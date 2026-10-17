<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sales_Material_TypeRequest;
use App\Models\SalesMaterialType;
use Illuminate\Http\Request;

class SalesMaterialTypeController extends Controller
{
    //
    public function index(){
        $data=SalesMaterialType::select()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('admin.sales_material_type.index',compact('data'));
    }
    public function edit($id){
        $data=SalesMaterialType::find($id);
        return view('admin.sales_material_type.edit',compact('data'));
    }
     public function update($id,Sales_Material_TypeRequest $request){
        $data=SalesMaterialType::find($id);
        $data->fill([
            'name'=>$request->name,
            'active'=>$request->active ?? 0,
            'updated_by' => auth()->guard('admin')->id(),
        ]);
            if (!$data->isDirty()) {//داله تعمل تحقق اذا تم تعديل اي حقل او لا
            return redirect()->route('admin.sales_material_types.index')->with('error', 'لم تقم بتعديل الفئه');
}
$data->save();
        return redirect()->route('admin.sales_material_types.index')->with('success','تم تعديل الفئه بنجاح');
     }
    public function create(){
        return view('admin.sales_material_type.create');
    }
    public function store(Sales_Material_TypeRequest $request){
        // اضافه الفئه.
        SalesMaterialType::create([
            'name'=>$request->name,
            'active' => $request->active ?? 1,
            'added_by' => auth()->guard('admin')->id(),
            'updated_by' => auth()->guard('admin')->id(),
            'com_code' => auth()->guard('admin')->user()->com_code,
            'date' => now()->toDateString(),

        ]);
        return redirect()->route('admin.sales_material_types.index')->with('success','تم اضافه الفئه بنجاح');
    }
    public function delete_SalesMaterialType($id){
        $delete_SalesMaterialType=SalesMaterialType::find($id);
        $delete_SalesMaterialType->delete();
         return redirect()->back()->with('success', 'تم حذف الفئه الفاتوره بنجاح');
    }
   public function search(Request $request)
{
    $search = $request->input('search');

    $data = SalesMaterialType::where('name', 'LIKE', '%' . $search . '%')
        ->paginate(3)
        ->withQueryString();

      return view('admin.sales_Material_Type.index', compact('data', 'search'));
}

}
