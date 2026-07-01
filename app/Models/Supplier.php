<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $table='suppliers';
    protected $fillable = [
        'name','phone','account_number','supplier_code','city_id','address','start_balance','current_balance',
        'nodes','added_by','updated_by','com_code','date','active','start_balance_status',
        'suppliers_categories_id'
    ];
     public function addedBy()
{
    return $this->belongsTo(Admin::class, 'added_by');
}

public function updatedBy()
{
    return $this->belongsTo(Admin::class, 'updated_by');
}
// فئه المورد يتبع مورد واحد
public function category()
{
    return $this->belongsTo(SuppliersCategory::class, 'suppliers_categories_id');
}
}
