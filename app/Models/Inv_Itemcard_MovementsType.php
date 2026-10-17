<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inv_Itemcard_MovementsType extends Model
{
    //
    // نوع الحركه الصنف
       protected $table = 'inv__itemcard__movements_types';

    protected $fillable = [
        'type',
    ];
}
