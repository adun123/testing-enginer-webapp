<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chart_of_accounts extends Model
{
    /** @use HasFactory<\Database\Factories\ChartOfAccountsFactory> */
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'kategori_coa_id'
    ];

    public function kategori()
    {
        return $this->belongsTo(kategori_coas::class, 'kategori_coa_id');
    } 


    public function transaksis()
    {
        return $this->hasMany(transaksi::class, 'coa_id');
    }
}
