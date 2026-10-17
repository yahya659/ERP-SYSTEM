<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminShiftRequest;
use App\Models\Admin_Shift;
use App\Models\AdminTreasury;
use Illuminate\Http\Request;

class AdminShiftController extends Controller
{

    public function index()
    {
        $data=Admin_Shift::select()->orderBy('id','DESC')->get();
        if(!$data){
            return redirect()->back();
        }
        return view('admin.admins_shift.index',compact('data'));
    }



public function create()
{
   $admin = auth()->guard('admin')->user();

$treasuries = $admin->treasuries;// مباشرة من العلاقة الجديدة،في الادمن وفيها فلتر active تلقائيًا

foreach ($treasuries as $treasury) {
    // لمعرفه ن الخزنه مستخدمه من مستخدم اخر

    $treasury->is_busy = Admin_Shift::where('treasuries_id', $treasury->id)
        ->where('is_finished', 0)
        ->where('admin_id', '!=', $admin->id)
        ->exists();
}

    return view('admin.admins_shift.create', compact('treasuries'));
}
    public function store(AdminShiftRequest $request)
    {

          $com_code = auth()->guard('admin')->user()->com_code;
          $admin_id=auth()->guard('admin')->id();
        $cheack=Admin_Shift::where(['com_code'=>$com_code,'admin_id'=>$admin_id,'is_finished'=>0])->first();
        if($cheack !=null){
             return redirect()->route('admins_shift.index')
        ->with('error', 'عفوا هناك شفت مفتوح لديك حاليا ولايمكن فتح شفت جديد الا بعد اغلاق شفت الحالي ');

        }
        Admin_Shift::create([
        'admin_id' => $admin_id,
        'treasuries_id' => $request->treasuries_id,
        'start_date' => date('Y-m-d H:i:s'),
        'end_date' => null,
        // 'treasuries_balance_in_shift_start'=>$request->treasuries_balance_in_shift_start ?? 0,
        'date' => now()->toDateString(),
        'is_finished'=>$request->is_finished ?? 0,
        'added_by' => auth()->guard('admin')->id(),
        'updated_by' => auth()->guard('admin')->id(),
        'com_code' => auth()->guard('admin')->user()->com_code,

    ]);


 return redirect()->route('admins_shift.index')
        ->with('success', 'تم  فتح الشفت  بنجاح');
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
