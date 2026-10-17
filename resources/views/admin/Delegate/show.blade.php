@extends('layouts.admin')

@section('title')
    تفاصيل حساب المندوب
@endsection

@section('contentheader')
       تفاصيل حساب المندوب
@endsection

@section('contentlink')
    تفاصيل حساب المندوب
@endsection

@section('this is teast')
    عرض
@endsection

@section('content')

<div class="card">



    <div class="card-body">

        <table class="table table-bordered table-striped">

            {{-- اسم المندوب --}}
            <tr>
                <th>اسم المندوب</th>
                <td>{{ $data->name }}</td>
            </tr>

            {{-- رقم الهاتف --}}
            <tr>
                <th>رقم الهاتف</th>
                <td>{{ $data->phone ?? 'لا يوجد' }}</td>
            </tr>

            {{-- نوع الحساب --}}
            <tr>
                <th>نوع الحساب</th>
                <td>{{ $data->accauont_types }}</td>
            </tr>

            {{-- رقم الحساب --}}
            <tr>
                <th>رقم الحساب</th>
                <td>{{ $data->account_number }}</td>
            </tr>

            {{-- كود المندوب --}}
            <tr>
                <th>كود المندوب</th>
                <td>{{ $data->delegate_code }}</td>
            </tr>

            {{-- المدينة --}}
            <tr>
                <th>المدينة</th>
                <td>{{ $data->city_id ?? 'لا يوجد' }}</td>
            </tr>

            {{-- العنوان --}}
            <tr>
                <th>العنوان</th>
                <td>{{ $data->address ?? 'لا يوجد' }}</td>
            </tr>

            {{-- الرصيد الافتتاحي --}}
            <tr>
                <th>الرصيد الافتتاحي</th>
                <td>{{ $data->start_balance }}</td>
            </tr>

            {{-- الرصيد الحالي --}}
            <tr>
                <th>الرصيد الحالي</th>
                <td>{{ $data->current_balance }}</td>
            </tr>

            {{-- الملاحظات --}}
            <tr>
                <th>الملاحظات</th>
                <td>{{ $data->nodes ?? 'لا توجد ملاحظات' }}</td>
            </tr>

            {{-- أضيف بواسطة --}}
            <tr>
                <th>تمت الإضافة بواسطة</th>
                <td>
                    {{ $data->addedby->name ?? '-----' }}
                </td>
            </tr>

            {{-- عدل بواسطة --}}
            <tr>
                <th>تم التعديل بواسطة</th>
                <td>
                    {{ $data->updatedby->name ?? '-----' }}
                </td>
            </tr>

            {{-- كود الشركة --}}
            <tr>
                <th>كود الشركة</th>
                <td>{{ $data->com_code }}</td>
            </tr>

            {{-- تاريخ الإضافة --}}
            <tr>
                <th>تاريخ الإضافة</th>
                <td>{{ $data->date }}</td>
            </tr>

            {{-- حالة التفعيل --}}
            <tr>
                <th>حالة الحساب</th>
                <td>
                    @if ($data->active == 1)
                        <span class="badge badge-success">مفعل</span>
                    @else
                        <span class="badge badge-danger">غير مفعل</span>
                    @endif
                </td>
            </tr>

            {{-- حالة الرصيد الافتتاحي --}}
            <tr>
                <th>حالة الرصيد الافتتاحي</th>
                <td>
                    @if ($data->start_balance_status == 1)
                        <span class="text-danger">عليه</span>
                    @elseif ($data->start_balance_status == 2)
                        <span class="text-success">له</span>
                    @else
                        <span class="text-secondary">متزن</span>
                    @endif
                </td>
            </tr>

            {{-- نوع العمولة --}}
            <tr>
                <th>نوع عمولة المندوب</th>
                <td>
                    @if ($data->parcent_type == 1)
                        أجر ثابت
                    @elseif ($data->parcent_type == 2)
                        نسبة
                    @else
                        غير محدد
                    @endif
                </td>
            </tr>

            {{-- عمولة مبيعات الجملة --}}
            <tr>
                <th>عمولة مبيعات الجملة</th>
                <td>{{ $data->parcent_sales_commission_jomla }}</td>
            </tr>

            {{-- عمولة التحصيل --}}
            <tr>
                <th>عمولة تحصيل الفواتير - آجل</th>
                <td>{{ $data->parcent_collection_commission }}</td>
            </tr>

            {{-- عمولة القطاعي --}}
            <tr>
                <th>عمولة المبيعات القطاعي (تجزئة)</th>
                <td>{{ $data->parcent_sales_commission_katai }}</td>
            </tr>

            {{-- عمولة نصف الجملة --}}
            <tr>
                <th>عمولة مبيعات نصف الجملة</th>
                <td>{{ $data->parcent_sales_commission_nosjamla }}</td>
            </tr>

        </table>

        <br>

        <a href="{{ route('Delegates.index') }}" class="btn btn-danger">
            رجوع
        </a>

    </div>

</div>

@endsection
