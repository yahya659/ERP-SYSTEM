<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inv_Itemcard_MovementsCategory extends Model
{
    //
      protected $table='inv_itemcard_movements_categories';
    protected $fillable = [
        'name','added_by','updated_by','com_code',
    ];
            public function addedBy()
{
    return $this->belongsTo(Admin::class, 'added_by');
}

public function updatedBy()
{
    return $this->belongsTo(Admin::class, 'updated_by');
}
}

