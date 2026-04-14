<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email_alternative')->nullable()->default(null);
            $table->integer('count_verification')->nullable()->default(null);
            $table->tinyInteger('status')->default(1);
            $table->string('phone')->nullable()->default(null);
            $table->string('image')->nullable()->default(null);
            $table->string('doc_user_1')->nullable()->default(null);
            $table->string('id_contact_epp')->nullable()->default(null);
            $table->integer('province_id')->nullable()->default(null);
            $table->integer('city_id')->nullable()->default(null);
            $table->char('postal_code', 6)->nullable()->default(null);
            $table->text('name_organization')->nullable()->default(null);
            $table->text('address')->nullable()->default(null);
            $table->string('fax')->nullable()->default(null);
            $table->tinyInteger('is_migrasi')->nullable()->default(null);
            $table->tinyInteger('send_email')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
