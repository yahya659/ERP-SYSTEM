<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table="customers";
    protected $fillable = [
        'name','phone','account_number','customer_code','city_id','address','start_balance','current_balance',
        'nodes','added_by','updated_by','com_code','date','active','start_balance_status'
    ];
 public function addedBy()
{
    return $this->belongsTo(Admin::class, 'added_by');
}

public function updatedBy()
{
    return $this->belongsTo(Admin::class, 'updated_by');
}
// public function account()
// {
//     return $this->hasOne(Accauont::class,'other_table_fk');
// }
}
