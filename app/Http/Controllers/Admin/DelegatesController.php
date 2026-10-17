<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DelegateRequest;
use App\Models\Accauont;
use App\Models\Admin_Panel_Setting;
use App\Models\Delegate;
use Illuminate\Http\Request;

class DelegatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=Delegate::select()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('admin.Delegate.index',compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.Delegate.create');
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(DelegateRequest $request)
{
    $com_code = auth()->guard('admin')->user()->com_code;
    $admin_id = auth()->guard('admin')->id();

    // التأكد من عدم تكرار اسم المندوب
    $check = Delegate::where('name', $request->name)
        ->where('com_code', $com_code)
        ->first();

    if ($check != null) {
        return redirect()
            ->back()
            ->with('error', 'عفواً الاسم موجود من قبل')
            ->withInput();
    }

    // آخر رقم مندوب
    $lastDelegateCode = Delegate::max('delegate_code') ?? 1000;

    // آخر رقم حساب محاسبي
    $lastAccountNumber = Accauont::max('accauont_number') ?? 1000;

    // الرقم الجديد للمندوب
    $delegateCode = $lastDelegateCode + 1;

    // الرقم الجديد للحساب المحاسبي
    $accountNumber = max($lastDelegateCode, $lastAccountNumber) + 1;

    /*
    |--------------------------------------------------------------------------
    | إضافة المندوب
    |--------------------------------------------------------------------------
    */

    $Delegate = Delegate::create([

        'name' => $request->name,

        'phone' => $request->phone,

        'active' => $request->active,

        'city_id' => $request->city_id,

        'address' => $request->address,

        'start_balance' => $request->start_balance ?? 0,

        'current_balance' => $request->start_balance ?? 0,
        'parcent_type' => $request->parcent_type ?? 0,
        'parcent_sales_commission_katai' => $request->parcent_sales_commission_katai ?? 0,
        'parcent_sales_commission_nosjamla' => $request->parcent_sales_commission_nosjamla ?? 0,
        'parcent_sales_commission_jomla' => $request->parcent_sales_commission_jomla ?? 0,
        'parcent_collection_commission' => $request->parcent_collection_commission ?? 0,

        'nodes' => $request->nodes ?? 'لايوجد ملاحظات',

        'added_by' => $admin_id,

        'updated_by' => $admin_id,

        'com_code' => $com_code,

        'start_balance_status' => $request->start_balance_status,

        // نوع الحساب
        'accauont_types' => 4,

        // رقم المندوب
        'delegate_code' => $delegateCode,

        // رقم الحساب المحاسبي
        'account_number' => $accountNumber,

        'date' => now()->toDateString(),
    ]);


    /*
    |--------------------------------------------------------------------------
    | إعدادات الحسابات
    |--------------------------------------------------------------------------
    */

    $setting = Admin_Panel_Setting::first();


    /*
    |--------------------------------------------------------------------------
    | إضافة الحساب المحاسبي للمندوب
    |--------------------------------------------------------------------------
    */

    Accauont::create([

        'name' => $Delegate->name,

        // ربط الحساب بالمندوب
        'other_table_fk' => $Delegate->delegate_code,

        // رقم الحساب
        'accauont_number' => $accountNumber,

        // نوع الحساب
        'accauont_types' => $Delegate->accauont_types,

        // هل هو حساب رئيسي؟
        'is_parent' => $Delegate->is_parent ?? 0,

        // الحساب الأب
        'parient_accauont_number' => $setting->delegates_parent_number,

        // الرصيد الحالي
        'current_balance' => $Delegate->current_balance,

        // الملاحظات
        'nodes' => $Delegate->nodes,

        // الرصيد الافتتاحي
        'start_balance' => $Delegate->start_balance,

        // حالة الرصيد
        'start_balance_status' => $Delegate->start_balance_status,

        // حالة الحساب
        'is_archived' => $Delegate->active,

        'added_by' => $admin_id,

        'updated_by' => $admin_id,

        'com_code' => $com_code,

        'date' => now()->toDateString(),
    ]);


    /*
    |--------------------------------------------------------------------------
    | العودة إلى صفحة المندوبين
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('Delegates.index')
        ->with('success', 'تم إضافة حساب المندوب بنجاح');
}

    /**
     * Display the specified resource.
     */
public function show($id)
{
    $com_code = auth()->guard('admin')->user()->com_code;

    $data = Delegate::where('id', $id)
        ->where('com_code', $com_code)
        ->first();

    if (!$data) {
        return redirect()
            ->route('Delegate.index')
            ->with('error', 'المندوب غير موجود');
    }

    return view('admin.Delegate.show', compact('data'));
}
    /**
     * Show the form for editing the specified resource.
     */
      public function edit(string $id)
    {
        $data=Delegate::find($id);
        return view('admin.Delegate.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(DelegateRequest $request, $id)
{
    $com_code = auth()->guard('admin')->user()->com_code;

    $Delegate = Delegate::where('id', $id)
        ->where('com_code', $com_code)
        ->first();

    if (!$Delegate) {
        return redirect()->route('Delegates.index')
            ->with('error', 'المندوب غير موجود');
    }

    // هل حصل تغيير فعلاً؟
    $hasChanges =
        $Delegate->name != $request->name ||
        $Delegate->phone != $request->phone ||
        $Delegate->active != $request->active ||
        $Delegate->address != $request->address ||
        $Delegate->nodes != $request->nodes ||
        $Delegate->start_balance != $request->start_balance ||
        $Delegate->start_balance_status != $request->start_balance_status ||
        $Delegate->parcent_type != $request->parcent_type ||
        $Delegate->parcent_sales_commission_katai != $request->parcent_sales_commission_katai ||
        $Delegate->parcent_sales_commission_nosjamla != $request->parcent_sales_commission_nosjamla ||
        $Delegate->parcent_sales_commission_jomla != $request->parcent_sales_commission_jomla ||
        $Delegate->parcent_collection_commission != $request->parcent_collection_commission;

    if (!$hasChanges) {
        return redirect()->route('Delegates.index')
            ->with('error', 'لم تقم بتعديل أي بيانات');
    }

    // تحديث بيانات المندوب
    $Delegate->update([
        'name' => $request->name,
        'phone' => $request->phone,
        'active' => $request->active,
        'address' => $request->address,
        'nodes' => $request->nodes,

        'start_balance' => $request->start_balance ?? 0,
        'current_balance' => $request->start_balance ?? 0,
        'start_balance_status' => $request->start_balance_status,

        'parcent_type' => $request->parcent_type,
        'parcent_sales_commission_katai' =>
            $request->parcent_sales_commission_katai ?? 0,

        'parcent_sales_commission_nosjamla' =>
            $request->parcent_sales_commission_nosjamla ?? 0,

        'parcent_sales_commission_jomla' =>
            $request->parcent_sales_commission_jomla ?? 0,

        'parcent_collection_commission' =>
            $request->parcent_collection_commission ?? 0,

        'updated_by' => auth()->guard('admin')->id(),
    ]);

    // تحديث الحساب المالي المرتبط بالمندوب
    Accauont::where('other_table_fk', $Delegate->delegate_code)
        ->where('com_code', $com_code)
        ->update([
            'name' => $Delegate->name,
            'nodes' => $Delegate->nodes,
            'is_archived' => $Delegate->active,

            'start_balance' => $Delegate->start_balance,
            'current_balance' => $Delegate->current_balance,
            'start_balance_status' => $Delegate->start_balance_status,

            'updated_by' => auth()->guard('admin')->id(),
        ]);

    return redirect()->route('Delegates.index')
        ->with('success', 'تم تعديل حساب المندوب بنجاح');
}

    /**
     * Remove the specified resource from storage.
     */
public function destroy($id)
{
    $Delegate = Delegate::find($id);

    if (!$Delegate) {
        return redirect()->route('Delegates.index')
            ->with('error', 'العميل غير موجود');
    }

    //  حذف الحساب المرتبط
    Accauont::where('other_table_fk', $Delegate->delegate_code)->delete();
    // حذف الحساب
    $Delegate->delete();
    return redirect()->route('Delegates.index')
        ->with(['success' => 'تم حذف المندوب والحساب المالي بنجاح']);
}


    // البحث
     public function search(Request $request)
{
    $search = $request->input('search');
    $searchType = $request->input('search_type');
    $query = Delegate::query();
    if (!empty($search)) {
        if ($searchType == 'account_number') {
            $query->where('account_number', 'LIKE', '%' . $search . '%');
        }elseif($searchType == 'delegate_code'){
             $query->where('delegate_code', 'LIKE', '%' . $search . '%');
              }
        else
             {
            $query->where('name', 'LIKE', '%' . $search . '%');
            }
    }

    $data = $query->paginate(3)->withQueryString();
    return view('admin.Delegate.index', compact(
        'data',
        'search',
        'searchType'
    ));
}
}
