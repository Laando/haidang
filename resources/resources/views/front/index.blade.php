@extends('front.template')
@section('title')
    <title>{!! $seotitle !!}</title>
@stop
@section('meta')
    <meta name="keywords" content="{!! $seokeyword !!}"/>
    <meta name="description" content="{!! $seodescription !!}"/>
    <meta name="og:title" content="{!! $seotitle !!}"/>
    <meta name="og:image" content="{!!asset('assets/img/logo1-default.png')!!}"/>
    <meta name="og:description" content="{!! $seodescription !!}"/>
    <meta name="DC.title" content="{!! $seotitle !!}">
    <meta name="DC.subject" content="{!! $seodescription !!}">
@stop
@section('styles')
    @if($agent->isMobile())
    <style>
        .owl-carousel.owl-theme .owl-item {
            text-align: center;
        }
         .owl-carousel.owl-theme .owl-item  a{
            width: 35%;
        }
        .owl-carousel.owl-theme .owl-item  img {
            width: 35%;
            margin: 0 auto;
        }
    </style>
    @endif
@stop
@section('main')
    <main>
        <div class="hder-chude">
            <div class="container">
                <div class=" zindex-fixed mta75 " style="padding-top: 20px">
                    @php
                        $bannershome  = $homeslidebanners;
                    @endphp
                    @include('front.bannerhome' , ['banners' => $bannershome])
                </div>
                        

                <!-- <div class="col-12 mx-auto tour owl-carousel owl-theme abc">
                    @foreach($subjecttours as $sub)
                        @if($sub->icon_homepage != '')
                            <a class="text-center col-15 " href="{{ asset('') }}chu-de-tour/{{ $sub->slug }}">
                                <img src="{{ asset('')}}image/chude_icon/{{ $sub->icon_homepage }}"
                                     class="p-md-1 m-auto" style="height:70px" alt="{{ $sub->title }}">
                                <p>{{ $sub->title }}</p>
                            </a>
                        @endif
                    @endforeach
                </div> -->
            </div>
        </div>

        <div class="bg-f3f3f3">
            <div class="container">
                <div class="danhmuc_hd">
                    <div class="hr_danhmuc">DANH MỤC</div>
                    {!!   $agent->isMobile()?'<div':'<ul' !!} class="galeria {{ $agent->isMobile()?' owl-carousel owl-theme categoryhome':'' }} ">
                        @if($agent->isMobile())
                            <div class="text-center row item ">
                                <div class="col-6">
                                    <a href="{{ asset('tour-trong-nuoc') }}">
                                        <img src="images/icontourtrongnuoc.png"/>
                                        <p>TOUR TRONG NƯỚC</p>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ asset('tour-nuoc-ngoai') }}">
                                        <img src="images/icontournuocngoai.png"/>
                                        <p>TOUR NƯỚC NGOÀI</p>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ asset('tour-doan') }}">
                                        <img src="images/icontourdoan.png"/>
                                        <p> TOUR ĐOÀN</p>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ asset('tour-gio-vang') }}">
                                        <img src="images/icontourgiovang.png"/>
                                        <p>TOUR GIỜ VÀNG</p>
                                    </a>
                                </div>
                            </div>
                            <div class="text-center row item">
                                <div class="col-6">
                                    <a href="{{ asset('chu-de/tour-cam-trai') }}">
                                        <img src="images/iconcamtrai.png"/>
                                        <p>TOUR CẮM TRẠI</p>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ asset('page/teambuilding') }}">
                                        <img src="images/icontourteam.png"/>
                                        <p>TEAM BUILDING</p>
                                    </a>
                                </div>
                                <div class="col-6">

                                    <a href="{{ asset('page/event-hoi-nghi') }}">
                                        <img src="images/iconeventhoinghi.png"/>
                                        <p> EVENT HỘI NGHỊ</p>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ asset('page/visa-passport') }}">
                                        <img src="images/iconpassport.png"/>
                                        <p> VISA-PASPORT</p>
                                    </a>
                                </div>
                            </div>
                            <div class="text-center row item">
                                <div class="col-6">
                                    <a href="{{ asset('page/ve-may-bay') }}">
                                        <img src="images/iconvemaybay.png"/>
                                        <p>VÉ MÁYBAY </p>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ asset('page/thue-xe') }}">
                                        <img src="images/iconthuexe.png"/>
                                        <p>THUÊ XE </p>
                                    </a>
                                </div>
                                <div class="col-6">
                                   <a href="{{ asset('page/khach-san') }}">
                                       <img src="images/iconkhachsan.png"/>
                                       <p>KHÁCH SẠN </p>
                                   </a>
                               </div>
                                <div class="col-6">
                                    <a href="{{ asset('page/du-hoc') }}">
                                        <img src="images/iconduhoc.png"/>
                                        <p>DU HỌC</p>
                                    </a>
                                </div>
                            </div>
                            <div class="text-center row item">
                                <div class="col-6">
                                    <a href="{{ asset('cam-nang-du-lich') }}">
                                        <img src="images/iconcamnang.png"/>
                                        <p>CẨM NANG DU LỊCH</p>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ asset('tin-tuc') }}">
                                        <img src="images/icontintuc.png"/>
                                        <p>TIN TỨC</p>
                                    </a>
                                </div>
                            </div>
                        @else
                        <li class="text-center item">
                            <a href="{{ asset('tour-trong-nuoc') }}">
                                <img src="images/icontourtrongnuoc.png"/>
                                <p>TOUR TRONG NƯỚC</p>
                            </a>
                        </li>
                        <li class="text-center item">
                            <a href="{{ asset('tour-nuoc-ngoai') }}">
                                <img src="images/icontournuocngoai.png"/>
                                <p>TOUR NƯỚC NGOÀI</p>
                            </a>
                        </li>
                        <li class="text-center item">
                            <a href="{{ asset('tour-doan') }}">
                                <img src="images/icontourdoan.png"/>
                                <p> TOUR ĐOÀN</p>
                            </a>
                        </li>
                        <li class="text-center item">
                            <a href="{{ asset('tour-gio-vang') }}">
                                <img src="images/icontourgiovang.png"/>
                                <p>TOUR GIỜ VÀNG</p>
                            </a>
                        </li>
                        <li class="text-center item">
                            <a href="{{ asset('chu-de/tour-cam-trai') }}">
                                <img src="images/iconcamtrai.png"/>
                                <p>TOUR CẮM TRẠI</p>
                            </a>
                        </li>
                        <li class="text-center item">
                            <a href="{{ asset('page/teambuilding') }}">
                                <img src="images/icontourteam.png"/>
                                <p>TEAM BUILDING</p>
                            </a>
                        </li>
                        <li class="text-center item">
                            <a href="{{ asset('page/event-hoi-nghi') }}">
                                <img src="images/iconeventhoinghi.png"/>
                                <p> EVENT HỘI NGHỊ</p>
                            </a>
                        </li>
                        <li class="text-center item">
                            <a href="{{ asset('page/visa-passport') }}">
                                <img src="images/iconpassport.png"/>
                                <p> VISA-PASPORT</p>
                            </a>
                        </li>
                        <li class="text-center item">
                            <a href="{{ asset('page/ve-may-bay') }}">
                                <img src="images/iconvemaybay.png"/>
                                <p>VÉ MÁYBAY </p>
                            </a>
                        </li>
                        <li class="text-center item">
                            <a href="{{ asset('page/thue-xe') }}">
                                <img src="images/iconthuexe.png"/>
                                <p>THUÊ XE </p>
                            </a>
                        </li>
                        <li class="text-center item">
                            <a href="{{ asset('page/khach-san') }}">
                                <img src="images/iconkhachsan.png"/>
                                <p>KHÁCH SẠN </p>
                            </a>
                        </li>
                        <li class="text-center item">
                            <a href="{{ asset('page/du-hoc') }}">
                                <img src="images/iconduhoc.png"/>
                                <p>DU HỌC</p>
                            </a>
                        </li>
                        <li class="text-center item">
                            <a href="{{ asset('cam-nang-du-lich') }}">
                                <img src="images/iconcamnang.png"/>
                                <p>CẨM NANG DU LỊCH</p>
                            </a>
                        </li>
                        <li class="text-center item">
                            <a href="{{ asset('tin-tuc') }}">
                                <img src="images/icontintuc.png"/>
                                <p>TIN TỨC</p>
                            </a>
                        </li>
                        @endif
                    {!!  $agent->isMobile()?'</div>':'</ul>' !!}
                </div>

                <div class="clearfix"></div>
                <div class="bg-white">
                    <div class="hd-tour-index">
                        <div class="mb-3 col-12 text-center text-uppercase">
                            <h5>TOUR PHÙ HỢP VỚI BẠN </h5>
                        </div>
                        <div class="card-deck mb-5 position-relative text-center">
                            @foreach($tours as $index=>$tour)
                                @include('partials.tourpartial' ,['tour'=> $tour , 'showTicket'=>true])
                            @endforeach
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="mx-auto px-xs-0">
                    <div class="clearfix"></div>
                    <div class="bg-white">
                        <div class="hd-tour-index">
                            <div class="mb-3 col-12 text-center text-uppercase">
                                <h4>TOUR SẮP KHỞI </h4>
                            </div>
                            <div class="tab row mx-0">
                                <button class="tablinks col-6  active" onmouseover="openCity(event, 'In')">TOUR TRONG
                                    NƯỚC
                                </button>
                                <button class="tablinks col-6" onmouseover="openCity(event, 'Out')">TOUR NƯỚC NGOÀI
                                </button>
                            </div>

                            <div id="In" class="tabcontent mt-3 mx-a15" style="display:block">
                                <div class="row mx-0">
                                    @foreach($tours_trongnuoc as $index=>$tour)
                                        @include('partials.tourpartial' ,['tour'=> $tour])
                                    @endforeach
                                </div>
                            </div>
                            <div id="Out" class="tabcontent mt-3 mx-a15">
                                <div class="row mx-0">
                                    @foreach($tours_nuocngoai as $index=>$tour)
                                        @include('partials.tourpartial' ,['tour'=> $tour])
                                    @endforeach
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>


                    <div class="mt-3 mb-2">
                        @foreach($homebottombanners as $index=>$banner)
                            @if($index == 0)
                                @php
                                    if($agent->isMobile()){
                                    $banner->images = imgageMobile($banner->images , 600 , 400);
                                }
                                @endphp
                                <a href="{{ $banner->url }}"><img src="{{ asset('image/'.$banner->images) }}"
                                                                  class="img-fluid w-100" alt="{{ $banner->title }}"></a>
                            @endif
                        @endforeach
                    </div>
                    <div class="row pt-1 mx-auto banner owl-carousel nav-none owl-theme">
                        @foreach($homebottombanners as $index=>$banner)
                            @php
                                if($agent->isMobile()){
                                    $banner->images = imgageMobile($banner->images , 600 , 400);
                                }
                            @endphp
                            <a href="{{ $banner->url }}"><img src="{{ asset('image/'.$banner->images) }}"
                                                              class="img-fluid mx-auto" alt="{{ $banner->title }}"></a>
                        @endforeach
                    </div>

                    <div class="bg-white hd-tour-index mb-3">
                        <div class="tab row px-1">
                            <button class="tablinks2 col-3 active" onmouseover="openGroup(event, 'New')"
                                    onclick="location='/tin-tuc'">TIN TỨC
                            </button>
                            <button class="tablinks2 col-3" onmouseover="openGroup(event, 'Note')"
                                    onclick="location='/cam-nang-du-lich'">CẨM NANG DU LỊCH
                            </button>
                            <button class="tablinks2 col-3" onmouseover="openGroup(event, 'Video')"
                                    onclick="location='/tin-tuc/video'">VIDEO
                            </button>
                            <button class="tablinks2 col-3" onmouseover="openGroup(event, 'Img')"
                                    onclick="location='/tin-tuc/hinh-anh'">HÌNH ẢNH
                            </button>
                        </div>

                        <div id="New" class="tabcontent2 mt-3 mx-a15" style="display:block">
                            <div class="row mx-0">
                                @php
                                    $home_blogs_1 = $home_blogs;
                                    $blogs = $home_blogs_1->filter(function ($value, $key) {
                                                $check_sub = $value->subjectblogs->filter(function($v, $k){
                                                                return $v->id == 23;
                                                                });
                                                return $check_sub->count() > 0;
                                                });
                                @endphp
                                @include('partials.bloghomepartial',['blogs'=>$blogs])
                            </div>
                        </div>
                        <div id="Note" class="tabcontent2 mt-3 mx-a15" style="display:none">
                            <div class="row mx-0">
                                @php
                                    $home_blogs_2 = $home_blogs;
                                    $blogs = $home_blogs_2->filter(function ($value, $key) {
                                                $check_sub = $value->subjectblogs->filter(function($v, $k){
                                                                return $v->id == 11;
                                                                });
                                                return $check_sub->count() > 0;
                                                });
                                @endphp
                                @include('partials.bloghomepartial',['blogs'=>$blogs])
                            </div>
                        </div>
                        <div id="Video" class="tabcontent2 mt-3 mx-a15" style="display:none">
                            <div class="row mx-0">
                                @php
                                    $home_blogs_3 = $home_blogs;
                                    $blogs = $home_blogs_3->filter(function ($value, $key) {
                                                $check_sub = $value->subjectblogs->filter(function($v, $k){
                                                                return $v->id == 17;
                                                                });
                                                return $check_sub->count() > 0;
                                                });
                                @endphp
                                @include('partials.bloghomepartial',['blogs'=>$blogs])
                            </div>
                        </div>
                        <div id="Img" class="tabcontent2 mt-3 mx-a15" style="display:none">
                            <div class="row mx-0">
                                @php
                                    $home_blogs_4 = $home_blogs;
                                    $blogs = $home_blogs_4->filter(function ($value, $key) {
                                                $check_sub = $value->subjectblogs->filter(function($v, $k){
                                                                return $v->id == 20;
                                                                });
                                                return $check_sub->count() > 0;
                                                });
                                @endphp
                                @include('partials.bloghomepartial',['blogs'=>$blogs])
                            </div>
                        </div>
                    </div>
                    @php
                        $banner  = $homedemofooter;
                        if($agent->isMobile()){
                            $banner->images = imgageMobile($banner->images , 600 , 400);
                        }
                    @endphp
                    <div class="mt-3 mb-2">
                        <a href="{{ $banner->url }}"><img src="{{ asset('image/'.$banner->images) }}" class="img-fluid"
                                                          alt="{{ $banner->title }}" height="200"></a>
                    </div>


                </div>
            </div>
        </div>

    </main>
@stop