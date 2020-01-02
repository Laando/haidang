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
        .waiting{
            color: red;
        }
        .done{
            font-weight: bold;
            color: blue;
        }
        .processing{
            font-weight: bold;
            color: #002b36;
            animation: blinker 1.5s linear infinite;
        }
        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
        .modal-backdrop {
            z-index: -1;
        }
    </style>
<div id="page-wrapper">

    @if (session('thongbao'))
        <div class="alert alert-danger">{{session('thongbao')}}</div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="text-align: center">Stt</th>
                                <th style="text-align: center">Tên khách hàng - Số điện thoại</th>
                                <th style="text-align: center">Ngày khởi hành</th>
                                <th style="text-align: center">Ngày đặt tour</th>
                                <th style="text-align: center">Phương tiện</th>
                                <th style="text-align: center">Số lượng</th>
                                <th style="text-align: center">Pax</th>
                                <th style="text-align: center">Tình trạng</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <script>
                                function formatDate(stringDate){
                                    var date=new Date(stringDate);
                                    return date.getDate() + '/' + (date.getMonth() + 1) + '/' +  date.getFullYear();
                                }
                            </script>
                            @if(count($tours)>0)
                                @foreach($tours as $index=>$tour)

                            <tr class="parent">
                                <th>{!! $index+1 !!}</th>
                                <td><strong>{!! $tour->name !!} - {{$tour->phone}}</strong></td>
                                <td style="text-align: center">{{ \Carbon\Carbon::parse($tour-> start_date)->format('d/m/Y')}} </td>
                                <td style="text-align: center"><font color="red">{{ \Carbon\Carbon::parse($tour -> receive_date)->format('d/m/Y - h:m:s')}}</font></td>
                                <td style="text-align: center">{{$tour-> vehicle}}</td>
                                <td style="text-align: center">{{$tour-> countXe}}</td>
                                <td style="text-align: center">{{$tour -> totalCount}}</td>
                                <td style="text-align: center">
                                    @if ($tour-> idStatus == 1)
                                        <div class="waiting">
                                            {{$tour->status}}
                                        </div>
                                    @endif
                                    @if ($tour-> idStatus == 2)
                                        <div class="processing">
                                            {{$tour->status}}
                                        </div>
                                    @endif
                                    @if ($tour-> idStatus == 3)
                                        <div class="done">
                                            {{$tour->status}}
                                        </div>
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    <!-- Check role -->

                                        <a
                                            @if ($user->id == 1 ||$user->id == $tour->idemployee || $tour->idStatus == 1)
                                                href="{!!asset('phong-doan/edit/idself_tour='.$tour->idself_tour.'/isUpdated=0') !!}"
                                            @endif
                                            @if($user->id != 1 && $user->id != $tour->idemployee)
                                                onclick="alert('Bạn không có quyền truy cập');"
                                            @endif
                                           class="btn btn-cancel">SỬA
                                        </a>


                                    <!--  -->
                                    <a href="" data-toggle="modal" data-target="#myModal" class="btn btn-warning">XÓA</a>
                                    <!-- Modal -->
                                    <div id="myModal"  class="modal fade" role="alert">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Bạn có muốn xóa Tour này không ?</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <button onclick="window.location.href='{!!asset('phong-doan/delete/id='.$tour->idself_tour) !!}'" type="button" class="btn btn-default" data-dismiss="modal">Có</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Không</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>


                            </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="timkiem-tour-ql clearfix">
                            <button onclick="window.open('phong-doan/thong-ke')" type="submit" class="btn btn-warning">THỐNG KÊ</button>
                        </div>
                    </div>
                </div>
                <div class="pull-right link">{!! $links !!}</div>
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
@stop
{{--@section('ready')--}}
        {{--var eventDates = {};--}}
        {{--@foreach($hasstartdates as $startdate)--}}
        {{--eventDates[ new Date( '{!! date('m/d/Y', strtotime($startdate)) !!}' )] = new Date( '{!! date('m/d/Y', strtotime($startdate)) !!}' );--}}
        {{--@endforeach--}}
        {{--$('#start').datepicker({--}}
            {{--dateFormat: 'dd/mm/yy',--}}
            {{--prevText: '<i class="fa fa-angle-left"></i>',--}}
            {{--nextText: '<i class="fa fa-angle-right"></i>',--}}
            {{--onSelect: function( selectedDate )--}}
            {{--{--}}
                {{--var arr = selectedDate.split('/');--}}
                {{--date = arr[1]+'/'+arr[0]+'/'+arr[2];--}}
                {{--var highlight = eventDates[new Date(date)];--}}
                {{--if( highlight ) {--}}
                    {{--$('form').submit();--}}
                {{--}--}}
            {{--},--}}
            {{--beforeShowDay: function( date ) {--}}
                {{--//alert(date);--}}
                {{--var highlight = eventDates[date];--}}
                {{--if( highlight ) {--}}
                    {{--return [true, "event"];--}}
                {{--} else {--}}
                    {{--return [true, ''];--}}
                {{--}--}}
            {{--}--}}
        {{--});--}}
{{--@stop--}}