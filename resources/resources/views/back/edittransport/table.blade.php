	@foreach ($edittransports as $edittransport)
		<tr >
			<td class="text-primary"><strong>{{ $edittransport->title }}</strong></td>
			<td>{!! $edittransport->seat !!}</td>
			<td>{!! numbertomoney($edittransport->price) !!}</td>
			<td></td>
			<td>{!! link_to_route('edittransport.edit', trans('back/edittransports.edit'), [$edittransport->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['edittransport.destroy', $edittransport->id]]) !!}
				{!! Form::destroy(trans('back/edittransports.destroy'), trans('back/edittransports.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach