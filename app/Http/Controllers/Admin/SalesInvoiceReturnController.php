<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesInvoicactiveinvoiceReturnRequest;
use App\Models\Accauont;
use App\Models\Admin_Shift;
use App\Models\Customer;
use App\Models\SalesInvoiceReturn;
use App\Models\Delegate;
use App\Models\ItemCard;
use App\Models\Inv_uom;
use App\Models\SalesMaterialType;
use App\Models\InvItemBatch;
use App\Models\Store;
use App\Models\TreasuriesTransaction;
use App\Models\SalesInvoiceReturnDetail;
use App\Models\Treasury;
use App\Models\InvItem_card_Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesInvoiceReturnController extends Controller
{
   public function index()
{
    $data = SalesInvoiceReturn::with([
    'customer',
    'delegate',
    'salesmaterialtypes',
    'details.itemcode'
])
->orderBy('id', 'DESC')
->paginate(PAGINATION_COUNT);

    $customers = Customer::where('active', 1)->orderBy('id', 'DESC')->get();
    $sales_material_types=SalesMaterialType::where('active', 1)->orderBy('id', 'DESC')->get();

    $delegate = Delegate::where('active', 1)
    ->orderBy('id', 'DESC')
    ->get();
    $item_cards = ItemCard::where('active', 1)
        ->orderBy('id', 'DESC')
        ->get();

    $units = Inv_uom::where('active', 1)
        ->get()
        ->keyBy('id');

    $stores = Store::where('active', 1)
        ->get()
        ->keyBy('id');

    $inv_item_batches = InvItemBatch::where('quantity', '>', 0)
        ->orderBy('item_code')
        ->orderBy('id', 'DESC')
        ->get();
    $treasuries = Treasury::where('active', 1)
    ->orderBy('id', 'DESC')
    ->get();
    // خزنة الشفت الحالي للمستخدم
$currentShift = Admin_Shift::where(
    'admin_id',
    auth('admin')->id()
)
    ->where('is_finished', 0)
    ->with('treasuriesname')
    ->first();
    // ============================================================
// حساب الرصيد الحالي لخزنة الشفت
// ============================================================

$treasuryBalance = 0;

if ($currentShift) {

    $treasuryBalance = TreasuriesTransaction::where(
        'treasuries_id',
        $currentShift->treasuries_id
    )
        ->where('admin_shift_id', $currentShift->id)
        ->sum('money');
}

    return view(
        'admin.sales_invoice_return.index',
        compact(
            'data',
            'customers',
            'item_cards',
            'units',
            'stores',
            'inv_item_batches','treasuries','currentShift','treasuryBalance','delegate','sales_material_types'
        )
    );
}

public function search(Request $request)
{
    $query = SalesInvoiceReturn::with([
        'customer',
        'delegate',
        'salesmaterialtypes'
    ]);

    // البحث
    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            // رقم الفاتورة
            $q->where('auto_serial', 'like', "%{$search}%")

                // اسم العميل
                ->orWhereHas('customer', function ($customerQuery) use ($search) {

                    $customerQuery->where('name', 'like', "%{$search}%");

                })

                // اسم المندوب
                ->orWhereHas('delegate', function ($delegateQuery) use ($search) {

                    $delegateQuery->where('name', 'like', "%{$search}%");

                });

        });
    }


    // من تاريخ
    if ($request->filled('from_date')) {

        $query->whereDate(
            'invoice_date',
            '>=',
            $request->from_date
        );

    }


    // إلى تاريخ
    if ($request->filled('to_date')) {

        $query->whereDate(
            'invoice_date',
            '<=',
            $request->to_date
        );

    }


    // النتائج
    $data = $query
        ->orderBy('id', 'DESC')
        ->paginate(PAGINATION_COUNT)
        ->withQueryString();


    // نفس البيانات التي تحتاجها صفحة index
    $customers = Customer::where('active', 1)
        ->orderBy('id', 'DESC')
        ->get();

    $sales_material_types = SalesMaterialType::where('active', 1)
        ->orderBy('id', 'DESC')
        ->get();

    $delegate = Delegate::where('active', 1)
        ->orderBy('id', 'DESC')
        ->get();


    $item_cards = ItemCard::where('active', 1)
        ->orderBy('id', 'DESC')
        ->get();

    $units = Inv_uom::where('active', 1)
        ->get()
        ->keyBy('id');

    $stores = Store::where('active', 1)
        ->get()
        ->keyBy('id');

    $inv_item_batches = InvItemBatch::where('quantity', '>', 0)
        ->orderBy('item_code')
        ->orderBy('id', 'DESC')
        ->get();

    $treasuries = Treasury::where('active', 1)
        ->orderBy('id', 'DESC')
        ->get();


    // الشفت الحالي
    $currentShift = Admin_Shift::where(
        'admin_id',
        auth('admin')->id()
    )
        ->where('is_finished', 0)
        ->with('treasuriesname')
        ->first();


    // رصيد الخزنة
    $treasuryBalance = 0;

    if ($currentShift) {

        $treasuryBalance = TreasuriesTransaction::where(
            'treasuries_id',
            $currentShift->treasuries_id
        )
            ->where('admin_shift_id', $currentShift->id)
            ->sum('money');

    }


    return view(
        'admin.sales_invoice_return.index',
        compact(
            'data',
            'customers',
            'item_cards',
            'units',
            'stores',
            'inv_item_batches',
            'treasuries',
            'currentShift',
            'treasuryBalance',
            'delegate',
            'sales_material_types'
        )
    );
}
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(SalesInvoicactiveinvoiceReturnRequest $request)
{
     $com_code = auth()->guard('admin')->user()->com_code;


    $autoSerial = (SalesInvoiceReturn::max('auto_serial') ?? 0) + 1;

    // إنشاء الفاتورة
    $invoice = SalesInvoiceReturn::create([
        'invoice_date' => $request->invoice_date,

        'customer_code' => $request->is_has_customer == 1
            ? $request->customer_code
            : null,
            'return_type'=>2,

        'is_has_customer' => $request->is_has_customer ?? 0,

        'sales_material_types' => $request->sales_material_types,

        'delegate_id' => $request->delegate_id ?: null,

        'auto_serial' => $autoSerial,

        'added_by' => auth()->guard('admin')->id(),

        'updated_by' => auth()->guard('admin')->id(),

        'com_code' => $com_code,

        'is_approved' => 0,
    ]);
    // التأكد أن الفاتورة تم إنشاؤها فعلاً
    if (!$invoice) {
        return back()
            ->with('error', 'لم يتم إنشاء الفاتورة.');
    }
    // التأكد من وجود الفاتورة في قاعدة البيانات
    $checkInvoice = SalesInvoiceReturn::where(
        'auto_serial',
        $invoice->auto_serial
    )->first();
    if (!$checkInvoice) {
        return back()
            ->with('error', 'تمت محاولة إنشاء الفاتورة ولكن لم يتم العثور عليها.');
    }
    // الفاتورة موجودة فعلاً
    // نرجع إلى صفحة الفواتير مع رقمها
    return redirect()
        ->route('sales_invoice_return.index', [
            'open_invoice' => $checkInvoice->auto_serial,
        ])
        ->with('success', 'تم إنشاء الفاتورةالمرتجع بنجاح .');
}
    /**
     * Display the specified resource.
     */
   public function show(string $id)
{

}

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(string $auto_serial)
{
    $data = SalesInvoiceReturn::with(['customer','delegate','salesmaterialtypes'])->findOrFail($auto_serial);
     return view('admin.sales_invoice_return.load_invoice_edit', compact('data'));
}
// اضافه التفاصيل للفاتوره
public function addItemToInvoice(Request $request)
{
    $com_code = auth()->guard('admin')->user()->com_code;

    // =====================================================
    // التحقق من البيانات
    // =====================================================

    $request->validate([

        'auto_serial_sales_invoice' => 'required',

        'item_code' => 'required',

        'store_id' => 'required',

        'sales_uom_id' => 'required',

        'quantity' => 'required|numeric|min:1',

        'unit_price' => 'required|numeric|min:0',

    ]);


    // =====================================================
    // البحث عن الفاتورة
    // =====================================================

    $invoice = SalesInvoiceReturn::where(
        'auto_serial',
        $request->auto_serial_sales_invoice
    )->first();


    if (!$invoice) {

        return back()->with(
            'error',
            'الفاتورة غير موجودة.'
        );

    }


    // =====================================================
    // التأكد أن الفاتورة غير معتمدة
    // =====================================================

    if ($invoice->is_approved == 1) {

        return back()->with(
            'error',
            'لا يمكن إضافة صنف إلى فاتورة معتمدة.'
        );

    }


    // =====================================================
    // البحث عن الصنف
    // =====================================================

    $item = ItemCard::where('com_code', $com_code)
        ->where('item_code', $request->item_code)
        ->first();


    if (!$item) {

        return back()->with(
            'error',
            'الصنف غير موجود.'
        );

    }


    // =====================================================
    // حساب كمية الخصم من المخزون
    // المخزون محفوظ بوحدة التجزئة
    // =====================================================

    if (
        (int)$request->sales_uom_id ===
        (int)$item->uom_id
    ) {

        // البيع بالوحدة الأب

        $quantityToSubtract =
            $request->quantity *
            $item->retail_uom_quantity_to_parent;

    } else {

        // البيع بوحدة التجزئة

        $quantityToSubtract =
            $request->quantity;

    }


    // =====================================================
    // البحث عن الباتش
    // =====================================================

    $batch = InvItemBatch::where('com_code', $com_code)
        ->where('store_id', $request->store_id)
        ->where('item_code', $request->item_code)
        ->where('inv_uoms_id', $item->retail_uom)
        ->where('quantity', '>=', $quantityToSubtract)
        ->orderBy('expire_date', 'asc')
        ->first();


    if (!$batch) {

        return back()->with(
            'error',
            'لا توجد كمية كافية في المخزون.'
        );

    }


    // =====================================================
    // كمية المخزن الحالي قبل الحركة
    // =====================================================

    $quantityStoreBefore = InvItemBatch::where(
        'com_code',
        $com_code
    )
        ->where('store_id', $request->store_id)
        ->where('item_code', $request->item_code)
        ->sum('quantity');


    // =====================================================
    // كمية الصنف في جميع المخازن قبل الحركة
    // =====================================================

    $quantityAllStoresBefore = InvItemBatch::where(
        'com_code',
        $com_code
    )
        ->where('item_code', $request->item_code)
        ->sum('quantity');


    // =====================================================
    // زياده الكمية من الباتش
    // =====================================================

    $batch->quantity =
        $batch->quantity +
        $quantityToSubtract;


    // =====================================================
    // تحديث إجمالي تكلفة الباتش
    // =====================================================

    $batch->total_cost_price =
        $batch->quantity *
        $batch->unit_cost_price;


    $batch->updated_by =
        auth()->guard('admin')->id();


    $batch->save();


    // =====================================================
    // كمية المخزن الحالي بعد الحركة
    // =====================================================

    $quantityStoreAfter = InvItemBatch::where(
        'com_code',
        $com_code
    )
        ->where('store_id', $request->store_id)
        ->where('item_code', $request->item_code)
        ->sum('quantity');


    // =====================================================
    // كمية الصنف في جميع المخازن بعد الحركة
    // =====================================================

    $quantityAllStoresAfter = InvItemBatch::where(
        'com_code',
        $com_code
    )
        ->where('item_code', $request->item_code)
        ->sum('quantity');


    // =====================================================
    // حساب الإجمالي
    // =====================================================

    $totalPrice =
        $request->quantity *
        $request->unit_price;


    // =====================================================
    // إضافة الصنف إلى تفاصيل الفاتورة
    // =====================================================

    $salesInvoiceDetails = SalesInvoiceReturnDetail::create([

        // رقم الفاتورة
        'auto_serial_sales_invoice' =>
            $invoice->auto_serial,

        // نوع الصنف
        'item_card_type' =>
            $request->item_card_type ?? 1,

        // كود الصنف
        'item_code' =>
            $request->item_code,

        // نوع البيع
        'sales_item_type' =>
            $request->sales_item_type,

        // الكمية
        'quantity' =>
            $request->quantity,

        // وحدة البيع
        'unit_id' =>
            $request->sales_uom_id,

        // المخزن
        'store_id' =>
            $request->store_id,

        // هل الوحدة أب أم تجزئة
        'is_main_or_retail_uom' =>
            $request->is_main_or_retail_uom ?? 0,

        // سعر الوحدة
        'unit_price' =>
            $request->unit_price,

        // إجمالي الصنف
        'total_price' =>
            $totalPrice,

        // تاريخ الفاتورة
        'invoice_date' =>
            $invoice->invoice_date,

        // الدفعة
        'batch_id' =>
            $request->batch_id ?? $batch->id,

        // الشركة
        'com_code' =>
            $com_code,

        // المستخدم
        'added_by' =>
            auth()->guard('admin')->id(),

        'updated_by' =>
            auth()->guard('admin')->id(),

        // تاريخ الإنتاج
        'production_date' =>
            $batch->production_date ,

        // تاريخ الانتهاء
        'expir_date' =>
            $batch->expire_date ,

        // نوع الحركة
        'is_normal_or_other' =>
            $request->is_normal_or_other,

    ]);


    // =====================================================
    // تسجيل حركة الصنف
    // =====================================================


    InvItem_card_Movement::create([

      // فئة الحركة
'inv_itemcard_movements_categories' => 1,
        // الصنف
        'item_code' =>
            $request->item_code.'رقم الصنف :'.'اسم الصنف :'.$item->name,

        // نوع الحركة
        'items_movements_types' =>4,

        // رقم الفاتورة
        'FK_table' =>'رقم الفاتوره :'.
            $invoice->auto_serial,

        // رقم تفاصيل الفاتورة
        'FK_table_details' =>
            $salesInvoiceDetails->id,

        // البيان
        'byan' =>
            'مرتجع من فاتورة مبيعات',

        // كمية الصنف في جميع المخازن قبل الحركة
        'quantity_befor_movement' =>
            $quantityAllStoresBefore,

        // كمية الصنف في جميع المخازن بعد الحركة
        'quantity_after_move' =>
            $quantityAllStoresAfter,

        // كمية المخزن الحالي قبل الحركة
        'quantity_befor_move_store' =>
            $quantityStoreBefore,

        // كمية المخزن الحالي بعد الحركة
        'quantity_after_move_store' =>
            $quantityStoreAfter,

        // المستخدم
        'added_by' =>
            auth()->guard('admin')->id(),

        // التاريخ
        'date' =>
            $invoice->invoice_date,

        // الشركة
        'com_code' =>
            $com_code,

        // المخزن
        'store_id' =>
            $request->store_id,

    ]);


    // =====================================================
    // تحديث البطاقة الرئيسية للصنف
    // =====================================================

    $currentStoreQuantity = InvItemBatch::where(
        'com_code',
        $com_code
    )
        ->where('store_id', $request->store_id)
        ->where('item_code', $request->item_code)
        ->sum('quantity');


    // =====================================================
    // كمية الصنف في جميع المخازن
    // =====================================================

    $currentAllStoresQuantity = InvItemBatch::where(
        'com_code',
        $com_code
    )
        ->where('item_code', $request->item_code)
        ->sum('quantity');


    // =====================================================
    // تحديث الكمية الكلية في البطاقة الرئيسية
    // =====================================================

    $item->Quantity_all_retail =
        $currentAllStoresQuantity;


    // =====================================================
    // تحديث كمية الوحدة الأب
    // =====================================================

    if (
        $item->retail_uom_quantity_to_parent > 0
    ) {

        $item->Quantity =
            floor(
                $currentStoreQuantity /
                $item->retail_uom_quantity_to_parent
            );

        // =================================================
        // كمية التجزئة المتبقية
        // =================================================

        $item->Quantity_retail =
            $currentStoreQuantity %
            $item->retail_uom_quantity_to_parent;

    } else {

        $item->Quantity = 0;

        $item->Quantity_retail =
            $currentStoreQuantity;

    }


    // =====================================================
    // تحديث المستخدم
    // =====================================================

    $item->updated_by =
        auth()->guard('admin')->id();


    // =====================================================
    // حفظ البطاقة الرئيسية
    // =====================================================

    $item->save();


    // =====================================================
    // الرجوع
    // =====================================================

    return back()->with(
        'success',
        'تم إضافة الصنف إلى الفاتورة وخصم الكمية من المخزون بنجاح.'
    );
}
// اعتماد الفاتوره المرتجع*/
public function sales_approve_invoice(Request $request, $auto_serial)
{
    $com_code = auth()->guard('admin')->user()->com_code;
    $admin_id = auth()->guard('admin')->id();

    // =========================================================
    // جلب الفاتورة
    // =========================================================

    $data = SalesInvoiceReturn::where('auto_serial', $auto_serial)
        ->where('com_code', $com_code)
        ->first();

    if (!$data) {
        return redirect()->back()
            ->with('error', 'الفاتورة غير موجودة');
    }

    if ($data->is_approved == 1) {
        return redirect()->back()
            ->with('error', 'تم اعتماد هذه الفاتورة من قبل');
    }

    // =========================================================
    // جلب العميل
    // =========================================================

    $customer = Customer::where('id', $data->customer_code)
        ->where('com_code', $com_code)
        ->first();

    if (!$customer) {
        return redirect()->back()
            ->with('error', 'العميل غير موجود');
    }

    // =========================================================
    // الحساب المالي للعميل
    // نفس منطق حساب المورد
    // =========================================================

    $customerAccount = Accauont::where(
        'accauont_number',
        $customer->account_number
    )
        ->where('com_code', $com_code)
        ->first();

    if (!$customerAccount) {
        return redirect()->back()
            ->with(
                'error',
                'رقم الحساب المالي للعميل غير موجود في شجرة الحسابات'
            );
    }

    // =========================================================
    // التحقق من الشفت الخاص بالخزينة
    // =========================================================

    $shift = Admin_Shift::where('admin_id', $admin_id)
        ->where('treasuries_id', $request->treasury_id)
        ->where('com_code', $com_code)
        ->where('is_finished', 0)
        ->first();

    if (!$shift) {
        return redirect()->route('Sales_Invoice.index')
            ->with(
                'error',
                'لا يمكن اعتماد الفاتورة، الشفت الخاص بالخزينة مغلق'
            );
    }

    // =========================================================
    // تفاصيل الفاتورة
    // =========================================================

    $all_item_sum = SalesInvoiceReturnDetail::where('com_code', $com_code)
        ->where('auto_serial_sales_invoice', $auto_serial)
        ->sum('total_price');

    // =========================================================
    // التحقق من وجود أصناف
    // =========================================================

    if ($all_item_sum == 0) {
        return redirect()->route('sales_invoice_return.index')
            ->with(
                'error',
                'لا يمكن اعتماد الفاتورة لأنها لا تحتوي على أصناف'
            );
    }

    // =========================================================
    // حفظ بيانات الفاتورة قبل الاعتماد
    // =========================================================

    $data->total_cost = $all_item_sum;

    $data->total_before_discount = $request->final_total;

    $data->discount_type = $request->discount_type;
    $data->discount_value = $request->discount_input;

    $data->tax_percent = $request->tax_percentage;
    $data->tax_value = $request->tax_value;

    $data->notes = $request->notes ?? 'لايوجد ملاحظة';

    $data->bill_type = $request->invoice_type;

    $data->what_paid = $request->paid_amount ?? 0;
    $data->what_remain = $request->remaining_amount;

    $data->approved_by = $admin_id;

    $data->account_number = $customer->account_number;

    $data->treasury_transaction_id = $request->treasury_id;

    // =========================================================
    // متغيرات رصيد حساب العميل
    // =========================================================

    $balanceBefore = $customerAccount->current_balance ?? 0;
    $balanceAfter = $balanceBefore;

    // =========================================================
    // تحديث حساب العميل
    // إذا كانت الفاتورة آجلة
    // =========================================================

    if ($data->bill_type == 2) {

        // رصيد العميل قبل الفاتورة
        $balanceBefore =
            $customerAccount->current_balance ?? 0;

        // إضافة المبلغ المتبقي على حساب العميل
        $balanceAfter =
            $balanceBefore + $data->what_remain;

        // تحديث الحساب المحاسبي
        $customerAccount->current_balance =
            $balanceAfter;

        $customerAccount->updated_by =
            $admin_id;

        $customerAccount->save();

        // تسجيل الرصيد في الفاتورة
        $data->customer_balance_before =
            $balanceBefore;

        $data->customer_balance_after =
            $balanceAfter;

        $data->money_for_account =
            $data->what_remain;
    }

    // =========================================================
    // إذا كانت الفاتورة كاش
    // لا يوجد مبلغ على حساب العميل
    // =========================================================

    else {

        $data->customer_balance_before =
            $balanceBefore;

        $data->customer_balance_after =
            $balanceBefore;

        $data->money_for_account = 0;
    }

    // =========================================================
    // اعتماد الفاتورة
    // =========================================================

    $data->is_approved = 1;

    $data->save();

    // =========================================================
    // جلب الخزينة
    // =========================================================

    $treasury = Treasury::where('id', $request->treasury_id)
        ->where('com_code', $com_code)
        ->first();

    if (!$treasury) {
        return redirect()->back()
            ->with('error', 'الخزينة غير موجودة');
    }

    // =========================================================
    // زيادة رقم إيصال القبض
    // =========================================================

    $treasury->last_isal_exchange =
        ($treasury->last_isal_exchange ?? 0) + 1;

    $treasury->save();

    // =========================================================
    // تسجيل حركة الخزينة
    // =========================================================

    TreasuriesTransaction::create([

        'treasuries_id' =>
            $treasury->id,

        'mov_type' =>
            6,

        'the_forign_key' =>
            $data->auto_serial,

        // الحساب المحاسبي للعميل
        'accauont_number' =>
            $customerAccount->id,

        'is_accauont' =>
            1,

        'is_Approved' =>
            1,

        'admin_shift_id' =>
            $shift->id,

        // المبلغ المدفوع فعليًا
        'money' =>
            $data->what_paid,

        // المبلغ المتبقي على العميل
        'money_for_accauont' =>
            $data->what_remain,

        'move_date' =>
            now(),

        'bayan' =>
            'تحصيل إيراد مبيعات رقم فاتوره ' . $data->auto_serial,

        'added_by' =>
            $admin_id,

        'updated_by' =>
            $admin_id,

        'com_code' =>
            $com_code,

        'auto_serial' =>
            $data->auto_serial,

        'isal_number' =>
            $treasury->last_isal_collection,
    ]);

    // =========================================================
    // النتيجة
    // =========================================================

    return redirect()->route('sales_invoice_return.index')
        ->with(
            'success',
            'تم اعتماد الفاتورة بنجاح وتحديث حساب العميل وحركة الخزينة'
        );
}
    /**
     * حذف الفاتوره بشكل عام
     */
public function destroy(string $id)
{
    $data = SalesInvoiceReturn::findOrFail($id);

    $detailsCount = SalesInvoiceReturnDetail::where('auto_serial_sales_invoice', $data->auto_serial)->count();

    if ($detailsCount > 0) {
        return redirect()
            ->route('sales_invoice_return.index')
            ->with([
                'error' => 'لا يمكن حذف الفاتورة لأنها تحتوي على أصناف. ولم يتم اعتمادها '
            ]);
    }

    $data->delete();

    return redirect()
        ->route('sales_invoice_return.index')
        ->with([
            'success' => 'تم حذف الفاتورة المرتجع بنجاح'
        ]);
}

// حذف الصنف من الفاتوره قبل الااعتماد

public function deleteItem($id)
{
    DB::beginTransaction();

    try {
        $com_code = auth()->guard('admin')->user()->com_code;
        $admin_id = auth()->guard('admin')->id();

        // 1. جلب تفاصيل المرتجع
        $detail = SalesInvoiceReturnDetail::where('id', $id)
            ->where('com_code', $com_code)
            ->lockForUpdate()
            ->first();

        if (!$detail) {
            throw new \Exception('الصنف غير موجود في تفاصيل المرتجع');
        }

        // 2. جلب فاتورة المرتجع
        $invoice = SalesInvoiceReturn::where(
            'auto_serial',
            $detail->auto_serial_sales_invoice
        )
            ->where('com_code', $com_code)
            ->lockForUpdate()
            ->first();

        if (!$invoice) {
            throw new \Exception('فاتورة المرتجع غير موجودة');
        }

        // 3. منع الحذف بعد اعتماد الفاتورة
        if ($invoice->is_approved == 1) {
            throw new \Exception(
                'لا يمكن حذف صنف من فاتورة مرتجع مبيعات معتمدة'
            );
        }

        // 4. جلب بطاقة الصنف
        $item = ItemCard::where('com_code', $com_code)
            ->where('item_code', $detail->item_code)
            ->first();

        if (!$item) {
            throw new \Exception('بطاقة الصنف غير موجودة');
        }

        // 5. جلب نفس الباتش المرتبط بتفاصيل المرتجع
        $batch = InvItemBatch::where('id', $detail->batch_id)
            ->where('com_code', $com_code)
            ->where('store_id', $detail->store_id)
            ->where('item_code', $detail->item_code)
            ->lockForUpdate()
            ->first();

        if (!$batch) {
            throw new \Exception('الباتش المرتبط بالصنف غير موجود');
        }

        // 6. تحويل الكمية إلى الوحدة الصغرى
        $quantityToRemove = $detail->quantity;

        if ((int) $detail->unit_id === (int) $item->uom_id) {
            $quantityToRemove *= $item->retail_uom_quantity_to_parent;
        }

        // 7. التحقق من كمية الباتش
        if ($batch->quantity < $quantityToRemove) {
            throw new \Exception(
                'كمية الباتش الحالية أقل من الكمية المطلوب خصمها'
            );
        }

        // 8. حساب الكميات قبل الحذف
        $quantityBeforeAllStores = InvItemBatch::where(
            'item_code',
            $detail->item_code
        )
            ->where('com_code', $com_code)
            ->sum('quantity');

        $quantityBeforeStore = InvItemBatch::where(
            'item_code',
            $detail->item_code
        )
            ->where('store_id', $detail->store_id)
            ->where('com_code', $com_code)
            ->sum('quantity');

        // 9. عكس الزيادة التي حدثت عند إضافة الصنف للمرتجع
        $batch->quantity -= $quantityToRemove;
        $batch->total_cost_price =
            $batch->quantity * $batch->unit_cost_price;
        $batch->updated_by = $admin_id;
        $batch->save();

        // 10. حساب الكميات بعد الحذف
        $quantityAfterAllStores = InvItemBatch::where(
            'item_code',
            $detail->item_code
        )
            ->where('com_code', $com_code)
            ->sum('quantity');

        $quantityAfterStore = InvItemBatch::where(
            'item_code',
            $detail->item_code
        )
            ->where('store_id', $detail->store_id)
            ->where('com_code', $com_code)
            ->sum('quantity');

        // 11. تحديث بطاقة الصنف
        $item->Quantity_all_retail = $quantityAfterAllStores;

        if ($item->retail_uom_quantity_to_parent > 0) {
            $item->Quantity = floor(
                $quantityAfterStore /
                $item->retail_uom_quantity_to_parent
            );

            $item->Quantity_retail =
                $quantityAfterStore %
                $item->retail_uom_quantity_to_parent;
        } else {
            $item->Quantity = 0;
            $item->Quantity_retail = $quantityAfterStore;
        }

        $item->updated_by = $admin_id;
        $item->save();

        // 12. تسجيل حركة حذف الصنف من مرتجع المبيعات
        InvItem_card_Movement::create([
            'inv_itemcard_movements_categories' => 2,
            'item_code' => $detail->item_code,
            'items_movements_types' => 13,
            'FK_table' => $invoice->auto_serial,
            'FK_table_details' => $detail->id,
            'byan' => 'حذف صنف من فاتورة مرتجع مبيعات غير معتمدة',
            'added_by' => $admin_id,
            'date' => date('Y-m-d'),
            'com_code' => $com_code,
            'store_id' => $detail->store_id,
            'quantity_befor_movement' => $quantityBeforeAllStores,
            'quantity_after_move' => $quantityAfterAllStores,
            'quantity_befor_move_store' => $quantityBeforeStore,
            'quantity_after_move_store' => $quantityAfterStore,
        ]);

        // 13. حذف تفاصيل المرتجع
        $detail->delete();

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'تم حذف الصنف وخصم كميته من الباتش وتسجيل حركة المخزون بنجاح'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}


}
