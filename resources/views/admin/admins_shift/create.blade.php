@extends('layouts.admin')
@section('title')

    اضافه تسليم خزن
@endsection

@section('contentheader')
    اضافه تسليم خزن
@endsection
@section('contentlink')
    اضافه تسليم خزن
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
                    <h3 class="card-title card_title_center"> اضافه تسليم خزن
                    </h3>

                </div>

                <div class="card-body">
                    {{-- @if(@isset($data) && !@empty($data)) --}}
                    <form action="{{ route('admins_shift.store') }}" method="POST">
                        @csrf
                        <label>الخزن المضافة لصلاحيتي</label>

                        <select name="treasuries_id" id="treasuries_id" class="form-control">
                            <option value="">اختر الخزنة</option>

                            @foreach($treasuries as $item)

                                @php
                                // لمعرفه الشخص الذي يستخدم الخزنه حاليا
                                    $shift = \App\Models\Admin_Shift::with('adminname')
                                        ->where('treasuries_id', $item->id)
                                        ->where('is_finished', 0)
                                        ->first();
                                @endphp

                                <option value="{{ $item->id }}" {{ $shift ? 'disabled' : '' }}>
                                    {{ $item->name }}

                                    @if($shift)
                                        (مستخدمة حالياً بواسطة {{ $shift->adminname->name ?? 'غير معروف' }})
                                    @endif
                                </option>

                            @endforeach
                        </select>
                        @error('treasuries_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

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
