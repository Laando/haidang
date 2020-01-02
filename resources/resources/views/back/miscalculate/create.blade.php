@extends('back.template')

@section('main')

 <!-- Entête de page -->
  @include('back.partials.entete', ['title' => trans('back/miscalculates.dashboard'), 'icone' => 'send', 'fil' => link_to('miscalculate', trans('back/miscalculates.miscalculates')) . ' / ' . trans('back/miscalculates.creation')])

	<div class="col-sm-12">
		{!! Form::open(['url' => 'miscalculate', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
			{!! Form::control('text', 0, 'title', $errors, trans('back/miscalculates.title')) !!}
			{!! Form::submit('Tạo mới') !!}
		{!! Form::close() !!}
	</div>

@stop

@section('scripts')
    {!! HTML::script('js/script.js') !!}
@stop
@section('styles')

@stop