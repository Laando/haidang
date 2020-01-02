	@foreach ($hotels as $hotel)
		<tr >
			<td class="text-primary">
                <strong>{!! link_to_route('hotel.edit',$hotel->title,[$hotel->id]) !!}</strong><br>
            </td>
			<td>{!! $hotel->phone !!}</td>
			<td></td>
			<td></td>
			<td>{!! link_to_route('hotel.edit', trans('back/hotels.edit'), [$hotel->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['hotel.destroy', $hotel->id]]) !!}
				{!! Form::destroy(trans('back/hotels.destroy'), trans('back/hotels.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach