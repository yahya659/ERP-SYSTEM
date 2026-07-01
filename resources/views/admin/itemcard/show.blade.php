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
            </tr>

            <tr>
                <th>الباركود</th>
                <td>{{ $data->barcode ?? 'لا يوجد' }}</td>
            </tr>

            <tr>
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
            </tr>

            <tr>
                <th>صنف الأب</th>
                <td>{{ $data->parent_inv_itemscardid->name ?? 'لا يوجد' }}</td>
            </tr>

            <tr>
                <th>وحدة قياس صنف الأب</th>
                <td>{{ $data->uomid->name ?? 'لا يوجد' }}</td>
            </tr>

            <tr>
                <th>هل للصنف سعر ثابت</th>
                <td>
                    {{ $data->has_fixed_price == 1 ? 'نعم' : 'لا' }}
                </td>
            </tr>

            <tr>
                <th>هل له وحدة تجزئة</th>
                <td>
                    {{ $data->dose_has_retailunit == 1 ? 'نعم' : 'لا' }}
                </td>
            </tr>

            <tr>
                <th>وحدة التجزئة</th>
                <td>{{ $data->retail_uom_id->name ?? 'لا يوجد' }}</td>
            </tr>

            <tr>
                <th>عدد وحدات التجزئة</th>
                <td>{{ $data->retail_uom_quantity_to_parent ?? 0 }}</td>
            </tr>

            <tr>
                <th>السعر قطاعي</th>
                <td>{{ $data->price }}</td>
            </tr>

            <tr>
                <th>سعر نص جملة</th>
                <td>{{ $data->nos_gomla_price }}</td>
            </tr>

            <tr>
                <th>سعر جملة</th>
                <td>{{ $data->wholesale_price }}</td>
            </tr>

            <tr>
                <th>تكلفة الشراء</th>
                <td>{{ $data->coast_price }}</td>
            </tr>

            <tr>
                <th>السعر قطاعي (تجزئة)</th>
                <td>{{ $data->retail_price }}</td>
            </tr>

            <tr>
                <th>نص جملة (تجزئة)</th>
                <td>{{ $data->nos_gomla_price_retail }}</td>
            </tr>

            <tr>
                <th>جملة (تجزئة)</th>
                <td>{{ $data->wholesale_price_retail }}</td>
            </tr>

            <tr>
                <th>تكلفة (تجزئة)</th>
                <td>{{ $data->coast_price_retail }}</td>
            </tr>

            <tr>
                <th>حالة التفعيل</th>
                <td>
                    {{ $data->active == 1 ? 'مفعل' : 'غير مفعل' }}
                </td>
            </tr>

        </table>

        <a href="{{ route('item_card.index') }}" class="btn btn-danger">
            رجوع
        </a>

    </div>

</div>


@endsection
