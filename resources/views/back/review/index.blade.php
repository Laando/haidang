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

  @include('back.partials.entete', ['title' => trans('back/reviews.dashboard') . link_to_route('review.create', trans('back/reviews.add'), [], ['class' => 'btn btn-info pull-right']), 'icone' => 'send', 'fil' => link_to('admin', trans('back/admin.dashboard')) . ' / ' . trans('back/reviews.reviews')])


  @if(session()->has('ok'))
      @include('partials/error', ['type' => 'success', 'message' => session('ok')])
  @endif

  <div class="pull-right link">{!! $links !!}</div>

	<div class="table-responsive">
        {!! Form::open(['method' => 'GET', 'route' => 'review.index']) !!}
        <div class="col-md-12">
            <div class="col-md-12 col-xs-12">
                {!! Form::select('tour', $tourlist  , Request::get('tour')!=''?Request::get('tour'):null,array('class'=>'form-control')) !!}
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
					<th>{{ trans('back/reviews.tour') }}</th>
					<th>{{ trans('back/reviews.user') }}</th>
					<th>{{ trans('back/reviews.rating') }}</th>
					<th></th>
					<th></th>
                    <th></th>
				</tr>
			</thead>
			<tbody>
			  @include('back.review.table')
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
                url: 'review/sort/' + $(this).attr('name'),
                type: 'GET',
                dataType: 'json'
            })
                    .done(function(data) {
                        $('tbody').html(data.view);
                        $('.link').html(data.links);
                        $('#tempo').remove();
                    })
                    .fail(function() {
                        alert('{{ trans('back/reviews.fail') }}');
                    });
        });


    });

  </script>

@stop