<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'email_log_id',
    'domain',
    'tanggal',
    'email',
    'tgl_exp',
    'selisih',
    'sel_tahun',
    'status',
])]
class EmailLogExpired extends Model
{
    protected $table = 'email_log_expired';

    protected $primaryKey = 'email_log_id';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'email_log_id' => 'integer',
            'tanggal' => 'datetime',
            'tgl_exp' => 'date',
            'selisih' => 'integer',
            'sel_tahun' => 'integer',
        ];
    }

    public function dnsServer(): BelongsTo
    {
        return $this->belongsTo(DnsServer::class, 'domain', 'domain');
    }
}
