<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class Dashboardcontroller extends Controller
{
    //
     public function index()
    {
        // Ambil total debit & credit per kategori
        $report = Transaksi::selectRaw('kategori_coas.nama as kategori, SUM(transaksis.debit) as total_debit, SUM(transaksis.credit) as total_credit')
            ->join('chart_of_accounts', 'transaksis.coa_id', '=', 'chart_of_accounts.id')
            ->join('kategori_coas', 'chart_of_accounts.kategori_coa_id', '=', 'kategori_coas.id')
            ->groupBy('kategori_coas.nama')
            ->get();

        // Hitung total profit/loss
        $totalDebit = $report->sum('total_debit');
        $totalCredit = $report->sum('total_credit');
        $profit = $totalCredit - $totalDebit;

        return view('dashboard', compact('report', 'totalDebit', 'totalCredit', 'profit'));
    }
}
