<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvItemscardCategory extends Model
{
    //
    protected $table='inv_itemscard_categories';
    protected $fillable = [
        'name','added_by','updated_by','com_code','date','active',
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
