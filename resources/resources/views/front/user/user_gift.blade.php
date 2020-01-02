@extends('front.template')
@section('title')
    <title>{!! $seotitle !!}</title>
@stop
@section('meta')
    <meta name="keywords" content="{!! $seokeyword !!}" />
    <meta name="description" content="{!! $seodescription !!}" />
    <meta name="og:title" content="{!! $seotitle !!}"/>
    <meta name="og:image" content="{!!asset('assets/img/logo1-default.png')!!}"/>
    <meta name="og:description" content="{!! $seodescription !!}"/>
    <meta name="DC.title" content="{!! $seotitle !!}">
    <meta name="DC.subject" content="{!! $seodescription !!}">
    <!-- Facebook Conversion Code for Đăng ký - FB- 20/08/2015 -->
    <script>(function() {
            var _fbq = window._fbq || (window._fbq = []);
            if (!_fbq.loaded) {
                var fbds = document.createElement('script');
                fbds.async = true;
                fbds.src = '//connect.facebook.net/en_US/fbds.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(fbds, s);
                _fbq.loaded = true;
            }
        })();
        window._fbq = window._fbq || [];
        window._fbq.push(['track', '6032628477009', {'value':'0.00','currency':'VND'}]);
    </script>
    <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6032628477009&amp;cd[value]=0.00&amp;cd[currency]=VND&amp;noscript=1" /></noscript>
@stop
@section('styles')
    <!-- Include Editor plugins CSS style. -->

@stop
@section('main')
<main>
    <div class="col-lg-11 col-12 container px-xs-0">
        <div class="banner position-relative zindex-fixed mta75" style="z-index: 3;margin-top: -50px;">
            <div class="bannertop owl-carousel nav-none owl-theme">
                <?php
                $user = auth()->user();
                $expiresAt = \Carbon\Carbon::now()->addMinutes(10);
                $usergift_banner = \Illuminate\Support\Facades\Cache::remember('usergift_banner', $expiresAt, function () {
                    return \App\Models\Banner::where('type', 'like', 'usergift_banner')->orderBy('priority', 'ASC')->get();
                });
                ?>
                @foreach($usergift_banner as $banner)
                    @php
                        if($agent->isMobile()){
                            $banner->images = imgageMobile($banner->images , 600 , 400);
                        }
                    @endphp
                    <a href="{{ $banner->url }}"><img src="{{ asset('image/'.$banner->images) }}" class="banner-home img-fluid w-100" alt="{{ $banner->title }}"></a>
                @endforeach
            </div>
        </div>
        <div class="mt-lg-5 mt-3">
            @if($user !== null)
            <h6 class="mt-3">SỐ ĐIỂM ĐANG CÓ <span class="h4 ff5400">{{ thousandsep($user->point) }}</span> ĐIỂM</h6>
            @else
                <form class="form-inline mb-4 pt-3 pb-3 pl-4 pr-4" style="background:#fe7a64">
                    <label for="" class="mr-lg-5 mr-md-2">KIỂM TRA SỐ ĐIỂM BẠN ĐANG CÓ</label>
                    <div class="form-group mr-lg-5 mr-md-2 w-md-50 wline-sm-100" style="width:55%">
                        <input id="CheckPointPhone" type="text" class="form-control rounded-0 " placeholder="NHẬP SỐ ĐIỆN THOẠI" style="width:100%" />
                    </div>
                    <div class="alert alert-danger" style="display: none;">
                        <strong>Có lỗi !</strong>
                        <ul>
                            <li class="ErrorConssult"></li>
                        </ul>
                    </div>
                    <div class="alert alert-info" style="display: none;">
                        <strong>Số điểm : </strong>
                        <ul>
                            <li class="PointResult"></li>
                        </ul>
                    </div>
                    <button type="button" class="btn rounded-0 text-white pl-md-3 pr-md-3 pl-lg-5 pr-lg-5 m-lg-0 m-auto" style="background-color:#f9381e" onclick="CheckPoint(this)">KIỂM TRA</button>
                </form>
            @endif
        </div>
        <div class="mb-3 text-md-left text-center">
            <h4>DANH SÁCH QUÀ TẶNG</h4>
        </div>
        <div class="content bg-efefef p-3">
            <div class="row">
                @foreach($gifts as $gift)
                    @php
                        $images = $gift->images ? explode(';', $gift->images) : [];
                        $image = count($images) ? $images[count($images) - 2] : '';
                        $image =  checkImage($image,true);
                    @endphp
                <div class="col-lg-4 col-md-6">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" src="{{ asset('image/'.$image) }}" alt="Thumbnail [100%x225]" style="height: 150px; width: 100%; display: block;" data-holder-rendered="true">
                        <div class="card-body p-3">
                            <p class="card-text text-center">{{ $gift->title }}</p>
                            <div class="text-right mb-2">
                                <a data-gift-id="{{ $gift->id }}"  class="p-2 text-white" data-toggle="modal"
                                   data-target="#confirmGiftModal" style="background-color:#f9381e">
                                    <img src="{{ asset('images') }}/coin.png" style="margin-top:-2px" width="20" height="20">{{ thousandsep($gift->point ) }}<span class="pr-2 pl-2">&Iota;</span>ĐỔI
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="bg-efefef p-2 d-sm-none d-block">
        <div class="text-center w-100">
            <p class="font-weight-bold flex-nowrap">Ưu đãi khi sử dụng Haidangtravel App</p>
        </div>
        <div class="row mx-0">
            <div class="col-4 px-2 text-center">
                <img src="/images/icon-45.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
                <p class="font-weight-bold">Mua sắm & thanh toán thuận tiện</p>
            </div>
            <div class="col-4 px-2 text-center">
                <img src="/images/icon-46.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
                <p class="font-weight-bold">Nhiều ưu đãi hơn trên app</p>
            </div>
            <div class="col-4 px-2 text-center">
                <img src="/images/icon-47.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
                <p class="font-weight-bold">Theo dõi đơn hàng dễ dàng</p>
            </div>
        </div>
        <div class="my-2">
            <button class="btn w-100 btn-wanning btn-block bg-color-line text-light rounded-0" type="button">Tải App</button>
        </div>
    </div>
    <div class="bg-oganre p-2 d-sm-none d-block">
        <div class="my-2">
            <button class="btn w-100 btn-wanning btn-block bg-ed1c24 text-light rounded-0 text-uppercase" type="button">Xem thông tin haidangtravel</button>
        </div>
    </div>
</main>
<div id="confirmGiftModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content ">
            {!! Form::open([]) !!}
            <div class="modal-body ">
                <div class="count">
                    <p>{{ $user===null?'Hãy đăng nhập để sử dụng chức năng này !': 'Bạn có chắc muốn đổi món quà này !'}}</p>
                    <div class="alert alert-danger" style="display: none;">
                        <strong>Có lỗi !</strong>
                        <ul>
                            <li class="ErrorConssult"></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @if($user !==null)
                <button type="button"  class="btn btn-primary confirm_gift" onclick="ConfirmGift(this)">Gửi</button>
                @endif
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
</div>
@stop
@section('scripts')
    {!! HTML::script('js/user.js') !!}
@stop
