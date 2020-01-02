	@foreach ($subjectblogs as $subjectblog)
		<tr >
			<td class="text-primary"><strong>{{ $subjectblog->title }}</strong></td>
			<td>{!! $subjectblog->description !!}</td>
			<td>{!! $subjectblog->priority !!}</td>
			<td></td>
			<td>{!! link_to_route('subjectblog.edit', trans('back/subjectblogs.edit'), [$subjectblog->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['subjectblog.destroy', $subjectblog->id]]) !!}
				{!! Form::destroy(trans('back/subjectblogs.destroy'), trans('back/subjectblogs.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach