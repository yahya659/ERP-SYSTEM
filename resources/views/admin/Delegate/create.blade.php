@extends('layouts.admin')
@section('title')

    اضافه حساب مندوب
@endsection

@section('contentheader')
    اضافه حساب مندوب
@endsection
@section('contentlink')
    اضافه حساب مندوب
@endsection
@section('this is teast')
    عرض
@endsection
@section('content')
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
        <div
            style="
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

   <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center"> اضافه حساب المندوب
                </h3>
            </div>

            <div class="card-body">
             <form action="{{ route('Delegates.store') }}" method="POST">
    @csrf

    <div class="row">

        {{-- العمود الأول --}}
        <div class="col-md-6">

            {{-- 1 اسم المندوب --}}
            <div class="form-group">
                <label for="name">اسم المندوب</label>

                <input type="text"
                       name="name"
                       id="name"
                       class="form-control"
                       value="{{ old('name') }}">

                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            {{-- 2 حالة الرصيد --}}
            <div class="form-group">
                <label for="start_balance_status">حالة الرصيد أو المدة</label>

                <select name="start_balance_status"
                        id="start_balance_status"
                        class="form-control">

                    <option value="">اختر الحالة</option>

                    <option value="1"
                        {{ old('start_balance_status') == 1 ? 'selected' : '' }}>
                        مدين
                    </option>

                    <option value="2"
                        {{ old('start_balance_status') == 2 ? 'selected' : '' }}>
                        دائن
                    </option>

                    <option value="0"
                        {{ old('start_balance_status') == 0 ? 'selected' : '' }}>
                        متزن
                    </option>

                </select>

                @error('start_balance_status')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            {{-- 3 الرصيد الافتتاحي --}}
            <div class="form-group">
                <label for="start_balance">الرصيد الافتتاحي</label>

                <input type="number"
                       name="start_balance"
                       id="start_balance"
                       class="form-control"
                       value="{{ old('start_balance', 0) }}">

                @error('start_balance')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            {{-- 4 الملاحظات --}}
            <div class="form-group">
                <label for="nodes">الملاحظات (اختياري)</label>

                <input type="text"
                       name="nodes"
                       id="nodes"
                       class="form-control"
                       value="{{ old('nodes') }}">
            </div>


            {{-- 5 رقم المندوب --}}
            <div class="form-group">
                <label for="phone">رقم المندوب</label>

                <input type="text"
                       name="phone"
                       id="phone"
                       class="form-control"
                       inputmode="numeric"
                       value="{{ old('phone') }}">

                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            {{-- 6 عنوان المندوب --}}
            <div class="form-group">
                <label for="address">عنوان المندوب</label>

                <input type="text"
                       name="address"
                       id="address"
                       class="form-control"
                       value="{{ old('address') }}">

                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

        </div>


        {{-- العمود الثاني --}}
        <div class="col-md-6">

            {{-- 1 حالة التفعيل --}}
            <div class="form-group">
                <label for="active">حالة التفعيل</label>

                <select name="active"
                        id="active"
                        class="form-control">

                    <option value="">اختر الحالة</option>

                    <option value="1"
                        {{ old('active') == 1 ? 'selected' : '' }}>
                        نعم مفعل
                    </option>

                    <option value="0"
                        {{ old('active') == 0 ? 'selected' : '' }}>
                        ليس مفعل
                    </option>

                </select>

                @error('active')
                    <span class="text-danger">{{ $message }}</span>
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

                    <option value="">اختر الحالة</option>

                    <option value="1"
                        {{ old('parcent_type') == 1 ? 'selected' : '' }}>
                        أجر ثابت
                    </option>

                    <option value="2"
                        {{ old('parcent_type') == 2 ? 'selected' : '' }}>
                        نسبة
                    </option>

                </select>

                @error('parcent_type')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            {{-- 3 قطاعي --}}
            <div class="form-group">
                <label for="parcent_sales_commission_katai">
                    نسبة المندوب من المبيعات القطاعي (تجزئة)
                </label>

                <input type="number"
                       name="parcent_sales_commission_katai"
                       id="parcent_sales_commission_katai"
                       class="form-control"
                       value="{{ old('parcent_sales_commission_katai', 0) }}">

                @error('parcent_sales_commission_katai')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            {{-- 4 نصف الجملة --}}
            <div class="form-group">
                <label for="parcent_sales_commission_nosjamla">
                    نسبة المندوب من مبيعات نصف الجملة
                </label>

                <input type="number"
                       name="parcent_sales_commission_nosjamla"
                       id="parcent_sales_commission_nosjamla"
                       class="form-control"
                       value="{{ old('parcent_sales_commission_nosjamla', 0) }}">

                @error('parcent_sales_commission_nosjamla')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            {{-- 5 الجملة --}}
            <div class="form-group">
                <label for="parcent_sales_commission_jomla">
                    نسبة المندوب من مبيعات الجملة
                </label>

                <input type="number"
                       name="parcent_sales_commission_jomla"
                       id="parcent_sales_commission_jomla"
                       class="form-control"
                       value="{{ old('parcent_sales_commission_jomla', 0) }}">

                @error('parcent_sales_commission_jomla')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            {{-- 6 التحصيل --}}
            <div class="form-group">
                <label for="parcent_collection_commission">
                    نسبة المندوب من تحصيل الفواتير - آجل
                </label>

                <input type="number"
                       name="parcent_collection_commission"
                       id="parcent_collection_commission"
                       class="form-control"
                       value="{{ old('parcent_collection_commission', 0) }}">

                @error('parcent_collection_commission')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

        </div>

    </div>


    {{-- الأزرار --}}
    <div class="row">
        <div class="col-12 mt-3">

            <button type="submit" class="btn btn-primary">
                اضافة
            </button>

            <button type="button"
                    class="btn btn-danger"
                    onclick="window.history.back()">
                الغاء
            </button>

        </div>
    </div>

</form>
            </div>
        </div>
    </div>
</div>
    </div>
    <script>

        document.getElementById('start_balance_status').addEventListener('change', function () {

            let status = this.value;
            let balanceInput = document.getElementById('start_balance');


            // لم يتم اختيار الحالة
            if (status == "") {

                balanceInput.value = "";
                balanceInput.readOnly = true;

            }

            // متزن
            else if (status == 0) {

                balanceInput.value = 0;
                balanceInput.readOnly = true;

            }

            // مدين
            else if (status == 1) {

                balanceInput.readOnly = false;
                balanceInput.value = "";

            }

            // دائن
            else if (status == 2) {

                balanceInput.readOnly = false;
                balanceInput.value = "";

            }

        });


        // منع الإدخال قبل اختيار الحالة
        document.getElementById('start_balance').addEventListener('input', function () {

            let status = document.getElementById('start_balance_status').value;


            if (status == "") {

                this.value = "";

                alert("يجب أولاً تحديد حالة الرصيد");

                return;

            }


            // مدين موجب فقط
            if (status == 1) {

                if (this.value < 0) {
                    this.value = Math.abs(this.value);
                }

            }


            // دائن سالب فقط
            if (status == 2) {

                if (this.value > 0) {
                    this.value = -Math.abs(this.value);
                }

            }

        });


    </script>
@endsection
