@if ($data && $data->is_approved == 0)

    {{-- بيانات الفاتورة --}}
    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                اعتماد وترحيل فاتوره المشتريات
            </h5>
        </div>

        <div class="card-body">

            <form id="approve_invoice_form" action="{{ route('SupplierWithOrder.approve', $data->id) }}" method="POST">
                @csrf

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                إجمالي الأصناف في الفاتورة
                            </label>

                            <input type="text" id="total_cost" name="total_cost" class="form-control bg-light"
                                value="{{ $data->total_cost * 1 }}" readonly>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                نسبة ضريبة القيمة المضافة
                            </label>

                            <input type="text" id="tax_percent" name="tax_percent" class="form-control" value="{{ $data->tax_percent * 1 }}">
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                قيمة ضريبة القيمة المضافة
                            </label>

                            <input type="text" id="tax_value" name="tax_value" class="form-control bg-light" value="{{ $data->tax_value }}"
                                readonly>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                الإجمالي مع نسبة الضريبة
                            </label>

                            <input type="text" id="total_before_discount"  class="form-control bg-light"
                                value="{{ $data->total_before_discount * 1 }}" readonly>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">

                            <label class="font-weight-bold">
                                نوع الخصم
                            </label>

                            <select name="discount_type" id="discount_type" class="form-control">

                                <option value="">
                                    من فضلك اختر نوع الخصم
                                </option>

                                <option value="1" {{ $data->discount_type == 1 ? 'selected' : '' }}>
                                    نسبة مئوية
                                </option>

                                <option value="2" {{ $data->discount_type == 2 ? 'selected' : '' }}>
                                    قيمة ثابتة
                                </option>

                            </select>

                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">

                            <label class="font-weight-bold">
                                نسبة / قيمة الخصم
                            </label>

                            <input type="number" name="discount_percent" id="discount_percent" class="form-control"
                                value="{{ $data->discount_percent }}">
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">

                            <label class="font-weight-bold">
                                قيمة الخصم
                            </label>

                            <input type="text" name="discount_value" id="discount_value" class="form-control bg-light"
                                readonly>

                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">

                            <label class="font-weight-bold">
                                الإجمالي النهائي بعد الخصم
                            </label>

                            <input type="text" name="total_after_discount" id="total_after_discount"
                                class="form-control bg-success text-white" readonly>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">
                            خزنة الصرف
                        </label>

                        @if($adminsift)
                            {{-- الشفت مفتوح --}}
                            <input type="text" id="treasury_transaction_id" class="form-control bg-light"
                                value="{{ $adminsift->treasuriesname->name ?? '' }}" readonly>

                            <input type="hidden" name="treasury_transaction_id" value="{{ $adminsift->treasury_id }}">

                            <small class="text-success d-block mt-1">
                                {{-- <i class="fa fa-check-circle"></i> --}}
                                الشفت مفتوح باسم: {{ $adminsift->adminname->name ?? auth()->guard('admin')->user()->name }}
                            </small>
                        @else
                            {{-- لا يوجد شفت مفتوح --}}
                            <input type="text" id="treasury_transaction_id" class="form-control bg-light text-danger"
                                value="لا يوجد شفت مفتوح" readonly>

                            <input type="hidden" name="treasury_transaction_id" value="">

                            <small class="text-danger d-block mt-1">
                                <i class="fa fa-exclamation-triangle"></i>
                                لا يمكنك اعتماد الفاتورة إلا بعد فتح شفت خزينة
                            </small>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                رصيد المتاح في الخزنه
                            </label>
                            <input type="text" id="treasury_balance" class="form-control bg-light"
                                value="{{ $treasuriesBalance ?? 0 }}" readonly>
                            <small id="treasury_error" class="text-danger d-block mt-1"></small>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">

                            نوع الفاتورة
                        </label>

                        <select name="bill_type" id="bill_type" class="form-control">
                            <option value="" disabled selected>اختر</option>
                            <option value="1">كاش</option>
                            <option value="0">اجل</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold ">

                            المدفوع للمورد الاان
                        </label>

                        <input type="text" id="paid" name="paid" class="form-control bg-light">
                        <small id="paid_error" class="text-danger"></small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold ">

                            المتبقي على المورد
                        </label>

                        <input type="text" id="remain" name="remain" class="form-control bg-light" readonly>
                    </div>
                </div>

                <hr>
                <div class="text-center">

                    <button type="submit" class="btn btn-success btn-lg px-5">


                        تأكيد الاعتماد

                    </button>

                </div>


            </form>

        </div>

    </div>


@elseif ($data && $data->is_approved == 1)

    <div class="alert alert-danger">
        عفواً، لقد تم اعتماد الفاتورة من قبل
    </div>

@else

    <div class="alert alert-danger">
        عفواً، لا توجد بيانات لعرضها
    </div>

@endif

   <script src="{{ asset('assets/admin/dist/js/load_approve_invoice.js') }}"></script>
