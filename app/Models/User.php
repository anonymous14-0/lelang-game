<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Item;
use App\Models\Bid;
// Model user aplikasi dengan role admin, penjual, dan pembeli.
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // Kolom user yang boleh diisi melalui registrasi atau seeder.
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    // Kolom sensitif yang disembunyikan saat model diserialisasi.
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // Mengatur casting otomatis untuk verifikasi email dan password.
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // Relasi user penjual dengan item yang dimiliki.
    public function items()
        {
            return $this->hasMany(Item::class);
        }

        // Relasi user pembeli dengan bid yang pernah dibuat.
        public function bids()
        {
            return $this->hasMany(Bid::class);
        }
}
