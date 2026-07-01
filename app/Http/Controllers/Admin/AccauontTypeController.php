<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountType;
use Illuminate\Http\Request;

class AccauontTypeController extends Controller
{

    public function index()
    {
        $data=AccountType::select()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('admin.accauont_types.index',compact('data'));

    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
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
      public function search(Request $request)
{
    $search = $request->input('search');

    $data = AccountType::where('name', 'LIKE', '%' . $search . '%')
        ->paginate(3)
        ->withQueryString();

      return view('admin.accauont_types.index', compact('data', 'search'));
}
}
