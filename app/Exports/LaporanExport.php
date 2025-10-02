<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanExport implements FromView
{
    protected $pivot;
    protected $months;
    protected $totals;
    protected $incomeCats;
    protected $expenseCats;

    public function __construct($pivot, $months, $totals, $incomeCats, $expenseCats)
    {
        $this->pivot = $pivot;
        $this->months = $months;
        $this->totals = $totals;
        $this->incomeCats = $incomeCats;
        $this->expenseCats = $expenseCats;
    }

    public function view(): View
    {
        return view('admin.exports.laporan', [
            'pivot' => $this->pivot,
            'months' => $this->months,
            'totals' => $this->totals,
            'incomeCats' => $this->incomeCats,
            'expenseCats' => $this->expenseCats,
        ]);
    }
}
