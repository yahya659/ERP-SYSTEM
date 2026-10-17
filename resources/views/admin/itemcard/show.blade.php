@extends('layouts.admin')
@section('title')

    تفاصيل الصنف
@endsection

@section('contentheader')
    تفاصيل الصنف

@endsection
@section('contentlink')
    تفاصيل الصنف
@endsection
@section('this is teast')
    عرض
@endsection

@section('content')

    <div class="card">

        <div class="card-header">
            <h3>
                تفاصيل الصنف
                <span class="badge bg-primary">
                    {{ $data->name }}
                </span>
            </h3>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th>اسم الصنف</th>
                    <td>{{ $data->name }}</td>

                    <th>الباركود</th>
                    <td>{{ $data->barcode ?? 'لا يوجد' }}</td>

                    <th>نوع الصنف</th>
                    <td>
                        @if($data->item_type == 1)
                            مخزني
                        @elseif($data->item_type == 2)
                            استهلاكي
                        @else
                            عهدة
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>فئة الصنف</th>
                    <td>{{ $data->inv_itemscard_categoriesid->name ?? 'لا يوجد' }}</td>

                    <th>صنف الأب</th>
                    <td>{{ $data->parent_inv_itemscardid->name ?? 'لا يوجد' }}</td>

                    <th>وحدة قياس صنف الأب</th>
                    <td>{{ $data->uomid->name ?? 'لا يوجد' }}</td>
                </tr>

                <tr>
                    <th>هل للصنف سعر ثابت</th>
                    <td>{{ $data->has_fixed_price == 1 ? 'نعم' : 'لا' }}</td>

                    <th>هل له وحدة تجزئة</th>
                    <td>{{ $data->dose_has_retailunit == 1 ? 'نعم' : 'لا' }}</td>

                    <th>وحدة التجزئة</th>
                    <td>{{ $data->retail_uom_id->name ?? 'لا يوجد' }}</td>
                </tr>

                <tr>
                    <th>عدد وحدات التجزئة</th>
                    <td>{{ $data->retail_uom_quantity_to_parent ?? 0 }}</td>

                    <th>السعر قطاعي</th>
                    <td>{{ $data->price }}</td>

                    <th>سعر نص جملة</th>
                    <td>{{ $data->nos_gomla_price }}</td>
                </tr>

                <tr>
                    <th>سعر جملة</th>
                    <td>{{ $data->wholesale_price }}</td>

                    <th>تكلفة الشراء</th>
                    <td>{{ $data->coast_price }}</td>

                    <th>السعر قطاعي (تجزئة)</th>
                    <td>{{ $data->retail_price }}</td>
                </tr>

                <tr>
                    <th>نص جملة (تجزئة)</th>
                    <td>{{ $data->nos_gomla_price_retail }}</td>

                    <th>جملة (تجزئة)</th>
                    <td>{{ $data->wholesale_price_retail }}</td>

                    <th>تكلفة (تجزئة)</th>
                    <td>{{ $data->coast_price_retail }}</td>
                </tr>

                <tr>
                    <th>صورة الصنف</th>
                    <td>
                        @if($data->image)
                            <img src="{{ asset('storage/' . $data->image) }}" alt="{{ $data->name }}" width="150" height="150"
                                style="object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                        @else
                            لا توجد صورة
                        @endif
                    </td>

                    <th>حالة التفعيل</th>
                    <td>{{ $data->active == 1 ? 'مفعل' : 'غير مفعل' }}</td>

                    <th>كود الصنف</th>
                    <td>{{ $data->item_code }} </td>
                </tr>

            </table>

            <a href="{{ route('item_card.index') }}" class="btn btn-danger">
                رجوع
            </a>

        </div>

    </div>
    <h4 class="mt-4"> سجل حركه الصنف : </h4>
<form action="{{ route('item_card.show', $data->id) }}" method="GET">

    <div class="form-group">
        <label>اختر المخزن :</label>

        <select name="store_id" class="form-control" onchange="this.form.submit()">

            {{-- <option value="">-- اختر المخزن --</option> --}}

            <option value="all"
                {{ $selectedStore == 'all' ? 'selected' : '' }}>
                كل المخازن
            </option>

            @foreach($stores as $store)
                <option value="{{ $store->id }}"
                    {{ $selectedStore == $store->id ? 'selected' : '' }}>
                    {{ $store->name }}
                </option>
            @endforeach

        </select>
    </div>

</form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>تاريخ الااضافه</th>
                <th>البيان</th>
                <th>نوع الحركه</th>
                <th>قسم الحركه</th>
                <th>المخزن</th>
                <th>الكمية قبل الحركة</th>
                <th>الكمية بعد الحركة</th>
            </tr>
        </thead>



<div class="card bg-success text-white shadow-sm mb-3"
     style="border-radius: 8px; max-width: 280px;">
    <div class="card-body text-center p-2">
        <div style="font-size: 14px;">
            {{-- <i class="fas fa-warehouse"></i> --}}
            كمية الكراتين في جميع المخازن :
        </div>

        <div class="font-weight-bold mt-1" style="font-size: 24px;">
            {{ number_format($totalQuantityAllStores / 24) }}
            <small style="font-size: 13px;">كرتون</small>
        </div>
    </div>
</div>

       <tbody>
            @forelse($movements as $movement)

                <tr>
                    <td>
                        {{ \Carbon\Carbon::parse($movement->date)->format('Y-m-d h:i A') }}
                        <br>
                        <small>
                            بواسطة: {{ $movement->addedBy->name ?? '-' }}
                        </small>
                    </td>
                    <td>{{ $movement->byan }}</td>
                    <td>{{ $movement->movementType->type}}</td>
                    <td>{{ $movement->movementCategory->name}}</td>
                    <td>{{ $movement->store->name }}</td>
                    <td>{{ $movement->quantity_befor_move_store /24}} كرتون
                          <br>
    {{-- <small>
        كمية جميع المخازن: {{ $movement->quantity_befor_movement }} قطعة
    </small> --}}
                    </td>
                    <td>{{ $movement->quantity_after_move_store / 24}} كرتون
                          <br>
    {{-- <small>
        كمية جميع المخازن: {{ $movement->quantity_after_move }} قطعة
    </small> --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        لا توجد حركة لهذا الصنف في هااذا المخزن
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>


@endsection
