@extends('layouts.admin')
@section('title')

    الوحدات
@endsection

@section('contentheader')
    الوحدات
@endsection
@section('contentlink')
    الوحدات
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

    @if(session('error'))
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
            {{ session('error') }}
        </div>
    @endif
    <div class="row">
        <div class="col-12">

            @if($data)

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title card_title_center">بيانات وحده الااصناف</h3>
                        <a href="{{ route('admin.Inv_uom.create') }}" class="btn btn-sm btn-success">
                            اضافة جديد
                        </a>

                    </div>
                    <div class="row align-items-end">

                        <!-- البحث بالاسم -->
                        <div class="col-md-6">

                            <form action="{{ route('admin.Inv_uom.search') }}" method="GET">

                                <div class="row align-items-end">

                                    <!-- البحث بالاسم -->
                                    <div class="col-md-6">
                                        <label>البحث بالاسم</label>
                                        <input type="text" name="search" class="form-control" placeholder="بحث بالاسم"
                                            value="{{ request('search') }}">
                                    </div>

                                    <!-- البحث بالنوع -->
                                    <div class="col-md-4">
                                        <label>نوع الصنف</label>
                                        <select name="is_master_search" class="form-control">
                                            <option value="">الكل</option>
                                            <option value="1">جملة</option>
                                            <option value="0">تجزئة</option>
                                        </select>
                                    </div>

                                    <!-- زر البحث -->
                                    <div class="col-md-2">
                                        <button class="btn btn-primary w-100" type="submit">
                                            بحث
                                        </button>
                                    </div>

                                </div>

                            </form>

                        </div>


                        <div class="card-body">
                            <a href="{{ route('admin.Inv_uom.index') }}" class="btn btn-info">
                                عرض جميع بيانات الوحدات
                            </a>

                            <div class="table-responsive">
                                @if($data->count() == 0)

                                    <div class="alert alert-danger text-center">

                                        @if(request('search') && request('is_master_search') !== null && request('is_master_search') !== '')

                                            لا يوجد هذا الصنف:
                                            <b>{{ request('search') }}</b>
                                            في قسم
                                            <b>{{ request('is_master_search') == 1 ? 'الجملة' : 'التجزئة' }}</b>

                                        @elseif(request('search'))

                                            لا يوجد أي نتائج للبحث عن:
                                            <b>{{ request('search') }}</b>

                                        @elseif(request('is_master_search') !== null && request('is_master_search') !== '')

                                                                       عفوا....لاتوجد وحدات لعرضها


                                        @else

                                                                     عفوا....لاتوجد وحدات لعرضها


                                        @endif

                                    </div>

                                @endif


                                <table id="example2" class="table table-bordered table-hover">
                                    <thead class="custom_thead">
                                        <th>مسلسل</th>
                                        <th>اسم القسم</th>
                                        <th>الحالة التفعيل</th>
                                        {{-- <th>هل رئيسيه</th> --}}
                                        <th>نوع القسم</th>
                                        <th>تاريخ الاااضافه</th>
                                        <th>تاريخ التحديث</th>

                                        <th>#</th>
                                    </thead>

                                    <tbody>
                                        @foreach($data as $info)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $info->name }}</td>
                                                <td>{{ $info->active == 1 ? 'مفعل' : 'غير مفعل' }}</td>
                                                <td>{{ $info->is_master == 1 ? 'وحده جمله -اب' : '  وحده تجزئه' }}</td>
                                                {{-- <td></td> --}}
                                                <td>{{ $info->created_at }} بواسطة:
                                                    {{ $info->addedBy->name ?? 'غير معروف' }}
                                                </td>
                                                </td>
                                                <td>{{ $info->updated_at }}
                                                    بواسطة:
                                                    {{ $info->updatedBy->name ?? 'غير معروف' }}
                                                </td>
                                                <td><a href="{{ route('admin.Inv_uom.edit', $info->id) }}"
                                                        class="btn btn-sm btn-success">
                                                        تعديل
                                                    </a>


                                                    <a href="{{ route('admin.delete_Inv_uom', $info->id) }}"
                                                        onclick="return confirm('هل أنت متأكد من حذف الوحده ..لن تتمكن من استرجاعها مجددا')"
                                                        class="btn btn-sm btn-danger">
                                                        حذف
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
                        <a href="{{ route('admin.Inv_uom.create') }}" class="btn btn-sm btn-success">
                            اضافة جديد
                        </a>
                        <button type="button" class="btn btn-danger" onclick="window.history.back()">رجوع </button>


                        <div class="alert alert-danger text-center">
                            عفوا....لاتوجد وحدات لعرضها
                        </div>

                    @endif

                </div>
            </div>
        </div>


@endsection
