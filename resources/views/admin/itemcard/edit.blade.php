@extends('layouts.admin')

@section('title')
    تعديل فئة الأصناف
@endsection

@section('content')

@if(session('success'))
    <div style="background:#d4edda;color:#155724;padding:15px;border-radius:5px;margin-bottom:20px;text-align:center;font-weight:bold;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background:#f8d7da;color:#721c24;padding:15px;border-radius:5px;margin-bottom:20px;text-align:center;font-weight:bold;">
        {{ session('error') }}
    </div>
@endif

<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-center">تعديل صنف</h3>
            </div>

            <div class="card-body">

                @if(isset($data) && !empty($data))

                <form action="{{ route('item_card.update', $data->id) }}" method="POST">
                    @method('PUT')
                    @csrf

                    {{-- Barcode --}}
                    <label>باركود الصنف (اختياري)</label>
                    <input name="barcode" class="form-control" value="{{ old('barcode', $data->barcode) }}">
                    @error('barcode')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    {{-- Name --}}
                    <label>اسم الصنف</label>
                    <input name="name" class="form-control" value="{{ old('name', $data->name) }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    {{-- Item Type --}}
                    <label>نوع الصنف</label>
                    <select name="item_type" class="form-control">
                        <option value="1" {{ $data->item_type == 1 ? 'selected' : '' }}>مخزني</option>
                        <option value="2" {{ $data->item_type == 2 ? 'selected' : '' }}>استهلاكي</option>
                        <option value="3" {{ $data->item_type == 3 ? 'selected' : '' }}>عهده</option>
                    </select>
                     <label>سعر</label>
                                <input name="price" id="price" class="form-control" value="{{ old('barcode', $data->price) }}">

                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br />
                                <label>سعر تجزئه</label>
                                <input name="retail_price" id="retail_price" class="form-control" value="{{ old('barcode', $data->retail_price) }}">

                                @error('retail_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br />
                                <label>سعر جمله</label>
                                <input name="wholesale_price" id="wholesale_price" class="form-control" value="{{ old('barcode', $data->wholesale_price) }}">

                                @error('wholesale_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br />

                    {{-- Category --}}
                    <label>فئة الصنف</label>
                    <select name="inv_itemscard_categories_id" class="form-control">
                        <option value="">اختار فئة الصنف</option>
                        @foreach ($inv_itemscard_categories as $info)
                            <option value="{{ $info->id }}"
                                {{ $data->inv_itemscard_categories_id == $info->id ? 'selected' : '' }}>
                                {{ $info->name }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Unit --}}
                    <label>وحدة الصنف الأساسية</label>
                    <select name="uom_id" class="form-control">
                        @foreach ($parent_inv_itemscardid as $info)
                            <option value="{{ $info->id }}"
                                {{ $data->uom_id == $info->id ? 'selected' : '' }}>
                                {{ $info->name }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Parent Item --}}
                    <label>الصنف الأب</label>
                    <select name="parent_inv_itemscard_id" class="form-control">
                        <option value="">بدون صنف أب</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}"
                                {{ $data->parent_inv_itemscard_id == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Retail --}}
                    <label>هل له وحدة تجزئة</label>
                    <select name="dose_has_retailunit" class="form-control">
                        <option value="1" {{ $data->dose_has_retailunit == 1 ? 'selected' : '' }}>نعم</option>
                        <option value="0" {{ $data->dose_has_retailunit == 0 ? 'selected' : '' }}>لا</option>
                    </select>

                    <label>وحدة التجزئة</label>
                    <select name="retail_uom" class="form-control">
                        @foreach($parent_inv_itemscardid_children as $info)
                            <option value="{{ $info->id }}"
                                {{ $data->retail_uom == $info->id ? 'selected' : '' }}>
                                {{ $info->name }}
                            </option>
                        @endforeach
                    </select>

                    <label>كمية التجزئة</label>
                    <input type="number" step="0.01" name="retail_uom_quantity_to_parent"
                        class="form-control"
                        value="{{ old('retail_uom_quantity_to_parent', $data->retail_uom_quantity_to_parent) }}">

                    {{-- Active --}}
                    <label>حالة التفعيل</label>
                    <select name="active" class="form-control">
                        <option value="1" {{ $data->active == 1 ? 'selected' : '' }}>مفعل</option>
                        <option value="0" {{ $data->active == 0 ? 'selected' : '' }}>غير مفعل</option>
                    </select>

                    <br>

                    <button type="submit" class="btn btn-success">تحديث</button>
                    <button type="button" class="btn btn-danger" onclick="window.history.back()">إلغاء</button>

                </form>

                @else
                    <div class="alert alert-danger text-center">
                        عفواً... لا توجد بيانات لعرضها
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>

@endsection
