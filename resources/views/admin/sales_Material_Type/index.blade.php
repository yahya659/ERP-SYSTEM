@extends('layouts.admin')
@section('title')

    فئات الفواتير المخازن
@endsection

@section('contentheader')
    الفواتير المخازن
@endsection
@section('contentlink')
    الفواتير المخازن
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
    <form action="{{ route('admin.SalesMaterialTypeController.search') }}" method="GET">

        <div class="row align-items-end">

            <!-- البحث بالاسم -->
            <div class="col-md-6">
                <label>البحث بالاسم</label>
                <input type="text" name="search" class="form-control" placeholder="بحث بالاسم"
                    value="{{ request('search') }}">
            </div>

            <!-- زر البحث -->
            <div class="col-md-2">
                <button class="btn btn-primary w-100" type="submit">
                    بحث
                </button>

            </div>


        </div>

    </form>
    <div class="row">
        <div class="col-12">

            @if($data)

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title card_title_center">بيانات الفواتير</h3>
                        <a href="{{ route('admin.SalesMaterialTypeController.create') }}" class="btn btn-sm btn-success">
                            اضافة جديد
                        </a>
                        <a href="{{ route('admin.sales_material_types.index') }}" class="btn btn-info">
                            عرض جميع الفواتير
                        </a>

                    </div>


                      @if(isset($search) && $data->count() == 0)
                                <div class="alert alert-danger text-center">
                                    لا يوجد فئه فواتير بهذا الاسم: {{ $search }}
                                </div>
                            @endif
                    <div class="card-body">

                        <div class="table-responsive">


                            <table id="example2" class="table table-bordered table-hover">

                                <thead class="custom_thead">
                                    <th>مسلسل</th>
                                    <th>اسم الفئه</th>
                                    <th>الحالة التفعيل</th>
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
                                            <td>{{ $info->created_at }} بواسطة:
                                                {{ $info->addedBy->name ?? 'غير معروف' }}
                                            </td>
                                            </td>
                                            <td>{{ $info->updated_at }}
                                                بواسطة:
                                                {{ $info->updatedBy->name ?? 'غير معروف' }}
                                            </td>
                                            <td><a href="{{ route('admin.SalesMaterialTypeController.edit', $info->id) }}"
                                                    class="btn btn-sm btn-success">
                                                    تعديل
                                                </a>


                                                <a href="{{ route('admin.delete_SalesMaterialType', $info->id) }}"
                                                    onclick="return confirm('هل أنت متأكد من حذف الفئه ..لن تتمكن من استرجاعها مجددا')"
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

                    <div class="alert alert-danger text-center">
                        عفوا....لاتوجد بيانات لعرضها
                    </div>

                @endif

            </div>
        </div>
    </div>


@endsection
