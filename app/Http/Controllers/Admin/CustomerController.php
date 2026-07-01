<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomersRequest;
use App\Models\Accauont;
use App\Models\Admin_Panel_Setting;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index()
    {
           $search = null;
    $searchType = null;
        $data=Customer::select()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('admin.customers.index',compact('data','searchType','search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomersRequest $request)
    {
          $com_code = auth()->guard('admin')->user()->com_code;
        //   لعدم تكرار رقم الحساب ورقم حساب العميل
          $lastCustomerAccount = Customer::max('account_number') ?? 1000;
          $lastAccauontAccount = Accauont::max('accauont_number') ?? 1000;
        //  يشوف الااسم ذا مش موجود
        $cheack=Customer::where(['name'=>$request->name,'com_code'=>$com_code])->first();
        if($cheack==null){
   $customer = Customer::create([
    'name' => $request->name,
    'phone' => $request->phone,
    'active' => $request->active,
    'city_id' => $request->city_id,
    'address' => $request->address,
    'start_balance' => $request->start_balance ?? 0,
    'current_balance' => $request->start_balance ?? 0,
    'nodes' => $request->nodes ?? 'لايوجد ملاحضات',
    'added_by' => auth()->guard('admin')->id(),
    'updated_by' => auth()->guard('admin')->id(),
    'com_code' => auth()->guard('admin')->user()->com_code,
    'start_balance_status' => $request->start_balance_status,
    'customer_code' => (Customer::max('customer_code') ?? 1000000) + 1,
    'account_number' =>max($lastCustomerAccount, $lastAccauontAccount) + 1,
    'date' => now()->toDateString(),
]);
// التخزين في جدول الحسابات
$accNumber = (Accauont::max('accauont_number') ?? 1000) + 1;
$setting = Admin_Panel_Setting::first();//حساب الااب من الشركه
Accauont::create([
                'name' => $customer->name,
                'other_table_fk' => $customer->customer_code,
                'accauont_number'=> $accNumber,
                'accauont_types'=> $customer->accauont_types ?? 3,// نوع الحساب عميل
                'is_parent'=> $customer->is_parent ?? 0,
                'parient_accauont_number'=> $setting->customer_parent_number,
                'accauont_number'=> $accNumber,
                'current_balance'=> $customer->start_balance ?? 0,
                'nodes'=> $customer->nodes ?? 'لايوجد ملاحضات',
                'start_balance'=> $customer->start_balance ?? 0,
                'start_balance_status'=> $customer->start_balance_status,
                'is_archived'=> $customer->active,
                'added_by'=> auth()->guard('admin')->id(),
                'updated_by'=> auth()->guard('admin')->id(),
                'com_code'=> auth()->guard('admin')->user()->com_code,
                'date'=> now()->toDateString(),
]);
 }else{
        return redirect()->back()->with('error', 'عفوا الاسم موجود من قبل')->withInput();
        }
          return redirect()->route('customers.index')->with('success', 'تم إضافة حساب العميل بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
            $data = Customer::findOrFail($id);
        return view('admin.customers.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data=Customer::find($id);
        return view('admin.customers.edit',compact('data'));
    }
public function update(CustomersRequest $request, $id)
{
    $com_code = auth()->guard('admin')->user()->com_code;

    $customer = Customer::where('id', $id)
        ->where('com_code', $com_code)
        ->first();

    if (!$customer) {
        return redirect()->route('customers.index')
            ->with('error', 'العميل غير موجود');
    }

    // هل في تغيير فعلاً؟
    $hasChanges = $customer->name != $request->name ||
        $customer->phone != $request->phone ||
        $customer->active != $request->active ||
        $customer->address != $request->address ||
        $customer->nodes != $request->nodes;

    if (!$hasChanges) {
        return redirect()->route('customers.index')
            ->with('error', 'لم تقم بتعديل أي بيانات');
    }

    // تحديث العميل
    $customer->update([
        'name' => $request->name,
        'active' => $request->active,
        'phone' => $request->phone,
        'nodes' => $request->nodes,
        'address' => $request->address,
        'updated_by' => auth()->guard('admin')->id(),
    ]);

    // تحديث الحساب المالي المرتبط
    Accauont::where('other_table_fk', $customer->customer_code)
        ->where('com_code', $com_code)
        ->update([
            'name' => $customer->name,
            'nodes' => $customer->nodes,
            'is_archived' => $customer->active,
            'updated_by' => auth()->guard('admin')->id(),
        ]);

    return redirect()->route('customers.index')
        ->with('success', 'تم تعديل الحساب بنجاح');
}
public function destroy($id)
{
    $customer = Customer::find($id);

    if (!$customer) {
        return redirect()->route('customers.index')
            ->with('error', 'العميل غير موجود');
    }

    //  حذف الحساب المرتبط
    Accauont::where('other_table_fk', $customer->customer_code)->delete();
    // حذف الحساب
    $customer->delete();
    return redirect()->route('customers.index')
        ->with(['success' => 'تم حذف العميل والحساب المالي بنجاح']);
}
 public function search(Request $request)
{
    $search = $request->input('search');
    $searchType = $request->input('search_type');
    $query = Customer::query();
    if (!empty($search)) {
        if ($searchType == 'account_number') {
            $query->where('account_number', 'LIKE', '%' . $search . '%');
        }elseif($searchType == 'customer_code'){
             $query->where('customer_code', 'LIKE', '%' . $search . '%');
              }
        else
             {
            $query->where('name', 'LIKE', '%' . $search . '%');
            }
    }

    $data = $query->paginate(3)->withQueryString();
    return view('admin.customers.index', compact(
        'data',
        'search',
        'searchType'
    ));
}

}
