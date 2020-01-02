	@foreach ($blogs as $blog)
		<tr >
			<td class="text-primary">
                <strong>{!! link_to_route('blog.edit',$blog->title,[$blog->id]) !!}</strong><br>
                {!! HTML::link('#fast-edit', 'Sửa nhanh', array('class' => 'fast-edit'))!!}
            </td>
			<td>{!! $blog->destinationpoint->title !!}</td>
			<td>{!! implode(";",$blog->subjectblogs->pluck('title')->all()) !!}</td>
			<td></td>
			<td>{!! link_to_route('blog.edit', trans('back/blogs.edit'), [$blog->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['blog.destroy', $blog->id]]) !!}
				{!! Form::destroy(trans('back/blogs.destroy'), trans('back/blogs.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach