<?php use Illuminate\Support\Facades\Input; ?>
@extends('front.staff.template')
    @section('styles')
        {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') !!}
        {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') !!}
    @stop
    @section('main')
        <?php
            $urlform = 'staff/order';
            if(str_contains(Request::path(),'staff/givenorder')) {
                $urlform = 'staff/givenorder';
            }
            if(str_contains(Request::path(),'staff/giveorder/1')) {
                $urlform = 'staff/giveorder/1';
            }
            if(str_contains(Request::path(),'staff/giveorder/2')) {
                $urlform = 'staff/giveorder/2';
            }
        ?>
        {!! Form::open(['url' => $urlform, 'method' => 'get','id'=>'orderFilter']) !!}
        <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12 margin-top">
                        <div class="form-group input-group">
                            <input type="text" class="form-control" placeholder="Tìm kiếm đơn hàng" name="str">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="submit"><i class="fa fa-search"></i>
                                                    </button>
                                                </span>
                            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <h4 class="pull-left">  Danh sách đơn hàng : {!! $total !!} đơn hàng</h4><div class="pull-right">
                            Từ : <input type="text" name="start" id="start" placeholder="Chọn ngày bắt đầu" {!! Input::get('start')!=null?'value="'.Input::get('start').'"':'' !!}/>
                            đến  <input type="text" name="end" id="end" placeholder="Chọn ngày kết thúc" {!! Input::get('end')!=null?'value="'.Input::get('end').'"':'' !!}>
                            </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Tên / Số điện thoại</th>
                                <th>Tên tour</th>
                                <th>Mã đơn hàng</th>
                                <th class="text-center">Ngày đặt</br>Ngày khởi hành</th>
                                <th>Số lượng</th>
                                <th>
                                    <select name="status" id="filterStatus">
                                        <option value="" {!! Input::get('status')==''?'selected':'' !!}>Tình trạng</option>
                                        <option value="1" {!! Input::get('status')==1?'selected':'' !!}>Chưa xác nhận</option>
                                        <option value="2" {!! Input::get('status')==2?'selected':'' !!}>Đã xác nhận</option>
                                        <option value="3" {!! Input::get('status')==3?'selected':'' !!}>Hoàn tất</option>
                                        <option value="4" {!! Input::get('status')==4?'selected':'' !!}>Giữ chỗ</option>
                                        <option value="0" {!! Input::get('status')=='0'?'selected':'' !!}>Hủy</option>
                                    </select>
                                </th>
                                <th>Sửa</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <?php
                                $code_order  = '';
                                $id_part  = $order->id.'';
                                $total_char = strlen($id_part);
                                for($i=$total_char;$i<5;$i++){
                                    $id_part = '0'.$id_part;
                                }
                                $startdate_str = date_format(date_create($order->startdate->startdate),'dmy');
                                $code_order = 'HD'.$id_part.date('y').'-'.$startdate_str;
                                ?>
                            <tr>
                                <th {!! $order->online==true?'style="color:red"':'' !!} {!! $order->staff->role->slug=='agent'?'style="color:blue"':'' !!}>{!! $order->customer->fullname !!}<br/>{!! $order->customer->phone!!}</th>
                                <td><a href="{!! asset($order->startdate->tour->slug) !!}">{!! $order->startdate->tour->title !!}</a></td>
                                <td>{!! $code_order !!}</td>
                                <td class="text-center">{!! date_format(date_create($order->created_at),'d/m/Y') !!}
                                    <br/>
                                    <strong class="alert-danger">{!! date_format(date_create($order->startdate->startdate),'d/m/Y') !!}</strong>
                                </td>
                                <td>NL : {!! $order->adult !!}<br/>TE : {{ $order->child }}<br/>EB : {{ $order->baby }}</td>
                                <td>{!! getStatusOrder($order->status) !!}
                                    @if($order->deposit==0&&!($order->status==3||$order->status==0))
                                    <br/>
                                    <?php
                                        $createat = $order->created_at;
                                        $endat = $order->created_at->addDays(2);
                                        $nowtime = \Carbon\Carbon::now();
                                            $difftime = $nowtime->diffInHours($endat,false);
                                    ?>
                                        @if( $difftime>=0)
                                            <strong style="color:red">Còn lại : {!!  $difftime  !!}h</strong>
                                        @else
                                            <strong style="color:red">Còn lại : {!!  $difftime  !!} h<br/> (quá hạn)</strong>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <a href="{!! asset('staff/editorder/'.$order->id) !!}" type="button" class="btn btn-warning"> Sửa</a>
                                </td>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="pull-right link">{!! $links !!}</div>
        </div>
        <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
        {!! Form::close() !!}
    @stop
    @section('scripts')
        {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
        {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') !!}
        {!! HTML::script('assets/js/plugins/datepicker.js') !!}
    @stop
    @section('ready')
        $( "#start" ).datepicker({
        defaultDate: "-1y",
        setDate : "-1y",
        dateFormat:'dd/mm/yy',
        prevText: '<i class="fa fa-angle-left"></i>',
        nextText: '<i class="fa fa-angle-right"></i>',
        onSelect: function( selectedDate ) {
        $( "#end" ).datepicker( "option", "minDate", selectedDate );
        }
        });
        $( "#end" ).datepicker({
        defaultDate: new Date(),
        setDate : "+1w",
        dateFormat:'dd/mm/yy',
        prevText: '<i class="fa fa-angle-left"></i>',
        nextText: '<i class="fa fa-angle-right"></i>',
        onSelect: function( selectedDate ) {
        $( "#start" ).datepicker( "option", "maxDate", selectedDate );
        }
        });
        $('#filterStatus').change(function(){
            $('#orderFilter').submit();
        });
    @stop