<div class="vc_row wpb_row vc_row-fluid vc_custom_1463096648310">
    <div class="slz_col-sm-12 wpb_column vc_column_container vc_col-sm-7">
        <div class="vc_column-inner vc_custom_1468574547376">
            <div class="wpb_wrapper">
                <div class="slz-shortcode block-title-16301066235a921411945e5 ">
                    <div class="group-title">
                        <div class="sub-title">
                            <p class="text">Chủ Đề Tour</p><i class="icons flaticon-people"></i></div>
                        <h2 class="main-title">ĐƯỢC XEM NHIỀU</h2>
                    </div>
                    <p>Top chủ đề được xem nhiều nhất trong năm, Những chủ đề dưới đây là một trong những chủ đề được nhiều khách hàng tìm kiếm và lựa chọn trong năm</p>
                </div>
                <div class="vc_empty_space" style="height: 10px">
                    <span class="vc_empty_space_inner"></span>
                </div>
                <div class="vc_row wpb_row vc_inner vc_row-fluid">
                    <?php
                        $count_homesubjecttours = $subjecttours->count();
                        $loop_count  = ceil($count_homesubjecttours /3) ;
                    ?>
                    @for($i = 1 ; $i <= 3 ; $i++)
                    <div class="wpb_column vc_column_container vc_col-sm-4">
                        <div class="vc_column-inner ">
                            <div class="wpb_wrapper">
                                <div class="slz-shortcode group-list ">
                                    <ul class="list-unstyled about-us-list">
                                        @foreach($subjecttours as $index=>$subjecttour)
                                            @if($index < $i*$loop_count && $index >= ($i-1)*$loop_count)
                                            <li>
                                                <p class="text"><a href="{!! asset('chu-de-tour/'.$subjecttour->slug)!!}">{!! $subjecttour->title !!} ({!! $subjecttour->count_tour !!})</a></p>
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
                <div class="vc_empty_space" style="height: 35px"><span class="vc_empty_space_inner"></span></div>
            </div>
        </div>
    </div>
    <div class="slz_col-sm-12 wpb_column vc_column_container vc_col-sm-5">
        <div class="vc_column-inner vc_custom_1463109325289">
            <div class="wpb_wrapper">
                <div class="wpb_single_image wpb_content_element vc_align_left  wpb_animate_when_almost_visible wpb_appear appear">
                    <figure class="wpb_wrapper vc_figure">
                        <div class="vc_single_image-wrapper  vc_box_border_grey">
                            <a href="{{ $homesubjectbanner->url }}"><img width="450" height="367" src="{{ asset('image/'.$homesubjectbanner->images) }}" class="vc_single_image-img attachment-full" alt="about-us-1" srcset="{{ asset('image/'.$homesubjectbanner->images) }} 450w, {{ asset('image/'.$homesubjectbanner->images) }} 300w" sizes="(max-width: 450px) 100vw, 450px" />
                            </a>
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
</div>