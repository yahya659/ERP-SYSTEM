<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreasuriesTransaction extends Model
{
    //
    protected $table="treasuries_transactions";
    protected $fillable = [
         'treasuries_id',
        'mov_type',
        'the_forign_key',
        'accauont_number',
        'is_accauont',
        'is_Approved',
        'admin_shift_id',
        'money',
        'money_for_accauont',
        'move_date',
        'bayan',
        'added_by',
        'updated_by',
        'com_code',
        'auto_serial',
        'isal_number'
    ];
                public function addedBy()
{
    return $this->belongsTo(Admin::class, 'added_by');
}

public function updatedBy()
{
    return $this->belongsTo(Admin::class, 'updated_by');
}

// الخزينة المرتبطة بهذه الحركة
public function treasury()
{
    return $this->belongsTo(Treasury::class, 'treasuries_id');
}

// الحساب المالي المرتبط بهذه الحركة
public function account()
{
    return $this->belongsTo(Accauont::class, 'accauont_number');
}

// شفت المستخدم الذي تمت خلاله الحركة
public function adminShift()
{
    return $this->belongsTo(Admin_Shift::class, 'admin_shift_id');
}
public function movType()
{
    return $this->belongsTo(
        MovType::class,
        'mov_type'
    );
}

}
