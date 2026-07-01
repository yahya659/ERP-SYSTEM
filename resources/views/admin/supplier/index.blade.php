@extends('layouts.admin')
@section('title')

    الحسابات الموردين
@endsection

@section('contentheader')
    الحسابات الموردين
@endsection
@section('contentlink')
    الحسابات الموردين

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
                        <h3 class="card-title card_title_center">     الحسابات الموردين</h3>
                        <a href="{{ route('Suppliers.create') }}" class="btn btn-sm btn-success">
                            اضافه جديد
                        </a>

                    </div>

                    <div class="card-header">
                        {{-- search --}}
                          <form action="{{ route('admin.Suppliers.search') }}" method="GET" class="mt-3">
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
            <input type="radio" name="search_type" value="supplier_code"
                {{ request('search_type') == 'supplier_code' ? 'checked' : '' }}>
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
                                    <a href="{{ route('Suppliers.index') }}" class="btn btn-info btn-block">
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
        @elseif ($searchType == 'supplier_code')
         <div class="alert alert-danger text-center">
            لا يوجد كود بهذا الرقم: {{ $search }}
        </div>

    @else

        <div class="alert alert-danger text-center">
            لا يوجد حسابات عملاء بهذا الاسم: {{ $search }}
        </div>

    @endif

@endif
                          <table id="example2" class="table table-bordered table-hover">
    <thead class="custom_thead">
        <th>اسم المورد</th>
        <th>اسم الفئة</th>
        <th>رقم الحساب</th>
        <th>الكود</th>
        <th>العنوان</th>
        <th>الرقم</th>
        <th>الرصيد الحالي</th>
        <th>حالة التفعيل</th>
        <th>#</th>
    </thead>

    <tbody>
        @foreach($data as $info)
            <tr>
                <td>{{ $info->name }}</td>

                {{-- لازم يكون من علاقة المورد نفسه --}}
                <td>{{ $info->category->name ?? 'لا يوجد' }}</td>

                <td>{{ $info->account_number }}</td>
                <td>{{ $info->supplier_code }}</td>
                <td>{{ $info->address }}</td>
                <td>{{ $info->phone }}</td>

                <td>{{ $info->current_balance }}</td>

                <td>
                    {{ $info->active == 1 ? 'نعم' : 'غير مفعل' }}
                </td>

              <td>
    <div style="display: flex; gap: 5px; align-items: center;">

        <a href="{{ route('Suppliers.edit', $info->id) }}" class="btn btn-sm btn-success">
            تعديل
        </a>

        <form action="{{ route('Suppliers.destroy', $info->id) }}" method="POST">
            @csrf
            @method('DELETE')

            <button type="submit"
                    onclick="return confirm('هل أنت متأكد من الحذف؟')"
                    class="btn btn-sm btn-danger">
                حذف
            </button>
        </form>

        <a href="{{ route('Suppliers.show', $info->id) }}" class="btn btn-sm btn-info">
            عرض
        </a>

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
                    <a href="{{ route('customers.create') }}" class="btn btn-sm btn-success">
                        اضافه جديد
                    </a>
                    <button type="button" class="btn btn-danger" onclick="window.history.back()">الغاء</button>


                    <div class="alert alert-danger text-center">
                        عفوا....لاتوجد حسابات عملاء لعرضها
                    </div>

                @endif

            </div>
        </div>
    </div>


@endsection
