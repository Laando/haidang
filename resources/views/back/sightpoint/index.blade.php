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

  @include('back.partials.entete', ['title' => trans('back/sightpoints.dashboard') . link_to_route('sightpoint.create', trans('back/sightpoints.add'), [], ['class' => 'btn btn-info pull-right']), 'icone' => 'send', 'fil' => link_to('admin', trans('back/admin.dashboard')) . ' / ' . trans('back/sightpoints.sightpoints')])
 
  <div id="tri" class="btn-group btn-group-sm">
    <a href="#" type="button" name="total" class="btn btn-default active">{{ trans('back/sightpoints.all') }} <span class="badge">{{  $counts['total'] }}</span></a>
    @foreach ($destinationpoints as $destinationpoint)
      <a href="#" type="button" name="{!! $destinationpoint->id !!}" class="btn btn-default">{{ $destinationpoint->title  }} <span class="badge">{{ $counts[$destinationpoint->id] }}</span></a>
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
					<th>{{ trans('back/sightpoints.title') }}</th>
					<th>{{ trans('back/sightpoints.description') }}</th>
					<th>{{ trans('back/sightpoints.priority') }}</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			  @include('back.sightpoint.table')
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
          url: 'sightpoint/sort/' + $(this).attr('name'),
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
          alert('{{ trans('back/sightpoints.fail') }}');
        });        
      });

    });

  </script>
  {!! HTML::script('js/script.js') !!}
@stop