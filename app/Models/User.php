<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Permission\Traits\HasRoles;

#[Fillable([
    'name',
    'email',
    'email_alternative',
    'count_verification',
    'status',
    'phone',
    'image',
    'doc_user_1',
    'id_contact_epp',
    'province_id',
    'city_id',
    'postal_code',
    'name_organization',
    'address',
    'fax',
    'is_migrasi',
    'send_email',
    'password',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, LogsActivity, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'count_verification' => 'integer',
            'status' => 'integer',
            'province_id' => 'integer',
            'city_id' => 'integer',
            'is_migrasi' => 'integer',
            'send_email' => 'integer',
            'password' => 'hashed',
        ];
    }

    public function dnsServers(): HasMany
    {
        return $this->hasMany(DnsServer::class, 'users_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

    public function initials(): string
    {
        return Str::initials($this->name, true);
    }
}
