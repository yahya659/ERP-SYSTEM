@extends('layouts.admin')

@section('title')
    تعديل حساب المندوب
@endsection

@section('contentheader')
    تعديل حساب المندوب
@endsection

@section('contentlink')
    تعديل
@endsection

@section('this is teast')
    عرض
@endsection


@section('content')

    {{-- رسالة النجاح --}}
    @if(session('success'))
        <div style="
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


    {{-- رسالة الخطأ --}}
    @if(session('error'))
        <div style="
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
        ">
            {{ session('error') }}
        </div>
    @endif


    <div class="row">

        <div class="col-12">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">
                        تعديل حساب المندوب
                    </h3>
                </div>


                <div class="card-body">

                    @if($data)

                        <form action="{{ route('Delegates.update', $data->id) }}"
                              method="POST">

                            @csrf
                            @method('PUT')


                            <div class="row">

                                {{-- ========================= --}}
                                {{-- العمود الأول --}}
                                {{-- ========================= --}}

                                <div class="col-md-6">

                                    {{-- 1 اسم المندوب --}}
                                    <div class="form-group">

                                        <label for="name">
                                            اسم المندوب
                                        </label>

                                        <input type="text"
                                               name="name"
                                               id="name"
                                               class="form-control"
                                               value="{{ old('name', $data->name) }}" >

                                        @error('name')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>


                                    {{-- 2 حالة الرصيد --}}
                                    <div class="form-group">

                                        <label for="start_balance_status">
                                            حالة الرصيد أو المدة
                                        </label>

                                        <select name="start_balance_status" 
                                                id="start_balance_status"
                                                class="form-control">

                                            <option value="">
                                                اختر الحالة
                                            </option>

                                            <option value="1"
                                                {{ old('start_balance_status', $data->start_balance_status) == 1 ? 'selected' : '' }}>
                                                مدين
                                            </option>

                                            <option value="2"
                                                {{ old('start_balance_status', $data->start_balance_status) == 2 ? 'selected' : '' }}>
                                                دائن
                                            </option>

                                            <option value="0"
                                                {{ old('start_balance_status', $data->start_balance_status) == 0 ? 'selected' : '' }}>
                                                متزن
                                            </option>

                                        </select>

                                        @error('start_balance_status')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>


                                    {{-- 3 الرصيد الافتتاحي --}}
                                    <div class="form-group">

                                        <label for="start_balance">
                                            الرصيد الافتتاحي
                                        </label>

                                        <input type="number"
                                               name="start_balance"
                                               id="start_balance"
                                               class="form-control"
                                               value="{{ old('start_balance', $data->start_balance) }}">

                                        @error('start_balance')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>


                                    {{-- 4 الملاحظات --}}
                                    <div class="form-group">

                                        <label for="nodes">
                                            الملاحظات (اختياري)
                                        </label>

                                        <input type="text"
                                               name="nodes"
                                               id="nodes"
                                               class="form-control"
                                               value="{{ old('nodes', $data->nodes) }}">

                                        @error('nodes')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>


                                    {{-- 5 رقم المندوب --}}
                                    <div class="form-group">

                                        <label for="phone">
                                            رقم المندوب
                                        </label>

                                        <input type="text"
                                               name="phone"
                                               id="phone"
                                               class="form-control"
                                               inputmode="numeric"
                                               value="{{ old('phone', $data->phone) }}">

                                        @error('phone')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>


                                    {{-- 6 العنوان --}}
                                    <div class="form-group">

                                        <label for="address">
                                            عنوان المندوب
                                        </label>

                                        <input type="text"
                                               name="address"
                                               id="address"
                                               class="form-control"
                                               value="{{ old('address', $data->address) }}">

                                        @error('address')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>

                                </div>


                                {{-- ========================= --}}
                                {{-- العمود الثاني --}}
                                {{-- ========================= --}}

                                <div class="col-md-6">

                                    {{-- 1 حالة التفعيل --}}
                                    <div class="form-group">

                                        <label for="active">
                                            حالة التفعيل
                                        </label>

                                        <select name="active"
                                                id="active"
                                                class="form-control">

                                            <option value="">
                                                اختر الحالة
                                            </option>

                                            <option value="1"
                                                {{ old('active', $data->active) == 1 ? 'selected' : '' }}>
                                                نعم مفعل
                                            </option>

                                            <option value="0"
                                                {{ old('active', $data->active) == 0 ? 'selected' : '' }}>
                                                ليس مفعل
                                            </option>

                                        </select>

                                        @error('active')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>


                                    {{-- 2 نوع العمولة --}}
                                    <div class="form-group">

                                        <label for="parcent_type">
                                            نوع عمولة المندوب بالفواتير
                                        </label>

                                        <select name="parcent_type"
                                                id="parcent_type"
                                                class="form-control">

                                            <option value="">
                                                اختر الحالة
                                            </option>

                                            <option value="1"
                                                {{ old('parcent_type', $data->parcent_type) == 1 ? 'selected' : '' }}>
                                                أجر ثابت
                                            </option>

                                            <option value="2"
                                                {{ old('parcent_type', $data->parcent_type) == 2 ? 'selected' : '' }}>
                                                نسبة
                                            </option>

                                        </select>

                                        @error('parcent_type')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>


                                    {{-- 3 عمولة القطاعي --}}
                                    <div class="form-group">

                                        <label for="parcent_sales_commission_katai">
                                            نسبة المندوب من المبيعات القطاعي (تجزئة)
                                        </label>

                                        <input type="number"
                                               name="parcent_sales_commission_katai"
                                               id="parcent_sales_commission_katai"
                                               class="form-control"
                                               value="{{ old('parcent_sales_commission_katai', $data->parcent_sales_commission_katai) }}">

                                        @error('parcent_sales_commission_katai')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>


                                    {{-- 4 عمولة نصف الجملة --}}
                                    <div class="form-group">

                                        <label for="parcent_sales_commission_nosjamla">
                                            نسبة المندوب من مبيعات نصف الجملة
                                        </label>

                                        <input type="number"
                                               name="parcent_sales_commission_nosjamla"
                                               id="parcent_sales_commission_nosjamla"
                                               class="form-control"
                                               value="{{ old('parcent_sales_commission_nosjamla', $data->parcent_sales_commission_nosjamla) }}">

                                        @error('parcent_sales_commission_nosjamla')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>


                                    {{-- 5 عمولة الجملة --}}
                                    <div class="form-group">

                                        <label for="parcent_sales_commission_jomla">
                                            نسبة المندوب من مبيعات الجملة
                                        </label>

                                        <input type="number"
                                               name="parcent_sales_commission_jomla"
                                               id="parcent_sales_commission_jomla"
                                               class="form-control"
                                               value="{{ old('parcent_sales_commission_jomla', $data->parcent_sales_commission_jomla) }}">

                                        @error('parcent_sales_commission_jomla')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>


                                    {{-- 6 عمولة التحصيل --}}
                                    <div class="form-group">

                                        <label for="parcent_collection_commission">
                                            نسبة المندوب من تحصيل الفواتير - آجل
                                        </label>

                                        <input type="number"
                                               name="parcent_collection_commission"
                                               id="parcent_collection_commission"
                                               class="form-control"
                                               value="{{ old('parcent_collection_commission', $data->parcent_collection_commission) }}">

                                        @error('parcent_collection_commission')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>

                                </div>

                            </div>


                            {{-- الأزرار --}}
                            <div class="row">

                                <div class="col-12 mt-3">

                                    <button type="submit"
                                            class="btn btn-primary">
                                        تعديل
                                    </button>

                                    <button type="button"
                                            class="btn btn-danger"
                                            onclick="window.history.back()">
                                        الغاء
                                    </button>

                                </div>

                            </div>

                        </form>

                    @else

                        <div class="alert alert-danger text-center">
                            عفوا....لاتوجد حسابات لعرضها
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

@endsection
