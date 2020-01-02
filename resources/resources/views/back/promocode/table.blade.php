	@foreach ($promocodes as $promocode)
		<tr >
			<td>{!! $promocode->code !!}</td>
			<td>{!! $promocode->startdate !== null ? $promocode->startdate->startdate : '' !!}</td>
			<td>{!! $promocode->startdate !== null ? ($promocode->startdate->tour !==null ?$promocode->startdate->tour->title : '') : '' !!}</td>
			<td>{!! numbertomoney($promocode->value) !!}</td>
			<td>{!! $promocode->order_id!!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['promocode.destroy', $promocode->id]]) !!}
				{!! Form::destroy(trans('back/promocodes.destroy'), trans('back/promocodes.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach