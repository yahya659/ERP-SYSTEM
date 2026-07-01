<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvItemscardCategoryRequest;
use App\Models\InvItemscardCategory;
use Illuminate\Http\Request;

class InvItemscardCategoryController extends Controller
{
    public function index()
    {
     $data=InvItemscardCategory::select()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('admin.InvItemscardCategory.index',compact('data'));    }
        public function create(){
    return view('admin.InvItemscardCategory.create');
    }
  public function store(Request $request)
{
    $InvItemscardCategory = InvItemscardCategory::where('name', $request->name)
        ->where('com_code', auth()->guard('admin')->user()->com_code)
        ->first();

    if ($InvItemscardCategory) {

        return redirect()->back()
            ->withInput()
            ->with(
                'error',
                'الفئة (' . $InvItemscardCategory->name . ') موجودة مسبقاً'
            );
    }

    InvItemscardCategory::create([
        'name' => $request->name,
        'active' => $request->active ?? 1,
        'added_by' => auth()->guard('admin')->id(),
        'com_code' => auth()->guard('admin')->user()->com_code,
        'date' => now()->toDateString(),
    ]);

    return redirect()
        ->route('inv_itemscard_categories.create')
        ->with('success', 'تم إضافة الفئة بنجاح');
}

    public function edit(string $id)
    {
    $data=InvItemscardCategory::find($id);
        return view('admin.InvItemscardCategory.edit',compact('data'));
    }
 public function update(InvItemscardCategoryRequest $request,$id){
        $data=InvItemscardCategory::find($id);
        $data->fill([
            'name'=>$request->name,
            'active'=>$request->active ?? 0,
            'updated_by' => auth()->guard('admin')->id(),
            'added_by'=>auth()->guard('admin')->id(),
        ]);
            if (!$data->isDirty()) {//داله تعمل تحقق اذا تم تعديل اي حقل او لا
            return redirect()->route('inv_itemscard_categories.index')->with('error', 'لم تقم بتعديل الفئه الااصناف');
}
$data->save();
        return redirect()->route('inv_itemscard_categories.index')->with('success','تم تعديل فئه االااصناف بنجاح');
     }

// حذف اصناف البيااانات
    public function destroy(string $id)
    {
                $delete_InvItemscard=InvItemscardCategory::find($id);
                $delete_InvItemscard->delete();


    return redirect()
        ->route('inv_itemscard_categories.index')
        ->with(['success' => 'تم حذف فئه الااصناف بنجاح']);

    }
       public function search(Request $request)
{
    $search = $request->input('search');

    $data = InvItemscardCategory::where('name', 'LIKE', '%' . $search . '%')
        ->paginate(3)
        ->withQueryString();

      return view('admin.InvItemscardCategory.index', compact('data', 'search'));
}


}
