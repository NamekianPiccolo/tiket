<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Tiket;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{

    public function index()
    {
        $keranjang = auth()->user()->keranjang()->with('tiket')->get();
        $total = $keranjang->sum(function ($item) {
            return $item->tiket->harga * $item->jumlah;
        });

        return view('customer.keranjang', compact('keranjang', 'total'));
    }

   public function store(Request $request)
{
    $request->validate([
        'tiket_id' => 'required|exists:tikets,id',
        'jumlah' => 'required|integer|min:1'
    ]);

    // Cek apakah tiket sudah ada di keranjang user
    $existingCart = Keranjang::where('user_id', auth()->id())
                            ->where('tiket_id', $request->tiket_id)
                            ->first();

    if ($existingCart) {
        // Update quantity jika sudah ada
        $existingCart->update([
            'jumlah' => $existingCart->jumlah + $request->jumlah
        ]);
    } else {
        // Tambahkan baru jika belum ada
        Keranjang::create([
            'user_id' => auth()->id(),
            'tiket_id' => $request->tiket_id,
            'jumlah' => $request->jumlah
        ]);
    }

    // Hitung total item di keranjang
    $cartCount = Keranjang::where('user_id', auth()->id())->count();

   return redirect()->route('keranjang.index')
           ->with('success', ' berhasil memasukkan keranjang');
}
public function update(Request $request, Keranjang $keranjang)
{
    $request->validate([
        'jumlah' => 'required|integer|min:1|max:' . $keranjang->tiket->stok,
    ]);

    try {
        $keranjang->update([
            'jumlah' => $request->jumlah,
        ]);

        // Hitung ulang total
        $subtotal = $keranjang->tiket->harga * $request->jumlah;

        $total = $subtotal;

        return response()->json([
            'success' => true,
            'message' => 'Jumlah berhasil diperbarui',
            'data' => [
                'subtotal' => number_format($subtotal, 0, ',', '.'),
                'total' => number_format($total, 0, ',', '.'),
                'jumlah' => $request->jumlah
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal memperbarui jumlah: ' . $e->getMessage()
        ], 500);
    }
}

    public function destroy(Keranjang $keranjang)
    {
        $keranjang->delete();
        return redirect()->route('keranjang.index')->with('success', 'Item berhasil dihapus dari keranjang');
    }
}
