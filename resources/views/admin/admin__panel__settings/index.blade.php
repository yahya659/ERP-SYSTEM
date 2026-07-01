@extends('layouts.admin')
@section('title')

    الضبط العام
@endsection

@section('contentheader')
    الضبط
@endsection
@section('contentlink')
    الضبط
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

    <div class="row">
        <div class="col-12">

            @if($data)

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title card_title_center">بيانات الضبط العام</h3>
                    </div>

                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <tr>
                                <th>اسم الشركة</th>
                                <td>{{ $data->system_name ?? 'لاتوجد شركة' }}</td>
                            </tr>

                            <tr>
                                <th>كود الشركة</th>
                                <td>{{ $data->com_code ?? 'لايوجد كود' }}</td>
                            </tr>

                            <tr>
                                <th>حالة الشركة</th>
                                <td>{{ $data->active == 1 ? 'مفعل' : 'غير مفعل' }}</td>
                            </tr>

                            <tr>
                                <th>عنوان الشركة</th>
                                <td>{{ $data->address ?? 'لا يوجد عنوان' }}</td>
                            </tr>

                            <tr>
                                <th>رقم الشركة</th>
                                <td>{{ $data->phone ?? 'لا يوجد رقم' }}</td>
                            </tr>
                            <tr>
                                <th>حساب الاب للعملاء بالشجره المحاسبيه</th>
                                <td>اسم الحساب المالي :   {{ $data->customerparentnumber->name ?? 'لا يوجد رقم' }}<br/> رقم الحساب المالي :  {{ $data->customerparentnumber->id }}</td>

                            </tr>
                            <tr>
                                <th>حساب الاب للموردين بالشجره المحاسبيه</th>
                                <td>اسم الحساب المالي :   {{ $data->supplierparentnumber->name ?? 'لا يوجد رقم' }}<br/> رقم الحساب المالي :  {{ $data->customerparentnumber->id }}</td>

                            </tr>
                            <tr>
                                <th>الحاله</th>
                                <td>{{ $data->active == 1 ? 'مفعل' : 'غير مفعل' }}</td>
                            </tr>

                            <tr>
                                <th>رسالة تنبيه أعلى الشاشة</th>
                                <td>{{ $data->general_alert ?? '------' }}</td>
                            </tr>
                            <tr>
                                <th>لوقو الشركه</th>
                                <td>{{ $data->general_alert ?? '------' }}</td>
                            </tr>
                            <tr>
                                <th>آخر تحديث</th>
                                <td>
                                    {{ $data->updated_at
                ? $data->updated_at->format('Y-m-d (h:i:s)') . ' ' . ($data->updated_at->format('A') == 'AM' ? 'صباحاً' : 'مساءً')
                : 'لايوجد تحديث'
                                }}
                                    <br>

                                    بواسطة:
                                    {{ optional($data->updatedBy)->name ?? 'غير معروف' }}

                                    <a href="{{ route('admin.adminpanelsetting.edit') }}" class="btn btn-sm btn-success">
                                        تعديل
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            @else

                <div class="alert alert-danger text-center">
                    عفوا....لاتوجد بيانات لعرضها
                </div>

            @endif

        </div>
    </div>

@endsection
