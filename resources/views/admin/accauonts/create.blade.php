@extends('layouts.admin')
@section('title')

    اضافه حساب مالي
@endsection

@section('contentheader')
    اضافه حساب مالي
@endsection
@section('contentlink')
    اضافه حساب مالي
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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center"> اضافه حساب مالي </h3>
            </div>

            <div class="card-body">
                <form action="{{ route('acaauonts.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">اسم الحساب المالي</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>نوع الحساب</label>
                                <select name="accauont_types" id="accauont_types" class="form-control">
                                    <option value="">اختار نوع الحسب</option>
                                    @foreach ($accauont_types as $info)
                                        <option value="{{$info->id}}" {{ old('accauont_types') == $info->id }}>{{$info->name}}</option>
                                    @endforeach
                                </select>
                                @error('accauont_types')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">هل يملك اب</label>
                                <select name="is_parent" id="is_parent" class="form-control">
                                    <option value="" selected="selected">اختر الحاله</option>
                                    <option value="1" {{ old('is_parent') == 1  }}>نعم</option>
                                    <option value="0" {{ old('is_parent') == 0   }}>لا</option>
                                </select>
                                @error('is_parent')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group" id="parent" style="display:none ">
                                <label> حساب الأب إذا لم يكن له أب</label>
                                <select name="parient_accauont_number" class="form-control">
                                    <option value="">اختر حساب الأب</option>
                                    @foreach ($parient_accauont as $info)
                                        <option value="{{ $info->id }}" @if(old('parient_accauont_number') == $info->id) selected='selected' @endif>
                                            {{ $info->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parient_accauont_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">هل هو مدين او داين او متزن</label>
                                <select name="start_balance_status" id="start_balance_status" class="form-control">
                                    <option value="" selected="selected">اختر الحالة</option>
                                    <option value="1" {{ old('start_balance_status') == 1   }}>مدين</option>
                                    <option value="2" {{ old('start_balance_status') == 2  }}>دائن</option>
                                    <option value="0" {{ old('start_balance_status') == 0   }}>متزن</option>
                                </select>
                                @error('start_balance_status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>الرصيد الافتتاحي</label>
                                <input type="number" name="start_balance" id="start_balance" class="form-control" value="{{ old('start_balance') }}">
                                @error('start_balance')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">الملاحظات (اختياري)</label>
                                <input type="text" name="nodes" id="nodes" class="form-control" value="{{ old('nodes') }}">
                                @error('nodes')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="active">حاله التفعيل (مورشفه)</label>
                                <select name="is_archived" id="is_archived" class="form-control">
                                    <option value="" selected="selected">اختر الحاله</option>
                                    <option value="1" {{ old('is_archived') == 1 }}>نعم مورشف</option>
                                    <option value="0" {{ old('is_archived') == 0   }}>لا ليست مورشف</option>
                                </select>
                                @error('is_archived')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        </div>
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">اضافة</button>
                                <button type="button" class="btn btn-danger" onclick="window.history.back()">الغاء</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
    </div>
    <script>
        function toggleParent() {
            let isParent = document.getElementById('is_parent').value;
            let parentDiv = document.getElementById('parent');

            // إذا اختار "لا" (1) يظهر
            if (isParent == 0) {
                parentDiv.style.display = 'block';
            } else {
                parentDiv.style.display = 'none';
            }
        }
        // يسمح ب الاادخال  المدين والدين والمتزن
        document.getElementById('is_parent').addEventListener('change', toggleParent);

        window.onload = function () {
            toggleParent();
        };

        document.getElementById('start_balance_status').addEventListener('change', function () {

            let status = this.value;
            let balanceInput = document.getElementById('start_balance');

            // متزن
            if (status == 0) {
                balanceInput.value = 0;
                balanceInput.readOnly = true;
            }

            // مدين (موجب فقط)
            else if (status == 1) {
                balanceInput.readOnly = false;

                balanceInput.addEventListener('input', function () {
                    if (this.value < 0) {
                        this.value = Math.abs(this.value);
                    }
                });
            }

            // دائن (سالب فقط)
            else if (status == 2) {
                balanceInput.readOnly = false;

                balanceInput.addEventListener('input', function () {
                    if (this.value > 0) {
                        this.value = -Math.abs(this.value);
                    }
                });
            }
        });
        // لم يقبل ادخال الرصيد الاافتتاحي الا عند تحديد هل مدين او لا وغيره...الخ
        document.getElementById('start_balance').addEventListener('focus', function () {

    let status = document.getElementById('start_balance_status').value;

    if(status == "") {

        alert(" يجب أولاً تحديد حالة الرصيد (مدين أو دائن أو متزن)");

        this.blur(); // يرجع التركيز

    }

});
    </script>

@endsection
