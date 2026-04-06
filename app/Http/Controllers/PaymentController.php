<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Tiket;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\DetailTransaksi;
use App\Models\TiketCustomer;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        // Configure Midtrans for this specific request
        $this->configureMidtrans();

        $transaksi = Transaksi::with(['details', 'user'])->findOrFail($request->id);

        // Validasi metode pembayaran
        $request->validate([
            'metode_pembayaran' => 'required|in:transfer_bank,e_wallet,kartu_kredit'
        ]);

        // Jika status sudah dibayar, langsung redirect
        if ($transaksi->status_pembayaran == 'dibayar') {
             return redirect()->route('thankyou');
        }else if($transaksi->status_pembayaran == 'gagal') {
            $this->updateTicketStock($transaksi);
            return redirect()->route('payment.show')->with('error', 'Pembayaran gagal, silakan coba lagi.');
        }

        // Siapkan parameter untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $transaksi->kode_transaksi,
                'gross_amount' => $transaksi->total_harga,
            ],
            'customer_details' => [
                'first_name' => $transaksi->user->name,
                'email' => $transaksi->user->email,
            ],
            'item_details' => $this->prepareItemDetails($transaksi->details),
            'callbacks' => [
                'finish' => route('thankyou')
            ]
        ];

        // Tambahkan payment_type berdasarkan metode yang dipilih
        switch ($request->metode_pembayaran) {
            case 'transfer_bank':
                $params['bank_transfer'] = [
                    'bank' => 'bni' // Default bank, bisa disesuaikan
                ];
                break;
            case 'e_wallet':
                $params['payment_type'] = 'gopay'; // Default e-wallet
                break;
            case 'kartu_kredit':
                $params['payment_type'] = 'credit_card';
                break;
        }

        try {
            // Dapatkan Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);
          $transaksi->update([
            'metode_pembayaran' => $request->metode_pembayaran,
            'snap_token' => $snapToken,

        ]);

            return response()->json([
                'snapToken' => $snapToken
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Halaman setelah pembayaran berhasil
    public function createTiket(Request $request)
    {
         $transansi_id = $request->transaksi_id;
        $transaksi = Transaksi::with(['details', 'details.tiket'])->findOrFail($transansi_id); 

        // Buat detail transaksi
        $detailTransaksi = DetailTransaksi::where('transaksi_id', $transansi_id)
                                ->with(['transaksi'])
                                ->get();
        $user = auth()->user();
        if ($transaksi->status_pembayaran == 'menunggu') {
            $this->updateTicketStock($transaksi);
            return redirect()->route('payment.show');
        }
        // Buat tiket untuk pelanggan
        foreach($detailTransaksi as $item) {
    $tiket = Tiket::findOrFail($item->tiket_id);

    // Update tiket yang sudah expired
    TiketCustomer::where('id', $item->tiket_id)
        ->update([
            'status' => 'kadaluarsa',
            'updated_at' => now()
        ]);

    for ($i = 0; $i < $item->jumlah; $i++) {
        $kodeTiket = Str::uuid()->toString();

        // Generate QR Code dengan Simple QR Code
        $qrCode = QrCode::format('png') // Format PNG (default)
            ->size(300)                 // Ukuran 300x300 pixel
            ->errorCorrection('H')      // Level koreksi error tinggi
            ->margin(1)                 // Margin 1 unit
            ->color(40, 40, 40)         // Warna QR (RGB)
            ->backgroundColor(255, 255, 255) // Latar belakang putih
            ->generate($kodeTiket); // Data yang akan dimasukkan ke QR Code

        // Simpan QR Code ke storage
        $qrCodeNamePath = 'qrcodes/'.$kodeTiket.'.png';
        Storage::disk('public')->put($qrCodeNamePath, $qrCode);
        $qrCodeName = $kodeTiket;
        // Buat tiket baru
        TiketCustomer::create([
            'transaksi_id' => $transaksi->id,
            'tiket_id' => $tiket->id,
            'user_id' => $user->id,
            'nama' => $user->name,
            'email' => $user->email,
            'kode_tiket' => $kodeTiket,
            'qr_code' => $qrCodeName,
            'status' => 'aktif',
            'tanggal_expired' => now()->addDays(30),
        ]);
    }
}
        return redirect()->route('thankyou');
}

 public function thankyou(){
    return view('customer.payment.thankyou');
 }

    // Webhook untuk notifikasi dari Midtrans
    public function notificationHandler(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        $validSignatureKey = hash("sha512",
            $notification->order_id .
            $notification->status_code .
            $notification->gross_amount .
            config('services.midtrans.server_key'));

        if ($notification->signature_key != $validSignatureKey) {
            return response(['message' => 'Invalid signature'], 403);
        }

        $transaksi = Transaksi::where('kode_transaksi', $notification->order_id)->first();

        if (!$transaksi) {
            return response(['message' => 'Transaction not found'], 404);
        }

        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;

        // Handle status transaksi
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $transaksi->status_pembayaran = 'menunggu';
            } else if ($fraudStatus == 'accept') {
                $transaksi->status_pembayaran = 'dibayar';
            }
        } else if ($transactionStatus == 'settlement') {
            $transaksi->status_pembayaran = 'dibayar';

        } else if ($transactionStatus == 'pending') {
            $transaksi->status_pembayaran = 'menunggu';
        } else if ($transactionStatus == 'deny' ||
                 $transactionStatus == 'expire' ||
                 $transactionStatus == 'cancel') {
            $transaksi->status_pembayaran = 'gagal';

        }else {
            $transaksi->status_pembayaran = 'gagal';
        }

        $transaksi->save();

        return response(['message' => 'Notification handled']);
    }

    // Helper: Configure Midtrans settings
    private function configureMidtrans()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    // Helper: Siapkan detail item untuk Midtrans
    private function prepareItemDetails($details)
    {
        $items = [];

        foreach ($details as $detail) {
            $items[] = [
                'id' => $detail->tiket_id,
                'price' => $detail->harga_satuan,
                'quantity' => $detail->jumlah,
                'name' => $detail->tiket->namaTiket
            ];
        }

        return $items;
    }


    // Helper: Update stok tiket setelah pembayaran berhasil
    private function updateTicketStock($transaksi)
    {
        if($transaksi->status_pembayaran = 'gagal') {
            foreach ($transaksi->details as $detail) {
                $tiket = Tiket::find($detail->tiket_id);
                if ($tiket) {
                    $tiket->stok += $detail->jumlah;
                    $tiket->save();
                }
            }
        }
    }
}
