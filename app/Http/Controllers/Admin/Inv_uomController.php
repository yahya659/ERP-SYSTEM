<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvuomRequest;
use App\Models\Inv_uom;
use Illuminate\Http\Request;

class Inv_uomController extends Controller
{
    //
    public function index(){
        $data=Inv_uom::select()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('admin.inv_uom.index',compact('data'));
    }

    public function create(){
        return view('admin.inv_uom.create');

    }
public function search(Request $request)
{
    $data = Inv_uom::query();

    if ($request->search) {
        $data->where('name', 'LIKE', '%' . $request->search . '%');
    }

    if ($request->is_master_search !== null && $request->is_master_search !== '') {
        $data->where('is_master', $request->is_master_search);
    }

    $data = $data->orderBy('id', 'DESC')
        ->paginate(10)
        ->withQueryString();

    return view('admin.inv_uom.index', compact('data'));
}
     public function store(InvuomRequest $request)
{
    // التحقق من وجود وحده من قبل
    if ((int)$request->is_master == 1) {

        $Inv_uom = Inv_uom::where('is_master', 1)
            ->where('com_code', auth()->guard('admin')->user()->com_code)
            ->first();

       if ($Inv_uom) {
    return redirect()->back()
        ->withInput()//لإعادة تعبئة الحقول في النموذج
        ->with(
            'error',
            'يوجد وحده باسم (' . $Inv_uom->name . ')  ولا يمكن إضافة أكثر من وحده رئيسية'
        );
        }
    }
    // إضافة وحده
    Inv_uom::create([
        'name' => $request->name,
        'is_master' => $request->is_master,
        'active' => $request->active ?? 1,

        'added_by' => auth()->guard('admin')->id(),
        'com_code' => auth()->guard('admin')->user()->com_code,
        'date' => now()->toDateString(),
    ]);

    return redirect()
        ->route('admin.Inv_uom.create')
        ->with('success', 'تم إضافة الوحده بنجاح');
}


 public function edit($id){
        $data=Inv_uom::find($id);
        return view('admin.inv_uom.edit',compact('data'));
    }
     public function update($id,InvuomRequest $request){
        $data=Inv_uom::find($id);
        $data->fill([
            'name'=>$request->name,
            'is_master' => $request->is_master ?? 0,
            'active'=>$request->active ?? 0,
            'updated_by' => auth()->guard('admin')->id(),
            'added_by'=>auth()->guard('admin')->id(),
        ]);
            if (!$data->isDirty()) {//داله تعمل تحقق اذا تم تعديل اي حقل او لا
            return redirect()->route('admin.Inv_uom.index')->with('error', 'لم تقم بتعديل الوحده');
}
$data->save();
        return redirect()->route('admin.Inv_uom.index')->with('success','تم تعديل الوحده بنجاح');
     }
         public function delete_Inv_uom($id)
{
    $delete_Inv_uom = Inv_uom::find($id);

    if (!$delete_Inv_uom) {
        return redirect()->back()->with('error', 'السجل غير موجود');
    }



    $delete_Inv_uom->delete();

    return redirect()
        ->route('admin.Inv_uom.index')
        ->with(['success' => 'تم حذف الوحده بنجاح']);
}

}
