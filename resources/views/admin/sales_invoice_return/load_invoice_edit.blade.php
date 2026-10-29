<div class="modal fade" id="load_invoice_edit_{{ $data->auto_serial }}" tabindex="-1">
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
    <div class="modal-dialog modal-xl" role="document">

        <div class="modal-content">

            {{-- ===================================================== --}}
            {{-- Header --}}
            {{-- ===================================================== --}}

            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">
                    تعديل فاتورة مرتجع
                </h5>

                <button type="button" class="close text-white" data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>


            {{-- ===================================================== --}}
            {{-- Body --}}
            {{-- ===================================================== --}}

            <div class="modal-body">


                @if ($data->is_approved == 1)

                    {{-- الفاتورة معتمدة --}}

                    <div class="alert alert-danger text-center py-4">

                        <i class="fas fa-lock fa-2x mb-3"></i>

                        <h5 class="font-weight-bold">
                            لا يمكن تعديل الفاتورة
                        </h5>

                        <p class="mb-0">
                            هذه الفاتورة معتمدة من قبل، ولا يمكن تعديل بياناتها.
                        </p>

                    </div>

                @else


                    {{-- ================================================= --}}
                    {{-- الفاتورة غير معتمدة --}}
                    {{-- ================================================= --}}



                    @csrf


                    {{-- ================================================= --}}
                    {{-- بيانات الفاتورة --}}
                    {{-- ================================================= --}}

                    <div class="card mb-3">

                        <div class="card-header bg-light">

                            <strong>
                                بيانات الفاتورة
                            </strong>

                        </div>


                        <div class="card-body">

                            <div class="row">


                                {{-- تاريخ الفاتورة --}}

                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label>
                                            تاريخ الفاتورة
                                        </label>

                                        <input type="date" name="invoice_date" class="form-control"
                                            value="{{ $data->invoice_date }}" readonly>

                                    </div>

                                </div>


                                {{-- هل يوجد عميل --}}

                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label>
                                            هل يوجد عميل؟
                                        </label>

                                        <select name="is_has_customer" class="form-control">

                                            {{-- <option value="0" {{ $data->is_has_customer == 0 ? 'selected' : '' }}>
                                                لا يوجد عميل (طياري)
                                            </option> --}}

                                            <option value="1" {{ $data->is_has_customer == 1 ? 'selected' : '' }} disabled>
                                                يوجد عميل
                                            </option>

                                        </select>

                                    </div>

                                </div>


                                {{-- نوع الفاتورة --}}

                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label>
                                            نوع الفاتورة
                                        </label>

                                        <select name="sales_material_types" class="form-control">

                                            {{-- <option value="">
                                                اختر النوع
                                            </option> --}}

                                            @foreach ($sales_material_types as $type)

                                                <option value="{{ $type->id }}" {{ $data->sales_material_types == $type->id ? 'selected' : '' }} disabled>

                                                    {{ $type->name }}

                                                </option>

                                            @endforeach

                                        </select>


                                        @error('sales_material_types')

                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>

                                        @enderror

                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- بيانات العميل --}}
                    {{-- ================================================= --}}

                    <div class="card mb-3">

                        <div class="card-header bg-light">

                            <strong>
                                بيانات العميل
                            </strong>

                        </div>


                        <div class="card-body">

                            <div class="form-group">


                                <label>
                                    العميل
                                </label>

                                <select name="customer_code" class="form-control">

                                    {{-- <option value="">
                                        اختر العميل
                                    </option> --}}

                                    @foreach ($customers as $customer)

                                        <option value="{{ $customer->id }}" {{ $data->customer_code == $customer->id ? 'selected' : '' }} disabled>

                                            {{ $customer->name }}

                                        </option>

                                    @endforeach

                                </select>


                                @error('customer_code')

                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- بيانات المندوب --}}
                    {{-- ================================================= --}}

                    <div class="card mb-3">

                        <div class="card-header bg-light">

                            <strong>
                                بيانات المندوب
                            </strong>

                        </div>


                        <div class="card-body">

                            <div class="form-group">

                                <label>
                                    المندوب
                                </label>

                                <select name="delegate_id" class="form-control">

                                    {{-- <option value="">
                                        بدون مندوب
                                    </option> --}}

                                    @foreach ($delegate as $delegates)

                                        <option value="{{ $delegates->id }}" {{ $data->delegate_id == $delegates->id ? 'selected' : '' }} disabled>

                                            {{ $delegates->name }}

                                        </option>

                                    @endforeach

                                </select>


                                @error('delegate_id')

                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- إضافة صنف إلى الفاتورة --}}
                    {{-- ================================================= --}}
                    <form action="{{ route('sales_invoice_return.addItem') }}" method="POST">

                        @csrf
                        <div class="card mb-3 shadow-sm border-0">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">

                                    إضافة صنف إلى فاتورة المرتجع
                                </h5>
                            </div>
                        </div>


                        <div class="card-body">

                            {{-- رقم الفاتورة --}}
                            <input type="hidden" name="auto_serial_sales_invoice" value="{{ $data->auto_serial }}">
                            {{-- ================================================= --}}
                            {{-- المخزن + نوع البيع + الصنف --}}
                            {{-- ================================================= --}}

                            <div class="row">


                                {{-- =============================== --}}
                                {{-- المخزن --}}
                                {{-- =============================== --}}

                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label>
                                            المخزن
                                        </label>


                                        <select name="store_id" class="form-control sales-store">

                                            <option value="" disabled>
                                                -- اختر المخزن --
                                            </option>


                                            @foreach ($stores as $store)

                                                <option value="{{ $store->id }}" >

                                                    {{ $store->name }}

                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>


                                {{-- =============================== --}}
                                {{-- نوع البيع --}}
                                {{-- =============================== --}}

                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label>
                                            نوع المرتجع
                                        </label>


                                        <select name="sales_item_type" class="form-control sales-type">

                                            <option value="">
                                                -- اختر نوع المرتجع --
                                            </option>


                                            <option value="1">
                                                جملة
                                            </option>


                                            <option value="2">
                                                قطاعي
                                            </option>


                                            <option value="3">
                                                تجزئة
                                            </option>

                                        </select>

                                    </div>

                                </div>
                                <div class="col-md-3" id="" style="">

                                    <div class="form-group">

                                        <label>
                                            هل المرتجع
                                        </label>
                                        <select name="is_normal_or_other" id="is_normal_or_other"
                                            class="form-control">

                                            <option value="1">عادي</option>
                                            <option value="2">بونص</option>
                                            <option value="3">دعايه</option>
                                            <option value="4">هالك</option>

                                        </select>
                                    </div>
                                </div>


                                {{-- =============================== --}}
                                {{-- الصنف --}}
                                {{-- =============================== --}}

                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label>
                                            الصنف
                                        </label>


                                        <select name="item_code" class="form-control sales-item">

                                            <option value="">
                                                -- اختر الصنف --
                                            </option>


                                            @foreach ($item_cards as $item)

                                                <option value="{{ $item->item_code }}"
                                                    data-item-type="{{ $item->item_type }}"
                                                    data-main="{{ $item->main_unit_id }}"
                                                    data-main-name="{{ $item->mainUnit->name ?? '' }}"
                                                    data-retail="{{ $item->retail_unit_id }}"
                                                    data-retail-name="{{ $item->retailUnit->name ?? '' }}"
                                                    data-retail-qty="{{ $item->retail_qty }}"
                                                    data-price="{{ $item->price }}"
                                                    data-nos-gomla-price="{{ $item->nos_gomla_price }}"
                                                    data-wholesale-price="{{ $item->wholesale_price }}"
                                                    data-price-retail="{{ $item->price_retail }}"
                                                    data-nos-gomla-price-retail="{{ $item->nos_gomla_price_retail }}"
                                                    data-wholesale-price-retail="{{ $item->wholesale_price_retail }}">

                                                    {{ $item->name }}

                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>
                                {{-- ================================================= --}}
                                {{-- معلومات المخزون --}}
                                {{-- ================================================= --}}

                                <div class="row mt-3">

                                    {{-- الوحدة الأب --}}
                                    <div class="col-md-3">

                                        <div class="form-group">

                                            <label>
                                                الوحدة الأب
                                            </label>

                                            <input type="text" class="form-control sales-parent-unit" readonly
                                                placeholder="الوحده ">

                                        </div>

                                    </div>


                                    {{-- المتوفر من الوحدة الأب --}}
                                    <div class="col-md-3">

                                        <div class="form-group">

                                            <label>
                                                المتوفر من الوحدة الأب
                                            </label>

                                            <input type="text" class="form-control sales-parent-quantity" readonly
                                                placeholder="العدد">

                                        </div>

                                    </div>


                                    {{-- وحدة التجزئة --}}
                                    <div class="col-md-3">

                                        <div class="form-group">

                                            <label>
                                                وحدة التجزئة
                                            </label>

                                            <input type="text" class="form-control sales-retail-unit" readonly
                                                placeholder="الوحده">

                                        </div>

                                    </div>


                                    {{-- المتوفر من التجزئة --}}
                                    <div class="col-md-3">

                                        <div class="form-group">

                                            <label>
                                                المتوفر من وحدة التجزئة
                                            </label>

                                            <input type="text" class="form-control sales-retail-quantity" readonly
                                                placeholder="العدد">

                                        </div>

                                    </div>

                                </div>


                                {{-- ========================================================= --}}
                                {{-- وحدة البيع --}}
                                {{-- ========================================================= --}}

                                <div class="row mt-3">

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                وحدة المرتجع
                                            </label>

                                            <select name="sales_uom_id" class="form-control sales-uom" disabled>

                                                <option value="">
                                                    -- اختر وحدة المرتجع --
                                                </option>

                                            </select>

                                        </div>

                                    </div>


                                    {{-- الكمية المتوفرة حسب الوحدة --}}
                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                الكمية المتوفرة حسب الوحدة
                                            </label>

                                            <input type="text" class="form-control sales-available-quantity" readonly
                                                placeholder="الكمية المتوفرة ">

                                        </div>

                                    </div>


                                    {{-- الكمية المطلوبة --}}
                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                الكمية المرتجعه
                                            </label>

                                            <input type="number" name="quantity"
                                                class="form-control sales-required-quantity" min="1" step="1"
                                                placeholder="أدخل الكمية">

                                            <small class="text-danger sales-quantity-error"></small>

                                        </div>

                                    </div>
                                    {{-- ========================================================= --}}
                                    {{-- سعر الوحدة --}}
                                    {{-- ========================================================= --}}

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                سعر المرتجع
                                                <span class="sales-selected-unit" style="color: green">
                                                    ()
                                                </span>
                                            </label>

                                            <input type="text" name="unit_price" class="form-control sales-unit-price"
                                                readonly placeholder=" السعر ">

                                        </div>

                                    </div>
                                    {{-- ========================================================= --}}
                                    {{-- الإجمالي --}}
                                    {{-- ========================================================= --}}

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                الإجمالي
                                            </label>

                                            <input type="text" name="total_price"
                                                class="form-control sales-total-price" readonly placeholder=" الإجمالي ">

                                        </div>

                                    </div>


                                </div>


                            </div>

                        </div>

                        <div class="text-center mt-3">

                            <button type="submit" class="btn btn-success">

                                <i class="fas fa-plus"></i>

                                إضافة الصنف إلى الفاتورة المرتجع

                            </button>

                        </div>

                    </form>

                    {{-- الأصناف التي في الفاتورة --}}
                    <div class="card mt-4">

                        <div class="card-header bg-primary text-white">
                            <strong> أصناف الفاتورة المرتجع</strong>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive">

                                <table class="table table-bordered table-hover text-center">

                                    <thead class="thead-light">

                                        <tr>
                                            <th>المخزن</th>
                                            <th>نوع المرتجع</th>
                                            <th>الصنف</th>
                                            <th>وحدة المرتجع</th>
                                            <th>سعر الوحدة</th>
                                            <th>الكمية</th>
                                            <th>الإجمالي</th>
                                            <th>إجراء</th>
                                        </tr>

                                    </thead>

                                    <tbody>

                                        @forelse ($data->details as $item)

                                            <tr>

                                                {{-- المخزن --}}
                                                <td>
                                                    {{ $item->store->name ?? $item->store_id }}
                                                </td>

                                                {{-- نوع البيع --}}
                                                <td>
                                                    @if ($item->sales_item_type == 1)
                                                        جملة
                                                    @elseif ($item->sales_item_type == 2)
                                                        قطاعي
                                                    @elseif ($item->sales_item_type == 3)
                                                        تجزئة
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                {{-- الصنف --}}
                                                <td>
                                                    {{ $item->itemcode->name ?? $item->item_code }}
                                                </td>

                                                {{-- وحدة البيع --}}
                                                <td>
                                                    {{ $item->unit->name ?? $item->unit_id }}
                                                </td>

                                                {{-- سعر الوحدة --}}
                                                <td>
                                                    {{ number_format($item->unit_price, 2) }}
                                                </td>

                                                {{-- الكمية --}}
                                                <td>
                                                    {{ $item->quantity }}
                                                </td>

                                                {{-- الإجمالي --}}
                                                <td class="sales-item-total">
                                                    {{ number_format($item->total_price, 2) }}
                                                </td>

                                                {{-- إجراء --}}
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm delete-invoice-item"
                                                        data-id="{{ $item->id }}">
                                                        <i class="fas fa-trash"></i>
                                                        حذف
                                                    </button>
                                                </td>

                                            </tr>

                                        @empty

                                            <tr class="sales-empty-items-row">
                                                <td colspan="8" class="text-center text-muted">
                                                    لا توجد أصناف في هذه الفاتورة
                                                </td>
                                            </tr>

                                        @endforelse

                                    </tbody>

                                    <tfoot>

                                        <tr>

                                            <th colspan="6" class="text-left">
                                                إجمالي الفاتورة
                                            </th>

                                            <th class="sales-invoice-total">
                                                {{ number_format($data->details->sum('total_price'), 2) }}
                                            </th>

                                            <th></th>

                                        </tr>

                                    </tfoot>

                                </table>


                            </div>

                        </div>

                    </div>

                    {{-- ================================================= --}}
                    {{-- اعتماد فاتورة المبيعات --}}
                    {{-- ================================================= --}}
                   <form action="{{ route('sales_invoice_return.approve', $data->auto_serial) }}" method="POST"
    class="sales-invoice-save-form">

    @csrf
    @method('PUT')

                        <div class="card mt-3">

                            <div class="card-header bg-primary text-white">
                                <strong>حفظ الفاتورة</strong>
                            </div>

                            <div class="card-body">

                                <div class="row">

                                    {{-- إجمالي الأصناف --}}
                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                إجمالي الأصناف
                                            </label>

                                            <input type="number" name="total_items_price"
                                                class="form-control sales-total-items-price"
                                                value="{{ $data->details->sum('total_price') }}" readonly>

                                        </div>

                                    </div>


                                    {{-- نسبة ضريبة القيمة المضافة --}}
                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                نسبة ضريبة القيمة المضافة
                                            </label>

                                            <div class="input-group">

                                                <input type="number" name="tax_percentage"
                                                    class="form-control sales-tax-percentage"
                                                    value="{{ $data->tax_percentage  }}" min="0" step="0.01">

                                                <div class="input-group-append">

                                                    <span class="input-group-text">
                                                        %
                                                    </span>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                    {{-- قيمة ضريبة القيمة المضافة --}}
                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                قيمة ضريبة القيمة المضافة
                                            </label>

                                            <input type="number" name="tax_value" class="form-control sales-tax-value"
                                                value="{{ $data->tax_value ?? 0 }}" readonly>

                                        </div>

                                    </div>
                                    {{-- الإجمالي مع الضريبة --}}
                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                الإجمالي مع نسبة الضريبة
                                            </label>

                                            <input type="number" name="total_with_tax"
                                                class="form-control sales-total-with-tax"
                                                value="{{ $data->total_with_tax ?? 0 }}" readonly>

                                        </div>

                                    </div>
                                    {{-- نوع الخصم --}}
                                    <div class="col-md-4">
    <div class="form-group">
        <label>نوع الخصم</label>
        <select name="discount_type" class="form-control sales-discount-type">
            <option value="0" {{ ($data->discount_type ?? 0) == 0 ? 'selected' : '' }} >
                لا يوجد خصم
            </option>
            <option value="1" {{ ($data->discount_type ?? 0) == 1 ? 'selected' : '' }}>
                نسبة مئوية
            </option>
            <option value="2" {{ ($data->discount_type ?? 0) == 2 ? 'selected' : '' }}>
                قيمة ثابتة
            </option>
        </select>
    </div>
</div>
                                    {{-- نسبة / قيمة الخصم --}}
                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label class="sales-discount-input-label">
                                                نسبة الخصم
                                            </label>

                                            <input type="number" name="discount_input"
                                                class="form-control sales-discount-input"
                                                value="{{ $data->discount_input ?? 0 }}" min="0" step="0.01">

                                        </div>

                                    </div>
                                    {{-- قيمة الخصم --}}
                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                قيمة الخصم
                                            </label>

                                            <input type="number" name="discount_value"
                                                class="form-control sales-discount-value"
                                                value="{{ $data->discount_value ?? 0 }}" readonly>

                                        </div>

                                    </div>
                                    {{-- الإجمالي النهائي بعد الخصم --}}
                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                الإجمالي النهائي بعد الخصم
                                            </label>

                                            <input type="number" id="final_total" name="final_total"
                                                class="form-control sales-final-total"
                                                value="{{ $data->final_total ?? 0 }}" readonly>

                                        </div>

                                    </div>
                                    {{-- خزنة القبض --}}
                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                خزنة القبض
                                            </label>

                                            <select name="treasury_id" id="treasury_id" class="form-control sales-treasury">

                                                @if ($currentShift && $currentShift->treasuriesname)

                                                    <option value="{{ $currentShift->treasuries_id }}">
                                                        {{ $currentShift->treasuriesname->name }}
                                                    </option>

                                                @endif

                                            </select>

                                        </div>

                                    </div>
                                    {{-- الرصيد المتاح في الخزنة --}}
                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                الرصيد المتاح في الخزنة
                                            </label>

                                            <input type="text" class="form-control sales-treasury-balance"
                                                value="{{ number_format($treasuryBalance, 2) }}"
                                                data-balance="{{ $treasuryBalance }}" readonly>

                                        </div>

                                    </div>
                                    {{-- نوع الفاتورة --}}
                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                نوع الفاتورة
                                            </label>

                                            <select name="invoice_type"  class="form-control sales-invoice-type">

                                                <option value="1"
                                                    {{ ($data->invoice_type ?? '') == 'cash' ? 'selected' : '' }}>
                                                    كاش
                                                </option>

                                                <option value="2"
                                                    {{ ($data->invoice_type ?? '') == 'credit' ? 'selected' : '' }}>
                                                    آجل
                                                </option>

                                            </select>

                                        </div>

                                    </div>
                                    {{-- المبلغ المحصل --}}
                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                المبلغ المحصل
                                            </label>

                                            <input type="number" name="paid_amount"
                                                class="form-control sales-paid-amount" min="0" step="0.01"
                                                value="{{ $data->paid_amount ?? 0 }}">

                                        </div>

                                    </div>



                                    {{-- المتبقي على العميل --}}
                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                المتبقي على العميل
                                            </label>

                                            <input type="number" name="remaining_amount"
                                                class="form-control sales-remaining-amount"
                                                value="{{ $data->remaining_amount ?? 0 }}" readonly>

                                        </div>

                                    </div>
                                    {{-- ملاحظة الفاتورة --}}
                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>
                                                ملاحظة الفاتورة (اختياري)
                                            </label>

                                            <textarea name="notes" class="form-control sales-notes" rows="3"
                                                placeholder="اكتب ملاحظة الفاتورة هنا...">{{ $data->notes ?? '' }}</textarea>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="text-center mt-3 mb-3">

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                               اعتماد وترحيل الفاتوره
                            </button>

                        </div>

                    </form>

                @endif

            </div>

        </div>

    </div>

</div>
<script>// ============================================================
// جافاسكريبت مودال "تعديل الفاتورة"
// ============================================================

// ============================================================
// عند اختيار الصنف: تحديث وحدات البيع + بيانات المخزون
// ============================================================

document.addEventListener("change", function (e) {
    if (!e.target.matches(".sales-item")) return;

    const modal = e.target.closest(".modal");
    if (!modal) return;

    const itemSelect = e.target;
    const option = itemSelect.options[itemSelect.selectedIndex];

    const uomSelect = modal.querySelector(".sales-uom");
    const parentUnitInput = modal.querySelector(".sales-parent-unit");
    const parentQtyInput = modal.querySelector(".sales-parent-quantity");
    const retailUnitInput = modal.querySelector(".sales-retail-unit");
    const retailQtyInput = modal.querySelector(".sales-retail-quantity");

    const main = option.dataset.main;
    const mainName = option.dataset.mainName;
    const retail = option.dataset.retail;
    const retailName = option.dataset.retailName;

    // لم يتم اختيار صنف
    if (!itemSelect.value || !main) {
        if (uomSelect) {
            uomSelect.innerHTML = `<option value="">-- اختر وحدة البيع --</option>`;
            uomSelect.disabled = true;
        }
        if (parentUnitInput) parentUnitInput.value = "";
        if (parentQtyInput) parentQtyInput.value = "";
        if (retailUnitInput) retailUnitInput.value = "";
        if (retailQtyInput) retailQtyInput.value = "";

        clearUnitPriceInModal(modal);
        return;
    }

    // عرض أسماء الوحدات
    if (parentUnitInput) parentUnitInput.value = mainName || "";
    if (retailUnitInput) retailUnitInput.value = retailName || "";

    // تعبئة select وحدة البيع
    if (uomSelect) {
        uomSelect.innerHTML = `<option value="">-- اختر وحدة البيع --</option>`;
        uomSelect.disabled = false;

        if (main && mainName) {
            uomSelect.innerHTML += `<option value="${main}">${mainName} (وحدة الأب)</option>`;
        }

        if (retail && retailName) {
            uomSelect.innerHTML += `<option value="${retail}">${retailName} (وحدة التجزئة)</option>`;
        }
    }

    // تحديث كمية المخزون المتوفرة
    updateAvailableQuantityInModal(modal);

    clearUnitPriceInModal(modal);
});


// ============================================================
// تحديث الكمية المتوفرة في المخزن (المخزن + الصنف)
// ============================================================

function updateAvailableQuantityInModal(modal) {
    const storeSelect = modal.querySelector(".sales-store");
    const itemSelect = modal.querySelector(".sales-item");
    const parentQtyInput = modal.querySelector(".sales-parent-quantity");
    const retailQtyInput = modal.querySelector(".sales-retail-quantity");
    const availableQtyInput = modal.querySelector(".sales-available-quantity");

    const invItemBatches = window.invItemBatches || [];

    if (!storeSelect || !itemSelect || !storeSelect.value || !itemSelect.value) {
        if (parentQtyInput) parentQtyInput.value = "";
        if (retailQtyInput) retailQtyInput.value = "";
        if (availableQtyInput) {
            availableQtyInput.value = "";
            availableQtyInput.dataset.retailQuantity = "0";
        }
        return;
    }

    const option = itemSelect.options[itemSelect.selectedIndex];
    const retailQty = Number(option.dataset.retailQty) || 1;

    const batches = invItemBatches.filter(function (batch) {
        return (
            String(batch.store_id) === String(storeSelect.value) &&
            String(batch.item_code) === String(itemSelect.value) &&
            Number(batch.quantity) > 0
        );
    });

    const totalRetailQuantity = batches.reduce(function (total, batch) {
        return total + Number(batch.quantity);
    }, 0);

    const mainQuantity = Math.floor(totalRetailQuantity / retailQty);
    const remainingRetail = totalRetailQuantity % retailQty;

    if (parentQtyInput) parentQtyInput.value = mainQuantity;
    if (retailQtyInput) retailQtyInput.value = remainingRetail;

    if (availableQtyInput) {
        availableQtyInput.dataset.retailQuantity = totalRetailQuantity;
        availableQtyInput.value = totalRetailQuantity;
    }
}

document.addEventListener("change", function (e) {
    if (!e.target.matches(".sales-store")) return;

    const modal = e.target.closest(".modal");
    if (!modal) return;

    updateAvailableQuantityInModal(modal);
});


// ============================================================
// تحديد سعر الوحدة
// ============================================================

document.addEventListener("change", function (e) {
    if (!e.target.matches(".sales-type, .sales-uom")) return;

    const modal = e.target.closest(".modal");
    if (!modal) return;

    updateUnitPriceInModal(modal);
});

function updateUnitPriceInModal(modal) {
    const itemSelect = modal.querySelector(".sales-item");
    const uomSelect = modal.querySelector(".sales-uom");
    const salesType = modal.querySelector(".sales-type");
    const unitPriceInput = modal.querySelector(".sales-unit-price");
    const selectedUnitLabel = modal.querySelector(".sales-selected-unit");

    if (!itemSelect || !uomSelect || !salesType || !unitPriceInput) return;

    if (!itemSelect.value || !uomSelect.value || !salesType.value) {
        clearUnitPriceInModal(modal);
        return;
    }

    const option = itemSelect.options[itemSelect.selectedIndex];

    // أسعار وحدة الأب
    const price = Number(option.dataset.price) || 0;
    const nosGomlaPrice = Number(option.dataset.nosGomlaPrice) || 0;
    const wholesalePrice = Number(option.dataset.wholesalePrice) || 0;

    // أسعار وحدة التجزئة
    const priceRetail = Number(option.dataset.priceRetail) || 0;
    const nosGomlaPriceRetail = Number(option.dataset.nosGomlaPriceRetail) || 0;
    const wholesalePriceRetail = Number(option.dataset.wholesalePriceRetail) || 0;

    let newPrice = "";

    // وحدة الأب
    if (uomSelect.value == option.dataset.main) {
        if (salesType.value == "1") newPrice = price;
        else if (salesType.value == "2") newPrice = nosGomlaPrice;
        else if (salesType.value == "3") newPrice = wholesalePrice;
    }
    // وحدة التجزئة
    else if (uomSelect.value == option.dataset.retail) {
        if (salesType.value == "1") newPrice = priceRetail;
        else if (salesType.value == "2") newPrice = nosGomlaPriceRetail;
        else if (salesType.value == "3") newPrice = wholesalePriceRetail;
    }

    unitPriceInput.value = Number(newPrice).toFixed(2);

    if (selectedUnitLabel) {
        let unitName = uomSelect.options[uomSelect.selectedIndex].text
            .replace("(وحدة الأب)", "")
            .replace("(وحدة التجزئة)", "")
            .trim();

        selectedUnitLabel.innerText = "(" + unitName + ")";
    }

    calculateTotalInModal(modal);
}

function clearUnitPriceInModal(modal) {
    const unitPriceInput = modal.querySelector(".sales-unit-price");
    const selectedUnitLabel = modal.querySelector(".sales-selected-unit");

    if (unitPriceInput) unitPriceInput.value = "";
    if (selectedUnitLabel) selectedUnitLabel.innerText = "()";

    calculateTotalInModal(modal);
}


// ============================================================
// حساب الإجمالي = الكمية × سعر الوحدة
// ============================================================

function calculateTotalInModal(modal) {
    const quantityInput = modal.querySelector(".sales-required-quantity");
    const unitPriceInput = modal.querySelector(".sales-unit-price");
    const totalPriceInput = modal.querySelector(".sales-total-price");

    if (!quantityInput || !unitPriceInput || !totalPriceInput) return;

    const quantity = parseFloat(quantityInput.value) || 0;
    const price = parseFloat(unitPriceInput.value) || 0;

    totalPriceInput.value = (quantity * price).toFixed(2);
}

document.addEventListener("input", function (e) {
    if (!e.target.matches(".sales-required-quantity")) return;

    const modal = e.target.closest(".modal");
    if (!modal) return;

    calculateTotalInModal(modal);
});


// ============================================================
// حساب قيمة الضريبة + الإجمالي مع الضريبة
// ============================================================

function calculateTaxInModal(modal) {
    const totalItemsInput = modal.querySelector(".sales-total-items-price");
    const taxPercentageInput = modal.querySelector(".sales-tax-percentage");
    const taxValueInput = modal.querySelector(".sales-tax-value");
    const totalWithTaxInput = modal.querySelector(".sales-total-with-tax");

    if (!totalItemsInput || !taxPercentageInput || !taxValueInput || !totalWithTaxInput) {
        return;
    }

    const totalItems = Number(totalItemsInput.value) || 0;
    const taxPercentage = Number(taxPercentageInput.value) || 0;
    const taxValue = (totalItems * taxPercentage) / 100;
    const totalWithTax = totalItems + taxValue;

    taxValueInput.value = taxValue.toFixed(2);
    totalWithTaxInput.value = totalWithTax.toFixed(2);

    calculateDiscountInModal(modal);
}

document.addEventListener("input", function (e) {
    if (!e.target.matches(".sales-tax-percentage")) return;

    const modal = e.target.closest(".modal");
    if (!modal) return;

    calculateTaxInModal(modal);
});


// ============================================================
// حساب الخصم + الإجمالي النهائي (محدثة لدعم الأرقام والنصوص)
// ============================================================

function calculateDiscountInModal(modal) {
    const totalWithTaxInput = modal.querySelector(".sales-total-with-tax");
    const discountTypeSelect = modal.querySelector(".sales-discount-type");
    const discountInputEl = modal.querySelector(".sales-discount-input");
    const discountValueInput = modal.querySelector(".sales-discount-value");
    const finalTotalInput = modal.querySelector(".sales-final-total");

    if (!totalWithTaxInput || !discountTypeSelect || !discountInputEl || !discountValueInput || !finalTotalInput) {
        return;
    }

    const totalWithTax = Number(totalWithTaxInput.value) || 0;
    const discountType = String(discountTypeSelect.value);
    const discountInput = Number(discountInputEl.value) || 0;

    let discountValue = 0;

  if (discountType === "1" || discountType === "percentage") {

    const taxPercentage = Number(
        modal.querySelector(".sales-tax-percentage").value
    ) || 0;

    if (discountInput >= taxPercentage) {
        alert("نسبة الخصم يجب أن تكون أقل من نسبة الضريبة.");
        discountInputEl.value = 0;
        discountValueInput.value = "0.00";
        finalTotalInput.value = totalWithTax.toFixed(2);
        calculateRemainingAmountInModal(modal, true);
        return;
    }

    discountValue = (totalWithTax * discountInput) / 100;
}

    else if (discountType === "2" || discountType === "fixed") {
        discountValue = discountInput;
    }

    if (discountValue > totalWithTax) {
        discountValue = totalWithTax;
    }

    discountValueInput.value = discountValue.toFixed(2);

    const finalTotal = totalWithTax - discountValue;
    finalTotalInput.value = finalTotal.toFixed(2);

    calculateRemainingAmountInModal(modal, true);
}
// عند تغيير نوع الخصم
document.addEventListener("change", function (e) {
    if (!e.target.matches(".sales-discount-type")) return;

    const modal = e.target.closest(".modal");
    if (!modal) return;

    const label = modal.querySelector(".sales-discount-input-label");
    if (label) {
        const isPercentage = e.target.value === "1" || e.target.value === "percentage";
        label.innerText = isPercentage ? "نسبة الخصم (%)" : "قيمة الخصم";
    }

    calculateDiscountInModal(modal);
});

// عند تغيير قيمة الخصم
document.addEventListener("input", function (e) {
    if (!e.target.matches(".sales-discount-input")) return;

    const modal = e.target.closest(".modal");
    if (!modal) return;

    calculateDiscountInModal(modal);
});


// ============================================================
// التحقق من نوع الفاتورة + حساب المتبقي (محدثة لدعم القيم الرقمية)
// ============================================================

function calculateRemainingAmountInModal(modal, silent) {
    const finalTotalInput = modal.querySelector(".sales-final-total");
    const paidInput = modal.querySelector(".sales-paid-amount");
    const remainingInput = modal.querySelector(".sales-remaining-amount");
    const invoiceTypeSelect = modal.querySelector(".sales-invoice-type");

    if (!finalTotalInput || !paidInput || !remainingInput || !invoiceTypeSelect) {
        return;
    }

    const finalTotal = Number(finalTotalInput.value) || 0;
    const invoiceType = String(invoiceTypeSelect.value);

    let paidAmount = Number(paidInput.value) || 0;

    // فاتورة كاش: 1 أو "cash"
    if (invoiceType === "1" || invoiceType === "cash") {
        paidInput.value = finalTotal.toFixed(2);
        remainingInput.value = "0.00";
        return;
    }

    // فاتورة آجل: 2 أو "credit"
    if (invoiceType === "2" || invoiceType === "credit") {
        if (paidAmount > finalTotal) {
            paidAmount = finalTotal;
            paidInput.value = finalTotal.toFixed(2);

            if (!silent) {
                alert("المبلغ المحصل لا يمكن أن يكون أكبر من إجمالي الفاتورة.");
            }
        }

        if (paidAmount >= finalTotal && finalTotal > 0) {
            paidAmount = finalTotal - 0.01;
            paidInput.value = paidAmount.toFixed(2);

            if (!silent) {
                alert("الفاتورة الآجلة يجب أن يتبقى منها مبلغ على العميل.");
            }
        }

        remainingInput.value = (finalTotal - paidAmount).toFixed(2);
    }
}

// عند تغيير نوع الفاتورة (كاش / آجل)
document.addEventListener("change", function (e) {
    if (!e.target.matches(".sales-invoice-type")) return;

    const modal = e.target.closest(".modal");
    if (!modal) return;

    calculateRemainingAmountInModal(modal, true);
});

// عند تغيير المبلغ المحصل
document.addEventListener("input", function (e) {
    if (!e.target.matches(".sales-paid-amount")) return;

    const modal = e.target.closest(".modal");
    if (!modal) return;

    calculateRemainingAmountInModal(modal, false);
});


// ============================================================
// إعادة حساب إجمالي الأصناف عند الحذف
// ============================================================

function updateTotalItemsPriceInModal(modal) {
    const totalItemsInput = modal.querySelector(".sales-total-items-price");
    const invoiceTotalCell = modal.querySelector(".sales-invoice-total");

    if (!totalItemsInput) return;

    let total = 0;

    modal.querySelectorAll(".sales-item-total").forEach(function (cell) {
        total += Number(cell.innerText) || 0;
    });

    totalItemsInput.value = total.toFixed(2);

    if (invoiceTotalCell) {
        invoiceTotalCell.innerText = total.toFixed(2);
    }

    calculateTaxInModal(modal);
}

// عند حذف صنف

// ============================================================
// تهيئة أولية عند فتح المودال
// ============================================================

document.addEventListener("shown.bs.modal", function (e) {
    const modal = e.target;
    if (!modal.classList.contains("modal")) return;

    calculateTaxInModal(modal);
});</script>

<script>
if (!window.salesInvoiceDeleteListenerAttached) {

    window.salesInvoiceDeleteListenerAttached = true;

    document.addEventListener("click", function (e) {

        const deleteButton = e.target.closest(".delete-invoice-item");

        if (!deleteButton) return;

        const modal = deleteButton.closest(".modal");
        const row = deleteButton.closest("tr");

        if (!modal || !row) return;

        const itemId = deleteButton.dataset.id;

        if (!itemId) {
            alert("رقم الصنف غير موجود");
            return;
        }

        if (!confirm("هل أنت متأكد من حذف هذا الصنف من الفاتورة؟")) {
            return;
        }

        deleteButton.disabled = true;


fetch("{{ route('sales_invoice_return.deleteItem', ':id') }}".replace(':id', itemId), {

            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "Content-Type": "application/json"
            }
        })

        .then(async response => {

            const data = await response.json();

            if (!response.ok) {
                throw new Error(
                    data.message || "حدث خطأ أثناء الحذف"
                );
            }

            return data;
        })

        .then(data => {

            if (!data.status) {
                throw new Error(
                    data.message || "لم يتم حذف الصنف"
                );
            }

            row.remove();

            const tbody = modal.querySelector("tbody");

            const remainingRows =
                tbody.querySelectorAll("tr:not(.sales-empty-items-row)");

            if (remainingRows.length === 0) {

                tbody.innerHTML = `
                    <tr class="sales-empty-items-row">
                        <td colspan="8" class="text-center text-muted">
                            لا توجد أصناف في هذه الفاتورة
                        </td>
                    </tr>
                `;
            }

            updateTotalItemsPriceInModal(modal);

        })

        .catch(error => {

            console.error("خطأ حذف الصنف:", error);

            alert(error.message || "حدث خطأ أثناء حذف الصنف");

        })

        .finally(() => {
            deleteButton.disabled = false;
        });

    });

}
</script>



{{-- =============================================================== --}}
{{-- JavaScript --}}
{{-- =============================================================== --}}

<script>

    document.addEventListener('change', function (event) {

        // =====================================================
        // المخزن أو الصنف
        // =====================================================

        if (
            event.target.classList.contains('sales-store') ||
            event.target.classList.contains('sales-item')
        ) {

            const card = event.target.closest('.card');

            if (!card) return;

            const storeSelect =
                card.querySelector('.sales-store');

            const itemSelect =
                card.querySelector('.sales-item');

            const salesUom =
                card.querySelector('.sales-uom');

            const parentUnit =
                card.querySelector('.sales-parent-unit');

            const parentQuantity =
                card.querySelector('.sales-parent-quantity');

            const retailUnit =
                card.querySelector('.sales-retail-unit');

            const retailQuantity =
                card.querySelector('.sales-retail-quantity');

            const availableQuantity =
                card.querySelector('.sales-available-quantity');

            const requiredQuantity =
                card.querySelector('.sales-required-quantity');

            const error =
                card.querySelector('.sales-quantity-error');

            const unitPrice =
                card.querySelector('.sales-unit-price');

            const totalInput =
                card.querySelector('.sales-total-price');

            const selectedUnit =
                card.querySelector('.sales-selected-unit');


            if (
                !storeSelect ||
                !itemSelect ||
                !salesUom ||
                !parentUnit ||
                !parentQuantity ||
                !retailUnit ||
                !retailQuantity ||
                !availableQuantity ||
                !requiredQuantity
            ) {
                return;
            }


            // =================================================
            // تنظيف البيانات
            // =================================================

            parentUnit.value = '';
            parentQuantity.value = '';

            retailUnit.value = '';
            retailQuantity.value = '';

            availableQuantity.value = '';

            requiredQuantity.value = '';
            requiredQuantity.disabled = true;

            if (error) {
                error.textContent = '';
            }

            if (unitPrice) {
                unitPrice.value = '';
            }

            if (totalInput) {
                totalInput.value = '';
            }

            if (selectedUnit) {
                selectedUnit.textContent = '()';
            }

            salesUom.innerHTML = `
            <option value="">
                -- اختر وحدة البيع --
            </option>
        `;

            salesUom.disabled = true;


            // =================================================
            // لازم اختيار المخزن والصنف
            // =================================================

            if (
                !storeSelect.value ||
                !itemSelect.value
            ) {
                return;
            }


            // =================================================
            // بيانات Laravel
            // =================================================

            const items =
                @json($item_cards);

            const batches =
                @json($inv_item_batches);

            const units =
                @json($units);


            // =================================================
            // الصنف
            // =================================================

            const item =
                items.find(function (row) {

                    return String(row.item_code)
                        === String(itemSelect.value);

                });


            if (!item) {
                return;
            }


            // =================================================
            // دفعات الصنف
            // =================================================

            const itemBatches =
                batches.filter(function (batch) {

                    return String(batch.store_id)
                        === String(storeSelect.value)

                        &&

                        String(batch.item_code)
                        === String(item.item_code);

                });


            // =================================================
            // إذا لا يوجد مخزون
            // =================================================

            if (itemBatches.length === 0) {

                parentQuantity.value = 0;
                retailQuantity.value = 0;

                return;
            }


            // =================================================
            // إجمالي كمية التجزئة
            // =================================================

            let totalRetailQuantity = 0;

            itemBatches.forEach(function (batch) {

                totalRetailQuantity +=
                    Number(batch.quantity) || 0;

            });


            // =================================================
            // وحدة التجزئة
            // =================================================

            if (item.retail_uom) {

                const retail =
                    units[item.retail_uom];

                if (retail) {

                    retailUnit.value =
                        retail.name;

                }

            }


            // =================================================
            // كمية التجزئة المتوفرة
            // =================================================

            retailQuantity.value =
                totalRetailQuantity;


            // =================================================
            // الوحدة الأب
            // =================================================

            if (item.uom_id) {

                const parent =
                    units[item.uom_id];

                if (parent) {

                    parentUnit.value =
                        parent.name;

                }

            }


            // =================================================
            // عدد التجزئة داخل الأب
            // =================================================

            const quantityToParent =
                Number(
                    item.retail_uom_quantity_to_parent
                ) || 0;


            // =================================================
            // كمية الوحدة الأب
            // =================================================

            let parentQty = 0;

            if (quantityToParent > 0) {

                parentQty =
                    Math.floor(
                        totalRetailQuantity /
                        quantityToParent
                    );

            }


            parentQuantity.value =
                parentQty;


            // =================================================
            // إضافة الوحدة الأب
            // =================================================

            if (item.uom_id) {

                const parent =
                    units[item.uom_id];

                if (parent) {

                    const option =
                        document.createElement('option');

                    option.value =
                        item.uom_id;

                    option.textContent =
                        parent.name;

                    salesUom.appendChild(option);

                }

            }


            // =================================================
            // إضافة وحدة التجزئة
            // =================================================

            if (item.retail_uom) {

                const retail =
                    units[item.retail_uom];

                if (retail) {

                    const option =
                        document.createElement('option');

                    option.value =
                        item.retail_uom;

                    option.textContent =
                        retail.name;

                    salesUom.appendChild(option);

                }

            }


            // =================================================
            // تفعيل وحدة البيع
            // =================================================

            if (salesUom.options.length > 1) {

                salesUom.disabled = false;

            }

        }


        // =====================================================
        // نوع البيع أو وحدة البيع
        // =====================================================

        if (
            event.target.classList.contains('sales-type') ||
            event.target.classList.contains('sales-uom')
        ) {

            calculateSalesPrice(
                event.target.closest('.card')
            );

        }

    });


    // =========================================================
    // دالة حساب السعر
    // =========================================================

    function calculateSalesPrice(card) {

        if (!card) return;


        const itemSelect =
            card.querySelector('.sales-item');

        const salesType =
            card.querySelector('.sales-type');

        const salesUom =
            card.querySelector('.sales-uom');

        const unitPrice =
            card.querySelector('.sales-unit-price');

        const selectedUnit =
            card.querySelector('.sales-selected-unit');


        if (
            !itemSelect ||
            !salesType ||
            !salesUom ||
            !unitPrice
        ) {
            return;
        }


        // =====================================================
        // تنظيف السعر
        // =====================================================

        unitPrice.value = '';


        // =====================================================
        // لازم اختيار الثلاثة
        // =====================================================

        if (
            !itemSelect.value ||
            !salesType.value ||
            !salesUom.value
        ) {
            return;
        }


        // =====================================================
        // بيانات الأصناف
        // =====================================================

        const items =
            @json($item_cards);

        const units =
            @json($units);


        // =====================================================
        // الصنف
        // =====================================================

        const item =
            items.find(function (row) {

                return String(row.item_code)
                    === String(itemSelect.value);

            });


        if (!item) {
            return;
        }


        const selectedUom =
            String(salesUom.value);

        const parentUom =
            String(item.uom_id);

        const retailUom =
            String(item.retail_uom);

        const salesTypeValue =
            String(salesType.value);


        let price = 0;


        // =====================================================
        // الوحدة الأب
        // =====================================================

        if (selectedUom === parentUom) {

            // 1 = جملة
            if (salesTypeValue === '1') {

                price =
                    Number(item.wholesale_price) || 0;

            }

            // 2 = قطاعي
            else if (salesTypeValue === '2') {

                price =
                    Number(item.retail_price) || 0;

            }

            // 3 = تجزئة
            else if (salesTypeValue === '3') {

                price =
                    Number(item.retail_price) || 0;

            }

        }


        // =====================================================
        // وحدة التجزئة
        // =====================================================

        else if (selectedUom === retailUom) {

            // 1 = جملة
            if (salesTypeValue === '1') {

                price =
                    Number(item.wholesale_price_retail) || 0;

            }

            // 2 = قطاعي
            else if (salesTypeValue === '2') {

                price =
                    Number(item.retail_price_retail) || 0;

            }

            // 3 = تجزئة
            else if (salesTypeValue === '3') {

                price =
                    Number(item.price) || 0;

            }

        }


        // =====================================================
        // عرض السعر
        // =====================================================

        unitPrice.value =
            price;


        // =====================================================
        // اسم الوحدة
        // =====================================================

        if (selectedUnit) {

            const selectedUnitData =
                units[salesUom.value];

            if (selectedUnitData) {

                selectedUnit.textContent =
                    '(' + selectedUnitData.name + ')';

            }

        }


        // =====================================================
        // تفعيل الكمية المطلوبة
        // =====================================================

        const requiredQuantity =
            card.querySelector(
                '.sales-required-quantity'
            );

        if (requiredQuantity) {

            requiredQuantity.disabled = false;

        }


        // =====================================================
        // إعادة حساب الإجمالي
        // =====================================================

        calculateSalesTotal(card);

    }


    // =========================================================
    // حساب الإجمالي
    // =========================================================

    function calculateSalesTotal(card) {

        if (!card) return;


        const quantityInput =
            card.querySelector(
                '.sales-required-quantity'
            );

        const priceInput =
            card.querySelector(
                '.sales-unit-price'
            );

        const totalInput =
            card.querySelector(
                '.sales-total-price'
            );


        if (
            !quantityInput ||
            !priceInput ||
            !totalInput
        ) {
            return;
        }


        const quantity =
            Number(quantityInput.value) || 0;

        const price =
            Number(priceInput.value) || 0;


        totalInput.value =
            quantity * price;

    }


    // =========================================================
    // عند إدخال الكمية
    // =========================================================

    document.addEventListener('input', function (event) {

        if (
            !event.target.classList.contains(
                'sales-required-quantity'
            )
        ) {
            return;
        }


        const card =
            event.target.closest('.card');

        if (!card) return;


        const quantityInput =
            card.querySelector(
                '.sales-required-quantity'
            );

        const availableInput =
            card.querySelector(
                '.sales-available-quantity'
            );

        const error =
            card.querySelector(
                '.sales-quantity-error'
            );


        const quantity =
            Number(quantityInput.value) || 0;

        const available =
            Number(availableInput?.value) || 0;


        // =====================================================
        // تنظيف الخطأ
        // =====================================================

        if (error) {

            error.textContent = '';

        }

        quantityInput.classList.remove(
            'is-invalid'
        );


        // =====================================================
        // لا يوجد مخزون
        // =====================================================

        if (
            available <= 0 &&
            quantity > 0
        ) {

            if (error) {

                error.textContent =
                    'لا توجد كمية متوفرة في المخزن.';

            }

            quantityInput.classList.add(
                'is-invalid'
            );

        }


        // =====================================================
        // الكمية أكبر من المتوفر
        // =====================================================

        else if (
            quantity > available
        ) {

            if (error) {

                error.textContent =
                    'الكمية المطلوبة أكبر من الكمية المتوفرة.';

            }

            quantityInput.classList.add(
                'is-invalid'
            );

        }


        // =====================================================
        // حساب الإجمالي
        // =====================================================

        calculateSalesTotal(card);

    });

</script>
<script>

    document.addEventListener('change', function (event) {

        if (!event.target.classList.contains('sales-uom')) {
            return;
        }

        const salesUom = event.target;
        const card = salesUom.closest('.card');

        if (!card) return;

        const itemSelect =
            card.querySelector('.sales-item');

        const storeSelect =
            card.querySelector('.sales-store');

        const availableQuantity =
            card.querySelector('.sales-available-quantity');

        const requiredQuantity =
            card.querySelector('.sales-required-quantity');

        const selectedUnit =
            card.querySelector('.sales-selected-unit');


        if (
            !itemSelect ||
            !storeSelect ||
            !availableQuantity ||
            !requiredQuantity
        ) {
            return;
        }


        // =====================================================
        // بيانات Laravel
        // =====================================================

        const items =
            @json($item_cards);

        const batches =
            @json($inv_item_batches);

        const units =
            @json($units);


        // =====================================================
        // الصنف المختار
        // =====================================================

        const item =
            items.find(function (row) {

                return String(row.item_code)
                    === String(itemSelect.value);

            });


        if (!item) {
            return;
        }


        // =====================================================
        // دفعات الصنف في المخزن
        // =====================================================

        const itemBatches =
            batches.filter(function (batch) {

                return String(batch.store_id)
                    === String(storeSelect.value)

                    &&

                    String(batch.item_code)
                    === String(item.item_code);

            });


        // =====================================================
        // إجمالي المخزون بوحدة التجزئة
        // =====================================================

        let totalRetailQuantity = 0;

        itemBatches.forEach(function (batch) {

            totalRetailQuantity +=
                Number(batch.quantity) || 0;

        });


        // =====================================================
        // عدد وحدات التجزئة داخل الوحدة الأب
        // =====================================================

        const quantityToParent =
            Number(
                item.retail_uom_quantity_to_parent
            ) || 0;


        // =====================================================
        // تحديد الكمية حسب وحدة البيع
        // =====================================================

        if (
            String(salesUom.value)
            === String(item.uom_id)
        ) {

            // -----------------------------------------------
            // الوحدة الأب
            // -----------------------------------------------

            if (quantityToParent > 0) {

                availableQuantity.value =
                    Math.floor(
                        totalRetailQuantity /
                        quantityToParent
                    );

            } else {

                availableQuantity.value = 0;

            }

        }

        else if (
            String(salesUom.value)
            === String(item.retail_uom)
        ) {

            // -----------------------------------------------
            // وحدة التجزئة
            // -----------------------------------------------

            availableQuantity.value =
                totalRetailQuantity;

        }

        else {

            availableQuantity.value = 0;

        }


        // =====================================================
        // إظهار اسم الوحدة
        // =====================================================

        if (selectedUnit) {

            const selectedUnitData =
                units[salesUom.value];

            if (selectedUnitData) {

                selectedUnit.textContent =
                    '(' + selectedUnitData.name + ')';

            }

        }


        // =====================================================
        // تفعيل الكمية المطلوبة
        // =====================================================

        requiredQuantity.disabled = false;

    });

</script>
