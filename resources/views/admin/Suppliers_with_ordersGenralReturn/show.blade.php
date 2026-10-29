@extends('layouts.admin')
@section('title')

 عرض تفاصيل المرتجع
@endsection

@section('contentheader')
    عرض تفاصيل المرتجع
@endsection
@section('contentlink')
    عرض تفاصيل المرتجع
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
                                                background-color: #f8d7da;
                                                color: #721c24;
                                                border: 1px solid #f5c6cb;
                                                padding: 15px;
                                                border-radius: 5px;
                                                margin-bottom: 20px;
                                                font-weight: bold;
                                                text-align: center;
                                            ">
            <i class="fas fa-exclamation-triangle"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="card">

        <div class="card-header">
            <h3>  تفاصيل المرتجع</h3>
        </div>



        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th>كود الفاتوره الاالي </th>
                    <td>{{ $data->auto_serial  }}</td>
                </tr>

                <tr>
                    <th> كود فاتوره باصل فاتوره المشتريات </th>
                    <td>{{ $data->doc_no }}</td>
                </tr>

                <tr>
                    <th> تاريخ الفاتوره </th>
                    <td>{{ $data->order_date }}</td>
                </tr>
                <tr>
                    <th> اسم المورد</th>
                    <td>{{ $data->supplier->name }}</td>
                </tr>
                <tr>
                    <th> اسم المخزن المستلم الفاتروه</th>
                    <td>{{ $data->storename->name ?? 'لايوجد' }}</td>
                </tr>
                <tr>
                    <th> نوع الفاتوره</th>
                    <td>{{ $data->bill_type == 0 ? 'كاش' : 'اجل' }}</td>
                </tr>
                <tr>
                    <th> اجمالي الفاتوره</th>
                    <td>{{ $data->total_cost * 1 ?? '0'}}</td>
                </tr>
                @if($data->discount_type != null)
                    <tr>
                        <th>الخصم على الفاتورة %</th>
                        <td>
                            @if($data->discount_type == 1)
                                خصم بنسبة {{ $data->discount_percent * 1 }} وقيمتها {{ $data->discount_value * 1 }}
                            @else
                                خصم يدوي وقيمته {{ $data->discount_value * 1 }}
                            @endif
                        </td>
                    </tr>
                @else
                    <tr>
                        <th>الخصم على الفاتورة</th>
                        <td>لا يوجد</td>
                    </tr>
                @endif
                <tr>
                    <th>القيمة المضافة (الضريبه)</th>
                    <td>
                        @if($data->tax_percent > 0)
                            بنسبه {{ $data->tax_percent * 1 }} % وقيمتها {{ $data->tax_value * 1 }}
                        @else
                            لا يوجد
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>الااضافه</th>
                    <td>
                        {{ $data->addedBy->name ?? '-----' }}
                        <br>
                        {{ $data->created_at ? $data->created_at->format('Y-m-d') : '---' }}
                        -
                        {{ $data->created_at ? $data->created_at->format('h:i') : '' }}
                        {{ $data->created_at ? ($data->created_at->format('A') == 'AM' ? 'صباحاً' : 'مساءً') : '' }}
                    </td>
                </tr>
                <tr>
                    <th>التحديث</th>
                    <td>
                        {{ $data->updatedBy->name ?? 'لا يوجد' }}
                        <br>
                        {{ $data->updated_at ? $data->updated_at->format('Y-m-d') : '---' }}
                        -
                        {{ $data->updated_at ? $data->updated_at->format('h:i') : '' }}
                        {{ $data->updated_at ? ($data->updated_at->format('A') == 'AM' ? 'صباحاً' : 'مساءً') : '' }}
                    </td>
                </tr>
            </table>
            <a href="{{ route('SupplierWithOrder.index') }}" class="btn btn-danger">
                رجوع
            </a>
        </div>
    </div>

    {{-- ----------- --}}
    @if ($data->is_approved == 0)
        <p>الااصناف المرتجعه للفاتورة :</p>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addItemModal">
            <i class="fas fa-plus"></i> إضافة مرتجع للفاتورة
        </button>
     @if($data->details->count() > 0)
    <a href="#"
       class="btn btn-primary btn-sm rounded-pill px-3 shadow"
       data-toggle="modal"
       data-target="#approveModal">

        <i class="fa fa-share-square"></i>
        الاعتماد والترحيل المرتجع

    </a>
@endif
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    اعتماد  وترحيل الفاتورة المرتجع
                </h5>

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>
            </div>

            <div class="modal-body">

                {{--  نستدعي صفحة  --}}

              @include('admin.Suppliers_with_ordersGenralReturn.load_approve_invoice', ['data' => $data, 'adminsift' => $adminsift,'treasuriesBalance'=>$treasuriesBalance])


            </div>

        </div>

    </div>

</div>
{{-- نهايه الااعتماد والترحيل --}}

        <!--first Modal--------------------------------------------------------- -->
        <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">


                    <form action="{{ route('admin.suppliers_with_ordersGenralReturn.add_new_details') }}" method="POST" id="AddTobill">
                        @csrf

                        <input type="hidden" name="auto_serial" value="{{ $data->auto_serial }}">
                        <input type="hidden" name="order_date" value="{{ $data->order_date }}">



                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="addItemModalLabel">
                               اضافه  مرتجع للمورد :
                            </h5>

                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="active">اسم الصنف</label>
                                        <select name="item_code_add" id="item_code_add" class="form-control">
                                            <option value="" selected disabled>اختر الصنف</option>

                                          @foreach($item_cards as $info)
    <option value="{{ $info->item_code }}"
        data-main="{{ $info->uom_id }}"
        data-main-name="{{ $info->uomid->name ?? '' }}"
        data-retail="{{ $info->retail_uom }}"
        data-retail-name="{{ $info->retail_uom_id->name ?? '' }}"
        data-has-retail="{{ $info->dose_has_retailunit }}"
        data-type="{{ $info->item_type }}">
        {{ $info->name }}
    </option>
@endforeach
                                        </select>
                                    </div>
                                </div>

<div class="col-md-4" id="batch_div" style="display: none;">
    <div class="form-group">
        <label for="batch_id">الكميه بالمخزن المحدد ({{ $data->storename->name }})</label>
        <select name="batch_id" id="batch_id" class="form-control">
            <option value="">اختر الباتش</option>
        </select>
    </div>
</div>
                                <div class="col-md-4" id="unit_div" style="display: none;">
                                    <div class="form-group">
                                        <label for="active">بيانات وحدة الصنف</label>
                                        <select id="unit_data" name="unit_data" class="form-control">
                                            {{-- <option value="" selected disabled>اختر الوحدة</option> --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="delivery_quantity_div" style="display: none;">
                                    <div class="form-group">
                                        <label for="delivery_quantity">الكمية المستلمة</label>
                                        <input type="number" id="delivery_quantity" name="delivery_quantity"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4" id="price_add_div" style="display: none;">
                                    <div class="form-group">
                                        <label for="delivery_quantity">سعر الوحده</label>
                                        <input type="number" id="price_add" name="price_add" class="form-control" readonly>
                                    </div>
                                </div>
                                {{-- <div class="col-md-4" id="production_date_div" style="display: none;">
                                    <div class="form-group">
                                        <label for="delivery_quantity">تاريخ الانتاج</label>
                                        <input type="date" id="production_date" name="production_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4" id="expir_date_div" style="display: none;">
                                    <div class="form-group">
                                        <label for="delivery_quantity">تاريخ الانتهاء</label>
                                        <input type="date" id="expir_date" name="expir_date" class="form-control">
                                    </div>
                                </div> --}}
                                <div class="col-md-4" id="total_add_div" style="display: none;">
                                    <div class="form-group">
                                        <label for="delivery_quantity">الااجمالي</label>
                                        <input readonly id="total_add" name="total_add" class="form-control">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">


                            <button type="submit" class="btn btn-success">
                                إضافة الصنف للفاتورة
                            </button>



                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                إغلاق
                            </button>
                    </form>
                </div>

            </div>
        </div>
        <!-- end-Modal ------------------------------------------------------------->
        </div>
        {{-- الاصناف المطلوبه --}}
        <table class="table table-bordered table-striped text-center">
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
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>الصنف</th>
                    <th>الوحدة</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                    <th>الإجمالي</th>
                    <th>تاريخ الإنتاج</th>
                    <th>تاريخ الانتهاء</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>


            <tbody>

                @forelse ($data->details as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->item->name ?? 'غير موجود' }} <br>رقم الباتش : {{ $detail->batchid->auto_serial}}</td>
                        <td>{{ $detail->unit->name ?? '---' }}</td>
                        <td>{{ $detail->delivery_quantity * 1 }}</td>
                        <td>{{ $detail->unit_price * 1 }}</td>
                        <td>{{ $detail->total_price * 1 }}</td>
                        <td>{{ $detail->production_date ?? 'ليس الصنف استهلاكي' }}</td>
                        <td>{{ $detail->expir_date ?? 'ليس الصنف استهلاكي' }}</td>
                        <td>
                            <a href="{{ route('Suppliers_with_ordersGenralReturn.editdetail', $detail->id) }}" class="btn btn-sm btn-success">
                                تعديل
                            </a>
                            <form action="{{ route('suppliers_with_ordersGenralReturn.destroyDetail', $detail->id) }}" method="POST"
                                style="display:inline;">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('هل أنت متأكد من حذف هذا الصنف؟')">
                                    حذف
                                </button>

                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-danger font-weight-bold">
                            لا يوجد أصناف للفاتوره
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>




    @else
        <span class="alert alert-warning">الفاتوره مغلقه .... </span>
        <table class="table table-bordered table-striped text-center">
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
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>الصنف</th>
                    <th>الوحدة</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                    <th>الإجمالي</th>
                    <th>تاريخ الإنتاج</th>
                    <th>تاريخ الانتهاء</th>

                </tr>
            </thead>


            <tbody>

                @forelse ($data->details as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->item->name ?? 'غير موجود' }} <br>رقم الباتش : {{ $detail->batchid->auto_serial}}</td>
                        <td>{{ $detail->unit->name ?? '---' }}</td>
                        <td>{{ $detail->delivery_quantity * 1 }}</td>
                        <td>{{ $detail->unit_price * 1 }}</td>
                        <td>{{ $detail->total_price * 1 }}</td>
                        <td>{{ $detail->production_date ?? 'ليس الصنف استهلاكي' }}</td>
                        <td>{{ $detail->expir_date ?? 'ليس الصنف استهلاكي' }}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-danger font-weight-bold">
                            لا يوجد أصناف للفاتوره
                        </td>
                    </tr>
                @endforelse

        </table>

    @endif

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/admin/dist/js/supplierWithOrderGenralReturn.js') }}"></script>

@endsection
