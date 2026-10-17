@extends('layouts.admin')

@section('title')
    المبيعات
@endsection

@section('contentheader')
    المبيعات
@endsection

@section('contentlink')
    المبيعات
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
                        <h3 class="card-title card_title_center">فواتير المبيعات للعملاء</h3>
                        <button type="button" class="btn btn-success" onclick="$('#addInvoicemirrorModal').modal('show')">
                            عرض اسعار
                        </button>
                        {{--الموديل الخاص ب اضافه الاااصناف بعرض الااسعار --}}
                        @include('admin.Sales_Invoice.load_addinvoicemirror')
                        {{-- اضافه فاتوره مبيعات الفعليه --}}
                        {{-- <h3 class="card-title card_title_center">اضافه فاتوره مبيعات الفعليه </h3> --}}
                        <button type="button" class="btn btn-info" onclick="$('#loadmodeladdbtnactiveinvoice').modal('show')">
                            اضافه فاتوره فعليه
                        </button>
                        {{--الموديل الخاص ب اضافه الاااصناف ببفاتوره لفعليه--}}
                        @include('admin.Sales_Invoice.loadmodeladdbtnactiveinvoice')
                    </div>

                    <div class="card-header">

                    </div>

                    <!-- البحث بالاسم -->
                    <div class="col-md-10">

                        <form action="{{ route('Sales_Invoice.search') }}" method="GET">

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
                                                    class="form-control"
                                                    placeholder="رقم الفاتورة أو اسم العميل أو اسم المندوب">

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


                                        {{-- زر البحث --}}
                                        <div class="col-md-1">

                                            <button type="submit" class="btn btn-primary ">

                                                {{-- <i class="fas fa-search"></i> --}}

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
                            <a href="{{ route('Sales_Invoice.index') }}" class="btn btn-info">
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

                                            عفوا....لاتوجد مبيعات لعرضها


                                        @else

                                            عفوا....لاتوجد مبيعات لعرضها


                                        @endif

                                    </div>

                                @endif
                               <div class="d-flex align-items-center justify-content-between p-3 my-3 bg-primary text-white rounded shadow-sm">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-invoice fa-2x ml-3 me-3"></i>
                                        <h6 class="mb-0 fw-bold">جميع فواتير العملاء</h6>
                                    </div>
                                    <span class="badge bg-light text-primary fs-6 px-3 py-2 rounded-pill">
                                        إجمالي الفواتير: {{ $data->count() }}
                                    </span>
                                </div>
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead class="custom_thead">

                                        <th>رقم الفاتوره(serial_no)</th>
                                        <th>العميل</th>
                                        <th>المندوب</th>
                                        <th>نوع الفاتوره</th>
                                        <th>تاريخ الفاتوره</th>
                                        {{-- <th>تاريخ التحديث</th> --}}
                                        <th>حاله الفاتوره</th>


                                        <th>#</th>
                                    </thead>

                                    <tbody>
                                        @foreach($data as $info)
                                            <tr>

                                                <td>{{ $info->auto_serial }}</td>
                                                <td>
                                                    {{ $info->Customer?->name ?? 'بدون عميل' }}
                                                </td>
                                                <td>{{ $info->delegate->name ?? 'لايوجد'  }}</td>

                                                <td>{{ $info->salesmaterialtypes?->name ?? 'غير محدد' }}</td>
                                                <td>{{ $info->invoice_date }}</td>
                                                <td>{{ $info->is_approved == 1 ? 'معتمده -- من: ' . $info->approvedby->name : 'مفتوح--لم يتم الااعتماد' }}</td>
                                                <td>
                                                    <div class="d-flex gap-3">


                                                        <div class="d-flex align-items-center justify-content-center flex-wrap"
                                                            style="gap: 6px;">

                                                            {{-- تعديل --}}
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                onclick="$('#load_invoice_edit_{{ $info->auto_serial }}').modal('show')">
                                                                <i class="fas fa-edit"></i>
                                                                تعديل
                                                            </button>

                                                            {{-- تعديل فاتورة فعلية --}}
                                                            @include('admin.Sales_Invoice.load_invoice_edit', ['data' => $info])


                                                            <form action="{{ route('Sales_Invoice.destroy', $info->id) }}"
                                                                method="POST" class="d-inline m-0">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit" @if ( $info->is_approved == 1) disabled

                                                                @endif
                                                                    onclick="return confirm('هل أنت متأكد من حذف الفاتورة؟ لن تتمكن من استرجاعها مجدداً')"
                                                                    class="btn btn-sm btn-danger">
                                                                    <i class="fas fa-trash"></i>
                                                                    حذف
                                                                </button>
                                                            </form>

                                                        </div>

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
                        <a href="{{ route('Sales_Invoice.create') }}" class="btn btn-sm btn-success">
                            اضافة جديد
                        </a>
                        <button type="button" class="btn btn-danger" onclick="window.history.back()">رجوع </button>


                        <div class="alert alert-danger text-center">
                            عفوا....لاتوجد مبيعات لعرضها
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>


@endsection
{{-- سكربت ينقلك الى تعديل الفاتوره او املاء الفاتوره بعد فتحها للعميل --}}

<script src="{{ asset('assets/admin/dist/js/SalesInvoice.js') }}"></script>
