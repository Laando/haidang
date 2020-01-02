	@foreach ($cars as $car)
		<tr >
			<td class="text-primary"><strong>{{ $car->title }}</strong></td>
			<td>{!! $car->supportphone !!}</td>
			<td></td>
			<td></td>
			<td>{!! link_to_route('car.edit', trans('back/cars.edit'), [$car->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['car.destroy', $car->id]]) !!}
				{!! Form::destroy(trans('back/cars.destroy'), trans('back/cars.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach