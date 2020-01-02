
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
        <form method="GET" action="{{route('startDateList')}}">
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
        </form>
        <div class="pull-right link">{!! $links !!}</div>
        <div class="content table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>TÊN TOUR</th>
                        <th>GIÁ</th>
                        <th>Phương tiện</th>
                        <th>Xem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tours as $index => $tour)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$tour->title}}</td>                            
                            <td>{{number_format($tour->adultprice) . 'đ ' }}</td>
                            <td>{{$tour->traffic}}</td>
                            <td><a href="{{route('startDateManage', ['id' => $tour->id])}}">Xem lịch khởi hành</a></td>
                        </tr>
                    @endforeach              
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