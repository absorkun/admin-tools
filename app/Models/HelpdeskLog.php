<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

#[Fillable([
    'domain',
    'pelapor_nama',
    'pelapor_email',
    'pelapor_phone',
    'jenis_layanan',
    'kanal',
    'deskripsi',
    'status',
    'catatan_tambahan',
    'users_id',
])]
class HelpdeskLog extends Model
{
    use LogsActivity;

    protected $table = 'helpdesk_log';

    protected $primaryKey = 'helpdesk_log_id';

    const STATUS_DIPROSES = 'Diproses';

    const STATUS_SELESAI = 'Selesai';

    const STATUSES = [self::STATUS_DIPROSES, self::STATUS_SELESAI];

    const KANAL = [
        'Whatsapp',
        'Email',
        'Aplikasi Domain',
        'Aplikasi Layanan Bantuan',
    ];

    const JENIS_LAYANAN = [
        'Pendaftaran Nama Domain',
        'Permintaan Reset Password',
        'Informasi',
        'Insiden',
        'Perpanjangan Nama Domain',
        'Pembaharuan Nameserver',
    ];

    protected function casts(): array
    {
        return [
            'helpdesk_log_id' => 'integer',
            'users_id' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function dnsServer(): BelongsTo
    {
        return $this->belongsTo(DnsServer::class, 'domain', 'domain');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }
}
