<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Rename columns (skip if already renamed)
        if (Schema::hasColumn('helpdesk_log', 'sumber')) {
            Schema::table('helpdesk_log', function (Blueprint $table) {
                $table->renameColumn('sumber', 'kanal');
                $table->renameColumn('isi_laporan', 'deskripsi');
                $table->renameColumn('catatan_admin', 'catatan_tambahan');
            });
        }

        // Backfill NULLs before making NOT NULL
        DB::table('helpdesk_log')
            ->whereNull('pelapor_phone')
            ->update(['pelapor_phone' => '-']);

        Schema::table('helpdesk_log', function (Blueprint $table) {
            $table->string('kanal', 50)->change();
            $table->string('pelapor_email')->nullable()->change();
            $table->string('pelapor_phone')->nullable(false)->change();

            if (! Schema::hasColumn('helpdesk_log', 'jenis_layanan')) {
                $table->string('jenis_layanan')->after('pelapor_phone');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('helpdesk_log', function (Blueprint $table) {
            $table->dropColumn('jenis_layanan');
            $table->string('pelapor_email')->nullable(false)->change();
            $table->string('pelapor_phone')->nullable()->change();
        });

        Schema::table('helpdesk_log', function (Blueprint $table) {
            $table->renameColumn('kanal', 'sumber');
            $table->renameColumn('deskripsi', 'isi_laporan');
            $table->renameColumn('catatan_tambahan', 'catatan_admin');
        });
    }
};
