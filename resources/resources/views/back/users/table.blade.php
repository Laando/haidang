	@foreach ($users as $user)
		<tr {!! !$user->seen? 'class="warning"' : '' !!}>
			<td class="text-primary"><strong>{{ $user->username }}/{{ $user->phone }}</strong></td>
			<td>{{ $user->role->title }}</td>
			<td>{!! Form::checkbox('seen', $user->id, $user->seen) !!}</td>
			<td></td>
			<td>{!! link_to_route('user.edit', trans('back/users.edit'), [$user->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['user.destroy', $user->id]]) !!}
				{!! Form::destroy(trans('back/users.destroy'), trans('back/users.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach