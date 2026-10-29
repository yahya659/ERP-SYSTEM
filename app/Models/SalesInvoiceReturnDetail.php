<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesInvoiceReturnDetail extends Model
{
    protected $table = 'sales_invoice_return_details';

    protected $fillable = [
        'auto_serial_sales_invoice',
        'item_card_type',
        'item_code',
        'date',
        'sales_item_type',
        'quantity',
        'unit_id',
        'store_id',
        'is_main_or_retail_uom',
        'unit_price',
        'total_price',
        'invoice_date',
        'batch_id',
        'com_code',
        'added_by',
        'updated_by',
        'production_date',
        'expir_date',
        'is_normal_or_other',
    ];
         public function addedBy()
{
    return $this->belongsTo(Admin::class, 'added_by');
}

public function updatedBy()
{
    return $this->belongsTo(Admin::class, 'updated_by');
}
public function unit()
{
    return $this->belongsTo(Inv_uom::class, 'unit_id');
}
public function store()
{
    return $this->belongsTo(Store::class, 'store_id');
}
public function itemcode()
{
    return $this->belongsTo(ItemCard::class, 'item_code','item_code');

}
public function details()
{
    return $this->hasMany(
        SalesInvoiceReturnDetail::class,
        'auto_serial_sales_invoice',
        'auto_serial'
    );
}
}
