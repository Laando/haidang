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

  @include('back.partials.entete', ['title' => trans('back/destinationpoints.dashboard') . link_to_route('destinationpoint.create', trans('back/destinationpoints.add'), [], ['class' => 'btn btn-info pull-right']), 'icone' => 'send', 'fil' => link_to('admin', trans('back/admin.dashboard')) . ' / ' . trans('back/destinationpoints.destinationpoints')])

  <div id="tri" class="btn-group btn-group-sm">
    <a href="#" type="button" name="total" class="btn btn-default active">{{ trans('back/destinationpoints.all') }} <span class="badge">{{  $counts['total'] }}</span></a>
    @foreach ($regions as $region)
      <a href="#" type="button" name="{!! $region->id !!}" class="btn btn-default">{{ $region->title  }} <span class="badge">{{ $counts[$region->id] }}</span></a>
    @endforeach
  </div>

	@if(session()->has('ok'))
    @include('partials/error', ['type' => 'success', 'message' => session('ok')])
	@endif

  <div class="pull-right link">{!! $links !!}</div>

	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>{{ trans('back/destinationpoints.title') }}</th>
					<th>{{ trans('back/destinationpoints.description') }}</th>
					<th>{{ trans('back/destinationpoints.priority') }}</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			  @include('back.destinationpoint.table')
      </tbody>
		</table>
	</div>

	<div class="pull-right link">{!! $links !!}</div>

@stop

@section('scripts')

  <script>

    $(function() {

      // Sorting gestion
      $('#tri').find('a').click(function(e) {
        e.preventDefault();
        // Wait icon
        $('.breadcrumb li').append('<span id="tempo" class="fa fa-refresh fa-spin"></span>');
        // Buttons aspect
        $('#tri').find('a').removeClass('active');
        // Send ajax
        $.ajax({
          url: 'destinationpoint/sort/' + $(this).attr('name'),
          type: 'GET',
          dataType: 'json'
        })
        .done(function(data) {
          $('tbody').html(data.view);
          $('.link').html(data.links);
          $('#tempo').remove();
          makePageLink();
        })
        .fail(function() {
          alert('{{ trans('back/destinationpoints.fail') }}');
        });        
      });

    });

  </script>
  {!! HTML::script('js/script.js') !!}
@stop