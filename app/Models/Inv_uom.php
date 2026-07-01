<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inv_uom extends Model
{
    //

     protected $table = 'inv_uoms';

    protected $fillable = [
        'name',
        'added_by',
        'updated_by',
        'com_code',
        'active',
        'date',
        'is_master',
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
