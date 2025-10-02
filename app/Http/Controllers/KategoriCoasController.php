<?php

namespace App\Http\Controllers;

use App\Models\kategori_coas;
use Illuminate\Http\Request;

class KategoriCoasController extends Controller
{
    
    public function index()
    {
        $kategori = kategori_coas::orderBy('id', 'desc')->get();
        return view('admin.masterdata.kategori', compact('kategori'));
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255'
        ]);

        kategori_coas::create([
            'nama' => $request->nama
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }


    public function update(Request $request, kategori_coas $kategori)
    {
        $request->validate([
            'nama' => 'required|string|max:255'
        ]);

        $kategori->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    
    public function destroy(kategori_coas $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
