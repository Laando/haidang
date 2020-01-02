@extends('front.template')
<?php
$image='assets/img/logo1-default.png';
if(isset($destinationpoint)){
    $arrimg = explode(';',$destinationpoint->images);
    $image =  checkImage($arrimg[0]);
    $image = 'image/'.$image;
    $seotitle = '';
    $seokeyword = '';
    $seodescription = '';
        $seotitle .= 'Tour du lịch ';
        $seokeyword .= '';
        $seodescription = '';
    $seotitle .= $destinationpoint->title;
    $seokeyword .= $destinationpoint->seokeyword;
    $seodescription .= $destinationpoint->seodescription;

}
?>
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
@stop
@section('styles')

@stop
@section('main')
    <main>
        <div class="container mt-50">
            <div class="px-xs-0">
                <div class="banner position-relative zindex-fixed mta75" style="z-index: 3;margin-top: -50px;">
                    <div class="bannertop owl-carousel nav-none nav-res owl-theme">
                        @foreach($cate_banner as $banner)
                            @php
                                if($agent->isMobile()){
                                    $banner->images = imgageMobile($banner->images , 600 , 400);
                                }
                            @endphp
                            <a href="{{ $banner->url }}"><img src="{{ asset('image/'.$banner->images) }}" class="banner-home img-fluid w-100" alt="{{ $banner->title }}"></a>
                        @endforeach

                    </div>
                </div>
                <div class="mt-md-5 mt-3">
                    <div class="mb-3 col-12 text-center text-uppercase">
                        <h4>
                            @php
                                $region_col = 3 ;
                                switch ($isOutbound) {
                                    case 0 :
                                        echo('Tour trong nước');
                                        break;
                                    case 1 :
                                        echo('Tour nước ngoài');
                                        $region_col = 5 ;
                                        break;
                                    case 2 :
                                        echo('Tour đoàn');
                                        break;
                                }
                            @endphp
                        </h4>
                    </div>
                    @if($isOutbound == 0 || $isOutbound == 1)
                    <div class="d-md-block d-none">
                        <table class="table-tour table table-bordered mb-5">
                            <thead class="text-uppercase font-weight-bold text-center">
                            <tr>
                                @php
                                    $expiresAt = \Carbon\Carbon::now()->addMinutes(10);
                                    $destinationpoints = Cache::remember('destinationpoints_homepage',$expiresAt, function() {
                                        return \App\Models\DestinationPoint::orderBy('priority','ASC')->get();
                                    });
                                @endphp
                                @foreach($region_menus as $region)
                                    @php
                                        $region_destinationpoints = $destinationpoints->filter(function ($value, $key)use ($region){
                                                                        return $value->region_id == $region->id;
                                                                    });
                                    @endphp
                                    <th style="width:33%" scope="col" {!! $region_destinationpoints->count() > 8?'colspan="2"':'' !!}>{{ $region->title }}</th>
                                @endforeach

                                {{--<th style="width:33%" scope="col" colspan="2">miền nam</th>--}}
                                {{--<th style="width:33%" scope="col">miền nam</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                @foreach($region_menus as $region)
                                    @php
                                        $region_destinationpoints = $destinationpoints->filter(function ($value, $key)use ($region){
                                                                        return $value->region_id == $region->id;
                                                                    });
                                        $count_col  = $region_destinationpoints->count() > 8?2:1;
                                    @endphp
                                    @for($i = 1 ; $i<=$count_col ; $i ++)
                                        <td class="{{ $i === $count_col?'py-lg-3 pl-auto':'border-right-0' }}">
                                            @foreach($region_destinationpoints->values() as $index=>$dp)
                                                @if($index > ($i-1)*8 && $index < $i*8)
                                                    <p><a href="{{ asset('diem-den/'.$dp->slug) }}" class="text-gray"><i class="far fa-compass"></i>{{ $dp->title }}</a></p>
                                                @endif
                                            @endforeach
                                        </td>
                                    @endfor
                                @endforeach
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="content">
                        <div class="row text-center">
                            @foreach($tours as $tour)
                                @include('partials.tourpartial' ,['tour'=> $tour])
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>
        <div class="bg-efefef p-2 d-sm-none d-block">
            <div class="text-center w-100">
                <p class="font-weight-bold flex-nowrap">Ưu đãi khi sử dụng Haidangtravel App</p>
            </div>
            <div class="row mx-0">
                <div class="col-4 px-2 text-center">
                    <img src="images/icon-45.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
                    <p class="font-weight-bold">Mua sắm & thanh toán thuận tiện</p>
                </div>
                <div class="col-4 px-2 text-center">
                    <img src="images/icon-46.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
                    <p class="font-weight-bold">Nhiều ưu đãi hơn trên app</p>
                </div>
                <div class="col-4 px-2 text-center">
                    <img src="images/icon-47.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
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

@stop