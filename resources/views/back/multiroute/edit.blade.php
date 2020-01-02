
@extends('back.template')

@section('main')

    <!-- Entête de page -->
    @include('back.partials.entete', ['title' => trans('back/multiroutes.dashboard'), 'icone' => 'send', 'fil' => link_to('multiroute', trans('back/multiroutes.multiroutes')) . ' / ' . trans('back/multiroutes.creation')])
    <style>
        .clear {
            clear: both;
        }
    </style>
    <div class="col-sm-12">
        {!! Form::model($multiroute, ['route' => ['multiroute.update', $multiroute->id], 'method' => 'put', 'class' => 'form-horizontal panel']) !!}
        {!! Form::control('text', 0, 'title', $errors, trans('back/multiroutes.title')) !!}
        {!! Form::control('number', 0, 'total_day', $errors, trans('back/multiroutes.totalday')) !!}
        {!! Form::control('text', 0, 'transport_type', $errors, trans('back/multiroutes.transporttype')) !!}
        {!! Form::control('text', 0, 'start_time', $errors, trans('back/multiroutes.starttime')) !!}
        {!! Form::control('number', 0, 'start', $errors, trans('back/multiroutes.starttimestamp')) !!}
        {!! Form::selection('destinationpoint', $select, null, 'Tạo điểm liên tuyến') !!}
        <div class="col-md-12">
            <div class="col-md-2">
                {!! Form::control('number', 0, 'priority-point', $errors,null,null,null,'Thứ tự') !!}
            </div>
            <div class="col-md-1">
                &nbsp
            </div>
            <div class="col-md-2">
                {!! Form::control('number', 0, 'day-point', $errors ,null,null,null,'Số ngày') !!}
            </div>
            <div class="col-md-4">
                {!! Form::button('<i class="fa fa-plus"></i>',['id'=>'add-point']) !!}
            </div>
        </div>
        <hr/>
        <div>Các điểm đã chọn</div>
        <div id="result-point">
            @foreach($multiroute->multiroutepoints as $point)
            <div class="oldnode">
                <div class="pointname pull-left">{{ $point->destinationpoint->title  }}</div>
                <div class="pull-left">
                    <input type="hidden" name="oldid[]" value="{{ $point->id  }}"/>
                    <input type="hidden" name="oldpointid[]" value="{{ $point->destinationpoint->id  }}"/>
                    <div>
                        <input type="number" name="oldpointpriority[]" value="{{ $point->priority  }}"/>
                        <input type="number" name="oldpointday[]" value="{{ $point->day }}"/>
                        <button type="button" class="delOldMultiRoutePoint">Remove</button>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            @endforeach
        </div>
        {!! Form::submit('Chỉnh sửa') !!}
        {!! Form::close() !!}
    </div>

@stop

@section('scripts')
    {!! HTML::script('ckeditor/ckeditor.js') !!}
    {!! HTML::script('js/script.js') !!}
@stop
@section('styles')

@stop