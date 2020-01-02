
@extends('front.staff.template')
@section('styles')
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') !!}
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') !!}
@stop
@section('main')
    <nav class="navbar navbar-default navbar-fixed">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="">Quản lý tour</a>
            </div>
        </div>
        {!! Form::open(['method' => 'GET', 'url' => '/staff/quanlytour']) !!}
            <div class="row ml-0">
                <div class="col-md-12">
                    <div class="col-md-6 col-xs-12">
                        {!! Form::select('subjecttour', $subjectlist  , Request::get('subjecttour')!=''?Request::get('subjecttour'):null,array('class'=>'form-control')) !!}
                    </div>
                    <div class="col-md-6 col-xs-12">
                        {!! Form::select('diemden', $diemdenlist  , Request::get('diemden')!=''?Request::get('diemden'):null,array('class'=>'form-control')) !!}
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    {!! Form::submit('Chọn')!!}
                </div>
                <div class="col-md-12 text-center"><hr/></div>
            </div>
        {!! Form::close() !!}
        <div class="pull-right link">{!! $links !!}</div>
        <div class="table-responsive">
            <div class="clearfix"></div>
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên Tour</th>
                        <th>Khởi Hành</th>
                        <th>Giá</th>
                        <th>Chỉnh Sửa</th>
                    </tr>
                </thead>
                <tbody>
                    @include('front.staff.tour.table')
                </tbody>
            </table>
        </div>
        <div class="pull-right link">{!! $links !!}</div>
    </nav>
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