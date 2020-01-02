@foreach($reviews as $re)
    <div class="media media-v2">
        <div class="media-body">
            <h4 class="media-heading">
                <strong>{!! $re->user_id==null?$re->name:$re->user->fullname !!}</strong> {!! date_format(date_create($re->created_at),'d/m/Y')!!}
                <small>
                    @for($i=0;$i<$re->rating;$i++)
                        <i class="fa fa-star"></i>
                    @endfor
                </small>
            </h4>
            <p>{!! $re->comment !!}</p>

        </div>
    </div><!--/end media media v2-->
@endforeach