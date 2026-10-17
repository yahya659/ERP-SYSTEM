@extends('layouts.admin')
@section('title')

    المشتريات
@endsection

@section('contentheader')
    الحركه المخزونيه
@endsection
@section('contentlink')
    فواتير المشتريات من الموردين
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
                        <h3 class="card-title card_title_center">فواتير المشتريات من الموردين</h3>
                        <a href="{{ route('SupplierWithOrder.create') }}" class="btn btn-sm btn-success">
                            اضافة جديد
                        </a>

                    </div>

                    <!-- البحث بالاسم -->
                    <div class="col-md-10">
                        <form action="{{ route('SupplierWithOrder.search') }}" method="GET">

                            <div class="card shadow-sm border-0">
                                <div class="card-body">

                                    <div class="row g-2 align-items-end">

                                        {{-- البحث --}}
                                        <div class="col-md-5">
                                            <label class="form-label">
                                                <i class="fas fa-search"></i>
                                                بحث
                                            </label>

                                            <div class="input-group">
                                                <input type="text" name="search" value="{{ request('search') }}"
                                                    class="form-control" placeholder="رقم الفاتورة أو اسم المورد">


                                            </div>
                                        </div>


                                        {{-- من تاريخ --}}
                                        <div class="col-md-3">
                                            <label class="form-label">
                                                <i class="far fa-calendar-alt"></i>
                                                من تاريخ
                                            </label>

                                            <input type="date" name="from_date" value="{{ request('from_date') }}"
                                                class="form-control">
                                        </div>


                                        {{-- إلى تاريخ --}}
                                        <div class="col-md-3">
                                            <label class="form-label">
                                                <i class="far fa-calendar-alt"></i>
                                                إلى تاريخ
                                            </label>

                                            <input type="date" name="to_date" value="{{ request('to_date') }}"
                                                class="form-control">
                                        </div>


                                        {{-- إعادة تعيين --}}
                                        <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                        بحث
                                    </button>
                                </div>

                                    </div>

                                </div>

                            </div>

                        </form>
                    </div>
                    <div class="row align-items-end">
                        <div class="card-body">
                            <a href="{{ route('SupplierWithOrder.index') }}" class="btn btn-info">
                                عرض جميع
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

                                            عفوا....لاتوجد مشتريات لعرضها


                                        @else

                                            عفوا....لاتوجد مشتريات لعرضها


                                        @endif

                                    </div>

                                @endif



                                <table id="example2" class="table table-bordered table-hover">
                                    <thead class="custom_thead">

                                        <th>رقم الفاتوره</th>
                                        <th>المورد</th>

                                        <th>نوع الفاتوره</th>
                                        <th>ملاحضه </th>
                                        <th>المخزن المستلم</th>
                                        <th>تاريخ الفاتوره</th>
                                        {{-- <th>تاريخ التحديث</th> --}}
                                        <th>حاله الفاتوره</th>

                                        <th>#</th>
                                    </thead>

                                    <tbody>
                                        @foreach($data as $info)
                                            <tr>

                                                <td>{{ $info->doc_no }}</td>
                                                <td>{{ $info->supplier->name }}</td>
                                                <td>{{ $info->bill_type == 1 ? 'اجل' : 'كاش' }}</td>
                                                <td>{{ $info->notes}}</td>
                                                <td>{{ $info->storename->name ?? 'لا يوجد مخزن'}}</td>
                                                <td>{{ $info->order_date }}</td>
                                                <td>{{ $info->is_approved == 1 ? 'مغلقه' : 'مفتوح' }}</td>
                                                <td>
                                                    <div class="d-flex gap-3">

                                                         @if ($info->is_approved==1)
                                                        <a href="{{ route('SupplierWithOrder.edit', $info->id) }}" style="display: none"
                                                            class="btn btn-sm btn-success gap-3">
                                                            تعديل
                                                        </a>
                                                        @else
                                                        <a href="{{ route('SupplierWithOrder.edit', $info->id) }}"
                                                            class="btn btn-sm btn-success gap-3">
                                                            تعديل
                                                        </a>

                                                        @endif
{{--
                                                        <a href="{{ route('SupplierWithOrder.edit', $info->id) }}"
                                                            class="btn btn-sm btn-success gap-3">
                                                            تعديل
                                                        </a> --}}

                                                        <a href="{{ route('SupplierWithOrder.show', $info->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            الاصناف
                                                        </a>



                                                        <form action="{{ route('SupplierWithOrder.destroy', $info->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                             @if ($info->is_approved==1)
                                                        <button type="submit"
                                                                onclick="return confirm('هل أنت متأكد من حذف الفاتورة؟ لن تتمكن من استرجاعها مجدداً')"
                                                                class="btn btn-sm btn-danger" style="display: none">
                                                                حذف
                                                            </button>
                                                            @else
                                                             <button type="submit"
                                                                onclick="return confirm('هل أنت متأكد من حذف الفاتورة؟ لن تتمكن من استرجاعها مجدداً')"
                                                                class="btn btn-sm btn-danger" >
                                                                حذف
                                                            </button>


                                                        @endif



                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>



                                </table>
                                {{ $data->links() }}
                            </div>
                        </div>

            @else
                        <a href="{{ route('SupplierWithOrder.create') }}" class="btn btn-sm btn-success">
                            اضافة جديد
                        </a>
                        <button type="button" class="btn btn-danger" onclick="window.history.back()">رجوع </button>


                        <div class="alert alert-danger text-center">
                            عفوا....لاتوجد مشتريات لعرضها
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>


@endsection
