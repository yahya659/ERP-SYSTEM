<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuppliersCategoryRequest;
use App\Models\SuppliersCategory;
use Illuminate\Http\Request;

class SuppliersCategoryController extends Controller
{
    public function index()
    {
           $data=SuppliersCategory::select()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('admin.suppliers_Category.index',compact('data'));
        // return view('admin.customers.index',compact('data','searchType','search'));

    }


    public function create()
    {
        return view('admin.suppliers_Category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    $SuppliersCategory = SuppliersCategory::where('name', $request->name)
        ->where('com_code', auth()->guard('admin')->user()->com_code)
        ->first();

    if ($SuppliersCategory) {

        return redirect()->back()
            ->withInput()
            ->with(
                'error',
                'الفئة (' . $SuppliersCategory->name . ') موجودة مسبقاً'
            );
    }

    SuppliersCategory::create([
        'name' => $request->name,
        'active' => $request->active ?? 1,
        'added_by' => auth()->guard('admin')->id(),
        'com_code' => auth()->guard('admin')->user()->com_code,
        'date' => now()->toDateString(),
    ]);

    return redirect()
        ->route('Suppliers_Category.index')
        ->with('success', 'تم إضافة الفئة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

 public function edit($id){
        $data=SuppliersCategory::find($id);
        return view('admin.suppliers_Category.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(SuppliersCategoryRequest $request,$id){
        $data=SuppliersCategory::find($id);
        $data->fill([
            'name'=>$request->name,
            'active'=>$request->active ?? 1,
            'updated_by' => auth()->guard('admin')->id(),
            
        ]);
            if (!$data->isDirty()) {//داله تعمل تحقق اذا تم تعديل اي حقل او لا
            return redirect()->route('Suppliers_Category.index')->with('error', 'لم تقم بتعديل الفئه المورد');
}
$data->save();
        return redirect()->route('Suppliers_Category.index')->with('success','تم تعديل فئه المورد بنجاح');
     }


    public function destroy(string $id)

{
    $Suppliers = SuppliersCategory::find($id);
    $Suppliers->delete();
        return redirect()->route('Suppliers_Category.index')
            ->with('success', 'تم الحذف بنجاح');

    }
       public function search(Request $request)
{
    $search = $request->input('search');

    $data = SuppliersCategory::where('name', 'LIKE', '%' . $search . '%')
        ->paginate(3)
        ->withQueryString();

      return view('admin.suppliers_Category.index', compact('data', 'search'));
}
}
