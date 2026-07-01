@extends('layouts.admin')
@section('title')

    الحسابات
@endsection

@section('contentheader')
    انواع الحسابات
@endsection
@section('contentlink')
    الحسابات
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
    <div class="row">
        <div class="col-12">

            @if($data)
                <div class="card">
                    {{-- <div class="card-header">
                        <h3 class="card-title card_title_center">انواع الحسابات</h3>
                        <a href="" class="btn btn-sm btn-success">
                            اضافه جديد
                        </a>

                    </div> --}}

                    <div class="card-header">

                        <h3 class="card-title card_title_center">انواع الحسابات</h3>

                        <form action="{{ route('admin.acaauont_types.search') }}" method="GET" class="mt-3">
                            <div class="row align-items-center">

                                <div class="col-md-4">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="ابحث باسم المخزن" class="form-control">
                                </div>

                                <div class="col-md-2">
                                    <button class="btn btn-primary btn-block" type="submit">
                                        <i class="fas fa-search"></i> بحث
                                    </button>
                                </div>

                                <div class="col-md-2">
                                    <a href="{{ route('acaauont_types.index') }}" class="btn btn-info btn-block">
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
                                    لا يوجد حسابات بهذا الاسم: {{ $search }}
                                </div>
                            @endif
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th>مسلسل</th>
                                    <th>اسم الحساب</th>
                                    <th>الحالة التفعيل</th>
                                    <th>هل له علاقه بلداخلي</th>

                                </thead>

                                <tbody>
                                    @foreach($data as $info)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $info->name }}</td>
                                            <td>{{ $info->active == 1 ? 'مفعل' : 'غير مفعل' }}</td>
                                            <td>{{ $info->relatedternalaccounts == 1 ? 'نعم مضاف من شاشات الحسابات' : 'لا مضاف من شاشات الحسابات' }}</td>

                                        </tr>
                                    @endforeach

                                </tbody>



                            </table>
                            {{ $data->links() }}
                        </div>
                    </div>

            @else
                    <a href="{{ route('admin.stores.create') }}" class="btn btn-sm btn-success">
                        اضافه جديد
                    </a>
                    <button type="button" class="btn btn-danger" onclick="window.history.back()">الغاء</button>


                    <div class="alert alert-danger text-center">
                        عفوا....لاتوجد مخازن لعرضها
                    </div>

                @endif

            </div>
        </div>
    </div>


@endsection
