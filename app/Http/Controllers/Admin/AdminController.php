<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminTreasury;
use App\Models\Treasury;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {
        $data=Admin::select()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('admin.admin_accauonts.index',compact('data'));
    }
public function detalls($id)
{
    $data = Admin::find($id);

    if(!$data){
        return redirect()->back();
    }
    $admin_treasury = AdminTreasury::where('admin_id', $id)->orderBy('id', 'DESC')->get();
    $treasury=Treasury::select()->orderBy('id','DESC')->get();

    return view('admin.admin_accauonts.detalls', ['data' => $data,'admin_treasury' => $admin_treasury,'treasury'=>$treasury]);
}
// اضاف الخزن للمستخدم
public function add_new_admin_treasuries(Request $request)
{
    $com_code = auth()->guard('admin')->user()->com_code;
    // التحقق هل الخزنة موجودة مسبقاً لهذا المستخدم
    $check = AdminTreasury::where(['admin_id' => $request->admin_id,'treasuries_id' => $request->treasuries_id])->first();
    if ($check) {
        return redirect()->back()
            ->with('error', 'هذه الخزنة مسلمة للمستخدم من قبل');
    }

    AdminTreasury::create([
        'admin_id' => $request->admin_id,
        'treasuries_id' => $request->treasuries_id,
        'active' => 1,
        'com_code' => $com_code,
        'added_by' => auth()->guard('admin')->id(),
        'updated_by' => auth()->guard('admin')->id(),
    ]);

    return redirect()->back()
        ->with('success', 'تم إضافة الخزنة للمستخدم بنجاح');
}


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
