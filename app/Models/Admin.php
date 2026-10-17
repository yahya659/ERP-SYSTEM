<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Authenticatable
{
    //
    protected $table="admins";
    protected $fillable = [//حقول المسموح تعبتها
        'name','email','username','password','added_by','updated_by','com_code'
    ];
     // العلاقة الجديدة: الخزن المصرح بها لهذا المستخدم
    public function treasuries()
    {
        return $this->belongsToMany(
            Treasury::class,
            'admin_treasuries',   // اسم جدول الربط
            'admin_id',           // المفتاح الخاص بـ Admin في جدول الربط
            'treasuries_id'       // المفتاح الخاص بـ Treasury في جدول الربط
        )->wherePivot('active', 1); // تستخدم كثير لكثير، فيها جدول وسيطwherePivot
    }
}
