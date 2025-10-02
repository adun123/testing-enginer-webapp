<?php

namespace App\Http\Controllers;

use App\Models\transaksis;
use App\Models\chart_of_accounts;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksisController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('chartOfAccount')->get();
        $coa = chart_of_accounts::all();

        return view('admin.transaksi', compact('transaksi', 'coa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'coa_id' => 'required|exists:chart_of_accounts,id',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'debit' => 'nullable|numeric|min:0',
            'credit' => 'nullable|numeric|min:0',
        ]);

        Transaksi::create($request->all());

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'coa_id' => 'required|exists:chart_of_accounts,id',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'debit' => 'nullable|numeric|min:0',
            'credit' => 'nullable|numeric|min:0',
        ]);

        $transaksi->update($request->all());

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
