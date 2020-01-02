@extends('front.staff.template')
@section('styles')
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') !!}
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') !!}
    {!! HTML::style('css/datepicker.css') !!}
@stop
@section('main')
    @php

    @endphp
    <style>
        .datepicker{z-index:1151 !important;}
        .form-group select{
            height: 34px;
            width: 100%;
        }
        .percentmask{
            text-align: right;
        }
        .form-horizontal .form-group {
            margin-right:  0px !important;
            margin-left:  0px !important;
        }
    </style>
    <div id="page-wrapper">

        {!! Form::open(['url' => 'staff/startdate', 'method' => 'get', 'class' => '']) !!}
        <div class="row">
            <div class="col-md-12 margin-top">
                <div class="col-sm-3 bs-example" data-example-ids="select-form-control">

                    {!! Form::select('destinationpoint', $destinationpoints,null,array('class'=>'form-control')) !!}

                </div><!-- /.bs-example -->
                <div class="col-sm-9" id="startdate-tour">
                    @include('front.staff.partials.startdatetour')
                </div>
            </div><!--col-md-12-->
        </div><!--row-->
        {!! Form::close() !!}
        @if(Session::has('transportError'))
            @if (count($errors) > 0 )
                <div class="alert alert-danger">
                    <strong>{!! sesion('transportError') !!}</strong>
                </div>
            @endif
        @endif
        @if($tour !== null)
        <div class="row">
            <div class="col-lg-12">
                <div class="td-khohanh">
                    <h3><i class="fa fa-circle"></i> LỊCH KHỞI HÀNH {!! $tour->title !!}
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#StartDateModal">
                            Tạo mới
                        </button>
                    </h3>
                    <div class="panel-body">
                        <div class="panel panel-default">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Stt</th>
                                        <th>Ngày khởi hành</th>
                                        <th>Không nhận khách</th>
                                        <th>
                                            Giá tour
                                        </th>
                                        <th>
                                            Các khoản phụ thu
                                        </th>
                                        <th>
                                            Số chổ
                                        </th>
                                        <th>
                                            Phương tiện
                                        </th>
                                        <th>
                                            
                                        </th>
                                        <th>

                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if($user->role->slug=='admin'){
                                        $startdates = $tour->startdates()->orderBy('startdate','ASC')->get();
                                    } else {
                                        $startdates = $tour->startdates()->where('startdate','>',new \DateTime())->orderBy('startdate','ASC')->get();
                                    }
                                    ?>
                                    @foreach($startdates as $index=>$startdate)
                                        <?php $addings = json_decode($startdate->addings) ?>
                                        <tr>
                                            <th>{!! $index+1 !!}</th>
                                            <th>{!! date_format(date_create($startdate->startdate),'d/m/Y') !!}</th>
                                            <td class="td-isEnd"><input type="checkbox"  data-id="{{ $startdate->id }}" class="isEnd" {{ $startdate->isEnd?'checked':'' }}></td>
                                            <td>{!! numbertomoney($startdate->adult_price)!!}</td>
                                            <td>
                                                @foreach($addings as $adding)
                                                <span>{{ $adding->name }}({{  numbertomoney($adding->price) }} {{  $adding->required==='true'?'-bắt buộc':''}})</span>;
                                                @endforeach
                                            </td>
                                            <td>{!! $startdate->seat !!}</td>
                                            <td>{{ $vehicles->filter(function ($value, $key) use ($startdate) { return $value->idtypeVehicle == $startdate->traffic;})->first()->vehicle }}</td>
                                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#StartDateModal" data-id="{!! $startdate->id !!}">
                                                    Sửa
                                                </button></td>
                                            <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#MiscalculateModal" data-id="{!! $startdate->id !!}">
                                                   Chiết tính
                                                </button></td>
                                        </tr>
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

        <!-- Button trigger modal -->
        @if($tour)
            <input value="{{ $tour->id }}" id="TourId" type="hidden"/>
        @endif
        @include('partials.startdatemodal')
        @include('partials.miscalculatemodal')
        @endif
@stop
@section('scripts')
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') !!}
    {!! HTML::script('js/bootstrap-datepicker.js') !!}
    {!! HTML::script('js/bootstrap-datepicker.vi.min.js', ['charset'=>'UTF-8']) !!}
    {!! HTML::script('js/jquery.inputmask.min.js') !!}
    {!! HTML::script('js/jquery.inputmask.numeric.extensions.min.js') !!}
    {!! HTML::script('js/staff.js') !!}
            {!! HTML::script('js/form.js') !!}
            {!! HTML::script('js/helper.js') !!}
    <script>
        function renderAddingAdd()
        {
            return $('<div class="adding-field">'+
                    '<label><i class="fa fa-close adding"></i> Phụ thu :</label>'+
                        '<div class="form-group input-group adding">'+
                    '<span class="input-group-addon">Loại :</span>'+
                    '<select name="addingcate[]">'+
                    '</select>'+
                    '</div>'+
                    '<div class="form-group input-group adding">'+
                    '<span class="input-group-addon">Số tiền :</span>'+
                    '<input type="text" class="form-control price moneymask" placeholder="Số tiền phụ thu" name="price[]" required>'+
                    '</div>'+
                    '</div>'


            );
        }
    </script>
@stop
@section('ready')

@stop