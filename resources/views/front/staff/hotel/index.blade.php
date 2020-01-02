js@extends('front.staff.template')
@section('styles')
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') !!}
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') !!}
@stop
@section('main')
    <style>
        .event a {
            background-color: #42B373 !important;
            background-image :none !important;
            color: #ffffff !important;
        }
    </style>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Stt</th>
                                <th>Khách sạn</th>
                                <th>Khách hàng</th>
                                <th>Điện thoại</th>
                                <th>Đã xem</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($hotelbooks)>0)
                                @foreach($hotelbooks as $index=>$hotelbook)
                                <?php

                                ?>
                            <tr class="parent">
                                <th>{!! $index+1 !!}</th>
                                <td>{!! $hotelbook->hotel->title !!}</td>
                                <td>{!! $hotelbook->fullname !!}</td>
                                <td>{!! $hotelbook->phone !!}</td>
                                <td><input type="checkbox" value="{!! $hotelbook->id !!}" {!! $hotelbook->seen==1?'checked':'' !!} class="seen-book" /></td>
                                <td><a href="{!!asset('staff/'.$hotelbook->id.'/hotel') !!}" class="btn btn-warning">Chi tiết</a></td>

                            </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->

        <div class="pull-right link">{!! $links !!}</div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
@stop
@section('scripts')
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') !!}
    {!! HTML::script('assets/js/plugins/datepicker.js') !!}
    {!! HTML::script('js/jquery.inputmask.min.js') !!}
    {!! HTML::script('js/jquery.inputmask.numeric.extensions.min.js') !!}
    {!! HTML::script('js/staff.js') !!}
@stop
@section('ready')

@stop