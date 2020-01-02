@extends('back.template')

@section('main')

 <!-- Entête de page -->
  @include('back.partials.entete', ['title' => trans('back/reviews.dashboard'), 'icone' => 'bus', 'fil' => link_to('review', trans('back/reviews.reviews')) . ' / ' . trans('back/reviews.creation')])
	<div class="col-sm-12">
		{!! Form::open(['url' => 'review', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
            <div class="col-md-12">
                <div class="panel panel-primary">
                <div class="panel-body">
                    {!! Form::selection('tour', $tourlist , null, trans('back/reviews.tour')) !!}
                    {!! Form::control('text', 0, 'user', $errors, trans('back/reviews.user')) !!}
                    {!! Form::control('number', 0, 'rating' ,$errors, trans('back/reviews.rating')) !!}
                    {!! Form::control('text', 0, 'comment', $errors, trans('back/reviews.comment')) !!}
                    {!! Form::control('text', 0, 'name', $errors, trans('back/reviews.name')) !!}
                    {!! Form::control('email', 0, 'email', $errors, trans('back/reviews.email')) !!}
                    <div class="form-group ">
                        Spam <input value="1" type="checkbox" name="spam" >
                    </div>
                </div>
                </div><!--End panel -->
            </div>
            <div class="col-sm-12">

			{!! Form::submit('Tạo mới') !!}
            </div>
		{!! Form::close() !!}
	</div>

@stop

@section('scripts')
    {!! HTML::script('ckeditor/ckeditor.js') !!}
    {!! HTML::script('js/bootstrap-datepicker.js') !!}
    {!! HTML::script('js/script.js') !!}
@stop
@section('styles')
    {!! HTML::style('css/datepicker.css') !!}
@stop