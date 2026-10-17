@extends('layouts.admin')
@section('title')

    الصلاحيات
@endsection

@section('contentheader')
    المستخدمين
@endsection
@section('contentlink')
    <a href="{{ route('admin.treasuries.index') }}">المستخدمين</a>

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
    @if(session('info'))
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
            {{ session('info') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12">

            @if($data)

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title card_title_center">بيانات المستخدمين</h3>
                        <a href="" class="btn btn-sm btn-success">
                            اضافة جديد
                        </a>

                    </div>
                    <div class="card-header">

                        <h3 class="card-title card_title_center">بيانات المستخدمين</h3>

                        <form action="" method="GET" class="mt-3">
                            <div class="row align-items-center">

                                <div class="col-md-4">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="ابحث باسم الخزن" class="form-control">
                                </div>

                                <div class="col-md-2">
                                    <button class="btn btn-primary btn-block" type="submit">
                                        <i class="fas fa-search"></i> بحث
                                    </button>
                                </div>

                                <div class="col-md-2">
                                    <a href="{{ route('admin_accauonts.index') }}" class="btn btn-info btn-block">
                                        عرض الجميع
                                    </a>
                                </div>



                            </div>
                        </form>

                    </div>


                    <div class="card-body">

                        <div class="table-responsive">
                            @if(isset($search) && $data->count() == 0)
                                <div class="alert alert-danger text-center">
                                    لا يوجد مساتخدمين بهاذا الااسم بهذا الاسم: {{ $search }}
                                </div>
                            @endif

                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th>مسلسل</th>
                                    <th>اسم المستخدم</th>

                                    <th>الحالة</th>

                                    <th>#</th>
                                </thead>

                                <tbody>
                                    @foreach($data as $info)

                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $info->name }}</td>

                                            <td>{{ $info->active == 1 ? 'مفعل' : 'غير مفعل' }}</td>

                                            <td>
                                                <a href=""
                                                    class="btn btn-sm btn-success">
                                                    تعديل
                                                </a>

                                                <a href="{{ route('admin_accauonts.detalls',$info->id) }}"
                                                    class="btn btn-sm btn-info ml-1">
                                                   تفاصيل المستخدم
                                                </a>
                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>



                            </table>
                            {{ $data->links() }}
                        </div>
                    </div>

            @else

                    <div class="alert alert-danger text-center">
                        عفوا....لاتوجد بيانات لعرضها
                    </div>

                @endif

            </div>
        </div>
    </div>


@endsection
