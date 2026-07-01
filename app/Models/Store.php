<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    //
    protected $table='stores';
    protected $fillable = [
        'name',
    'added_by',
    'updated_by',
    'com_code',
    'date',
    'active',
    'phones',
    'address',
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
