@extends('layouts.admin')
@section('title')

    اضافه مخزن فرعي للااستلام
@endsection

@section('contentheader')
    اضافه مخزن فرعي
@endsection
@section('contentlink')
    تسليم مخزن فرعي
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
                    <h3 class="card-title card_title_center">اضافة الخزن فرعي للتسيم {{ $data->name }}</h3>

                </div>

                <div class="card-body">
                    <form action="{{ route('admin.treasuries.Store_Treasury_Delivery', $data->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">اسم الخزن الفرعي</label>
                            <select name="treasuries_can_delivery_id" id="treasuries_can_delivery_id" class="form-control">
                                <option value="">اختار الخزن</option>
                                @if (isset($Treasury) && !empty($Treasury))
                                    @foreach ($Treasury as $info)
                                        <option @if (old('treasuries_can_delivery_id') == $info->id) selected="selected" @endif
                                            value="{{ $info->id }}">{{ $info->name }}</option>
                                    @endforeach
                                @endif

                            </select>
                            @error('treasuries_can_delivery_id')
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
