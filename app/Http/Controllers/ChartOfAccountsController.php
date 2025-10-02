<?php

namespace App\Http\Controllers;

use App\Models\chart_of_accounts;
use App\Models\kategori_coas;
use Illuminate\Http\Request;

class ChartOfAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua COA beserta kategori-nya
        $coa = chart_of_accounts::with('kategori')->get();
        $kategori = kategori_coas::all();

        return view('admin.masterdata.coa', compact('coa', 'kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:chart_of_accounts,kode',
            'nama' => 'required|string|max:255',
            'kategori_coa_id' => 'required|exists:kategori_coas,id',
        ]);

        chart_of_accounts::create($request->all());

        return redirect()->route('coa.index')->with('success', 'Chart of Account berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, chart_of_accounts $coa)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:chart_of_accounts,kode,' . $coa->id,
            'nama' => 'required|string|max:255',
            'kategori_coa_id' => 'required|exists:kategori_coas,id',
        ]);

        $coa->update($request->all());

        return redirect()->route('coa.index')->with('success', 'Chart of Account berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(chart_of_accounts $coa)
    {
        $coa->delete();

        return redirect()->route('coa.index')->with('success', 'Chart of Account berhasil dihapus.');
    }
}
