<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    /** @use HasFactory<\Database\Factories\TransaksisFactory> */
    use HasFactory;

    protected $table = 'transaksis'; 
    protected $fillable = [
        'coa_id',
        'tanggal',
        'deskripsi',
        'debit',
        'credit'
    ];

    public function chartOfAccount()
    {
        return $this->belongsTo(chart_of_accounts::class, 'coa_id');
    }
}
