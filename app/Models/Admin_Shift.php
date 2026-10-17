<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin_Shift extends Model
{
    //
       protected $table="admins_shift";
    protected $fillable = [//حقول المسموح تعبتها
        'admin_id','treasuries_id','start_date','end_date','treasuries_balance_in_shift_start','is_finished',
        'is_delivered_and_rivew','delivered_to_admin_id','delivered_admin_to_shift_id','delivered_to_treasuries_id','mony_should_delivered',
        'what_realy_delivered','mony_state','mony_state_value','reseave_type','review_reseave_date',
        'nods','com_code','added_by','updated_by','date',
    ];
public function addedBy()
{
    return $this->belongsTo(Admin::class, 'added_by');
}

public function updatedBy()
{
    return $this->belongsTo(Admin::class, 'updated_by');
}
public function adminname(){
    return $this->belongsTo(Admin::class,'admin_id');
}
public function treasuriesname(){
    return $this->belongsTo(Treasury::class,'treasuries_id');
}

}
