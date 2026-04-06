<?php
namespace App\Http\Controllers;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Keranjang;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Crypt;

class TransaksiController extends Controller{
    public function index(){
        $user = Auth::user();
        $transaksis = Transaksi::with('details.tiket')
                            ->where('user_id', $user->id)
                            ->orderBy('created_at', 'desc')
                            ->get();
        return  view('customer.transaksi', compact('transaksis'));
    }
    public function checkout(Request $request)
    {
        $request->validate([
            'total_harga' => 'required|numeric' // This comes from your hidden input
        ]);
        $user = Auth::user();
        $keranjangItems = Keranjang::with('tiket')->where('user_id', $user->id)->get();
        if ($keranjangItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang belanja kosong'
            ], 400);
        }
        $subtotal = $keranjangItems->sum(function($item) {
            return $item->jumlah * $item->tiket->harga;
            });
        $totalHarga = $subtotal ;

        if ($totalHarga != $request->total_harga) {
            return response()->json([
                'success' => false,
                'message' => 'Total harga tidak valid'
            ], 400);
        }

        $transaksi = Transaksi::create([
            'kode_transaksi' => 'TRX-' . Str::upper(Str::random(10)),
            'user_id' => $user->id,
            'subtotal' => $subtotal,
            'total_harga' => $totalHarga,
            'status_pembayaran' => 'menunggu',
            'metode_pembayaran' => $request->payment_method, // Field name matches form
        ]);

        foreach ($keranjangItems as $item) {
            $tiket = Tiket::findOrFail($item->tiket_id);
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'tiket_id' => $item->tiket_id,
                'jumlah' => $item->jumlah,
                'harga_satuan' => $item->tiket->harga,
                'subtotal' => $item->jumlah * $item->tiket->harga,
            ]);
            $tiket->decrement('stok', $item->jumlah);
        }

        Keranjang::where('user_id', $user->id)->delete();
        session(['current_transaction_id' => $transaksi->id]);

        return redirect()->route('payment.show')->with('success', 'Checkout berhasil!');
    }

    public function checkout_langsung(Request $request){
        $request->validate([
            'tiket_id' => 'required|exists:tikets,id',
            'jumlah' => 'required|integer|min:1'
        ]);

        // Dapatkan data tiket
        $tiket = Tiket::findOrFail($request->tiket_id);

        // Validasi stok
        if ($tiket->stok < $request->jumlah) {
            return back()->with('error', 'Stok tiket tidak mencukupi');
        }

        $kodeTransaksi = 'TRX-' . Str::upper(Str::random(8)) . now()->format('Ymd');

        $transaksi = Transaksi::create([
            'kode_transaksi' => $kodeTransaksi,
            'user_id' => auth()->id(),
            'total_harga' => $tiket->harga * $request->jumlah,
            'status_pembayaran' => 'menunggu',
            'metode_pembayaran' => null,
            'catatan' => null
        ]);

        DetailTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'tiket_id' => $tiket->id,
            'jumlah' => $request->jumlah,
            'harga_satuan' => $tiket->harga,
            'subtotal' => $tiket->harga * $request->jumlah
        ]);

        $tiket->decrement('stok', $request->jumlah);

        // Simpan ID transaksi di session
        session(['current_transaction_id' => $transaksi->id]);

        return redirect()->route('payment.show')->with('success', 'Checkout berhasil!');
    }

    public function show(){
        $transaksiId = session('current_transaction_id');

        if (!$transaksiId) {
            abort(404, 'Transaksi tidak ditemukan');
        }else{
            $transaksi = Transaksi::with(['details', 'details.tiket', 'user'])
                ->where('id', $transaksiId)
                ->firstOrFail();
                if($transaksi->status_pembayaran == 'gagal') {
                    foreach ($transaksi->details as $detail) {
                        $tiket = Tiket::findOrFail($detail->tiket_id);
                        $tiket->increment('stok', $detail->jumlah);
                    }
                return view('customer.payment.gagal', compact('transaksi'));
                }
            return view('customer.payment.paymentShow', compact('transaksi'));
        }
    }
    public function bayar(Request $request)
    {
        $transaksi = Transaksi::findOrFail($request->id);
        // Validasi input
        $request->validate([
            'id' => 'required',
        ]);
        session(['current_transaction_id' => $transaksi->id]);
        return redirect()->route('payment.show');
    }
}
