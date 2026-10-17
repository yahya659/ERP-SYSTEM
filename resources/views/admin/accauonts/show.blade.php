@extends('layouts.admin')
@section('title')

   تفاصيل الحساب المالي
@endsection

@section('contentheader')
   تفاصيل
@endsection
@section('contentlink')
   تفاصيل الحساب المالي

@endsection
@section('this is teast')
    عرض
@endsection

@section('content')

    <div class="card">

        <div class="card-header">
            <h3>تفاصيل الحساب المالي</h3>
        </div>


        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th>اسم الحساب</th>
                    <td>{{ $data->name }}</td>
                </tr>

                <tr>
                    <th>رقم الحساب</th>
                    <td>{{ $data->accauont_number }}</td>
                </tr>


                <tr>
                    <th>نوع الحساب</th>
                    <td>{{ $data->accauonttypes->name }}</td>
                </tr>


                <tr>
                    <th>حساب أب</th>
                    <td>{{ $data->parientaccauontnumber->name  ?? 'لايوجد' }}</td>
                </tr>


                <tr>
                    <th>رصيد افتتاحي</th>
                    <td>{{ $data->start_balance }}</td>
                </tr>


                <tr>
                    <th>حالة الرصيد</th>
                   <td>
    {{


        $data->current_balance > 0 ? 'مدين  (عليه)' :
        ($data->current_balance < 0 ? 'دائن  (له)' : 'متزن')
    }}
     <p style="
    text-decoration: underline;
    color: {{ $data->current_balance < 0 ? 'green' : 'red' }};
">
    {{ $data->current_balance }}
</p>
</td>
                </tr>


                <tr>
                    <th>ملاحظات</th>
                    <td>{{ $data->nodes }}</td>
                </tr>


                <tr>
                    <th>مؤرشف</th>
                    <td>
                        {{ $data->is_archived == 1 ? 'نعم' : 'لا' }}
                    </td>
                </tr>


                <tr>
                    <th>تاريخ الإضافة</th>
                    <td>{{ $data->created_at }}<br/>{{ $data->addedBy->name }}</td>

                </tr>
                <tr>
                    <th>التحديث</th>
                    <td>{{ $data->updated_at ?? '-----' }}<br/>{{ $data->updatedBy->name ?? '----' }}</td>
                </tr>


            </table>


            <a href="{{ route('acaauonts.index') }}" class="btn btn-danger">
                رجوع
            </a>

        </div>

    </div>


@endsection
