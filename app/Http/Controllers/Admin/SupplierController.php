<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuppliersRequest;
use App\Models\Supplier;
use App\Models\SuppliersCategory;
use App\Models\Customer;
use App\Models\Accauont;
use App\Models\Admin_Panel_Setting;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

   public function index()
    {
           $search = null;
    $searchType = null;

        $data=Supplier::select()->with('category')->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('admin.supplier.index',compact('data','searchType','search'));
    }

    /**
     * Show the form for creating a new resource.
     */
  public function create()
    {
        $categories = SuppliersCategory::all();
        return view('admin.supplier.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SuppliersRequest $request)
    {
          $com_code = auth()->guard('admin')->user()->com_code;
        //   لعدم تكرار رقم الحساب ورقم حساب العميل
          $lastSupplierAccount = Supplier::max('account_number') ?? 1000;
          $lastAccauontAccount = Accauont::max('accauont_number') ?? 1000;
        //  يشوف الااسم ذا مش موجود
        $cheack=Supplier::where(['name'=>$request->name,'com_code'=>$com_code])->first();
        if($cheack==null){
   $Supplier = Supplier::create([
    'name' => $request->name,
    'phone' => $request->phone,
    'active' => $request->active,
    'city_id' => $request->city_id,
    'address' => $request->address,
    'start_balance' => $request->start_balance ?? 0,
    'current_balance' => $request->start_balance ?? 0,
    'suppliers_categories_id' => $request->suppliers_categories_id,
    'nodes' => $request->nodes ?? 'لايوجد ملاحضات',
    'added_by' => auth()->guard('admin')->id(),
    'updated_by' => auth()->guard('admin')->id(),
    'com_code' => auth()->guard('admin')->user()->com_code,
    'start_balance_status' => $request->start_balance_status,
    'supplier_code' => (Supplier::max('supplier_code') ?? 2000000) + 1,
    'account_number' =>max($lastSupplierAccount, $lastAccauontAccount) + 1,
    'date' => now()->toDateString(),
]);
// التخزين في جدول الحسابات
$accNumber = (Accauont::max('accauont_number') ?? 1000) + 1;
$setting = Admin_Panel_Setting::first();//حساب الااب من الشركه
Accauont::create([
                'name' => $Supplier->name,
                'other_table_fk' => $Supplier->supplier_code,
                'accauont_number'=> $accNumber,
                'accauont_types'=> $Supplier->accauont_types ?? 2,// نوع الحساب مورد
                'is_parent'=> $Supplier->is_parent ?? 0,
                'parient_accauont_number'=> $setting->supplier_parent_number,
                'accauont_number'=> $accNumber,
                'current_balance'=> $Supplier->start_balance ?? 0,
                'nodes'=> $Supplier->nodes ?? 'لايوجد ملاحضات',
                'start_balance'=> $Supplier->start_balance ?? 0,
                'start_balance_status'=> $Supplier->start_balance_status,
                'is_archived'=> $Supplier->active,
                'added_by'=> auth()->guard('admin')->id(),
                // 'updated_by'=> auth()->guard('admin')->id(),
                'com_code'=> auth()->guard('admin')->user()->com_code,
                'date'=> now()->toDateString(),
]);
 }else{
        return redirect()->back()->with('error', 'عفوا الاسم موجود من قبل')->withInput();
        }
          return redirect()->route('Suppliers.index')->with('success', 'تم إضافة حساب العميل بنجاح');


    }
    public function show(string $id)
    {
        //
            $data = Supplier::findOrFail($id);
        return view('admin.supplier.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit($id)
{
    $com_code = auth()->guard('admin')->user()->com_code;

    $data = Supplier::where('id',$id)
        ->where('com_code',$com_code)
        ->first();

    $categories = SuppliersCategory::where('com_code',$com_code)
        ->get();


    return view('admin.supplier.edit',compact('data','categories'));
}

    /**
     * Update the specified resource in storage.
     */
public function update(SuppliersRequest $request, $id)
{
    $com_code = auth()->guard('admin')->user()->com_code;

    $Supplier = Supplier::where('id', $id)
        ->where('com_code', $com_code)
        ->first();

    if (!$Supplier) {
        return redirect()->route('Suppliers.index')
            ->with('error', 'المورد غير موجود');
    }


    $hasChanges = $Supplier->name != $request->name ||
        $Supplier->phone != $request->phone ||
        $Supplier->active != $request->active ||
        $Supplier->address != $request->address ||
        $Supplier->nodes != $request->nodes ||
        $Supplier->suppliers_categories_id != $request->suppliers_categories_id;


    if (!$hasChanges) {
        return redirect()->route('Suppliers.index')
            ->with('error', 'لم تقم بتعديل أي بيانات');
    }


    $Supplier->update([
        'name' => $request->name,
        'phone' => $request->phone,
        'active' => $request->active,
        'city_id' => $request->city_id,
        'address' => $request->address,

        'suppliers_categories_id' => $request->suppliers_categories_id,
        'nodes' => $request->nodes,
        'updated_by' => auth()->guard('admin')->id(),
    ]);


    // تحديث البيانات بعد التعديل
    $Supplier->refresh();


    Accauont::where('other_table_fk', $Supplier->supplier_code)
        ->where('com_code', $com_code)
        ->update([
            'name' => $Supplier->name,
            'nodes' => $Supplier->nodes,
            'is_archived' => $Supplier->active,
            'updated_by' => auth()->guard('admin')->id(),
        ]);


    return redirect()->route('Suppliers.index')
        ->with('success', 'تم تعديل بيانات المورد بنجاح');
}

    /**
     * Remove the specified resource from storage.
     */
 public function destroy($id)
{
    $Supplier = Supplier::find($id);

    if (!$Supplier) {
        return redirect()->route('Suppliers.index')
            ->with('error', 'العميل غير موجود');
    }

    //  حذف الحساب المرتبط
    Accauont::where('other_table_fk', $Supplier->supplier_code)->delete();
    // حذف الحساب
    $Supplier->delete();
    return redirect()->route('Suppliers.index')
        ->with(['success' => 'تم حذف العميل والحساب المالي بنجاح']);
}
 public function search(Request $request)
{
    $search = $request->input('search');
    $searchType = $request->input('search_type');
    $query = Supplier::query();
    if (!empty($search)) {
        if ($searchType == 'account_number') {
            $query->where('account_number', 'LIKE', '%' . $search . '%');
        }elseif($searchType == 'supplier_code'){
             $query->where('supplier_code', 'LIKE', '%' . $search . '%');
              }
        else
             {
            $query->where('name', 'LIKE', '%' . $search . '%');
            }
    }

    $data = $query->paginate(3)->withQueryString();
    return view('admin.supplier.index', compact(
        'data',
        'search',
        'searchType'
    ));
}
}
