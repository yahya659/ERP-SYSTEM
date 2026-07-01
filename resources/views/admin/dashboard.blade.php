@extends('layouts.admin')
@section('content')
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
@section('title')

    الرئيسيه
@endsection
@section('contentheader')
    الرئيسيه
@endsection
@section('contentlink')
    الرئيسيه
@endsection
@section('this is teast')
    عرض
@endsection
@section('content')
<div class="row" style="background-image: url({{ asset('assets/admin/imgs/erp.jpg') }});background-size:cover;background-repeate;min-height:600px;"
 @endsection
