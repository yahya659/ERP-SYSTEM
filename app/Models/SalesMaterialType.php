<?php

namespace App\Models;
use App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SalesMaterialType extends Model
{
    //
     protected $table = 'sales_material_types';

    protected $fillable = [
        'name',
        'added_by',
        'updated_by',
        'com_code',
        'active',
        'date',
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
