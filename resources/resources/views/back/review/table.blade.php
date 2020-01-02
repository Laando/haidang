	@foreach ($reviews as $review)
		<tr >
			<td class="text-primary">
                <strong>{!! link_to_route('review.edit',$review->tour->title,[$review->id]) !!}</strong><br>
            </td>
			<td>{!! isset($review->user)?$review->user->fullname:$review->name !!}</td>
			<td>{!! $review->rating !!}</td>
			<td></td>
			<td>{!! link_to_route('review.edit', trans('back/reviews.edit'), [$review->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
			<td>
				{!! Form::open(['method' => 'DELETE', 'route' => ['review.destroy', $review->id]]) !!}
				{!! Form::destroy(trans('back/reviews.destroy'), trans('back/reviews.destroy-warning')) !!}
				{!! Form::close() !!}
			</td>
		</tr>
	@endforeach