@extends('back.template')
@section('styles')
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') !!}
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') !!}
@stop
@section('main')

 <!-- Entête de page -->
  @include('back.partials.entete', ['title' => trans('back/users.dashboard'), 'icone' => 'user', 'fil' => link_to('user', trans('back/users.Users')) . ' / ' . trans('back/users.creation')])
 @if (count($errors) > 0)
     <div class="alert alert-danger">
         <strong>Đăng ký của bạn có lỗi</strong>
         <ul>
             @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
             @endforeach
         </ul>
     </div>
 @endif
	<div class="col-sm-12">
		{!! Form::open(['url' => 'user', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}	
			{!! Form::control('text', 0, 'username', $errors, trans('back/users.name')) !!}
			{!! Form::control('email', 0, 'email', $errors, trans('back/users.email')) !!}
			{!! Form::control('password', 0, 'password', $errors, trans('back/users.password')) !!}
			{!! Form::control('password', 0, 'password_confirmation', $errors, trans('back/users.confirm-password')) !!}
            {!! Form::control('text', 0, 'fullname', $errors, trans('back/users.fullname')) !!}
            {!! Form::control('number', 0, 'phone', $errors, trans('back/users.phone')) !!}
            {!! Form::control('text', 0, 'member_card', $errors, 'Member Card') !!}
            {!! Form::selection('member_card_type', $select_card_type, 0 , 'Loại Member Card') !!}
            <div class="form-group">
                <label for="dob" class="control-label">Năm sinh</label>
                {!! Form::text('dob','',array('class'=>'form-control datepicker')) !!}
            </div>
            {!! Form::control('text', 0, 'address', $errors, trans('back/users.address')) !!}
            <div class="form-group ">
                <label for="gender" class="control-label">Giới tính</label>
                {!! Form::select('gender', array('1' => 'Nam', '2' => 'Nữ','3'=>'Khác'),null,array('class'=>'form-control')) !!}
            </div>
            {!! Form::control('text', 0, 'yahoo', $errors, 'Yahoo') !!}
            {!! Form::control('text', 0, 'skype', $errors, 'Skype') !!}
            {!! Form::control('text', 0, 'facebook', $errors, 'Facebook') !!}
            <div class="form-group col-lg-12">
                <label></label>
                {!! Form::checkbox('status', '1', true );!!} Trạng thái hoạt động
            </div>
            <div class="form-group col-lg-12">
                <label></label>
                {!! Form::checkbox('getmail', '1', true );!!} Nhận mail từ Hải Đăng Travel
            </div>
			{!! Form::selection('role', $select, null, trans('back/users.role')) !!}
			{!! Form::submit(trans('front/form.send')) !!}
		{!! Form::close() !!}
	</div>

@stop

@section('scripts')
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') !!}
    {!! HTML::script('assets/js/plugins/datepicker.js') !!}
@stop
@section('styles')
    {!! HTML::style('css/datepicker.css') !!}
@stop
@section('ready')
    $('.datepicker').datepicker({
    dateFormat: 'dd/mm/yy',
    prevText: '<i class="fa fa-angle-left"></i>',
    nextText: '<i class="fa fa-angle-right"></i>',
    });
@stop