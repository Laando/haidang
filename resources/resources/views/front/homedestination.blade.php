<div class="vc_row-full-width vc_clearfix"></div>
    <div class="vc_row wpb_row vc_row-fluid vc_custom_1463096648310">
        <div class="slz_col-sm-12 wpb_column vc_column_container vc_col-sm-7">
            <div class="vc_column-inner vc_custom_1468574547376">
                <div class="wpb_wrapper">
                    <div class="slz-shortcode block-title-16301066235a921411945e5 ">
                        <div class="group-title">
                            <div class="sub-title">
                                <p class="text">Điểm Du Lịch</p><i class="icons flaticon-people"></i></div>
                            <h2 class="main-title">Nổi Bật Nhất</h2>
                        </div>
                        <p>Những địa điểm nổi bật với nhiều lịch trình hấp dẫn, được nhiều du khách chọn làm điểm du lịch trong năm. Quý khách có thể tham khảo để lựa chọn cho mình một hành trình phù hợp.</p>
                    </div>
                    <div class="vc_empty_space" style="height: 10px">
                        <span class="vc_empty_space_inner"></span>
                    </div>
                    <div class="vc_row wpb_row vc_inner vc_row-fluid">
                        <div class="wpb_column vc_column_container vc_col-sm-4">
                            <div class="vc_column-inner ">
                                <div class="wpb_wrapper">
                                    <div class="slz-shortcode group-list ">
                                        <ul class="list-unstyled about-us-list">
                                            @foreach($homedestination_trongnuoc as $index=>$dp)
                                                @if($index<4)
                                            <li>
                                                <p class="text"><a href="{{ asset('diem-den/'.$dp->slug) }}">{{ $dp->title }} ({{ $dp->count_tour }})</a></p>
                                            </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wpb_column vc_column_container vc_col-sm-4">
                            <div class="vc_column-inner ">
                                <div class="wpb_wrapper">
                                    <div class="slz-shortcode group-list ">
                                        <ul class="list-unstyled about-us-list">
                                            @foreach($homedestination_trongnuoc as $index=>$dp)
                                                @if($index >=4 && $index <8)
                                                    <li>
                                                        <p class="text"><a href="{{ asset('diem-den/'.$dp->slug) }}">{{ $dp->title }} ({{ $dp->count_tour }})</a></p>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wpb_column vc_column_container vc_col-sm-4">
                            <div class="vc_column-inner ">
                                <div class="wpb_wrapper">
                                    <div class="slz-shortcode group-list ">
                                        <ul class="list-unstyled about-us-list">
                                            @foreach($homedestination_nuocngoai as $index=>$dp)
                                                @if($index<4)
                                                    <li>
                                                        <p class="text"><a href="{{ asset('diem-den/'.$dp->slug) }}">{{ $dp->title }} ({{ $dp->count_tour }})</a></p>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="vc_empty_space" style="height: 35px"><span class="vc_empty_space_inner"></span></div>
                </div>
            </div>
        </div>
        <div class="slz_col-sm-12 wpb_column vc_column_container vc_col-sm-5">
            <div class="vc_column-inner vc_custom_1463109325289">
                <div class="wpb_wrapper">
                    <div class="wpb_single_image wpb_content_element vc_align_left  wpb_animate_when_almost_visible wpb_appear appear vc_custom_1463027357222">
                        <figure class="wpb_wrapper vc_figure">
                            <div class="vc_single_image-wrapper  vc_box_border_grey">
                                <a href="{{ $homedestinationbanner->url }}"><img width="450" height="367" src="{{ asset('image/'.$homedestinationbanner->images) }}" class="vc_single_image-img attachment-full" alt="about-us-1" srcset="{{ asset('image/'.$homedestinationbanner->images) }} 450w, {{ asset('image/'.$homedestinationbanner->images) }} 300w" sizes="(max-width: 450px) 100vw, 450px" />
                                </a>
                            </div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="vc_row-full-width vc_clearfix"></div>

    <div data-vc-full-width="true" data-vc-full-width-init="false" data-vc-stretch-content="true" class="vc_row wpb_row vc_row-fluid vc_custom_1463017194672 vc_row-has-fill vc_row-no-padding">
        <div class="wpb_column vc_column_container vc_col-sm-12">
            <div class="vc_column-inner ">
                <div class="wpb_wrapper">
                    <div class="slz-shortcode travelers travel-id-12546943295a921412cd9c1 ">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="traveler-wrapper padding-top padding-bottom">
                                        <div class="group-title white">
                                            <div class="sub-title">
                                                <p class="text">Tour đang</p><i class="icons flaticon-people"></i>
                                            </div>
                                            <h2 class="main-title">Khuyến Mãi</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="traveler-list">
                                        @foreach($homeslidebanners as $index => $banner)
                                        <div class="traveler">
                                            <div class="wrapper-content">
                                                <a href="{!!  $banner->url !!}">
                                                    <img src="{!! asset('image/'.$banner->images) !!}" class="img-responsive" alt="cover-image-4" />
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>