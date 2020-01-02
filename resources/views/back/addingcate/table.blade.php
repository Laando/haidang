	@foreach ($addingcates as $addingcate)
		<tr >
			<td class="text-primary"><strong>{{ $addingcate->title }}</strong></td>
			<td>{!! $addingcate->seat !!}</td>
			<td></td>
			<td></td>
			<td>{!! link_to_route('addingcate.edit', trans('back/addingcates.edit'), [$addingcate->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['addingcate.destroy', $addingcate->id]]) !!}
				{!! Form::destroy(trans('back/addingcates.destroy'), trans('back/addingcates.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach