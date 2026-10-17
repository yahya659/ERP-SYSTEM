<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovType extends Model
{
    protected $table = 'mov_type';

    protected $fillable = [
        'name',
        'active',
        'in_screen',
        'is_private_internal',
    ];

    public function treasuriesTransactions()
    {
        return $this->hasMany(
            TreasuriesTransaction::class,
            'mov_type'
        );
    }
}
