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

    <div class="timkiem-tour-ql clearfix">
        {!! Form::open(['url' => 'staff', 'method' => 'post', 'class' => 'form-horizontal panel sky-form']) !!}
        <div class="col-sm-3  bs-example" data-example-ids="select-form-control">
                <select name="staff" class="form-control">
                    <option value="">Người phụ trách</option>
                    @foreach($staffs as $staff)
                        <option value="{!! $staff->id !!}" {!! ($request['staff']===null&&$role!=='admin')?($staff->id===$user->id?'selected="selected"':''):($request!=null&&$request['staff']==$staff->id?'selected="selected"':'') !!}>{!! $staff->fullname !!}</option>
                    @endforeach
                </select>
        </div><!-- /.bs-example -->
        <div class="col-sm-3 bs-example" data-example-ids="select-form-control">
                <select name="destinationpoint" class="form-control">
                    <option value="">Tất Cả Tour</option>
                    @foreach($destinationpoints as $destinationpoint )
                    <option value="{!! $destinationpoint->id !!}" {!! $request!=null&&$request['destinationpoint']==$destinationpoint->id?'selected="selected"':'' !!}>{!! $destinationpoint->title !!}</option>
                    @endforeach
                </select>
        </div><!-- /.bs-example -->
        <div class="col-sm-2 bs-example" data-example-ids="select-form-control">
            <fieldset>
                <div class="row">
                    <section>
                        <label class="input">
                            <i class="icon-append fa fa-calendar"></i>
                            <input type="text" name="start" id="start" placeholder="Chọn lịch khởi hành" {!! $request!=null?'value="'.$request['start'].'"':'' !!}>
                        </label>
                    </section>
                </div>
            </fieldset>
        </div><!-- /.bs-example -->
        <button type="submit" class="btn btn-warning">TÌM</button>
        {!! Form::close() !!}
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Stt</th>
                                <th >Tên Tour</th>
                                <th >Mã</th>
                                <th >Ngày khởi hành</th>
                                <th>Số tiền</th>
                                <th >Số chổ </th>
                                <th ></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($tours)>0)
                                @foreach($tours as $index=>$tour)
                                    <?php
                                    $id_part  = $tour->id.'';
                                    $total_char = strlen($id_part);
                                    for($i=$total_char;$i<5;$i++){
                                        $id_part = '0'.$id_part;
                                    }
                                    $code_order = 'HD'.$id_part.date_format(date_create($tour->created_at),'y');
                                    ?>
                            <tr class="parent">
                                <th>{!! $index+1 !!}</th>
                                <td><a href="{!! asset($tour->slug)!!}">{!! $tour->title !!}</a></td>
                                <td>{!!  $code_order !!}</td>
                                <td>
                                    <?php
                                        $tour_id  = $tour->id ;
                                        $starts = $hasstartdates->filter(function($value, $key) use ($tour_id) {
                                            return $value->tour_id == $tour_id;
                                        });
                                        $first_sd = $starts->first();
                                    ?>
                                    <select>
                                        @foreach($starts as $startdate)
                                        <option value="{!! $startdate->id !!}"  data-price="{{ $startdate->adult_price }}">{!! date_format(date_create($startdate->startdate),'d/m/Y') !!}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>{!! $first_sd?numbertomoney($first_sd->adult_price):'' !!}</td>
                                <td class="seat"></td>
                                <td><a href="{!!asset('staff/neworder?tourid='.$tour->id) !!}" class="btn btn-warning">GIỮ CHỖ</a></td>

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

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>Tổng hợp người quản lý</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Stt</th>
                                    <th>Tên Quản Lý</th>
                                    <th>
                                        Số Điện Thoại
                                    </th>
                                    <th>
                                        Mail
                                    </th>
                                    <th>
                                        Skype
                                    </th>
                                    <th>
                                        Yahoo
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  $count = 1;?>
                                @foreach($staffs as $staff)
                                <tr>
                                    <th>{!! $count !!}</th>
                                    <th>{!! $staff->fullname !!}</th>
                                    <td>{!! $staff->phone !!}</td>
                                    <td>{!! $staff->email !!}</td>
                                    <td>{!! $staff->skype !!}</td>
                                    <td>{!! $staff->yahoo !!}</td>
                                </tr>
                                <?php $count++; ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-lg-12 -->
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
    {!! HTML::script('js/form.js') !!}
    {!! HTML::script('js/helper.js') !!}
@stop
@section('ready')
        var eventDates = {};
        @foreach($hasstartdates as $startdate)
        eventDates[ new Date( '{!! date('m/d/Y', strtotime($startdate)) !!}' )] = new Date( '{!! date('m/d/Y', strtotime($startdate)) !!}' );
        @endforeach
        $('#start').datepicker({
            dateFormat: 'dd/mm/yy',
            prevText: '<i class="fa fa-angle-left"></i>',
            nextText: '<i class="fa fa-angle-right"></i>',
            onSelect: function( selectedDate )
            {
                var arr = selectedDate.split('/');
                date = arr[1]+'/'+arr[0]+'/'+arr[2];
                var highlight = eventDates[new Date(date)];
                if( highlight ) {
                    $('form').submit();
                }
            },
            beforeShowDay: function( date ) {
                //alert(date);
                var highlight = eventDates[date];
                if( highlight ) {
                    return [true, "event"];
                } else {
                    return [true, ''];
                }
            }
        });
@stop