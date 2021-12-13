<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserDiceTron extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'balance',
        'reff',
        'bonus',
        'wager',
    ];

    /**
     * Get the wallet associated with the UserDiceTron
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wallet()
    {
        return $this->hasOne(UserWallet::class, 'id_akun', 'id');
    }

    /**
     * Get all of the logGame for the UserDiceTron
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logGame()
    {
        return $this->hasMany(LogGame::class, 'id_akun', 'id');
    }

    /**
     * Get the history associated with the UserDiceTron
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function history()
    {
        return $this->hasOne(History::class, 'id_akun', 'id');
    }

    /**
     * Get all of the deposit for the UserDiceTron
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deposit()
    {
        return $this->hasMany(Deposit::class, 'id_akun', 'id');
    }

    /**
     * Get all of the wd for the UserDiceTron
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wd()
    {
        return $this->hasMany(Withdraw::class, 'id_akun', 'id');
    }
}
