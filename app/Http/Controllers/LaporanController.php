<?php

namespace App\Http\Controllers;

use App\Models\transaksis;
use App\Models\kategori_coas;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
class LaporanController extends Controller
{
public function export()
{
    // panggil index untuk dapatkan data
    $data = $this->indexData();

    return Excel::download(
        new LaporanExport(
            $data['pivot'], 
            $data['months'], 
            $data['totals'], 
            $data['incomeCats'], 
            $data['expenseCats']
        ), 
        'laporan.xlsx'
    );
}

// pisahkan logika data biar reusable
private function indexData()
{
    $report = transaksi::selectRaw("
            kategori_coas.nama as kategori,
            DATE_FORMAT(transaksis.tanggal, '%Y-%m') as periode,
            SUM(transaksis.debit) as total_debit,
            SUM(transaksis.credit) as total_credit
        ")
        ->join('chart_of_accounts', 'transaksis.coa_id', '=', 'chart_of_accounts.id')
        ->join('kategori_coas', 'chart_of_accounts.kategori_coa_id', '=', 'kategori_coas.id')
        ->groupBy('kategori_coas.nama', 'periode')
        ->orderBy('periode')
        ->get();

    $categories = $report->pluck('kategori')->unique();
    $months = $report->pluck('periode')->unique()->sort();

    $pivot = [];
    foreach ($categories as $cat) {
        foreach ($months as $month) {
            $data = $report->firstWhere(fn($r) => $r->kategori == $cat && $r->periode == $month);
            $pivot[$cat][$month] = $data ? ($data->total_credit - $data->total_debit) : 0;
        }
    }

    $incomeCats = ['Salary', 'Other Income'];
    $expenseCats = ['Family Expense', 'Transport Expense', 'Meal Expense'];

    $totals = [];
    foreach ($months as $month) {
        $totals['income'][$month] = collect($incomeCats)->sum(fn($c) => $pivot[$c][$month] ?? 0);
        $totals['expense'][$month] = collect($expenseCats)->sum(fn($c) => $pivot[$c][$month] ?? 0);
        $totals['net'][$month] = $totals['income'][$month] - $totals['expense'][$month];
    }

    return compact('pivot', 'categories', 'months', 'totals', 'incomeCats', 'expenseCats');
}

public function index()
{
    $data = $this->indexData();
    return view('admin.laporan', $data);
}
}
