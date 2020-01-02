@extends('front.staff.template')
@section('styles')
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') !!}
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') !!}
@stop
@section('main')
    <div id="page-wrapper">
        <h2>Xóa hóa đơn</h2>
        <div class="row">
            @if ((Session::has('error')))
                <div class="alert alert-danger">
                    <strong>Không thể xóa</strong>
                    <ul>
                            <li>{!! Session::get('error') !!}</li>
                    </ul>
                </div>
            @endif
        </div>
        <div class="row">
            @if ((Session::has('ok')))
                <div class="alert alert-info">
                    <strong>Xóa thành công</strong>
                </div>
            @endif
        </div>
        <div class="row">Hóa đơn chỉ được xóa khi đã hủy</div>
        <div class="row">
            {!! Form::open(['url' => 'staff/forcedel', 'method' => 'post', 'class' => '']) !!}
            <div class="form-group input-group">
                <span class="input-group-addon">ID Hóa đơn</span>
                <input type="number" class="form-control" placeholder="Nhập id hóa đơn" name="order_id" value="{!! old('order_id'); !!}">
            </div>
            <button type="submit" class="btn btn-info" name="forcedel" value="1" >Xác nhận xóa</button>
            {!! Form::close() !!}
        </div>
    </div>
@stop
