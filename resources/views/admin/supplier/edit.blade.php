`
@extends('layouts.admin')
@section('title')

تعديل الحساب المورد
@endsection
@section('contentheader')
تعديل الحساب المورد

@endsection
@section('contentlink')
    تعديل
@endsection
@section('this is teast')
    عرض
@endsection


@section('content')

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
@section('content')
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

    <data class="row">
      <div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center">تعديل الحساب المورد</h3>
        </div>

        <div class="card-body">

            @if($data)

                <form action="{{ route('Suppliers.update',$data->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <!-- الاسم -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">الاسم</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $data->name) }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- حالة التفعيل -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="active">حالة التفعيل</label>

                                <select name="active" id="active" class="form-control">
                                    <option value="">اختر الحالة</option>

                                    <option value="1"
                                        {{ old('active', $data->active) == 1 ? 'selected' : '' }}>
                                        نعم
                                    </option>

                                    <option value="0"
                                        {{ old('active', $data->active) == 0 ? 'selected' : '' }}>
                                        لا
                                    </option>
                                </select>

                                @error('active')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- رقم العميل -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">رقم المورد</label>
                                <input type="number" name="phone" id="phone" class="form-control"
                                    value="{{ old('phone', $data->phone) }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- العنوان -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">عنوان العميل</label>
                                <input type="text" name="address" id="address" class="form-control"
                                    value="{{ old('address', $data->address) }}">
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- الملاحظات -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nodes">الملاحظات (اختياري)</label>
                                <input type="text" name="nodes" id="nodes" class="form-control"
                                    value="{{ old('nodes', $data->nodes) }}">
                                @error('nodes')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- فئة المورد -->
<div class="col-md-6">
    <div class="form-group">
        <label for="suppliers_categories_id">فئة المورد</label>

        <select name="suppliers_categories_id" id="suppliers_categories_id" class="form-control">

            <option value="">اختر الفئة</option>

            @foreach($categories as $category)

                <option value="{{ $category->id }}"
                    {{ old('suppliers_categories_id', $data->suppliers_categories_id) == $category->id ? 'selected' : '' }}>

                    {{ $category->name }}

                </option>

            @endforeach

        </select>

        @error('suppliers_categories_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror

    </div>
</div>


                    </div>

                    <!-- الأزرار -->
                    <div class="row">
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary">تعديل</button>
                            <button type="button" class="btn btn-danger"
                                onclick="window.history.back()">الغاء</button>
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
<script>
document.addEventListener('DOMContentLoaded', function () {

    let isParent = document.getElementById('is_parent');
    let parentBox = document.getElementById('parentBox');
    let parentSelect = document.querySelector('[name="parient_accauont_number"]');


    function toggleParentBox() {

        if (isParent.value == 1) {

            parentBox.style.display = 'none';

            // مسح الأب إذا صار حساب رئيسي
            parentSelect.value = '';

        } else {

            parentBox.style.display = 'block';

        }
    }


    toggleParentBox();

    isParent.addEventListener('change', toggleParentBox);

});
</script>
@endsection
