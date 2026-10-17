<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvItemBatch extends Model
{
    //
     protected $table='inv_item_batches';
      protected $fillable = [
        'store_id',
        'item_code',
        'inv_uoms_id',
        'unit_cost_price',
        'quantity',
        'total_cost_price',
        'production_date',
        'expire_date',
        'auto_serial',
        'is_send_archif',
        'added_by',
        'updated_by',
        'com_code',

    ];
            public function addedBy()
{
    return $this->belongsTo(Admin::class, 'added_by');
}

public function updatedBy()
{
    return $this->belongsTo(Admin::class, 'updated_by');
}
public function storeid ()
{
    return $this->belongsTo(Store::class, 'store_id');
}
public function invuomsid()
{
    return $this->belongsTo(Inv_uom::class, 'inv_uoms_id');
}
}
