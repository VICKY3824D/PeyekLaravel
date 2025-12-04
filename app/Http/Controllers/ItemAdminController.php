<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();
        return view('admin.item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
                $is_admin = auth()->check() && in_array(auth()->user()->nama, ['Eni Erawati', 'Vicky']);

        if (!$is_admin) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.item.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Cek Otorisasi
        $is_admin = auth()->check() && in_array(auth()->user()->nama, ['Eni Erawati', 'Vicky']);
        if (!$is_admin) {
            abort(403, 'Unauthorized action.');
        }

        // 2. Validasi Input
        $validated = $request->validate([
            'nama_peyek' => 'required|string|max:50',
            'topping'    => 'nullable|string|max:50',
            'hrg_kiloan' => 'required|integer|min:0',
            'gambar'     => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'deskripsi'  => 'nullable|string',
        ]);

        // 3. GENERATE ID OTOMATIS (Logika Custom)
        // Ambil nama, misal: "Peyek Bosok"
        $nama = trim($request->nama_peyek);
        $kata = explode(' ', $nama); // Pecah jadi array: ["Peyek", "Bosok"]

        if (count($kata) >= 2) {
            // Pola: Huruf pertama kata 1 + Huruf pertama kata 2 + Huruf terakhir kata 2
            // Contoh: P + b + k = pbk
            $huruf1 = substr($kata[0], 0, 1);       // P
            $huruf2 = substr($kata[1], 0, 1);       // b
            $huruf3 = substr($kata[1], -1);         // k

            $generatedId = strtolower($huruf1 . $huruf2 . $huruf3);
        } else {
            // Fallback jika nama cuma 1 kata (misal: "Peyek"), ambil 3 huruf pertama
            $generatedId = strtolower(substr($nama, 0, 3));
        }

        // Cek apakah ID sudah ada di database untuk mencegah error duplicate entry
        if (Item::where('id', $generatedId)->exists()) {
            // Opsi: Tambahkan angka acak atau return error
            // Disini kita return error agar admin mengganti nama peyeknya
            return back()->withInput()->withErrors(['nama_peyek' => 'ID Generated (' . $generatedId . ') sudah digunakan oleh produk lain.']);
        }

        // Masukkan ID ke array data yang akan disimpan
        $validated['id'] = $generatedId;


        // 4. Handle Upload Gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img_item_upload'), $filename);
            $validated['gambar'] = $filename;
        }

        // 5. Handle Checkbox
        $validated['is_available'] = $request->has('is_available') ? 1 : 0;

        // 6. Simpan Data
        // Pastikan 'id' ada di $fillable pada model Item
        Item::create($validated);

        return redirect()
            ->route('admin.index')
            ->with('success', 'Item berhasil ditambahkan dengan ID: ' . $generatedId);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
