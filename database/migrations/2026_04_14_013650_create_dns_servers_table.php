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
        Schema::create('dns_server', function (Blueprint $table) {
            $table->string('domain')->primary();
            $table->integer('domains_id');
            $table->integer('users_id')->nullable();
            $table->text('name_srv')->nullable();
            $table->string('status', 40)->nullable();
            $table->tinyInteger('dnssec')->nullable();
            $table->date('tgl_reg')->nullable();
            $table->date('tgl_exp')->nullable();
            $table->date('tgl_upd')->nullable();
            $table->string('dns_a', 40)->nullable();
            $table->string('website', 40)->nullable();
            $table->date('tgl_exp_domains')->nullable();
            $table->date('tgl_email')->nullable();
            $table->tinyInteger('jumlah_notif')->nullable()->default(0);
            $table->index('domains_id');
            $table->index('domain');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dns_server');
    }
};
