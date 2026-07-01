<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccauontRequest;
use App\Models\Accauont;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\AccountType;
use Illuminate\Http\Request;

class AccauontController extends Controller
{

    public function index()
    {
        $data=Accauont::select()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('admin.accauonts.index',compact('data'));
    }

public function create()
{
 $com_code = auth()->guard('admin')->user()->com_code;
    $accauont_types = AccountType::where('active', 1)->where('relatedternalaccounts', 0)->orderBy('id', 'DESC')->get();
$parient_accauont = Accauont::where('is_parent', 1)->where('com_code', $com_code)->orderBy('id', 'DESC')->get();
 return view('admin.accauonts.create', compact('accauont_types','parient_accauont'));
}

    public function store(AccauontRequest $request)
    {
         $com_code = auth()->guard('admin')->user()->com_code;
         //   لعدم تكرار رقم الحساب ورقم حساب العميل
          $lastCustomerAccount = Customer::max('account_number') ?? 1000;
          $lastAccauontAccount = Accauont::max('accauont_number') ?? 1000;
        //  يشوف الااسم ذا مش موجود
        $cheack=Accauont::where(['name'=>$request->name,'com_code'=>$com_code])->first();
        if($cheack==null){
            Accauont::create([
                'name' => $request->name,
                'accauont_number'=> $request->accauont_number,
                'accauont_types'=> $request->accauont_types,
                'is_parent'=> $request->is_parent,
                'parient_accauont_number'=> $request->parient_accauont_number,
                'accauont_number'=> max($lastAccauontAccount,$lastCustomerAccount) + 1,
                'current_balance'=> $request->start_balance ?? 0,
                'nodes'=> $request->nodes ?? 'لايوجد ملاحضات',
                'start_balance'=> $request->start_balance ?? 0,
                'start_balance_status'=> $request->start_balance_status,
                'is_archived'=> $request->is_archived,
                'added_by'=> auth()->guard('admin')->id(),
                'updated_by'=> auth()->guard('admin')->id(),
                'com_code'=> auth()->guard('admin')->user()->com_code,
                'date'=> now()->toDateString(),
                ]);
                }else{
                    return redirect()->back()->with('error', 'عفوا الاسم موجود من قبل')->withInput();
                    }
                    return redirect()->route('acaauonts.index')->with('success', 'تم إضافة الحساب المالي بنجاح');
                    }


    public function show(string $id)
    {
        //
            $data = Accauont::findOrFail($id);
        return view('admin.accauonts.show',compact('data'));
    }


    public function edit(string $id)
    {
         $com_code = auth()->guard('admin')->user()->com_code;

        $data=Accauont::find($id);
         $accauont_types = AccountType::where('active', 1)->where('relatedternalaccounts', 0)->orderBy('id', 'DESC')->get();
$parient_accauont = Accauont::where('is_parent', 1)->where('com_code', $com_code)->orderBy('id', 'DESC')->get();
        return view('admin.accauonts.edit',compact('data','accauont_types','parient_accauont'));
    }


public function update( AccauontRequest $request,$id)
{
 $data = Accauont::find($id);

$data->fill([
    'name' => $request->name,
    'accauont_types' => $request->accauont_types,
    'is_parent' => $request->is_parent,
    'parient_accauont_number' => $request->parient_accauont_number,
    'nodes' => $request->nodes,
    'is_archived' => $request->is_archived,
    'updated_by' => auth()->guard('admin')->id(),
]);

// إذا ما في تغيير
if (!$data->isDirty()) {
    return redirect()
        ->route('acaauonts.index')
        ->with('error', 'لم تقم بتعديل أي حساب مالي');
}
$data->save();
//  تحديث جدول العملاء
Customer::where('customer_code', $data->other_table_fk)
    ->update([
        'name' => $data->name,
        'nodes' => $data->nodes,
        'active' => $data->is_archived,
        'updated_by' => auth()->guard('admin')->id(),
    ]);
       // تحديث جدول الموردين
    Supplier::where('supplier_code', $data->other_table_fk)
        ->update([
            'name' => $data->name,
            'nodes' => $data->nodes,
            'active' => $data->is_archived,
            'updated_by' => auth()->guard('admin')->id(),
        ]);


return redirect()
->route('acaauonts.index')
->with('success', 'تم تعديل الحساب المالي بنجاح');
}


 public function destroy($id)
{
    $account = Accauont::find($id);

    if (!$account) {
        return redirect()->route('acaauonts.index')
            ->with('error', 'الحساب غير موجود');
    }

    //  حذف العميل المرتبط
    Customer::where('customer_code', $account->other_table_fk)->delete();
    Supplier::where('supplier_code', $account->other_table_fk)->delete();
    //  حذف الحساب
    $account->delete();

    return redirect()
        ->route('acaauonts.index')
        ->with(['success' => 'تم حذف الحساب والعميل بنجاح']);
}
public function search(Request $request)
{
    $search = $request->input('search');
    $searchType = $request->input('search_type');

    // بدء بناء الاستعلام
    $query = Accauont::query();

    // التحقق مما إذا كان المستخدم قد كتب شيئاً في حقل البحث
    if (!empty($search)) {
        if ($searchType == 'account_number') {
            // إذا اختار رقم الحساب، يبحث في حقل accauont_number
            $query->where('accauont_number','LIKE', '%' . $search . '%');
        } else {
            // الافتراضي: يبحث في حقل الاسم name
            $query->where('name', 'LIKE', '%' . $search . '%');
        }
    }

    // جلب البيانات مع التصفح والحفاظ على روابط البحث
    $data = $query->paginate(3)->withQueryString();

    // تمرير المتغيرات للـ
    return view('admin.accauonts.index', compact('data', 'search'));
}
}
