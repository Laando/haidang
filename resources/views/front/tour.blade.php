<?php
// $eventtime =  Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $eventtimeconfig->content);
$eventtimeend =  $eventtime->copy()->addHour(2);
$now = Carbon\Carbon::now();
$inEvent = $now->between($eventtime, $eventtimeend);
$arrimg = explode(';',$tour->images);
$image =  checkImage($arrimg[0]);
$vehicles = \App\Models\Traffic::all();
?>
@extends('front.template')
@section('title')
    <title>{!! $tour->title !!}</title>
@stop
@section('meta')
    <?php
    $arrimg = explode(';',$tour->images);
    $image =  checkImage($arrimg[0]);
    ?>
    <meta name="keywords" content="{!! $tour->seokeyword !!}" />
    <meta name="description" content="{!! $tour->seodescription !!}" />
    <meta name="og:title" content="{!! $tour->title !!}"/>
    <meta name="og:image" content="{!! asset('image/'.$image) !!}"/>
    <meta name="og:description" content="{!! $tour->seodescription !!}"/>
    <meta name="DC.title" content="{!! $tour->title !!}">
    <meta name="DC.subject" content="{!! $tour->seodescription !!}">
@stop
@section('styles')
    {!! HTML::style('css/bootstrap-datetimepicker.min.css') !!}
@stop
@section('main')
    <main>
        <div class="container">
            <div>
                <div class="mt-4">
                    <div class="mb-4">
                        <img src="{{ asset('')}}images/icon-32.png" class="float-left mr-3" alt="user" width="40">
                        <p class="mb-0 pt-md-3 pt-0 text-dark font-weight-bold text-uppercase" href="#">{{ $tour->title }}</p>
                    </div>
                </div>
                <div style="clear: both;"></div>
                <div class="row mb-md-4 mb-2 mx-md-auto mx-0">
                    <div class="col-md-6 col-12 rounded-0 flex-md-row box-shadow h-md-250 p-0">
                        <div class="w-100 position-relative">
                            <div id="big" class="owl-carousel owl-theme">
                                <?php $endimage = explode(';', $tour->end_images); ?>
                                @foreach($endimage as $index=>$image)
                                    <img src="{!! $image !!}" class="img-responsive m-auto mb-3">
                                @endforeach
                            </div>
                            <div id="thumbs" class="owl-carousel owl-theme">
                                @foreach($endimage as $index=>$image)
                                    <img src="{!! $image !!}" class="img-responsive px-md-2 px-1 m-auto mb-3">
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @php
                        $startdates = $tour->activeDates()->orderBy('startdate', 'ASC')->get();
                        $discount_rate = 0 ;
                        if($startdates->count()> 0){
                            $first_sd =  $startdates->first();
                            $first_addings  = json_decode($first_sd->addings);
                            $discount_rate = 100 - ceil($first_sd->adult_price / $tour->price * 100);
                        } else {
                            $first_sd = new stdClass();
                            $first_sd->adult_price = 0;
                            $first_sd->child_price = 0;
                            $first_sd->baby_price = 0;
                            $first_sd->traffic = 1;
                            $first_addings = [];
                        }
                        $id_part = $tour->id . '';
                        $total_char = strlen($id_part);
                        for ($i = $total_char; $i < 5; $i++) {
                            $id_part = '0' . $id_part;
                        }
                        $code_order = 'HD' . $id_part . date_format(date_create($tour->created_at), 'y');
                    @endphp
                    <div class="col-md-6 col-12 rounded-0 pr-0 pl-md-2 pl-0">
                        <p class="py-2 text-center font-weight-bold bg-d4c13b mb-0">GIÁ ĐANG KHUYẾN MÃI</p>
                        <div class="bg-f9e767 py-2">
                            <p class="text-center font-weight-bold h4" id="priceByStar" data-price="{{ $first_sd->adult_price }}">{{ numbertomoney($first_sd->adult_price) }}</p>
                            <p class="text-warning font-weight-bold mb-0 text-center text-danger"><span class="small text-dark pr-2"><s>Giá gốc:{{ number_format($tour->price) . ' vnđ' }}</s></span><span id="discount_rate"></span></p>
                        </div>
                        <?php
                        $str_sd = array();
                        $str_adding = array();
                        foreach ($startdates as $index => $value) {
                            $str_sd[] = date_format(date_create($value->startdate), 'Y-m-d');
                            $str_st[] = date_format(date_create($value->startdate), 'Y,m,d');
                            $str_value[] = date_format(date_create($value->startdate), 'd/m/Y');
                            $adding = $value->adding;
                            $str_adding[] = $adding != null ? $adding : 0;
                        }
                        ?>
                        <div class="row mx-0">
                            <div class="col-6 border px-2 py-3"><p class="text-center mb-0">LỊCH KHỞI HÀNH: <span id="startdate_list">{{ isset($str_value[0])?$str_value[0]:'' }}</span></p></div>
                            <div class="col-6 border px-2 py-3"><p class="text-center mb-0">THỜI GIAN: {{ $tour->period }}</p></div>
                            <div class="col-6 border px-2 py-3"><p class="text-center mb-0">PHƯƠNG TIỆN: {{ $vehicles->filter(function ($value, $key) use ($first_sd) { return $value->idtypeVehicle == $first_sd->traffic;})->first()->vehicle }}</p></div>
                            <div class="col-6 border px-2 py-3">
                                <div class="row">
                                    <div class="col-6 px-0">
                                        <p class="text-center mb-0 ">TIÊU CHUẨN</p>
                                    </div>
                                    <div class="col-6">
                                        <select class="custom-select custom" id="standardPrice">
                                            <option value="0">Mặc định</option>
                                            @foreach( $first_addings as $index=>$adding)
                                                @if(($adding->obj*1) > 2)
                                                    <option value="{{ $adding->price }}">{{ $adding->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-3 bg-f9e767">
                            {!! Form::open([]) !!}
                            <p class="text-center font-weight-bold mb-0">YÊU CẦU TƯ VẤN MIỄN PHÍ</p>
                            <p class="text-center">Nhập SĐT chúng tôi sẽ liên lạc với bạn trong 5 phút !!!</p>
                            <span class="countdown-consult"></span>
                            <div class="col-12 mb-2 position-relative">
                                <input type="text" name="phone" id="ConsultPhone" class="form-control border-right-0" placeholder="Nhập số điện thoại tại đây" style="width:100%">
                                <div class="position-absolute" style="top:0;right:15px">
                                    <button type="button" class="btn rounded-left-0 mb-2 bg-oganre text-white" onclick="SubmitAdvice(this)">GỬI</button>
                                </div>
                                <div class="alert alert-danger" style="display: none;">
                                    <strong>Có lỗi !</strong>
                                    <ul>
                                        <li class="ErrorConssult"></li>
                                    </ul>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="row justify-content-md-center my-1">
                            <div class="col-md-auto">
                                <button class="btn">
                                    <i class="far fa-heart fa-lg mr-1"></i>Lưu vào yêu thích
                                </button>
                            </div>
                            <div class="col-md-auto">
                                <button class="btn">
                                    <i class="far fa-envelope fa-lg mr-1"></i>Gửi lịch trình
                                </button>
                            </div>
                            <div class="col-md-auto">
                                <button class="btn">
                                    <i class="fas fa-print fa-lg mr-1"></i>In lịch trình
                                </button>
                            </div>
                        </div>
                        <div class="row justify-content-md-center align-self-center mb-3">
                            <a href="#TourResult"> 
                                <button class='btn btn-danger btn-choose px-4'>
                                    <i class="fas fa-shopping-cart fa-lg mr-1"></i>
                                    <span>CHỌN MUA</span> 
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 px-0 py-1">
                        <p class="tour-text">
                            {!! strip_tags($tour->description ) !!}
                        </p>
                    </div>
                    <div class="col-md-6 col-12 pr-0 pl-md-2 pl-0 py-1">
                        <div class="d-md-block d-none">
                            <div class="row mx-0">
                                <div class="col-4 text-center border py-3 px-lg-2 px-1">
                                    <img src="{{ asset('')}}images/icon-34.png" class="float-left height-res-30" alt="user" height="40">
                                    <p class="mb-0 pt-md-3 text-dark font-weight-bold text-uppercase fs-res-smaller" href="#">vé tham quan</p>
                                </div>
                                <div class="col-4 text-center border py-3 px-lg-2 px-1">
                                    <img src="{{ asset('')}}images/icon-35.png" class=" float-left height-res-30" alt="user" height="40">
                                    <p class="mb-0 pt-md-3 text-dark font-weight-bold text-uppercase fs-res-smaller" href="#">phương tiện</p>
                                </div>
                                <div class="col-4 text-center border py-3 px-lg-2 px-1">
                                    <img src="{{ asset('')}}images/icon-36.png" class=" float-left height-res-30" alt="user" height="40">
                                    <p class="mb-0 pt-md-3 text-dark font-weight-bold text-uppercase fs-res-smaller" href="#">Ăn uống</p>
                                </div>
                                <div class="col-4 text-center border py-3 px-lg-2 px-1">
                                    <img src="{{ asset('')}}images/icon-37.png" class=" float-left height-res-30" alt="user" height="40">
                                    <p class="mb-0 pt-md-3 text-dark font-weight-bold text-uppercase fs-res-smaller" href="#">khách sạn</p>
                                </div>
                                <div class="col-4 text-center border py-3 px-lg-2 px-1">
                                    <img src="{{ asset('')}}images/icon-38.png" class=" float-left height-res-30" alt="user" height="40">
                                    <p class="mb-0 pt-md-3 text-dark font-weight-bold text-uppercase fs-res-smaller" href="#">hướng dẫn viên</p>
                                </div>
                                <div class="col-4 text-center border py-3 px-lg-2 px-1">
                                    <img src="{{ asset('')}}images/icon-39.png" class=" float-left height-res-30" alt="user" height="40">
                                    <p class="mb-0 pt-md-3 text-dark font-weight-bold text-uppercase fs-res-smaller" href="#">bảo hiểm</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab row mx-0">
                    <button class="tablinks col-6  active" onmouseover="openCity(event, 'In')">LỊCH TRÌNH TOUR</button>
                    <button class="tablinks col-6" onmouseover="openCity(event, 'Out')">HÌNH ẢNH</button>
                </div>
                <div id="In" class="tabcontent mt-3" style="display:block">
                    <div class="d-lg-block d-none">
                        <?php
                        $details = $tour->details()->orderBy('day', 'ASC')->get();
                        ?>
                        @foreach($details as $index => $detail)
                            <div class="dis-flex mt-2 bg-6498ff font-weight-bold w-100">
                                <p class="p-3 mb-0 text-white border-right text-nowrap">NGÀY {!! $detail->day !!}</p>
                                <p class="p-3 mb-0 text-white">{!! $detail->title !!}</p>
                            </div>
                            <div class="p-3 bg-f5f5f5">
                                {!! $detail->content !!}
                            </div>
                        @endforeach
                    </div>
                    <div id="accordion">
                        <div id="Note">
                            <a class="dis-flex mt-2 bg-f9e767 font-weight-bold w-100" data-toggle="collapse" data-target="#note-price" aria-expanded="false" aria-controls="true">
                                <p class="p-2 mb-0 text-nowrap">GIÁ TOUR CHI TIẾT</p>
                            </a>
                        </div>
                        <div id="note-price" class="collapse" aria-labelledby="Note" data-parent="#accordion">
                            <div class="bg-f5f5f5 py-3 px-sm-2 px-1">
                                <table class="table table-bordered bg-white">
                                    <thead class="text-center">
                                    <tr>
                                        <th></th>
                                        <th>Người lớn<br />(Từ 12 tuổi trở lên)</th>
                                        <th>Trẻ em<br />(Từ 2 đến dưới 12 tuổi)</th>
                                        <th>Trẻ nhỏ<br />(Dưới 2 tuổi)</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-right">
                                    <tr>
                                        <td class="text-left">Giá tour cơ bản</td>
                                        <td>{{ numbertomoney($first_sd->adult_price) }}</td>
                                        <td>{{ numbertomoney($first_sd->child_price) }}</td>
                                        <td>{{ numbertomoney($first_sd->baby_price) }}</td>
                                    </tr>
                                    @foreach($first_addings as $index=>$adding)
                                        <tr>
                                            <td class="text-left">{{ $adding->name }} {{ $adding->required==='true'?'(khoản bắt buộc)':'' }}</td>
                                            <td colspan="3">{{ numbertomoney($adding->price) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="Time">
                            <a class="dis-flex mt-2 bg-f9e767 font-weight-bold w-100" data-toggle="collapse" data-target="#all-time" aria-expanded="false" aria-controls="true">
                                <p class="p-2 mb-0 text-nowrap">LỊCH KHỞI HÀNH</p>
                            </a>
                        </div>
                        <div id="all-time" class="collapse" aria-labelledby="Time" data-parent="#accordion">
                            <div class="bg-f5f5f5 py-3 px-sm-2 px-1">
                                <table class="table table-bordered table-striped text-center bg-white">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Ngày khởi hành</th>
                                        <th>Phương tiện</th>
                                        <th>Giá</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($startdates as $index=>$startdate)
                                        @php
                                            $traffic = $vehicles->filter(function ($value, $key) use ($startdate) {
                                                return $value->idtypeVehicle == $startdate->traffic;
                                            })->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ Carbon\Carbon::createFromFormat('Y-m-d',$startdate->startdate)->format('d-m-Y') }}</td>
                                            <td>{{ $traffic->vehicle }}</td>
                                            <td>{{ numbertomoney($startdate->adult_price) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <p class="text-right font-weight-bold">Liên hệ để biết thêm lịch khởi hành</p>
                            </div>
                        </div>
                        <div id="One">
                            <a class="dis-flex mt-2 bg-f9e767 font-weight-bold w-100" data-toggle="collapse" data-target="#all-price" aria-expanded="false" aria-controls="true">
                                <p class="p-2 mb-0 text-nowrap">GIÁ TOUR BAO GỒM</p>
                            </a>
                        </div>
                        <div id="all-price" class="collapse" aria-labelledby="One" data-parent="#accordion">
                            <div class="card-body">
                                {!! $tour->reside !!}
                            </div>
                        </div>
                        <div id="Two">
                            <a class="dis-flex mt-2 bg-f9e767 font-weight-bold w-100" data-toggle="collapse" data-target="#not-allprice" aria-expanded="false" aria-controls="not-allprice">
                                <p class="p-2 mb-0 text-nowrap">GIÁ TOUR KHÔNG BAO GỒM</p>
                            </a>
                        </div>
                        <div id="not-allprice" class="collapse" aria-labelledby="Two" data-parent="#accordion">
                            <div class="card-body">
                                {!! $tour->notinclude !!}
                            </div>
                        </div>
                        <div id="Three">
                            <a class="dis-flex mt-2 bg-f9e767 font-weight-bold w-100" data-toggle="collapse" data-target="#Child" aria-expanded="false" aria-controls="Child">
                                <p class="p-2 mb-0 text-nowrap">QUY ĐỊNH TRẺ EM</p>
                            </a>
                        </div>
                        <div id="Child" class="collapse" aria-labelledby="Three" data-parent="#accordion">
                            <div class="card-body">
                                {!! $tour->childstipulate !!}
                            </div>
                        </div>
                        <div id="Four">
                            <a class="dis-flex mt-2 mb-2 bg-f9e767 font-weight-bold w-100" data-toggle="collapse" data-target="#Buy-cancer" aria-expanded="false" aria-controls="Buy-cancer">
                                <p class="p-2 mb-0 text-nowrap">GIÁ TOUR MUA VÀ HỦY TOUR</p>
                            </a>
                        </div>
                        <div id="Buy-cancer" class="collapse" aria-labelledby="Four" data-parent="#accordion">
                            <div class="card-body">
                                {!! $tour->buycancelstipulate !!}
                            </div>
                        </div>
                        <div id="Five">
                            <a class="dis-flex mt-2 mb-2 bg-f9e767 font-weight-bold w-100" data-toggle="collapse" data-target="#note" aria-expanded="false" aria-controls="note">
                                <p class="p-2 mb-0 text-nowrap">GHI CHÚ</p>
                            </a>
                        </div>
                        <div id="note" class="collapse" aria-labelledby="Five" data-parent="#accordion">
                            <div class="card-body">
                                {!! $tour->note !!}
                            </div>
                        </div>
                        <div id="Six">
                            <a class="dis-flex mt-2 mb-2 bg-f9e767 font-weight-bold w-100" data-toggle="collapse" data-target="#pay" aria-expanded="false" aria-controls="pay">
                                <p class="p-2 mb-0 text-nowrap">HÌNH THỨC THANH TOÁN</p>
                            </a>
                        </div>
                        <div id="pay" class="collapse" aria-labelledby="Six" data-parent="#accordion">
                            <div class="card-body">
                                {!! $tour->payment !!}
                            </div>
                        </div>
                        <div id="Seven">
                            <a class="dis-flex mt-2 mb-2 bg-f9e767 font-weight-bold w-100" data-toggle="collapse" data-target="#place" aria-expanded="false" aria-controls="place">
                                <p class="p-2 mb-0 text-nowrap">ĐIỂM ĐÓN KHÁCH</p>
                            </a>
                        </div>
                        <div id="place" class="collapse" aria-labelledby="Seven" data-parent="#accordion">
                            <div class="card-body">
                                {!! $tour->takeoff !!}
                            </div>
                        </div>
                    </div>
                    <div class="bg-f5f5f5 mb-2">
                        {!! Form::open(['class' => 'py-3','id' => 'TourResult']) !!}
                            <input type="hidden" name="tour_id" id="TourId" value="{{ $tour->id }}">
                            <p class="mb-0 p-2 text-dark font-weight-bold text-uppercase text-center" href="#">kiểm tra giá</p>
                            <div class="row mx-0">
                                <div class="col-md-4 col-12">
                                    <div class="form-group mx-lg-3 mx-md-2 mb-lg-2 mb-md-1">
                                        <label for="">Người lớn / <span id="adult_price" data-price="{{  count($startdates) > 0 ? $first_sd->adult_price :'Liên hệ'  }}">{{ count($startdates) > 0 ? numbertomoney($first_sd->adult_price) :'Liên hệ' }}</span></label>
                                        <input name="tour_adult" type="text" class="form-control rounded-0" onkeyup="TourResult()">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mx-lg-3 mx-md-2 mb-lg-2 mb-md-1">
                                        <label for="">Trẻ em / <span id="child_price" data-price="{{  count($startdates) > 0 ? $first_sd->child_price :'Liên hệ'  }}">{{ count($startdates) > 0 ? numbertomoney($first_sd->child_price) :'Liên hệ' }}</span></label>
                                        <input name="tour_child" type="text" class="form-control rounded-0" onkeyup="TourResult()">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mx-lg-3 mx-md-2 mb-lg-2 mb-md-1">
                                        <label for="">Trẻ nhỏ / <span id="baby_price" data-price="{{  count($startdates) > 0 ? $first_sd->baby_price :'Liên hệ'  }}">{{ count($startdates) > 0 ? numbertomoney($first_sd->baby_price) :'Liên hệ' }}</span></label>
                                        <input name="tour_baby"type="text" class="form-control rounded-0" onkeyup="TourResult()">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mx-lg-3 mx-md-2 mb-lg-2 mb-md-1 date position-relative" data-provide="datepicker">
                                        <label for="">Ngày khởi hành</label>
                                        <input name="tour_startdate" id="tour_startdate" type="text" class="form-control rounded-0" onkeyup="TourResult()">
                                        <div  class="input-group-addon position-absolute" style="right:10px;bottom:7px">
                                            <span><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mx-lg-3 mx-md-2 mb-lg-2 mb-md-1">
                                        @php
                                            $std_addings = $first_addings ;
                                        @endphp
                                        <label for="">Tiêu chuẩn</label>
                                        <select name="tour_standard" class="form-control rounded-0" onchange="TourResult()">
                                            <option value="">Mặc định</option>
                                            @foreach( $std_addings as $index=>$adding)
                                                @if(($adding->obj*1) > 2)
                                                    <option value="{{ $adding->obj }}">{{ $adding->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12 text-center mt-md-auto my-2">
                                    <button type="button" class="btn rounded-0 small bg-oganre w-80 text-white" onclick="BookingTour(this)">TIẾP TỤC ĐẶT TOUR</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="bg-f5f5f5 py-3 px-sm-2 px-1 " id="tour-result">
                        <table class="table table-bordered bg-white">
                            <thead class="text-center">
                            <tr>
                                <th></th>
                                <th>Bắt buộc</th>
                                <th>Số lượng</th>
                                <th>Giá tiền</th>
                                <th>Tổng cộng</th>
                            </tr>
                            </thead>
                            <tbody class="text-right" id="tbody-result">

                            </tbody>
                        </table>
                    </div>
                    <div class="mb-3 bg-f5f5f5">
                        <div class="row mx-0">
                            <div class="col-lg-3 col-12 p-sm-0 p-4 bg-f9e767 d-lg-flex d-none align-items-center justify-content-center border">
                                <p class="h6 mb-0 p-lg-4 p-0 font-weight-bold">LIÊN HỆ QUẢN LÝ</p>
                            </div>
                            <div class="col-lg-9 col-12 px-0 d-flex">
                                <div class="border col-4 text-center p-3">
                                    <p class="mb-0">Người phụ trách tour</p>
                                    <p class="mb-0 text-uppercase">{{ $tour->user->fullname }}</p>
                                </div>
                                <div class="border col-4 text-center d-flex d-grid align-items-center justify-content-center p-lg-3 py-md-3 px-md-2">
                                    <a><img src="{{ asset('')}}images/icon-41.png" class="float-left mr-lg-3 m-auto" alt="user" height="30" width="30"></a>
                                    <p class="mb-0 d-sm-block d-none"><a href="skype:{{ $tour->user->skype }}?chat">{{ $tour->user->skype }}</a></p>
                                </div>
                                <div class="border col-4 text-center d-flex align-items-center justify-content-center p-3">
                                    <a><img src="{{ asset('')}}images/icon-40.png" class="float-left mr-3" alt="user" height="30" width="30"></a>
                                    <p class="mb-0 d-sm-block d-none"><a href="tel:{{ $tour->user->phone }}">{{ $tour->user->phone }}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="Out" class="tabcontent mt-3">
                    <div class="row">
                        @foreach($endimage as $index=>$image)
                            @if($image != '')
                                <div class="col-sm-4 col-6 mb-3">
                                    <a href="{!! ($image) !!}" data-fancybox="images" data-type="image">
                                        <img src="{!! ($image) !!}" class="img-thumbnail m-auto mb-3">
                                    </a>
                                </div>
                            @endif
                        @endforeach
                        {{--@foreach($arrimg  as $index=>$image)--}}
                            {{--@if($image != '')--}}
                                {{--<div class="col-sm-4 col-6 mb-3">--}}
                                    {{--<a href="{!! asset('image/'.$image) !!}" data-fancybox="images" data-type="image">--}}
                                        {{--<img src="{!! asset('image/'.$image) !!}" class="img-thumbnail m-auto mb-3">--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            {{--@endif--}}
                        {{--@endforeach--}}


                    </div>
                </div>
                <div class="clearfix"></div>

            </div>
        </div>
        <div class="bg-efefef p-2 d-sm-none d-block">
            <div class="text-center w-100">
                <p class="font-weight-bold flex-nowrap">Ưu đãi khi sử dụng Haidangtravel App</p>
            </div>
            <div class="row mx-0">
                <div class="col-4 px-2 text-center">
                    <img src="{{ asset('')}}images/icon-45.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
                    <p class="font-weight-bold">Mua sắm & thanh toán thuận tiện</p>
                </div>
                <div class="col-4 px-2 text-center">
                    <img src="{{ asset('')}}images/icon-46.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
                    <p class="font-weight-bold">Nhiều ưu đãi hơn trên app</p>
                </div>
                <div class="col-4 px-2 text-center">
                    <img src="{{ asset('')}}images/icon-47.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
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
    @if($tour->tour_ads!='')
        <script type="text/javascript">
            var google_tag_params = {
                travel_destid: "{!! $tour->tour_ads !!}",
                travel_pagetype: "tourdulich",
            };
        </script>
        <script type="text/javascript">
            /* <![CDATA[ */
            var google_conversion_id = 973763657;
            var google_custom_params = window.google_tag_params;
            var google_remarketing_only = true;
            /* ]]> */
        </script>
        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
        </script>
        <noscript>
            <div style="display:inline;">
                <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/973763657/?value=0&guid=ON&script=0"/>
            </div>
        </noscript>
    @endif
@stop
@section('ready')
    @if ($errors->any())
        jQuery('html, body').animate({
        scrollTop: jQuery('.alert.alert-danger').offset().top
        }, 1000);
    @endif
    @foreach($startdates as $sd)
        startdates = [...startdates , {tour_id : {{ $sd->tour_id }} , startdate_id : {{ $sd->id }} , date : new Date('{{ Carbon\Carbon::createFromFormat('Y-m-d',$sd->startdate)->format('Y-m-d') }}')}];
    @endforeach
    let temp_sds  = startdates.map(function(obj){ return obj.date });
    $('#tour_startdate').datetimepicker({
    format: 'DD/MM/Y',
    locale: 'vi',
    enabledDates : temp_sds,
    defaultDate: temp_sds.length > 0 ? temp_sds[0] : '' ,
    }).on("dp.change", function (e) {
    let current_date  =  e.date.toDate();
    let has_exist = false ;
    $.each(startdates,function(index,date){
    if(( current_date.getYear() === date.getYear() &&
    current_date.getMonth() === date.getMonth() &&
    current_date.getDate() === date.getDate()
    )){
    has_exist = true ;
    return;
    }
    });
    if(!has_exist) {
    $('#tour_startdate').val('');
    }

    });
@stop
@section('scripts')
    <script>
        let isAuthenticated = {{ \Illuminate\Support\Facades\Auth::guest()?'false':'true'  }};
        let startdates  = [] ;
                @if($tour->isGolden()&&$inEvent)
        var isGoldenInEvent = true;
                @else
        var isGoldenInEvent = false;
        @endif
        function SubmitAdvice(node) {
            var phone = $('#ConsultPhone').val();
            var form = $('#ConsultPhone').closest('form');
            if(validatePhone(phone)){
                var data = {};
                data.tour_id = '<?php echo $tour->id; ?>';
                $(form).find('input').each(function(index,element){
                    data[$(element).attr('name')] = $(element).val();
                });
                $.ajax({
                    url:  '<?php echo asset('/'); ?>consult/send',
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        if(response === 'Ok'){
                            $('.countdown-consult').show();
                            // Set the date we're counting down to
                            var now = new Date().getTime();
                            var countDownDate = now+(60*5*1000); // add 5 mins
                            var x = setInterval(function() {
                                now = new Date().getTime();
                                // Get todays date and time
                                // Find the distance between now and the count down date
                                var distance = countDownDate - now;
                                console.log(countDownDate,now,distance);
                                // Time calculations for days, hours, minutes and seconds
                                //var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                //var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                // Display the result in the element with id="demo"
                                $('.countdown-consult').html( minutes + " phút " + seconds + " giây ");
                                // If the count down is finished, write some text
                                if (distance < 0) {
                                    clearInterval(x);
                                    $('.countdown-consult').html('Xin lỗi có vẻ như mọi tư vấn đều bận ! Gọi trực tiếp tới HOTLINE : <a href="tel:19002011">1900 2011</a>');
                                }
                            }, 1000);
                        }
                        //$(node).prop('disabled',false);
                    }
                });
                $(node).prop('disabled',true);
            } else {
                $(form).find('.alert.alert-danger').show();
                $('.ErrorConssult').text('Số điện thoại không hợp lệ !');
            }
        }
        function validatePhone(txtPhone) {
            var a = txtPhone;
            var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
            if (filter.test(a)) {
                return true;
            }
            else {
                return false;
            }
        }
    </script>
    {!! HTML::script('js/moment.min.js') !!}
    {!! HTML::script('js/bootstrap-datetimepicker.js') !!}
@stop