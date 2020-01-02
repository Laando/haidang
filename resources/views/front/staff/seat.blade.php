@extends('front.staff.template')
@section('styles')

@stop
@section('main')
    <style>
        .seat-infor div button.btn {
            height: 90px;
        }
        .save-form i.fa-save ,.hide-form i.fa-remove
        {
            position: absolute;
            z-index: 3;
            margin-top: -10px;
            margin-left: -10px;
        }
        .over {
            -webkit-box-shadow: 0 5px 10px rgba(0,0,0,0.2);
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);

            -webkit-transform: scale(1.1);
            -moz-transform: scale(1.1);
            -o-transform: scale(1.1);
            -ms-transform: scale(1.1);
            transform: scale(1.1);
        }

        .moving {
            -webkit-transform: scale(0.9);
            -moz-transform: scale(0.9);
            -o-transform: scale(0.9);
            -ms-transform: scale(0.9);
            transform: scale(0.9);
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=30)";
            filter: alpha(opacity=30);
            opacity: 0.3;
        }

        .drop {
            -webkit-animation: drop 1s ease;
            -moz-animation: drop 1s ease;
            -ms-animation: drop 1s ease;
            -o-animation: drop 1s ease;
            animation: drop 1s ease;
        }
        @keyframes "drop" {
            0%, 100% {
                background: #FF9933;
                color: #fff;
            }
            50% {
                color: #FF9933;
                background: #00ff8f;
            }
        }
        @-moz-keyframes drop {
            0%, 100% {
                background: #FF9933;
                color: #fff;
            }
            50% {
                color: #FF9933;
                background: #00ff8f;
            }

        }
        @-webkit-keyframes "drop" {
            0%, 100% {
                background: #FF9933;
                color: #fff;
            }
            50% {
                color: #FF9933;
                background: #00ff8f;
            }
        }
        @-ms-keyframes "drop" {
        0%, 100% {
            background: #FF9933;
            color: #fff;
        }
        50% {
            color: #FF9933;
            background: #00ff8f  ;
        }
        }
        @-o-keyframes "drop" {
            0%, 100% {
                background: #FF9933;
                color: #fff;
            }
            50% {
                color: #FF9933;
                background: #00ff8f;
            }
        }
        .seat-infor .collapse.in {
            height: 90px;
        }
    </style>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tạo danh sách</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row" id="order-information">
            <div class=" col-md-6 panel-heading danhsach-pax">
                <div class="bs-example" data-example-ids="select-form-control">
                    <select class="form-control" id="tour">
                        @foreach($tours as $key => $value)
                            <option value="{!! $key !!}"
                            @if(isset($transport))
                                    {!! $key==$transport->startdate->tour->id?'selected':'' !!}
                            @endif
                            >{!! $value !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class=" col-md-6 panel-heading danhsach-pax">
                <div class="bs-example" data-example-ids="select-form-control">
                    <select class="form-control" id="OrderStartdate">
                        <option value="">Chọn khởi hành</option>
                        @if(isset($transport))
                            <?php
                            $startdates = $transport->startdate->tour->startdates()->where('startdate','>',new \DateTime())->orderBy('startdate','ASC')->get();
                            $str= '';
                            foreach($startdates as $sd)
                                {
                                    $str .= '<option value="'.$sd->id.'" '.($transport->startdate_id==$sd->id?'selected="selected"':'').'>'.date_format(date_create($sd->startdate),'d/m/Y').'</option>';
                                }
                            echo $str;
                            ?>
                        @endif
                    </select>
                </div>
            </div>
            <div class="transport-result">
                @if(isset($transport))
                    @include('front.staff.partials.transportresult')
                @endif
            </div>
        </div>
        <!-- /.row -->
        <div class="seatlist-result">
            @if(isset($transport))
                <?php
                    $priority = 1;
                    foreach($transports as $index=>$t){
                        if($t->id==$transport->id) $priority= $index+1;
                    }
                ?>
                @include('front.staff.partials.seatlist')
            @endif
        </div>
    </div>
    <!-- /#page-wrapper -->
@stop
@section('scripts')
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') !!}
    {!! HTML::script('assets/js/plugins/datepicker.js') !!}
    {!! HTML::script('js/jquery.inputmask.min.js') !!}
    {!! HTML::script('js/jquery.inputmask.numeric.extensions.min.js') !!}
    {!! HTML::script('js/zepto.dragswap.js') !!}
    {!! HTML::script('js/staff.js') !!}
    {!! HTML::script('js/form.js') !!}
    {!! HTML::script('js/helper.js') !!}
@stop
@section('ready')

@stop