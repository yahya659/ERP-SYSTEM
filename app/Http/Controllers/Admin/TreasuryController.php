<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\TreasuryRequest;

use App\Http\Controllers\Controller;
use App\Http\Requests\Add_Treasury_Delivery;
use App\Http\Requests\Add_Treasury_DeliveryRequest;
use App\Models\Treasury;
use App\Models\Treasury_Delivery;
use Illuminate\Http\Request;

class TreasuryController extends Controller
{
    //DESCترتيب تنازلي
    public function index(){
        $data=Treasury::select()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('admin.treasuries.index',compact('data'));

    }
    public function create(){

        return view('admin.treasuries.create');
    }
    public function store(TreasuryRequest $request)
{
    // التحقق من وجود خزنة رئيسية
    if ((int)$request->is_master == 1) {

        $masterTreasury = Treasury::where('is_master', 1)
            ->where('com_code', auth()->guard('admin')->user()->com_code)
            ->first();

       if ($masterTreasury) {
    return redirect()->back()
        ->withInput()//لإعادة تعبئة الحقول في النموذج
        ->with(
            'error',
            'يوجد خزن رئيسية بالفعل باسم (' . $masterTreasury->name . ') ولا يمكن إضافة أكثر من خزن رئيسية'
        );
        }
    }
    // إضافة الخزنة
    Treasury::create([
        'name' => $request->name,
        'is_master' => $request->is_master ?? 0,
        'active' => $request->active ?? 1,
        'last_isal_exchange' => 0,
        'last_isal_collection' => 0,
        'added_by' => auth()->guard('admin')->id(),
        'com_code' => auth()->guard('admin')->user()->com_code,
        'date' => now()->toDateString(),
    ]);

    return redirect()
        ->route('admin.treasuries.create')
        ->with('success', 'تم إضافة الخزن بنجاح');
}

// تعديل الخزنة
public function edit($id){
    $data=Treasury::select()->find($id);
    if(!$data){
        return redirect()->route('admin.treasuries.index')->with('error','الخزن غير موجود');
    }
    return view('admin.treasuries.edit',compact('data'));
    }
    // تحديث الخزنة بعد حفضها
public function update($id,TreasuryRequest $request){
    $data=Treasury::select()->find($id);
    if(!$data){
        return redirect()->route('admin.treasuries.index')->with('error','الخزن غير موجود');
    }
    // التحقق من وجود خزنة رئيسية أخرى
    if ((int)$request->is_master == 1) {
        $masterTreasury = Treasury::where('is_master', 1)
            ->where('com_code', auth()->guard('admin')->user()->com_code)->first();
            if ($masterTreasury) {
                return redirect()->back()->withInput()//لإعادة تعبئة الحقول في النموذج
        ->with(
            'error',
            'يوجد خزن رئيسية بالفعل باسم (' . $masterTreasury->name . ') ولا يمكن إضافة أكثر من الخزن رئيسية'
        );
        }
    }

    $data->fill([
        'name' => $request->name,
        'is_master' => $request->is_master ?? 0,
        'active' => $request->active ?? 1,
        'last_isal_exchange' => $request->last_isal_exchange ,
        'last_isal_collection' => $request->last_isal_collection ,
        'updated_by' => auth()->guard('admin')->id(),
    ]);
    if (!$data->isDirty()) {//داله تعمل تحقق اذا تم تعديل اي حقل او لا
    return redirect()->route('admin.treasuries.index')->with('info', 'لم تقم بتعديل خزن');
}
$data->save();

    return redirect()
        ->route('admin.treasuries.index')
        ->with('success', 'تم تحديث خزن بنجاح');
}
public function search(Request $request)
{
    $search = $request->input('search');

    $data = Treasury::where('name', 'LIKE', '%' . $search . '%')
        ->paginate(3)
        ->withQueryString();

      return view('admin.treasuries.index', compact('data', 'search'));
}
public function detalls($id){
    $data=Treasury::select()->find($id);
$Treasury_Delivery = Treasury_Delivery::with(['canDeliveryTreasury','treasury'])
    ->where('treasuries_id', $id)
    ->orderBy('id','DESC')
    ->get();
      return view('admin.treasuries.detalls',['data'=>$data,'Treasury_Delivery'=>$Treasury_Delivery]);
}

// اضافه تسليم خزنه
public function Add_Treasury_Delivery($id){
    $com_code=auth()->guard('admin')->user()->com_code;
    $data=Treasury::select('id','name')->find($id);
    if(empty($data)){
        return redirect()->route('admin.treasuries.index');
    }

    $Treasury=Treasury::select('id','name')->where(['com_code'=>$com_code,'active'=>1])->get();
        return view('admin.treasuries.Add_Treasury_Delivery',['data'=>$data,'Treasury'=>$Treasury]);
    }
    // تسليم خزن الفرعيه
public function Store_Treasury_Delivery($id, Add_Treasury_DeliveryRequest $request)
{
    $com_code = auth()->guard('admin')->user()->com_code;

    $check = Treasury_Delivery::where([
        'treasuries_id' => $id,
        'treasuries_can_delivery_id' => $request->treasuries_can_delivery_id,
        'com_code' => $com_code
    ])->first();

    if ($check) {
        return redirect()->back()
            ->with(['error' => 'عفواً هذه خزن تم تسليمها من قبل'])
            ->withInput();
    }

    $data_insert_details = [];

    $data_insert_details['treasuries_id'] = $id;
    $data_insert_details['treasuries_can_delivery_id'] = $request->treasuries_can_delivery_id;
    $data_insert_details['added_by'] = auth()->guard('admin')->id();
    $data_insert_details['com_code'] = $com_code;
    $data_insert_details['created_at'] = now();

    Treasury_Delivery::create($data_insert_details);

    return redirect()
        ->route('admin.treasuries.detalls', $id)
        ->with(['success' => 'تم تسليم خزن بنجاح']);
}
// حذف الخزنه الفرعيه
public function delete_Treasury_Delivery($id)
{
    $Treasury_Delivery = Treasury_Delivery::find($id);

    if (!$Treasury_Delivery) {
        return redirect()->back()->with('error', 'السجل غير موجود');
    }

    $treasury_id = $Treasury_Delivery->treasuries_id;

    $Treasury_Delivery->delete();

    return redirect()
        ->route('admin.treasuries.detalls', $treasury_id)
        ->with(['success' => 'تم حذف  تسليم خزن بنجاح']);
}
}

