<div data-vc-full-width="true" data-vc-full-width-init="false" class="vc_row wpb_row vc_row-fluid slz-bg_parallax vc_custom_1463027505022 vc_row-has-fill">
    <div class="wpb_column vc_column_container vc_col-sm-12">
        <div class="vc_column-inner ">
            <div class="wpb_wrapper">
                <div class="slz-shortcode block-title-15697673325a9214119ae4d ">
                    <div class="group-title">
                        <div class="sub-title">
                            <p class="text">Chương Trình Du Lịch</p><i class="icons flaticon-people"></i></div>
                        <h2 class="main-title">{{ $tour_type }}</h2>
                    </div>
                </div>

                <div class="slz-shortcode tours-wrapper block-4542472715a9214119b2a5">
                    <div class="tours-content">
                        <?php
                        if($isOutbound){
                            $list_tours  = $tours_nuocngoai ;
                            $link_cate = asset('tour-nuoc-ngoai');
                        } else {
                            $list_tours  = $tours_trongnuoc ;
                            $link_cate = asset('tour-trong-nuoc');
                        }
                        ?>
                        <div class="tours-list tours-carousel" data-count="3">
                            @foreach($list_tours as $tour)
                            @include('partials.tourpartial',[ 'tour' => $tour])
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="vc_row wpb_row vc_inner vc_row-fluid">
                    <div class="text-center wpb_column vc_column_container vc_col-sm-12">
                        <div class="vc_column-inner ">
                            <div class="wpb_wrapper">
                                <div class="vc_empty_space" style="height: 40px"><span class="vc_empty_space_inner"></span></div>
                                <a href="{{ $link_cate }}" class="slz-shortcode btn btn-maincolor btn-maincolor-7649392695a921412cc639 ">Xem Tất Cả</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>