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
        
        <div id="page-wrapper">
            {!! Form::open(['url' => $urlform, 'method' => 'get','id'=>'orderFilter']) !!}
                <div class="row">
                    <div class="col-lg-12 margin-top">
                        <div class="form-group input-group">
                            <input type="text" class="form-control" placeholder="Tìm kiếm đơn hàng (Tên khách hàng, SĐT hoặc mã đơn)" name="str" @if(Request::get('str') != null) value="{{Request::get('str')}}" @endif;>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                <h4 class="pull-left">  Danh sách đơn hàng : {!! $total !!} đơn hàng</h4>
                                    <!-- <div class="pull-right">
                                    Từ : <input type="tẽt" name="start" id="start" placeholder="Chọn ngày bắt đầu" Ơ!! $start!=null?'value="'.Request::get('start').'"':'' !!Ư/>
                                    đến  <input type="tẽt" name="end" id="end" placeholder="Chọn ngày kết thúc" Ơ!! $end!=null?'value="'.Request::get('end').'"':'' !!Ư>
                                    </div> -->
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Tên</th>
                                            <th>Số điện thoại</th>
                                            <th>Tên tour</th>
                                            <th>Ngày đặt</th>
                                            <th>Ngày khởi hành</th>
                                            <th>Mã đơn hàng</th>
                                            <th>
                                                <select name="status" id="filterStatus">
                                                    <option value="" {!! $status== '' ? 'selected':'' !!}>Tình trạng</option>
                                                    <option value="1" {!! $status== 1 ? 'selected':'' !!}>Chưa xác nhận</option>
                                                    <option value="4" {!! $status== 4 ? 'selected':'' !!}>Giữ chỗ</option>
                                                </select>
                                            </th>
                                            <th>Xem</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <th {!! $order->online==true?'style="color:red"':'' !!} {!! $order->staff->role->slug=='agent'?'style="color:blue"':'' !!}>{!! $order->customer_name !!}</th>
                                                <td>{!! $order->phone!!}</td>
                                                <td><a href="{{ asset($order->tourstaff->slug) }}">{!! $order->startdate->tour->title !!}</a></td>
                                                <td>
                                                    <?php 
                                                        $created_at = date_format(date_create($order->created_at),'d/m/Y');
                                                        $now = date_format(\Carbon\Carbon::now(),'d/m/Y');
                                                        if($created_at == $now): 
                                                            $created_at = $order->created_at->diffInHours(\Carbon\Carbon::now(), false);
                                                    ?>
                                                            {{ $created_at == 0 ? 'Vừa xong' : $created_at . 'h trước' }}
                                                    <?php
                                                        else: 
                                                    ?>
                                                            {{ $created_at }}
                                                    <?php
                                                        endif;
                                                    ?>
                                                    <br/>
                                                </td>
                                                <td>{!! date_format(date_create($order->startdate->startdate),'d/m/Y') !!}</td>
                                                <td>{{ $order->order_code }}</td>
                                                <td>{!! getStatusOrder($order->status) !!}
                                                    <!-- @if($order->deposit==0&&!($order->status==3||$order->status==0))
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
                                                    @endif -->
                                                </td>
                                                <td>
                                                    <a href="{{route('processOrder') . '?order_id=' . $order->id}}" type="button" class="btn btn-warning">Xem</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
            <div class="pull-right link">{{ $orders->appends(Request::all())->links() }}</div>
        </div>
        <!-- /#page-wrapper --> 

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