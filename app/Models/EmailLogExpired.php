<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

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
    use LogsActivity;

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

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class, 'domain', 'name');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }
}
