	@foreach ($subjecttours as $subjecttour)
		<tr >
			<td class="text-primary"><strong>{{ $subjecttour->title }}</strong></td>
			{{--<td>{!! $subjecttour->priority !!}</td>--}}
			<td></td>
			<td>{!! link_to_route('subjecttour.edit', trans('back/subjecttours.edit'), [$subjecttour->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['subjecttour.destroy', $subjecttour->id]]) !!}
				{!! Form::destroy(trans('back/subjecttours.destroy'), trans('back/subjecttours.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach