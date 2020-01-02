
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Quản Lý</title>

    <!-- Bootstrap Core CSS -->
    <link href="{!! asset('bower_components/bootstrap/dist/css/bootstrap.min.css')!!}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{!! asset('bower_components/metisMenu/dist/metisMenu.min.css')!!}" rel="stylesheet">


    <!-- Custom CSS -->
    <link href="{!! asset('dist/css/sb-admin-2.css')!!}" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="{!! asset('bower_components/font-awesome/css/font-awesome.min.css')!!}" rel="stylesheet" type="text/css">
    <link href="{!! asset('demo/js/select2-4.0.3/dist/css/select2.min.css')!!}" rel="stylesheet" type="text/css">
    @yield('styles')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top " role="navigation" style="margin-bottom: 0">
        <div>
            <h3 class="pull-left"><a href="{!! asset('staff/neworder?create=new')!!}" class="btn btn-primary btn-sm">Tạo đơn hàng</a></h3>
            <h3 class="pull-left"><a href="{!! asset('tour')!!}" class="btn btn-primary btn-sm">Quản lý tour</a></h3>
        </div>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- /.navbar-header -->
        <ul class="nav navbar-top-links navbar-right">

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> Quản Lý Của <h6>{!! $user->fullname !!}</h6></a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Cài đặt</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{!! asset('auth/logout')!!}"><i class="fa fa-sign-out fa-fw"></i> Thoát</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="{!! asset('staff') !!}"><i class="fa fa-dashboard fa-fw"></i> Trang chủ</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-wrench fa-fw"></i> Quản lý<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level in {!! Request::has('tour')||str_contains(Request::url(),'staff/order')||str_contains(Request::url(),'staff/givenorder')||str_contains(Request::url(),'staff/giveorder/1')||str_contains(Request::url(),'staff/giveorder/2')?'in':'' !!}">
                            <li>
                                <a href="{!! asset('staff/tour') !!}">Tour quản lý<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level in {!! Request::has('order')||str_contains(Request::url(),'staff/order')||str_contains(Request::url(),'staff/givenorder')||str_contains(Request::url(),'staff/giveorder/1')||str_contains(Request::url(),'staff/giveorder/2')?'in':'' !!}">
                                    <li>
                                        <a href="{!! asset('staff/tour') !!}"><i class="fa fa-envelope fa-fw"></i>Quản lý</a>
                                    </li>
                                    <li>
                                        <a href="{!! asset('staff/order') !!}"><i class="fa fa-envelope fa-fw"></i>Xem đơn hàng</a>
                                    </li>
                                    <li>
                                        <a href="{!! asset('staff/givenorder') !!}"><i class="fa fa-envelope fa-fw"></i>Xem giử chỗ</a>
                                    </li>
                                    <li>
                                        <a href="{!! asset('staff/giveorder/1') !!}"><i class="fa fa-envelope fa-fw"></i>KH chờ xử lý</a>
                                    </li>
                                    <li>
                                        <a href="{!! asset('staff/giveorder/2') !!}"><i class="fa fa-envelope fa-fw"></i>Số khách gửi</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="{!! asset('staff/seat') !!}">Sửa danh sách</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="{!! asset('staff/hotel') !!}"><i class="fa fa-dashboard fa-fw"></i> Quản lý Đặt phòng KS</a>
                    </li>
                    <li>
                        <a href="{!! asset('staff/checkCustomer') !!}"><i class="fa fa-dashboard fa-fw"></i> Kiểm tra khách hàng (Theo chỗ ngồi)</a>
                    </li>

                    <li>
                        <a href="{!! asset('staff/customer') !!}"><i class="fa fa-user fa-fw"></i> Quản lý khách hàng</a>
                    </li>
                    @if($user->role->slug == 'admin')
                        <li>
                            <a href="{!! asset('staff/delOrder') !!}"><i class="fa fa-remove fa-fw"></i> Xóa hóa đơn</a>
                        </li>
                        <li>
                            <a href="{!! asset('staff/doFinished') !!}"><i class="fa fa-check-square-o fa-fw"></i> Hoàn tất hóa đơn</a>
                        </li>
                    @endif
                </ul>
                @if(Session::has('finished'))
                    <div class="alert alert-info">{!! session('finished') !!}</div>
                @endif
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>
    @yield('main')
</div>
<ul class="notifications"></ul>
    <!-- jQuery -->
    <script src="{!! asset('bower_components/jquery/dist/jquery.min.js')!!}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{!! asset('bower_components/bootstrap/dist/js/bootstrap.min.js')!!}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{!! asset('bower_components/metisMenu/dist/metisMenu.min.js')!!}"></script>
    <script src="{!! asset('demo/js/select2-4.0.3/dist/js/select2.min.js')!!}"></script>
    @yield('scripts')

    <!-- Custom Theme JavaScript -->
    <script src="{!! asset('dist/js/sb-admin-2.js')!!}"></script>
<script type="text/javascript">
    var _globalObj = {!! json_encode(array('_token'=> csrf_token())) !!}
</script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        $('.select2').select2();
        @yield('ready')
    });
</script>
</body>

</html>
