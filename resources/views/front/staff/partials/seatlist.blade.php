<?php
    $tour = $transport->startdate->tour;
    $is_outbound  = $tour->isOutbound;
?>
<style>
    .border-seat {
        text-align: center;
        border: 1px solid rgb(0, 177, 192);
        min-height: 42px;;
    }
    .is_bed button ,.is_bed .plug{
        min-width: 45px;
    }
    .is_bed .btn {
        white-space: normal;
    }
    .collapse.customer-info.in {
        height: 120px!important;
    }
</style>
<div class="panel panel-default">
    <div class=" panel-heading">
        Danh sách {!! $priority !!}
        <button type="button" class="btn btn-outline btn-success" data-toggle="modal" data-target="#myModal" id="note-update">Cập nhật thông tin</button>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog note-update">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Thông tin xe</h4>
                    </div>
                    <div class="modal-body">
                        <div class="input-group  margin-bottom-10">
                            <span class="input-group-addon" id="sizing-addon3">Hướng dẫn viên</span>
                            <input type="text" class="form-control guide" name="guide" placeholder="Nhập tên hướng dẫn viên" aria-describedby="sizing-addon3" value="{!! $transport->guide !!}">
                        </div>
                        <div class="input-group  margin-bottom-10">
                            <span class="input-group-addon" id="sizing-addon3">Phone</span>
                            <input type="text" class="form-control phoneguide" name="phoneguide" placeholder="Số điện thoại HDV" aria-describedby="sizing-addon3" value="{!! $transport->phoneguide !!}">
                        </div>
                        <div class="input-group  margin-bottom-10">
                            <span class="input-group-addon" id="sizing-addon3">Ghi chú</span>
                            <input type="text" class="form-control note" name="note" placeholder="Ghi chú" aria-describedby="sizing-addon3" value="{!! $transport->note !!}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
                        <button type="button" class="btn btn-primary" data-id="{!! $transport->id !!}" onclick="updateNote(this)" id="update">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::open(['url' => 'staff/printTransportList', 'method' => 'post']) !!}
        <input type="hidden" value="{!! $transport->id !!}" name="id"/>
        <div class="pull-right" style="    margin-top: -32px;"><button type="submit"><i class="fa fa-print"></i></button></div>
        {!! Form::close() !!}
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <!-- số ghế -->
        @if($transport->is_bed)
            <?php
            $arr_convert_bed = [
                    1 =>'A1',2 =>'A2',3 =>'B1',4 =>'B2',5 =>'C1',6 =>'C2',
                    7 =>'A3',8 =>'A4',9 =>'B3',10 =>'B4',11 =>'C3',12 =>'C4',
                    13 =>'A5',14 =>'A6',15 =>'B5',16 =>'B6',17 =>'C5',18 =>'C6',
                    19 =>'A7',20 =>'A8',21 =>'B7',22 =>'B8',23 =>'C7',24 =>'C8',
                    25 =>'A9',26 =>'A10',27 =>'B9',28 =>'B10',29 =>'C9',30 =>'C10',
                    31 =>'D1',32 =>'D2',33 =>'D3',34 =>'D4',35 =>'D5',
                    36 =>'D6',37 =>'D7',38 =>'D8',39 =>'D9',40 =>'D10'
            ];
            ?>
        <div class="col-md-12 soghe-pax sortable grid is_bed">
            <div class="col-md-4 border-seat">Tài xế </div><div class="col-md-4 border-seat">Hướng dẫn viên</div><div class="col-md-4 border-seat">Cửa lên xuống</div>
            <div class="col-md-2 border-seat">Trên </div><div class="col-md-2 border-seat">Dưới</div>
            <div class="col-md-2 border-seat">Trên </div><div class="col-md-2 border-seat">Dưới</div>
            <div class="col-md-2 border-seat">Trên </div><div class="col-md-2 border-seat">Dưới</div>
            <div class="clearfix"></div>
            @foreach($seats as $index=>$seat)
                @if($index<40)
                    @if($index == 30)
                        <div class="clearfix"></div>
                        <div class="col-md-2 nopadding is_bed  border-seat" >
                            Dưới
                        </div>
                    @endif
                    @if($index == 35)
                        <div class="clearfix"></div>
                        <div class="col-md-2 nopadding is_bed  border-seat" >
                            Trên
                        </div>
                    @endif
                <?php
                $order =   $seat->order;
                ?>
            <div class="col-md-2 margin-bottom-10 seat-infor group-{!!isset($order)?$seat->order->id:'empty isempty' !!}" draggable="true">
                <div class="collapse in group-on-{!!isset($order)?$seat->order->id:'empty isempty' !!}">
                    <div class="{!! isset($order)?'btn btn-warning':'btn btn-default' !!} col-md-12" data-toggle="tooltip" data-placement="top" title="{!! $seat->phone !!}">
                        <a href="{!! isset($order)?asset('staff/editorder/'.$seat->order->id):''!!}">
                            Ghế <span class="number" style="font-size: 20px">{!! $arr_convert_bed[$seat->number] !!}</span> | {!! $seat->fullname !!}
                        </a><br/>
                        <span>
                            <a class="show-form" data-group="{!!isset($order)?$seat->order->id:'empty' !!}" {!! isset($order)?($seat->order->deposit==0?'style="color:white"':''):'' !!}>Nhóm : {!! isset($order)?($seat->order->customer->fullname==''?$seat->order->customer->phone:$seat->order->customer->fullname):' ( trống ) ' !!}</a>
                        </span>
                    </div>
                </div>
                <div class="collapse customer-info group-in-{!!isset($order)?$seat->order->id:'empty isempty' !!}" >
                    @include('front.staff.partials.updateseat')
                </div>
            </div>
                @if(($index+1)%6==0 && $index != 0 && $index != 35 )
                            <div class="clearfix {!! $index !!}"></div>
                @endif
                @endif
            @endforeach
        </div>
        @else
            <div class="col-md-12 soghe-pax sortable grid">
                @foreach($seats as $index=>$seat)
                    <?php
                    $order =   $seat->order;
                    ?>
                    <div class="col-md-3 col-xs-6 margin-bottom-10 seat-infor group-{!!isset($order)?$seat->order->id:'empty isempty' !!}" draggable="true">
                        <div class="collapse in group-on-{!!isset($order)?$seat->order->id:'empty isempty' !!}">
                            <div class="{!! isset($order)?'btn btn-warning':'btn btn-default' !!} col-md-12" data-toggle="tooltip" data-placement="top" title="{!! $seat->phone !!}">
                                <a href="{!! isset($order)?asset('staff/editorder/'.$seat->order->id):''!!}">
                                    Ghế <span class="number">{!! $seat->number !!}</span> | {!! $seat->fullname !!}
                                </a><br/>
                        <span>
                            <a class="show-form" data-group="{!!isset($order)?$seat->order->id:'empty' !!}" {!! isset($order)?($seat->order->deposit==0?'style="color:white"':''):'' !!}>Nhóm : {!! isset($order)?($seat->order->customer->fullname==''?$seat->order->customer->phone:$seat->order->customer->fullname):' ( trống ) ' !!}</a>
                        </span>
                            </div>
                        </div>
                        <div class="collapse customer-info group-in-{!!isset($order)?$seat->order->id:'empty isempty' !!}" >
                            @include('front.staff.partials.updateseat')
                        </div>
                    </div>
                    @if(($index+1)%4==0 && $index != 0)
                        <div class="clearfix"></div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
    <!-- /.panel-body -->
</div>
<!-- /.panel -->