<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

#[Fillable([
    'name',
    'zone',
    'registered_at',
    'expires_at',
    'note',
    'domain_name_server',
    'ns_country',
    'status',
    'registrant_id',
    'phone',
    'product_id',
    'type_domain',
    'renewal_date',
    'active_date',
    'expired_date',
    'duration',
    'name_organization',
    'nama_instansi',
    'address',
    'postal_code',
    'province_id',
    'city_id',
    'district_id',
    'village_id',
])]
class Domain extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'domains';

    protected function casts(): array
    {
        return [
            'registered_at' => 'datetime',
            'expires_at' => 'datetime',
            'domain_name_server' => 'array',
            'ns_country' => 'array',
            'renewal_date' => 'date',
            'active_date' => 'date',
            'expired_date' => 'date',
            'duration' => 'integer',
            'registrant_id' => 'integer',
            'product_id' => 'integer',
            'province_id' => 'integer',
            'city_id' => 'integer',
            'district_id' => 'integer',
            'approved_by_id' => 'integer',
            'canceled_by_id' => 'integer',
            'ammount' => 'integer',
        ];
    }

    public function registrant(): BelongsTo
    {
        return $this->belongsTo(Registrant::class, 'registrant_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class, 'village_id');
    }

    public function helpdeskLogs(): HasMany
    {
        return $this->hasMany(HelpdeskLog::class, 'domain', 'name');
    }

    public function emailLogExpireds(): HasMany
    {
        return $this->hasMany(EmailLogExpired::class, 'domain', 'name');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }
}
