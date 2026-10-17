@extends('layouts.admin')
@section('title')
    تفاصيل الخزن
@endsection
@section('contentheader')
    تفاصيل الخزن
@endsection
@section('contentlink')
    تفاصيل الخزن
@endsection
@section('this is teast')
    عرض
@endsection
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
@section('content')
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


    <data class="row">
        <div class="col-12">


            @if(isset($data) && !empty($data))
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tbody>

                            <tr>
                                <th width="30%" class="custom_thead">اسم الخزن</th>
                                <td>{{ $data->name }}</td>
                            </tr>

                            <tr>
                                <th class="custom_thead">آخر صرف</th>
                                <td>{{ $data->last_isal_exchange }}</td>
                            </tr>

                            <tr>
                                <th class="custom_thead">آخر تحصيل</th>
                                <td>{{ $data->last_isal_collection }}</td>
                            </tr>

                            <tr>
                                <th class="custom_thead">المخزن الرئيسي</th>
                                <td>
                                    @if($data->is_master == 1)
                                        نعم
                                    @else
                                        لا
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th class="custom_thead">تاريخ الإضافة</th>
                                <td>
                                    {{ $data->created_at->format('Y-m-d g:i') }}<br>
                                    {{ $data->created_at->format('A') == 'AM' ? 'صباحاً' : 'مساءً' }}
                                    <br>
                                    بواسطة {{ $data->addedBy->name ?? 'غير معروف' }}
                                </td>
                            </tr>

                            <tr>
                                <th class="custom_thead">تاريخ التحديث</th>
                                <td>
                                    {{ $data->updated_at->format('Y-m-d g:i') }}<br>
                                    {{ $data->updated_at->format('A') == 'AM' ? 'صباحاً' : 'مساءً' }}
                                    <br>
                                    بواسطة {{ $data->updatedBy->name ?? 'غير معروف' }}
                                </td>
                            </tr>

                            <tr>
                                <th class="custom_thead">الحالة</th>
                                <td>
                                    @if($data->active == 1)
                                        <span class="badge badge-success">مفعل</span>
                                    @else
                                        <span class="badge badge-danger">غير مفعل</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th class="custom_thead">الإجراءات</th>
                                <td>
                                    <a href="{{ route('admin.treasuries.edit', $data->id) }}" class="btn btn-sm btn-success">
                                        تعديل
                                    </a>

                                    <button type="button" class="btn btn-sm btn-secondary" onclick="window.history.back()">
                                        رجوع
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>


            @else
                <div class="alert alert-danger text-center">
                    عفوا.... لا توجد بيانات لعرضها
                </div>



            @endif


            {{-- start-Treasury_Delivery --}}
            @if($Treasury_Delivery->isNotEmpty())
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">

                        <h5 class="text-muted mb-2">
                           الخزن الفرعيه الذي تم تسليمها
                        </h5>

                        {{-- <h3 class="text-primary font-weight-bold">
                            (الفرع الريسي)
                        </h3> --}}

                        <hr>
{{-- 
                        <small class="text-muted">
                            يتم تسليم الخزن إلى المخزن الرئيسي
                        </small> --}}

                    </div>
                    <div class="card-header">
                        <a href="{{ route('admin.treasuries.Add_Treasury_Delivery', $data->id) }}"
                            class="btn btn-sm btn-success">
                            اضافه تسليم الخزن
                        </a>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-striped text-center">

                        <thead class="custom_thead">
                            <tr>
                                <th>اسم الخزن</th>
                                <th>تم تسليمه إلى</th>
                                <th>بواسطة</th>
                                <th>تاريخ التسليم</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($Treasury_Delivery as $info)

                                <tr>



                                    <td>
                                        {{ $info->canDeliveryTreasury->name ?? 'لا يوجد اسم' }}
                                    </td>
                                        <td>
                                        {{ $info->treasury->name ?? '---' }}
                                    </td>

                                    <td>
                                        {{ $info->addedBy->name ?? 'غير معروف' }}
                                    </td>

                                    <td>
                                        {{ $info->created_at->format('Y-m-d H:i') ?? 'لايوجد' }}
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.treasuries.delete_Treasury_Delivery', $info->id) }}"
                                            onclick="return confirm('هل أنت متأكد من حذف الخزن الفرعي؟')"
                                            class="btn btn-sm btn-danger">
                                            حذف
                                        </a>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>
                </div>

            @else
                <div class="card-header">
                    <a href="{{ route('admin.treasuries.Add_Treasury_Delivery', $data->id) }}" class="btn btn-sm btn-success">
                        اضافه تسليم الخزن
                    </a>
                </div>
                <div class="alert alert-warning text-center">
                    لا يوجد الخزن تم تسليمها
                </div>

            @endif
            {{-- end-Treasury_Delivery --}}




        </div>
        </div>

@endsection
