	@foreach ($meals as $meal)
		<tr >
			<td class="text-primary"><strong>{{ $meal->title }}</strong></td>
			<td>{!! $meal->seat !!}</td>
			<td></td>
			<td></td>
			<td>{!! link_to_route('meal.edit', trans('back/meals.edit'), [$meal->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['meal.destroy', $meal->id]]) !!}
				{!! Form::destroy(trans('back/meals.destroy'), trans('back/meals.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach