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
        Schema::table('helpdesk_log', function (Blueprint $table) {
            // Ganti kolom pelapor jadi 3 field terpisah
            $table->dropColumn('pelapor');
        });

        Schema::table('helpdesk_log', function (Blueprint $table) {
            $table->string('pelapor_nama')->after('domain');
            $table->string('pelapor_email')->after('pelapor_nama');
            $table->string('pelapor_phone')->nullable()->after('pelapor_email');

            // Domain wajib isi dan harus terdaftar
            $table->string('domain')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('helpdesk_log', function (Blueprint $table) {
            $table->dropColumn(['pelapor_nama', 'pelapor_email', 'pelapor_phone']);
            $table->string('pelapor')->after('domain');
            $table->string('domain')->nullable()->change();
        });
    }
};
