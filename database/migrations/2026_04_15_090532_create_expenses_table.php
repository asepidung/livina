<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            // Menghubungkan ke tabel categories
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('keterangan')->nullable();
            $table->integer('odo'); // Odometer
            $table->decimal('biaya', 12, 2); // Nominal biaya
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
