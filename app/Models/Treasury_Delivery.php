<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treasury_Delivery extends Model
{
    //
     protected $table = 'treasuries_delivery';

    protected $fillable = [
        'treasuries_id',
        'treasuries_can_delivery_id',
        'added_by',
        'updated_by',
        'com_code',
    ];


    public function treasury()
    {
        return $this->belongsTo(Treasury::class, 'treasuries_id');
    }

    public function canDeliveryTreasury()
    {
        return $this->belongsTo(Treasury::class, 'treasuries_can_delivery_id');
    }
    public function addedBy()
{
    return $this->belongsTo(Admin::class, 'added_by');
}
}
