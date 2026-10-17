<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
{
    //
     protected $table = 'sales_invoice';

    protected $fillable = [

        // نوع مادة / مبيعات الفاتورة
        'sales_material_types',

        // الرقم التسلسلي للفاتورة
        'auto_serial',

        // تاريخ الفاتورة
        'invoice_date',

        // كود العميل
        'customer_code',
        // خاصه ب المندوب
        'delegate_id',
        // هل الفاتورة لها عميل؟
'is_has_customer',

        // حالة اعتماد الفاتورة
        'is_approved',

        // الإجمالي قبل الخصم
        'total_before_discount',

        // نوع الخصم
        'discount_type',

        // قيمة الخصم
        'discount_value',

        // نسبة الضريبة
        'tax_percent',

        // قيمة الضريبة
        'tax_value',

        // ملاحظات
        'notes',

        // إجمالي الفاتورة
        'total_cost',

        // رقم الحساب المالي
        'account_number',

        // المبلغ على الحساب
        'money_for_account',

        // نوع الفاتورة / الدفع
        'bill_type',

        // المبلغ المدفوع
        'what_paid',

        // المبلغ المتبقي
        'what_remain',

        // حركة الخزينة
        'treasury_transaction_id',

        // رصيد العميل قبل الفاتورة
        'customer_balance_before',

        // رصيد العميل بعد الفاتورة
        'customer_balance_after',

        // الشركة
        'com_code',

        // المستخدم الذي أضاف
        'added_by',

        // المستخدم الذي عدل
        'updated_by',

        // المستخدم الذي اعتمد
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
        SalesInvoiceDetails::class,
        'auto_serial_sales_invoice',
        'auto_serial'
    );
}

}
