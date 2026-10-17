@extends('layouts.admin')
@section('title')

  فواتير مرتجع المشتريات العام
@endsection

@section('contentheader')
   اضافه   فواتير مرتجع المشتريات العام :
@endsection
@section('contentlink')
  فواتير مرتجع المشتريات العام
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
                    <h3 class="card-title card_title_center">   فواتير مرتجع المشتريات العام </h3>

                </div>

                <div class="card-body">

                    <form action="{{ route('suppliers_with_ordersGenralReturn.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                                <label for="order_date">تاريخ الفاتورة</label>
                                <input type="date" name="order_date" readonly id="order_date" class="form-control" value="{{ old('order_date', now()->format('Y-m-d')) }}">
                                @error('order_date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                             {{-- <div class="form-group">
                            <label for="name">رقم الفاتوره المسجله باصل فاتوره المشتريات</label>
                            <input  name="doc_no" id="doc_no" class="form-control" value="{{ old('doc_no') }}">
                            @error('doc_no')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> --}}
                        <div class="form-group">
                            <label for="active">اسم المورد</label>
                            <select name="supplier_id" id="supplier_id" class="form-control">
                                <option value="" disabled selected>اختر المورد</option>
                                @foreach($supplier as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="active">اسم المخزن</label>
                            <select name="store_id" id="store_id" class="form-control">
                                <option value="" disabled selected>اختر المخزن</option>
                                @foreach($store as $store)
                                    <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
                                        {{$store->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('store_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="is_master">نوع الفاتوره</label>

                            <select name="bill_type" id="bill_type" class="form-control">
                                <option value="" disabled selected> نوع الفاتوره</option>
                                <option value="1" {{ old('bill_type') == 0 }}> اجل</option>
                                <option value="0" {{ old('bill_type') == 1}}>كاش </option>
                            </select>
                            @error('bill_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                            <div class="form-group">
                                <label for="order_date">ملاحضه</label>
                                <input type="text" name="notes" id="notes" class="form-control" value="{{ old('notes', 'مرتجع') }}">
                                @error('notes')
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
