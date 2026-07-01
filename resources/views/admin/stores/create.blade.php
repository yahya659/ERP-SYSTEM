@extends('layouts.admin')
@section('title')

    اضافه مخازن
@endsection

@section('contentheader')
    اضافه مخازن
@endsection
@section('contentlink')
    اضافه مخازن
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> اضافه مخزن</h3>

                </div>

                <div class="card-body">

                    <form action="{{ route('admin.stores.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">اسم المخزن</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">هاتف المخزن</label>
                            <input type="text" name="phones" id="phones" class="form-control" value="{{ old('phones') }}">
                            @error('phones')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">العنوان المخزن</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="active">حاله التفعيل</label>
                            <select name="active" id="active" class="form-control">
                                <option value="1" {{ old('active') == 1 ? 'selected' : '' }}>مفعل</option>
                                <option value="0" {{ old('active') == 0 ? 'selected' : '' }}>غير مفعل</option>
                            </select>
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn btn-primary">اضافة</button>
                            <button type="button" class="btn btn-danger" onclick="window.history.back()">الغاء</button>

                        </div>
                    </form>

                </div>
            </div>








        </div>
    </div>

@endsection
