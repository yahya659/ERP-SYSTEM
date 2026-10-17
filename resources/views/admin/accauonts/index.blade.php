@extends('layouts.admin')
@section('title')

    الحسابات الماليه
@endsection

@section('contentheader')
    الحسابات الماليه (الشجره المحاسبيه)
@endsection
@section('contentlink')
    الحسابات الماليه (الشجره المحاسبيه)

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
                        <h3 class="card-title card_title_center"> الحسابات الماليه (الشجره المحاسبيه)</h3>
                        <a href="{{ route('acaauonts.create') }}" class="btn btn-sm btn-success">
                            اضافه جديد
                        </a>

                    </div>

                    <div class="card-header">


                        <form action="{{ route('admin.acaauonts.search') }}" method="GET" class="mt-3">
                            <div class="row align-items-center">

                              <div class="col-md-2">

    <div class="form-group">

        <label>نوع البحث</label><br>

        <label>
            <input type="radio" name="search_type" value="name"
                {{ request('search_type') == 'name' ? 'checked' : '' }}>
            اسم الحساب
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
                                    <a href="{{ route('acaauonts.index') }}" class="btn btn-info btn-block">
                                        عرض الجميع
                                    </a>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            @if(isset($search) && $data->count() == 0)
                                <div class="alert alert-danger text-center">
                                    لا يوجد حسابات ماليه بهذا الاسم: {{ $search }}
                                </div>
                            @endif
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th>مسلسل</th>
                                    <th>الااسم</th>
                                    <th>رقم الحساب</th>
                                    <th>النوع</th>
                                    <th>هل اب</th>
                                    <th>الحساب الاب</th>
                                    <th>الرصيد</th>
                                    <th>حالة الرصيد</th>
                                    <th> التفعيل </th>
                                    <th>#</th>
                                </thead>

                                <tbody>
                                    @foreach($data as $info)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $info->name }}</td>
                                            <td>{{ $info->accauont_number }}</td>
                                            <td>{{ $info->accauonttypes->name }}</td>
                                            <td>{{ $info->is_parent == 1 ? 'نعم' : 'لا ' }}</td>
                                            <td>
                                                {{ $info->parientaccauontnumber ? $info->parientaccauontnumber->name : '-------' }}
                                            </td>
                                            <td>{{ $info->current_balance *1 }}</td>

                                            <td>
                                                {{ $info->current_balance > 0 ? 'مدين  (عليه)' : ($info->current_balance < 0 ? 'دائن  (له)' : 'متزن') }}
                                            </td>
                                            <td>
                                                {{ $info->is_archived == 1? 'مفعل': ($info->is_parent == 1 ? 'من ميزان المراجعه ' : 'غير مفعل') }}

                                            </td>

                                            <td>
                                                 @if ($info->accauonttypes->relatedternalaccounts==1)
                                                 <a href="{{ route('acaauonts.edit', $info->id) }}" class="btn btn-sm btn-success">
                                                    تعديل
                                                </a>
                                                <form action="{{ route('acaauonts.destroy', $info->id) }}" method="POST"
                                                    class="d-inline-block" style="margin: 0 5px;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('هل أنت متأكد من الحذف ..لن تتمكن من استرجاعها مجددا')"
                                                        class="btn btn-sm btn-danger">
                                                        حذف
                                                    </button>
                                                </form>

                                                <a href="{{ route('acaauonts.show',$info->id) }}" class="btn btn-sm btn-info">
                                                    عرض المزيد
                                                </a>
                                                @else
                                                <a>يعدل من شاشته</a>
                                                 <a href="{{ route('acaauonts.show',$info->id) }}" class="btn btn-sm btn-info">
                                                    عرض المزيد
                                                </a>


                                            @endif



                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>



                            </table>
                            {{ $data->links() }}
                        </div>
                    </div>

            @else
                    <a href="{{ route('acaauonts.create') }}" class="btn btn-sm btn-success">
                        اضافه جديد
                    </a>
                    <button type="button" class="btn btn-danger" onclick="window.history.back()">الغاء</button>


                    <div class="alert alert-danger text-center">
                        عفوا....لاتوجد حسابات الماليه لعرضها
                    </div>

                @endif

            </div>
        </div>
    </div>


@endsection
