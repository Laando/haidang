    @php
        $images = $tour->images ? explode(';', $tour->images) : [];
        $image = count($images) ? $images[count($images) - 2] : '';
        $image =  checkImage($image,true);
    @endphp
    <div class="col-md-6 col-lg-4 mb-2">
        <div class="img-card position-relative">
            <a href="{{ asset($tour->slug) }}">
                <figure style="background-image:url('/image/{{ $image }}')" class="bg-figure"></figure>
            </a>
            @if(isset($isGold))
                <?php
//                    $total_ticket = $tour->startdates->pipe(function ($collection) {
//                        return $collection->promotion_codes->count();
//                    });
//                    var_dump($total_ticket);
                ?>
            <div class="d-flex justify-content-between align-items-center p-3 position-absolute" style="top:0;width:100%">
                <p class="col-4 bg-page text-white p-2 text-uppercase rounded fs-12">Còn 2 vé</p>
                <p class="col-7 bg-page text-white p-2 text-uppercase rounded fs-12 eventTime"></p>
            </div>
            @endif
            @if(isset($destinationpoint))
                @php
                    $check_exist_image = false;
                    if($destinationpoint->icon != ''){
                        $file = public_path().('/image/chude_icon/'.$destinationpoint->icon);
                        $check_exist_image = file_exists($file);
                    }
                @endphp
                @if($check_exist_image)
                    <div class="item-event position-absolute ">
                        <p class="bannerchude-hd"><img src="{{ asset('') }}image/chude_icon/{{ $destinationpoint->icon }}"></p>
                    </div>
                @endif
            @endif
            <div class="tientour_hd">{{numbertomoney($tour->adultprice )}}</div>
        </div>
        <div class="card-body bg-xam p-0">
            <div class="p-1 tite-card-hd">{{ $tour->period }} | {{ $tour->traffic }} | {{ $tour->starhotel }} sao</div>
            <div class="card m-0 border-0 text-group-tour">
                <div class="cl-hdtitle card-text bg-xam text-center p-3 mb-0 boder-bottom-page">
                    <p style="text-overflow: ellipsis;display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;overflow: hidden;margin-bottom: 0;">
                        {{ $tour->title }}</p>
                </div>
                <div class="position-absolute bg-page p-3 show-tour" style="width:100%;height:100%">
                    <a class="navbar-brand mr-0  p-0" href="{{ asset($tour->slug) }}" aria-label="Bootstrap">
                        <img src="{{ asset('') }}images/icon-11.png" alt="user">
                    </a>

                </div>
            </div>
        </div>
    </div>