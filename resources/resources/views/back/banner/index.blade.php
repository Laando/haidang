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

  @include('back.partials.entete', ['title' => trans('back/banners.dashboard') . link_to_route('banner.create', trans('back/banners.add'), [], ['class' => 'btn btn-info pull-right']), 'icone' => 'send', 'fil' => link_to('admin', trans('back/admin.dashboard')) . ' / ' . trans('back/banners.banners')])

  <div id="tri" class="btn-group btn-group-sm">
      <a href="#" type="button" name="total" class="btn btn-default active">{{ trans('back/banners.all') }} <span class="badge">{{  $counts['total'] }}</span></a>
      @foreach ($types as $key=>$value)
          @if(array_key_exists($key, $counts))
          <a href="#" type="button" name="{!! $key !!}" class="btn btn-default">{{ $value  }} <span class="badge">{{ $counts[$key] }}</span></a>
          @endif
      @endforeach
  </div>

  @if(session()->has('ok'))
      @include('partials/error', ['type' => 'success', 'message' => session('ok')])
  @endif

  <div class="pull-right link">{!! $links !!}</div>

	<div class="table-responsive">
        {!! Form::open(['method' => 'GET', 'route' => 'banner.index']) !!}
        {!! Form::close() !!}
		<table class="table">
			<thead>
				<tr>
					<th>{{ trans('back/banners.title') }}</th>
					<th>{{ trans('back/banners.alt') }}</th>
					<th>{{ trans('back/banners.url') }}</th>
					<th></th>
					<th></th>
                    <th></th>
				</tr>
			</thead>
			<tbody>
			  @include('back.banner.table')
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
                url: 'banner/sort/' + $(this).attr('name'),
                type: 'GET',
                dataType: 'json'
            })
                    .done(function(data) {
                        $('tbody').html(data.view);
                        $('.link').html(data.links);
                        $('#tempo').remove();
                    })
                    .fail(function() {
                        alert('{{ trans('back/banners.fail') }}');
                    });
        });


    });

  </script>

@stop