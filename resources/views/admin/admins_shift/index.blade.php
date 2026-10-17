@extends('layouts.admin')
@section('title')

    حركه شفت الخزينه
@endsection

@section('contentheader')
    حركه شفت الخزينه
@endsection
@section('contentlink')
    <a href="{{ route('admin.treasuries.index') }}"> حركه شفت الخزينه</a>

@endsection
@section('this is teast')
    عرض
@endsection

@section('content')
    @if(session('success'))
        <div
            style="
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
        <div
            style="
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

            @if($data->isNotEmpty())

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title card_title_center">بيانات حركه شفت الخزينه</h3>
                        <a href="{{ route('admins_shift.create') }}" class="btn btn-sm btn-success">
                            فتح شفت جديد 
                        </a>

                    </div>
                    <div class="card-header">

                        <h3 class="card-title card_title_center">بيانات المستخدمين لحركه شفت الخزينه</h3>

                        {{-- <form action="" method="GET" class="mt-3">
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
                        </form> --}}

                    </div>


                    <div class="card-body">

                        <div class="table-responsive">
                            {{-- @if(isset($search) && $data->count() == 0)
                            <div class="alert alert-danger text-center">
                                لا يوجد مساتخدمين بهاذا الااسم بهذا الاسم: {{ $search }}
                            </div>
                            @endif --}}

                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th>مسلسل</th>
                                    <th>اسم المستخدم</th>
                                    <th>اسم الخزينه</th>
                                    <th>تاريخ بدايه الورديه</th>
                                    <th>تاريخ نهايه الورديه</th>

                                    <th> انتهى الشفت</th>
                                    <th>حاله المراجعه</th>



                                    <th></th>
                                </thead>

                                <tbody>
                                    @foreach($data as $info)

                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}

                                                @if($info->is_finished == 0 && $info->admin_id == auth()->guard('admin')->id())
                                                    <br>
                                                    <span class="badge badge-danger mt-1">
                                                        شفتك الحالي
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $info->adminname->name ?? 'لايوجد اسم ' }}</td>
                                            <td>{{ $info->treasuriesname->name ?? 'لايوجد اسم خزينه ' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($info->start_date)->format('Y-m-d h:i') }}
                                                {{ \Carbon\Carbon::parse($info->start_date)->format('A') == 'AM' ? 'صباحًا' : 'مساءً' }}
                                            </td>
                                            <td>{{ $info->end_date ?? 'لايوجد تاريخ' }}</td>
                                            {{-- <td>{{ $info->treasuries_balance_in_shift_start * 1 ?? 'لايوجد رصيد' }}</td> --}}
                                            <td>{{ $info->is_finished == 1 ? 'نعم ' : 'لم ينتهي' }}</td>
                                            <td>{{$info->is_delivered_and_rivew == 1 ? 'تمت المراجعة' : ($info->is_finished == 1 ? 'بانتظار المراجعة' : 'ليس بعد') }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="" class="btn btn-sm btn-success mr-2">
                                                        <i class="fas fa-print"></i> طباعة الكشف
                                                    </a>

                                                    <a href="{{ route('admin_accauonts.detalls', $info->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="fas fa-file-alt"></i> كشف مختصر
                                                    </a>
                                                </div>
                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>



                            </table>
                            {{-- {{ $data->links() }} --}}
                        </div>
                    </div>

            @else
                    <a href="{{ route('admins_shift.create') }}" class="btn btn-sm btn-success">
                        فتح شفت جديد جديد
                    </a>
                    <div class="alert alert-danger text-center">
                        عفوا....لاتوجد بيانات لعرضها
                    </div>

                @endif

            </div>
        </div>
    </div>


@endsection
