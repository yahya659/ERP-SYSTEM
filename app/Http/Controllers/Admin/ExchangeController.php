<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExchangeStoreRequest;
use App\Models\Accauont;
use App\Models\Admin_Shift;
use App\Models\MovType;
use App\Models\TreasuriesTransaction;
use App\Models\Treasury;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ExchangeController extends Controller
{
//    صرف من الخزنه
  public function index(Request $request)
{
    $com_code = auth()->guard('admin')->user()->com_code;

    // حركات الصرف
    $query = TreasuriesTransaction::select()
        ->with('treasury', 'account', 'adminShift', 'movType')
        ->where('com_code', $com_code);

    // البحث بالرقم التسلسلي
    if ($request->filled('auto_serial')) {

        $query->where(
            'auto_serial',
            $request->auto_serial
        );
    }

    $data = $query
        ->orderBy('id', 'DESC')
        ->paginate(PAGINATION_COUNT)
        ->withQueryString();


    $movTypes = MovType::where('active', 1)
        ->where('is_private_internal', 1)
        // حركات الصرف الخاصة بالعمليات الداخلية
        ->orderBy('id', 'DESC')
        ->get();


    // إرسال الحسابات
    $accauont = Accauont::where('com_code', $com_code)
        ->where('is_parent', 0)
        ->where('is_archived', 1)
        ->orderBy('id', 'DESC')
        ->get();


    // الشفت الحالي
    $adminsift = Admin_Shift::where('com_code', $com_code)
        ->where('admin_id', auth()->guard('admin')->id())
        ->where('is_finished', 0)
        ->with(['adminname', 'treasuriesname'])
        ->first();


    // جمع الرصيد المتاح في الخزينة
    $treasuriesBalance = 0;

    if ($adminsift) {

        $treasuriesBalance = TreasuriesTransaction::where(
            'treasuries_id',
            $adminsift->treasuries_id
        )->sum('money');
    }


    return view(
        'admin.Exchange.index',
        compact(
            'data',
            'adminsift',
            'accauont',
            'movTypes',
            'treasuriesBalance'
        )
    );
}
    public function create()
    {
        //
    }
public function store(ExchangeStoreRequest $request)
{
    $com_code = auth()->guard('admin')->user()->com_code;
    $admin_id = auth()->guard('admin')->id();

    // التحقق من الشفت
    $adminShift = Admin_Shift::where('id', $request->admin_shift_id)
        ->where('com_code', $com_code)
        ->where('admin_id', $admin_id)
        ->where('is_finished', 0)
        ->first();

    if (!$adminShift) {
        return redirect()->back()
            ->with('error', 'لا يوجد شفت مفتوح');
    }

    // حساب رصيد الخزينة الحالي
    $treasuriesBalance = TreasuriesTransaction::where(
        'treasuries_id',
        $adminShift->treasuries_id
    )->sum('money');

    // التحقق من كفاية الرصيد
    if ($request->money > $treasuriesBalance) {
        return redirect()->back()
            ->withInput()
            ->with(
                'error',
                'لا يمكن تنفيذ عملية الصرف، رصيد الخزينة أقل من مبلغ الصرف'
            );
    }

    // جلب الخزينة
    $treasury = Treasury::find($adminShift->treasuries_id);

    if (!$treasury) {
        return redirect()->back()
            ->with('error', 'الخزينة غير موجودة');
    }

    try {

        DB::transaction(function () use (
            $request,
            $adminShift,
            $treasury,
            $com_code,
            $admin_id
        ) {

            // جلب الحساب المالي
            $accauont = Accauont::find($request->accauont_number);

            if (!$accauont) {
                throw new \Exception('الحساب المالي غير موجود');
            }

            // زيادة رقم سند الصرف
            $treasury->last_isal_exchange =
                $treasury->last_isal_exchange + 1;

            $isal_number = $treasury->last_isal_exchange;

            $treasury->save();

            // آخر رقم تسلسلي للحركة
            $lastAutoSerial =
                TreasuriesTransaction::max('auto_serial') ?? 100;

            $autoSerial = $lastAutoSerial + 1;

            /*
             * ==========================================
             * حساب رصيد الحساب قبل وبعد الصرف
             * ==========================================
             */

            $balanceBefore = $accauont->current_balance ?? 0;


            $balanceAfter = $balanceBefore + $request->money;

            /*
             * ==========================================
             * تحديث رصيد الحساب
             * ==========================================
             */

            $accauont->current_balance = $balanceAfter;
            $accauont->save();

            /*
             * ==========================================
             * تسجيل حركة الخزينة
             * ==========================================
             */

            TreasuriesTransaction::create([

                'treasuries_id' => $adminShift->treasuries_id,

                'mov_type' => $request->mov_type,

                'accauont_number' => $request->accauont_number,

                'is_accauont' => 1,

                'is_Approved' => 1,

                'admin_shift_id' => $adminShift->id,

                // المبلغ ينقص من الخزينة
                'money' => $request->money * -1,

                // أثر الصرف على الحساب
                'money_for_accauont' => $request->money,

                'move_date' => $request->move_date,

                'isal_number' => $isal_number,

                'auto_serial' => $autoSerial,

                'bayan' => $request->bayan,

                'added_by' => $admin_id,

                'com_code' => $com_code,
            ]);
        });

        return redirect()->back()
            ->with('success', 'تم صرف المبلغ وتحديث رصيد الحساب بنجاح');

    } catch (\Exception $e) {

        return redirect()->back()
            ->withInput()
            ->with(
                'error',
                'حدث خطأ أثناء تنفيذ عملية الصرف: ' . $e->getMessage()
            );
    }
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
