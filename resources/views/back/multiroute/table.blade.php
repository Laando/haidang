	@foreach ($multiroutes as $multiroute)
		<tr >
			<td class="text-primary"><strong>{{ $multiroute->title }}</strong></td>
			<td>{!! $multiroute->total_day !!}</td>
			<td>
                @foreach($multiroute->multiroutepoints as $point)
                    {!! $point->destinationpoint->title.' - ' !!}
                @endforeach
            </td>
			<td></td>
			<td>{!! link_to_route('multiroute.edit', trans('back/multiroutes.edit'), [$multiroute->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['multiroute.destroy', $multiroute->id]]) !!}
				{!! Form::destroy(trans('back/multiroutes.destroy'), trans('back/multiroutes.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach