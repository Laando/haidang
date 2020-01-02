	@foreach ($sightpoints as $sightpoint)
		<tr >
			<td class="text-primary"><strong>{{ $sightpoint->title }}</strong></td>
			<td>{!! $sightpoint->description !!}</td>
			<td>{!! $sightpoint->priority !!}</td>
			<td></td>
			<td>{!! link_to_route('sightpoint.edit', trans('back/sightpoints.edit'), [$sightpoint->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['sightpoint.destroy', $sightpoint->id]]) !!}
				{!! Form::destroy(trans('back/sightpoints.destroy'), trans('back/sightpoints.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach