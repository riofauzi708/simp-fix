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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade'); // Relasi ke pegawai
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade'); // Relasi ke perusahaan
            $table->date('payment_date'); // Tanggal pembayaran gaji
            $table->decimal('amount', 12, 2); // Jumlah gaji yang dibayarkan
            $table->text('note')->nullable(); // Catatan tambahan untuk pembayaran gaji (misalnya potongan atau tunjangan)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
