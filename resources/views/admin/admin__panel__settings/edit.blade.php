@extends('layouts.admin')
@section('title')

    التعديل الضبط العام
@endsection
@section('contentheader')
    تعديل
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

    <div class="row">
        <div class="col-12">





            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">تعديل بيانات الضبط العام </h3>
                </div>

                <div class="card-body">
                    @if(@isset($data) && !@empty($data))
                                <form action="{{ route('admin.adminpanelsetting.update') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="system_name">اسم الشركة</label>
                                        <input type="text" name="system_name" id="system_name" class="form-control"
                                            value="{{ $data->system_name }}">
                                        @error('system_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="com_code">كود الشركة</label>
                                        <input type="text" name="com_code" id="com_code" class="form-control"
                                            value="{{ $data->com_code }}">
                                                          @error('com_code')
                <span class="text-danger">{{ $message }}</span>
            @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="active">حالة الشركة</label>
                                        <select name="active" id="active" class="form-control">
                                            <option value="1" {{ $data->active == 1 ? 'selected' : '' }}>مفعل</option>
                                            <option value="0" {{ $data->active == 0 ? 'selected' : '' }}>غير مفعل</option>
                                        </select>
                                                      @error('active')
                <span class="text-danger">{{ $message }}</span>
            @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="address">عنوان الشركة</label>
                                        <input type="text" name="address" id="address" class="form-control"
                                            value="{{ $data->address }}">
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">رقم الشركة</label>
                                        <input type="text" name="phone" id="phone" class="form-control" value="{{ $data->phone }}">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label>حساب الاب للعملاء بالشجره المحاسبيه</label>
                                        <select name="customer_parent_number" id="customer_parent_number" class="form-control">

                                            @foreach ($parient_accauont as $info)
                                            <option value="{{ $info->id }}" {{ old('customer_parent_number', $data->customer_parent_number) == $info->id ? 'selected' : '' }}>
                                                    {{ $info->name }}
                                            </option>
                                             @endforeach
                                        </select>
                                        @error('customer_parent_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>حساب الاب للموردين بالشجره المحاسبيه</label>
                                        <select name="supplier_parent_number" id="supplier_parent_number" class="form-control">

                                            @foreach ($parient_accauont as $info)
                                            <option value="{{ $info->id }}" {{ old('supplier_parent_number', $data->supplier_parent_number) == $info->id ? 'selected' : ''  }}>
                                                    {{ $info->name }}
                                            </option>
                                             @endforeach
                                        </select>
                                        @error('supplier_parent_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>حساب الاب للمندوبين بالشجره المحاسبيه</label>
                                        <select name="delegates_parent_number" id="delegates_parent_number" class="form-control">

                                            @foreach ($parient_accauont as $info)
                                            <option value="{{ $info->id }}" {{ old('delegates_parent_number', $data->delegates_parent_number) == $info->id ? 'selected' : ''  }}>
                                                    {{ $info->name }}
                                            </option>
                                             @endforeach
                                        </select>
                                        @error('delegates_parent_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>حساب الاب للموظفين بالشجره المحاسبيه</label>
                                        <select name="employees_parent_number" id="employees_parent_number" class="form-control">

                                            @foreach ($parient_accauont as $info)
                                            <option value="{{ $info->id }}" {{ old('employees_parent_number', $data->employees_parent_number) == $info->id ? 'selected' : ''  }}>
                                                    {{ $info->name }}
                                            </option>
                                             @endforeach
                                        </select>
                                        @error('employees_parent_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>



                                    <div class="form-group">
                                        <label for="general_alert">رسالة تنبيه أعلى الشاشة</label>
                                        <input type="text" name="general_alert" id="general_alert" class="form-control"
                                            value="{{ $data->general_alert }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="logo">لوقو الشركة</label>
                                        {{-- <input type="file" name="logo" id="logo" class="form-control"> --}}
                                    </div>
                                    <button type="submit" class="btn btn-primary">تحديث</button>
                                </form>

                            </div>
                        </div>

                    @else

                <div class="alert alert-danger text-center">
                    عفوا....لاتوجد بيانات لعرضها
                </div>

            @endif

        </div>
    </div>

@endsection
