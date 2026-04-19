<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('zone');
            $table->dateTime('registered_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->text('note')->nullable();
            $table->json('domain_name_server')->nullable();
            $table->json('ns_country')->nullable();
            $table->timestamps();
            $table->string('doc_domain_1')->nullable();
            $table->string('doc_domain_2')->nullable();
            $table->string('doc_domain_3')->nullable();
            $table->string('doc_domain_4')->nullable();
            $table->string('doc_domain_5')->nullable();
            $table->string('fax')->nullable();
            $table->text('name_organization')->nullable();
            $table->integer('klasifikasi_instansi_id')->nullable();
            $table->string('nama_instansi')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code', 100)->nullable();
            $table->enum('status', [
                'error', 'draft', 'verifikasi dokumen', 'pending payment',
                'verifikasi pembayaran', 'active', 'suspend', 'cancelled', 'reject',
            ])->default('draft');
            $table->enum('status_stage', [
                'information-instansi', 'information-domain', 'document-domain', 'preview',
            ])->default('information-instansi');
            $table->integer('province_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->string('village_id', 10)->nullable();
            $table->integer('registrant_id')->nullable();
            $table->string('phone')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('approved_by_id')->nullable();
            $table->integer('canceled_by_id')->nullable();
            $table->string('description_domain')->nullable();
            $table->integer('approved_payment_by_id')->nullable();
            $table->enum('type_domain', ['registration', 'renewal', 'transfer'])->default('registration');
            $table->date('renewal_date')->nullable();
            $table->date('active_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->tinyInteger('duration')->nullable();
            $table->string('d_registrant_type', 100)->nullable();
            $table->integer('ammount')->nullable();
            $table->string('d_status', 5)->nullable();
            $table->string('d_xname')->nullable();
            $table->string('u_organization_type', 100)->nullable();
            $table->string('u_organization_name')->nullable();
            $table->string('u_state', 50)->nullable();
            $table->string('u_city', 50)->nullable();
            $table->text('u_street2')->nullable();
            $table->text('u_street3')->nullable();
            $table->softDeletes();
            $table->integer('deleted_by_id')->nullable();
            $table->timestamp('processed_update_ns_at')->nullable();

            $table->index(['name', 'zone']);
            $table->index('status');
            $table->index('registrant_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
