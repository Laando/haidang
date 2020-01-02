@if(isset($currentseat))
<style>
    .soghe .btn-btn-info:hover .plug , .soghe .btn-warning:hover .plug ,.soghe .btn-info:hover .plug
    {
        opacity: 1;
    }
    .soghe button div.plug {
        width: 22%;
        margin-left: -6px;
        margin-top: -25px;
        position: absolute;
        border-radius: 3px;
        padding: 5px;
        float: left;
        color:orange;
        background-color: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity .25s ease-in-out;
        -moz-transition: opacity .25s ease-in-out;
        -webkit-transition: opacity .25s ease-in-out;
        -o-transition: opacity .25s ease-in-out;
        border-radius: 3px;
    }
    .transport-choose {
        cursor: pointer;
    }
    .choose-transport.btn-info {
        background-color: rgba(35, 214, 164, 0.40)!important;
        color:orange!important;
    }
    .border-seat {
        text-align: center;
        border: 1px solid rgb(0, 177, 192);
        min-height: 42px;;
    }
    .is_bed button ,.is_bed .plug{
        min-width: 45px;
    }
</style>
    <hr>
    @if($notice!='')
        <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        {!! $notice !!}
        </div>
    @endif
    <div>Số chỗ còn lại  : <span class="totalseat">{!! ($order->adult+$order->addingseat)-$currentseat !!}</span></div>
    <div><i class="fa fa-car"></i> Số ghế : {!! implode(',',$sseat) !!}</div>
    <div class="clearfix"></div>
    <div class="col-md-4 tongxechay clearfix nopadding ">
        <?php $postion = 0;?>
        @foreach($transports as $index => $t)
        <?php if($t->id==$transport->id)  $postion = $index+1;?>
        <a data-id="{!! $t->id !!}" class="choose-transport {!!$t->id==$transport->id?'btn btn-info':''!!}" onclick="getTransportSeat(this)">Xe {!! $index+1 !!} <br><span>{!! $t->countOrderSeats() !!} chỗ</span></a>
        @endforeach
    </div><!--tongxechay-->
@if(isset($transport))
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
        <div class="col-md-8 sodoxe clearfix nopadding">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <input type="hidden" name="currenttransport" value="{!!isset($transport)?$transport->id:''!!}" id="currenttransport">
                    Sơ đồ xe {!! $postion !!} (Giường nằm)
                </div>
                <div class="panel-body ">
                    <div class="soghe">
                        <div class="col-md-4 border-seat">Tài xế </div><div class="col-md-4 border-seat">Hướng dẫn viên</div><div class="col-md-4 border-seat">Cửa lên xuống</div>
                        <div class="col-md-2 border-seat">Trên </div><div class="col-md-2 border-seat">Dưới</div>
                        <div class="col-md-2 border-seat">Trên </div><div class="col-md-2 border-seat">Dưới</div>
                        <div class="col-md-2 border-seat">Trên </div><div class="col-md-2 border-seat">Dưới</div>
                        <div class="clearfix"></div>
                        @if(isset($transport))
                            <?php
                            $seats = $transport->seats()->orderBy('number','ASC')->get();
                            ?>
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
                                 <div class="col-md-2 nopadding is_bed">
                                    <button type="button" class="btn {!! $seat->order_id==null?'btn-btn-info':($seat->order_id==$order->id?'btn-warning':'btn-info') !!}"
                                    @if($seat->order_id!=null)
                                            data-toggle="tooltip" data-placement="top" data-original-title="{!! $seat->order->customer->fullname!!}/{!!$seat->order->customer->phone !!}"
                                            @endif
                                            >
                                        <input type="hidden" name="number" value="{!! $seat->number !!}">
                                        <input type="hidden" name="order" value="{!! $seat->order!=null?$seat->order->id:'' !!}">
                                        <i class="fa fa-automobile"></i> {!! $arr_convert_bed[$seat->number] !!}
                                        <div class="plug text-center">
                                            <i class="fa {!! $seat->order_id==null?'fa-plus':($seat->order_id==$order->id?'fa-remove':'fa-search') !!}"></i>
                                        </div>
                                    </button>
                                 </div>
                             @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                <!-- .sodoxe -->
            </div>
        </div>
    @else
    <div class="col-md-8 sodoxe clearfix nopadding">
        <div class="panel panel-default">
            <div class="panel-heading">
                <input type="hidden" name="currenttransport" value="{!!isset($transport)?$transport->id:''!!}" id="currenttransport">
                Sơ đồ xe {!! $postion !!}
            </div>
            <div class="panel-body ">
                <div class="soghe">
                @if(isset($transport))
                    <?php
                        $seats = $transport->seats()->orderBy('number','ASC')->get();
                    ?>
                    @foreach($seats as $seat)
                        <button type="button" class="btn {!! $seat->order_id==null?'btn-btn-info':($seat->order_id==$order->id?'btn-warning':'btn-info') !!}"
                                @if($seat->order_id!=null)
                                data-toggle="tooltip" data-placement="top" data-original-title="{!! $seat->order->customer->fullname!!}/{!!$seat->order->customer->phone !!}"
                                @endif
                                >
                            <input type="hidden" name="number" value="{!! $seat->number !!}">
                            <input type="hidden" name="order" value="{!! $seat->order!=null?$seat->order->id:'' !!}">
                            <i class="fa fa-automobile"></i> {!! $seat->number !!}
                            <div class="plug text-center">
                                <i class="fa {!! $seat->order_id==null?'fa-plus':($seat->order_id==$order->id?'fa-remove':'fa-search') !!}"></i>
                            </div>
                        </button>
                    @endforeach
                @endif
                </div>
            </div>
            <!-- .sodoxe -->
        </div>
    </div>
    @endif
@endif
<div class="clearfix"></div>

@if(isset($transport))
<div class="pull-right"><a href="{!! asset('staff/seat?transport='.$transport->id)!!}">Sửa danh sách</a></div>
@endif
    @endif
    <!-- .panel-body -->