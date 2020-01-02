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
            .page-title{background-image: url("{{ asset('image/'.$cate_banner)}}");}
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
        @media screen and (min-width: 767px) {.page-title{background-color: #f3f3f3;background-image: url("{{ asset('image/'.$cate_banner)}}");background-repeat: no-repeat;background-attachment: fixed;background-position:center center;background-size:cover;text-align:left;}.page-title{height:540px;}.page-title .page-title-wrapper .breadcrumb > li .link.home{font-size:20px;}.page-title .page-title-wrapper .breadcrumb > li .link{font-size:12px;}.page-title .page-title-wrapper .breadcrumb > li,.page-title .page-title-wrapper .breadcrumb > li a,.page-title .page-title-wrapper .breadcrumb > li.active{font-size:20px;}.page-title .captions{font-size:46px;}}</style> <!-- End Dynamic Styling only for desktop -->
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

    </style>

@stop
@section('main')
<section class="exploore page-title">
    <div class="container">
        <div class="page-title-wrapper">
            <div class="page-title-content">
                <div class="page-title-content">
                    <ol class="breadcrumb">
                        <li class="active">
                            <a href="/" class="link home">Trang chủ</a>
                        </li>
                    </ol>
                    <div class="clearfix"></div>
                    <h3 style="padding-bottom: 10px;" class="captions"><?= $author->fullname ?></h3>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="tour-result-main padding-top padding-bottom">

    <div class="container">
        <div class="result-body block-12574292385a9658c723a39">
            <div class="row">
                <div id="page-content" class="col-md-12 main-right col-xs-12">

                    <div class="tours-result-content" style="text-align: center;">
                        <div class="tours-list">
                            <div class="row tourcate-main">
                                @foreach($tours as $tour)
                                    @if(isset($destinationpoint))
                                        @if(class_basename($destinationpoint)==='SubjectTour')
                                        @include('partials.toursearch',['tour'=>$tour ,'inCate'=>1 ,'current_sjt'=>$destinationpoint])
                                        @endif
                                        @if(class_basename($destinationpoint)==='DestinationPoint')
                                            @include('partials.toursearch',['tour'=>$tour ,'inCate'=>1 ,'current_dp'=>$destinationpoint])
                                        @endif
                                    @else
                                        @include('partials.toursearch',['tour'=>$tour ,'inCate'=>1 ])
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <?php
                            $counttour = $tours->count();
                            $remain = ($counttour-10);
                            $remain = $remain<0?0:$remain;$strload = ($remain==0)?'HẾT':'XEM THÊM ('.$remain.')';
                        ?>
                        {!! HTML::link('',$strload,['id'=>'in-view','rel'=>'pulse-grow','class'=>'btn-u btn-u-orange pulse-grow ajax-end' ,'data-total'=>$counttour]) !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop