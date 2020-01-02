@extends('back.template')

@section('main')

  @include('back.partials.entete', ['title' => trans('back/regions.dashboard'), 'icone' => 'th-large', 'fil' => link_to('admin', trans('back/admin.dashboard')) . ' / ' . trans('back/regions.regions')])

	<div class="col-sm-12">
		@if(session()->has('ok'))
			@include('partials.error', ['type' => 'success', 'message' => session('ok')])
		@endif
		{!! Form::open(['url' => 'regions', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
			@foreach ($regions as $region)
				{!! Form::control('text', 8, $region->id, $errors, trans('back/regions.' . $region->id), $region->title) !!}
            <div class="form-group col-lg-4">
                {!!  trans('back/regions.outbound') !!}
                <br/>
                {!! Form::checkbox('isOutbound_'.$region->id, 1,$region->isOutbound == 1 ? true : null , ['class' => 'field']) !!}
            </div>

			@endforeach
            <div class="clearfix"></div>
			{!! Form::submit(trans('front/form.send')) !!}
		{!! Form::close() !!}
	</div>

@stop