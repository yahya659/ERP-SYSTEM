`
@extends('layouts.admin')
@section('title')

    تعديل فواتير المشتريات من الموردين
@endsection
@section('contentheader')
    تعديل فواتير المشتريات من الموردين

@endsection
@section('contentlink')
    تعديل
@endsection
@section('this is teast')
    عرض
@endsection


@section('content')
    <data class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">تعديل فاتوره المورد</h3>
                </div>

                <div class="card-body">

                    <form action="{{ route('SupplierWithOrder.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="order_date">تاريخ الفاتورة</label>
                            <input type="date" name="order_date" id="order_date" class="form-control"
                                value="{{ old('order_date', $data->order_date) }}">

                            @error('order_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="doc_no">رقم الفاتوره المسجله باصل فاتوره المشتريات</label>
                            <input name="doc_no" id="doc_no" class="form-control"
                                value="{{ old('doc_no', $data->doc_no) }}">

                            @error('doc_no')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="supplier_id">اسم المورد</label>

                            <select name="supplier_id" id="supplier_id" class="form-control">

                                <option value="">اختر المورد</option>

                                @foreach($supplier as $sup)
                                    <option value="{{ $sup->id }}" {{ old('supplier_id', $data->supplier_id) == $sup->id ? 'selected' : '' }}>
                                        {{ $sup->name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('supplier_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="store_id">اسم المخزن</label>

                            <select name="store_id" id="store_id" class="form-control">

                                <option value="">اختر المخزن</option>

                                @foreach($store as $sto)
                                    <option value="{{ $sto->id }}" {{ old('store_id', $data->store_id) == $sto->id ? 'selected' : '' }}>
                                        {{ $sto->name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('store_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>



                        <div class="form-group">
                            <label for="bill_type">نوع الفاتورة</label>

                            <select name="bill_type" id="bill_type" class="form-control">

                                <option value="">نوع الفاتورة</option>

                                <option value="1" {{ old('bill_type', $data->bill_type) == 1 ? 'selected' : '' }}>
                                    اجل
                                </option>

                                <option value="0" {{ old('bill_type', $data->bill_type) == 0 ? 'selected' : '' }}>
                                    كاش
                                </option>

                            </select>

                            @error('bill_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>



                        <div class="form-group">
                            <label for="notes">ملاحظة</label>

                            <input type="text" name="notes" id="notes" class="form-control"
                                value="{{ old('notes', $data->notes) }}">

                            @error('notes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>



                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                تعديل
                            </button>

                            <button type="button" class="btn btn-danger" onclick="window.history.back()">
                                الغاء
                            </button>
                        </div>


                    </form>

                </div>
            </div>
        </div>
        </div>

@endsection
