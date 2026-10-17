@extends('layouts.admin')
@section('title')

    شاشه صرف النقديه
@endsection

@section('contentheader')
    الحسابات
@endsection
@section('contentlink')
    <a href="{{ route('TreasuriesTransaction.index') }}"> بيانات صرف النقديه</a>

@endsection
@section('this is teast')
    عرض
@endsection
@if(session('success'))
    <div
        style="
                                                                                                                                                                            background-color: #d4edda;
                                                                                                                                                                            color: #155724;
                                                                                                                                                                            border: 1px solid #c3e6cb;
                                                                                                                                                                            padding: 15px;
                                                                                                                                                                            border-radius: 5px;
                                                                                                                                                                            margin-bottom: 20px;
                                                                                                                                                                            font-weight: bold;
                                                                                                                                                                            text-align: center;
                                                                                                                                                                        ">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="
                                                                                                                            background-color: #d82f15;
                                                                                                                            color: #c3e6cb;
                                                                                                                            border: 1px solid #c3e6cb;
                                                                                                                            padding: 15px;
                                                                                                                            border-radius: 5px;
                                                                                                                            margin-bottom: 20px;
                                                                                                                            font-weight: bold;
                                                                                                                            text-align: center;
                                                                                                                        ">
        {{ session('error') }}
    </div>
@endif

@section('content')
    <div class="row">
        <div class="col-12">

         <form action="{{ route('Exchange.store') }}" method="POST" class="card shadow-sm border-0">
    @csrf

    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            صرف مبلغ مالي
        </h5>
    </div>

    <div class="card-body">

        @if ($adminsift)

         <div class="row g-3">

    {{-- الخزينة والشفت --}}
    <div class="col-md-6">
        <label class="form-label fw-bold">
            الخزينة
        </label>

        <select name="admin_shift_id" id="admin_shift_id" class="form-select">

            <option value="{{ $adminsift->id }}">
                {{ $adminsift->treasuriesname->name ?? 'لا يوجد اسم' }}
            </option>

        </select>

        @error('admin_shift_id')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror
    </div>


    {{-- الحساب المالي --}}
    <div class="col-md-6">
        <label class="form-label fw-bold">
            الحساب المالي
        </label>

        <select name="accauont_number" id="accauont_number" class="form-select">

            <option value="">
                اختر الحساب المالي المحصل منه
            </option>

            @foreach ($accauont as $account)
                <option
                  data-account-type="{{ $account->accauonttypes->id }}"
                   data-balance="{{ $account->current_balance ?? 0 }}"
                    value="{{ $account->id }}"
                    {{ old('accauont_number') == $account->id ? 'selected' : '' }}
                >
                   {{ $account->name }} ({{ $account->accauonttypes->name }}){{ $account->accauonttypes->id }}"
                </option>
            @endforeach

        </select>

        @error('accauont_number')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror
    </div>


    {{-- نوع الحركه --}}
    {{-- نوع الحركة --}}
<div class="col-md-6">

    <label class="form-label fw-bold">
        نوع الحركة
    </label>

    <select id="mov_type_select" class="form-select">

        <option value="">
            يتم تحديد نوع الحركة تلقائيًا
        </option>

        @foreach ($movTypes as $movType)

            <option
                value="{{ $movType->id }}"
                disabled
            >
                {{ $movType->name }}
            </option>

        @endforeach

    </select>

    {{-- هذا الذي يتم إرساله إلى Controller --}}
    <input
        type="hidden"
        name="mov_type"
        id="mov_type"
    >

</div>


    {{-- قيمة المبلغ --}}
    <div class="col-md-6">
        <label for="money" class="form-label fw-bold">
            قيمة المبلغ الصرف
        </label>

        <input
            type="number"
            name="money"
            id="money"
            class="form-control"
            value="{{ old('money') }}"
            placeholder="أدخل قيمة المبلغ"
        >

        @error('money')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror
    </div>


    {{-- تاريخ الحركة --}}
    <div class="col-md-6">
        <label for="move_date" class="form-label fw-bold">
            تاريخ الحركة
        </label>

        <input
            type="date"
            name="move_date"
            id="move_date"
            class="form-control"
            value="{{ old('move_date', date('Y-m-d')) }}" readonly
        >

        @error('move_date')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror
    </div>


    {{-- الرصيد المتاح --}}
    <div class="col-md-6">
        <label for="treasuries_balnce" class="form-label fw-bold">
            الرصيد المتاح في الخزينة
        </label>

        <input
                type="number"
                name="treasuries_balnce"
                id="treasuries_balnce"
                class="form-control bg-light"
                value="{{ $treasuriesBalance * 1 ?? 0 }}"
                readonly
        >

        @error('treasuries_balnce')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror
    </div>


    {{-- البيان --}}
    <div class="col-md-6">
        <label for="bayan" class="form-label fw-bold">
            البيان
        </label>

        <textarea
            name="bayan"
            id="bayan"
            class="form-control"
            rows="3"
            placeholder="أدخل بيان الحركة"
        >{{ old('bayan','صرف مقابل') }}</textarea>

        @error('bayan')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror
    </div>
        {{-- رصيد الحساب --}}
<div class="col-md-6" id="account_balance_box" style="display: none;">

    <label class="form-label fw-bold">
        بيانات رصيد الحساب
    </label>

    <div class="card border-0 shadow-sm bg-light mb-0">

        <div class="card-body py-3">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <small class="text-muted d-block">
                        الرصيد الحالي
                    </small>

                    <strong
                        id="account_current_balance"
                        style="font-size: 20px;">
                        0
                    </strong>
                </div>

                <div class="text-right">

                    <small class="text-muted d-block">
                        حالة الحساب
                    </small>

                    <strong
                        id="account_balance_status"
                        style="font-size: 18px;">
                        -
                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>

</div>

            <div class="card-footer bg-light text-end">

                <button type="submit" class="btn btn-success px-4">
                   صرف
                </button>

            </div>

        @else

            <div class="alert alert-warning mb-0 text-center">
                لا يوجد شفت مفتوح لكي تتمكن من الصرف
            </div>

        @endif

    </div>

</form>
{{-- ----------------------------- --}}



<form action="{{ route('Exchange.index') }}" method="GET" class="mb-3">

    <div class="row">

        <div class="col-md-4">
            <label>البحث بالرقم التسلسلي :</label>

            <input
                type="number"
                name="auto_serial"
                class="form-control"
                placeholder="أدخل الرقم التسلسلي"
                value="{{ request('auto_serial') }}"
            >
        </div>

        <div class="col-md-2 d-flex align-items-end">

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
                بحث
            </button>

        </div>

        <div class="col-md-2 d-flex align-items-end">

            <a href="{{ route('Exchange.index') }}"
               class="btn btn-secondary">
                عرض الجميع
            </a>

        </div>

    </div>

</form>
            {{-- @endforeach --}}

            @if($data->isNotEmpty())

                <div class="card">


                    </div>
                    <div class="card-header">

                        <h3 class="card-title card_title_center">بيانات المستخدمين لحركه شفت الخزينه</h3>

                    </div>


                    <div class="card-body">

                        <div class="table-responsive">


                            <table id="example2" class="table table-bordered table-hover" >
                                <thead class="custom_thead">
                                    <th>رقم تسلسلي تلقائي</th>
                                    <th>اسم الخزنه</th>
                                    <th> الحركه</th>
                                    <th>كود الحركة في الجدول المرتبط</th>
                                    <th>رقم الحساب المالي</th>
                                    <th>هل الحركة مرتبطة بحساب مالي</th>
                                    <th>معتمد</th>
                                    <th>شفت المستخدم</th>
                                    <th>المبلغ المصروف أو المحصل من الخزينة</th>
                                    <th> المبلغ المستحق للحساب أو على الحساب</th>
                                    <th> البيان</th>
                                    {{-- <th>حاله التفعيل</th> --}}
                                    {{-- <th></th> --}}
                                </thead>

                                <tbody>
                                    @foreach($data as $info)

                                        <tr>
                                            <td>
                                                {{ $info->auto_serial }}

                                                @if($info->is_finished == 0 && $info->admin_id == auth()->guard('admin')->id())
                                                    <br>
                                                    <span class="badge badge-danger mt-1">
                                                        شفتك الحالي
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $info->treasury->name ?? 'لايوجد اسم ' }}</td>
                                            <td>{{ $info->movType->name ?? 'لايوجد'}}</td>
                                            <td>{{ $info->the_forign_key ?? 'لايوجد'}}</td>
                                            <td>
                                                <div class="fw-bold">
                                                    {{ $info->account->accauonttypes->name ?? 'لا يوجد' }}
                                                </div>
                                                <span class="badge bg-secondary">
                                                    رقم الحساب: {{ $info->account->id }}

                                                </span>
                                                <span class="badge bg-secondary">

                                                    اسم الحساب: {{ $info->account->name }}
                                                </span>
                                            </td>
                                            <td>{{ $info->is_accauont == 1 ? 'نعم ' : 'لا' }}</td>
                                            <td>{{ $info->is_Approved == 1 ? 'نعم ' : 'لا' }}</td>
                                            <td>{{ $info->adminShift->adminname->name ?? 'لا يوجد' }}</td>
                                            <td>{{ $info->money*1  ?? 'لايوجد'}}</td>
                                            <td>{{ $info->money_for_accauont *1 ?? 'لايوجد'}}</td>
                                           <td>
                                                {{ $info->bayan ?? 'لايوجد' }}

                                                <br>

                                                <small class="text-muted">
                                                    {{-- <i class="fas fa-calendar"></i> --}}
                                                    {{ $info->created_at->format('Y-m-d') }}

                                                    <br>

                                                    {{-- <i class="fas fa-clock"></i> --}}
                                                    {{ $info->created_at->format('h:i') }}
                                                    {{ $info->created_at->format('A') == 'AM' ? 'صباحًا' : 'مساءً' }}
                                                </small>
                                            </td>
                                            {{-- <td>
                                                 <div class="d-flex justify-content-center">
                                                    <a href="" class="btn btn-sm btn-success mr-2">
                                                        <i class="fas fa-print"></i> طباعة
                                                    </a>

                                                    <a href=""
                                                        class="btn btn-sm btn-info">
                                                        <i class="fas fa-file-alt"></i> المزيد
                                                    </a>
                                                </div>
                                            </td> --}}

                                        </tr>

                                    @endforeach

                                </tbody>



                            </table>
                            {{ $data->links() }}
                        </div>
                    </div>

            @else

                    <div class="alert alert-danger text-center">
                        عفوا....لاتوجد بيانات لعرضها
                    </div>

                @endif

            </div>
        </div>
    </div>
         <script src="{{ asset('assets/admin/dist/js/exchange.js') }}"></script>

@endsection
