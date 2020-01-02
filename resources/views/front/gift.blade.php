@extends('front.template')
@section('title')
    <title>Gift</title>
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
    <style>
        .wishlist_table .add_to_cart,
        a.add_to_wishlist.button.alt {
            border-radius: 16px;
            -moz-border-radius: 16px;
            -webkit-border-radius: 16px;
        }
    </style>

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
    <!-- Start Dynamic Styling -->
    <style type="text/css">
        @media screen {
            #wrapper-content .section.page-detail {
                padding-top: 0px;
                padding-bottom: 0px;
            }
            .homepage-banner-content .group-title .banner {
                font-size: px;
            }
            .homepage-banner-content .group-title .sub-banner {
                font-size: px;
            }
            body {
                background-color: #ffffff;
                background-repeat: no-repeat;
                background-attachment: ;
                background-position: center center;
                background-size: cover;
            }
            .page-title {
                background-image: url("images/old-1130738_1920.jpg");
            }
            .page-title:before {
                content: "";
                position: absolute;
                width: 100%;
                height: 100%;
                left: 0;
                top: 0;
                background-color: rgba(52, 73, 94, 0.23)
            }
            .page-title .page-title-wrapper .breadcrumb>li .link.home {
                color: #ffffff;
                font-weight: 400;
                text-transform: uppercase;
            }
            .page-title .page-title-wrapper .breadcrumb>li .link {
                color: #ffffff;
            }
            .page-title .page-title-wrapper .breadcrumb>li .link {
                font-weight: 400;
                text-transform: uppercase;
            }
            .page-title .page-title-wrapper .breadcrumb>li+li:before,
            .page-title .page-title-wrapper li.active .link:after {
                color: #ffffff;
            }
            .page-title-wrapper .breadcrumb li.active .link:after {
                background-color: #ffdd00;
            }
            .page-title .page-title-wrapper .breadcrumb {
                border-bottom: 1px solid #ffdd00;
            }
            .page-title-wrapper .breadcrumb li.active .link:after {
                background-color: #ffdd00;
            }
            .page-title .page-title-wrapper .breadcrumb>li a {
                opacity: 0.8
            }
            .page-title .captions {
                color: #ffffff;
                font-weight: 900;
                text-transform: uppercase;
            }
            #page-sidebar .widget {
                margin-bottom: 50px
            }
            .footer-main-container {
                background-color: #292F32;
                background-image: url("images/bg-footer.jpg");
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-position: center center;
                background-size: cover;
            }
            .footer-main {
                background-color: rgba(0, 0, 0, 0);
            }
            .page-404 {
                background-color: #ffffff;
                background-image: url("images/bg-section-404.jpg");
                background-repeat: no-repeat;
                background-attachment: ;
                background-position: center center;
                background-size: cover;
            }
            .page-register {
                background-image: url("images/hotel-result.jpg");
            }
            .page-login {
                background-image: url("images/hotel-result.jpg");
            }
            a {
                color: #555e69
            }
            a:hover {
                color: #ffdd00
            }
            a:active {
                color: #ffdd00
            }
        }
    </style>
    <!-- End Dynamic Styling -->
    <!-- Start Dynamic Styling only for desktop -->
    <style type="text/css">
        @media screen and (min-width: 767px) {
            .page-title {
                background-color: #f3f3f3;
                background-image: url("images/old-1130738_1920.jpg");
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-position: center center;
                background-size: cover;
                text-align: left;
            }
            .page-title {
                height: 540px;
            }
            .page-title .page-title-wrapper .breadcrumb>li .link.home {
                font-size: 20px;
            }
            .page-title .page-title-wrapper .breadcrumb>li .link {
                font-size: 12px;
            }
            .page-title .page-title-wrapper .breadcrumb>li,
            .page-title .page-title-wrapper .breadcrumb>li a,
            .page-title .page-title-wrapper .breadcrumb>li.active {
                font-size: 20px;
            }
            .page-title .captions {
                font-size: ;
            }
        }
    </style>
    <!-- End Dynamic Styling only for desktop -->
    <!-- Custom Styling -->
    <style type="text/css">
        body {
            margin: 0 auto;
        }

        .main-content .page-banner.homepage-default {
            background-color: #152d49;
        }

        #header-options-form {
            display: none;
        }

        .slz-woocommerce .products .type-product:before {
            box-shadow: 0 0 1px rgba(0, 0, 0, 0.2);
        }

        .slz-woocommerce li.type-product .img-wrapper {
            background-color: #ffffff;
        }

        .slz-woocommerce .col-md-12 .products .type-product {
            margin-bottom: 30px;
        }

        header .woocommerce ul.product_list_widget {
            margin-top: 0;
        }

        .car-rent-layout-2 .group-button {
            display: table;
            width: 100%;
        }

        .traveler .wrapper-content .description {
            font-size: 0;
        }

        .traveler .wrapper-content .description p {
            font-size: 14px;
            display: inline;
        }

        @media screen and (max-width: 600px) {
            .rlp-table {
                padding: 30px 15px;
            }
        }
    </style>
    <style type="text/css" data-type="vc_shortcodes-custom-css">
        .vc_custom_1463096648310 {
            padding-top: 100px !important;
            padding-bottom: 30px !important;
        }

        .vc_custom_1463027505022 {
            padding-top: 65px !important;
            padding-bottom: 100px !important;
            background-image: url(images/bg-section-tour.jpg?id=405) !important;
        }

        .vc_custom_1463028221790 {
            padding-top: 65px !important;
            padding-bottom: 100px !important;
            background-image: url(images/bg-section-hotel.jpg?id=218) !important;
        }

        .vc_custom_1463017194672 {
            background-color: #cccccc !important;
        }

        .vc_custom_1462950433649 {
            padding-top: 100px !important;
            padding-bottom: 60px !important;
        }

        .vc_custom_1463037646466 {
            padding-top: 65px !important;
            padding-bottom: 100px !important;
            background-color: #fafafa !important;
        }

        .vc_custom_1468574547376 {
            padding-bottom: 30px !important;
        }

        .vc_custom_1463109325289 {
            padding-bottom: 40px !important;
        }

        .vc_custom_1463027357222 {
            margin-bottom: 0px !important;
        }
        .videos.layout-1 .video-thumbnail{
            bottom: -50px;
        }
    </style>
     <style id='slzexploore-custom-inline-inline-css' type='text/css'>
        .main-content .page-banner-2.homepage-02,
        .main-content .page-banner.homepage-default,
        .main-content .page-banner-2.homepage-03 {
            background-image: url({{ asset('image/'.$hometopbanner->images) }});
        }
    </style>
    <noscript>
        <style type="text/css"> .wpb_animate_when_almost_visible { opacity: 1; }</style>
    </noscript>
@stop
@section('main')
<section class="page-banner homepage-default" style="top: -183px; margin-bottom: -233px;">
    <div class="homepage-banner-warpper">
        <div class="homepage-banner-content">
            <div class="group-btn">
                <a href="/tour-sieu-khuyen-mai" data-hover="XEM NGAY" class="btn-click"><span class="text">TOUR SIÊU KHUYẾN MÃI</span>
                    <span class="icons fa fa-long-arrow-right"></span>
                </a>
            </div>
        </div>
    </div>
</section>
<div class="section section-padding page-detail padding-top padding-bottom">
    <div class="container">
        <div class="row">
            <div id="page-content" class="col-md-12 col-xs-12">
                <div id="post-45" class="post-45 page type-page status-publish hentry">
                    <div class="section-page-content clearfix ">
                        <div class="entry-content">
                            <div class="group-title">
                                <div class="sub-title">
                                    <p class="text">Dành cho bạn</p><i class="icons flaticon-people"></i>
                                </div>
                                <h2 class="main-title">Trang Quà Tặng</h2>
                            </div>
                            @if(session()->has('ok'))
                                @include('partials/error', ['type' => 'success', 'message' => session('ok')])
                            @else
                                @if(session()->has('error'))
                                    @include('partials/error', ['type' => 'danger', 'message' => session('error')])
                                @endif
                            @endif
                            <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                                @foreach ($gifts as $index=>$gift)
                                    <div class="hide">{!!$index+1!!}</div>
                                    <div class="list-promotion-item" style="">
                                        <div class="thumb 1" data-toggle="modal" data-target="#giftHistory_{{$index}}" >
                                            <div class="badge zero "></div>
                                            <img 
                                            style="white-space:pre-line" class="bg" alt="{{ $gift->title }}"
                                            src="{{ asset('')}}image/Tour-Nhat-Ban-Tokyo-Narita-Fuji-Kamakura-khuyen-mai-hinh-1.jpg">
                                            <div class="text-container">
                                                <p>
                                                    <span class="thumb-partner-name ">{{ $gift->title }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="giftHistory_{{$index}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                    <h3 class="modal-title TextEllipsis" title="{{ $gift->title }}">{{ $gift->title }}</h3>
                                                </div>
                                                <div class="modal-body" id="text">
                                                    <div class="row">
                                                        <div class="col-md-4 col-xs-12">
                                                            <div class="col-md-12 col-xs-12" style="padding-bottom: 20px">
                                                                <div class="info-carousel-container">
                                                                    <div class="ngSlider" >
                                                                        <div class="slide active" >
                                                                            <img src="{{ asset('')}}image/Tour-Nhat-Ban-Tokyo-Narita-Fuji-Kamakura-khuyen-mai-hinh-1.jpg">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-xs-12">
                                                                <div class="col-md-12 col-xs-12 "  style="">
                                                                    <label class="text-danger hide" style="text-align:center">Ưu đãi này không nhận được trên web</label>
                                                                </div>
                                                                <div class="col-md-12 col-xs-12" >
                                                                    @if(!auth()->check())
                                                                        <a href="{{ asset('login')}}"><button class="btn-style" >Đăng nhập</button></a>
                                                                    @else
                                                                        {!! Form::open(['url' => 'giftReceive', 'method' => 'post']) !!}
                                                                        <input type="hidden" value="{{auth()->user()->id}}" name="id"/>
                                                                        <input type="hidden" value="{{$gift->id}}" name="index"/>
                                                                        <button  type="submit" class="btn-style" >Nhận</button>
                                                                        {!! Form::close() !!}   
                                                                    @endif
                                                                </div>                                                               
                                                                <div class="col-md-12 col-xs-12">
                                                                    <button type="button" class="btn-style" data-dismiss="modal">Đóng</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 col-xs-12">
                                                            <div class="col-md-12 col-xs-12 content-container">
                                                                <div class="col-md-12 col-xs-12">
                                                                    <h5 class="text-success"><b >Số điểm cần: {!! $gift->point !!}</b></h5>
                                                                    <h5 class="text-success"><b >Số điểm hiện tại của bạn: </b><b class="text-danger">{{auth()->check()?auth()->user()->point:0 }}</b></h5>
                                                                </div>
                                                                <div class="col-md-12 col-xs-12">
                                                                    <div class="panel panel-info">
                                                                        <div class="panel-heading">
                                                                            GIỚI THIỆU 
                                                                        </div>
                                                                        <div class="panel-body collapse show" id="ctud" style="background-color: white;">
                                                                            <p ><p><strong>Chi tiết sản phẩm: </strong>{!! $gift->description !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="modal-footer">
                                            
                                            </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                @endforeach   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #section -->
</div>


@stop

@section('scripts')
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') !!}
@stop

