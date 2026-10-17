<div class="modal fade" id="addInvoicemirrorModal" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-xl" role="document">

        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">
             (عرض اسعار)
                </h5>

                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>

            </div>


            {{-- Body --}}
            <div class="modal-body">

                {{-- بيانات الفاتورة --}}
                <div class="card mb-3">

                    <div class="card-header bg-light">
                        <strong>بيانات الفاتورة</strong>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- تاريخ الفاتورة --}}
                            <div class="col-md-4">

                                <div class="form-group">

                                    <label>تاريخ الفاتورة</label>

                                    <input type="date" name="invoice_date" class="form-control"
                                        value="{{ date('Y-m-d') }}" readonly>

                                </div>

                            </div>


                            {{-- هل يوجد عميل --}}
                            <div class="col-md-4">

                                {{-- <div class="form-group">

                                    <label>هل يوجد عميل؟</label>

                                    <select name="is_has_customer" id="is_has_customer" class="form-control">

                                        <option value="0">
                                            لا يوجد عميل (طياري)
                                        </option>

                                        <option value="1">
                                            يوجد عميل
                                        </option>

                                    </select>

                                </div> --}}

                            </div>


                            {{-- هل يوجد مندوب --}}
                            {{-- <div class="col-md-4">

                                <div class="form-group">

                                    <label>هل يوجد مندوب؟</label>

                                    <select name="is_has_delegate" id="is_has_delegate" class="form-control">

                                        <option value="0">
                                            لا يوجد مندوب
                                        </option>

                                        <option value="1">
                                            يوجد مندوب
                                        </option>

                                    </select>

                                </div>

                            </div> --}}

                        </div>
                        {{-- بيانات العميل --}}
                        {{-- <div class="card mb-3" id="customerData" style="display: none;">

                            <div class="card-header bg-light d-flex justify-content-between align-items-center">

                                <strong>بيانات العميل</strong>

                                <button type="button" class="btn btn-success btn-sm">

                                    <i class="fas fa-plus"></i>
                                    إضافة عميل جديد

                                </button>

                            </div>

                            <div class="card-body">

                                <div class="form-group mb-0">

                                    <label>العميل</label>

                                    <select name="customer_code" id="customer_code" class="form-control">

                                        <option value="">
                                            اختر العميل
                                        </option>

                                        @foreach ($customers as $customer)

                                            <option value="{{ $customer->id }}">
                                                {{ $customer->name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                            </div>

                        </div> --}}

                    </div>

                </div>





                <div style="width: 100%; height: 10px; background-color: rgb(191, 179, 179);"></div>


                {{-- إضافة الصنف --}}
                <div class="card">

                    <div class="card-header bg-light">

                        <strong>
                            إضافة صنف للفاتورة
                        </strong>

                    </div>

                    <div class="card-body">

                        {{--بيانات المخازن--}}
                        <div class="form-group">

                            <label>
                                بيانات المخازن
                            </label>

                            <select name="store_id" id="store_id" class="form-control">

                                <option value="">
                                    اختر المخزن
                                </option>

                                @foreach ($stores as $store)

                                    <option value="{{ $store->id }}">
                                        {{ $store->name }}
                                        {{-- <p> رقم المخزن : {{ $store->phones }}</p> --}}
                                    </option>


                                @endforeach

                            </select>

                        </div>


                        {{-- نوع البيع --}}
                        <div class="form-group">

                            <label>
                                نوع البيع
                            </label>

                            <select name="sales_item_type" id="sales_item_type" class="form-control">

                                <option value="1">
                                    قطاعي---عميل عادي
                                </option>

                                <option value="2">
                                    نصف جملة---عميل قوي
                                </option>

                                <option value="3">
                                    جملة--عميل قوي جدا
                                </option>

                            </select>

                        </div>


                        {{-- الصنف --}}
                        <div class="form-group">

                            <label>
                                الصنف
                            </label>

                            <select name="item_code" id="item_code" class="form-control">

                                <option value="">
                                    اختر الصنف
                                </option>

                                @foreach ($item_cards as $item)

                                    <option value="{{ $item->item_code }}" data-item-type="{{ $item->item_type }}"
                                        data-main="{{ $item->uom_id }}"
                                        data-main-name="{{ $units[$item->uom_id]->name ?? '' }}"
                                        data-retail="{{ $item->retail_uom }}"
                                        data-retail-name="{{ $units[$item->retail_uom]->name ?? '' }}"
                                        data-retail-qty="{{ $item->retail_uom_quantity_to_parent }}"
                                        data-price="{{ $item->price }}" data-nos-gomla-price="{{ $item->nos_gomla_price }}"
                                        data-wholesale-price="{{ $item->wholesale_price }}"
                                        data-price-retail="{{ $item->retail_price }}"
                                        data-nos-gomla-price-retail="{{ $item->nos_gomla_price_retail }}"
                                        data-wholesale-price-retail="{{ $item->wholesale_price_retail }}">

                                        {{ $item->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- بيانات الباتش للصنف الاستهلاكي --}}
                        <div class="col-md-12" id="consumer_batches_div" style="display: none">

                            <div class="form-group">

                                <label>
                                    تفاصيل الصنف :
                                </label>

                                <div class="table-responsive">

                                    <table class="table table-bordered table-sm text-center">

                                        <thead class="thead-light">

                                            <tr>
                                                <th> رقم الباتش</th>
                                                <th>الكمية الموجودة</th>
                                                <th>تاريخ الإنتاج</th>
                                                <th>تاريخ الانتهاء</th>
                                                <th>الحاله</th>
                                            </tr>

                                        </thead>

                                        <tbody id="consumer_batches">

                                            <tr>
                                                <td colspan="3" class="text-muted">
                                                    اختر المخزن والصنف
                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>


                        {{-- الوحدة والكمية والسعر والإجمالي --}}
                        <div class="row">

                            {{-- الوحدة --}}
                            <div class="col-md-3" id="unit_div" style="display: none;">

                                <div class="form-group">

                                    <label>الوحدة</label>

                                    <select name="unit_id" id="unit_id" class="form-control">

                                        <option value="">
                                            اختر الوحدة
                                        </option>

                                    </select>

                                </div>

                            </div>
                            {{-- الكميه الموجوده بالمخزن المحدد --}}
                            <div class="col-md-3" id="available_quantity_div" style="display: none;">

                                <div class="form-group">

                                    <label>
                                        الكمية الموجودة بالمخزن
                                    </label>

                                    <input type="text" id="available_quantity" class="form-control" readonly>

                                </div>

                            </div>


                            {{-- الكمية --}}
                            <div class="col-md-3" id="quantity_div" style="display: none;">

                                <div class="form-group">

                                    <label>
                                        الكمية
                                    </label>

                                    <input type="number" value="1" name="quantity" id="quantity" class="form-control"
                                        min="1" step="0.01">

                                </div>

                            </div>


                            {{-- سعر الوحدة --}}
                            <div class="col-md-3" id="price_div" style="display: none;">

                                <div class="form-group">

                                    <label id="unit_price_label">
                                        سعر الوحدة
                                    </label>

                                    <input type="number" name="unit_price" id="unit_price" class="form-control"
                                        readonly>

                                </div>

                            </div>


                            {{-- الإجمالي --}}
                            <div class="col-md-3" id="total_div" style="display: none;">

                                <div class="form-group">

                                    <label>
                                        الإجمالي
                                    </label>

                                    <input type="number" name="total_price" id="total_price" class="form-control"
                                        readonly>

                                </div>

                            </div>
                            {{-- دعايه --}}
                            <div class="col-md-3" id="" style="">

                                <div class="form-group">

                                    <label>
                                        هل البيع عادي
                                    </label>
                                    <select name="is_normal_or_other" id="is_normal_or_other" name="is_normal_or_other"
                                        class="form-control">

                                        <option value="1">عادي</option>
                                        <option value="2">بونص</option>
                                        <option value="3">دعايه</option>
                                        <option value="4">هالك</option>

                                    </select>
                                </div>
                                {{-- زر إضافة الصنف --}}
                                <div class="text-left mt-3">

                                    <button type="button" id="addInvoiceItem" class="btn btn-danger btn-block">

                                        <i class="fas fa-plus"></i>
                                        إضافة الفاتورة

                                    </button>

                                </div>

                            </div>

                        </div>
                        <div class="card mt-4">

                            <div class="card-header bg-primary text-white">
                                <strong>أصناف الفاتورة</strong>
                            </div>

                            <div class="card-body">

                                <div class="table-responsive">

                                    <table class="table table-bordered table-hover text-center">

                                        <thead class="thead-light">

                                            <tr>
                                                <th>المخزن</th>
                                                <th>نوع البيع</th>
                                                <th>الصنف</th>
                                                <th>وحدة البيع</th>
                                                <th>سعر الوحدة</th>
                                                <th>الكمية</th>
                                                <th>الإجمالي</th>
                                                <th>إجراء</th>
                                            </tr>

                                        </thead>

                                        <tbody id="invoiceItems">

                                            {{-- الأصناف المضافة ستظهر هنا --}}

                                            <tr id="emptyItems">

                                                <td colspan="8" class="text-muted">
                                                    لم يتم إضافة أي صنف بعد
                                                </td>

                                            </tr>

                                        </tbody>

                                        <tfoot>

                                            <tr>

                                                <th colspan="6" class="text-left">
                                                    إجمالي الفاتورة
                                                </th>

                                                <th id="invoiceTotal">
                                                    0.00
                                                </th>

                                                <th></th>

                                            </tr>

                                        </tfoot>

                                    </table>

                                </div>

                            </div>


                        </div>




                    </div>

                </div>

            </div>
            <div style="width: 100%; height: 10px; background-color: rgb(191, 179, 179);"></div>

            {{-- اعتماد فاتوره المبيعات -------------------------------------}}
            <div class="card mt-3">

                <div class="card-header bg-primary text-white">
                    <strong>حفظ الفاتورة</strong>
                </div>

                <div class="card-body">

                    <div class="row">

                        {{-- إجمالي لااصناف --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    إجمالي الااصناف
                                </label>

                                <input type="number" name="total_items_price" id="total_items_price"
                                    class="form-control" value="0" readonly>

                            </div>

                        </div>


                        {{-- نسبة ضريبة القيمة المضافة --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    نسبة ضريبة القيمة المضافة
                                </label>

                                <div class="input-group">

                                    <input type="number" name="tax_percentage" id="tax_percentage" class="form-control"
                                        value="0" min="0" step="0.01">

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

                                <input type="number" name="tax_value" id="tax_value" class="form-control" value="0"
                                    readonly>

                            </div>

                        </div>
                        {{-- الإجمالي مع الضريبة --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    الإجمالي مع نسبة الضريبة
                                </label>

                                <input type="number" name="total_with_tax" id="total_with_tax" class="form-control"
                                    value="0" readonly>

                            </div>

                        </div>
                        {{-- نوع الخصم --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    نوع الخصم
                                </label>

                                <select name="discount_type" id="discount_type" class="form-control">

                                    <option value="percentage">
                                        نسبة مئوية
                                    </option>

                                    <option value="fixed">
                                        قيمة ثابتة
                                    </option>

                                </select>

                            </div>

                        </div>
                        {{-- نسبة / قيمة الخصم --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label id="discount_input_label">
                                    نسبة الخصم
                                </label>

                                <input type="number" name="discount_input" id="discount_input" class="form-control"
                                    value="0" min="0" step="0.01">

                            </div>

                        </div>
                        {{-- قيمة الخصم --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    قيمة الخصم
                                </label>

                                <input type="number" name="discount_value" id="discount_value" class="form-control"
                                    value="0" readonly>

                            </div>

                        </div>
                        {{-- الإجمالي النهائي بعد الخصم --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    الإجمالي النهائي بعد الخصم
                                </label>

                                <input type="number" name="final_total" id="final_total" class="form-control" value="0"
                                    readonly>

                            </div>

                        </div>
                        {{-- خزنة القبض --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    خزنة القبض
                                </label>

                                <select name="treasury_id" id="treasury_id" class="form-control">
                                    {{--
                                    <option value="">
                                        اختر خزنة القبض
                                    </option> --}}

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

                                <input type="text" id="treasury_balance" class="form-control"
                                    value="{{ number_format($treasuryBalance, 2) }}" readonly>

                            </div>

                        </div>
                        {{-- نوع الفاتورة --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    نوع الفاتورة
                                </label>

                                <select name="invoice_type" id="invoice_type" class="form-control">

                                    <option value="cash">
                                        كاش
                                    </option>

                                    <option value="credit">
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

                                <input type="number" name="paid_amount" id="paid_amount" class="form-control" min="0"
                                    step="0.01" value="0">

                            </div>

                        </div>



                        {{-- المتبقي على العميل --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    المتبقي على العميل
                                </label>

                                <input type="number" name="remaining_amount" id="remaining_amount" class="form-control"
                                    value="0" readonly>

                            </div>

                        </div>
                        {{-- ملاحظة الفاتورة --}}
                        <div class="col-md-12">

                            <div class="form-group">

                                <label for="notes">
                                    ملاحظة الفاتورة (اختياري)
                                </label>

                                <textarea name="notes" id="notes" class="form-control" rows="3"
                                    placeholder="اكتب ملاحظة الفاتورة هنا..."></textarea>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            {{-- Footer --}}
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">

                    إغلاق

                </button>

                <button type="submit" id="saveInvoiceBtn" class="btn btn-success">

                    <i class="fas fa-save"></i>
                    طباعه عرض السعر

                </button>

            </div>

        </div>

    </div>

</div>

<script>
    // وظيفته ببساطة أنه يأخذ بيانات الباتشات من Laravel ويحولها إلى بيانات JavaScript.
    window.invItemBatches = @json($inv_item_batches);
</script>
<script src="{{ asset('assets/admin/dist/js/load_addinvoice.js') }}"></script>
