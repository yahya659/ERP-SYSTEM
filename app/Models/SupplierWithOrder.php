<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierWithOrder extends Model
{
    //
       protected $table = 'suppliers_with_orders';

    protected $fillable = [
        'order_type',
        'auto_serial',
        'doc_no',
        'order_date',
        'supplier_id',
        'is_approved',
        'total_before_discount',
        'discount_type',
        'discount_value',
        'tax_percent',
        'tax_value',
        'notes',
        'total_cost',
        'account_number',
        'money_for_account',
        'bill_type',
        'what_paid',
        'what_remain',
        'store_id',
        'treasury_transaction_id',
        'supplier_balance_before',
        'supplier_balance_after',
        'com_code',
        'added_by',
        'updated_by',
        'approved_by',

    ];
            public function addedBy()
{
    return $this->belongsTo(Admin::class, 'added_by');
}

public function updatedBy()
{
    return $this->belongsTo(Admin::class, 'updated_by');
}
public function supplier()
{
    return $this->belongsTo(Supplier::class, 'supplier_id');
}
// المورد يملك تفصي فاتوره وحده
// اصناف الفاتوره
public function details()
{
    return $this->hasMany(
        Suppliers_with_orders_details::class,'auto_serial_suppliers_with_orders','auto_serial')->orderByDesc('id');
}
public function storename()
{
    return $this->belongsTo(
        Store::class,'store_id');
}
public function treasurie(){
        return $this->belongsTo(Treasury::class, 'treasury_transaction_id');

}

}
