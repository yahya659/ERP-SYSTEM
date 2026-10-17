@extends('layouts.admin')
@section('title')
    تفاصيل المستخدم
@endsection
@section('contentheader')
    تفاصيل المستخدم
@endsection
@section('contentlink')
    تفاصيل المستخدم
@endsection
@section('this is teast')
    عرض
@endsection
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
@section('content')
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
    {{-- ------------------------------------------------------------ --}}
    {{--start-model --}}
    <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form action="{{ route('admin_accauonts.add_new_admin_treasuries') }}" method="POST">
                    @csrf
                      <input type="hidden" name="admin_id" value="{{ $data->id }}">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="addItemModalLabel">
                            إضافة خزن للمستخدم
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" name="admin_id" value="{{ $data->id }}">

                        <div class="mb-3">
                            <label class="form-label">اختر الخزنة</label>

                            <select name="treasuries_id" id="treasuries_id" class="form-control" required>
                                <option value="">اختر الخزنة</option>

                                @foreach($treasury as $info)
                                    <option value="{{ $info->id }}">
                                        {{ $info->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="submit" class="btn btn-success">
                            حفظ
                        </button>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            إغلاق
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- end-model --}}
    {{-- ----------------------------------------------------------------- --}}
    <data class="row">
        <div class="col-12">


            @if(isset($data) && !empty($data))
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tbody>

                            <tr>
                                <th width="30%" class="custom_thead">اسم المستخدم</th>
                                <td>{{ $data->name }}</td>
                            </tr>
                            <tr>
                                <th class="custom_thead">تاريخ الإضافة</th>
                                <td>
                                    {{ $data->created_at->format('Y-m-d g:i') }}<br>
                                    {{ $data->created_at->format('A') == 'AM' ? 'صباحاً' : 'مساءً' }}
                                    <br>
                                    بواسطة {{ $data->addedBy->name ?? 'غير معروف' }}
                                </td>
                            </tr>

                            <tr>
                                <th class="custom_thead">تاريخ التحديث</th>
                                <td>
                                    {{ $data->updated_at->format('Y-m-d g:i') }}<br>
                                    {{ $data->updated_at->format('A') == 'AM' ? 'صباحاً' : 'مساءً' }}
                                    <br>
                                    بواسطة {{ $data->updatedBy->name ?? 'غير معروف' }}
                                </td>
                            </tr>

                            <tr>
                                <th class="custom_thead">الحالة</th>
                                <td>
                                    @if($data->active == 1)
                                        <span class="badge badge-success">مفعل</span>
                                    @else
                                        <span class="badge badge-danger">غير مفعل</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th class="custom_thead">الإجراءات</th>
                                <td>
                                    <a href="{{ route('admin_accauonts.edit', $data->id) }}" class="btn btn-sm btn-success">
                                        تعديل
                                    </a>

                                    <button type="button" class="btn btn-sm btn-secondary" onclick="window.history.back()">
                                        رجوع
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>


            @else
                <div class="alert alert-danger text-center">
                    عفوا.... لا توجد بيانات لعرضها
                </div>



            @endif


            {{-- start-admin-Treasury --}}
            @if($admin_treasury->isNotEmpty())

                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">

                        <h5 class="text-muted mb-2">
                            الخزن المضافه لصلاحيه المستخدم
                            <span class="badge bg-success">
                                {{ $data->name }}
                            </span>
                        </h5>

                    </div>

                    <div class="card-header">
                        <button type="button" id="openModalBtn" class="btn btn-success">
                            إضافة تسليم خزن للمستخدم
                        </button>
                    </div>
                </div>


                <div class="table-responsive mt-3">

                    <table class="table table-bordered table-striped text-center">

                        <thead class="custom_thead">
                            <tr>
                                <th>اسم الخزن</th>
                                <th>تم تسليمه إلى</th>
                                <th>بواسطة</th>
                                <th>تاريخ الاضافه</th>
                                <th></th>
                            </tr>
                        </thead>


                        <tbody>

                            @foreach($admin_treasury as $info)

                                <tr>

                                    <td>
                                        {{ $info->treasury->name ?? 'لا يوجد اسم' }}
                                    </td>


                                    <td>
                                        {{ $info->admin->name ?? '---' }}
                                    </td>


                                    <td>
                                        {{ $info->addedBy->name ?? 'غير معروف' }}
                                    </td>


                                    <td>
                                        {{ $info->created_at ? $info->created_at->format('Y-m-d H:i') : 'لايوجد' }}
                                    </td>


                                    <td>
                                        {{-- <a href="{{ route('admin.treasuries.delete_Treasury_Delivery', $info->id) }}"
                                            onclick="return confirm('هل أنت متأكد من حذف الخزن الفرعي؟')"
                                            class="btn btn-sm btn-danger">
                                            حذف
                                        </a> --}}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


            @else

                <div class="card-header">
                    <button type="button" id="openModalBtn" class="btn btn-success">
                        إضافة تسليم خزن للمستخدم
                    </button>
                </div>


                <h5 class="text-muted mb-2">
                    الخزن الاضافيه لصلاحيه المستخدم.
                    <span class="badge bg-success">
                        {{ $data->name }}
                    </span>
                </h5>
                <div class="alert alert-warning text-center">
                    لايوجد بيانات لعرضها
                </div>


            @endif
            {{-- end-admin-Treasury --}}


        </div>
        </div>
        <script>
                document.getElementById("openModalBtn").addEventListener("click", function () {

                    let modal = document.getElementById("addItemModal");

                    if (window.bootstrap) {
                        let bsModal = new bootstrap.Modal(modal);
                        bsModal.show();
                    } else if (window.jQuery) {
                        $('#addItemModal').modal('show');
                    } else {
                        alert("لايوجد");
                    }
                });
        </script>

@endsection
