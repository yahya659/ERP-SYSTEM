<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>تسجيل الدخول</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet"
        href="{{asset('assets/admin/https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/admin/dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="{{asset('assets/admin/https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700')}}"
        rel="stylesheet">
</head>
@section('content')
@if(session('logout'))
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
        {{ session('logout') }}
    </div>
@endif
@if(session('eror'))
    <div style="
                                background-color: #de3506;
                                color: #d2dad4;
                                border: 1px solid #c3e6cb;
                                padding: 15px;
                                border-radius: 5px;
                                margin-bottom: 20px;
                                font-weight: bold;
                                text-align: center;
                            ">
        {{ session('eror') }}
    </div>
@endif



<body class="hold-transition login-page" style="
background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.4)),
url({{ asset('assets/admin/imgs/erp.jpg') }});
background-size: cover;
background-repeat: no-repeat;
min-height: 600px;
">

    <div class="login-box">

        <!-- /.login-logo -->
        <div class="card" style="width: 450px; min-height: 420px; margin: auto;
     background: rgba(255,255,255,0.15);
     backdrop-filter: blur(1px);

     border-radius: 10px;">
          <div class="card-body login-card-body" style="padding: 30px; background: transparent;">

                <h4 class="text-center mb-4" style="color: black">مرحباً بك مجدداً</h4>

                {{-- <p class="login-box-msg">سجل دخولك للمتابعة إلى لوحة التحكم</p> --}}

                <form action="{{ route('admin.login') }}" method="post">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    @error('username')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">
                                تسجيل دخول
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{asset('assets/admin/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    </div>
</body>

</html>
