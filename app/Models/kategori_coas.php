<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori_coas extends Model
{
    /** @use HasFactory<\Database\Factories\KategoriCoasFactory> */
    use HasFactory;

    protected $fillable = [
        'nama'
    ];


    public function chartofaccounts()
    {
        return $this->hasMany(chart_of_accounts::class, 'kategori_coa_id');
    }
}
