<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserType;
use App\Models\Scopes\AktifScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'type' => UserType::class,
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new AktifScope);
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function calonPesertaDidik(): BelongsTo
    {
        return $this->belongsTo(CalonPesertaDidik::class);
    }

    public function getIsAdminAttribute(): bool
    {
        return $this->type === UserType::ADMIN;
    }

    public function getIsPendaftarAttribute(): bool
    {
        return $this->type === UserType::PENDAFTAR;
    }

    public function getIsPengujiAttribute(): bool
    {
        return $this->type === UserType::PENGUJI;
    }

    public function getIsSurveyorAttribute(): bool
    {
        return $this->type === UserType::SURVEYOR;
    }

    public function getIsPanitiaAttribute(): bool
    {
        return $this->type === UserType::PANITIA;
    }

    public function pendaftaran(): HasManyThrough
    {
        return $this->hasManyThrough(Pendaftaran::class, CalonPesertaDidik::class);
    }

    public function resetPassword($newPassword)
    {
        $this->password = bcrypt($newPassword);
        $this->save();
    }
}
