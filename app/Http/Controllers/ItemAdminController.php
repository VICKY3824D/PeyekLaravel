<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class ItemAdminController extends Controller
{

    public function index()
    {
        $is_admin = auth()->check() && in_array(auth()->user()->nama, ['Eni Erawati', 'Vicky']);
        $items = Item::all();
        if(!$is_admin){
            abort(403, 'Unauthorized action.');
        }
        return view('admin.item.index', compact('items', 'is_admin'));
    }


    public function create()
    {
        $is_admin = auth()->check() && in_array(auth()->user()->nama, ['Eni Erawati', 'Vicky']);

        if (!$is_admin) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.item.create');
    }


    public function store(Request $request)
    {
        $is_admin = auth()->check() && in_array(auth()->user()->nama, ['Eni Erawati', 'Vicky']);

        if (!$is_admin) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi input
        $validated = $request->validate([
            'nama_peyek' => 'required|string|max:50',
            'topping' => 'nullable|string|max:50',
            'hrg_kiloan' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'deskripsi' => 'nullable|string',
            'is_available' => 'nullable|boolean',
        ], [
            'nama_peyek.required' => 'Nama peyek harus diisi',
            'nama_peyek.max' => 'Nama peyek maksimal 50 karakter',
            'hrg_kiloan.required' => 'Harga harus diisi',
            'hrg_kiloan.integer' => 'Harga harus berupa angka',
            'hrg_kiloan.min' => 'Harga tidak boleh negatif',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Handle upload gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img_item_upload'), $filename);
            $validated['gambar'] = $filename;
        }

        // Handle checkbox is_available (jika tidak dicentang, set false)
        $validated['is_available'] = $request->has('is_available') ? true : false;

        // Generate ID dari nama_peyek
        $generatedId = $this->generateItemId($validated['nama_peyek']);

        // Cek jika ID sudah ada, tambahkan suffix angka
        $itemId = $generatedId;
        $counter = 1;
        while (Item::where('id', $itemId)->exists()) {
            $itemId = $generatedId . $counter;
            $counter++;
        }

        $validated['id'] = $itemId;

        // Create item
        $item = Item::create($validated);

        return redirect()
            ->route('admin.show', $item->id)
            ->with('success', 'Item berhasil ditambahkan!');
    }

    /**
     * Generate item ID from nama_peyek
     * Example: "peyek kacang" -> "pkg", "peyek rebon" -> "prn"
     */
    private function generateItemId(string $namaPeyek): string
    {
        // Ubah ke lowercase dan split by space
        $words = explode(' ', strtolower(trim($namaPeyek)));

        // Ambil huruf pertama dari setiap kata
        $id = '';
        foreach ($words as $index => $word) {
            if (!empty($word)) {
                $id .= substr($word, 0, 1);
            }
        }

        // Tambahkan huruf terakhir dari kata terakhir
        $lastWord = end($words);
        if (!empty($lastWord) && strlen($lastWord) > 1) {
            $id .= substr($lastWord, -1);
        }

        return $id;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Item::findOrFail($id);
        $is_admin = auth()->check() && in_array(auth()->user()->nama, ['Eni Erawati', 'Vicky']);

        return view('admin.item.show', compact('item', 'is_admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $is_admin = auth()->check() && in_array(auth()->user()->nama, ['Eni Erawati', 'Vicky']);

        if (!$is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $item = Item::findOrFail($id);

        return view('admin.item.edit', compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $is_admin = auth()->check() && in_array(auth()->user()->nama, ['Eni Erawati', 'Vicky']);

        if (!$is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $item = Item::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'nama_peyek' => 'required|string|max:50',
            'topping' => 'nullable|string|max:50',
            'hrg_kiloan' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'deskripsi' => 'nullable|string',
            'is_available' => 'nullable|boolean',
        ], [
            'nama_peyek.required' => 'Nama peyek harus diisi',
            'nama_peyek.max' => 'Nama peyek maksimal 50 karakter',
            'hrg_kiloan.required' => 'Harga harus diisi',
            'hrg_kiloan.integer' => 'Harga harus berupa angka',
            'hrg_kiloan.min' => 'Harga tidak boleh negatif',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Handle upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($item->gambar && file_exists(public_path('img_item_upload/' . $item->gambar))) {
                unlink(public_path('img_item_upload/' . $item->gambar));
            }

            // Upload gambar baru
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img_item_upload'), $filename);
            $validated['gambar'] = $filename;
        }

        // Handle checkbox is_available (jika tidak dicentang, set false)
        $validated['is_available'] = $request->has('is_available') ? true : false;

        // Update item
        $item->update($validated);

        return redirect()
            ->route('admin.show', $item->id)
            ->with('success', 'Item berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $is_admin = auth()->check() && in_array(auth()->user()->nama, ['Eni Erawati', 'Vicky']);

        if (!$is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $item = Item::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($item->gambar && file_exists(public_path('img_item_upload/' . $item->gambar))) {
            unlink(public_path('img_item_upload/' . $item->gambar));
        }

        // Soft delete item
        $item->delete();

        return redirect()
            ->route('admin.index')
            ->with('success', 'Item berhasil dihapus!');
    }
}
