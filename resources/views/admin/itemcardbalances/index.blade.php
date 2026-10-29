@extends('layouts.admin')

@section('title')
    ارصده الااصناف
@endsection

@section('contentheader')
    ارصده الااصناف

@endsection

@section('contentlink')
    ارصده الااصناف

@endsection

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- البحث بالاسم -->
    <div class="col-md-6">

        <form action="{{ route('itemcardbalances.search') }}" method="GET">

            <div class="row align-items-end">

                <div class="col-md-5">
                    <label>البحث بال اسم</label>
                    <input type="text" name="search" class="form-control" placeholder="بحث بالاسم"
                        value="{{ request('search') }}">
                </div>

                <div class="col-md-5">
                    <label>البحث بكود الصنف</label>
                    <input type="text" name="item_code" class="form-control" placeholder="بحث بكود الصنف"
                        value="{{ request('item_code') }}">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">
                        بحث
                    </button>
                </div>

            </div>

        </form>

    </div>
    <div class="row">

        <div class="col-12">

            @if($allitemcarddata->count() > 0 || isset($search) || isset($itemCode))

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">بيانات المنتجات وأرصدة الخزن</h3>

                        <div class="card-tools">
                            <a href="{{ route('itemcardbalances.create') }}" class="btn btn-success btn-sm">
                                إضافة جديد
                            </a>

                            <a href="{{ route('itemcardbalances.index') }}" class="btn btn-info btn-sm">
                                عرض جميع الأصناف
                            </a>
                        </div>
                    </div>

                    <div class="card-body">

                        @if(isset($search) && $allitemcarddata->count() == 0)
                            <div class="alert alert-danger text-center">
                                لا توجد أصناف بهذا الاسم: {{ $search }}
                            </div>
                        @endif

                        @if(isset($itemCode) && $allitemcarddata->count() == 0)
                            <div class="alert alert-danger text-center">
                                لا توجد أصناف بهذا الكود: {{ $itemCode }}
                            </div>
                        @endif

                        <div class="table-responsive">

                            <table class="table table-bordered table-hover text-center">

                                <thead class="custom_thead">
                                    <tr>
                                        <th style="width: 15%;">كود الصنف</th>
                                        <th style="width: 20%;">اسم الصنف</th>
                                        <th>إجمالي الكمية بجميع الخزن</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($allitemcarddata as $info)

                                        <tr>

                                            <td>
                                                {{ $info->item_code }}
                                            </td>

                                            <td>
                                                <strong>{{ $info->name }}</strong>
                                            </td>

                                            <td>

                                                <div class="mb-2">
                                                    @if($info->total_quantity > 0)
                                                        <span class="badge badge-success" style="font-size: 14px;">
                                                            اجمالي الكميه في جميع المخازن :
                                                            {{ number_format($info->total_quantity ) }}

                                                        </span>
                                                    @else
                                                        <span class="badge badge-secondary">
                                                            لا يوجد
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="table-responsive">

                                                    <table class="table table-sm table-bordered table-hover mb-0 text-center">

                                                        <thead style="background-color: #f4f6f9;">
                                                            <tr>
                                                                <th>رقم الباتش</th>
                                                                <th>الخزن</th>
                                                                <th>الكمية</th>
                                                                <th>تاريخ الإنتاج</th>
                                                                <th>تاريخ الانتهاء</th>
                                                                <th>المدة المتبقية</th>
                                                                <th>سعر تكلفة الوحدة</th>
                                                                <th>إجمالي سعر التكلفة</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>

                                                            @forelse($info->batches->where('quantity', '>', 0) as $batch)

                                                                                                <tr>
                                                                                                    <td>{{ $batch->auto_serial ?: 'لا يوجد' }}</td>

                                                                                                    <td>{{ $batch->storeid->name ?? 'لا يوجد' }}</td>

                                                                                                    <td>{{ number_format($batch->quantity ) }}<br/> ({{ $batch->invuomsid->name }}) </td>

                                                                                                    <td>{{ $batch->production_date ?: 'لا يوجد' }}</td>

                                                                                                    <td>{{ $batch->expire_date ?: 'لا يوجد' }}</td>

                                                                                                    <td>
                                                                                                        @if(!$batch->expire_date)
                                                                                                            لا يوجد
                                                                                                        @else
                                                                                                            @php
                                                                                                                $today = \Carbon\Carbon::today();
                                                                                                                $expireDate = \Carbon\Carbon::parse($batch->expire_date)->startOfDay();
                                                                                                                $daysLeft = (int) $today->diffInDays($expireDate, false);
                                                                                                            @endphp

                                                                                                            @if($daysLeft < 0)
                                                                                                                <span class="badge badge-danger">
                                                                                                                    منتهي منذ {{ abs($daysLeft) }} يوم
                                                                                                                </span>
                                                                                                            @elseif($daysLeft == 0)
                                                                                                                <span class="badge badge-danger">ينتهي اليوم</span>
                                                                                                            @elseif($daysLeft <= 30)
                                                                                                                <span class="badge badge-warning">باقي {{ $daysLeft }}
                                                                                                                    يوم</span>
                                                                                                            @else
                                                                                                                <span class="badge badge-success">باقي {{ $daysLeft }}
                                                                                                                    يوم</span>
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    </td>

                                                                                                    <td>
                                                                                                        {{ $batch->unit_cost_price !== null && $batch->unit_cost_price !== ''
                                                                                                        ? number_format($batch->unit_cost_price, 2)
                                                                                                        : 'لا يوجد' }}
                                                                                                    </td>

                                                                                                    <td>
                                                                                                        {{ $batch->total_cost_price !== null && $batch->total_cost_price !== ''
                                                                                                        ? number_format($batch->total_cost_price, 2)
                                                                                                        : 'لا يوجد' }}
                                                                                                    </td>
                                                                                                </tr>

                                                            @empty
                                                                <tr>
                                                                    <td colspan="8" class="text-muted">
                                                                        لا توجد باتشات لها كمية متوفرة لهذا الصنف
                                                                    </td>
                                                                </tr>
                                                            @endforelse

                                                        </tbody>

                                                    </table>

                                                </div>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>
                                            <td colspan="3" class="text-center text-muted">
                                                لا توجد منتجات
                                            </td>
                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                        <div class="mt-3">
                            {{ $allitemcarddata->links() }}
                        </div>

                    </div>

                </div>

            @else

                <div class="card">
                    <div class="card-body text-center">

                        <a href="{{ route('itemcardbalances.create') }}" class="btn btn-success btn-sm">
                            إضافة جديد
                        </a>

                        <div class="alert alert-danger mt-3 mb-0">
                            لا توجد منتجات
                        </div>

                    </div>
                </div>

            @endif

        </div>

    </div>


@endsection
