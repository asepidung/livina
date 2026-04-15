<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    // Kolom yang boleh diisi
    protected $fillable = ['name'];

    // Relasi: Satu kategori punya banyak catatan pengeluaran
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
