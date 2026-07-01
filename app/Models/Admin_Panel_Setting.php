<?php

namespace App\Models;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class Admin_Panel_Setting extends Model
{
    //
       protected $table="admin__panel__settings";
    protected $fillable = [//حقول المسموح تعبتها
        'system_name','phone','active','general_alert','address','phone',
        'added_by','updated_by','com_code','customer_parent_number','supplier_parent_number'
    ];
public function updatedBy()
{
    return $this->belongsTo(Admin::class, 'updated_by');
}
public function customerparentnumber()
{
    return $this->belongsTo(Accauont::class, 'customer_parent_number');
}
public function supplierparentnumber()
{
    return $this->belongsTo(Accauont::class, 'supplier_parent_number');
}
}
