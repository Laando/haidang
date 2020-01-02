	@foreach ($miscalculates as $miscalculate)
		<tr >
			<td class="text-primary"><strong>{{ $miscalculate->title }}</strong></td>
			<td></td>
			<td></td>
			<td>{!! link_to_route('miscalculate.edit', trans('back/miscalculates.edit'), [$miscalculate->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['miscalculate.destroy', $miscalculate->id]]) !!}
				{!! Form::destroy(trans('back/miscalculates.destroy'), trans('back/miscalculates.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach