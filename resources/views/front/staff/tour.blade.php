@extends('front.staff.template')
@section('styles')

@stop
@section('main')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="row">

            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row clearfix">
            <div class="col-md-3">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-shopping-cart fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{!! $countod !!}</div>
                                <div>Đơn Hàng</div>
                            </div>
                        </div>
                    </div>
                    <a href="{!! asset('staff/order') !!}">
                        <div class="panel-footer">
                            <span class="pull-left">Xem đơn hàng</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-support fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{!! $countgod !!}</div>
                                <div>Giữ chổ</div>
                            </div>
                        </div>
                    </div>
                    <a href="{!! asset('staff/givenorder') !!}">
                        <div class="panel-footer">
                            <span class="pull-left">Xem giữ chổ</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel-body nopdding">
                    <div class="list-group">
                        <a href="{!! asset('staff/giveorder/1') !!}" class="list-group-item">
                            <i class="fa fa-envelope fa-fw"></i>Khách gửi đang chờ xử lý
                                <span class="pull-right text-muted small"><em>{!! $countg1 !!} hóa đơn</em>
                                </span>
                        </a>
                        <a href="{!! asset('staff/giveorder/2') !!}" class="list-group-item">
                            <i class="fa fa-tasks fa-fw"></i> Số khách đã gửi
                                <span class="pull-right text-muted small"><em>{!! $countg2 !!} hóa đơn</em>
                                </span>
                        </a>
                        <a href="{!! asset('staff/startdate') !!}" class="list-group-item">
                            <i class="fa fa-gear fa-fw"></i> Tạo lịch khởi hành tour
                            </span>
                        </a>

                    </div>
                    <!-- /.list-group -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.col-lg-4 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
@stop
@section('scripts')
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') !!}
    {!! HTML::script('assets/js/plugins/datepicker.js') !!}

@stop