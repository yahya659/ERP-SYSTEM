@extends('layouts.admin')
@section('title')
    التعديل الحساب المالي
@endsection
@section('contentheader')
    التعديل الحساب المالي

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
                    <h3 class="card-title card_title_center">تعديل الحساب المالي</h3>
                </div>
                <div class="card-body">
                    @if($data)
                        <form action="{{ route('acaauonts.update',$data->id) }}" method="POST">
                           @csrf
                           @method('PUT')

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">اسم الحساب المالي</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ $data->name }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>نوع الحساب</label>
                                        <select name="accauont_types" id="accauont_types" class="form-control">
                                            <option value=""> نوع الحسب</option>
                                            @foreach ($accauont_types as $info)
                                            <option value="{{ $info->id }}" {{ $data->accauont_types == $info->id ? 'selected' : '' }}>
                                                    {{ $info->name }}
                                            </option> @endforeach
                                        </select>
                                        @error('accauont_types')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="name">هل يملك اب</label>
                                        <select name="is_parent" id="is_parent" class="form-control">
    <option value="">اختر الحالة</option>

    <option value="1"
        {{ old('is_parent', $data->is_parent ?? '') == 1 ? 'selected' : '' }}>
        نعم
    </option>

    <option value="0"
        {{ old('is_parent', $data->is_parent ?? '') == 0 ? 'selected' : '' }}>
        لا
    </option>
</select>
                                        @error('is_parent')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
<div class="form-group" id="parentBox"
    @if(old('is_parent', $data->is_parent ?? '') == 1) style="display:none" @endif>

    <label>حساب الأب</label>

    <select name="parient_accauont_number" class="form-control">
        <option value="">اختر حساب الأب</option>

        @foreach ($parient_accauont as $info)
            <option value="{{ $info->id }}"
                {{ old('parient_accauont_number', $data->parient_accauont_number ?? '') == $info->id ? 'selected' : '' }}>
                {{ $info->name }}
            </option>
        @endforeach

    </select>
</div>
                                </div>
                                <div class="col-md-6">




                                    <div class="form-group">
                                        <label for="name">الملاحظات (اختياري)</label>
                                        <input type="text" name="nodes" id="nodes" class="form-control"
                                            value="{{ old('nodes',$data->nodes) }}">
                                        @error('nodes')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                <div class="form-group">
    <label for="is_archived">حالة التفعيل (مؤرشفة)</label>

    <select name="is_archived" id="is_archived" class="form-control">
        <option value="">اختر الحالة</option>

        <option value="1"
            {{ old('is_archived', $data->is_archived ?? '') == 1 ? 'selected' : '' }}>
            نعم مؤرشف
        </option>

        <option value="0"
            {{ old('is_archived', $data->is_archived ?? '') == 0 ? 'selected' : '' }}>
            لا ليست مؤرشف
        </option>
    </select>

    @error('is_archived')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mt-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">حفظ</button>
                                        <button type="button" class="btn btn-danger"
                                            onclick="window.history.back()">الغاء</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    @else
                                <div class="alert alert-danger text-center">
                                    عفوا....لاتوجد حسابات لعرضها
                                </div>

                            </div>
                        </div>

                    @endif

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
