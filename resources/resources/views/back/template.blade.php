<?php
$user = Auth::user();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Mon site</title>
		<meta name="description" content="">	
		<meta name="viewport" content="width=device-width, initial-scale=1">

		{!! HTML::style('css/main_back.css') !!}

		<!--[if (lt IE 9) & (!IEMobile)]>
			{!! HTML::script('js/vendor/respond.min.js') !!}
		<![endif]-->
		<!--[if lt IE 9]>
			{{ HTML::style('https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js') }}
			{{ HTML::style('https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js') }}
		<![endif]-->
        {!! HTML::style('assets/plugins/scrollbar/css/jquery.mCustomScrollbar.css') !!}

        @yield('head')
        @yield('styles')

	</head>

  <body>

	<!--[if lte IE 7]>
	    <p class="browsehappy">Vous utilisez un navigateur <strong>obsolète</strong>. S'il vous plaît <a href="http://browsehappy.com/">Mettez le à jour</a> pour améliorer votre navigation.</p>
	<![endif]-->

   <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                @if($user->role->slug=='admin')
                    {!! link_to_route('admin', trans('back/admin.administration'), [], ['class' => 'navbar-brand']) !!}
                @else
                    <a href="{!! asset('staff') !!}" class="navbar-brand">Quản lý</a>
                @endif
            </div>
            <!-- Menu supérieur -->
            <ul class="nav navbar-right top-nav">
                <li>{!! link_to_route('home', trans('back/admin.home')) !!}</li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-user"></span> {{ Auth::user()->username }}<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{!! url('auth/logout') !!}"><span class="fa fa-fw fa-power-off"></span> {{ trans('back/admin.logout') }}</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Menu de la barre latérale -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav ">
                    @if($user->role->slug=='admin')
                        <li {!! Request::is('admin') ? 'class="active"' : '' !!}>
                        <a href="{!! route('admin') !!}"><span class="fa fa-fw fa-dashboard"></span> {{ trans('back/admin.dashboard') }}</a>
                        </li>

                        <li {!! Request::is('sourcepoint') ? 'class="active"' : '' !!}>
                        <a href="#" data-toggle="collapse" data-target="#sourcepointmenu"><span class="fa fa-fw fa-send"></span> {{ trans('back/admin.sourcepoint') }} <span class="fa fa-fw fa-caret-down"></span></a>
                        <ul id="sourcepointmenu" class="collapse">
                            <li {!! Request::is('sourcepoint') ? 'class="active"' : '' !!}><a href="{!! url('sourcepoint') !!}">{{ trans('back/admin.see-all') }}</a></li>
                            <li {!! Request::is('sourcepoint/create') ? 'class="active"' : '' !!}><a href="{!! url('sourcepoint/create') !!}">{{ trans('back/admin.add') }}</a></li>
                        </ul>
                        </li>
                        <li {!! Request::is('destinationpoint') ? 'class="active"' : '' !!}>
                        <a href="#" data-toggle="collapse" data-target="#destinationpointmenu"><span class="fa fa-fw fa-send"></span> {{ trans('back/admin.destinationpoint') }} <span class="fa fa-fw fa-caret-down"></span></a>
                        <ul id="destinationpointmenu" class="collapse">
                            <li {!! Request::is('destinationpoint') ? 'class="active"' : '' !!}><a href="{!! url('destinationpoint') !!}">{{ trans('back/admin.see-all') }}</a></li>
                            <li {!! Request::is('destinationpoint/create') ? 'class="active"' : '' !!}><a href="{!! url('destinationpoint/create') !!}">{{ trans('back/admin.add') }}</a></li>
                        </ul>
                        </li>
                         {{--<li {!! Request::is('sightpoint') ? 'class="active"' : '' !!}>--}}
                        {{--<a href="#" data-toggle="collapse" data-target="#sightpointmenu"><span class="fa fa-fw fa-send"></span> {{ trans('back/admin.sightpoint') }} <span class="fa fa-fw fa-caret-down"></span></a>--}}
                        {{--<ul id="sightpointmenu" class="collapse">--}}
                            {{--<li {!! Request::is('sightpoint') ? 'class="active"' : '' !!}><a href="{!! url('sightpoint') !!}">{{ trans('back/admin.see-all') }}</a></li>--}}
                            {{--<li {!! Request::is('sightpoint/create') ? 'class="active"' : '' !!}><a href="{!! url('sightpoint/create') !!}">{{ trans('back/admin.add') }}</a></li>--}}
                        {{--</ul>--}}
                        {{--</li>--}}
                        <li {!! Request::is('subjecttour') ? 'class="active"' : '' !!}>
                        <a href="#" data-toggle="collapse" data-target="#subjectmenu"><span class="fa fa-fw fa-send"></span> {{ trans('back/admin.subjecttour') }} <span class="fa fa-fw fa-caret-down"></span></a>
                        <ul id="subjectmenu" class="collapse">
                            <li {!! Request::is('subjecttour') ? 'class="active"' : '' !!}><a href="{!! url('subjecttour') !!}">{{ trans('back/admin.see-all') }}</a></li>
                            <li {!! Request::is('subjecttour/create') ? 'class="active"' : '' !!}><a href="{!! url('subjecttour/create') !!}">{{ trans('back/admin.add') }}</a></li>
                        </ul>
                        </li>
                @endif
                        <li {!! Request::is('tour') ? 'class="active"' : '' !!}>
                        <a href="#" data-toggle="collapse" data-target="#tourmenu"><span class="fa fa-fw fa-send"></span> {{ trans('back/admin.tour') }} <span class="fa fa-fw fa-caret-down"></span></a>
                        <ul id="tourmenu" class="collapse">
                            <li {!! Request::is('tour') ? 'class="active"' : '' !!}><a href="{!! url('tour') !!}">{{ trans('back/admin.see-all') }}</a></li>
                            <li {!! Request::is('tour/create') ? 'class="active"' : '' !!}><a href="{!! url('tour/create') !!}">{{ trans('back/admin.add') }}</a></li>
                        </ul>
                        <li {!! Request::is('promocode') ? 'class="active"' : '' !!}>
                            <a href="#" data-toggle="collapse" data-target="#promocodemenu"><span class="fa fa-fw fa-send"></span> Mã khuyến mãi <span class="fa fa-fw fa-caret-down"></span></a>
                            <ul id="promocodemenu" class="collapse">
                                <li {!! Request::is('promocode') ? 'class="active"' : '' !!}><a href="{!! url('promocode') !!}">{{ trans('back/admin.see-all') }}</a></li>
                                <li {!! Request::is('promocode/create') ? 'class="active"' : '' !!}><a href="{!! url('promocode/create') !!}">{{ trans('back/admin.add') }}</a></li>
                            </ul>
                        <li {!! Request::is('blog') ? 'class="active"' : '' !!}>
                        <a href="#" data-toggle="collapse" data-target="#blogmenu"><span class="fa fa-fw fa-send"></span> {{ trans('back/admin.blog') }} <span class="fa fa-fw fa-caret-down"></span></a>
                        <ul id="blogmenu" class="collapse">
                            <li {!! Request::is('blog') ? 'class="active"' : '' !!}><a href="{!! url('blog') !!}">{{ trans('back/admin.see-all') }}</a></li>
                            <li {!! Request::is('blog/create') ? 'class="active"' : '' !!}><a href="{!! url('blog/create') !!}">{{ trans('back/admin.add') }}</a></li>
                        </ul>
                        </li>

                        @if($user->role->slug=='admin')
                            <li {!! Request::is('miscalculate') ? 'class="active"' : '' !!}>
                                <a href="#" data-toggle="collapse" data-target="#miscalculatemenu"><span class="fa fa-fw fa-send"></span> Khoản dự chi tour <span class="fa fa-fw fa-caret-down"></span></a>
                            <ul id="miscalculatemenu" class="collapse">
                                <li {!! Request::is('miscalculate') ? 'class="active"' : '' !!}><a href="{!! url('miscalculate') !!}">{{ trans('back/admin.see-all') }}</a></li>
                                <li {!! Request::is('miscalculate/create') ? 'class="active"' : '' !!}><a href="{!! url('miscalculate/create') !!}">{{ trans('back/admin.add') }}</a></li>
                            </ul>
                        <li {!! Request::is('subjectblog') ? 'class="active"' : '' !!}>
                        <a href="#" data-toggle="collapse" data-target="#subjectblogmenu"><span class="fa fa-fw fa-send"></span> {{ trans('back/admin.subjectblog') }} <span class="fa fa-fw fa-caret-down"></span></a>
                        <ul id="subjectblogmenu" class="collapse">
                            <li {!! Request::is('subjectblog') ? 'class="active"' : '' !!}><a href="{!! url('subjectblog') !!}">{{ trans('back/admin.see-all') }}</a></li>
                            <li {!! Request::is('subjectblog/create') ? 'class="active"' : '' !!}><a href="{!! url('subjectblog/create') !!}">{{ trans('back/admin.add') }}</a></li>
                        </ul>
                        </li>
                        <li {!! Request::is('regions') ? 'class="active"' : '' !!}>
                        <a href="{!! url('regions') !!}"><span class="fa fa-fw fa-th-large"></span> {{ trans('back/admin.regions') }}</a>
                        </li>
                        <li {!! Request::is('banner') ? 'class="active"' : '' !!}>
                        <a href="{!! url('banner') !!}"><span class="fa fa-fw fa-envelope"></span> {{ trans('back/admin.banner') }}</a>
                        </li>
                        {{--<li {!! Request::is('addingcate') ? 'class="active"' : '' !!}>--}}
                        {{--<a href="{!! url('addingcate') !!}"><span class="fa fa-fw fa-envelope"></span> Phụ thu</a>--}}
                        {{--</li>--}}
                        @endif
                        {{--<li {!! Request::is('hotel') ? 'class="active"' : '' !!}>--}}
                        {{--<a href="{!! url('hotel') !!}"><span class="fa fa-fw fa-envelope"></span> {{ trans('back/admin.hotel') }}</a>--}}
                        {{--</li>--}}
                        {{--<li {!! Request::is('multiroute') ? 'class="active"' : '' !!}>
                        <a href="{!! url('multiroute') !!}"><span class="fa fa-fw fa-envelope"></span> {{ trans('back/admin.multiroute') }}</a>
                        </li>
                        <li {!! Request::is('edittransport') ? 'class="active"' : '' !!}>
                        <a href="{!! url('edittransport') !!}"><span class="fa fa-fw fa-envelope"></span> {{ trans('back/admin.edittransport') }}</a>
                        </li>
                        <li {!! Request::is('meal') ? 'class="active"' : '' !!}>
                        <a href="{!! url('meal') !!}"><span class="fa fa-fw fa-envelope"></span> {{ trans('back/admin.meal') }}</a>
                        </li>--}}
                        @if($user->role->slug=='admin')
                        <li {!! Request::is('user')||Request::is('user/create')||Request::is('user/roles') ? 'class="active"' : '' !!}>
                            <a href="#" data-toggle="collapse" data-target="#usermenu"><span class="fa fa-fw fa-user"></span> Người dùng <span class="fa fa-fw fa-caret-down"></span></a>
                            <ul id="usermenu" class="collapse">
                                <li {!! Request::is('user') ? 'class="active"' : '' !!}><a href="{!! url('user') !!}">{{ trans('back/admin.see-all') }}</a></li>
                                <li {!! Request::is('user/create') ? 'class="active"' : '' !!}><a href="{!! url('user/create') !!}">{{ trans('back/admin.add') }}</a></li>
                                <li {!! Request::is('user/roles') ? 'class="active"' : '' !!}><a href="{!! url('user/roles') !!}">{{ trans('back/roles.roles') }}</a></li>
                            </ul>
                        </li>
                        <li {!! Request::is('review') ? 'class="active"' : '' !!}>
                            <a href="#" data-toggle="collapse" data-target="#reviewmenu"><span class="fa fa-fw fa-send"></span> {{ trans('back/admin.review') }} <span class="fa fa-fw fa-caret-down"></span></a>
                            <ul id="reviewmenu" class="collapse">
                                <li {!! Request::is('review') ? 'class="active"' : '' !!}><a href="{!! url('review') !!}">{{ trans('back/admin.see-all') }}</a></li>
                                <li {!! Request::is('review/create') ? 'class="active"' : '' !!}><a href="{!! url('review/create') !!}">{{ trans('back/admin.add') }}</a></li>
                            </ul>
                        </li>
                        <li {!! Request::is('gift') ? 'class="active"' : '' !!}>
                            <a href="#" data-toggle="collapse" data-target="#giftmenu"><span class="fa fa-fw fa-send"></span> {{ trans('back/admin.gift') }} <span class="fa fa-fw fa-caret-down"></span></a>
                            <ul id="giftmenu" class="collapse">
                                <li {!! Request::is('gift') ? 'class="active"' : '' !!}><a href="{!! url('gift') !!}">{{ trans('back/admin.see-all') }}</a></li>
                                <li {!! Request::is('gift/create') ? 'class="active"' : '' !!}><a href="{!! url('gift/create') !!}">{{ trans('back/admin.add') }}</a></li>
                            </ul>
                        {{--<li {!! Request::is('car') ? 'class="active"' : '' !!}>--}}
                            {{--<a href="#" data-toggle="collapse" data-target="#carmenu"><span class="fa fa-fw fa-send"></span> {{ trans('back/admin.car') }} <span class="fa fa-fw fa-caret-down"></span></a>--}}
                            {{--<ul id="carmenu" class="collapse">--}}
                                {{--<li {!! Request::is('car') ? 'class="active"' : '' !!}><a href="{!! url('car') !!}">{{ trans('back/admin.see-all') }}</a></li>--}}
                                {{--<li {!! Request::is('car/create') ? 'class="active"' : '' !!}><a href="{!! url('car/create') !!}">{{ trans('back/admin.add') }}</a></li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                            <li {!! Request::is('config') ? 'class="active"' : '' !!}>
                                <a href="{!! url('config') !!}"><span class="fa fa-fw fa-envelope"></span> {{ trans('back/admin.config') }}</a>
                            </li>
                        <li {!! Request::is('consult') ? 'class="active"' : '' !!}>
                            <a href="{!! url('consult') !!}"><span class="fa fa-fw fa-envelope"></span> {{ trans('back/consult.title') }}</a>
                        </li>
                        <li {!! Request::is('flushcache') ? 'class="active"' : '' !!}>
                            <a href="{!! url('flushcache') !!}"><span class="fa fa-fw fa-envelope"></span> Xóa cache</a>
                        </li>
                            @endif
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                @yield('main')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /.page-wrapper -->

    </div>
    <!-- /.wrapper -->

    	{!! HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js') !!}
        {!! HTML::script('assets/plugins/scrollbar/js/jquery.mCustomScrollbar.concat.min.js') !!}
    	{!! HTML::script('js/plugins.js') !!}
        {!! HTML::script('js/helper.js') !!}
        @yield('scripts')
    <script type="text/javascript">
        var _globalObj = {'_token':'{{csrf_token()}}'};
        jQuery(document).ready(function() {
            $('.scrollbar').mCustomScrollbar({

            });
            @yield('ready')
        });

    </script>
  </body>
</html>