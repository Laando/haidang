	@foreach ($banners as $banner)
		<tr >
			<td class="text-primary">
                <strong>{!! link_to_route('banner.edit',$banner->title,[$banner->id]) !!}</strong><br>
                {!! HTML::link('#fast-edit', 'Sửa nhanh', array('class' => 'fast-edit'))!!}
            </td>
			<td>{!! $banner->title !!}</td>
			<td>{!! $banner->alt !!}</td>
			<td>{!! $banner->url !!}</td>
			<td>{!! link_to_route('banner.edit', trans('back/banners.edit'), [$banner->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['banner.destroy', $banner->id]]) !!}
				{!! Form::destroy(trans('back/banners.destroy'), trans('back/banners.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach