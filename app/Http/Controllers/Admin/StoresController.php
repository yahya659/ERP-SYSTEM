<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;

class StoresController extends Controller
{
    //
    public function index(){
        $data=Store::select()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('admin.stores.index',compact('data'));
    }
 public function edit($id){
        $data=Store::find($id);
        return view('admin.stores.edit',compact('data'));
    }
public function create(){
    return view('admin.stores.create');
}

public function search(Request $request)
{
    $search = $request->input('search');

    $data = Store::where('name', 'LIKE', '%' . $search . '%')
        ->paginate(3)
        ->withQueryString();

      return view('admin.stores.index', compact('data', 'search'));
}
 public function store(StoreRequest $request)
{
    // التحقق من وجود مخازن من قبل
    if ((int)$request->is_master == 1) {

        $Store = Store::where('active', 1)
            ->where('com_code', auth()->guard('admin')->user()->com_code)
            ->first();

       if ($Store) {
    return redirect()->back()
        ->withInput()//لإعادة تعبئة الحقول في النموذج
        ->with(
            'error',
            'يوجد مخزن باسم (' . $Store->name . ') ولا يمكن إضافة أكثر من مخزن '
        );
        }
    }
    // إضافة المخازن
    Store::create([
        'name' => $request->name,
        'phones' => $request->phones,
        'address' => $request->address,
        'active' => $request->active ?? 1,

        'added_by' => auth()->guard('admin')->id(),
        'com_code' => auth()->guard('admin')->user()->com_code,
        'date' => now()->toDateString(),
    ]);

    return redirect()
        ->route('admin.stores.create')
        ->with('success', 'تم إضافة المخزن بنجاح');
}

  public function update($id,StoreRequest $request){
        $data=Store::find($id);
        $data->fill([
            'name'=>$request->name,
            'phones'=>$request->phones,
            'address'=>$request->address,
            'active'=>$request->active ?? 0,
            'updated_by' => auth()->guard('admin')->id(),
        ]);
            if (!$data->isDirty()) {//داله تعمل تحقق اذا تم تعديل اي حقل او لا
            return redirect()->route('admin.stores.index')->with('error', 'لم تقم بتعديل المخزن');
}
$data->save();
        return redirect()->route('admin.stores.index')->with('success','تم تعديل المخزن بنجاح');
     }
     public function delete_stores($id)
{
    $delete_stores = Store::find($id);

    if (!$delete_stores) {
        return redirect()->back()->with('error', 'السجل غير موجود');
    }



    $delete_stores->delete();

    return redirect()
        ->route('admin.stores.index')
        ->with(['success' => 'تم حذف المخزن بنجاح']);
}
}
