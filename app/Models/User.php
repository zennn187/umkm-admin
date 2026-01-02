<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'alamat',
        'is_active',
        // Tambahkan field lain jika ada
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope untuk user aktif
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk user berdasarkan role
     */
    public function scopeByRole(Builder $query, string $role): Builder
    {
        return $query->where('role', $role);
    }

    /**
     * Scope untuk user dengan role admin atau super admin
     */
    public function scopeAdmins(Builder $query): Builder
    {
        return $query->whereIn('role', ['admin', 'super_admin']);
    }

    /**
     * Cek apakah user adalah super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Cek apakah user adalah admin (bukan super admin)
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah mitra
     */
    public function isMitra(): bool
    {
        return $this->role === 'mitra';
    }

    /**
     * Cek apakah user adalah pelanggan biasa
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Cek apakah user memiliki role tertentu
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Cek apakah user memiliki salah satu dari roles yang diberikan
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    /**
     * Cek apakah user dapat mengakses admin panel
     */
    public function canAccessAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'admin']);
    }

    /**
     * Dapatkan label role yang user-friendly
     */
    public function getRoleLabelAttribute(): string
    {
        $labels = [
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'mitra' => 'Mitra UMKM',
            'user' => 'Pelanggan',
        ];

        return $labels[$this->role] ?? ucfirst($this->role);
    }

    /**
     * Dapatkan inisial nama untuk avatar
     */
    public function getInitialsAttribute(): string
    {
        $names = explode(' ', $this->name);
        $initials = '';

        foreach ($names as $name) {
            $initials .= strtoupper(substr($name, 0, 1));
            if (strlen($initials) >= 2) break;
        }

        return $initials ?: strtoupper(substr($this->name, 0, 1));
    }

    /**
     * Cek apakah user dapat login
     */
    public function canLogin(): bool
    {
        return $this->is_active;
    }

    /**
     * Nonaktifkan user
     */
    public function deactivate(): bool
    {
        return $this->update(['is_active' => false]);
    }

    /**
     * Aktifkan user
     */
    public function activate(): bool
    {
        return $this->update(['is_active' => true]);
    }

    /**
     * Toggle status aktif user
     */
    public function toggleStatus(): bool
    {
        return $this->update(['is_active' => !$this->is_active]);
    }

    /**
     * Relation dengan UMKM (jika ada tabel UMKM)
     */
    public function umkms(): HasMany
    {
        return $this->hasMany(Umkm::class);
    }

    /**
     * Relation dengan produk (jika ada tabel produk)
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Relation dengan pesanan (jika ada tabel pesanan)
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Cek apakah user memiliki UMKM
     */
    public function hasUmkm(): bool
    {
        return $this->umkms()->exists();
    }

    /**
     * Dapatkan UMKM pertama user (untuk mitra)
     */
    public function getFirstUmkmAttribute()
    {
        return $this->umkms()->first();
    }

    /**
     * Boot method untuk model
     */
    protected static function boot()
    {
        parent::boot();

        // Set default role jika tidak diisi
        static::creating(function ($user) {
            if (empty($user->role)) {
                $user->role = 'user';
            }
            if (!isset($user->is_active)) {
                $user->is_active = true;
            }
        });
    }
}
