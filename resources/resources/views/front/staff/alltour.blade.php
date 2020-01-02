
@extends('front.staff.template')
@section('styles')
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') !!}
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') !!}
@stop
@section('main')
    <nav class="navbar navbar-default navbar-fixed">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="danhsachkhachhang.html">Danh sách khách hàng</a>
            </div>
        </div>
    </nav>

    <div class="pull-right link">{!! $links !!}</div>
    <div class="table-responsive">
        {!! Form::open(['method' => 'GET', 'url' => '/staff/alltour']) !!}
        <div class="col-md-12">
            <div class="col-md-4 col-xs-12">
                {!! Form::select('subjecttour', $subjectlist  , Request::get('subjecttour')!=''?Request::get('subjecttour'):null,array('class'=>'form-control')) !!}
            </div>
            <div class="col-md-4 col-xs-12">
                {!! Form::select('diemden', $diemdenlist  , Request::get('diemden')!=''?Request::get('diemden'):null,array('class'=>'form-control')) !!}
            </div>
            <div class="col-md-4 col-xs-12">
                {!! Form::select('user', $stafflist  , Request::get('user')!=''?Request::get('user'):null,array('class'=>'form-control')) !!}

            </div>
            
            
        </div>
        <div class="col-md-12 text-center"><hr/></div>
        <div class="col-md-12 text-center">
            {!! Form::submit('Chọn')!!}
        </div>
        {!! Form::close() !!}
        <div class="clearfix"></div>
        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên Tour</th>
                    <th>Khởi Hành</th>
                    <th>Giá</th>
                    <th>Phương Tiện</th>
                    <th>Số Lượng</th>
                    <th>Người Phụ Trách</th>
                </tr>
            </thead>
            <tbody>
                @include('front.staff.tour.tablealltour')
            </tbody>
        </table>
    </div>

    <div class="pull-right link">{!! $links !!}</div>
<!-- /#wrapper -->
@stop
@section('scripts')
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') !!}
    {!! HTML::script('assets/js/plugins/datepicker.js') !!}
    {!! HTML::script('js/jquery.inputmask.min.js') !!}
    {!! HTML::script('js/jquery.inputmask.numeric.extensions.min.js') !!}
    <!-- {!! HTML::script('js/staff.js') !!} -->
@stop