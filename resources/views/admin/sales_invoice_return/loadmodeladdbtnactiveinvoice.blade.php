<div class="modal fade" id="loadmodeladdbtnactiveinvoice" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-xl" role="document">

        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">
                    إضافة فاتورة مرتجع
                </h5>

                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>

            </div>


            {{-- Body --}}
            <div class="modal-body">

                <form action="{{ route('sales_invoice_return.store') }}" method="POST">

                    @csrf

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

                                        <input type="date" name="invoice_date" id="invoice_date" class="form-control"
                                            value="{{ date('Y-m-d') }}" readonly>

                                    </div>

                                </div>


                                {{-- هل يوجد عميل --}}
                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label>هل يوجد عميل؟</label>

                                        <select name="is_has_customer" id="is_has_customer" class="form-control">
                                            {{-- <option value="0" selected>لا يوجد عميل (طياري)</option> --}}
                                            <option value="1">يوجد عميل</option>
                                        </select>

                                    </div>

                                </div>
                                @error('is_has_customer')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror


                                {{-- نوع الفاتورة --}}
                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label>نوع الفاتورة</label>

                                        <select name="sales_material_types" id="sales_material_types"
                                            class="form-control">

                                            <option value="">
                                                اختر النوع
                                            </option>

                                            @foreach ($sales_material_types as $salesmaterialtypes)

                                                <option value="{{ $salesmaterialtypes->id }}">
                                                    {{ $salesmaterialtypes->name }}
                                                </option>

                                            @endforeach

                                        </select>
                                        @error('sales_material_types')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>


                                </div>


                            </div>


                            {{-- بيانات العميل --}}
                            <div class="card mb-3" id="customerData">

                                <div class="card-header bg-light">
                                    <strong>بيانات العميل</strong>
                                </div>

                                <div class="card-body">

                                    <div class="form-group mb-0">
                                         <a href="{{ route('customers.create') }}" type="button" class="btn btn-success btn-sm">

                                    <i class="fas fa-plus"></i>
                                    إضافة عميل جديد

                                         </a>

                                        <label>العميل</label>

                                        <select name="customer_code" id="customer_code" class="form-control">
                                            <option value="">اختر العميل</option>

                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @error('customer_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>

                                </div>


                            </div>



                            {{-- بيانات المندوب --}}
                            <div class="card mb-3">

                                <div class="card-header bg-light">

                                    <strong>
                                        بيانات المندوب
                                    </strong>

                                </div>

                                <div class="card-body">

                                    <div class="form-group mb-0">

                                        <label>
                                            المندوب
                                        </label>

                                        <select name="delegate_id" id="delegate_id" class="form-control">

                                            <option value="">
                                                بدون مندوب
                                            </option>

                                            @foreach ($delegate as $delegates)

                                                <option value="{{ $delegates->id }}">
                                                    {{ $delegates->name }}
                                                </option>

                                            @endforeach

                                        </select>
                                        @error('delegate_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>

                                </div>

                            </div>



                            {{-- زر فتح الفاتورة --}}
                            <div class="text-center mt-3">

                                <button type="submit" id="do_add_new_active_invoice" class="btn btn-success">

                                    <i class="fas fa-plus"></i>

                                    فتح وإضافة الفاتورة

                                </button>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>
<script>
    $(document).ready(function () {

        // عند تغيير "هل يوجد عميل؟"
        $(document).on('change', '#is_has_customer', function () {

            toggleCustomer();

        });


        // عند فتح الـ Modal
        $('#loadmodeladdbtnactiveinvoice').on('shown.bs.modal', function () {

            toggleCustomer();

        });


        function toggleCustomer() {

            var value = $('#is_has_customer').val();

            if (value == '1') {

                // يوجد عميل
                $('#customerData').show();

                $('#customer_code').prop('disabled', false);

            } else {

                // لا يوجد عميل (طياري)
                $('#customerData').hide();

                // تفريغ العميل
                $('#customer_code').val('');

                // تعطيل اختيار العميل
                $('#customer_code').prop('disabled', true);
            }
        }

    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        @if ($errors->any())
            $('#loadmodeladdbtnactiveinvoice').modal('show');
        @endif

});
</script>
