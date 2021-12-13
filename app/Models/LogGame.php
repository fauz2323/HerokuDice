<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogGame extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the user that owns the LogGame
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(UserDiceTron::class, 'id_akun', 'id');
    }
}
