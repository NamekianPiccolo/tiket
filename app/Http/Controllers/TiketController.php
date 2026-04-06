<?php
namespace App\Http\Controllers;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Tiket;
use App\Models\TiketCustomer;
use Illuminate\Http\Request;

class TiketController extends Controller{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');
        $provinces = Province::all();

        $query = Tiket::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('namaTiket', 'like', "%{$search}%")
                ->orWhere('lokawebsi', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%")
                ->orWhereHas('regency', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhereHas('province', function($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                });
            });
        }

        $query->orderBy('created_at', 'desc');
        $tikets = $query->paginate($perPage);

        return view('admin.tiket.index', compact('tikets', 'provinces'));
    }

    public function dashboard(Request $request){
        $search = $request->input('search');
        $provinces = Province::all();
        $query = Tiket::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('namaTiket', 'like', "%{$search}%")
                ->orWhere('lokawebsi', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%")
                ->orWhereHas('regency', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhereHas('province', function($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                });
            });
        }
        $query->orderBy('created_at', 'asc');
        $tikets = $query->get();

        return view('welcome', compact('tikets', 'provinces'));
    }

    public function detailtiket(Request $request){
        $tiket = Tiket::with(['regency.province'])->findOrFail($request->id);
        return view('detail_tiket', compact('tiket'));
    }

    public function show(Tiket $tiket){
        $tiket->load('regency.province');
        $provinces = Province::all();
        return view('admin.tiket.detailTiket', compact('tiket', 'provinces'));
    }

    public function store(Request $request){
        $request->validate([
            'namaTiket' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'lokawebsi' => 'required|string|max:255',
            'deskripsi' => 'string',
            'regencie_id' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpg,jpeg,png',
        ]);

        try {
            $data = $request->except('gambar');

            if ($request->hasFile('gambar')) {
                    $data['gambar'] = $request->file('gambar')->store('tikets', 'public');
                }

            $tiket = Tiket::create($data);

            if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Tiket berhasil ditambahkan',
                        'data' => $tiket
                    ], 201);
                }

        return redirect()->back()->with('success', 'Tiket berhasil ditambahkan!');

        }
        catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan tiket',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menambahkan tiket: ' . $e->getMessage());
        }
    }

    public function edit($id){
        $tiket = Tiket::with(['regency.province'])->findOrFail($id);
        $provinces = Province::all();

        return response()->json([
            'tiket' => $tiket,
            'province_id' => $tiket->regency->province_id,
        ]);
    }

    public function getRegencie($province_id){
        $regencies = Regency::where('province_id', $province_id)->get();
        return response()->json($regencies);
    }

    public function update(Request $request, $id){
        $tiket = Tiket::findOrFail($id);
        $request->validate([
            'namaTiket' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'lokawebsi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:5048',
            'regencie_id' => 'required|string|max:255',
        ]);

        try {
            $data = $request->except('gambar');

            if ($request->hasFile('gambar')) {
                if ($tiket->gambar && Storage::disk('public')->exists($tiket->gambar)) {
                    Storage::disk('public')->delete($tiket->gambar);
                }

                $data['gambar'] = $request->file('gambar')->store('tikets', 'public');
            }

            $tiket->update($data);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tiket berhasil diperbarui',
                    'data' => $tiket
                ]);
            }

            return redirect()->back()->with('success', 'Tiket berhasil diperbarui!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui tiket',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal memperbarui tiket: ' . $e->getMessage());
        }
    }

    public function destroy($id){
        try {
            $tiket = Tiket::findOrFail($id);

            if ($tiket->gambar && Storage::disk('public')->exists($tiket->gambar)) {
                Storage::disk('public')->delete($tiket->gambar);
            }

            $tiket->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tiket berhasil dihapus'
                ]);
            }

            return redirect()->route('tikets.index')->with('success', 'Tiket berhasil dihapus');
        }
        catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus tiket',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus tiket: ' . $e->getMessage());
        }
    }
    public function tiketCustomer(Request $request)
    {
        $user = auth()->user();
         $query = TiketCustomer::with('tiket')
            ->where('user_id', $user->id)
            ->latest();

        // Pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_tiket', 'like', "%$search%")
                  ->orWhere('nama', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhereHas('tiket', function($q) use ($search) {
                      $q->where('namaTiket', 'like', "%$search%");
                  });
            });
        }
        // Filter status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        // Pagination dengan 6 item per halaman
        $tiketCustomers = $query->paginate(4);
        // Jika request AJAX, kembalikan view partial
        if ($request->ajax()) {
            return view('partials.ticket_list', compact('tiketCustomers'))->render();
        }

        return view('customer.tiket_customer', compact('tiketCustomers'));
    }
    public function validasi(){
        return view('admin.validasi');
    }
      public function scan(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        $qrData = $request->input('qr_code');

        // Find the ticket by QR code
        $ticket = TiketCustomer::where('kode_tiket', $qrData)
            ->orWhere('qr_code', $qrData)
            ->first();

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket not found'
            ], 404);
        }
        // Check ticket status
        if ($ticket->status === 'digunakan') {
            return response()->json([
                'success' => false,
                'message' => 'Ticket has already been used'
            ]);
        }

        if ($ticket->status === 'kadaluarsa') {
            return response()->json([
                'success' => false,
                'message' => 'Ticket has expired'
            ]);
        }
        // If ticket is valid, mark it as used
        DB::beginTransaction();
        try {
            $ticket->update([
                'status' => 'digunakan',
                'updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Ticket successfully validated',
                'ticket' => [
                    'id' => $ticket->kode_tiket,
                    'event' => $ticket->tiket->namaTiket ?? 'N/A', // Assuming relationships are set up
                    'holder' => $ticket->kode_tiket,
                    'status' => 'Valid',
                    'scan_time' => now()
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error processing ticket: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verify(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        $qrData = $request->input('qr_code');

        $ticket = TiketCustomer::with(['tiket', 'user','transaksi'])
            ->where('kode_tiket', $qrData)
            ->orWhere('qr_code', $qrData)
            ->first();

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket not found'
            ], 404);
        }

        $statusMessage = '';
        if ($ticket->status === 'digunakan') {
            $statusMessage = 'Ticket has already been used';
        } elseif ($ticket->status === 'kadaluarsa') {
            $statusMessage = 'Ticket has expired';
        } else {
            $statusMessage = 'Ticket is valid';
        }

        return response()->json([
            'success' => true,
            'ticket' => [
                'id' => $ticket->kode_tiket,
                'event' => $ticket->tiket->namaTiket ?? 'N/A',
                'holder' => $ticket->kode_tiket,
                'status' => $ticket->status,
                'email' => $ticket->user->email,
                'purchase_date' => $ticket->tanggal_pembelian,
                'expiry_date' => $ticket->tanggal_expired,
                'status_message' => $statusMessage
            ]
        ]);
    }
}


