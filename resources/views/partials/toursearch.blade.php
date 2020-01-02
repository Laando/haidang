    <?php
        $images = $tour->images ? explode(';', $tour->images) : [];
        $image = count($images) ? $images[count($images) - 2] : '';
    ?>
    @if(isset($inCate))
    <div class="col-md-4 col-sm-4 in_tourcate">
    @endif
    <div class="tours-layout slzexploore_tour">
        <div class="image-wrapper">
            <a class="link" href="{{ asset($tour->slug) }}"><img width="400" height="270" src="{{$image ? asset('image/' . $image) : asset('image/no-photo.jpg')}}" class="img-responsive" alt="{!! $tour->title !!}" srcset="{!! asset('image/'.$image) !!}" sizes="(max-width: 400px) 100vw, 400px" />
            </a>
            <div class="title-wrapper">
                <div class="tags">
                    <ul class="list-inline list-unstyled list-tags">
                        @foreach($tour->subjecttours() as $sjt)
                        <li><a href="{{ asset('diem-den/'.$sjt->slug) }}" class="tag-item" tabindex="0">{{ $sjt->title }}</a></li>
                        @endforeach()
                    </ul>
                </div>
            </div>
            @if(isset($current_sjt))
                @if($current_sjt->icon!='')
                <div class="ribbon-sale">
                    <img src="{{asset('image/chude_icon/'.$current_sjt->icon)}}"/>
                </div>
                @endif
            @endif
        </div>
        <div class="content-wrapper">
            <ul class="list-info list-inline list-unstyle">
                <li class="view"><a href="" class="link"><span class="text number">{{ $tour->period }}</span></a></li>
                <li class="wishlist"><a href="" class="link list-wist"><span class="text number">{{ $tour->starhotel }} sao</span></a></li>
                <li class="comment"><a href="" class="link"><span class="text number">{{ $tour->traffic }}</span></a></li>
            </ul>
            <div class="content">
                <div class="title">
                    <div class="price">
                        <?php
                            $countst =     $tour->startdates()->where('startdate','>',new \DateTime())->count();
                            //$view_price =  $countst==0?'Tạm dừng':numbertomoney($tour->adultprice) ;
                        ?>
                        <span class="number">{!! $tour->adultprice==0?'Tạm dừng':numbertomoney($tour->adultprice ) !!}</span>
                    </div>
                </div>
                <div class="text">{{ $tour->title }}</div>
                <div class="group-btn-tours"><a href="{{ asset($tour->slug) }}" class="left-btn">Xem Ngay</a></div>
            </div>
        </div>
    </div>
    @if(isset($inCate))
    </div>
    @endif