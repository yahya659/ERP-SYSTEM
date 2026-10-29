@extends('layouts.admin')

@section('title')
    تعديل صنف
@endsection

@section('content')

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-11">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">تعديل صنف</h3>
                </div>

                <div class="card-body">

                @if(isset($data) && !empty($data))

                    @php
                        $baseFields = [
                            'price'           => 'سعر البيع للمستهلك (قطاعي)',
                            'nos_gomla_price' => 'سعر نصف الجملة',
                            'wholesale_price' => 'سعر الجملة',
                            'coast_price'     => 'سعر التكلفة (شراء)',
                        ];
                        $retailFields = [
                            'retail_price'           => 'سعر البيع للمستهلك (قطاعي)',
                            'nos_gomla_price_retail' => 'سعر نصف الجملة',
                            'wholesale_price_retail' => 'سعر الجملة',
                            'coast_price_retail'     => 'سعر التكلفة (شراء)',
                        ];
                        $doseValue = old('dose_has_retailunit', $data->dose_has_retailunit);
                    @endphp

                    <form action="{{ route('item_card.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            {{-- ============ العمود الأول: البيانات الأساسية ============ --}}
                            <div class="col-md-6">

                                <label>باركود الصنف</label>
                                <input name="barcode" id="barcode" class="form-control"
                                    value="{{ old('barcode', $data->barcode) }}" readonly>
                                <br />

                                <label>اسم الصنف</label>
                                <input name="name" id="name" class="form-control"
                                    value="{{ old('name', $data->name) }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br />

                                <label>نوع الصنف</label>
                                <select name="item_type" id="item_type" class="form-control">
                                    <option value="">اختار نوع الصنف</option>
                                    <option value="1" {{ old('item_type', $data->item_type) == 1 ? 'selected' : '' }}>صنف مخزني (يُضاف للمخزون ويُباع)</option>
                                    <option value="2" {{ old('item_type', $data->item_type) == 2 ? 'selected' : '' }}>صنف استهلاكي (تاريخ انتاج وانتهاء)</option>
                                    <option value="3" {{ old('item_type', $data->item_type) == 3 ? 'selected' : '' }}>عهدة (مسؤولية موظف/جهة معينة)</option>
                                </select>
                                @error('item_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br />

                                <label>فئة الصنف</label>
                                <select name="inv_itemscard_categories_id" id="inv_itemscard_categories_id" class="form-control">
                                    <option value="">اختار فئه الصنف</option>
                                    @foreach ($inv_itemscard_categories as $info)
                                        <option value="{{ $info->id }}"
                                            {{ old('inv_itemscard_categories_id', $data->inv_itemscard_categories_id) == $info->id ? 'selected' : '' }}>
                                            {{ $info->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('inv_itemscard_categories_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br />

                                <label>الصنف الرئيسي (المرتبط به)</label>
                                <select name="parent_inv_itemscard_id" id="parent_inv_itemscard_id" class="form-control">
                                    <option value="">بدون صنف رئيسي</option>
                                    @foreach($items as $item)
                                        @if($item->id != $data->id)
                                            <option value="{{ $item->id }}"
                                                {{ old('parent_inv_itemscard_id', $data->parent_inv_itemscard_id) == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('parent_inv_itemscard_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br />

                                <label>وحدة القياس الكبيرة (وحدة الصنف الرئيسي)</label>
                                <select name="uom_id" id="uom_id" class="form-control">
                                    <option value="">اختر الوحده</option>
                                    @foreach($parent_inv_itemscardid as $info)
                                        <option value="{{ $info->id }}"
                                            {{ old('uom_id', $data->uom_id) == $info->id ? 'selected' : '' }}>
                                            {{ $info->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('uom_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br />

                                <label>هل السعر ثابت ولا يتغيّر في الفواتير؟</label>
                                <select name="has_fixed_price" id="has_fixed_price" class="form-control">
                                    <option value="">اختر</option>
                                    <option value="1" {{ (string) old('has_fixed_price', $data->has_fixed_price) === '1' ? 'selected' : '' }}>
                                        نعم، السعر ثابت ولا يمكن تعديله في الفواتير
                                    </option>
                                    <option value="0" {{ (string) old('has_fixed_price', $data->has_fixed_price) === '0' ? 'selected' : '' }}>
                                        لا، السعر قابل للتعديل
                                    </option>
                                </select>
                                @error('has_fixed_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br />

                                <label>هل يُباع أيضًا بوحدة أصغر (تجزئة)؟</label>
                                <select name="dose_has_retailunit" id="dose_has_retailunit" class="form-control">
                                    <option disabled value="" {{ $doseValue === null || $doseValue === '' ? 'selected' : '' }}>اختر</option>
                                    <option value="1" {{ (string) $doseValue === '1' ? 'selected' : '' }}>
                                        نعم، يوجد وحدة بيع أصغر
                                    </option>
                                    <option value="0" {{ (string) $doseValue === '0' ? 'selected' : '' }}>
                                        لا، الصنف يُباع بوحدته الأساسية فقط
                                    </option>
                                </select>
                                @error('dose_has_retailunit')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br />

                                <label>حالة التفعيل</label>
                                <select name="active" id="active" class="form-control">
                                    <option value="1" {{ (string) old('active', $data->active) === '1' ? 'selected' : '' }}>مفعل</option>
                                    <option value="0" {{ (string) old('active', $data->active) === '0' ? 'selected' : '' }}>غير مفعل</option>
                                </select>
                                @error('active')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br />

                            </div>

                            {{-- ============ العمود الثاني: الأسعار والوحدات ============ --}}
                            <div class="col-md-6">

                                {{-- أسعار الوحدة الأساسية: ظاهرة دائمًا --}}
                                <h5 style="color:#555; border-bottom:1px solid #eee; padding-bottom:5px;">
                                    أسعار الوحدة الأساسية
                                    <span class="parent_uom_name" style="color:green"></span>
                                </h5>

                                <div id="base_prices_div">
                                    @foreach($baseFields as $field => $label)
                                        <label>{{ $label }} بوحدة
                                            <span class="parent_uom_name" style="color:green"></span>
                                        </label>
                                        <input type="number" step="any" name="{{ $field }}" id="{{ $field }}"
                                            class="form-control" value="{{ old($field, $data->$field) }}">
                                        @error($field)
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br />
                                    @endforeach
                                </div>

                                {{-- وحدة التجزئة وأسعارها: تظهر فقط عند dose = 1 --}}
                                <div id="retail_uom_div" style="{{ (string) $doseValue === '1' ? '' : 'display:none' }}">

                                    <h5 style="color:#555; border-bottom:1px solid #eee; padding-bottom:5px; margin-top:15px;">
                                        وحدة التجزئة وأسعارها
                                    </h5>

                                    <label>الوحدة الصغيرة (وحدة البيع بالتجزئة)</label>
                                    <select name="retail_uom" id="retail_uom" class="form-control">
                                        <option value="">اختر الوحدة</option>
                                        @foreach($parent_inv_itemscardid_children as $info)
                                            <option value="{{ $info->id }}"
                                                {{ old('retail_uom', $data->retail_uom) == $info->id ? 'selected' : '' }}>
                                                {{ $info->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('retail_uom')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br />

                                    <label>كام وحدة صغيرة بتساوي وحدة كبيرة واحدة من
                                        <span class="parent_uom_name" style="color:green"></span>
                                    </label>
                                    <input type="number" step="any" name="retail_uom_quantity_to_parent"
                                        id="retail_uom_quantity_to_parent" class="form-control"
                                        value="{{ old('retail_uom_quantity_to_parent', $data->retail_uom_quantity_to_parent) }}">
                                    @error('retail_uom_quantity_to_parent')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br />

                                    @foreach($retailFields as $field => $label)
                                        <label>{{ $label }} بوحدة
                                            <span class="retail_uom" style="color:green"></span>
                                        </label>
                                        <input type="number" step="any" name="{{ $field }}" id="{{ $field }}"
                                            class="form-control" value="{{ old($field, $data->$field) }}">
                                        @error($field)
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br />
                                    @endforeach
                                </div>

                                {{-- الصورة --}}
                                <label>صورة الصنف</label>
                                @if($data->image)
                                    <div style="margin-bottom:10px;">
                                        <img src="{{ asset('storage/' . $data->image) }}" width="120" height="120"
                                            style="object-fit:cover; border-radius:8px; border:1px solid #ddd;">
                                    </div>
                                @else
                                    <div class="text-muted" style="margin-bottom:10px;">لا توجد صورة حالية</div>
                                @endif
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>

                        <br>
                        <button type="submit" class="btn btn-success">تحديث</button>
                        <a href="{{ route('item_card.index') }}" class="btn btn-danger">إلغاء</a>
                    </form>

                @else
                    <div class="alert alert-danger text-center">عفواً... لا توجد بيانات لعرضها</div>
                @endif

                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const uom       = document.getElementById('uom_id');
        const dose      = document.getElementById('dose_has_retailunit');
        const retailDiv = document.getElementById('retail_uom_div');
        const retailUom = document.getElementById('retail_uom');

        // حقول التجزئة فقط تُعطَّل عند الإخفاء (المعطّل لا يُرسل للسيرفر)
        function toggleRetail() {
            const on = dose.value === '1';
            retailDiv.style.display = on ? 'block' : 'none';
            retailDiv.querySelectorAll('input, select').forEach(el => el.disabled = !on);
        }

        function updateNames() {
            const parentName = uom.value ? uom.options[uom.selectedIndex].text.trim() : '';
            const smallName  = retailUom.value ? retailUom.options[retailUom.selectedIndex].text.trim() : '';
            document.querySelectorAll('.parent_uom_name').forEach(el => el.textContent = parentName);
            document.querySelectorAll('.retail_uom').forEach(el => el.textContent = smallName);
        }

        uom.addEventListener('change', updateNames);
        retailUom.addEventListener('change', updateNames);
        dose.addEventListener('change', toggleRetail);

        toggleRetail();
        updateNames();
    });
    </script>

@endsection
