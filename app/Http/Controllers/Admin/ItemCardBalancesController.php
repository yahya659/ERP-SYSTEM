<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvItemBatch;
use App\Models\ItemCard;
use App\Models\Store;
use Illuminate\Http\Request;

class ItemCardBalancesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index()
{
    $com_code = auth()->guard('admin')->user()->com_code;

    // جلب الأصناف
    $allitemcarddata = ItemCard::where('com_code', $com_code)
        ->orderBy('id', 'DESC')
        ->paginate(PAGINATION_COUNT);

    // جلب الباتشات مع أسماء الخزن
    foreach ($allitemcarddata as $info) {
    $info->batches = InvItemBatch::where('com_code', $com_code)
        ->where('item_code', $info->item_code)
        ->with('storeid','invuomsid')
        ->get();
        $info->total_quantity = $info->batches->sum('quantity');
}

    return view(
        'admin.itemcardbalances.index',
        compact('allitemcarddata')
    );
}

public function search(Request $request)
{
    $com_code = auth()->guard('admin')->user()->com_code;

    $search = $request->input('search');
    $itemCode = $request->input('item_code');

    // جلب الأصناف حسب البحث
    $allitemcarddata = ItemCard::where('com_code', $com_code)
        ->when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })
        ->when($itemCode, function ($query) use ($itemCode) {
            $query->where('item_code', 'LIKE', '%' . $itemCode . '%');
        })
        ->orderBy('id', 'DESC')
        ->paginate(3)
        ->withQueryString();

    // جلب باتشات كل صنف مع اسم الخزن
    foreach ($allitemcarddata as $info) {
        $info->batches = InvItemBatch::where('com_code', $com_code)
            ->where('item_code', $info->item_code)
            ->with('storeid')
            ->get();
                    $info->total_quantity = $info->batches->sum('quantity');

    }

    return view(
        'admin.itemcardbalances.index',
        compact('allitemcarddata', 'search', 'itemCode')
    );
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
