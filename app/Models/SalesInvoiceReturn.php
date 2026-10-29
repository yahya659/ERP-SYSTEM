<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesInvoiceReturn extends Model
{
    protected $table = 'sales_invoice_return';

    protected $fillable = [
        'return_type',
        'sales_material_types',
        'auto_serial',
        'invoice_date',
        'customer_code',
        'delegate_id',
        'is_has_customer',
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
        'treasury_transaction_id',
        'customer_balance_before',
        'customer_balance_after',
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
public function approvedby()
{
    return $this->belongsTo(Admin::class, 'approved_by');
}
public function customer()
{
    return $this->belongsTo(Customer::class, 'customer_code', 'id');
}
public function delegate()
{
    return $this->belongsTo(Delegate::class, 'delegate_id');
}


public function salesmaterialtypes()
{
    return $this->belongsTo(
        SalesMaterialType::class,
        'sales_material_types'
    );
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
