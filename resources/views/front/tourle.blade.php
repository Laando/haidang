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
        background: #d10000 ;
        }
        .bg-transparent {
    background-color: #ca0000;}

    .title-style-2 {
    margin: 0 0 5px 0;
    font-size: 20px;
    text-transform: uppercase;
    position: relative;
    color: #ffffff;
    display: inline-block;
}
.tour-tet-hd.slick-slide { margin: 8px!important; width: 375px !important }
.slick-track{width: 8502px!important}
.special-offer-list .slick-prev, .special-offer-list .slick-next {
    width: 40px;
    height: 40px;
    line-height: 40px;
    text-align: center;
    border: 2px solid #ffe100;
    opacity: 0.3;
    color: #ffe100;
    border-radius: 50%;
    background-color: black;
    transition: all 0.3s ease;
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
}


.main-menu ul li{
    list-style-type: none;
    float: left;
}
.main-menu ul{ text-align: center; }
.main-menu ul li a {
    font-size: 20px;
    background: #ffffff;
    margin: 10px;
    padding: 10px;
    border-radius: 5px;
}
    </style>


@stop
@section('main')





<div class="campaign-black-friday-18">
  <!-- edit compaing -->
  <div class="content-banner clearfix">
    <div class="top-banner hidden-xs">
      <img
      src="https://c1.staticflickr.com/5/4849/46326880712_f66fdbdc53_b.jpg"
      />
    </div>

  </div>
  <div class="container">
    <div class="row">

      <!-- do rau lam-->
      <div class="main-menu">
       
          <ul>
            <li class=""><a href="#trongnuoc">TOUR TRONG NƯỚC</a></li>
            <li class=""><a href="#nuocngoai">TOUR NƯỚC NGOÀI</a></li>
             <li class=""><a href="#dieukienapdung">ĐIỀU KIỆN ÁP DỤNG</a></li>
              <li class=""><a href="#quatang">QUÀ TẶNG</a></li>
          </ul>
       
      </div>
      <!-- Content section -->
      <section class="slider-area" id="trongnuoc">
      <div class="section section-padding page-detail padding-top padding-bottom">
        <div class="container">
          <div class="row">
            <div id="page-content" class="col-md-12 col-xs-12">
              <div class="">

                <div class="tt-other" style="width: 100%;padding: 10px 20px;border-radius: 6px; background: #ec3837;text-align: center;color: #ffffff;font-size: 16px;text-transform: uppercase; margin-bottom: 20px;font-weight: bold;">
                  TOUR TẾT ÂM LỊCH TRONG NƯỚC
                </div>

              </div>
              <!--slide mau-->
              <div class="slz-shortcode block-title-10418674665c196a727bb74 ">
                <h3 class="title-style-2">TOUR ĐÀ LẠT</h3>
              </div>
              <div id="post-1120" class="post-1120 page type-page status-publish hentry" >
                <div class="section-page-content clearfix ">
                  <div class="entry-content">
                    <div class="vc_row wpb_row vc_row-fluid vc_custom_1467015917433">
                      <div class="wpb_column vc_column_container vc_col-sm-12">
                        <div class="vc_column-inner ">
                          <div class="wpb_wrapper">
                            <div class="slz-shortcode ">
                              <div class="special-offer-list">

                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-da-Lat-Tet-Am-Lich-HD09">
                                      <img src="https://c1.staticflickr.com/5/4875/45653090984_a70703dcea_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class=" tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-da-Lat-Tet-am-Lich-HD07">
                                      <img src="https://c1.staticflickr.com/5/4865/46376074701_44a54dbe1a_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-da-Lat-Gia-Re-Tet-Am-Lich-HD08">
                                      <img src="https://c1.staticflickr.com/5/4850/45653140634_28727d65bc_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd ">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-da-Lat-Tet-am-Lich-HD06">
                                      <img src="https://c1.staticflickr.com/5/4804/32504263448_1177ed7419_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd ">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-da-Lat-Tet-am-Lich-HD05">
                                      <img src="https://c1.staticflickr.com/5/4885/44559328200_8974f60a70_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd ">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-da-Lat-Tet-Am-Lich-HD02">
                                      <img src="https://c1.staticflickr.com/5/4858/45463795465_e0319cbb1b_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd ">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-da-Lat-Tet-Am-Lich-HD03">
                                      <img src="https://c1.staticflickr.com/5/4888/31436989347_cd9ebf9d71_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd ">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-da-Lat-Tet-Am-Lich-DH04">
                                      <img src="https://c1.staticflickr.com/5/4803/45653308734_661ae41f4d_o.jpg"/>
                                    </a>
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
              <!--end slide mau-->
              <!--slide mau-->
              <div class="slz-shortcode block-title-10418674665c196a727bb74 ">
                <h3 class="title-style-2">TOUR NHA TRANG</h3>
              </div>
              <div id="post-1120" class="post-1120 page type-page status-publish hentry" >
                <div class="section-page-content clearfix ">
                  <div class="entry-content">
                    <div class="vc_row wpb_row vc_row-fluid vc_custom_1467015917433">
                      <div class="wpb_column vc_column_container vc_col-sm-12">
                        <div class="vc_column-inner ">
                          <div class="wpb_wrapper">
                            <div class="slz-shortcode ">
                              <div class="special-offer-list">

                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Nha-Trang-Tet-am-Lich-HD04">
                                      <img src="https://c1.staticflickr.com/5/4918/45463922095_4eff710397_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class=" tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Nha-Trang-Tet-Tet-am-Lich-HD02">
                                      <img src="https://c1.staticflickr.com/5/4815/46325467902_fd1ed79de6_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-diep-son-nha-trang-tet-am-lich">
                                      <img src="https://c1.staticflickr.com/5/4848/46325481272_f66ab12eda_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd ">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-nha-trang-tet-am-lich-HD03">
                                      <img src="https://c1.staticflickr.com/5/4820/46376476751_358f910172_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd ">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Nha-Trang-Tet-am-Lich-HD01">
                                      <img src="https://c1.staticflickr.com/5/4910/46325561302_91c1a29726_o.jpg"/>
                                    </a>
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
              <!--end slide mau-->
              <!--slide mau-->
              <div class="slz-shortcode block-title-10418674665c196a727bb74 ">
                <h3 class="title-style-2">TOUR PHÚ YÊN</h3>
              </div>
              <div id="post-1120" class="post-1120 page type-page status-publish hentry" >
                <div class="section-page-content clearfix ">
                  <div class="entry-content">
                    <div class="vc_row wpb_row vc_row-fluid vc_custom_1467015917433">
                      <div class="wpb_column vc_column_container vc_col-sm-12">
                        <div class="vc_column-inner ">
                          <div class="wpb_wrapper">
                            <div class="slz-shortcode ">
                              <div class="special-offer-list">

                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Quy-Nhon-Phu-Yen-Tet-am-Lich-HD01">
                                      <img src="https://c1.staticflickr.com/5/4870/46376557821_58d7b89f8a_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class=" tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-diep-Son-Phu-Yen-Tet-am-Lich-HD01">
                                      <img src="https://c1.staticflickr.com/5/4917/31437252827_cdab31db05_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Phu-Yen-Tet-am-Lich-HD02">
                                      <img src="https://c1.staticflickr.com/5/4868/44559683400_c7b77cb3bd_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd ">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Phu-Yen-Tet-am-Lich-HD01">
                                      <img src="https://c1.staticflickr.com/5/4830/45464206745_aa0ab36d05_o.jpg"/>
                                    </a>
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
              <!--end slide mau-->
              <!--slide mau-->
              <div class="slz-shortcode block-title-10418674665c196a727bb74 ">
                <h3 class="title-style-2">TOUR LIÊN TUYẾN</h3>
              </div>
              <div id="post-1120" class="post-1120 page type-page status-publish hentry" >
                <div class="section-page-content clearfix ">
                  <div class="entry-content">
                    <div class="vc_row wpb_row vc_row-fluid vc_custom_1467015917433">
                      <div class="wpb_column vc_column_container vc_col-sm-12">
                        <div class="vc_column-inner ">
                          <div class="wpb_wrapper">
                            <div class="slz-shortcode ">
                              <div class="special-offer-list">

                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Binh-Hung-Ninh-Chu-Tet-Am-Lich-HD01">
                                      <img src="https://c1.staticflickr.com/5/4876/44560051900_78c2eb0697_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class=" tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Quy-Nhon-Mang-den-Tet-am-Lich">
                                      <img src="https://c1.staticflickr.com/5/4874/45464620655_28218b0e5c_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-dao-Binh-Hung-Ninh-Chu-Tet-am-Lich">
                                      <img src="https://c1.staticflickr.com/5/4871/46377061161_834a9262d7_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd ">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Tam-Binh-2-Tet-am-Lich">
                                      <img src="https://c1.staticflickr.com/5/4880/31437744787_f7061ed769_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd ">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-du-lich-Ninh-Chu-da-Lat-Tet-am-Lich">
                                      <img src="https://c1.staticflickr.com/5/4902/32505109158_0f96847ac7_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd ">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Phan-Thiet-da-Lat-Tet-am-Lich">
                                      <img src="https://c1.staticflickr.com/5/4838/31437796077_3a88c6b04b_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd ">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-dao-Binh-Ba-Nha-Trang-Tet-am-Lich">
                                      <img src="https://c1.staticflickr.com/5/4917/31437811377_49d13548cf_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd ">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Nha-Trang-da-Lat-Tet-am-Lich">
                                      <img src="https://c1.staticflickr.com/5/4816/45464739975_e499fa336a_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd ">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Binh-Ba-Nha-Trang-da-Lat-Tet-Am-Lich">
                                      <img src="https://c1.staticflickr.com/5/4913/31437864097_987e362639_o.jpg"/>
                                    </a>
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
              <!--end slide mau-->
              <!--slide mau-->
              <div class="slz-shortcode block-title-10418674665c196a727bb74 ">
                <h3 class="title-style-2">TOUR TÂY NGUYÊN</h3>
              </div>
              <div id="post-1120" class="post-1120 page type-page status-publish hentry" >
                <div class="section-page-content clearfix ">
                  <div class="entry-content">
                    <div class="vc_row wpb_row vc_row-fluid vc_custom_1467015917433">
                      <div class="wpb_column vc_column_container vc_col-sm-12">
                        <div class="vc_column-inner ">
                          <div class="wpb_wrapper">
                            <div class="slz-shortcode ">
                              <div class="special-offer-list">

                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Ta-dung-Buon-Me-Thuot-Tet-Am-Lich">
                                      <img src="https://c2.staticflickr.com/8/7835/45527178875_ffe69c8d6e_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class=" tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Buon-Me-Thuot-Tet-am-Lich">
                                      <img src="https://c1.staticflickr.com/5/4840/31438047977_a4b62350f3_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Mang-den-Buon-Me-Thuot-tet-am-lich">
                                      <img src="https://c1.staticflickr.com/5/4834/45464941425_cb4f774023_o.jpg"/>
                                    </a>
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
              <!--end slide mau-->

              <!--slide mau-->
              <div class="slz-shortcode block-title-10418674665c196a727bb74 ">
                <h3 class="title-style-2">TOUR ĐANG KHUYẾN MÃI</h3>
              </div>
              <div id="post-1120" class="post-1120 page type-page status-publish hentry" >
                <div class="section-page-content clearfix ">
                  <div class="entry-content">
                    <div class="vc_row wpb_row vc_row-fluid vc_custom_1467015917433">
                      <div class="wpb_column vc_column_container vc_col-sm-12">
                        <div class="vc_column-inner ">
                          <div class="wpb_wrapper">
                            <div class="slz-shortcode ">
                              <div class="special-offer-list">

                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Ca-Mau-Tet-Am-Lich-HD01">
                                      <img src="https://c1.staticflickr.com/5/4849/45654175424_a58f8eab0a_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class=" tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Phu-Quoc-Tet-am-Lich-HD03">
                                      <img src="https://c1.staticflickr.com/5/4913/46326322482_4ed0143a3b_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Phu-Quoc-Tet-Am-Lich">
                                      <img src="https://c1.staticflickr.com/5/4865/45654379454_7d1d4b1741_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-dao-Binh-Ba-Tet-am-Lich-HD02">
                                      <img src="https://c1.staticflickr.com/5/4852/46377275321_a7830dff5a_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd ">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-dao-Binh-Ba-Tet-am-Lich">
                                      <img src="https://c1.staticflickr.com/5/4892/45654240374_480d946164_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Quy-Nhon-Tet-am-Lich">
                                      <img src="https://c1.staticflickr.com/5/4819/46326429272_2205399666_o.jpg"/>
                                    </a>
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
              <!--end slide mau-->
            </div>
          </div>
        </div>
      </div>
    </section>
      <!-- #section -->
      <!--end do rau lam-->


      <!-- do rau lam-->
      <!-- Content section -->
      <section class="slider-area" id="nuocngoai">
      <div class="section section-padding page-detail padding-top padding-bottom">
        <div class="container">
          <div class="row">
            <div id="page-content" class="col-md-12 col-xs-12">
              <div class="">
                <div class="tt-other" style="width: 100%;padding: 10px 20px;border-radius: 6px; background: #ec3837;text-align: center;color: #ffffff;font-size: 16px;text-transform: uppercase; margin-bottom: 20px;font-weight: bold;">
                  TOUR TẾT ÂM LỊCH NƯỚC NGOÀI
                </div>

              </div>
              <!--slide mau-->
              <div class="slz-shortcode block-title-10418674665c196a727bb74 ">
                <h3 class="title-style-2">ĐANG KHUYẾN MÃI</h3>
              </div>
              <div id="post-1120" class="post-1120 page type-page status-publish hentry" >
                <div class="section-page-content clearfix ">
                  <div class="entry-content">
                    <div class="vc_row wpb_row vc_row-fluid vc_custom_1467015917433">
                      <div class="wpb_column vc_column_container vc_col-sm-12">
                        <div class="vc_column-inner ">
                          <div class="wpb_wrapper">
                            <div class="slz-shortcode ">
                              <div class="special-offer-list">


                                <div class=" tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Singapore-Indonesia-Malaysia-Tet-Am-Lich-HD01">
                                      <img src="https://c1.staticflickr.com/5/4835/45465028705_c64d61d0cd_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Singapore-Malaysia-Tet-Duong-Lich-HD02">
                                      <img src="https://c1.staticflickr.com/5/4915/32505514978_c319b41c06_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Thai-Lan-Tet-am-Lich-HD01">
                                      <img src="https://c1.staticflickr.com/5/4910/46377473621_0f7fd2008d_o.jpg"/>
                                    </a>
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
              <!--end slide mau-->
              <!--slide mau-->
              <div class="slz-shortcode block-title-10418674665c196a727bb74 ">
                <h3 class="title-style-2">CAMPUCHIA</h3>
              </div>
              <div id="post-1120" class="post-1120 page type-page status-publish hentry" >
                <div class="section-page-content clearfix ">
                  <div class="entry-content">
                    <div class="vc_row wpb_row vc_row-fluid vc_custom_1467015917433">
                      <div class="wpb_column vc_column_container vc_col-sm-12">
                        <div class="vc_column-inner ">
                          <div class="wpb_wrapper">
                            <div class="slz-shortcode ">
                              <div class="special-offer-list">


                                <div class=" tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Cambodia-Sihanoukville-Tet-am-Lich-HD02">
                                      <img src="https://c1.staticflickr.com/5/4857/32505545678_dd30b619fe_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Campuchia-Sihanoukville-Tet-am-Lich-HD01">
                                      <img src="https://c1.staticflickr.com/5/4844/44560603650_93bce9c890_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Campuchia-Siem-Riep-Tet-am-Lich-HD01">
                                      <img src="https://c1.staticflickr.com/5/4851/46377573031_1572b6b0b4_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Campuchia-Sihanoukville-Tet-am-Lich-HD03">
                                      <img src="https://c1.staticflickr.com/5/4899/46377585471_6746f1f4d6_o.jpg"/>
                                    </a>
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
              <!--end slide mau-->
              <!--slide mau-->
              <div class="slz-shortcode block-title-10418674665c196a727bb74 ">
                <h3 class="title-style-2">NHẬT BẢN - HÀN QUỐC</h3>
              </div>
              <div id="post-1120" class="post-1120 page type-page status-publish hentry" >
                <div class="section-page-content clearfix ">
                  <div class="entry-content">
                    <div class="vc_row wpb_row vc_row-fluid vc_custom_1467015917433">
                      <div class="wpb_column vc_column_container vc_col-sm-12">
                        <div class="vc_column-inner ">
                          <div class="wpb_wrapper">
                            <div class="slz-shortcode ">
                              <div class="special-offer-list">


                                <div class=" tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Nhat-Ban-Tet-Am-Lich-HD05">
                                      <img src="https://c1.staticflickr.com/5/4839/46377604641_7d702bb60c_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Nhat-Ban-Tet-Am-Lich-HD04">
                                      <img src="https://c1.staticflickr.com/5/4894/31438284067_8c973782a8_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Nhat-BanTet-Am-Lich-HD01">
                                      <img src="https://c1.staticflickr.com/5/4856/46377631411_11e969f114_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Han-Quoc-Tet-Am-Lich-HD02">
                                      <img src="https://c1.staticflickr.com/5/4818/32505651538_996877e12f_o.jpg"/>
                                    </a>
                                  </div>
                                </div>
                                <div class="tour-tet-hd">
                                  <div class="image-wrapper">
                                    <a class="link" href="http://haidangtravel.com/Tour-Han-Quoc-Tet-Am-Lich-HD01">
                                      <img src="https://c1.staticflickr.com/5/4814/31438318327_ff09319830_o.jpg"/>
                                    </a>
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
              <!--end slide mau-->

            </div>
          </div>
        </div>
      </div>
    </section>
      <!-- #section -->
      <!--end do rau lam-->
      <!--do rau lam-->
      <!-- Content section -->
      <section class="slider-area" id="dieukienapdung">
      <div class="section section-padding page-detail padding-top padding-bottom">
        <div class="container">
          <div class="row">
            <div id="page-content" class="col-md-12 col-xs-12">
              <div class="" style="color: #ffe100;">

                <div class="tt-other" style="width: 100%;padding: 10px 20px;border-radius: 6px; background: #ec3837;text-align: center;color: #ffffff;font-size: 16px;text-transform: uppercase; margin-bottom: 20px;font-weight: bold;color: white">
                  ĐIỀU KIỆN ÁP DỤNG
                </div>

                ĐIỀU KIỆN ÁP TOUR TRONG NƯỚC<br>

                Tặng trọn bộ quà tặng của Hải Đăng trị giá 2.000.000 đ (Vali, balo, dù, áo mưa,bao da hộ chiếu, viết, lịch để bàn, bao lì xì)-> Áp dụng cho nhóm 10 pax<br>
                Tặng lịch để bàn va bao lixi cho nhóm 3 khách<br>
                Tặng bao lixi 2019 cho nhóm 2 khách<br>
                Chương trình được áp dụng từ 20/12- 20/1/2019<br>

                ĐIỀU KIỆN ÁP TOUR TRONG NƯỚC<br>

                1. Khách đăng kí tour sẽ nhận 1 bao da hộ chiếu và 1 xấp phong bì lì xì.<br>
                2. Nhóm 2 khách tặng kèm 01 lịch để bàn.<br>
                3. Nhóm 3 – 4 khách tặng kèm 1 dù và 1 áo mưa<br>
                4. Nhóm trên 5 khách tặng kèm 01 vali du lịch<br>
                5.Tặng trọn bộ quà tặng của Hải Đăng trị giá 2.000.000 đ (Vali, balo, dù, áo mưa,bao da hộ chiếu, viết, lịch để bàn, bao lì xì)-> Áp dụng cho nhóm 10 pax<br>

              </div>
  
            </div>
          </div>
        </div>
      </div>
    </section>
      <!-- #section -->
      <!--end do rau lam-->

   <!--do rau lam-->
      <!-- Content section -->
      <section class="slider-area" id="quatang">
      <div class="section section-padding page-detail padding-top padding-bottom">
        <div class="container">
          <div class="row">
            <div id="page-content" class="col-md-12 col-xs-12">
              <div class="">

                <div class="tt-other" style="width: 100%;padding: 10px 20px;border-radius: 6px; background: #ec3837;text-align: center;color: #ffffff;font-size: 16px;text-transform: uppercase; margin-bottom: 20px;font-weight: bold;">
                  BỘ QUÀ TẶNG
                </div>

              </div>
             
            </div>
          </div>
        </div>
      </div>
    </section>
      <!-- #section -->
      <!--end do rau lam-->

    </div>
  </div>

</div>   

@stop


