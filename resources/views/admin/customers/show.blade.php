@extends('layouts.admin')
@section('title')

تفاصيل حساب العميل
@endsection

@section('contentheader')
   تفاصيل
@endsection
@section('contentlink')
تفاصيل حساب العميل
@endsection
@section('this is teast')
    عرض
@endsection

@section('content')

    <div class="card">

        <div class="card-header">
            <h3>تفاصيل حساب العميل</h3>
        </div>


        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th>اسم الحساب</th>
                    <td>{{ $data->name }}</td>
                </tr>

                <tr>
                    <th>رقم الحساب</th>
                    <td>{{ $data->account_number }}</td>
                </tr>
           
                <tr>
                    <th>رقم التلفون</th>
                    <td>{{ $data->phone }}</td>
                </tr>
                <tr>
                    <th>رقم الكود</th>
                    <td>{{ $data->customer_code }}</td>
                </tr>
                <tr>
                    <th>العنوان</th>
                    <td>{{ $data->address }}</td>
                </tr>
                <tr>
                    <th>رقم المدينه</th>
                    <td>{{ $data->city_id ?? 'لاوجد' }}</td>
                </tr>
                <tr>
                    <th>تم الاضافه</th>
                    <td>{{ $data->addedby->name }}<br/> {{ $data->date }}</td>

                </tr>
                <tr>
                    <th>تم التعديل</th>
                    <td>{{ $data->updatedby->name ?? '-----' }} <br/> {{ $data->date }}</td>
                </tr>
                <tr>
                    <th>كود الشركه</th>
                    <td>{{ $data->com_code }}</td>
                </tr>
                <tr>
                    <th>حاله تفعيل الحساب</th>
                    <td>{{ $data->active  == 1 ? 'نعم' : 'لا'  }}</td>
                </tr>
                <tr>
                    <th>مبلغ الحساب</th>
                    <td>{{ $data->current_balance }}</td>
                </tr>





                <tr>
                    <th>حساب أب</th>
                    <td>{{ $data->parientaccauontnumber->name  ?? 'لايوجد' }}</td>
                </tr>


                <tr>
                    <th>ملاحظات</th>
                    <td>{{ $data->nodes }}</td>
                </tr>





            </table>


            <a href="{{ route('customers.index') }}" class="btn btn-danger">
                رجوع
            </a>

        </div>

    </div>


@endsection
