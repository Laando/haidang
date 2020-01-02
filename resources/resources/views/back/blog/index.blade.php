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

  @include('back.partials.entete', ['title' => trans('back/blogs.dashboard') . link_to_route('blog.create', trans('back/blogs.add'), [], ['class' => 'btn btn-info pull-right']), 'icone' => 'send', 'fil' => link_to('admin', trans('back/admin.dashboard')) . ' / ' . trans('back/blogs.blogs')])
 


	@if(session()->has('ok'))
    @include('partials/error', ['type' => 'success', 'message' => session('ok')])
	@endif

  <div class="pull-right link">{!! $links !!}</div>

	<div class="table-responsive">
        {!! Form::open(['method' => 'GET', 'route' => 'blog.index']) !!}
        <div class="col-md-12">
            <div class="col-md-4 col-xs-12">
                {!! Form::select('destinationpoint', $destinationlist  , Request::get('destinationpoint')!=''?Request::get('destinationpoint'):null,array('class'=>'form-control')) !!}

            </div>
            <div class="col-md-4 col-xs-12">
                {!! Form::select('subjectblog', $subjectlist  , Request::get('subjectblog')!=''?Request::get('subjectblog'):null,array('class'=>'form-control')) !!}
            </div>
            <div class="col-md-4 col-xs-12">
                {!! Form::text('search',  Request::get('search')!=''?Request::get('search'):null , array('class'=>'form-control','placeholder'=>'Tìm kiếm blog')) !!}
            </div>
        </div>
        <div class="col-md-12 text-center"><hr/></div>
        <div class="col-md-12 text-center">
            {!! Form::submit('Chọn')!!}
        </div>
        {!! Form::close() !!}
		<table class="table">
			<thead>
				<tr>
					<th>{{ trans('back/blogs.title') }}</th>
					<th>{{ trans('back/blogs.destinationpoint') }}</th>
					<th>{{ trans('back/blogs.subjectblog') }}</th>
					<th></th>
					<th></th>
                    <th></th>
				</tr>
			</thead>
			<tbody>
			  @include('back.blog.table')
      </tbody>
		</table>
	</div>

	<div class="pull-right link">{!! $links !!}</div>

@stop

@section('scripts')

  <script>
    
    $(function() {

      // Sorting gestion


    });

  </script>

@stop