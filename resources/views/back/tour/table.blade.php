	@foreach ($tours as $tour)
		<tr >
			<td class="text-primary">
                <strong>{!! link_to_route('tour.edit',$tour->title,[$tour->id]) !!}</strong><br>
                {!! HTML::link(asset($tour->slug), $tour->slug, array('class' => 'fast-edit'))!!}
            </td>
			<td>{!! $tour->user==null?'':$tour->user->fullname !!}</td>
			<td><input type="checkbox" readonly="readonly" {!! $tour->homepage==1?'checked="checked"':'' !!} /></td>
			<td></td>
			<td>{!! link_to_route('tour.edit', trans('back/tours.edit'), [$tour->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			@if($user->role->slug == 'admin')
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['tour.destroy', $tour->id]]) !!}
				{!! Form::destroy(trans('back/tours.destroy'), trans('back/tours.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
			@endif
		</tr>
	@endforeach