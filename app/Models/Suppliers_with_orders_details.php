<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suppliers_with_orders_details extends Model
{
    //

    protected $table='suppliers_with_orders_details';
    protected $fillable = [
        'auto_serial_suppliers_with_orders',
        'order_type',
        'item_code',
        'delivery_quantity',
        'unit_id',
        'is_main_or_retail_uom',
        'unit_price',
        'total_price',
        'order_date',

        'batch_id',
        'com_code',
        'added_by',
        'updated_by',
        'production_date',
        'expir_date',


    ];


public function updatedBy()
{
    return $this->belongsTo(Admin::class, 'updated_by');
}
            public function addedBy()
{
    return $this->belongsTo(Admin::class, 'added_by');
}
public function order()
{
    return $this->belongsTo(
        SupplierWithOrder::class,
        'auto_serial_suppliers_with_orders',
        'auto_serial'
    );
}
// ربط بجدول الااصناف عشان ناخذ الااسم
public function item()
{
    return $this->belongsTo(ItemCard::class, 'item_code', 'item_code');
}
// الربط العمود بجدول ال وحدات لاااخذ الااسم
public function unit()
{
    return $this->belongsTo(Inv_uom::class, 'unit_id', 'id');
}

// العلاقة مع الباتش
public function batchid()
{
    return $this->belongsTo(
        InvItemBatch::class,'batch_id','auto_serial');
}




}
