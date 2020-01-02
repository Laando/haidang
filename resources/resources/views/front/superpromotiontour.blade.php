@extends('front.template')
<?php
$image = 'assets/img/logo1-default.png';
if (isset($destinationpoint)) {
    $arrimg = explode(';', $destinationpoint->images);
    $image = checkImage($arrimg[0]);
    $image = 'image/' . $image;
    $seotitle = '';
    $seokeyword = '';
    $seodescription = '';
    $seotitle .= 'Tour du lịch ';
    $seokeyword .= '';
    $seodescription = '';
    $seotitle .= 'Tin Tức';
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
    <style type="text/css">
        img.wp-smiley,
        img.emoji {
            display: inline !important;
            border: none !important;
            box-shadow: none !important;
            height: 1em !important;
            width: 1em !important;
            margin: 0 .07em !important;
            vertical-align: -0.1em !important;
            background: none !important;
            padding: 0 !important;
        }
    </style>
    <style type="text/css">

        @media screen {#wrapper-content .section.page-detail{}
            .homepage-banner-content .group-title .banner{font-size:45px;}
            .homepage-banner-content .group-title .sub-banner{font-size:45px;}
            body {background-color: #ffffff;background-repeat: no-repeat;background-attachment: ;background-position:center center;background-size:cover;}
            .page-title{background-image: url("{{ isset($banner) && $banner->images ? asset('image/' . $banner->images) : asset('image/no-photo.jpg') }}");}
            .page-title:before{content:"";position: absolute;width: 100%;height: 100%;left: 0;top: 0;background-color:rgba(52,73,94,0.23)}.page-title .page-title-wrapper .breadcrumb > li .link.home{color:#ffffff;font-weight:400;text-transform:uppercase;}
            .page-title .page-title-wrapper .breadcrumb > li .link{color:#ffffff;}
            .page-title .page-title-wrapper .breadcrumb > li .link{font-weight:400;text-transform:uppercase;}
            .page-title .page-title-wrapper .breadcrumb > li + li:before,.page-title .page-title-wrapper li.active .link:after{color:#ffffff;}
            .page-title-wrapper .breadcrumb li.active .link:after{background-color:#ffdd00;}
            .page-title .page-title-wrapper .breadcrumb{border-bottom:1px solid #ffdd00;}
            .page-title-wrapper .breadcrumb li.active .link:after{background-color:#ffdd00;}
            .page-title .page-title-wrapper .breadcrumb > li a{opacity: 0.8}
            .page-title .captions{color:#ffffff;font-weight:bold;text-transform:uppercase;}
            #page-sidebar .widget{margin-bottom:50px}
            .footer-main-container {background-color: #292F32;background-image: url("{{ asset('')}}images/bg-footer.jpg");background-repeat: no-repeat;background-attachment: fixed;background-position:center center;background-size:cover;}
            .footer-main {background-color:rgba(0, 0, 0, 0);}
            .page-404{background-color: #ffffff;background-image: url("{{ asset('')}}images/bg-section-404.jpg");background-repeat: no-repeat;background-attachment: ;background-position: center center;background-size:cover;}
            .page-register {background-image: url("{{ asset('')}}images/hotel-result.jpg");}
            .page-login {background-image: url("{{ asset('')}}images/hotel-result.jpg");}a{color:#555e69}a:hover{color:#ffdd00}a:active{color:#ffdd00}}
    </style>
    <!-- End Dynamic Styling -->
    <!-- Start Dynamic Styling only for desktop -->
    <style type="text/css">
        @media screen and (min-width: 767px) {.page-title{background-color: #f3f3f3;background-image: url("{{ isset($banner) && $banner->images ? asset('image/' . $banner->images) : asset('image/no-photo.jpg') }}");background-repeat: no-repeat;background-attachment: fixed;background-position:center center;background-size:cover;text-align:left;}.page-title{height:540px;}.page-title .page-title-wrapper .breadcrumb > li .link.home{font-size:20px;}.page-title .page-title-wrapper .breadcrumb > li .link{font-size:12px;}.page-title .page-title-wrapper .breadcrumb > li,.page-title .page-title-wrapper .breadcrumb > li a,.page-title .page-title-wrapper .breadcrumb > li.active{font-size:20px;}.page-title .captions{font-size:46px;}}</style> <!-- End Dynamic Styling only for desktop -->
    <!-- Custom Styling -->
    <style type="text/css">
        body{
            margin: 0 auto;
        }
        .main-content .page-banner.homepage-default {
            background-color:#152d49;
        }
        #header-options-form {
            display: none;
        }
        .slz-woocommerce .products .type-product:before {
            box-shadow: 0 0 1px rgba(0, 0, 0, 0.2);
        }
        .slz-woocommerce li.type-product .img-wrapper {
            background-color:#ffffff;
        }
        .slz-woocommerce .col-md-12 .products .type-product {
            margin-bottom:30px;
        }
        header .woocommerce ul.product_list_widget {
            margin-top: 0;
        }
        .car-rent-layout-2 .group-button {
            display:table;
            width: 100%;
        }
        .traveler .wrapper-content .description {
            font-size: 0;
        }
        .traveler .wrapper-content .description p {
            font-size: 14px;
            display:inline;
        }
        @media screen and (max-width: 600px) {
            .rlp-table {
                padding: 30px 15px;
            }

        }
        @media screen and (max-width : 600px) {
            .rating-widget.widget , .city-widget.widget {
                display: none;
            }
        }
        .notifications {
            position: fixed;
            right: 0px;
            top: 0px;
            z-index: 2;
            padding: 0;
            margin: 0;

        }
        .notifications li{
            background: #ff6a00;
            padding-right: 5px;
            color: #ffffff;
            font-weight: bold;
            max-width: 320px;
            display: block;
            position: relative;
            box-shadow: -2px 2px 2px rgba(0, 0, 0, 0.5);
            border-top: 1px solid rgba(255, 255, 255, 0.3);
        }
        .notifications li:first-child {
            border-top: 0;
        }
        .thumbnail img{
            width: 100%;
        }
        .campaign-black-friday-18 .block-countdown {
        width: 100%;
        background: url("{{ asset('')}}images/5bf28e98a1b7d-bg-countdow.png") no-repeat center top;
        padding: 103px 363px 100px;
        }
        .campaign-black-friday-18 {
        width: 100%;
        padding: 0;
        overflow: hidden;
        background: #040203 url("{{ asset('')}}images/5bf22aa100946-bg.jpg") no-repeat center top;
        }
        .bg-transparent {
    background-color: #ca0000;}
    </style>

@stop
@section('main')


<div class="campaign-black-friday-18">
                <!-- edit compaing -->
               
                <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="block-countdown" style="display: none;">
                        <div class="text-title"><p id="titlegiovang">Chương trình sẽ bắt đầu sau</p></div>
                        <div
                          class="timer"
                          data-status="stop"
                          data-current="1543683636"
                          data-start="1542938401"
                          data-end="1542992399"
                        >
                          <div class="numbers day">
                            <span class="number"><p id="giovangdays"></p></span> <span>Ngày</span>
                          </div>
                          :
                          <div class="numbers hour">
                            <span class="number"><p id="giovanghours"></p></span> <span>Giờ</span>
                          </div>
                          :
                          <div class="numbers minute">
                            <span class="number"><p id="giovangminutes"></p></span> <span>Phút</span>
                          </div>
                          :
                          <div class="numbers seconds">
                            <span class="number"><p id="giovangseconds"></p></span> <span>Giây</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <p id="giovang" val = <?= $golden_hour->content ?> style="font-size: 29px;color: red"></p>
                    <script>
                        // Set the date we're counting down to
                        //var countDownDate = new Date("Jan 5, 2019 15:37:25").getTime();
                        var countDownDate = <?php echo strtotime($golden_hour->content) ?> * 1000;
                        // Update the count down every 1 second
                        var x = setInterval(function() {
                            // Get todays date and time
                            var now = new Date().getTime();
                            // Find the distance between now and the count down date
                            var distance = countDownDate - now;
                           
                            if (distance<0) {
                                document.getElementById("titlegiovang").innerHTML =  " SẼ KẾT THÚC SAU";
                                var now = new Date();
                                document.getElementById("block-main-hot").classList.remove('hide');
                                countDownDates=new Date(countDownDate);
                                countDownDates.setHours(countDownDates.getHours()+2);
                                countDownDates=countDownDates.getTime();
                                var distance = countDownDates - now;
                                if (distance < 0) {
                                    document.getElementById("titlegiovang").innerHTML =  " ĐÃ KẾT THÚC";
                                    distance=0;
                                    if(!document.getElementById("block-main-hot").classList.add('contains')){
                                      document.getElementById("block-main-hot")
                                    }
                                    
                                }
                            }
                            else{
                              if(!document.getElementById("block-main-hot").classList.add('contains')){
                                      document.getElementById("block-main-hot")
                                    }
                            }
                            // Time calculations for days, hours, minutes and seconds
                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                            // Display the result in the element with id="demo"
                            document.getElementById("giovangdays").innerHTML = days;
                            document.getElementById("giovanghours").innerHTML = hours;
                            document.getElementById("giovangminutes").innerHTML = minutes;
                            document.getElementById("giovangseconds").innerHTML = seconds;
                            // If the count down is finished, write some text 
                        }, 1000);
                    </script>
                    <!-- <div class="col-md-12">
                      <div class="block-pic-nav menu-scroll-tab-1">
                        <div class="block-col">
                          <a data-id="food" href="javascript:void(0);"
                            ><img
                              src="{{ asset('')}}images/contact-people.png"
                          /></a>
                        </div>
                        <div class="block-col">
                          <a data-id="spa" href="javascript:void(0);"
                            ><img
                              src="{{ asset('')}}images/contact-people.png"
                          /></a>
                        </div>
                        <div class="block-col">
                          <a data-id="du-lich" href="javascript:void(0);"
                            ><img
                              src="{{ asset('')}}images/contact-people.png"
                          /></a>
                        </div>
                      </div>
                    </div> -->
                    <div class="block-logo-banner clearfix">
                      
                    <div class="col-md-12">
                 
                      <div class="item-list-product">
                        <div class="product-hot " id="">
                          <div class="block tab-style-1">
                            <div class="block__content tab-content clearfix">
                              <div role="tabpanel"class="tab-pane active"id="tab0">
                                @if(count($startdates))
                                <div class="row products" id="block-main-hot">
                                    @foreach($startdates as $startdate)
                                    <?php 
                                    $images = $startdate->tour->images ? explode(';', $startdate->tour->images) : [];
                                    $image = count($images) ? rtrim($images[0], '.') : '';
                                    ?>
                                    <div class="col-md-4 product-wrapper " id="product-352578-wrapper" data-id="352578" data-show="1" data-text="" data-campaign-time="0">
                                        <div class="product product-kind-1" id="product-352578"  data-toggle="box-link" data-target="_blank">
                                            <div class="product__image">
                                                <a target="_blank"href="{{asset($startdate->tour->slug)}}"title="{{$startdate->tour->title}}">
                                                    <img itemprop="image"class="lazy b-loaded" src="{{ $image ? asset('image/'. $image) : asset('image/no-photo.jpg') }}"alt="{{$startdate->tour->title}}"/>
                                                    <span class="icon-hot hot">ĐANG GIẢM 200k</span>
                                                    <div class="item__meta">
                                                        <div class="countdown-timer"><i class="hd hd-clock"></i>Số lượng có hạn</div>
                                                        <span class="view" href="{{asset($startdate->tour->slug)}}">XEM CHƯƠNG TRÌNH</span>
                                                    </div>
                                                </a>
                                          </div>

                                          <div class="product__header">
                                            <h3 class="product__title">
                                              <a target="_blank" href="{{asset($startdate->tour->slug)}}" itemprop="name" title="{{$startdate->tour->title}}">{{$startdate->tour->title}}</a>
                                              <meta itemprop="brand" content="" />
                                          </h3>
                                      </div>
                                      <div class="product__info">
                                        <div class="product__price _product_price" itemprop="offers" itemscope=""  >
                                          <meta itemprop="priceCurrency" content="VND" />
                                          <span class="price">
                                            <span class="price__value" itemprop="price"  >{{number_format($startdate->tour->adultprice)}}
                                            </span>
                                            <span class="price__symbol">đ</span>
                                            <span class="price__discount"> 200kđ</span>
                                        </span>
                                    </div>
                                    <div class="product__price product__price--list-price _product_price_old " style="display: inline-block;">
                                      <span class="price price--list-price">
                                        <span class="price__value"> {{number_format($startdate->tour->adultprice+200000)}}</span>
                                        <span class="price__symbol">vnđ</span>
                                    </span>
                                </div>
                                <div class="product__stats"></div>
                            </div>
                            <div class="box-small-count">
                                <div class="box-bar">
                            khởi hành: Giỗ Tổ \
                                  <div class="bar-content">
                                    <div class="box-percent" ">
                                      
                                  </div>
                              </div>
                          </div>
                          <div class="box-count">
                             
                              <button type="button" class="btn btn-success btn-sm  bt-mua-ngay" data-toggle="modal"
                                      data-target="#consultModal" data-tour-id="{!! $startdate->tour->id !!}">TÔI CẦN TƯ VẤN</button>
                          </div>
                      </div>
                  </div>
              </div>
              @endforeach
          </div>
          @endif
      </div>
  </div>
</div>

                          <div class="group-btn-show-more clearfix bt-read-more">
                        
                        
                        <!--<div class="logo-partner">
                          <div class="logo-partner-content">
                            <div
                              id="carousel-logo"
                              class="carousel slide"
                              data-ride="carousel"
                            >
                              <div class="carousel-inner" role="listbox">
                                <div class="item">
                                  <ul class="item-logo-partner">
                                    <img src="http://haidangtravel.com/image/tet-duong-lich-hinh-1.jpg">
                                  </ul>
                                </div>
                                <div class="item active">
                                  <div class="item-logo-partner">
                                    <ul class="item-logo-partner">
                                     <li>
                                      <img src="http://haidangtravel.com/image/15-ngay-nhan-qua-hinh-1.jpg">
                                    </li>
                                    </ul>
                                  </div>
                                </div>
                                <div class="item">
                                  <div class="item-logo-partner">
                                    <ul class="item-logo-partner">
                                     <img src="http://haidangtravel.com/image/Thai-Lan-gia-re-hinh-1.jpg">
                                    </ul>
                                  </div>
                                </div>
                              </div>
     
                              <a
                                class="pre-logo"
                                href="#carousel-logo"
                                role="button"
                                data-slide="prev"
                              >
                                <i
                                  class="fa fa-chevron-left"
                                  aria-hidden="true"
                                ></i>
                              </a>
                              <a
                                class="next-logo"
                                href="#carousel-logo"
                                role="button"
                                data-slide="next"
                              >
                                <i
                                  class="fa fa-chevron-right"
                                  aria-hidden="true"
                                ></i>
                              </a>
                            </div>
                          </div>
                        </div>-->
                      </div>
                   
                            <!-- <div class="div-btn-show-more text-center">
                              <button
                                class="btn btn-default btn-show-more"
                                data-hide="0"
                                onclick="showMore(this)"
                              >
                                Xem thêm
                                <span
                                  class="glyphicon glyphicon-chevron-down"
                                ></span>
                              </button>
                              <button
                                class="btn btn-default btn-hide-more hidden"
                                onclick="hideProductMore(this)"
                              >
                                Ẩn đi
                                <span
                                  class="glyphicon glyphicon-chevron-up"
                                ></span>
                              </button>
                            </div> -->
                          </div>
                        </div>
                        <style>
                          .product-hot .products {
                            position: relative;
                          }

                          .product-hot .disable-deal {
                            width: 100%;
                            height: 100%;
                            position: absolute;
                            top: 0px;
                            left: 0px;
                            background-color: rgba(255, 255, 255, 0.7);
                            z-index: 10;
                          }

                          .product-hot .title {
                            text-transform: uppercase;
                            font-weight: 600;
                            background-color: #fff;
                            border-top: thin solid #dedede;
                            margin: 0px;
                            padding: 30px 0px;
                          }

                          .group-btn-show-more {
                            position: relative;
                            margin-top: -20px;
                            margin-bottom: 20px;
                          }

                          .div-btn-show-more {
                            width: 100%;
                            position: absolute;
                            top: 5px;
                            left: 0px;
                          }

                          .div-btn-show-more .btn-show-more,
                          .div-btn-show-more .btn-hide-more {
                            background-color: #e7e7e7;
                            color: #999999;
                            border: thin solid #e6e6e6;
                          }

                          .div-btn-show-more .btn-show-more span {
                            color: #aaa;
                          }

                          @media screen and (max-width: 767px) {
                            .product-hot .title {
                              font-size: 16px;
                            }
                          }
                        </style>
                      </div>
                    </div>
                  </div>
                </div>
                <!--<div class="other-campaign">
                  <div class="container">
                    <div class="row">
                      <div class="">
                        <div class="tt-other">
                          xem thêm Các chương trình khuyến mãi hấp dẫn
                        </div>
                      </div>
                      <div class="">
                        <div class="col-md-6 content-pic">
                          <a
                            target="_blank"
                            href="/"
                            ><img
                              src="{{ asset('')}}image/10-dia-diem-du-lich-da-Nang-dep-nhat-hinh-1.jpg"
                          /></a>
                        </div>
                        <div class="col-md-6 content-pic">
                          <a
                            target="_blank"
                            href="/"
                            ><img
                              src="{{ asset('')}}image/â€‹Mua-hoa-rau-muong-bien-hinh-1.jpg"
                          /></a>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="col-md-6 content-pic">
                          <a
                            target="_blank"
                            href="/"
                            ><img
                              src="{{ asset('')}}image/Binh-Lap-hinh-1.jpg"
                          /></a>
                        </div>
                        <div class="col-md-6 content-pic">
                          <a
                            target="_blank"
                            href="/"
                            ><img
                              src="{{ asset('')}}image/blog-demo1-hinh-1.jpg"
                          /></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>-->
              </div>   
              <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ĐĂNG KÝ GIỜ VÀNG</h4>
        </div>
        <div class="modal-body">
        <p>VÉ GIỜ VÀNG CHỈ CÒN: <b>02 VÉ</b> </p>

            Quý khách liên hệ: 19002011 để được tư vấn chi tiết.
        </p>

          <!-- phải đăng nhập mới mua đc tour - Nếu chưa có tài khoản phải đăng nhập trước khi mua, còn nếu đăng nhập thì hiển thị khung đăng nhâp như dưới -->
          <form method="post" action="http://haidangtravel.com/login">
            <div class="login-submit">
                <input type="submit" class="btn btn-maincolor" name="login" value="Đăng nhập">
               
            </div>
        </form>

    </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Mua </button>
        </div>
      </div>
      
    </div>
  </div>
<div id="consultModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content ">
            {!! Form::open([]) !!}
            <div class="modal-body ">
                <input type="hidden" name="tour_id" id="tour_contact_id" value="">
                <div class="count">
                    <p>Nhập SĐT chúng tôi sẽ liên lạc với bạn trong 5 phút !!!</p>
                    <span class="countdown-consult"></span>
                    <div class="form-group">
                        <input type="text" class="form-control" name="phone" id="ConsultPhone"
                               placeholder="Điện thoại liên lạc">
                    </div>
                    <div class="alert alert-danger" style="display: none;">
                        <strong>Có lỗi !</strong>
                        <ul>
                            <li class="ErrorConssult"></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"  class="btn btn-default" onclick="SubmitAdvice(this)">Gửi</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
</div>
@stop
@section('scripts')
<script>
    $(document).ready(function (e) {
        $("#consultModal").on('shown.bs.modal', function (event) {
            var button = $(event.relatedTarget) //
            $('#tour_contact_id').val(button.attr('data-tour-id'));
            $('#ConsultPhone')[0].focus();
            $(this).find('.alert.alert-danger').hide();
        });
        var consultModal = setInterval(function(){
            if(openModel === false){
                $('#consultModal').modal();
                openModel = true;
            }

        },45000);
    });
    function SubmitAdvice(node) {
        var phone = $('#ConsultPhone').val();
        var form = $('#ConsultPhone').closest('form');
        if(validatePhone(phone)){
            var data = {};
            data.tour_id = $('#tour_contact_id').val();
            $(form).find('input').each(function(index,element){
                data[$(element).attr('name')] = $(element).val();
            });
            $.ajax({
                url:  '{!! asset('/') !!}consult/send',
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

@stop

