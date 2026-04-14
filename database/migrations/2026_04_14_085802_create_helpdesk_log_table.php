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
        Schema::create('helpdesk_log', function (Blueprint $table) {
            $table->id('helpdesk_log_id');
            $table->string('domain')->nullable();
            $table->string('pelapor');
            $table->string('sumber', 50);
            $table->text('isi_laporan');
            $table->enum('status', ['Draft', 'Diproses', 'Selesai'])->default('Diproses');
            $table->text('catatan_admin')->nullable();
            $table->unsignedBigInteger('users_id');
            $table->timestamps();

            $table->index('domain');
            $table->index('status');
            $table->index('created_at');
            $table->foreign('users_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('helpdesk_log');
    }
};
