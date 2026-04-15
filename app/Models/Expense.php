<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'tanggal',
        'category_id',
        'keterangan',
        'odo',
        'biaya',
    ];

    // Relasi: Menghubungkan pengeluaran kembali ke kategorinya
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
