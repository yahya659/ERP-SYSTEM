@extends('layouts.admin')

@section('title')
    اضافه الاصناف
@endsection

@section('contentheader')
    اضافه الاصناف
@endsection

@section('contentlink')
    اضافه الاصناف
@endsection

@section('this is teast')
    الاصناف
@endsection


@section('content')

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif


    @if(session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif


    <div class="row">
        <div class="col-11">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">
                        اضافة صنف جديد
                    </h3>
                </div>


                <div class="card-body">


                    <form action="{{ route('item_card.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            {{-- العمود الأول --}}
                            <div class="col-md-6">

                                <label style="display:none ">باركود الصنف (اختياري)</label>
                                <input style="display:none" name="barcode" id="barcode" class="form-control"
                                    value="{{ old('barcode') }}">


                                @error('barcode')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br />


                                <label>اسم الصنف</label>
                                <input name="name" id="name" class="form-control" value="{{ old('name') }}">

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br />
                                <label>نوع الصنف</label>
                                <select name="item_type" id="item_type" class="form-control">
                                    <option value="">اختار نوع الصنف</option>
                                    <option value="1" {{ old('item_type') == 1 ? 'selected' : '' }}>مخزني</option>
                                    <option value="2" {{ old('item_type') == 2 ? 'selected' : '' }}>استهلاكي</option>
                                    <option value="3" {{ old('item_type') == 3 ? 'selected' : '' }}>عهده</option>
                                </select>
                                @error('item_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br />
                                <label>فئة الصنف</label>
                                <select name="inv_itemscard_categories_id" id="inv_itemscard_categories_id"
                                    class="form-control">
                                    <option value="">اختار فئه الصنف</option>
                                    @foreach ($inv_itemscard_categories_id as $info)
                                        <option value="{{ $info->id }}" {{ old('inv_itemscard_categories_id') == $info->id ? 'selected' : '' }}>{{ $info->name }}</option>
                                    @endforeach
                                </select>
                                @error('inv_itemscard_categories_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br />
                                 <label>صنف الاب له</label>

                                    <select name="parent_inv_itemscard_id" id="parent_inv_itemscard_id" class="form-control">
                                        <option value="">اختر الوحدة</option>

                                        @foreach($items as $info)

                                            <option value="{{ $info->id }}">
                                                {{ $info->name }}
                                            </option>

                                        @endforeach
                                    </select>
                                       @error('parent_inv_itemscard_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <label>وحده قياس صنف الأب</label>
                                <select name="uom_id" id="uom_id" class="form-control">
                                    <option value="">اختر الوحده</option>
                                    @foreach($parent_inv_itemscardid as $item)
                                        <option value="{{ $item->id }}" {{ old('uom_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('uom_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br />
                                 <label>هل للصنف سعر ثابت </label>

                                <select name="has_fixed_price" id="has_fixed_price" class="form-control">

                                    <option value="">اختر الوحدة</option>

                                    <option value="1" {{ old('has_fixed_price') == '1' ? 'selected' : '' }}>
                                        نعم ثابت ولايتغير في الفواتير
                                    </option>

                                    <option value="0" {{ old('has_fixed_price') == '0' ? 'selected' : '' }}>
                                        لا
                                    </option>

                                </select>
                                 @error('has_fixed_price')
                                 <span class="text-danger">{{ $message }}</span>
                                 @enderror
                                 <br/>
                                <label>هل له وحدة تجزئة ابن</label>

                                <select name="dose_has_retailunit" id="dose_has_retailunit" class="form-control">

                                    <option disabled selected value="">اختر الوحدة</option>

                                    <option value="1" {{ old('dose_has_retailunit') == '1' ? 'selected' : '' }}>
                                        نعم يوجد
                                    </option>

                                    <option value="0" {{ old('dose_has_retailunit') == '0' ? 'selected' : '' }}>
                                        لا يوجد
                                    </option>

                                </select>

                                @error('dose_has_retailunit')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <br />
                                <div id="retail_uom_div">

                                    <label>وحدة قياس التجزئة الابن بنسبه للاب <span class="parent_uom_name"
                                            style="color: green">

                                        </span></label>

                                    <select name="retail_uom" id="retail_uom" class="form-control">
                                        <option value="">اختر الوحدة</option>

                                        @foreach($parent_inv_itemscardid_children as $info)

                                            <option value="{{ $info->id }}">
                                                {{ $info->name }}
                                            </option>

                                        @endforeach

                                    </select>
                                    <label>عدد وحدات التجزئه في <span class="parent_uom_name" style="color: green">

                                        </span></label>

                                    <div style="display:flex; gap:10px; align-items:center;">

                                        <input type="number" name="retail_uom_quantity_to_parent"
                                            id="retail_uom_quantity_to_parent" class="form-control"
                                            value="{{ old('retail_uom_quantity_to_parent') }}">
                                    </div>
                                    @error('retail_uom_quantity_to_parent')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br />

                                    <label>السعر قطاعي بوحده <span class="parent_uom_name" style="color: green">

                                        </span></label>

                                    <div style="display:flex; gap:10px; align-items:center;">

                                        <input type="number" name="price" id="price" class="form-control"
                                            value="{{ old('price') }}">
                                    </div>
                                    @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br />
                                    <label> السعر نص جمله بوحده <span class="parent_uom_name" style="color: green">

                                        </span></label>

                                    <div style="display:flex; gap:10px; align-items:center;">

                                        <input type="number" name="nos_gomla_price" id="nos_gomla_price"
                                            class="form-control" value="{{ old('nos_gomla_price') }}">
                                    </div>
                                    @error('nos_gomla_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br />
                                    <label>السعر جمله بوحده <span class="parent_uom_name" style="color: green">

                                        </span></label>

                                    <div style="display:flex; gap:10px; align-items:center;">

                                        <input type="number" name="wholesale_price" id="wholesale_price"
                                            class="form-control" value="{{ old('wholesale_price') }}">
                                    </div>
                                    @error('wholesale_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br />
                                    <label>السعر تكلفه الشراء بوحده الجمله <span class="parent_uom_name"
                                            style="color: green">

                                        </span></label>

                                    <div style="display:flex; gap:10px; align-items:center;">

                                        <input type="number" name="coast_price" id="coast_price" class="form-control"
                                            value="{{ old('coast_price') }}">
                                    </div>
                                    @error('coast_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br />


                                </div>
                                {{-- -------------------------------------------------- --}}
                                <div>
                                    <label>السعر قطاعي بوحده <span class="retail_uom" style="color: green">

                                        </span> <span class="parent_uom_name" style="color: green">

                                        </span> </label>

                                    <div style="display:flex; gap:10px; align-items:center;">

                                        <input type="number" name="retail_price" id="retail_price" class="form-control"
                                            value="{{ old('retail_price') }}">
                                    </div>
                                    @error('retail_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <br />

                                    {{-- -------------------------------------------------- --}}
                                     <div>
                                    <label>السعر نص الجمله بوحده <span class="retail_uom" style="color: green">

                                        </span> <span class="parent_uom_name" style="color: green">

                                        </span></label>

                                    <div style="display:flex; gap:10px; align-items:center;">

                                        <input type="number" name="nos_gomla_price_retail" id="nos_gomla_price_retail"
                                            class="form-control" value="{{ old('nos_gomla_price_retail') }}">
                                    </div>
                                    @error('nos_gomla_price_retail')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <br />
                                <label>السعر الجمله بوحده <span class="retail_uom" style="color: green">

                                    </span> <span class="parent_uom_name" style="color: green">

                                    </span></label>

                                <div style="display:flex; gap:10px; align-items:center;">

                                    <input type="number" name="wholesale_price_retail" id="wholesale_price_retail"
                                        class="form-control" value="{{ old('wholesale_price_retail') }}">
                                </div>
                                @error('wholesale_price_retail')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br/>
                                    <label>السعر الشراء بوحده <span class="retail_uom" style="color: green">

                                </span> <span class="parent_uom_name" style="color: green">

                                </span></label>

                            <div style="display:flex; gap:10px; align-items:center;">

                                <input type="number" name="coast_price_retail" id="coast_price_retail" class="form-control"
                                    value="{{ old('coast_price_retail') }}">
                            </div>
                            @error('coast_price_retail')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                            <br />


                        </div>
                        <br />
                        {{-- -------------------------------------------------- --}}




                        <label>حالة التفعيل</label>
                        <select name="active" id="active" class="form-control">

                            <option  value="1" {{ old('active') == 1 ? 'selected' : '' }}>مفعل</option>
                            <option value="0" {{ old('active') == 0 ? 'selected' : '' }}>غير مفعل</option>
                        </select>
                        @error('active')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <br />

                </div>

            </div>

            <br>

            <button class="btn btn-primary">حفظ</button>

            <a href="{{ route('item_card.index') }}" class="btn btn-danger">الغاء</a>

            </form>


        </div>

    </div>




    <script>

        window.onload = function () {

            let select = document.getElementById('uom_id');
            let dose = document.getElementById('dose_has_retailunit');
            let retailDiv = document.getElementById('retail_uom_div');

            // جديد: عناصر التكلفة
            let retailUom = document.getElementById('retail_uom');

            function updateRetailName() {

                let text = retailUom.options[retailUom.selectedIndex].text;

                document.querySelectorAll('.retail_uom').forEach(el => {
                    el.innerHTML = text;
                });

            }

            retailUom.addEventListener('change', function () {
                updateRetailName();
            });

            updateRetailName();
            // let coastPrice = document.getElementById('coast_price');


            function checkRetail() {

                // لازم وحدة الأب تكون مختارة أولاً
                if (select.value == '') {
                    retailDiv.style.display = 'none';
                    dose.value = '';
                    return;
                }

                // إذا تم اختيار وحدة الأب
                if (dose.value == '1') {
                    retailDiv.style.display = 'block';
                } else {
                    retailDiv.style.display = 'none';
                }
            }


            function updateUomName() {

                document.querySelectorAll('.parent_uom_name').forEach(el => {
                    el.innerHTML = select.options[select.selectedIndex].text;
                });

            }


            // جديد: التحكم في سعر التكلفة + اسم الوحدة
            function updateRetailUom() {

                if (!retail) return;

                let text = retail.options[retail.selectedIndex].text;

                document.querySelectorAll('.parent_uom_name').forEach(el => {
                    el.innerHTML = text;
                });

                if (retail.value != '') {
                    coastPrice.parentElement.style.display = 'block';
                } else {
                    coastPrice.parentElement.style.display = 'none';
                }
            }


            checkRetail();


            select.addEventListener('change', function () {

                updateUomName();

                dose.value = '';

                checkRetail();

            });


            dose.addEventListener('change', function () {
                checkRetail();
            });


            if (select.value != '') {
                updateUomName();
            }


            // جديد: عند تغيير وحدة التجزئة
            if (retail) {

                coastPrice.parentElement.style.display = 'none';

                retail.addEventListener('change', function () {
                    updateRetailUom();
                });

                updateRetailUom();
            }

        }
        let retailUom = document.getElementById('retail_uom');
        let retailPriceDiv = document.getElementById('retail_price').parentElement.parentElement;

        // إخفاء أولي
        retailPriceDiv.style.display = 'none';

        function checkRetailPrice() {

            if (retailUom.value != '') {
                retailPriceDiv.style.display = 'block';
            } else {
                retailPriceDiv.style.display = 'none';
            }

        }

        // عند التغيير
        retailUom.addEventListener('change', function () {
            checkRetailPrice();
        });

        // عند فتح الصفحة
        checkRetailPrice();

    </script>
@endsection
