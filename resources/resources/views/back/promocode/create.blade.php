@extends('back.template')

@section('main')

 <!-- Entête de page -->
  @include('back.partials.entete', ['title' => trans('back/promocodes.dashboard'), 'icone' => 'send', 'fil' => link_to('promocode', trans('back/promocodes.promocodes')) . ' / ' . trans('back/promocodes.creation')])

	<div class="col-sm-12">
		{!! Form::open(['url' => 'promocode', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
            <div class="form-group  col-md-6">
                <label for="code" class="control-label">Mã</label>
                <input class="form-control " placeholder="" name="code" type="text" id="code">
            </div>
            <div class="form-group  col-md-6">
                <div>
                    <button type="button" onclick="GeneratePromoCode()"> Tạo mã </button>
                </div>
            </div>
            {!! Form::control('number', 0, 'value', $errors, 'Giá trị') !!}
			{!! Form::submit('Tạo mới') !!}
		{!! Form::close() !!}
	</div>

@stop

@section('scripts')
    {!! HTML::script('js/script.js') !!}
@stop
@section('styles')

@stop