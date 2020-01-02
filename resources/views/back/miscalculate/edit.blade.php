
@extends('back.template')

@section('main')

    <!-- Entête de page -->
    @include('back.partials.entete', ['title' => trans('back/miscalculates.dashboard'), 'icone' => 'send', 'fil' => link_to('miscalculate', trans('back/miscalculates.miscalculates')) . ' / ' . trans('back/miscalculates.creation')])

    <div class="col-sm-12">
        {!! Form::model($miscalculate, ['route' => ['miscalculate.update', $miscalculate->id], 'method' => 'put', 'class' => 'form-horizontal panel']) !!}
        {!! Form::control('text', 0, 'title', $errors, trans('back/miscalculate.title')) !!}
        {!! Form::submit('Chỉnh sửa') !!}
        {!! Form::close() !!}
    </div>

@stop

@section('scripts')
    {!! HTML::script('js/script.js') !!}
@stop
@section('styles')

@stop