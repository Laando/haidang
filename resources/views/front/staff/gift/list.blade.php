@extends('front.staff.template')
    @section('styles')
        {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') !!}
        {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') !!}
    @stop
    @section('main')
        <?php
            $urlform = 'staff/gift';
            if(str_contains(Request::path(),'staff/givengift')) {
                $urlform = 'staff/givengift';
            }
            if(str_contains(Request::path(),'staff/givegift/1')) {
                $urlform = 'staff/givegift/1';
            }
            if(str_contains(Request::path(),'staff/givegift/2')) {
                $urlform = 'staff/givegift/2';
            }
        ?>
        
        <div id="page-wrapper">
            {!! Form::open(['url' => $urlform, 'method' => 'get','id'=>'giftFilter']) !!}
                <div class="row">
                    <div class="col-lg-12 margin-top">
                        <div class="form-group input-group">
                            <input type="text" class="form-control" placeholder="Tìm kiếm (Tên khách hàng, SĐT hoặc Tên Quà Tặng)" name="str" @if(Request::get('str') != null) value="{{Request::get('str')}}" @endif;>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                <h4 class="pull-left">  Danh sách quà tặng : {!! $total !!}  quà tặng</h4>
                                    <!-- <div class="pull-right">
                                    Từ : <input type="tẽt" name="start" id="start" placeholder="Chọn ngày bắt đầu" Ơ!! $start!=null?'value="'.Request::get('start').'"':'' !!Ư/>
                                    đến  <input type="tẽt" name="end" id="end" placeholder="Chọn ngày kết thúc" Ơ!! $end!=null?'value="'.Request::get('end').'"':'' !!Ư>
                                    </div> -->
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Tên</th>
                                            <th>Số điện thoại</th>
                                            <th>Tên Quà Tặng</th>
                                            <th>Ngày đặt</th>
                                            <th>
                                                <select name="status" id="filterStatus">
                                                    <option value="" {!! $status== '' ? 'selected':'' !!}>Tình trạng</option>
                                                    <option value="1" {!! $status== 1 ? 'selected':'' !!}>Chưa xác nhận</option>
                                                    <option value="4" {!! $status== 4 ? 'selected':'' !!}>Đã Xác Nhận</option>
                                                </select>
                                            </th>
                                            <th>Xem</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($gifts as $gift)
                                            <tr>
                                                <th >{!! $gift->customer->fullname !!}</th>
                                                <th>{!! $gift->customer->phone !!}</th>
                                                <td><a href="{{ asset('member-gift') }}">{!! $gift->gift->title !!}</a></td>
                                                <td>
                                                <?php 
                                                        $created_at = date_format(date_create($gift->created_at),'d/m/Y');
                                                        $now = date_format(\Carbon\Carbon::now(),'d/m/Y');
                                                        if($created_at == $now): 
                                                            $created_at = $gift->created_at->diffInHours(\Carbon\Carbon::now(), false);
                                                    ?>
                                                            {{ $created_at == 0 ? 'Vừa xong' : $created_at . 'h trước' }}
                                                    <?php
                                                        else: 
                                                    ?>
                                                            {{ $created_at }}
                                                    <?php
                                                        endif;
                                                    ?>
                                                 </td>
                                                <td>
                                                @if($gift->status==1)
                                                    Chờ Xác Nhận
                                                @elseif($gift->status==4)
                                                    Đã Xác Nhận
                                                @endif
                                                
                                                </td>
                                                <td>
                                                <a href="{{route('processGift') . '?gift_id=' . $gift->id}}" type="button" class="btn btn-warning">Xem</a>
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
            $('#giftFilter').submit();
        });
    @stop