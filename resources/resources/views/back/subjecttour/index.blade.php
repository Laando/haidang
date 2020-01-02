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

  @include('back.partials.entete', ['title' => trans('back/subjecttours.dashboard') . link_to_route('subjecttour.create', trans('back/subjecttours.add'), [], ['class' => 'btn btn-info pull-right']), 'icone' => 'send', 'fil' => link_to('admin', trans('back/admin.dashboard')) . ' / ' . trans('back/regions.regions')])
 


	@if(session()->has('ok'))
    @include('partials/error', ['type' => 'success', 'message' => session('ok')])
	@endif

  <div class="pull-right link">{!! $links !!}</div>

	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>{{ trans('back/subjecttours.title') }}</th>
					{{--<th>{{ trans('back/subjecttours.description') }}</th>--}}
					<th>{{ trans('back/subjecttours.priority') }}</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			  @include('back.subjecttour.table')
      </tbody>
		</table>
	</div>

	<div class="pull-right link">{!! $links !!}</div>

@stop

@section('scripts')

  <script>
    
    $(function() {




    });

  </script>

@stop