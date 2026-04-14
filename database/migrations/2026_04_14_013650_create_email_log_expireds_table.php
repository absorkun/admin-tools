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
        Schema::create('email_log_expired', function (Blueprint $table) {
            $table->increments('email_log_id');
            $table->string('domain');
            $table->dateTime('tanggal');
            $table->string('email');
            $table->date('tgl_exp');
            $table->integer('selisih')->nullable();
            $table->tinyInteger('sel_tahun')->nullable();
            $table->string('status', 80)->nullable();
            $table->index('domain');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_log_expired');
    }
};
