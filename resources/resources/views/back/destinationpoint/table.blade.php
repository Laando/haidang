	@foreach ($destinationpoints as $destinationpoint)
		<tr >
			<td class="text-primary"><strong>{{ $destinationpoint->title }}</strong></td>
			<td>{!! $destinationpoint->description !!}</td>
			<td>{!! $destinationpoint->priority !!}</td>
			<td></td>
			<td>{!! link_to_route('destinationpoint.edit', trans('back/destinationpoints.edit'), [$destinationpoint->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['destinationpoint.destroy', $destinationpoint->id]]) !!}
				{!! Form::destroy(trans('back/destinationpoints.destroy'), trans('back/destinationpoints.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach