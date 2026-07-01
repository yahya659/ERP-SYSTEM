@extends('layouts.admin')

@section('title')
    المنتجات
@endsection

@section('contentheader')
    المنتجات
@endsection

@section('contentlink')
    المنتجات
@endsection

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- البحث بالاسم -->
    <div class="col-md-6">

        <form action="{{ route('admin.item_card.search') }}" method="GET">

            <div class="row align-items-end">

                <!-- البحث بالاسم -->
                <div class="col-md-6">
                    <label>البحث بالاسم</label>
                    <input type="text" name="search" class="form-control" placeholder="بحث بالاسم"
                        value="{{ request('search') }}">
                </div>

                <!-- زر البحث -->
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">
                        بحث
                    </button>

                </div>


            </div>

        </form>

    </div>
    <div class="row">
        <div class="col-12">

            @if($data)

                <div class="card">

                    <div class="card-header">

                        <h3 class="card-title">
                            بيانات المنتجات
                        </h3>

                        <a href="{{ route('item_card.create') }}" class="btn btn-success btn-sm">
                            اضافة جديد
                        </a>
                        <a href="{{ route('item_card.index') }}" class="btn btn-info">
                            عرض جميع الااصناف
                        </a>

                    </div>



                    <div class="card-body">


                        <div class="table-responsive">


                            <table class="table table-bordered table-hover">
                                @if(isset($search) && $data->count() == 0)
                                    <div class="alert alert-danger text-center">
                                        لا يوجد اصناف بهذا الاسم: {{ $search }}
                                    </div>
                                @endif


                       <thead class="custom_thead">
    <tr>
        <th>المسلسل</th>
        <th>اسم الصنف</th>
        <th>نوع الصنف</th>
        <th>الفئة</th>
        <th>الصنف الأب</th>
        <th>وحدة الأب</th>
        <th>وحدة التجزئة</th>
        <th>حالة التفعيل</th>
        <th>الإجراء</th>
    </tr>
</thead>


<tbody>

@foreach($data as $info)

<tr>

    <td>
        {{ $loop->iteration }}
    </td>


    <td>
        {{ $info->name }}
    </td>


    <td>
        @switch($info->item_type)

            @case(1)
                مخزني
                @break

            @case(2)
                استهلاكي
                @break

            @case(3)
                عهده
                @break

            @default
                غير محدد

        @endswitch
    </td>



    <td>
        {{ $info->inv_itemscard_categoriesid->name }}
    </td>



    <td>
        {{ $info->parent_inv_itemscardid?->name ?? 'لا يوجد صنف أب' }}
    </td>



    <td>
        {{ $info->uomid->name  }}
    </td>



    <td>
        {{ $info->retail_uom_id->name ??' لا يوجد'}}
    </td>



    <td>

        @if($info->active == 1)

            <span class="badge bg-success">
                مفعل
            </span>

        @else

            <span class="badge bg-danger">
                غير مفعل
            </span>

        @endif

    </td>



    <td>

        <a href="{{ route('item_card.edit',$info->id) }}"
           class="btn btn-success btn-sm">

            تعديل

        </a>
          <a href="{{ route('item_card.show',$info->id) }}" class="btn btn-sm btn-info">
                                                    عرض المزيد
                                                </a>


        <form action="{{ route('item_card.destroy',$info->id) }}"
              method="POST"
              style="display:inline-block">

            @csrf
            @method('DELETE')


            <button type="submit"
                    onclick="return confirm('هل أنت متأكد من الحذف؟')"
                    class="btn btn-danger btn-sm">

                حذف

            </button>

        </form>


    </td>


</tr>

@endforeach


</tbody>


                            </table>


                            {{ $data->links() }}


                        </div>

                    </div>


                </div>



            @else

                <a href="{{ route('item_card.create') }}" class="btn btn-success btn-sm">
                    اضافة جديد
                </a>
                <div class="alert alert-danger text-center">

                    لا توجد منتجات

                </div>


            @endif


        </div>
    </div>


@endsection
