	@foreach ($sourcepoints as $sourcepoint)
		<tr >
			<td class="text-primary"><strong>{{ $sourcepoint->title }}</strong></td>
			<td>{!! $sourcepoint->description !!}</td>
			<td>{!! $sourcepoint->priority !!}</td>
			<td></td>
			<td>{!! link_to_route('sourcepoint.edit', trans('back/sourcepoints.edit'), [$sourcepoint->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['sourcepoint.destroy', $sourcepoint->id]]) !!}
				{!! Form::destroy(trans('back/sourcepoints.destroy'), trans('back/sourcepoints.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach