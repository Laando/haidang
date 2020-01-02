<?php
$user = Auth::user();
?>
@extends('back.template')

@section('head')

<style type="text/css">
  
  .badge {
    padding: 1px 8px 1px;
    background-color: #aaa !important;
  }

</style>

@stop

@section('main')
  @include('back.partials.entete', ['title' => trans('back/tours.dashboard') . link_to_route('tour.create', trans('back/tours.add'), [], ['class' => 'btn btn-info pull-right']), 'icone' => 'send', 'fil' => link_to('admin', trans('back/admin.dashboard')) . ' / ' . trans('back/tours.tours')])



	@if(session()->has('ok'))
    @include('partials/error', ['type' => 'success', 'message' => session('ok')])
	@endif
  @if($user->role->slug=='admin')
  <div class="col-md-12">
      <h2>Điền GOOGLE ADS vào tour</h2>
      <div class="col-md-5">
          <input id="tour-name" class="form-control" type="text" name="tour-name" placeholder="Điền vào tên tour" />
      </div>
      <div class="col-md-5">
          <input id="tour-ads" class="form-control" type="text" name="tour-ads" placeholder="Điền vào mã"/>
      </div>
      <div class="col-md-2">
          <button id="send-ads" class="btn btn-primary">Nhập</button>
      </div>
      <div class="col-md-12 alert fade" id="ads-result" alert-dismissible role="alert">
          <button type="button" class="close" data-dismiss="alert">
              <span aria-hidden="true">&times;</span>
              <span class="sr-only">Close</span>
          </button>
          <span class="result"></span>
      </div>
  </div>
  @endif
  <hr/>
  <div class="pull-right link">{!! $links !!}</div>
	<div class="table-responsive">
        {!! Form::open(['method' => 'GET', 'route' => 'tour.index']) !!}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-md-12">
            <div class="col-md-4 col-xs-12">
                {!! Form::select('user', $stafflist  , Request::get('user')!=''?Request::get('user'):null,array('class'=>'form-control')) !!}

            </div>
            <div class="col-md-4 col-xs-12">
                {!! Form::select('subjecttour', $subjectlist  , Request::get('subjecttour')!=''?Request::get('subjecttour'):null,array('class'=>'form-control')) !!}
            </div>
            <div class="col-md-4 col-xs-12">
                {!! Form::text('search',  Request::get('search')!=''?Request::get('search'):null , array('class'=>'form-control','placeholder'=>'Tìm kiếm tour')) !!}
            </div>
        </div>
        <div class="col-md-12 text-center"><hr/></div>
        <div class="col-md-12 text-center">
            {!! Form::submit('Chọn')!!}
        </div>
        {!! Form::close() !!}
        <div class="clearfix"></div>
		<table class="table">
			<thead>
				<tr>
					<th>{{ trans('back/tours.title') }}</th>
					<th>{{ trans('back/tours.user') }}</th>
					<th>{{ trans('back/tours.homepage') }}</th>
					<th></th>
					<th></th>
          <th></th>
				</tr>
			</thead>
			<tbody>
			  @include('back.tour.table')
      </tbody>
		</table>
	</div>

	<div class="pull-right link">{!! $links !!}</div>

@stop

@section('scripts')

  <script>
    
    $(function() {
      $('#send-ads').click(function(){
          var token = $('input[name="_token"]').val();
            var tour_name = $('#tour-name').val();
            var tour_ads = $('#tour-ads').val();
          $.ajax({
              url:'http://'+window.location.host+'/function/updateTourAds',
              type: "POST",
              data: { tour_name : tour_name,_token:token,tour_ads:tour_ads },
              success: function(data, textStatus, jqXHR) {
                  if(data=='ok') {
                      $('#ads-result').removeClass('alert-danger');
                      $('#ads-result').addClass('alert-success');
                      $('#ads-result').addClass('in');
                      $('#ads-result').text('Cập nhật ads cho tour "'+tour_name+'" thành công !');
                  } else {
                      $('#ads-result').removeClass('alert-succes');
                      $('#ads-result').addClass('alert-danger');
                      $('#ads-result').addClass('in');
                      $('#ads-result').text(data);
                  }
              }

          });
      });
    });

  </script>

@stop