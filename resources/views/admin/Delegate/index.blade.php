@extends('layouts.admin')
@section('title')

    حسابات المندوبين
@endsection

@section('contentheader')
    حسابات المندوبين
@endsection
@section('contentlink')
  حسابات المندوبين

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

            @if($data)

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title card_title_center"> حسابات المندوبين</h3>
                        <a href="{{ route('Delegates.create') }}" class="btn btn-sm btn-success">
                            اضافة جديد
                        </a>

                    </div>

                    <!-- البحث بالاسم -->
                       <div class="card-header">
                        {{-- search --}}
                          <form action="{{ route('admin.Delegates.search') }}" method="GET" class="mt-3">
                            <div class="row align-items-center">

                             <div class="col-md-2">

    <div class="form-group">

        <label>نوع البحث :</label><br>

        <label>
            <input type="radio" name="search_type" value="name"
                {{ request('search_type') == 'name' ? 'checked' : '' }}>
            اسم الحساب
        </label>

        <br>

        <label>
            <input type="radio" name="search_type" value="delegate_code"
                {{ request('search_type') == 'delegate_code' ? 'checked' : '' }}>
            رقم الكود
        </label>

        <br>

        <label>
            <input type="radio" name="search_type" value="account_number"
                {{ request('search_type') == 'account_number' ? 'checked' : '' }}>
            رقم الحساب
        </label>

    </div>

</div>

                                <div class="col-md-4">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="اكتب كلمة البحث هنا..." class="form-control">
                                </div>

                                <div class="col-md-2">
                                    <button class="btn btn-primary btn-block" type="submit">
                                        <i class="fas fa-search"></i> بحث
                                    </button>
                                </div>

                                <div class="col-md-2">
                                    <a href="{{ route('Delegates.index') }}" class="btn btn-info btn-block">
                                        عرض الجميع
                                    </a>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
  @if(isset($search) && $data->count() == 0)

    @if($searchType == 'account_number')

        <div class="alert alert-danger text-center">
            لا يوجد رقم حساب بهذا الرقم: {{ $search }}
        </div>
        @elseif ($searchType == 'delegate_code')
         <div class="alert alert-danger text-center">
            لا يوجد كود بهذا الرقم: {{ $search }}
        </div>

    @else

        <div class="alert alert-danger text-center">
            لا يوجد حسابات مندوب بهذا الاسم: {{ $search }}
        </div>

    @endif

@endif
                    <div class="row align-items-end">
                        <div class="card-body">
                            {{-- <a href="{{ route('Delegates.index') }}" class="btn btn-info">
                                عرض جميع
                            </a> --}}

                            <div class="table-responsive">
                                @if($data->count() == 0)

                                    <div class="alert alert-danger text-center">

                                        @if(request('search') && request('is_master_search') !== null && request('is_master_search') !== '')

                                            لا يوجد هذا مندوبين:
                                            <b>{{ request('search') }}</b>
                                            في قسم
                                            <b>{{ request('is_master_search') == 1 ? 'الجملة' : 'التجزئة' }}</b>

                                        @elseif(request('search'))

                                            لا يوجد أي نتائج للبحث عن:
                                            <b>{{ request('search') }}</b>

                                        @elseif(request('is_master_search') !== null && request('is_master_search') !== '')

                                            عفوا....لاتوجد مندوبين لعرضها


                                        @else

                                            عفوا....لاتوجد مندوبين لعرضها


                                        @endif

                                    </div>

                                @endif



                                <table id="example2" class="table table-bordered table-hover">
                                    <thead class="custom_thead">
                                        <th>الكود</th>
                                        <th>رقم الحساب</th>


                                        <th>المندوب</th>

                                        <th> الهاتف</th>

                                        <th>العنوان </th>
                                        <th> الرصد الحالي</th>
                                        <th> حاله الرصيد الاافتتاحي </th>
                                        <th> ملاحضات </th>
                                        <th>التفعيل</th>

                                        <th>#</th>
                                    </thead>

                                    <tbody>
                                        @foreach($data as $info)
                                            <tr>
                                                <td>{{ $info->delegate_code}}</td>
                                                <td>{{ $info->account_number}}</td>


                                                <td>{{ $info->name }}</td>
                                                <td>{{ $info->phone }}</td>

                                                <td>{{ $info->address }}</td>
                                                <td>{{ $info->current_balance }}</td>
                                                <td>
                                                    @if ($info->start_balance_status == 1)
                                                      مدين  (عليه)
                                                    @elseif ($info->start_balance_status == 2)
                                                    دائن  (له)
                                                    @else
                                                        متزن
                                                    @endif
                                                </td>
                                                <td>{{ $info->nodes }}</td>
                                                <td>{{ $info->active == 1 ? 'مفعل' : 'معطل' }}</td>
                                                <td>
                                                    <div class="d-flex gap-3">

                                                        <a href="{{ route('Delegates.edit', $info->id) }}"
                                                            class="btn btn-sm btn-success gap-3">
                                                            تعديل
                                                        </a>

                                                        <a href="{{ route('Delegates.show', $info->id) }}"
                                                            class="btn btn-sm btn-info">
                                                           تفاصيل
                                                        </a>


                                                        <form action="{{ route('Delegates.destroy', $info->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                onclick="return confirm('هل أنت متأكد من حذف ؟ لن تتمكن من استرجاعها مجدداً')"
                                                                class="btn btn-sm btn-danger">
                                                                حذف
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>



                                </table>
                                {{ $data->links() }}
                            </div>
                        </div>

            @else
                        <a href="{{ route('SupplierWithOrder.create') }}" class="btn btn-sm btn-success">
                            اضافة جديد
                        </a>
                        <button type="button" class="btn btn-danger" onclick="window.history.back()">رجوع </button>


                        <div class="alert alert-danger text-center">
                            عفوا....لاتوجد مشتريات لعرضها
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>


@endsection
