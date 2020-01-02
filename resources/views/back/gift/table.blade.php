	@foreach ($gifts as $gift)
		<tr >
			<td class="text-primary"><strong>{{ $gift->title }}</strong></td>
			<td>{!! $gift->description !!}</td>
			<td>{!! $gift->priority !!}</td>
			<td></td>
			<td>{!! link_to_route('gift.edit', trans('back/gifts.edit'), [$gift->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['gift.destroy', $gift->id]]) !!}
				{!! Form::destroy(trans('back/gifts.destroy'), trans('back/gifts.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach