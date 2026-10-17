@extends('layouts.admin')
@section('title')

    تعديل فواتير المرتجع من الموردين
@endsection
@section('contentheader')
    تعديل فواتير المرتجع من الموردين

@endsection
@section('contentlink')
    تعديل
@endsection
@section('this is teast')
    عرض
@endsection
@section('content')
    <div class="col-12">

        <div class="card">

            <div class="card-header">
                <h3 class="card-title card_title_center">
                    تعديل صنف في الفاتورة
                </h3>
            </div>


            <div class="card-body">

                <form action="{{ route('Suppliers_with_ordersGenralReturn.updateDetail', $data->id) }}" method="POST">
    @csrf
    @method('PUT')



                    <div class="form-group">
                        <label>الصنف</label>

                        <select name="item_code" class="form-control">

                            <option value="">اختر الصنف</option>

                            @foreach($items as $item)

                                <option value="{{ $item->item_code }}" {{ $data->item_code == $item->item_code ? 'selected' : '' }}>

                                    {{ $item->name }}

                                </option>

                            @endforeach
                            @error('item_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror


                        </select>

                    </div>



                    <div class="form-group">

                        <label>الوحدة</label>

                        <select name="unit_id" class="form-control">

                            <option value="">اختر الوحدة</option>

                            @foreach($units as $unit)

                                <option value="{{ $unit->id }}" {{ $data->unit_id == $unit->id ? 'selected' : '' }}>

                                    {{ $unit->name }}

                                </option>

                            @endforeach
                            @error('unit_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror


                        </select>

                    </div>




                    <div class="form-group">
                        <label>الكمية</label>

                        <input type="number" name="delivery_quantity" class="form-control"
                            value="{{ old('delivery_quantity', $data->delivery_quantity * 1) }}">

                    </div>
                    @error('delivery_quantity')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror




                    <div class="form-group">

                        <label>السعر</label>

                        <input type="number" name="unit_price" class="form-control"
                            value="{{ old('unit_price', $data->unit_price * 1) }}">

                    </div>
                    @error('unit_price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror



                    <div class="form-group">

                        <label>الإجمالي</label>

                        <input type="number" name="total_price" class="form-control"
                            value="{{ old('total_price', $data->total_price * 1) }}" readonly>

                    </div>
                  @if($data->item && $data->item->item_type == 2)
                  <div class="form-group">
                    <label>تاريخ الإنتاج</label>
                    <input type="date"
                     name="production_date"
                     class="form-control"
                        value="{{ $data->production_date }}">
                    </div>

                        <div class="form-group">
                            <label>تاريخ الانتهاء</label>
                            <input type="date"
                                name="expir_date"
                                class="form-control"
                                value="{{ $data->expir_date }}">
                        </div>
                    @endif
                    <button class="btn btn-primary">
                        تعديل
                    </button>
                    <button type="button" class="btn btn-danger" onclick="history.back()">
                        إلغاء
                    </button>
                </form>
            </div>
        </div>
    </div>


@endsection
