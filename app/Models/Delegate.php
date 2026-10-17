<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delegate extends Model
{
    //
    protected $table='delegates';
    protected $fillable = [
        'name',
        'phone',
        'accauont_types',
        'account_number',
        'delegate_code',
        'city_id',
        'address',
        'start_balance',
        'current_balance',
        'nodes',
        'added_by',
        'updated_by',
        'com_code',
        'date',
        'active',
        'start_balance_status',
        'parcent_type',
        'parcent_sales_commission_jomla',
        'parcent_collection_commission',
        'parcent_sales_commission_katai',
        'parcent_sales_commission_nosjamla',
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
