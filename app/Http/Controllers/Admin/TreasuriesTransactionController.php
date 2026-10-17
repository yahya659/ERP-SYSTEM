<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTreasuriesTransactionRequest;
use App\Models\Accauont;
use App\Models\Admin_Shift;
use App\Models\MovType;
use App\Models\TreasuriesTransaction;
use App\Models\Treasury;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class TreasuriesTransactionController extends Controller
{

public function index(Request $request)
{
    $com_code = auth()->guard('admin')->user()->com_code;

    // حركات الخزينة
    $query = TreasuriesTransaction::select()
        ->with('treasury', 'account', 'adminShift', 'movType','addedBy')
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
        ->where('is_private_internal', 0)
        // لحركات العامة وليس الحركات الخاصة بالعمليات الداخلية
        ->orderBy('id', 'DESC')
        ->get();


    $accauont = Accauont::where('com_code', $com_code)
        ->where('is_parent', 0)
        ->where('is_archived', 1)
        ->orderBy('id', 'DESC')
        ->get();


    // خاصه بتحصيل الشفت الذي تم اغلاقه
    $adminsift = Admin_Shift::where('com_code', $com_code)
        ->where('admin_id', auth()->guard('admin')->id())
        ->where('is_finished', 0)
        ->with(['adminname', 'treasuriesname'])
        ->first();


    // جمع الرصيد المتاح في الخزنه
    $treasuriesBalance = 0;

    if ($adminsift) {

        $treasuriesBalance = TreasuriesTransaction::where(
            'treasuries_id',
            $adminsift->treasuries_id
        )->sum('money');
    }


    return view(
        'admin.TreasuriesTransaction.index',
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
        // return view('admin.TreasuriesTransaction.create');
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(StoreTreasuriesTransactionRequest $request)
{
    $com_code = auth()->guard('admin')->user()->com_code;
    $admin_id = auth()->guard('admin')->id();

    // التحقق من وجود شفت مفتوح
    $adminShift = Admin_Shift::where('id', $request->admin_shift_id)
        ->where('com_code', $com_code)
        ->where('admin_id', $admin_id)
        ->where('is_finished', 0)
        ->first();

    if (!$adminShift) {
        return redirect()->back()
            ->with('error', 'لا يوجد شفت مفتوح');
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
$balanceBefore = $accauont->current_balance ?? 0;

// إضافة الدين الجديد على حساب المورد
if ($balanceBefore >= 0) {
    $balanceAfter = $balanceBefore - $request->money;
} else {
    // الحساب دائن: زيادة الدين لصالح المورد
    $balanceAfter = $balanceBefore + $request->money;
}

// تحديث رصيد الحساب
$accauont->current_balance = $balanceAfter;
$accauont->save();

// أثر العملية على الحساب
$moneyForAccount = -$request->money;

            /*
             * ==========================================
             * زيادة رقم سند التحصيل
             * ==========================================
             */

            $treasury->last_isal_collection =
                $treasury->last_isal_collection + 1;

            $isal_number =
                $treasury->last_isal_collection;

            $treasury->save();

            /*
             * ==========================================
             * آخر رقم تسلسلي
             * ==========================================
             */

            $lastAutoSerial =
                TreasuriesTransaction::max('auto_serial') ?? 100;

            $autoSerial =
                $lastAutoSerial + 1;

            /*
             * ==========================================
             * تسجيل حركة التحصيل
             * ==========================================
             */

            TreasuriesTransaction::create([

                'treasuries_id' =>
                    $adminShift->treasuries_id,

                'mov_type' =>
                    $request->mov_type,

                'accauont_number' =>
                    $request->accauont_number,

                'is_accauont' => 1,

                'is_Approved' => 1,

                'admin_shift_id' =>
                    $adminShift->id,

                // التحصيل يزيد الخزينة
                'money' =>
                    $request->money,

                // أثر التحصيل على الحساب
                'money_for_accauont' =>
                    $moneyForAccount,

                'move_date' =>
                    $request->move_date,

                'isal_number' =>
                    $isal_number,

                'auto_serial' =>
                    $autoSerial,

                'bayan' =>
                    $request->bayan,

                'added_by' =>
                    $admin_id,

                'com_code' =>
                    $com_code,
            ]);
        });

        return redirect()->back()
            ->with(
                'success',
                'تم تحصيل المبلغ وتحديث رصيد الحساب بنجاح'
            );

    } catch (\Exception $e) {

        return redirect()->back()
            ->withInput()
            ->with(
                'error',
                'حدث خطأ أثناء تنفيذ عملية التحصيل: '
                . $e->getMessage()
            );
    }
}
public function searchBySerial($auto_serial)
{
    $com_code = auth()->guard('admin')->user()->com_code;

    $data = TreasuriesTransaction::where('auto_serial', $auto_serial)
        ->where('com_code', $com_code)
        ->first();

    if (!$data) {
        return response()->json([
            'status' => false,
            'message' => 'لم يتم العثور على حركة الخزينة',
        ]);
    }

    return response()->json([
        'status' => true,
        'data' => $data,
    ]);
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
