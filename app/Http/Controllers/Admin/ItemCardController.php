<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemCardRequest;
use App\Models\Inv_uom;
use App\Models\InvItem_card_Movement;
use App\Models\InvItemBatch;
use App\Models\ItemCard;
use App\Models\InvItemscardCategory;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;

class ItemCardController extends Controller
{

public function index()
{
    $data = ItemCard::select()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
    return view('admin.itemcard.index',compact('data'));
}
 public function create()
{
    $com_code = auth()->guard('admin')->user()->com_code;
    $inv_itemscard_categories_id = InvItemscardCategory::where('com_code',$com_code)->where('active',1)->get();
$parent_inv_itemscardid = Inv_uom::where('com_code', $com_code)->where('active', 1)->where('active', 1)->get();
$parent_inv_itemscardid_children = Inv_uom::where('com_code', $com_code)->where('active', 1)->where('active', 1)->get();//اذا كانت تجزئه
    $items = ItemCard::where('com_code',$com_code)->get();
    return view('admin.itemcard.create',
    compact('inv_itemscard_categories_id','parent_inv_itemscardid','items','parent_inv_itemscardid_children'));
}

    /**
     * Store a newly created resource in storage.
     */
public function store(ItemCardRequest $request)
{
    $com_code = auth()->guard('admin')->user()->com_code;

    // تحقق من تكرار الاسم
    $item_card = ItemCard::where('name', $request->name)
        ->where('com_code', $com_code)
        ->first();

    if ($item_card) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'الصنف (' . $item_card->name . ') موجود مسبقاً');
    }

    // توليد item_code
    $lastItem = ItemCard::where('com_code', $com_code)
        ->orderBy('id', 'desc')
        ->first();

    $item_code = $lastItem ? $lastItem->item_code + 1 : 1;

    // توليد barcode
    $barcode = $request->barcode;
    if (empty($barcode)) {
        $barcode = 'PRD-' . time();
    }

    // رفع الصورة
    $path = null;
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('items', 'public');
    }

    // ===== جديد: هل للصنف وحدة تجزئة؟ =====
    $hasRetail = (int) $request->dose_has_retailunit === 1;

    ItemCard::create([
        'name' => $request->name,
        'barcode' => $barcode,
        'item_code' => $item_code,

        'item_type' => $request->item_type,
        'inv_itemscard_categories_id' => $request->inv_itemscard_categories_id,
        'parent_inv_itemscard_id' => $request->parent_inv_itemscard_id,

        // ===== معدّل: تعتمد على $hasRetail =====
        'dose_has_retailunit' => $hasRetail ? 1 : 0,
        'retail_uom' => $hasRetail ? $request->retail_uom : null,
        'retail_uom_quantity_to_parent' => $hasRetail ? $request->retail_uom_quantity_to_parent : 0,

        'uom_id' => $request->uom_id,
        'active' => $request->active ?? 1,
        'date' => now()->toDateString(),

        'added_by' => auth()->guard('admin')->id(),
        'com_code' => $com_code,

        // أسعار الوحدة الأساسية (كما هي)
        'price' => $request->price ?? 0,
        'nos_gomla_price' => $request->nos_gomla_price ?? 0,
        'wholesale_price' => $request->wholesale_price ?? 0,
        'coast_price' => $request->coast_price ?? 0,

        // ===== معدّل: أسعار التجزئة تُحفظ فقط عند 1 =====
        'retail_price' => $hasRetail ? $request->retail_price : 0,
        'nos_gomla_price_retail' => $hasRetail ? $request->nos_gomla_price_retail : 0,
        'wholesale_price_retail' => $hasRetail ? $request->wholesale_price_retail : 0,
        'coast_price_retail' => $hasRetail ? $request->coast_price_retail : 0,

        'has_fixed_price' => $request->has_fixed_price ?? 0,
        'Quantity' => $request->Quantity ?? 0,
        'Quantity_retail' => $request->Quantity_retail ?? 0,
        'Quantity_all_retail' => $request->Quantity_all_retail ?? 0,
        'image' => $path,
    ]);

    return redirect()
        ->route('item_card.index')
        ->with('success', 'تم إضافة الصنف بنجاح');
}




  public function edit($id)
{
    $data = ItemCard::findOrFail($id);

    $inv_itemscard_categories = InvItemscardCategory::get();
    $parent_inv_itemscardid = Inv_uom::get();
    $parent_inv_itemscardid_children = Inv_uom::get();
    $items = ItemCard::get();

    return view('admin.itemcard.edit', compact(
        'data',
        'inv_itemscard_categories',
        'parent_inv_itemscardid',
        'parent_inv_itemscardid_children',
        'items'
    ));
}
public function update(ItemCardRequest $request, $id)
{
    $com_code = auth()->guard('admin')->user()->com_code;

    $item = ItemCard::where('id', $id)->where('com_code', $com_code)->first();
    if (!$item) {
        return redirect()
            ->route('item_card.index')
            ->with('error', 'الصنف غير موجود');
    }

    // منع تكرار الاسم مع صنف آخر (يتجاهل الصنف الحالي)
    $duplicate = ItemCard::where('name', $request->name)
        ->where('com_code', $com_code)
        ->where('id', '!=', $item->id)
        ->first();

    if ($duplicate) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'الصنف (' . $duplicate->name . ') موجود مسبقاً');
    }

    // الصورة
    $path = $item->image;
    if ($request->hasFile('image')) {
        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }
        $path = $request->file('image')->store('items', 'public');
    }

    // هل للصنف وحدة تجزئة؟
    $hasRetail = (int) $request->dose_has_retailunit === 1;

    $item->update([
        // الباركود لا يتغير عند التعديل
        'name' => $request->name,
        'item_type' => $request->item_type,
        'inv_itemscard_categories_id' => $request->inv_itemscard_categories_id,
        'uom_id' => $request->uom_id,
        'parent_inv_itemscard_id' => $request->parent_inv_itemscard_id,
        'active' => $request->active,
        'has_fixed_price' => $request->has_fixed_price ?? 0,

        // أسعار الوحدة الأساسية (مطلوبة دائمًا بالتحقق)
        'price' => $request->price ?? 0,
        'nos_gomla_price' => $request->nos_gomla_price ?? 0,
        'wholesale_price' => $request->wholesale_price ?? 0,
        'coast_price' => $request->coast_price ?? 0,

        // التجزئة: تُحفظ فقط عند 1، وتُصفَّر عند 0
        'dose_has_retailunit' => $hasRetail ? 1 : 0,
        'retail_uom' => $hasRetail ? $request->retail_uom : null,
        'retail_uom_quantity_to_parent' => $hasRetail ? $request->retail_uom_quantity_to_parent : 0,
        'retail_price' => $hasRetail ? $request->retail_price : 0,
        'nos_gomla_price_retail' => $hasRetail ? $request->nos_gomla_price_retail : 0,
        'wholesale_price_retail' => $hasRetail ? $request->wholesale_price_retail : 0,
        'coast_price_retail' => $hasRetail ? $request->coast_price_retail : 0,

        'image' => $path,
    ]);

    return redirect()
        ->route('item_card.index')
        ->with('success', 'تم تحديث البيانات بنجاح');
}
       public function destroy(string $id)
    {
                $ItemCard=ItemCard::find($id);
                $ItemCard->delete();


    return redirect()
        ->route('item_card.index')
        ->with(['success' => 'تم حذف فئه  بنجاح']);

    }
public function search(Request $request)
{
    $search = $request->input('search');
    $itemCode = $request->input('item_code');

    $data = ItemCard::query()
        ->when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })
        ->when($itemCode, function ($query) use ($itemCode) {
            $query->where('item_code', 'LIKE', '%' . $itemCode . '%');
        })
        ->paginate(3)
        ->withQueryString();

    return view('admin.itemcard.index', compact('data', 'search', 'itemCode'));
}
   public function show(string $id)
{
    $data = ItemCard::findOrFail($id);
    // حساب اخر عدد في كل المخازن
     $totalQuantityAllStores = InvItemBatch::where('item_code', $data->item_code)
    ->where('com_code', auth()->guard('admin')->user()->com_code)
    ->sum('quantity');

    $stores = Store::where('active', 1)
        ->where('com_code', $data->com_code)
        ->get();

    $selectedStore = request('store_id');

    $storeQuantity = null;

    if ($selectedStore == 'all') {

        $storeQuantity = InvItem_card_Movement::where('item_code', $data->item_code)
            ->orderBy('id', 'DESC')
            ->first()?->quantity_after_move;

    } elseif ($selectedStore) {

        $storeQuantity = InvItem_card_Movement::where('item_code', $data->item_code)
            ->where('store_id', $selectedStore)
            ->orderBy('id', 'DESC')
            ->first()?->quantity_after_move_store;
    }

    // حركات الصنف
   $movementsQuery = InvItem_card_Movement::with([
    'movementType',
    'movementCategory',
    'addedBy',
    'store',
    'itemCard.uomid',
    'itemCard.retail_uom_id'
])
    ->where('item_code', $data->item_code);

    // إذا اختار مخزن معين
    if ($selectedStore && $selectedStore != 'all') {
        $movementsQuery->where('store_id', $selectedStore);
    }

    $movements = $movementsQuery
        ->orderBy('id', 'DESC')
        ->get();

    return view('admin.itemcard.show', compact(
        'data',
        'stores',
        'selectedStore',
        'storeQuantity',
        'movements',
        'totalQuantityAllStores'
    ));
}

}
