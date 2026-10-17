<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function Laravel\Prompts\table;

class AdminTreasury extends Model
{
     protected $table="admin_treasuries";
    protected $fillable = [
        'admin_id','treasuries_id','date','active','added_by','updated_by'

        ,'com_code',
    ];
 public function addedBy()
{
    return $this->belongsTo(Admin::class, 'added_by');
}

public function updatedBy()
{
    return $this->belongsTo(Admin::class, 'updated_by');
}
public function treasury()
{
    return $this->belongsTo(Treasury::class, 'treasuries_id');
}

public function admin()
{
    return $this->belongsTo(Admin::class, 'admin_id');
}
public function activeTreasuries()
{
    return $this->hasMany(AdminTreasury::class, 'admin_id')
        ->where('active', 1)
        ->with('treasury');
}
}
