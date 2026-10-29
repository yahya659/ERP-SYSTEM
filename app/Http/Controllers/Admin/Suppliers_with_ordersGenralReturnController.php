<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuppliersWithOrdersGenralReturnDetailRequest;
use App\Http\Requests\SuppliersWithOrdersGenralReturnRequest;
use App\Models\Accauont;
use App\Models\Admin_Shift;
use App\Models\Inv_uom;
use App\Models\ItemCard;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\InvItem_card_Movement;
use App\Models\InvItemBatch;
use App\Models\Suppliers_with_orders_details;
use App\Models\SupplierWithOrder;
use App\Models\TreasuriesTransaction;
use App\Models\Treasury;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class Suppliers_with_ordersGenralReturnController extends Controller
{

public function index()
{
    $com_code = auth()->guard('admin')->user()->com_code;

    $data = SupplierWithOrder::with('supplier')
        ->where('order_type', 3)
        ->where('com_code', $com_code)
        ->orderBy('id', 'DESC')
        ->paginate(PAGINATION_COUNT);

    return view('admin.Suppliers_with_ordersGenralReturn.index', compact('data'));
}
public function search(Request $request)
{
    $query = SupplierWithOrder::with('supplier')->where('order_type', 3)->orderBy('id', 'DESC');
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
        'admin.Suppliers_with_ordersGenralReturn.index',
        compact('data')
    );
}
public function create()
    {
        $supplier=Supplier::all();
        $store=Store::all();
         return view('admin.Suppliers_with_ordersGenralReturn.create',compact('supplier','store'));

    }


public function store(SuppliersWithOrdersGenralReturnRequest $request)
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
    'order_type' => 3,
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
          return redirect()->route('suppliers_with_ordersGenralReturn.index')->with('success', 'تم إضافة المرتجع وصرفه للمخزن    بنجاح');


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
          return view('admin.suppliers_with_ordersGenralReturn.show',compact('data','item_cards','adminsift','treasuriesBalance'));
    }
public function edit(string $id)
{
    $data = SupplierWithOrder::find($id);

    $supplier = Supplier::all();

    $store = Store::all();

    return view('admin.suppliers_with_ordersGenralReturn.edit', compact(
        'data',
        'supplier',
        'store'
    ));
}
public function update($id, SuppliersWithOrdersGenralReturnRequest $request)
{
    $com_code = auth()->guard('admin')->user()->com_code;

    $data = SupplierWithOrder::find($id);

    $data->fill([
        'supplier_id' => $request->supplier_id,
        'order_date' => $request->order_date,
        'store_id' => $request->store_id,
        'bill_type' => $request->bill_type,
        'notes' => $request->notes,
        'updated_by' => auth()->guard('admin')->id(),
        'com_code' => $com_code,
    ]);
    // التحقق هل تغيرت بيانات أم لا
    if (!$data->isDirty()) {
        return redirect()
            ->route('suppliers_with_ordersGenralReturn.index')
            ->with('error', 'لم تقوم بتعديل المرتجع ');
    }
    $data->save();
    return redirect()
        ->route('suppliers_with_ordersGenralReturn.index')
        ->with('success','تم تعديل المرتجع ');
}

public function destroy(string $id)
{
    $com_code = auth()->guard('admin')->user()->com_code;
    $admin_id = auth()->guard('admin')->id();

    // جلب فاتورة المرتجع
    $Supplier = SupplierWithOrder::where('id', $id)
        ->where('com_code', $com_code)
        ->first();

    if (!$Supplier) {
        return redirect()->route('suppliers_with_ordersGenralReturn.index')
            ->with(['error' => 'فاتورة المرتجع غير موجودة']);
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

                // جلب الباتش المرتبط بتفاصيل المرتجع
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

                // إذا كان الباتش موجودًا، نرجع الكمية إليه
                if ($batch && $item) {

                    // تحويل الكمية إلى الوحدة الصغرى (التجزئة)
                    $quantity_retail = $detail->delivery_quantity;

                    if ($detail->unit_id == $item->uom_id) {
                        $quantity_retail *=
                            $item->retail_uom_quantity_to_parent;
                    }

                    // الكمية قبل الحركة
                    $quantityBeforeAllStores = InvItemBatch::where(
                        'item_code',
                        $detail->item_code
                    )->where('com_code', $com_code)
                        ->sum('quantity');

                    $quantityBeforeStore = InvItemBatch::where(
                        'item_code',
                        $detail->item_code
                    )->where('store_id', $Supplier->store_id)
                        ->where('com_code', $com_code)
                        ->sum('quantity');

                    // إعادة الكمية إلى الباتش
                    $batch->quantity += $quantity_retail;

                    $batch->total_cost_price =
                        $batch->quantity * $batch->unit_cost_price;

                    $batch->updated_by = $admin_id;
                    $batch->save();

                    // الكمية بعد الحركة
                    $quantityAfterAllStores =
                        $quantityBeforeAllStores + $quantity_retail;

                    $quantityAfterStore =
                        $quantityBeforeStore + $quantity_retail;

                    // تسجيل حركة الصنف
                    InvItem_card_Movement::create([
                        'inv_itemcard_movements_categories' => 1,
                        'item_code' => $detail->item_code,
                        'items_movements_types' => 1,
                        'FK_table' => $Supplier->auto_serial,
                        'FK_table_details' =>
                            'حذف فاتورة مرتجع رقم: ' . $Supplier->doc_no,
                        'byan' =>
                            'إعادة كمية الصنف إلى الباتش بسبب حذف فاتورة المرتجع',
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
                }

                // حذف تفاصيل الصنف
                $detail->delete();
            }

            // حذف فاتورة المرتجع بعد معالجة جميع الأصناف
            $Supplier->delete();
        });

        return redirect()->route('suppliers_with_ordersGenralReturn.index')
            ->with([
                'success' => 'تم حذف فاتورة المرتجع وأصنافها وإرجاع الكميات إلى الباتشات وتسجيل الحركات بنجاح'
            ]);

    } catch (\Throwable $e) {
        return redirect()->back()
            ->with([
                'error' => 'تعذر حذف فاتورة المرتجع: ' . $e->getMessage()
            ]);
    }
}
//اضافه اصناف

public function add_new_details(Request $request)
{
    $com_code = auth()->guard('admin')->user()->com_code;

    $item = ItemCard::where('item_code', $request->item_code_add)->first();

    if (!$item) {
        return back()->with('error', 'لاتوجد بيانات للصنف');
    }

    $isMain = ($request->unit_data == $item->uom_id) ? 1 : 0;

    // إذا يوجد detail_id يعني تعديل
    if ($request->detail_id) {
        $detail = Suppliers_with_orders_details::find($request->detail_id);

        if (!$detail) {
            return back()->with('error', 'الصنف غير موجود');
        }

        $detail->update([
            'item_code' => $request->item_code_add,
            'delivery_quantity' => $request->delivery_quantity,
            'unit_id' => $request->unit_data,
            'is_main_or_retail_uom' => $isMain,
            'unit_price' => $request->price_add,
            'total_price' => $request->total_add,
            // 'production_date' => $request->production_date,
            // 'expir_date' => $request->expir_date,
            'updated_by' => auth()->guard('admin')->id(),
        ]);

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

        return redirect()->back()->with('success', 'تم تعديل الصنف بنجاح');
    }

    // جلب الفاتورة
    $order = SupplierWithOrder::where('auto_serial', $request->auto_serial)
        ->where('com_code', $com_code)
        ->first();

    if (!$order) {
        return back()->with('error', 'فاتورة المرتجع غير موجودة');
    }

    // جلب الباتش المختار والتحقق من أنه تابع للصنف والخزن
    $batch = InvItemBatch::where('auto_serial', $request->batch_id)
        ->where('store_id', $order->store_id)
        ->where('item_code', $request->item_code_add)
        ->where('com_code', $com_code)
        ->where('quantity', '>', 0)
        ->first();

    if (!$batch) {
        return back()->with('error', 'الباتش المحدد غير موجود أو كميته صفر');
    }

    // تحويل الكمية إلى الوحدة الصغرى
    $quantity_retail = $request->delivery_quantity;

    if ($request->unit_data == $item->uom_id) {
        $quantity_retail =
            $request->delivery_quantity * $item->retail_uom_quantity_to_parent;
    } elseif ($request->unit_data == $item->retail_uom) {
        $quantity_retail = $request->delivery_quantity;
    }

    if ($quantity_retail <= 0) {
        return back()->with('error', 'الكمية يجب أن تكون أكبر من صفر');
    }

    if ($quantity_retail > $batch->quantity) {
        return back()->with('error', 'الكمية المطلوبة أكبر من الكمية الموجودة في الباتش');
    }

    // السعر محفوظ في الباتش على مستوى الوحدة الصغرى
  $unitPrice = $batch->unit_cost_price;
$totalPrice = $request->delivery_quantity * $unitPrice;
    // التواريخ من الباتش المختار
    $productionDate = $batch->production_date;
    $expiryDate = $batch->expire_date;

    // قبل الحركة
    $quantityBeforeAllStores = InvItemBatch::where(
        'item_code',
        $request->item_code_add
    )->where('com_code', $com_code)->sum('quantity');

    $quantityBeforeStore = InvItemBatch::where(
        'item_code',
        $request->item_code_add
    )->where('store_id', $order->store_id)
        ->where('com_code', $com_code)->sum('quantity');

    // حفظ تفاصيل المرتجع مع رقم الباتش الصحيح
    $detail = Suppliers_with_orders_details::create([
        'auto_serial_suppliers_with_orders' => $request->auto_serial,
        'order_type' => 3,
        'item_code' => $request->item_code_add,
        'delivery_quantity' => $request->delivery_quantity,
        'unit_id' => $request->unit_data,
        'is_main_or_retail_uom' => $isMain,
        'unit_price' => $unitPrice,
        'total_price' => $totalPrice,
        'order_date' => date('Y-m-d'),
        'production_date' => $productionDate,
        'expir_date' => $expiryDate,
        'batch_id' => $batch->auto_serial,
        'com_code' => $com_code,
        'added_by' => auth()->guard('admin')->id(),
        'updated_by' => auth()->guard('admin')->id(),
    ]);

    // خصم الكمية مباشرة من الباتش المختار
    $batch->quantity -= $quantity_retail;
    $batch->total_cost_price = $batch->quantity * $batch->unit_cost_price;
    $batch->updated_by = auth()->guard('admin')->id();
    $batch->save();

    // بعد الحركة
    $quantityAfterAllStores = $quantityBeforeAllStores - $quantity_retail;
    $quantityAfterStore = $quantityBeforeStore - $quantity_retail;

    $supplier = Supplier::where('id', $order->supplier_id)->first();

    // تسجيل حركة المرتجع
    InvItem_card_Movement::create([
        'inv_itemcard_movements_categories' => 3,
        'item_code' => $request->item_code_add,
        'items_movements_types' => 3,
        'FK_table' => $request->auto_serial,
        'FK_table_details' => 'رقم فاتورة مرتجع المورد: ' . $order->doc_no,
        'byan' => 'إرجاع صنف إلى المورد: ' . ($supplier->name ?? ''),
        'added_by' => auth()->guard('admin')->id(),
        'date' => date('Y-m-d'),
        'com_code' => $com_code,
        'store_id' => $order->store_id,
        'quantity_befor_movement' => $quantityBeforeAllStores,
        'quantity_after_move' => $quantityAfterAllStores,
        'quantity_befor_move_store' => $quantityBeforeStore,
        'quantity_after_move_store' => $quantityAfterStore,
    ]);

    // تحديث إجمالي الفاتورة
    $totalCost = Suppliers_with_orders_details::where(
        'auto_serial_suppliers_with_orders',
        $request->auto_serial
    )->sum('total_price');

    SupplierWithOrder::where('auto_serial', $request->auto_serial)
        ->update([
            'total_cost' => $totalCost
        ]);

    return redirect()->back()->with('success', 'تم إضافة صنف المرتجع بنجاح');
}

// جلب الفاتوره من الباتش


public function getItemBatches($item_code)
{
    $com_code = auth()->guard('admin')->user()->com_code;

    $auto_serial = request()->query('auto_serial');

    $order = SupplierWithOrder::where('auto_serial', $auto_serial)
        ->where('com_code', $com_code)
        ->first();

    if (!$order) {
        return response()->json([
            'success' => false,
            'message' => 'الفاتورة غير موجودة'
        ], 404);
    }

    $batches = InvItemBatch::with('invuomsid')
        ->where('store_id', $order->store_id)
        ->where('item_code', $item_code)
        ->where('com_code', $com_code)
        ->where('quantity', '>', 0)
        ->orderBy('auto_serial', 'desc')
        ->get()
        ->map(function ($batch) {
            return [
                'auto_serial' => $batch->auto_serial,
                'quantity' => $batch->quantity,
                'unit_cost_price' => $batch->unit_cost_price,
                'production_date' => $batch->production_date,
                'expire_date' => $batch->expire_date,
                'inv_uoms_id' => $batch->inv_uoms_id,
                'unit_name' => $batch->invuomsid->name ?? 'غير محددة',
            ];
        });

    return response()->json([
        'success' => true,
        'batches' => $batches
    ]);
}

    // تعديل الصنف
    public function editdetail(string $id)
{
    $data = Suppliers_with_orders_details::find($id);
    $items = ItemCard::where('com_code', auth()->guard('admin')->user()->com_code)->get();
    $units = Inv_uom::where('com_code', auth()->guard('admin')->user()->com_code)->where('active',1)->get();
    return view('admin.Suppliers_with_ordersGenralReturn.editdetail', compact(
        'data',
        'items',
        'units'
    ));
    }
     // تحديث الصنف يعد التعديل
    public function updateDetail(SuppliersWithOrdersGenralReturnDetailRequest $request, $id)
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
return redirect()
    ->route('suppliers_with_ordersGenralReturn.show', $order->id)
    ->with('success', 'تم تعديل الصنف المرتجع بنجاح');
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
    $order = SupplierWithOrder::where(
        'auto_serial',
        $detail->auto_serial_suppliers_with_orders
    )->where('com_code', $com_code)->first();

    if (!$order) {
        return redirect()->back()->with('error', 'الفاتورة غير موجودة');
    }

    // جلب الباتش الأصلي الذي خُصمت منه الكمية
    $batch = InvItemBatch::where(
        'auto_serial',
        $detail->batch_id
    )->where('store_id', $order->store_id)
        ->where('item_code', $detail->item_code)
        ->where('com_code', $com_code)
        ->first();

    if (!$batch) {
        return redirect()->back()->with(
            'error',
            'الباتش الأصلي غير موجود، لم يتم حذف الصنف'
        );
    }

    // تحويل الكمية إلى الوحدة الصغرى (التجزئة)
    $item = ItemCard::where(
        'item_code',
        $detail->item_code
    )->first();

    if (!$item) {
        return redirect()->back()->with('error', 'بيانات الصنف غير موجودة');
    }

    $quantity_retail = $detail->delivery_quantity;

    if ($detail->unit_id == $item->uom_id) {
        $quantity_retail *= $item->retail_uom_quantity_to_parent;
    }

    // الكميات قبل إعادة الصنف
    $quantityBeforeAllStores = InvItemBatch::where(
        'item_code',
        $detail->item_code
    )->where('com_code', $com_code)->sum('quantity');

    $quantityBeforeStore = InvItemBatch::where(
        'item_code',
        $detail->item_code
    )->where('store_id', $order->store_id)
        ->where('com_code', $com_code)->sum('quantity');

    // إعادة الكمية إلى نفس الباتش
    $batch->quantity += $quantity_retail;
    $batch->total_cost_price = $batch->quantity * $batch->unit_cost_price;
    $batch->updated_by = auth()->guard('admin')->id();
    $batch->save();

    // الكميات بعد إعادة الصنف
    $quantityAfterAllStores = $quantityBeforeAllStores + $quantity_retail;
    $quantityAfterStore = $quantityBeforeStore + $quantity_retail;

    // تسجيل حركة إعادة الصنف إلى الخزن
    InvItem_card_Movement::create([
        'inv_itemcard_movements_categories' => 1,
        'item_code' => $detail->item_code,
        'items_movements_types' => 13,
        'FK_table' => $order->auto_serial,
        'FK_table_details' => 'حذف صنف من فاتورة مرتجع المورد رقم: ' . $order->doc_no,
        'byan' => 'إعادة كمية الصنف إلى الخزن بعد حذفها من تفاصيل المرتجع',
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
    $auto_serial = $detail->auto_serial_suppliers_with_orders;
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
        'تم حذف الصنف وإعادة كميته إلى الباتش بنجاح'
    );
}

/**داله اعتماد الفاتوره المرتجع  */
public function load_approve_invoice(Request $request){
   $data = SupplierWithOrder::with('treasurie')
    ->find($request->id);
return view('admin.Suppliers_with_ordersGenralReturn.load_approve_invoice', compact('data'));
}
// االاعتماد المرتجع

public function approve_invoice(Request $request, $id)
{
    $com_code = auth()->guard('admin')->user()->com_code;
    $admin_id = auth()->guard('admin')->id();

    $data = SupplierWithOrder::where('id', $id)
        ->where('com_code', $com_code)
        ->first();

    if (!$data) {
        return redirect()->back()->with('error', 'الفاتورة غير موجودة');
    }

    if ($data->is_approved == 1) {
        return redirect()->back()->with('error', 'تم اعتماد هذه الفاتورة من قبل');
    }

    $supplier = Supplier::find($data->supplier_id);

    if (!$supplier) {
        return redirect()->back()->with('error', 'بيانات المورد غير موجودة');
    }

    $accauont = Accauont::where(
        'accauont_number',
        $supplier->account_number
    )->first();

    if (!$accauont) {
        return redirect()->back()->with(
            'error',
            'رقم الحساب المالي للمورد غير موجود في شجرة الحسابات'
        );
    }

    $request->validate([
        'paid' => 'required|numeric|min:0',
        'remain' => 'required|numeric|min:0',
        'total_cost' => 'required|numeric|min:0',
        'bill_type' => 'required|in:0,1',
    ]);


$billType = (int) $request->bill_type;
$totalAmount = (float) $request->total_cost;

if ($billType === 1) {
    // مرتجع نقدي
    $paidAmount = $totalAmount;
    $remainAmount = 0;
} elseif ($billType === 0) {
    // مرتجع آجل
    $paidAmount = 0;
    $remainAmount = $totalAmount;
} else {
    return redirect()->back()
        ->withInput()
        ->with('error', 'نوع المرتجع غير صحيح');
}

    $adminShift = null;
    $treasury = null;

    // الشفت والخزنة مطلوبان عند استلام المبلغ نقداً فقط
    if ($billType == 1) {
        $adminShift = Admin_Shift::where('com_code', $com_code)
            ->where('admin_id', $admin_id)
            ->where('is_finished', 0)
            ->with('treasuriesname')
            ->first();

        if (!$adminShift) {
            return redirect()->back()->with(
                'error',
                'لا يوجد شفت مفتوح، برجاء فتح شفت أولاً'
            );
        }

        $treasury = $adminShift->treasuriesname;

        if (!$treasury) {
            return redirect()->back()->with(
                'error',
                'لا توجد خزنة مرتبطة بالشفت الحالي'
            );
        }
    }

    try {
        DB::transaction(function () use (
            $data,
            $supplier,
            $accauont,
            $adminShift,
            $treasury,
            $billType,
            $paidAmount,
            $remainAmount,
            $totalAmount,
            $request,
            $admin_id,
            $com_code
        ) {
            // منع اعتماد الفاتورة مرتين
            $invoice = SupplierWithOrder::where('id', $data->id)
                ->where('com_code', $com_code)
                ->lockForUpdate()
                ->first();

            if (!$invoice || $invoice->is_approved == 1) {
                throw new \Exception('الفاتورة غير موجودة أو معتمدة من قبل');
            }

            // جلب تفاصيل المرتجع
            $details = Suppliers_with_orders_details::where(
                'auto_serial_suppliers_with_orders',
                $invoice->auto_serial
            )->get();

            if ($details->isEmpty()) {
                throw new \Exception('لا توجد أصناف في فاتورة المرتجع');
            }

            // التأكد من وجود الأصناف
            foreach ($details as $detail) {
                $item = ItemCard::where('item_code', $detail->item_code)
                    ->where('com_code', $com_code)
                    ->first();

                if (!$item) {
                    throw new \Exception(
                        'الصنف رقم ' . $detail->item_code . ' غير موجود'
                    );
                }
            }


            // حركة الخزنة: عكس حركة المشتريات

            if ($billType == 1) {
                // سند تحصيل يزيد
                $treasury = Treasury::find($adminShift->treasuries_id);

            if ($treasury) {
                $treasury->last_isal_collection =
                    $treasury->last_isal_collection + 1;

                $treasury->save();
}
                $lastSerial =
                    TreasuriesTransaction::max('auto_serial') ?? 0;

                $lastIsalNumber =
                    TreasuriesTransaction::max('isal_number') ?? 0;

                TreasuriesTransaction::create([
                    'treasuries_id' => $treasury->id,
                    'auto_serial' => $lastSerial + 1,
                    'isal_number' => $lastIsalNumber + 1,

                    'mov_type' => 10,
                    'the_forign_key' => $invoice->id,
                    'accauont_number' => $accauont->id,
                    'is_accauont' => 1,
                    'is_Approved' => 1,
                    'admin_shift_id' => $adminShift->id,

                    // المورد يعيد المال، لذلك يزيد رصيد الخزنة
                    'money' => $paidAmount,
                    'money_for_accauont' => 0,

                    'added_by' => $admin_id,
                    'updated_by' => $admin_id,
                    'move_date' => date('Y-m-d'),
                    'bayan' => 'اعتماد فاتورة مرتجع مورد رقم ' . $invoice->id,
                    'com_code' => $com_code,
                ]);
            }

            // ==========================================
            // تحديث حساب المورد
            // الرصيد السالب يعني أن الشركة مدينة للمورد
            // ==========================================
            $balanceBefore = (float) ($accauont->current_balance ?? 0);

            // المرتجع الآجل يقلل المبلغ المستحق للمورد
            $balanceAfter = $balanceBefore + $remainAmount;

            $accauont->current_balance = $balanceAfter;
            $accauont->save();

            // ==========================================
            // اعتماد الفاتورة
            // لا نعدل المخزون هنا لأن الخصم يتم عند
            // إضافة تفاصيل المرتجع في الكود الحالي
            // ==========================================
            $invoice->is_approved = 1;
            $invoice->discount_type = $request->discount_type;
            $invoice->discount_value = $request->discount_value;
            $invoice->bill_type = $billType;
            $invoice->what_paid = $paidAmount;
            $invoice->what_remain = $remainAmount;
            $invoice->discount_percent = $request->discount_percent;
            $invoice->tax_percent = $request->tax_percent;
            $invoice->tax_value = $request->tax_value;
            $invoice->total_before_discount = $totalAmount;
            $invoice->money_for_account = $remainAmount;
            $invoice->order_type = 3;

            // هذا الحقل مرتبط بجدول treasuries في قاعدة بياناتك
            $invoice->treasury_transaction_id =
                $treasury ? $treasury->id : null;

            $invoice->supplier_balance_before = $balanceBefore;
            $invoice->supplier_balance_after = $balanceAfter;
            $invoice->approved_by = $admin_id;
            $invoice->account_number = $supplier->account_number;

            $invoice->save();
        });

    } catch (\Throwable $e) {
        return redirect()->back()->with(
            'error',
            'تعذر اعتماد الفاتورة: ' . $e->getMessage()
        );
    }

    return redirect()->back()->with(
        'success',
        'تم اعتماد فاتورة مرتجع المورد بنجاح'
    );
}

}
