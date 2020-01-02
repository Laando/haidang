@extends('front.staff.template')
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
            <form class="sky-form">
            <h4 class="modal-title" id="myModalLabel2">Đặt phòng khách sạn {!! $hotelbook->hotel->title !!}</h4>
            <fieldset>
                <section class="col-md-6">
                    <label class="input">
                        <i class="icon-append fa fa-user"></i>
                        {!! Form::text('adult', $hotelbook->adult, array('placeholder' => 'Số người lớn','id'=>'adult')) !!}
                        <b class="tooltip tooltip-bottom-right">Số người lớn</b>
                    </label>
                </section>
                <section class="col-md-6">
                    <label class="input">
                        <i class="icon-append fa fa-user"></i>
                        {!! Form::text('child',$hotelbook->child, array('placeholder' => 'Số trẻ em','id'=>'child')) !!}
                        <b class="tooltip tooltip-bottom-right">Số trẻ em (2-11 tuổi)</b>
                    </label>
                </section>
                <section class="col-md-12 room-select-list">

                    @foreach($hotelbook->rooms as $room)
                            <div class="room-list">
                                <div class="col-md-6 room-type-text">{!! $room->title !!}</div>
                                <div class="col-md-3 room-amount">{!! $room->pivot->number.' phòng' !!}</div>
                                <div class="col-md-3 room-price">{!! numbertomoney($room->pivot->cached_price) !!}</div>
                            </div>
                    @endforeach

                </section>
                <section class="col-md-6">
                    <label class="input">
                        <i class="icon-append fa fa-user"></i>
                        {!! Form::text('checkin', date_format(date_create($hotelbook->checkin),'d/m/Y'), array('placeholder' => 'Check-in','id'=>'checkin')) !!}
                        <b class="tooltip tooltip-bottom-right">Thời gian check-in</b>
                    </label>
                </section>
                <section class="col-md-6">
                    <label class="input">
                        <i class="icon-append fa fa-user"></i>
                        {!! Form::text('checkout',date_format(date_create($hotelbook->checkout),'d/m/Y'), array('placeholder' => 'Check-out','id'=>'checkout')) !!}
                        <b class="tooltip tooltip-bottom-right">Thời gian check-out</b>
                    </label>
                </section>
                <section class="col-md-12">
                    <label class="input">
                        <i class="icon-append fa fa-briefcase"></i>
                        {!! Form::text('fullname', $hotelbook->fullname, array('placeholder' => 'Họ tên')) !!}
                        <b class="tooltip tooltip-bottom-right">Họ và tên liên lạc</b>
                    </label>
                </section>
                <section class="col-md-12">
                    <label class="input">
                        <i class="icon-append fa fa-briefcase"></i>
                        {!! Form::text('email', $hotelbook->email, array('placeholder' => 'Email')) !!}
                        <b class="tooltip tooltip-bottom-right">Email</b>
                    </label>
                </section>
                <section class="col-md-12">
                    <label class="input">
                        <i class="icon-append fa fa-briefcase"></i>
                        {!! Form::text('phone', $hotelbook->phone, array('placeholder' => 'Điện thoại')) !!}
                        <b class="tooltip tooltip-bottom-right">Điện thoại</b>
                    </label>
                </section>
                <section class="col-md-12">
                    <label class="input">
                        <i class="icon-append fa fa-briefcase"></i>
                        {!! Form::text('address', $hotelbook->address, array('placeholder' => 'Địa chỉ')) !!}
                        <b class="tooltip tooltip-bottom-right">Địa chỉ</b>
                    </label>
                </section>
            </fieldset>
        <!-- /.col-lg-12 -->

        </form>
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