@extends('layouts.admin')
@section('title')
التعديل المخزن
@endsection
@section('contentheader')
    تعديل المخزن
@endsection
@section('contentlink')
    الضبط
@endsection
@section('this is teast')
    عرض
@endsection
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
                    <h3 class="card-title card_title_center">تعديل بيانات الخزن </h3>
                </div>
                <div class="card-body">
                    @if(@isset($data) && !@empty($data))
                                <form action="{{ route('admin.treasuries.update', $data->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">اسم الخزن</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ $data->name }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="last_isal_exchange">اخر  صرف</label>
                                        <input type="text" name="last_isal_exchange" id="last_isal_exchange" class="form-control"
                                            value="{{ $data->last_isal_exchange }}">
                                        @error('last_isal_exchange')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="last_isal_receipt">اخر تحصيل  </label>
                                        <input type="text" name="last_isal_collection" id="last_isal_collection" class="form-control"
                                            value="{{ $data->last_isal_collection }}">
                                        @error('last_isal_collection')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="is_master">الخزن الرئيسي</label>
                                        <select name="is_master" id="is_master" class="form-control">
                                            <option value="">اختر الحالة</option>
                                            <option value="1" {{ $data->is_master == 1 ? 'selected' : '' }}>نعم</option>
                                            <option value="0" {{ $data->is_master == 0 ? 'selected' : '' }}>لا</option>
                                        </select>
                                        @error('is_master')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="active">حالة الخزن</label>
                                        <select name="active" id="active" class="form-control">
                                            <option value="">اختر الحالة</option>
                                            <option value="1" {{ $data->active == 1 ? 'selected' : '' }}>مفعل</option>
                                            <option value="0" {{ $data->active == 0 ? 'selected' : '' }}>غير مفعل</option>
                                        </select>
                                        @error('active')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">تحديث</button>
                                        <button type="button" class="btn btn-danger" onclick="window.history.back()">الغاء</button>
                                    </div>
                                </form>
                            @else
                                <div class="alert alert-danger text-center">
                                    عفوا....لاتوجد بيانات لعرضها
                                </div>

                        </div>
                    </div>

                @endif

            </div>
        </div>

@endsection
