<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accauont extends Model
{
    //
       protected $table="accauonts";
       protected $fillable = [//حقول المسموح تعبتها
       'name','accauont_types','parient_accauont_number','accauont_number','start_balance','current_balance','other_table_fk','nodes',
       'added_by','updated_by','is_archived','com_code','is_parent','date','start_balance_status',
     
    ];
       public function addedBy()
{
    return $this->belongsTo(Admin::class, 'added_by');
}

public function updatedBy()
{
    return $this->belongsTo(Admin::class, 'updated_by');
}
public function accauonttypes()
{
    return $this->belongsTo(AccountType::class, 'accauont_types');
}
public function parientaccauontnumber()
{
    return $this->belongsTo(Accauont::class, 'parient_accauont_number');
}
public function customer()
{
    return $this->belongsTo(Customer::class,'other_table_fk');
}
}
