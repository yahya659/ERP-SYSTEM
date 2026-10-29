<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuppliersWithOrderDetailRequest;
use App\Http\Requests\SupplierWithOrderRequest;
use App\Models\Accauont;
use App\Models\Admin_Shift;
use App\Models\Inv_uom;
use App\Models\InvItem_card_Movement;
use App\Models\InvItemBatch;
use App\Models\ItemCard;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\Suppliers_with_orders_details;
use App\Models\SupplierWithOrder;
use App\Models\TreasuriesTransaction;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class SupplierWithOrderController extends Controller
{

    public function index()
    {
         $com_code = auth()->guard('admin')->user()->com_code;
           $data=SupplierWithOrder::select()->with('supplier')->orderBy('id','DESC')->where('order_type',1)->where('com_code', $com_code)->paginate(PAGINATION_COUNT);
        return view('admin.supplier_With_Order.index',compact('data'));
    }
    // داله البحث
public function search(Request $request)
{
    $query = SupplierWithOrder::with('supplier')->where('order_type', 1)->orderBy('id', 'DESC');
    // البحث برقم الفاتورة أو المورد
    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where('doc_no', 'like', '%' . $search . '%')

                ->orWhere('id', 'like', '%' . $search . '%')

                ->orWhereHas('supplier', function ($supplier) use ($search) {

                    $supplier->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    );

                });
        });
    }
    // البحث من تاريخ
    if ($request->filled('from_date')) {

        $query->whereDate(
            'order_date',
            '>=',
            $request->from_date
        );
    }
    // البحث إلى تاريخ
    if ($request->filled('to_date')) {

        $query->whereDate(
            'order_date',
            '<=',
            $request->to_date
        );
    }
    // النتائج
    $data = $query->paginate(PAGINATION_COUNT);

    // الحفاظ على البحث والتواريخ أثناء التنقل
    $data->appends($request->all());

    return view(
        'admin.supplier_With_Order.index',
        compact('data')
    );
}

    public function create()
    {
        $supplier=Supplier::all();
        $store=Store::all();
         return view('admin.supplier_with_order.create',compact('supplier','store'));

    }
    public function store(SupplierWithOrderRequest $request)
    {
          $com_code = auth()->guard('admin')->user()->com_code;
             $lastDocNo = SupplierWithOrder::where('com_code', $com_code)
    ->orderBy('doc_no', 'DESC')
    ->value('doc_no');

$docNo = $lastDocNo ? $lastDocNo + 1 : 1;
   SupplierWithOrder::create([
    'supplier_id' => $request->supplier_id,//اسم المورد
    'order_date' => $request->order_date,
    'doc_no' => $docNo,
    'store_id' => $request->store_id,
    'bill_type' => $request->bill_type,
    'notes' => $request->notes,
    'auto_serial' => (SupplierWithOrder::max('auto_serial') ?? 0) + 1,
    'order_type' =>1,
    'total_cost' => $request->total_cost,
    'tax_value' => $request->tax_value,
    'discount_value' => $request->discount_value,
    'discount_type' => $request->discount_type,
    'total_before_discount' => $request->total_before_discount,
    'supplier_balance_before' => $request->supplier_balance_before,
    'supplier_balance_after' => $request->supplier_balance_after,
    'money_for_account' => $request->money_for_account,
    // 'money_for_account' => $request->money_for_account,

    'added_by' => auth()->guard('admin')->id(),
    'updated_by' => auth()->guard('admin')->id(),
    'com_code' =>$com_code,
    'is_approved' => $request->is_approved ??0,


]);
          return redirect()->route('SupplierWithOrder.index')->with('success', 'تم إضافة الفاتوره  بنجاح  ');


    }


    public function show(string $id)
    {

          $data = SupplierWithOrder::find($id);
          $com_code = auth()->guard('admin')->user()->com_code;

$adminsift = Admin_Shift::where('com_code', $com_code)
    ->where('admin_id', auth()->guard('admin')->id())
    ->where('is_finished', 0)
    ->with(['adminname', 'treasuriesname'])
    ->first();//لعرض الشفت لانها عبر include
    ;//جمع الرصيد المتاح في الخزنه
        $treasuriesBalance = 0;
        if ($adminsift) {
            $treasuriesBalance = TreasuriesTransaction::where(
                'treasuries_id',
                $adminsift->treasuries_id
            )->sum('money');
        }
          $item_cards = ItemCard::with(['uomid', 'retail_uom_id',])->where('active', 1)->orderBy('id', 'DESC')->get();
          return view('admin.supplier_with_order.show',compact('data','item_cards','adminsift','treasuriesBalance'));
    }


   public function edit(string $id)
{
    $data = SupplierWithOrder::find($id);

    $supplier = Supplier::all();

    $store = Store::all();

    return view('admin.supplier_With_Order.edit', compact(
        'data',
        'supplier',
        'store'
    ));
}

    /**
     * Update the specified resource in storage.
     */
  public function update($id, SupplierWithOrderRequest $request)
{
    $com_code = auth()->guard('admin')->user()->com_code;

    $data = SupplierWithOrder::find($id);

    $data->fill([
        'supplier_id' => $request->supplier_id,
        'order_date' => $request->order_date,
        'doc_no' => $request->doc_no,
        'store_id' => $request->store_id,
        'bill_type' => $request->bill_type,
        'notes' => $request->notes,
        'updated_by' => auth()->guard('admin')->id(),
        'com_code' => $com_code,
    ]);
    // التحقق هل تغيرت بيانات أم لا
    if (!$data->isDirty()) {
        return redirect()
            ->route('SupplierWithOrder.index')
            ->with('error', 'لم تقوم بتعديل فواتير المشتريات من المورد');
    }
    $data->save();
    return redirect()
        ->route('SupplierWithOrder.index')
        ->with('success','تم تعديل فواتير المشتريات من المورد');
}

public function destroy(string $id)
{
    $com_code = auth()->guard('admin')->user()->com_code;
    $admin_id = auth()->guard('admin')->id();

    // جلب فاتورة المشتريات
    $Supplier = SupplierWithOrder::where('id', $id)
        ->where('com_code', $com_code)
        ->first();

    if (!$Supplier) {
        return redirect()->route('SupplierWithOrder.index')
            ->with(['error' => 'فاتورة المشتريات غير موجودة']);
    }

    // جلب جميع أصناف الفاتورة
    $details = Suppliers_with_orders_details::where(
        'auto_serial_suppliers_with_orders',
        $Supplier->auto_serial
    )->where('com_code', $com_code)->get();

    try {
        DB::transaction(function () use (
            $Supplier,
            $details,
            $com_code,
            $admin_id
        ) {
            foreach ($details as $detail) {

                // جلب بطاقة الصنف
                $item = ItemCard::where('item_code', $detail->item_code)
                    ->where('com_code', $com_code)
                    ->first();

                // جلب الباتش المرتبط بتفاصيل الفاتورة
                $batch = null;

                if (!empty($detail->batch_id)) {
                    $batch = InvItemBatch::where(
                        'auto_serial',
                        $detail->batch_id
                    )
                        ->where('store_id', $Supplier->store_id)
                        ->where('item_code', $detail->item_code)
                        ->where('com_code', $com_code)
                        ->lockForUpdate()
                        ->first();
                }

                // لا نحذف الفاتورة إذا تعذر تحديد الباتش أو بطاقة الصنف
                if (!$item || !$batch) {
                    throw new \Exception(
                        'تعذر العثور على بطاقة الصنف أو الباتش للصنف رقم: '
                        . $detail->item_code
                        . '، لذلك لم يتم حذف الفاتورة'
                    );
                }

                // تحويل الكمية إلى الوحدة الصغرى (التجزئة)
                $quantity_retail = $detail->delivery_quantity;

                if ($detail->unit_id == $item->uom_id) {
                    $quantity_retail *=
                        $item->retail_uom_quantity_to_parent;
                }

                // التأكد من أن الباتش يحتوي على الكمية المراد خصمها
                if ($batch->quantity < $quantity_retail) {
                    throw new \Exception(
                        'لا يمكن حذف الفاتورة؛ كمية الباتش الحالية أقل من الكمية المطلوب خصمها للصنف رقم: '
                        . $detail->item_code
                    );
                }

                // الكميات قبل الحركة
                $quantityBeforeAllStores = InvItemBatch::where(
                    'item_code',
                    $detail->item_code
                )->where('com_code', $com_code)->sum('quantity');

                $quantityBeforeStore = InvItemBatch::where(
                    'item_code',
                    $detail->item_code
                )->where('store_id', $Supplier->store_id)
                    ->where('com_code', $com_code)
                    ->sum('quantity');

                // خصم كمية المشتريات من الباتش
                $batch->quantity -= $quantity_retail;

                $batch->total_cost_price =
                    $batch->quantity * $batch->unit_cost_price;

                $batch->updated_by = $admin_id;
                $batch->save();

                // الكميات بعد الحركة
                $quantityAfterAllStores =
                    $quantityBeforeAllStores - $quantity_retail;

                $quantityAfterStore =
                    $quantityBeforeStore - $quantity_retail;

                // تسجيل حركة الصنف
                InvItem_card_Movement::create([
                    'inv_itemcard_movements_categories' => 1,
                    'item_code' => $detail->item_code,
                    'items_movements_types' => 1,
                    'FK_table' => $Supplier->auto_serial,
                    'FK_table_details' =>
                        'حذف فاتورة مشتريات رقم: ' . $Supplier->doc_no,
                    'byan' =>
                        'خصم كمية الصنف من الخزن بسبب حذف فاتورة المشتريات',
                    'added_by' => $admin_id,
                    'date' => date('Y-m-d'),
                    'com_code' => $com_code,
                    'store_id' => $Supplier->store_id,
                    'quantity_befor_movement' =>
                        $quantityBeforeAllStores,
                    'quantity_after_move' =>
                        $quantityAfterAllStores,
                    'quantity_befor_move_store' =>
                        $quantityBeforeStore,
                    'quantity_after_move_store' =>
                        $quantityAfterStore,
                ]);

                // حذف تفاصيل الصنف
                $detail->delete();
            }

            // حذف فاتورة المشتريات بعد معالجة جميع الأصناف
            $Supplier->delete();
        });

        return redirect()->route('SupplierWithOrder.index')
            ->with([
                'success' =>
                    'تم حذف فاتورة المشتريات وأصنافها وخصم الكميات من الباتشات وتسجيل الحركات بنجاح'
            ]);

    } catch (\Throwable $e) {
        return redirect()->back()
            ->with([
                'error' => 'تعذر حذف فاتورة المشتريات: ' . $e->getMessage()
            ]);
    }
}


//اضافه اصناف
public function add_new_details(Request $request)
{
    $com_code = auth()->guard('admin')->user()->com_code;
    $item = ItemCard::where('item_code', $request->item_code_add)->first();

    if(!$item){
        return back()->with('error','لاتوجد بيانات للصنف');
    }

    // تحديد هل الوحدة رئيسية أو تجزئة
    $isMain = ($request->unit_data == $item->uom_id) ? 1 : 0;

    // إذا يوجد detail_id يعني تعديل
    if($request->detail_id)
    {
        $detail = Suppliers_with_orders_details::find($request->detail_id);

        if(!$detail){
            return back()->with('error','الصنف غير موجود');
        }

        $detail->update([
            'item_code' => $request->item_code_add,
            'delivery_quantity' => $request->delivery_quantity,
            'unit_id' => $request->unit_data,
            'is_main_or_retail_uom' => $isMain,
            'unit_price' => $request->price_add,
            'total_price' => $request->total_add,
            'production_date' => $request->production_date,
            'expir_date' => $request->expir_date,
            'updated_by' => auth()->guard('admin')->id(),
        ]);

        // تحديث إجمالي الفاتورة
        $totalCost = Suppliers_with_orders_details::where(
            'auto_serial_suppliers_with_orders',
            $detail->auto_serial_suppliers_with_orders
        )->sum('total_price');

        SupplierWithOrder::where(
            'auto_serial',
            $detail->auto_serial_suppliers_with_orders
        )->update([
            'total_cost'=>$totalCost
        ]);

        return redirect()->back()
            ->with('success','تم تعديل الصنف بنجاح');
    }

    // إذا لا يوجد detail_id يعني إضافة جديدة
    $detail = Suppliers_with_orders_details::create([
        'auto_serial_suppliers_with_orders' => $request->auto_serial,
        'order_type' => 1,
        'item_code' => $request->item_code_add,
        'delivery_quantity' => $request->delivery_quantity,
        'unit_id' => $request->unit_data,
        'is_main_or_retail_uom' => $isMain,
        'unit_price' => $request->price_add,
        'total_price' => $request->total_add,
        'order_date' => $request->order_date,
        'production_date' => $request->production_date,
        'expir_date' => $request->expir_date,
        'batch_id' => 0,
        'com_code' => $com_code,
        'added_by' => auth()->guard('admin')->id(),
        'updated_by' => auth()->guard('admin')->id(),
    ]);

    // بعد حفظ تفاصيل الفاتورة ننشئ الباتش
    $order = SupplierWithOrder::where(
        'auto_serial',
        $request->auto_serial
    )->first();

    // جلب بيانات الصنف
    $item = ItemCard::where(
        'item_code',
        $request->item_code_add
    )->first();
    $batch_uom_id = !empty($item->retail_uom)
    ? $item->retail_uom
    : $item->uom_id;

    // تحويل الكمية إلى الوحدة الصغرى (Retail)
    $quantity_retail = $request->delivery_quantity;

    // إذا دخل المستخدم بالوحدة الأب (كرتون)
    if($request->unit_data == $item->uom_id){

        // كرتون × عدد الحبات
        $quantity_retail =
            $request->delivery_quantity * $item->retail_uom_quantity_to_parent;
    }

    // إذا دخل المستخدم بالحبة تبقى كما هي
    elseif($request->unit_data == $item->retail_uom){

        $quantity_retail = $request->delivery_quantity;
    }

    // =====================================================
    // قبل الحركة
    // =====================================================

    // كمية الصنف في جميع المخازن قبل الحركة
    $quantityBeforeAllStores = InvItemBatch::where(
        'item_code',
        $request->item_code_add
    )
    ->where(
        'com_code',
        $com_code
    )
    ->sum('quantity');

    // كمية الصنف في المخزن الحالي قبل الحركة
    $quantityBeforeStore = InvItemBatch::where(
        'item_code',
        $request->item_code_add
    )
    ->where(
        'store_id',
        $order->store_id
    )
    ->where(
        'com_code',
        $com_code
    )
    ->sum('quantity');

    // البحث عن الباتش الموجود بنفس الصنف والسعر وتاريخ الانتهاء
    $batch = InvItemBatch::where('store_id', $order->store_id)
        ->where('item_code', $request->item_code_add)
        ->where('inv_uoms_id', $batch_uom_id)
        ->where('unit_cost_price', $request->price_add)
        ->where('expire_date', $request->expir_date)
        ->first();




// البحث عن الباتش الموجود بنفس الصنف والسعر وتاريخ الانتهاء
$batch = InvItemBatch::where('store_id', $order->store_id)
    ->where('item_code', $request->item_code_add)
    ->where('inv_uoms_id', $item->retail_uom)
    ->where('unit_cost_price', $request->price_add)
    ->where('expire_date', $request->expir_date)
    ->where('com_code', $com_code)
    ->first();

if ($batch) {

    // تحديث كمية الباتش الموجود
    $batch->quantity += $quantity_retail;

    // تحديث إجمالي التكلفة
    $batch->total_cost_price += $request->total_add;

    $batch->updated_by = auth()->guard('admin')->id();

    $batch->save();

} else {

    // إنشاء باتش جديد
    $batch_serial = (InvItemBatch::max('auto_serial') ?? 0) + 101;

    $batch = InvItemBatch::create([
        'store_id' => $order->store_id,
        'item_code' => $request->item_code_add,
        'inv_uoms_id' => $batch_uom_id,
        'unit_cost_price' => $request->price_add,
        'quantity' => $quantity_retail,
        'total_cost_price' => $request->total_add,
        'production_date' => $request->production_date,
        'expire_date' => $request->expir_date,
        'auto_serial' => $batch_serial,
        'is_send_archif' => 0,
        'added_by' => auth()->guard('admin')->id(),
        'updated_by' => auth()->guard('admin')->id(),
        'com_code' => $com_code,
    ]);
}

// ربط تفاصيل الفاتورة برقم الباتش الفعلي
$detail->batch_id = $batch->auto_serial;
$detail->save();


    // =====================================================
    // بعد الحركة
    // =====================================================

    $quantityAfterAllStores =
        $quantityBeforeAllStores + $quantity_retail;

    $quantityAfterStore =
        $quantityBeforeStore + $quantity_retail;


    $supplier = Supplier::where(
        'id',
        $order->supplier_id
    )->first();

    // لجلب رقم الفاتورة
    $order = SupplierWithOrder::where(
        'auto_serial',
        $request->auto_serial
    )->first();

    // =====================================================
    // تسجيل حركة الصنف
    // =====================================================

    InvItem_card_Movement::create([

        'inv_itemcard_movements_categories' => 1,//شراء

        'item_code' =>$request->item_code_add ,

        'items_movements_types' => 1,

        'FK_table' => $request->auto_serial,

        'FK_table_details' =>
            'رقم الفاتوره المورد :'.':'. $order->doc_no,

        'byan' =>
            'إضافة صنف من فاتورة شراء للمورد: ' .
            $supplier->name,

        'added_by' =>
            auth()->guard('admin')->id(),

        'date' =>
            date('Y-m-d'),

        'com_code' =>
            $com_code,

        'store_id' =>
            $order->store_id,

        // جميع المخازن
        'quantity_befor_movement' =>
            $quantityBeforeAllStores,

        'quantity_after_move' =>
            $quantityAfterAllStores,

        // المخزن الحالي
        'quantity_befor_move_store' =>
            $quantityBeforeStore,

        'quantity_after_move_store' =>
            $quantityAfterStore,
    ]);

    $totalCost = Suppliers_with_orders_details::where(
        'auto_serial_suppliers_with_orders',
        $request->auto_serial
    )->sum('total_price');

    SupplierWithOrder::where(
        'auto_serial',
        $request->auto_serial
    )->update([
        'total_cost'=>$totalCost
    ]);

    return redirect()->back()
        ->with('success','تم إضافة الصنف للفاتورة بنجاح');
}
    // تعديل الصنف
    public function editdetail(string $id)
{
    $data = Suppliers_with_orders_details::find($id);
    $items = ItemCard::where('com_code', auth()->guard('admin')->user()->com_code)->get();
    $units = Inv_uom::where('com_code', auth()->guard('admin')->user()->com_code)->where('active',1)->get();
    return view('admin.supplier_With_Order.editdetail', compact(
        'data',
        'items',
        'units'
    ));
    }
    // تحديث الصنف يعد التعديب
    public function updateDetail(SuppliersWithOrderDetailRequest $request, $id)
{
    $detail = Suppliers_with_orders_details::findOrFail($id);
    $detail->item_code = $request->item_code;
    $detail->unit_id = $request->unit_id;
    $detail->delivery_quantity = $request->delivery_quantity;
    $detail->unit_price = $request->unit_price;
    // حساب الإجمالي تلقائياً
    $detail->total_price = $request->delivery_quantity * $request->unit_price;
    $detail->production_date = $request->production_date;
    $detail->expir_date = $request->expir_date;
    // تحديد هل الوحدة رئيسية أم تجزئة
    $item = ItemCard::where('item_code', $request->item_code)->first();
    if ($item) {
        $detail->is_main_or_retail_uom =
            ($request->unit_id == $item->uom_id) ? 1 : 0;
            }
            $detail->updated_by = auth()->guard('admin')->id();
            $detail->save();
    // إعادة حساب إجمالي الفاتورة
    $totalCost = Suppliers_with_orders_details::where(
        'auto_serial_suppliers_with_orders',
        $detail->auto_serial_suppliers_with_orders
    )->sum('total_price');
    SupplierWithOrder::where(
        'auto_serial',
        $detail->auto_serial_suppliers_with_orders
    )->update([
        'total_cost' => $totalCost
    ]);
      $order = SupplierWithOrder::where('auto_serial',$detail->auto_serial_suppliers_with_orders)->first();
return redirect()->route('SupplierWithOrder.show', $order->id)->with('success', 'تم تعديل الصنف بنجاح');
}
// حذف الصنف

public function destroyDetail($id)
{
    $com_code = auth()->guard('admin')->user()->com_code;

    $detail = Suppliers_with_orders_details::find($id);

    if (!$detail) {
        return redirect()->back()->with('error', 'الصنف غير موجود');
    }

    // جلب الفاتورة
    $auto_serial = $detail->auto_serial_suppliers_with_orders;

    $order = SupplierWithOrder::where('auto_serial', $auto_serial)
        ->where('com_code', $com_code)
        ->first();

    if (!$order) {
        return redirect()->back()->with('error', 'الفاتورة غير موجودة');
    }

    // جلب الصنف
    $item = ItemCard::where('item_code', $detail->item_code)->first();

    if (!$item) {
        return redirect()->back()->with('error', 'بيانات الصنف غير موجودة');
    }

    // جلب الباتش المرتبط بتفاصيل الفاتورة
    $batch = InvItemBatch::where('auto_serial', $detail->batch_id)
        ->where('store_id', $order->store_id)
        ->where('item_code', $detail->item_code)
        ->where('com_code', $com_code)
        ->first();

    if (!$batch) {
        return redirect()->back()->with(
            'error',
            'الباتش المرتبط بالصنف غير موجود، لم يتم حذف الصنف'
        );
    }

    // تحويل الكمية إلى الوحدة الصغرى (التجزئة)
    $quantity_retail = $detail->delivery_quantity;

    if ($detail->unit_id == $item->uom_id) {
        $quantity_retail *= $item->retail_uom_quantity_to_parent;
    }

    // التأكد من أن الباتش يحتوي على الكمية المراد خصمها
    if ($batch->quantity < $quantity_retail) {
        return redirect()->back()->with(
            'error',
            'لا يمكن حذف الصنف لأن كمية الباتش الحالية أقل من الكمية المسجلة في الفاتورة'
        );
    }

    // الكميات قبل الحركة
    $quantityBeforeAllStores = InvItemBatch::where(
        'item_code',
        $detail->item_code
    )->where('com_code', $com_code)->sum('quantity');

    $quantityBeforeStore = InvItemBatch::where(
        'item_code',
        $detail->item_code
    )->where('store_id', $order->store_id)
        ->where('com_code', $com_code)->sum('quantity');

    // خصم الكمية من نفس الباتش
    $batch->quantity -= $quantity_retail;
    $batch->total_cost_price = $batch->quantity * $batch->unit_cost_price;
    $batch->updated_by = auth()->guard('admin')->id();
    $batch->save();

    // الكميات بعد الحركة
    $quantityAfterAllStores = $quantityBeforeAllStores - $quantity_retail;
    $quantityAfterStore = $quantityBeforeStore - $quantity_retail;

    // تسجيل حركة عكس المشتريات
    InvItem_card_Movement::create([
        'inv_itemcard_movements_categories' => 1,
        'item_code' => $detail->item_code,
        'items_movements_types' => 1,
        'FK_table' => $auto_serial,
        'FK_table_details' => 'حذف صنف من فاتورة المشتريات رقم: ' . $order->doc_no,
        'byan' => 'خصم كمية الصنف من الخزن بسبب حذف تفاصيل فاتورة المشتريات',
        'added_by' => auth()->guard('admin')->id(),
        'date' => date('Y-m-d'),
        'com_code' => $com_code,
        'store_id' => $order->store_id,
        'quantity_befor_movement' => $quantityBeforeAllStores,
        'quantity_after_move' => $quantityAfterAllStores,
        'quantity_befor_move_store' => $quantityBeforeStore,
        'quantity_after_move_store' => $quantityAfterStore,
    ]);

    // حذف تفاصيل الصنف
    $detail->delete();

    // إعادة حساب إجمالي الفاتورة
    $totalCost = Suppliers_with_orders_details::where(
        'auto_serial_suppliers_with_orders',
        $auto_serial
    )->sum('total_price');

    SupplierWithOrder::where('auto_serial', $auto_serial)
        ->where('com_code', $com_code)
        ->update([
            'total_cost' => $totalCost
        ]);

    return redirect()->back()->with(
        'success',
        'تم حذف الصنف وخصم كميته من الباتش بنجاح'
    );
}



/**داله اعتماد الفاتوره */
public function load_approve_invoice(Request $request){
   $data = SupplierWithOrder::with('treasurie')
    ->find($request->id);
return view('admin.supplier_With_Order.load_approve_invoice', compact('data'));
}
// الاعتماد المشتريات
public function approve_invoice(Request $request, $id)
{
    $com_code = auth()->guard('admin')->user()->com_code;
    $admin_id = auth()->guard('admin')->id();

    $data = SupplierWithOrder::find($id);

    if (!$data) {
        return redirect()->back()
            ->with('error', 'الفاتورة غير موجودة');
    }

    if ($data->is_approved == 1) {
        return redirect()->back()
            ->with('error', 'تم اعتماد هذه الفاتورة من قبل');
    }

    // جلب المورد
    $supplier = Supplier::find($data->supplier_id);

    if (!$supplier) {
        return redirect()->back()
            ->with('error', 'بيانات المورد غير موجودة');
    }

    // الحساب المالي للمورد
    $accauont = Accauont::where(
        'accauont_number',
        $supplier->account_number
    )->first();

    if (!$accauont) {
        return redirect()->back()
            ->with(
                'error',
                'رقم الحساب المالي للمورد غير موجود في شجرة الحسابات'
            );
    }

    // ==============================
    // التحقق من الشفت
    // ==============================

    $adminShift = Admin_Shift::where('com_code', $com_code)
        ->where('admin_id', $admin_id)
        ->where('is_finished', 0)
        ->with('treasuriesname')
        ->first();

    if (!$adminShift) {
        return redirect()->back()
            ->with(
                'error',
                'لا يوجد شفت مفتوح، برجاء فتح شفت أولاً'
            );
    }

    $treasury = $adminShift->treasuriesname;

    if (!$treasury) {
        return redirect()->back()
            ->with(
                'error',
                'لا توجد خزنة مرتبطة بالشفت الحالي'
            );
    }

    // ==============================
    // رصيد الخزنة
    // ==============================

    $currentBalance = TreasuriesTransaction::where(
        'treasuries_id',
        $treasury->id
    )->sum('money');

    if ($currentBalance <= 0) {
        return redirect()->back()
            ->with(
                'error',
                'رصيد الخزنة صفر، لا يمكن اعتماد الفاتورة'
            );
    }

    // ==============================
    // المبلغ المدفوع
    // ==============================

    $paidAmount = $request->paid ?? 0;

    if ($paidAmount > $currentBalance) {
        return redirect()->back()
            ->with(
                'error',
                'مبلغ الاعتماد أكبر من رصيد الخزنة المتاح'
            );
    }

    DB::transaction(function () use (
        $data,
        $supplier,
        $accauont,
        $treasury,
        $adminShift,
        $paidAmount,
        $request,
        $admin_id
    ) {

        // =====================================================
        // حركة الخزينة
        // =====================================================

        $lastSerial =
            TreasuriesTransaction::max('auto_serial') ?? 0;

        $lisalnumber =
            TreasuriesTransaction::max('isal_number') ?? 0;

        TreasuriesTransaction::create([

            'treasuries_id' =>
                $treasury->id,

            'auto_serial' =>
                $lastSerial + 1,

            'isal_number' =>
                $lisalnumber + 1,

            'mov_type' =>
                9,

            'the_forign_key' =>
                $data->id,

            'accauont_number' =>
                $accauont->id,

            'is_accauont' =>
                1,

            'is_Approved' =>
                1,

            'admin_shift_id' =>
                $adminShift->id,

            'money' =>
                -1 * $paidAmount,

            'money_for_accauont' =>
                $request->remain,

            'added_by' =>
                $admin_id,

            'updated_by' =>
                $admin_id,

            'move_date' =>
                date('Y-m-d'),

            'bayan' =>
                'اعتماد فاتورة مشتريات رقم ' . $data->id,

            'com_code' =>
                $data->com_code,
        ]);


        // =====================================================
        // تحديث حساب المورد
        // =====================================================

        $balanceBefore =
            $accauont->current_balance ?? 0;

        $balanceAfter =
            $balanceBefore - $request->remain;

        $accauont->current_balance =
            $balanceAfter;

        $accauont->save();


        // =====================================================
        // تحديث الأصناف
        // =====================================================

        $details = Suppliers_with_orders_details::where(
            'auto_serial_suppliers_with_orders',
            $data->auto_serial
        )->get();


        foreach ($details as $detail) {

            // جلب الصنف
            $item = ItemCard::where(
                'item_code',
                $detail->item_code
            )
                ->where(
                    'com_code',
                    $data->com_code
                )
                ->first();


            if (!$item) {

                throw new \Exception(
                    'الصنف رقم ' .
                    $detail->item_code .
                    ' غير موجود'
                );
            }


            // =================================================
            // عدد وحدات التجزئة داخل الوحدة الأب
            // =================================================

            $conversion =
                $item->retail_uom_quantity_to_parent;


            if ($conversion <= 0) {

                throw new \Exception(
                    'الصنف ' .
                    $item->name .
                    ' لا يحتوي على عدد تجزئة صحيح'
                );
            }


            // =================================================
            // الشراء بالوحدة الأب
            // =================================================

            if ($detail->unit_id == $item->uom_id) {

                $item->coast_price =
                    $detail->unit_price;


                $item->coast_price_retail =
                    $detail->unit_price / $conversion;


                // كمية الأب
                $item->Quantity =
                    ($item->Quantity ?? 0)
                    + $detail->delivery_quantity;


                // تحويل الكمية إلى التجزئة
                $retailQuantity =
                    $detail->delivery_quantity
                    * $conversion;


                // كمية التجزئة
                $item->Quantity_retail =
                    ($item->Quantity_retail ?? 0)
                    + $retailQuantity;


                // إجمالي الكمية بالتجزئة
                $item->Quantity_all_retail =
                    ($item->Quantity_all_retail ?? 0)
                    + $retailQuantity;
            }


            // =================================================
            // الشراء بوحدة التجزئة
            // =================================================

           elseif ($detail->unit_id == $item->retail_uom) {

    // ==========================================
    // الشراء بوحدة التجزئة
    // ==========================================

    // سعر الحبة
    $item->coast_price_retail =
        $detail->unit_price;

    // سعر الكرتون
    $item->coast_price =
        $detail->unit_price * $conversion;


    // ==========================================
    // كمية التجزئة التي دخلت
    // ==========================================

    $retailQuantity =
        $detail->delivery_quantity;


    // ==========================================
    // تحويل الحبات إلى كراتين
    // ==========================================

    $parentQuantity =
        $retailQuantity / $conversion;


    // إضافة كمية الكراتين
    $item->Quantity =
        ($item->Quantity ?? 0)
        + $parentQuantity;


    // ==========================================
    // إضافة كمية الحبات
    // ==========================================

    $item->Quantity_retail =
        ($item->Quantity_retail ?? 0)
        + $retailQuantity;


    // ==========================================
    // إجمالي الحبات
    // ==========================================

    $item->Quantity_all_retail =
        ($item->Quantity_all_retail ?? 0)
        + $retailQuantity;
}


            // =================================================
            // وحدة غير صحيحة
            // =================================================

            else {

                throw new \Exception(
                    'وحدة الشراء للصنف ' .
                    $item->name .
                    ' غير صحيحة'
                );
            }


            // المستخدم الذي قام بالتحديث
            $item->updated_by =
                $admin_id;


            // حفظ الصنف
            $item->save();
        }


        // =====================================================
        // اعتماد الفاتورة
        // =====================================================

        $data->is_approved = 1;

        $data->discount_type =
            $request->discount_type;

        $data->discount_value =
            $request->discount_value;

        $data->bill_type =
            $request->bill_type;

        $data->what_paid =
            $paidAmount;

        $data->what_remain =
            $request->remain;

        $data->discount_percent =
            $request->discount_percent;

        $data->tax_percent =
            $request->tax_percent;

        $data->tax_value =
            $request->tax_value;

        $data->total_before_discount =
            $request->total_cost;

        $data->money_for_account =
            -1 * $request->remain;

        $data->order_type =
            1;

        $data->treasury_transaction_id =
            $treasury->id;

        $data->supplier_balance_before =
            $balanceBefore;

        $data->supplier_balance_after =
            $balanceAfter;

        $data->approved_by =
            $admin_id;

        $data->account_number =
            $supplier->account_number;

        $data->save();
    });


    return redirect()->back()
        ->with(
            'success',
            'تم اعتماد الفاتورة وتحديث أسعار وكميات الأصناف بنجاح'
        );
}


}
