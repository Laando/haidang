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
        .page-title{
            position: relative;
        }
        #wrapper-content .section.page-detail{
            padding-bottom: 0;
        }

    </style>

@stop
@section('main')
<section class="exploore page-title" style="top: -183px;
    margin-bottom: -183px;">
    <div class="container">
        <div class="page-title-wrapper">
            <div class="page-title-content">
                <a href="{{asset('/')}}">
                    <ol class="breadcrumb">
                        <li class="active">
                            <a class="link home">
                                Trang chủ
                            </a>
                        </li>
                    </ol>
                </a>
                <div class="clearfix"></div>
                <h2 class="captions">{{$config->title}}</h2>
            </div>
        </div>
    </div>
</section>
<div class="section section-padding page-detail padding-top padding-bottom" style="background-color: #fff">
    <div class="container">
        <div class="row">
            <div id="page-content" class="col-md-12 col-xs-12">
                <div id="post-537" class="post-537 page type-page status-publish hentry">
                    <div class="section-page-content clearfix ">
                        <div class="entry-content">
                            <div class="vc_row wpb_row vc_row-fluid vc_custom_1463045167639">
                                <div class="slz_col-sm-12 wpb_column vc_column_container vc_col-sm-6">
                                    <div class="vc_column-inner vc_custom_1463110533434">
                                        <div class="wpb_wrapper">
                                            <div class="slz-shortcode block-title-8583801585b73a8dc5838e ">
                                                <h3 class="title-style-2">HAIDANGTRAVEL</h3>
                                            </div>
                                            <div class="wpb_text_column wpb_content_element  vc_custom_1463035461905">
                                                <div class="wpb_wrapper">
                                                    <p>Là một đơn vị chuyên nghiệp trong lĩnh vực du lịch lữ hành. Với đội ngũ hơn 10 năm kinh nghiệm trong ngành, Sứ mệnh của chúng tôi là mang đến cho mọi người và mọi tổ chức trong và ngoài nước có những hành trình đa dạng và phong phú. Giúp mọi người có một tinh thần thoải mái, đồng thời chúng tôi sẽ truyền cho mọi người và mọi tổ chức trên hành trình sức mạnh và khả năng để họ đạt được nhiều điều hơn trong cuộc sống qua từng địa danh trên thế giới</p>
                                                </div>
                                            </div>
                                            <div class="wpb_text_column wpb_content_element  vc_custom_1463035502319">
                                                <div class="wpb_wrapper">
                                                    <h4>THÔNG TIN CHUNG</h4>
                                                    <p>Tên giao dịch tiếng Việt: CÔNG TY CỔ PHẦN XÂY DỰNG DU LỊCH HẢI ĐĂNG</p>
                                                    <p>Tên giao dịch tiếng Anh: Hai Dang Travel Joint Stock Company</p>
                                                    <p>Tên viết tắt: Hai Dang Travel</p>
                                                    <p>Địa Chỉ: Haidang Building - 357 Tân Sơn, Phường 15, Quận Tân Bình, Tp.HCM</p>
                                                    <p>Slogan: "Du Lịch Hải Đăng - Thắp Sáng Niềm Tin" ["Hai Dang Travel - Light Up The Hopes"]</p>
                                                    <p>Email: info@haidangtravel.com</p>
                                                    <p>Website: www.haidangtravel.com</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slz_col-sm-12 wpb_column vc_column_container vc_col-sm-6">
                                    <div class="vc_column-inner vc_custom_1463110545882">
                                        <div class="wpb_wrapper">
                                            <div class="wpb_single_image wpb_content_element vc_align_left  wpb_animate_when_almost_visible wpb_right-to-left right-to-left vc_custom_1463045413267 wpb_start_animation animated">
                                                <figure class="wpb_wrapper vc_figure">
                                                    <div class="vc_single_image-wrapper   vc_box_border_grey">
                                                        <img width="570" height="533" src="http://wp.swlabs.co/exploore/wp-content/uploads/2016/05/about-us-4-1.png" class="vc_single_image-img attachment-full" alt="about-us-4" srcset="http://wp.swlabs.co/exploore/wp-content/uploads/2016/05/about-us-4-1.png 570w, http://wp.swlabs.co/exploore/wp-content/uploads/2016/05/about-us-4-1-300x281.png 300w" sizes="(max-width: 570px) 100vw, 570px">
                                                    </div>
                                                </figure>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div data-vc-full-width="true" data-vc-full-width-init="true" class="vc_row wpb_row vc_row-fluid slz-bg_parallax vc_custom_1463130581815 vc_row-has-fill" style="position: relative; left: -247.5px; box-sizing: border-box; width: 1665px; padding-left: 247.5px; padding-right: 247.5px;padding-top: 100px !important;padding-bottom: 60px !important;background-image: url(http://wp.swlabs.co/exploore/wp-content/uploads/2016/05/bg-section-about-values.jpg?id=351) !important;opacity:1">
                                <div class="wpb_column vc_column_container vc_col-sm-12">
                                    <div class="vc_column-inner vc_custom_1463036613861">
                                        <div class="wpb_wrapper">
                                            <div class="slz-shortcode block-title-442459705b73a8dc5e5f7 ">
                                                <h3 class="title-style-2">Lĩnh Vực Hoạt Động</h3>
                                            </div>
                                            <div class="vc_row wpb_row vc_inner vc_row-fluid">
                                                <div class="wpb_column vc_column_container vc_col-sm-3">
                                                    <div class="vc_column-inner ">
                                                        <div class="wpb_wrapper">
                                                            <div class="slz-shortcode icon-box-13214151315b73a8dc5f438 ">
                                                                <div class="our-content">
                                                                    <i class="our-icon flaticon-cruise"></i>
                                                                    <div class="main-our">
                                                                        <p class="our-title">Cho Thuê Khách Sạn</p>
                                                                        <div class="text">Haidangtravel hiện tại là đơn vị lữ hành có liên kết tất cả khách sạn trong và ngoài nước với giá cả ưu đãi</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="vc_empty_space" style="height: 40px">
                                                                <span class="vc_empty_space_inner"></span>
                                                            </div>
                                                            <div class="slz-shortcode icon-box-7350980055b73a8dc5fac3 ">
                                                                <div class="our-content">
                                                                    <i class="our-icon flaticon-transport-10"></i>
                                                                    <div class="main-our">
                                                                        <p class="our-title">Tổ Chức Hội Nghị</p>
                                                                        <div class="text">Haidangtravel là một đơn vị chuyên tổ chức event, hội nghị, với đội ngũ trẻ năng động và nhiều kinh nghiệm</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="vc_empty_space" style="height: 40px">
                                                                <span class="vc_empty_space_inner"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="wpb_column vc_column_container vc_col-sm-3">
                                                    <div class="vc_column-inner ">
                                                        <div class="wpb_wrapper">
                                                            <div class="slz-shortcode icon-box-3692882375b73a8dc6068d ">
                                                                <div class="our-content">
                                                                    <i class="our-icon flaticon-security-1"></i>
                                                                    <div class="main-our">
                                                                        <p class="our-title">Tổ Chức Du Lịch</p>
                                                                        <div class="text">Là một đơn vị lữ hành chuyên nghiệp có kinh nghiệm hơn 10 năm tổ chức các tuyến du lịch trong và ngoài nước</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="vc_empty_space" style="height: 40px">
                                                                <span class="vc_empty_space_inner"></span>
                                                            </div>
                                                            <div class="slz-shortcode icon-box-20500931275b73a8dc60d0f ">
                                                                <div class="our-content">
                                                                    <i class="our-icon flaticon-people-6"></i>
                                                                    <div class="main-our">
                                                                        <p class="our-title">Tổ Chức Du Lịch Đoàn</p>
                                                                        <div class="text">Chúng tôi là đơn vị lữ hành chuyên thiết kế tổ chức các chương trình du lịch đoàn chuyên nghiệp với mô hình lớn</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="vc_empty_space" style="height: 40px">
                                                                <span class="vc_empty_space_inner"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="wpb_column vc_column_container vc_col-sm-3">
                                                    <div class="vc_column-inner ">
                                                        <div class="wpb_wrapper">
                                                            <div class="slz-shortcode icon-box-18118030805b73a8dc618fc ">
                                                                <div class="our-content">
                                                                    <i class="our-icon flaticon-direction"></i>
                                                                    <div class="main-our">
                                                                        <p class="our-title">Tổ Chức Teambuilding </p>
                                                                        <div class="text">Là đơn vị chuyên tổ chức các hoạt động dã ngoại và teambuilding cho các nhóm tập thể và công ty</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="vc_empty_space" style="height: 40px">
                                                                <span class="vc_empty_space_inner"></span>
                                                            </div>
                                                            <div class="slz-shortcode icon-box-9904967885b73a8dc61f77 ">
                                                                <div class="our-content">
                                                                    <i class="our-icon flaticon-man"></i>
                                                                    <div class="main-our">
                                                                        <p class="our-title">Đại Lý Vé Máy Bay</p>
                                                                        <div class="text">Là một trong những đại lý vé máy bay giá rẻ, của các hãng bay trong và ngoài nước </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="vc_empty_space" style="height: 40px">
                                                                <span class="vc_empty_space_inner"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="wpb_column vc_column_container vc_col-sm-3">
                                                    <div class="vc_column-inner ">
                                                        <div class="wpb_wrapper">
                                                            <div class="slz-shortcode icon-box-15385249925b73a8dc62af2 ">
                                                                <div class="our-content">
                                                                    <i class="our-icon flaticon-food-3"></i>
                                                                    <div class="main-our">
                                                                        <p class="our-title">Cho Thuê Xe</p>
                                                                        <div class="text">Với đội xe chuyên nghiệp , chúng tôi cung cấp các dòng xe du lịch từ 4 chỗ đến 45 chỗ</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="vc_empty_space" style="height: 40px">
                                                                <span class="vc_empty_space_inner"></span>
                                                            </div>
                                                            <div class="slz-shortcode icon-box-16072429105b73a8dc63198 ">
                                                                <div class="our-content">
                                                                    <i class="our-icon flaticon-food"></i>
                                                                    <div class="main-our">
                                                                        <p class="our-title">Làm Visa - Pass Port</p>
                                                                        <div class="text">Chúng tôi chuyên nhận làm Visa - Pass Port, làm thủ tục du học các quốc gia trên thế giới</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="vc_empty_space" style="height: 40px">
                                                                <span class="vc_empty_space_inner"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="vc_row-full-width vc_clearfix"></div>
                            <div>
                                <div class="vc_column-inner margin-top ">
                                    <div class="wpb_wrapper">
                                        <div class="slz-shortcode sc_team_carousel our-expert  slzexploore_team-18542637685ab188d68cd8e">
                                            <h3 class="title-style-2">Nhân Sự Tiêu Biểu</h3>
                                            <style type="text/css">
                                            .main-employee .slick-prev:before, 
                                            .main-employee .slick-next:before {
                                                color: black;    
                                            }
                                            </style>
                                        <div class="main-employee">
                                                <div class="item">
                                                    <img width="260" height="365" src="/images/ns19.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns20.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns21.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns1.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns2.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns5.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns18.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns4.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns6.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns7.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns3.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns9.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns10.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns11.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns12.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns13.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns14.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns15.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns16.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns17.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns4.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns19.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns20.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns21.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="//images/ns1.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns2.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns5.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div><div class="item">
                                                    <img width="260" height="365" src="/images/ns18.jpg" class="img img-responsive" alt="about-7">
                                                    
                                                </div>
                                        </div>
                                </div>
                            </div>
                            <div class="vc_row-full-width vc_clearfix"></div>
                            <div data-vc-full-width="true" data-vc-full-width-init="true" data-vc-stretch-content="true" class="vc_row wpb_row vc_row-fluid vc_custom_1466999915507 vc_row-no-padding margin-bottom" style="position: relative; left: -247.5px; box-sizing: border-box; width: 1665px;">
                                                                                <div class="wpb_column vc_column_container vc_col-sm-12">
                                                                                    <div class="vc_column-inner ">
                                                                                        <div class="wpb_wrapper">
                                                                                            <div class="slz-shortcode travelers travel-id-5446421865ab348027f789 ">
                                                                                                <div class="container">
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-4">
                                                                                                            <div class="traveler-wrapper padding-top padding-bottom">
                                                                                                                <div class="group-title white">
                                                                                                                    <div class="sub-title">
                                                                                                                        <p class="text">Các Giải Thưởng</p><i class="icons flaticon-people-1"></i>
                                                                                                                    </div>
                                                                                                                    <h2 class="main-title">Tiêu Biểu</h2>               
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <style type="text/css">
                                                                                                            .mar-top-100{margin-top: 100px; }
                                                                                                            .slider .slick-prev, .slider .slick-next {
                                                                                                                width: 50px;
                                                                                                                height: 50px;
                                                                                                                line-height: 50px;
                                                                                                                text-align: center;
                                                                                                                border: 2px solid #fff;
                                                                                                                border-radius: 50%;
                                                                                                                background-color: transparent;
                                                                                                                opacity: 0.5;
                                                                                                                transition: all 0.5s ease;
                                                                                                            }
                                                                                                            
                                                                                                            .slider .slick-prev:before, .slider .slick-next:before {
                                                                                                                font-family: FontAwesome;
                                                                                                                font-size: 24px;
                                                                                                                line-height: 46px;
                                                                                                                color: #fff;
                                                                                                                opacity: 1;
                                                                                                            }
                                                                                                            .slider .slick-prev{ margin-left: -23px; }
                                                                                                            .slider .slick-next{ margin-right: -23px; }
                                                                                                            .slider .slick-dots{ display: none !important; }
                                                                                                        </style>
                                                                                                        <div class="col-md-8 mar-top-100">
                                                                                                            <div class="slider">

                                                                                                                <div class="traveler">
                                                                                                                    <div class="cover-image">
                                                                                                                        <img width="400" height="200" src="/images/giaithuong7.jpg" class="img-responsive" alt="cover-image-4">
                                                                                                                    </div>
                                                                                                                    <div class="wrapper-content">
                                                                                                                        <p class="name">TOP BRANDS</p>
                                                                                                                        <p class="address">2015</p>
                                                                                                                        <div class="description">"<p>Là thương hiệu đạt cúp TOP BRANDS <br> vào năm 2015</p>
                                                                                                                                "</div>
                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                <div class="traveler">
                                                                                                                    <div class="cover-image">
                                                                                                                        <img width="400" height="200" src="/images/giaithuong8.jpg" class="img-responsive" alt="cover-image-4">
                                                                                                                    </div>
                                                                                                                    <div class="wrapper-content">
                                                                                                                         <p class="name">GIẤY KHEN QUẬN TÂN BÌNH</p>
                                                                                                                            <p class="address">2017</p>
                                                                                                                            <div class="description">"<p>Là doanh được được Quận Tân Bình cấp giấy khen vào năm 2017</p>
                                                                                                                                "</div>
                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                <div class="traveler">
                                                                                                                    <div class="cover-image">
                                                                                                                        <img width="400" height="200" src="/images/giaithuong1.jpg" class="img-responsive" alt="cover-image-4">
                                                                                                                    </div>
                                                                                                                    <div class="wrapper-content">
                                                                                                                        <p class="name">TRUSTED BRAND</p>
                                                                                                                        <p class="address">2013</p>
                                                                                                                        <div class="description">"<p>Chúng tôi vinh dư là công ty đạt giải thưởng TRUSTED BRAND vào năm 2013</p>
                                                                                                                            "</div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="traveler">
                                                                                                                   <div class="cover-image">
                                                                                                                        <img width="400" height="200" src="/images/giaithuong2.jpg" class="img-responsive" alt="cover-image-4">
                                                                                                                    </div>
                                                                                                                    <div class="wrapper-content">
                                                                                                                        <p class="name">BRAND PRODUCT SERVICE</p>
                                                                                                                        <p class="address">2013</p>
                                                                                                                        <div class="description">"<p>Là thương hiệu đạt giải thưởng Brand Product Service vào năm 2013</p>
                                                                                                                            "</div>
                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                <div class="traveler">
                                                                                                                     <div class="cover-image">
                                                                                                                        <img width="400" height="200" src="/images/giaithuong3.jpg" class="img-responsive" alt="cover-image-4">
                                                                                                                    </div>
                                                                                                                    <div class="wrapper-content">
                                                                                                                        <p class="name">DOANH NGHIỆP CỐNG HIẾN</p>
                                                                                                                        <p class="address">2013</p>
                                                                                                                        <div class="description">"<p>Là thương hiệu đạt giải thưởng  Doanh Nghiệp Cống hiến vào năm 2013</p>
                                                                                                                            "</div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="traveler">
                                                                                                                    <div class="cover-image">
                                                                                                                        <img width="400" height="200" src="/images/giaithuong4.jpg" class="img-responsive" alt="cover-image-4">
                                                                                                                    </div>
                                                                                                                    <div class="wrapper-content">
                                                                                                                        <p class="name">DOANH NGHIỆP CỐNG HIẾN</p>
                                                                                                                        <p class="address">2016</p>
                                                                                                                        <div class="description">"<p>Là thương hiệu đạt giải thưởng  Doanh Nghiệp Cống hiến vào năm 2016</p>
                                                                                                                            "</div>
                                                                                                                     </div>
                                                                                                                </div>
                                                                                                                <div class="traveler">
                                                                                                                    <div class="cover-image">
                                                                                                                        <img width="400" height="200" src="/images/giaithuong5.jpg" class="img-responsive" alt="cover-image-4"></div>
                                                                                                                        <div class="wrapper-content">
                                                                                                                            <p class="name">TOP BRANDS</p>
                                                                                                                            <p class="address">2015</p>
                                                                                                                            <div class="description">"<p>Là thương hiệu đạt giải thưởng   TOP Brand vào năm 2015</p>
                                                                                                                                "</div>
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                                <div class="traveler">
                                                                                                                     <div class="cover-image">
                                                                                                                        <img width="400" height="200" src="/images/giaithuong6.jpg" class="img-responsive" alt="cover-image-4"></div>
                                                                                                                        <div class="wrapper-content">
                                                                                                                            <p class="name">BRAND PRODUCT SERVICE</p>
                                                                                                                            <p class="address">2016</p>
                                                                                                                            <div class="description">"<p>Là thương hiệu đạt giải thưởng   BRAND PRODUCT SERVICE vào năm 2016</p>
                                                                                                                                "</div>
                                                                                                                            </div>
                                                                                                                </div>

                                                                                                                <div class="traveler">
                                                                                                                    <div class="cover-image">
                                                                                                                        <img width="400" height="200" src="/images/giaithuong7.jpg" class="img-responsive" alt="cover-image-4"></div>
                                                                                                                        <div class="wrapper-content">
                                                                                                                            <p class="name">TOP BRANDS</p>
                                                                                                                            <p class="address">2015</p>
                                                                                                                            <div class="description">"<p>Là thương hiệu đạt cúp TOP BRANDS</br> vào năm 2015</p>
                                                                                                                                "</div>
                                                                                                                            </div>
                                                                                                                </div>
                                                                                                                <div class="traveler">
                                                                                                                     <div class="cover-image">
                                                                                                                        <img width="400" height="200" src="/images/giaithuong8.jpg" class="img-responsive" alt="cover-image-4"></div>
                                                                                                                        <div class="wrapper-content">
                                                                                                                            <p class="name">GIẤY KHEN QUẬN TÂN BÌNH</p>
                                                                                                                            <p class="address">2017</p>
                                                                                                                            <div class="description">"<p>Là doanh được được Quận Tân Bình cấp giấy khen vào năm 2017</p>
                                                                                                                                "</div>
                                                                                                                            </div>
                                                                                                                </div>

                                                                                                                <div class="traveler">
                                                                                                                    <div class="cover-image">
                                                                                                                        <img width="400" height="200" src="/images/giaithuong1.jpg" class="img-responsive" alt="cover-image-4"></div>
                                                                                                                        <div class="wrapper-content">
                                                                                                                            <p class="name">TRUSTED BRAND</p>
                                                                                                                            <p class="address">2013</p>
                                                                                                                            <div class="description">"<p>Chúng tôi vinh dư là công ty đạt giải thưởng TRUSTED BRAND vào năm 2013</p>
                                                                                                                                "</div>
                                                                                                                            </div>
                                                                                                                </div>

                                                                                                                <div class="traveler">
                                                                                                                    <div class="cover-image">
                                                                                                                        <img width="400" height="200" src="/images/giaithuong2.jpg" class="img-responsive" alt="cover-image-4"></div>
                                                                                                                        <div class="wrapper-content">
                                                                                                                            <p class="name">BRAND PRODUCT SERVICE</p>
                                                                                                                            <p class="address">2013</p>
                                                                                                                            <div class="description">"<p>Là thương hiệu đạt giải thưởng Brand Product Service vào năm 2013</p>
                                                                                                                                "</div>
                                                                                                                        </div>
                                                                                                                </div>

                                                                                                              
                                                                                                            </div>

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div> 
                                                                                            </div> 
                                                                                        </div> 
                                                                                    </div> 
                                                                                </div> 
                                                                            </div> 
                                                                        </div>                            
                            <div class="vc_row-full-width vc_clearfix"></div>
                            <div class="vc_row wpb_row vc_row-fluid vc_custom_1463036090880">
                                                                                <div class="wpb_column vc_column_container vc_col-sm-12">
                                                                                    <div class="vc_column-inner ">
                                                                                        <div class="wpb_wrapper">
                                                                                            <div class="slz-shortcode about-banner ">
                                                                                                <h3 class="title-style-2">Khách hàng tiêu biểu</h3>
                                                                                                <div class="wrapper-banner slick-initialized slick-slider">
                                                                                                    <div aria-live="polite" class="slick-list draggable"><div class="slick-track" role="listbox" style="opacity: 1; width: 1140px; left: 0px;"><div class="content-banner slick-slide slick-current slick-active" data-slick-index="0" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide00" style="width: 190px;">
                                                                                                        <a class="img-banner" href="" tabindex="0">
                                                                                                            <img width="200" height="100" src="/images/hd-0.png" class="img-responsive" alt="about-banner-6">
                                                                                                        </a>
                                                                                                        <a class="img-banner" href="" tabindex="0">
                                                                                                            <img width="200" height="100" src="/images/hd-1.png" class="img-responsive" alt="about-banner-1">
                                                                                                        </a>
                                                                                                    </div><div class="content-banner slick-slide slick-active" data-slick-index="1" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide01" style="width: 190px;">
                                                                                                    <a class="img-banner" href="" tabindex="0">
                                                                                                        <img width="200" height="100" src="/images/hd-2.png" class="img-responsive" alt="about-banner-4">
                                                                                                    </a>
                                                                                                    <a class="img-banner" href="" tabindex="0">
                                                                                                        <img width="200" height="100" src="/images/hd-3.png" class="img-responsive" alt="about-banner-3">
                                                                                                    </a>
                                                                                                </div><div class="content-banner slick-slide slick-active" data-slick-index="2" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide02" style="width: 190px;">
                                                                                                <a class="img-banner" href="" tabindex="0">
                                                                                                    <img width="200" height="100" src="/images/hd-4.png" class="img-responsive" alt="about-banner-6">
                                                                                                </a>
                                                                                                <a class="img-banner" href="" tabindex="0">
                                                                                                    <img width="200" height="100" src="/images/hd-5.png" class="img-responsive" alt="about-banner-2">
                                                                                                </a>
                                                                                            </div><div class="content-banner slick-slide slick-active" data-slick-index="3" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide03" style="width: 190px;">
                                                                                            <a class="img-banner" href="" tabindex="0">
                                                                                                <img width="200" height="100" src="/images/hd-6.png" class="img-responsive" alt="about-banner-6">
                                                                                            </a>
                                                                                            <a class="img-banner" href="" tabindex="0">
                                                                                                <img width="200" height="100" src="/images/hd-7.png" class="img-responsive" alt="about-banner-5">
                                                                                            </a>
                                                                                        </div><div class="content-banner slick-slide slick-active" data-slick-index="4" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide04" style="width: 190px;">
                                                                                        <a class="img-banner" href="" tabindex="0">
                                                                                            <img width="200" height="100" src="/images/hd-8.png" class="img-responsive" alt="about-banner-3">
                                                                                        </a>
                                                                                        <a class="img-banner" href="" tabindex="0">
                                                                                            <img width="200" height="100" src="/images/hd-9.png" class="img-responsive" alt="about-banner-4">
                                                                                        </a>
                                                                                    </div><div class="content-banner slick-slide slick-active" data-slick-index="5" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide05" style="width: 189px;">
                                                                                    <a class="img-banner" href="" tabindex="0">
                                                                                        <img width="200" height="100" src="/images/hd-10.png" class="img-responsive" alt="about-banner-2">
                                                                                    </a>
                                                                                    <a class="img-banner" href="" tabindex="0">
                                                                                        <img width="200" height="100" src="/images/hd-11.png">
                                                                                    </a>
                                                                                </div></div></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                            <div class="vc_row-full-width vc_clearfix"></div>
                            <div class="wpb_column vc_column_container vc_col-sm-12">
                                                            <div class="vc_column-inner ">
                                                                <div class="wpb_wrapper">

                                                                    <h4 style="color: #2d3e52;text-align: left" class="vc_custom_heading vc_custom_1466579946490">HÌNH ẢNH CÔNG TY</h4>
                                                                    <div class="slz-shortcode sc_gallery  gallery_8513852135ab3776fee401" data-id="gallery_8513852135ab3776fee401">
                                                                        <div data-arrows="true" class="image-hotel-view-block" data-slider="8513852135ab3776fee401">    
                                                                            <div class="slider-for slick-initialized slick-slider">
                                                                                <!-- <button type="button" data-role="none" class="slick-prev slick-arrow" aria-label="Previous" role="button" style="display: block;">Previous</button>      
                                                                                <div aria-live="polite" class="slick-list draggable">
                                                                                    <div class="slick-track" style="opacity: 1; width: 6660px;" role="listbox">
                                                                                        <div class="item item-cd slick-slide" data-slick-index="0" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide30" style="width: 1110px; position: relative; left: 0px; top: 0px; z-index: 998; opacity: 0; transition: opacity 500ms ease 0s;">
                                                                                            <img width="750" height="350" src="/images/carnival-triumph-7cb184f207e878d0-750x350.jpg" class="img-responsive " alt="carnival-triumph-7cb184f207e878d0">
                                                                                        </div>
                                                                                        <div class="item item-cd slick-slide" data-slick-index="1" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide31" style="width: 1110px; position: relative; left: -1110px; top: 0px; z-index: 998; opacity: 0; transition: opacity 500ms ease 0s;">
                                                                                            <img width="750" height="350" src="/images/o-NEW-YORK-CITY-WRITER-facebook-750x350.jpg" class="img-responsive " alt="Sunset over manhattan">
                                                                                        </div>
                                                                                        <div class="item item-cd slick-slide slick-current slick-active" data-slick-index="2" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide32" style="width: 1110px; position: relative; left: -2220px; top: 0px; z-index: 999; opacity: 1;">
                                                                                            <img width="750" height="350" src="/images/Paris-City-HD-Wallpapers-750x350.jpg" class="img-responsive " alt="Paris-City-HD-Wallpapers">
                                                                                        </div>
                                                                                        <div class="item item-cd slick-slide" data-slick-index="3" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide33" style="width: 1110px; position: relative; left: -3330px; top: 0px; z-index: 998; opacity: 0;">
                                                                                            <img width="750" height="350" src="/images/City-of-Rome-Great-View-750x350.jpg" class="img-responsive " alt="City-of-Rome-Great-View">
                                                                                        </div>
                                                                                        <div class="item item-cd slick-slide" data-slick-index="4" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide34" style="width: 1110px; position: relative; left: -4440px; top: 0px; z-index: 998; opacity: 0;">
                                                                                            <img width="750" height="350" src="/images/R3-at-Sea-Rendering-750x350.jpg" class="img-responsive " alt="R3 at Sea Rendering">
                                                                                        </div>
                                                                                        <div class="item item-cd slick-slide" data-slick-index="5" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide35" style="width: 1110px; position: relative; left: -5550px; top: 0px; z-index: 998; opacity: 0;">
                                                                                            <img width="750" height="350" src="/images/maxresdefault-1-750x350.jpg" class="img-responsive " alt="maxresdefault">
                                                                                        </div>
                                                                                    </div>
                                                                                </div> -->

                                                                                <div aria-live="polite" class="slick-list draggable">
                                                                                    <div id="guest-slick">
                                                                                        
                                                                                        <div class="item item-cd">
                                                                                            <img width="750" height="350" src="/images/o-NEW-YORK-CITY-WRITER-facebook-750x350.jpg" class="img-responsive " alt="Sunset over manhattan">
                                                                                        </div>
                                                                                        <div class="item item-cd ">
                                                                                            <img width="750" height="350" src="/images/Paris-City-HD-Wallpapers-750x350.jpg" class="img-responsive " alt="Paris-City-HD-Wallpapers">
                                                                                        </div>
                                                                                        <div class="item item-cd">
                                                                                            <img width="750" height="350" src="/images/City-of-Rome-Great-View-750x350.jpg" class="img-responsive " alt="City-of-Rome-Great-View">
                                                                                        </div>
                                                                                        <div class="item item-cd ">
                                                                                            <img width="750" height="350" src="/images/R3-at-Sea-Rendering-750x350.jpg" class="img-responsive " alt="R3 at Sea Rendering">
                                                                                        </div>
                                                                                        <div class="item item-cd">
                                                                                            <img width="750" height="350" src="/images/maxresdefault-1-750x350.jpg" class="img-responsive " alt="maxresdefault">
                                                                                        </div>
                                                                                        <div class="item item-cd " >
                                                                                            <img width="750" height="350" src="/images/carnival-triumph-7cb184f207e878d0-750x350.jpg" class="img-responsive " alt="carnival-triumph-7cb184f207e878d0">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="slider-nav slick-initialized">     
                                                                                    <div aria-live="polite" class="slick-list draggable">
                                                                                        <div  id="guest-slick-nav" class="slick-track">
                                                                                            <div class="item">
                                                                                                <img width="750" height="350" src="/images/o-NEW-YORK-CITY-WRITER-facebook-750x350.jpg" class="img-responsive " alt="Sunset over manhattan">
                                                                                            </div>
                                                                                            <div class="item">
                                                                                                <img width="750" height="350" src="/images/Paris-City-HD-Wallpapers-750x350.jpg" class="img-responsive " alt="Paris-City-HD-Wallpapers">
                                                                                            </div>
                                                                                            <div class="item">
                                                                                                <img width="750" height="350" src="/images/City-of-Rome-Great-View-750x350.jpg" class="img-responsive " alt="City-of-Rome-Great-View">
                                                                                            </div>
                                                                                            <div class="item">
                                                                                                <img width="750" height="350" src="/images/R3-at-Sea-Rendering-750x350.jpg" class="img-responsive " alt="R3 at Sea Rendering">
                                                                                            </div>
                                                                                            <div class="item">
                                                                                                <img width="750" height="350" src="/images/maxresdefault-1-750x350.jpg" class="img-responsive " alt="maxresdefault">
                                                                                            </div>
                                                                                            <div class="item">
                                                                                                <img width="750" height="350" src="/images/carnival-triumph-7cb184f207e878d0-750x350.jpg" class="img-responsive " alt="carnival-triumph-7cb184f207e878d0">
                                                                                            </div>
                                                                                            
                                                                                        </div>
                                                                                    </div>
                                                                                 </div> 
                                                                                
                                                                            
                                                                            
                                                                                
                                                                        <!-- <button type="button" data-role="none" class="slick-next slick-arrow" aria-label="Next" role="button" style="display: block;">Next</button></div> -->
                                                                        <!-- <div class="slider-nav slick-initialized slick-slider">     
                                                                            <div aria-live="polite" class="slick-list draggable"><div class="slick-track" role="listbox" style="opacity: 1; width: 3568px; left: -1561px;"><div class="item  slick-slide slick-cloned" data-slick-index="-5" aria-hidden="true" tabindex="-1" style="width: 223px;">
                                                                                <img width="750" height="350" src="/images/o-NEW-YORK-CITY-WRITER-facebook-750x350.jpg" class="img-responsive " alt="Sunset over manhattan">
                                                                            </div><div class="item  slick-slide slick-cloned" data-slick-index="-4" aria-hidden="true" tabindex="-1" style="width: 223px;">
                                                                                <img width="750" height="350" src="/images/Paris-City-HD-Wallpapers-750x350.jpg" class="img-responsive " alt="Paris-City-HD-Wallpapers">
                                                                            </div><div class="item  slick-slide slick-cloned" data-slick-index="-3" aria-hidden="true" tabindex="-1" style="width: 223px;">
                                                                                <img width="750" height="350" src="/images/City-of-Rome-Great-View-750x350.jpg" class="img-responsive " alt="City-of-Rome-Great-View">
                                                                            </div><div class="item  slick-slide slick-cloned" data-slick-index="-2" aria-hidden="true" tabindex="-1" style="width: 223px;">
                                                                                <img width="750" height="350" src="/images/R3-at-Sea-Rendering-750x350.jpg" class="img-responsive " alt="R3 at Sea Rendering">
                                                                            </div><div class="item  slick-slide slick-cloned" data-slick-index="-1" aria-hidden="true" tabindex="-1" style="width: 223px;">
                                                                                <img width="750" height="350" src="/images/maxresdefault-1-750x350.jpg" class="img-responsive " alt="maxresdefault"></div><div class="item  slick-slide" data-slick-index="0" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide40" style="width: 223px;">
                                                                                <img width="750" height="350" src="/images/carnival-triumph-7cb184f207e878d0-750x350.jpg" class="img-responsive " alt="carnival-triumph-7cb184f207e878d0">
                                                                            </div><div class="item  slick-slide" data-slick-index="1" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide41" style="width: 223px;">
                                                                                <img width="750" height="350" src="/images/o-NEW-YORK-CITY-WRITER-facebook-750x350.jpg" class="img-responsive " alt="Sunset over manhattan">
                                                                            </div><div class="item  slick-slide slick-current slick-active" data-slick-index="2" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide42" style="width: 223px;">
                                                                                <img width="750" height="350" src="/images/Paris-City-HD-Wallpapers-750x350.jpg" class="img-responsive " alt="Paris-City-HD-Wallpapers">
                                                                            </div><div class="item  slick-slide slick-active" data-slick-index="3" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide43" style="width: 223px;">
                                                                                <img width="750" height="350" src="/images/City-of-Rome-Great-View-750x350.jpg" class="img-responsive " alt="City-of-Rome-Great-View">
                                                                            </div><div class="item  slick-slide slick-active" data-slick-index="4" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide44" style="width: 223px;">
                                                                                <img width="750" height="350" src="/images/R3-at-Sea-Rendering-750x350.jpg" class="img-responsive " alt="R3 at Sea Rendering">
                                                                            </div><div class="item  slick-slide slick-active" data-slick-index="5" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide45" style="width: 223px;">
                                                                                <img width="750" height="350" src="/images/maxresdefault-1-750x350.jpg" class="img-responsive " alt="maxresdefault"></div><div class="item  slick-slide slick-cloned slick-active" data-slick-index="6" aria-hidden="false" tabindex="-1" style="width: 223px;">
                                                                                <img width="750" height="350" src="/images/carnival-triumph-7cb184f207e878d0-750x350.jpg" class="img-responsive " alt="carnival-triumph-7cb184f207e878d0">
                                                                            </div><div class="item  slick-slide slick-cloned" data-slick-index="7" aria-hidden="true" tabindex="-1" style="width: 223px;">
                                                                                <img width="750" height="350" src="/images/o-NEW-YORK-CITY-WRITER-facebook-750x350.jpg" class="img-responsive " alt="Sunset over manhattan">
                                                                            </div><div class="item  slick-slide slick-cloned" data-slick-index="8" aria-hidden="true" tabindex="-1" style="width: 223px;">
                                                                                <img width="750" height="350" src="/images/Paris-City-HD-Wallpapers-750x350.jpg" class="img-responsive " alt="Paris-City-HD-Wallpapers">
                                                                            </div><div class="item  slick-slide slick-cloned" data-slick-index="9" aria-hidden="true" tabindex="-1" style="width: 223px;">
                                                                                <img width="750" height="350" src="/images/City-of-Rome-Great-View-750x350.jpg" class="img-responsive " alt="City-of-Rome-Great-View">
                                                                            </div><div class="item  slick-slide slick-cloned" data-slick-index="10" aria-hidden="true" tabindex="-1" style="width: 223px;">
                                                                                <img width="750" height="350" src="/images/R3-at-Sea-Rendering-750x350.jpg" class="img-responsive " alt="R3 at Sea Rendering">
                                                                            </div></div></div>
                                                                            
                                                                            </div> -->  
                                                                        </div>  
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                            <div data-vc-full-width="true" data-vc-full-width-init="true" data-vc-stretch-content="true" class="vc_row wpb_row vc_row-fluid vc_row-no-padding" style="position: relative; left: -247.5px; box-sizing: border-box; width: 1665px;">
                                <div class="wpb_column vc_column_container vc_col-sm-12">
                                    <div class="vc_column-inner ">
                                        <div class="wpb_wrapper">
                                            <div class="slz-shortcode contact-19437315195b73a8dcb6768 ">
                                                <div class="contact style-1">
                                                    <div class="container">     
                                                        <div class="row">
                                                            <div class="wrapper-contact-style">
                                                                <div data-wow-delay="0.5s" class="contact-wrapper-images wow fadeInLeft" style="visibility: hidden; animation-delay: 0.5s; animation-name: none;">
                                                                    <img width="276" height="536" src="http://wp.swlabs.co/exploore/wp-content/uploads/2016/05/contact-people.png" class="img-responsive attachment-full" alt="contact-people" srcset="http://wp.swlabs.co/exploore/wp-content/uploads/2016/05/contact-people.png 276w, http://wp.swlabs.co/exploore/wp-content/uploads/2016/05/contact-people-154x300.png 154w" sizes="(max-width: 276px) 100vw, 276px">
                                                                </div>
                                                                <div class="col-lg-6 col-sm-7 col-lg-offset-4 col-sm-offset-5">
                                                                    <div data-wow-delay="0.4s" class="contact-wrapper padding-top padding-bottom wow fadeInRight" style="visibility: hidden; animation-delay: 0.4s; animation-name: none;">             
                                                                        <div class="contact-box">
                                                                            <h5 class="title">LIÊN HỆ</h5>
                                                                            <div role="form" class="wpcf7" id="wpcf7-f46-p45-o1" lang="en" dir="ltr">
                                                                                <div class="screen-reader-response"></div>
                                                                                <div class="info-list">
                                                                                    <div><i class="icons fa fa-map-marker"></i><span>367 Tân Sơn, Phường 15, Quận Tân Bình, Hồ Chí Minh</span></div>
                                                                                    <div><i class="icons fa fa-phone"></i><span>19002011 - 0948991080</span></div>
                                                                                    <div><i class="icons fa fa-envelope-o"></i><a class="link" href="mailto:domain@expooler.com"><span>info@haidangtravel.com</span></a></div>
                                                                                </div>
                                                                                <div class="info-list">
                                                                                    <div><i class="icons fa fa-map-marker"></i><span>
                                                                                    <b>CHI NHÁNH QUẬN 1</b><br>
                                                                                    27 Đề Thám, Phường Cô Giang, Quận 1, Hồ Chí Minh</span>
                                                                                    </div>
                                                                                    <div><i class="icons fa fa-phone"></i><span>19002011( EXIT 107 )</span></div>
                                                                                    <div><i class="icons fa fa-map-marker"></i><span>
                                                                                    <b>CHI NHÁNH QUẬN 12</b><br>
                                                                                     256 TX25, Thạnh Xuân, Quận 12, Hồ Chí Minh</span>
                                                                                    </div>
                                                                                    <div><i class="icons fa fa-phone"></i><span>19002011( EXIT 111 )</span></div>

                                                                                    <div><i class="icons fa fa-map-marker"></i><span>
                                                                                    <b>CHI NHÁNH BIÊN HÒA </b><br>
                                                                                     51A2, KP11, Phường Tân Phong, Biên Hòa </span>
                                                                                    </div>
                                                                                    <div><i class="icons fa fa-phone"></i><span>19002011( EXIT 110 ) - 0909444035</span></div>
                                                                                    <br>
                                                                                    <div class="contact-submit">
                                                                                        <button class="wpcf7-form-control wpcf7-submit btn btn-slide" data-hover="19002011" type="submit"><span class="text">Gọi ngay </span><span class="icons fa fa-long-arrow-right"></span>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>      
                                                        </div>
                                                    </div>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="vc_row-full-width vc_clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
    <script type="text/javascript">
        $('.slider').slick({
            dots: false,
            slidesToShow: 2,
            slidesToScroll: 2,
            dots: true,
            infinite: true,
            cssEase: 'linear'
        });
        $('#guest-slick').slick({
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: true,
          fade: true,
          asNavFor: '#guest-slick-nav'
        });
        $('#guest-slick-nav').slick({
          slidesToShow: 5,
          slidesToScroll: 1,
          asNavFor: '#guest-slick',
          dots: false,
          centerMode: true,
          focusOnSelect: true
        });
        
        $('.helper-slick').slick({
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 6,
            slidesToScroll: 1,
            prevArrow: false,
            nextArrow: false,
            autoplay: true,
            autoplaySpeed: 4000,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        speed: 1000,
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 425,
                    settings: {
                        slidesToShow: 2,
                    }
                }
            ]
        });
        $('.main-employee').not('.slick-initialized').slick({
            autoplay: true,
            slidesToShow: 4,
  // prevArrow: '<div class="slick-prev"><i class="i-chev-left-thin"></i><span class="sr-text">Previous</span></div>',
  // nextArrow: '<div class="slick-next"><i class="i-chev-right-thin"></i><span class="sr-text">Next</span></div>',
            // prevArrow: true,
            // nextArrow: true,
            dots: true,
            responsive: [{ 
                breakpoint: 500,
                settings: {
                    dots: false,
                    arrows: false,
                    infinite: false,
                    slidesToShow: 2,
                    slidesToScroll: 2
                } 
            }]
            // dots: false,
            // infinite: true,
            // speed: 300,
            // slidesToShow: 4,
            // slidesToScroll: 1,
            // prevArrow: true,
            // nextArrow: true,
            // autoplay: true,
            // autoplaySpeed: 4000,
            // responsive: [
            //     {
            //         breakpoint: 1024,
            //         settings: {
            //             slidesToShow: 4,
            //         }
            //     },
            //     {
            //         breakpoint: 768,
            //         settings: {
            //             speed: 1000,
            //             slidesToShow: 3,
            //         }
            //     },
            //     {
            //         breakpoint: 425,
            //         settings: {
            //             slidesToShow: 2,
            //         }
            //     }
            // ]
        });
    </script>
@stop