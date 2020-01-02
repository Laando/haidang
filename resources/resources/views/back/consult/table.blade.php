	@foreach ($consults as $consult)
		<tr >
			<td>{!! $consult->tour_id!=NULL?($consult->tour!=NULL ?$consult->tour->title:'Tour đã bị xóa mã id là :'.$consult->tour_id ):''!!}</td>
			<td>{!! date_format(date_create($consult->created_at), 'Y-m-d H:i:s') !!}</td>
			<td>{!! $consult->user!=NULL?($consult->user->phone):'' !!}</td>
			<td>{!! $consult->phone!=NULL?($consult->phone):'' !!}</td>
			<td>{!! $consult->is_check==1?'<span style="color:blue">Đã tư vấn</span>':'<span style="color:red;font-weight:bold">Đang đợi</span>' !!}</td>
			<td>
				@if(auth()->user()->isAdmin())
				{!! Form::open(['method' => 'DELETE', 'route' => ['consult.destroy', $consult->id]]) !!}
				{!! Form::destroy(trans('back/consult.destroy'), trans('back/consult.destroy-warning')) !!}
				{!! Form::close() !!}
				@endif
			</td>
			<td>
				{!! Form::open(['method' => 'POST', 'route' => ['consult.check', $consult->id]]) !!}
				{!! Form::destroy(trans('back/consult.check'), trans('back/consult.check-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach