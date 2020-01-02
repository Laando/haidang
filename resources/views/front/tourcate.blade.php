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
@stop
@section('styles')

@stop
@section('main')
<main style=" background: #ff6000; padding-bottom: 40px">
    @if(isset($destinationpoint))
    {!! $destinationpoint->description !!}
    @endif
    <div class="container">
        <div class="" style="background: white;padding: 20px;border-radius: 20px;border-top: 5px solid gold;margin-top: 20px">

            <div class="mt-4">
                <div class="mb-3 col-12 text-center text-uppercase">
                    @if(isset($destinationpoint))
                    <h4>TỔNG HỢP: {{ $destinationpoint->title }}</h4>
                    @else
                        <h4>TÌM KIẾM : {{ \Illuminate\Support\Facades\Input::get('query_home') }}</h4>
                    @endif
                </div>
                <div class="tab row mb-3 mx-0">
                    <button class="tablinks col-6  active" onmouseover="openCity(event, 'In')">TOUR TRONG NƯỚC</button>
                    <button class="tablinks col-6" onmouseover="openCity(event, 'Out')">TOUR NƯỚC NGOÀI</button>
                </div>
                <form id="MenuSearch" class="row mb-4" action="/search" onsubmit="goSearch();return false;">
                    <div class="col-lg-3 mb-2 wline-sm-100">
                        <select name="destination" class="form-control rounded-0" style="width:100%">
                            <option value="">Điểm đến</option>
                            @foreach($destinationpoints as $dp)
                                <option {{ \Illuminate\Support\Facades\Input::get('destination')===$dp->slug?'selected':'' }} value="{{$dp->slug}}" data-type="{{ $dp->isOutbound }}" class="{{ $dp->isOutbound==='0'?'':'d-none' }}">{{ $dp->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-9 mb-2 wline-sm-100 position-relative">
                        <input name="query_home" value="{{ \Illuminate\Support\Facades\Input::get('query_home') }}" type="text" class="form-control rounded-0 border-right-0" placeholder="Bạn có thể tìm kiếm theo từ khóa" style="width:100%" />
                        <div class="position-absolute" style="top:0;right:15px">
                            <button type="button" class="btn rounded-0 mb-2 bg-white border border-left-0 border-right-0 pr-4 show-filter"><i class="fas fa-sliders-h"></i>&emsp;Bộ lọc</button>
                            <button type="submit" class="btn rounded-0 mb-2 bg-oganre text-white"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="">
                            <div class="shadow popup-filter">
                                <div class="row mx-0 ">
                                    <div class="col-4">
                                        <div>TIÊU CHUẨN</div><hr>
                                        @php
                                            $selectedSearchStarndards = array_flip(explode(',',\Illuminate\Support\Facades\Input::get('standard')));
                                        @endphp
                                        <div>
                                            <label class="check">
                                                Nhà nghỉ
                                                <input {{ isset( $selectedSearchStarndards[1]) ? 'checked':'' }} type="checkbox" data-name="standard" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="check">
                                                2 sao
                                                <input {{ isset( $selectedSearchStarndards[2]) ? 'checked':'' }} type="checkbox"  data-name="standard" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="check">
                                                3 Sao
                                                <input {{ isset( $selectedSearchStarndards[3]) ? 'checked':'' }} type="checkbox" data-name="standard" value="3">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="check">
                                                4 Sao
                                                <input {{ isset( $selectedSearchStarndards[4]) ? 'checked':'' }} ="checkbox" data-name="standard" value="4">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="check">
                                                5 Sao
                                                <input {{ isset( $selectedSearchStarndards[5]) ? 'checked':'' }} type="checkbox" data-name="standard" value="5">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div>Phương tiện</div><hr>
                                        @php
                                            $selectedSearchVehicle = array_flip(explode(',',\Illuminate\Support\Facades\Input::get('transport')));
                                        @endphp
                                        @foreach($vehicletype as $index=>$ve)
                                        <div>
                                            <label class="check">
                                                {{ $ve->vehicle }}
                                                <input {{ isset( $selectedSearchVehicle[$ve->idtypeVehicle]) ? 'checked':'' }} type="checkbox" data-name="transport" value="{{ $ve->idtypeVehicle }}">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="In" class="tabcontent mt-3" style="display:block">
                    <div class="row">
                        @php
                            $tour_domestic  =  $tours->filter(function ($value, $key) {
                                                return $value->isOutbound == 0;
                                                });
                            $tour_outbound  =  $tours->filter(function ($value, $key) {
                                                return $value->isOutbound == 1;
                                                });
                        @endphp
                        @if($tour_domestic->count()>0)
                        @foreach($tour_domestic as $tour)
                            @php
                                $images = $tour->images ? explode(';', $tour->images) : [];
                                $image = count($images) ? $images[count($images) - 2] : '';
                                $image =  checkImage($image,true);
                            @endphp
                            <a href="{{ asset($tour->slug) }}" aria-label="Bootstrap">
                                <div class="col-md-6 col-lg-4 mb-2">
                                    <div class="img-card position-relative">
                                        <figure style="background-image:url('/image/{{ $image }}')" class="bg-figure"></figure>
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
                                            <p class="cl-hdtitle card-text bg-xam text-center p-3 mb-0 boder-bottom-page">{{ $tour->title }}</p>
                                            <div class="position-absolute bg-page p-3 show-tour" style="width:100%;height:100%">
                                                <a class="navbar-brand mr-0  p-0" href="{{ asset($tour->slug) }}" aria-label="Bootstrap">
                                                    <img src="{{ asset('') }}images/icon-11.png" alt="user">
                                                </a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        @else
                            Không tìm thấy kết quả tour trong nước .<br/>
                        @endif
                        @if($tour_outbound->count()> 0)
                            Tìm thấy {{$tour_outbound->count()}} tour nước ngoài
                        @endif
                    </div>
                </div>
                <div id="Out" class="tabcontent mt-3">
                    <div class="row">
                        @if($tour_outbound->count()> 0)
                            @foreach($tour_outbound as $tour)
                                @php
                                    $images = $tour->images ? explode(';', $tour->images) : [];
                                    $image = count($images) ? $images[count($images) - 2] : '';
                                    $image =  checkImage($image,true);
                                @endphp
                                <a href="/" aria-label="Bootstrap">
                                    <div class="col-md-6 col-lg-4 mb-2">
                                        <div class="img-card position-relative">
                                            <figure style="background-image:url('/image/{{ $image }}')" class="bg-figure"></figure>
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
                                                <p class="cl-hdtitle card-text bg-xam text-center p-3 mb-0 boder-bottom-page">{{ $tour->title }}</p>
                                                <div class="position-absolute bg-page p-3 show-tour" style="width:100%;height:100%">
                                                    <a class="navbar-brand mr-0  p-0" href="{{ asset($tour->slug) }}" aria-label="Bootstrap">
                                                        <img src="{{ asset('') }}images/icon-11.png" alt="user">
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            Không tìm thấy kết quả tour nước ngoài .<br/>
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="bg-efefef p-2 d-sm-none d-block">
        <div class="text-center w-100">
            <p class="font-weight-bold flex-nowrap">Ưu đãi khi sử dụng Haidangtravel App</p>
        </div>
        <div class="row mx-0">
            <div class="col-4 px-2 text-center">
                <img src="{{ asset('') }}images/icon-45.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
                <p class="font-weight-bold">Mua sắm & thanh toán thuận tiện</p>
            </div>
            <div class="col-4 px-2 text-center">
                <img src="{{ asset('') }}images/icon-46.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
                <p class="font-weight-bold">Nhiều ưu đãi hơn trên app</p>
            </div>
            <div class="col-4 px-2 text-center">
                <img src="{{ asset('') }}images/icon-47.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
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
        @if(isset($destinationpoint))
            {!! $destinationpoint->content !!}
        @endif
</main>
@stop
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

        });
        function goSearch(){
            $form = $('#MenuSearch');
            let model = FormProvider.BindToModel($form);
            let link = '/search?';
            // find standard
            let standards= [] ;
            let transports= [] ;
            $('[data-name="standard"]:checked').each(function(index,item){
                standards = [...standards ,$(item).val()];
            })
            $('[data-name="transport"]:checked').each(function(index,item){
                transports = [...transports ,$(item).val()];
            })
            for (let [key,value] of Object.entries(model)){
                link += key+'='+value + '&';
            }
            link += 'standard='+ standards.join(',')+ '&';
            link += 'transport='+ transports.join(',',)+ '&';
            link = trim(link,'&');
            location = link;
            return false;
        }
    </script>
@stop