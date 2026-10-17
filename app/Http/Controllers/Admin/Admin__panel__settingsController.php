<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin_Panel_Setting;
use Illuminate\Http\Request;
use App\Http\Requests\Admin__panel__settings;
use App\Models\Accauont;

class admin__panel__settingsController extends Controller
{
    //
    public function index(){
       $data = Admin_Panel_Setting::with('updatedBy','customerparentnumber','supplierparentnumber')
    ->where('com_code', auth()->guard('admin')->user()->com_code)
    ->first();
        if(!empty($data)){
            $data['system_name']=$data->system_name;
            $data['phone']=$data->phone;
            $data['active']=$data->active;
            $data['general_alert']=$data->general_alert;
            $data['address']=$data->address;
            $data['updated_by']=$data->updated_by;
        }
        return view('admin.admin__panel__settings.index',compact('data'));
    }
    public function edit(){
        $com_code=auth()->guard('admin')->user()->com_code;
        $data = Admin_Panel_Setting::where('com_code', $com_code)->first();
        $parient_accauont = Accauont::where('is_parent',1)->where('com_code', $com_code)->orderBy('id', 'DESC')->get();

        return view('admin.admin__panel__settings.edit',compact('data','parient_accauont'));
    }
    public function update(Admin__panel__settings $request){
        $data = Admin_Panel_Setting::where('com_code', auth()->guard('admin')->user()->com_code)->first();
        if(!empty($data)){
            $data->system_name=$request->system_name;
            $data->phone=$request->phone;
            $data->active=$request->active;
            $data->general_alert=$request->general_alert;
            $data->address=$request->address;
            $data->customer_parent_number=$request->customer_parent_number;
            $data->supplier_parent_number=$request->supplier_parent_number;
            $data->delegates_parent_number=$request->delegates_parent_number;
            $data->employees_parent_number=$request->employees_parent_number;
            $data->updated_by=auth()->guard('admin')->user()->id;
        //    $data->updated_at = date('Y-m-d h:i:s A');
            $data->save();
        }

        return redirect()->route('admin.admin__panel__setting.index')->with('success', 'تم تعديل الإعدادات بنجاح');

    }

}
