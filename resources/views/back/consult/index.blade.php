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

  @include('back.partials.entete', ['title' => trans('back/consult.dashboard') , 'icone' => 'send', 'fil' => link_to('admin', trans('back/admin.dashboard')) . ' / ' . trans('back/consult.title')])
 


	@if(session()->has('ok'))
    @include('partials/error', ['type' => 'success', 'message' => session('ok')])
	@endif

  <div class="pull-right link">{!! $links !!}</div>

	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>{{ trans('back/consult.tour') }}</th>
					<th>Ngày yêu cầu</th>
					<th>{{ trans('back/consult.user') }}</th>
					<th>{{ trans('back/consult.phone') }}</th>
					<th>{{ trans('back/consult.status') }}</th>
                    <th></th>
				</tr>
			</thead>
			<tbody>
			  @include('back.consult.table')
      </tbody>
		</table>
	</div>

	<div class="pull-right link">{!! $links !!}</div>

@stop

@section('scripts')

  <script>
    var activitied= false;
    var timeout = null;
    $(function() {
        $(document).on('mousemove', function() {
            activitied = true;
        });
        timeout = setInterval(function() {
            if(activitied===false){
                location.reload(); // reload sau 3s mouse để yên
            }
            activitied=false;
        }, 5000);
      // Sorting gestion
    });

  </script>

@stop