<?php

namespace App\Models;
use App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Treasury extends Model
{
    //
    protected $table="treasuries";
    protected $fillable = [//حقول المسموح تعبتها
        'name','is_master','last_isal_exchange','last_isal_collection','added_by','updated_by','com_code','date','active'
    ];
        public function updatedBy()
{
    return $this->belongsTo(Admin::class, 'updated_by');
}
        public function addedBy()
{
    return $this->belongsTo(Admin::class, 'added_by');
}
}
