	@foreach ($configs as $config)
		<tr >
			<td class="text-primary">
                <strong>{!! link_to_route('config.edit',$config->title,[$config->id]) !!}</strong><br>
                {!! HTML::link('#fast-edit', 'Sửa nhanh', array('class' => 'fast-edit'))!!}
            </td>
			<td>{!! $config->type!!}</td>
			<td><input type="checkbox" {{ $config->is_page == 1 ? 'checked' : '' }}/></td>
			<td></td>
			<td>{!! link_to_route('config.edit', trans('back/configs.edit'), [$config->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['config.destroy', $config->id]]) !!}
				{!! Form::destroy(trans('back/configs.destroy'), trans('back/configs.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach