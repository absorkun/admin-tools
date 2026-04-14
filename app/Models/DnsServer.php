<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

#[Fillable([
    'domain',
    'domains_id',
    'users_id',
    'name_srv',
    'status',
    'dnssec',
    'tgl_reg',
    'tgl_exp',
    'tgl_upd',
    'dns_a',
    'website',
    'tgl_exp_domains',
    'tgl_email',
    'jumlah_notif',
])]
class DnsServer extends Model
{
    use LogsActivity;

    protected $table = 'dns_server';

    protected $primaryKey = 'domain';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'domain' => 'string',
            'domains_id' => 'integer',
            'users_id' => 'integer',
            'dnssec' => 'integer',
            'tgl_reg' => 'date',
            'tgl_exp' => 'date',
            'tgl_upd' => 'date',
            'tgl_exp_domains' => 'date',
            'tgl_email' => 'date',
            'jumlah_notif' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function emailLogExpireds(): HasMany
    {
        return $this->hasMany(EmailLogExpired::class, 'domain', 'domain');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }
}
