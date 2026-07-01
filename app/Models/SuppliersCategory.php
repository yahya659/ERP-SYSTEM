<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuppliersCategory extends Model
{
    //
      //
    protected $table='suppliers_categories';
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
public function suppliers()
{
    return $this->hasMany(
        Supplier::class,
        'suppliers_categories_id'
    );
}
}
