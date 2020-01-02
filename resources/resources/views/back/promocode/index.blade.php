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

  @include('back.partials.entete', ['title' => trans('back/promocodes.dashboard') . link_to_route('promocode.create', trans('back/promocodes.add'), [], ['class' => 'btn btn-info pull-right']), 'icone' => 'send', 'fil' => link_to('admin', trans('back/admin.dashboard')) . ' / ' . trans('back/regions.regions')])
 


	@if(session()->has('ok'))
    @include('partials/error', ['type' => 'success', 'message' => session('ok')])
	@endif

  <div class="pull-right link">{!! $links !!}</div>

	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>Tên Mã</th>
					<th>Ngày khởi hành</th>
					<th>Tour</th>
					<th>Giá trị</th>
					<th>Mã đơn hàng</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			  @include('back.promocode.table')
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