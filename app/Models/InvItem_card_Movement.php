<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvItem_card_Movement extends Model
{
    // جدول الحركات
     protected $table = 'inv_itemcard_movements';


    protected $fillable = [

        'inv_itemcard_movements_categories',
        'item_code',
        'items_movements_types',
        'FK_table',
        'FK_table_details',
        'byan',
        'quantity_befor_movement',
        'quantity_after_move',
        'added_by',
        'date',
        'com_code',
        'store_id',
        'quantity_befor_move_store',
        'quantity_after_move_store',

    ];
     public function addedBy()
{
    return $this->belongsTo(Admin::class, 'added_by');
}
    public function movementCategory()
{
    return $this->belongsTo(
        Inv_Itemcard_MovementsCategory::class,
        'inv_itemcard_movements_categories'
    );
}
public function store()
{
    return $this->belongsTo(Store::class, 'store_id');
}


public function movementType()
{
    return $this->belongsTo(
        Inv_Itemcard_MovementsType::class,
        'items_movements_types'
    );
}
}
