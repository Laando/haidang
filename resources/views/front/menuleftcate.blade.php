<div id='page-sidebar' class="sidebar sidebar-widget col-md-3 col-xs-12 ">
    <form class="find-tour slz-search-widget slz-shortcode sidebar-widget result-page " method="POST"><div class="col-2">
            {{ csrf_field() }}
            <input id="isOutbound" type="hidden" name="isOutbound" value="{{ $isOutbound }}">
            <div class="find-widget tour-template find-flight-widget widget" data-placeholder="Choose Location">
                <h4 class="title-widgets">TÌM KIẾM TOUR</h4>
                <div class="content-widget">
                    <div class="text-input small-margin-top">
                        <div class="text-left"><a style="color:black;font-weight: bold" href="javascript:void(0);" title="" class="btn-reset hide">Xóa</a></div>
                        <div class="text-box-wrapper">
                            <label class="tb-label">
                                Từ khóa?					</label>
                            <div class="input-group">
                                <input id="filter_keyword" class="tb-input" placeholder="Nhập tên cần tìm" type="text" value="" name="keyword" />					</div>
                        </div>
                        <div class="text-box-wrapper">
                            <label class="tb-label">
                                Điểm đến?					</label>
                            <div class="input-group">
                                <select class="tb-input select2" name="location" id="filter_location">
                                    <option value="" selected="selected">Choose Location</option>
                                    @foreach($destinationpoints_menucate as $dp )
                                        @if($dp->isOutbound == $isOutbound)
                                        <option value="{{ $dp->id }}" {{ isset($inputs['tour_dest'])?($inputs['tour_dest']==$dp->id?'selected="selected"':''):''  }}>{{ $dp->title }}</option>
                                        @endif
                                    @endforeach
                                </select>					</div>
                        </div>
                        <div class="input-daterange">
                            <div class="text-box-wrapper half left">
                                <label class="tb-label">
                                    Thời Gian đi						</label>
                                <div class="input-group">
                                    <input class="tb-input" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="" name="start_date" id="filter_startdate" />							<i class="tb-icon fa fa-calendar input-group-addon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id="do_filter" type="button" data-hover="TOUR" class="btn btn-slide small-margin-top" name="search-tour" value="1"><span class="text">Tìm Kiếm</span><span class="icons fa fa-long-arrow-right"></span></button>
                </div>
            </div>
        </div>
        @foreach($region_menus as $rg)
        <div class="col-1">
            <div class="city-widget widget">
                <div class="title-widget">
                    <div class="title">{{ $rg->title }}</div>
                </div>
                <div class="content-widget">
                    <div>
                        <a href="javascript:void(0);" title="" class="btn-reset hide">Xóa</a>
                    </div>
                    <div class="radio-selection">
                        @foreach($destinationpoints_menucate as $dp)
                            @if($dp->region_id == $rg->id && $dp->count_tour>0)
                        <div class="radio-btn-wrapper">
                            <input {{ isset($inputs['tour_dest'])?($inputs['tour_dest']==$dp->id?'checked="checked"':''):''  }} {{ (isset($destinationpoint)&&class_basename($destinationpoint)==='DestinationPoint')&&$destinationpoint->id==$dp->id?'checked="checked"':'' }} type="checkbox" name="filter_destinations[]"  value="{{ $dp->id }}" id="{{ $dp->slug }}" class="radio-btn">
                            <label for="{{ $dp->slug }}" class="radio-label">{{ $dp->title }}</label>
                            <span class="count count_dest_{{ $dp->id }}">{{ $dp->count_tour }}</span>
                        </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-1">
            <div class="city-widget widget">
                <div class="title-widget">
                    <div class="title">Chủ Đề Tour</div>
                </div>
                <div class="content-widget">
                    <div><a href="javascript:void(0);" title="" class="btn-reset hide">Xóa</a></div>
                    <div class="radio-selection">
                        @foreach($subjecttours_menucate  as $st)
                            @if($st->count_tour >0)
                                @if( $st->isOutbound == $isOutbound )
                        <div class="radio-btn-wrapper">
                            <input  {{ (isset($destinationpoint)&&class_basename($destinationpoint)==='SubjectTour')&&$destinationpoint->id==$st->id?'checked="checked"':'' }} type="checkbox" name="filter_subjects[]"  value="{{ $st->id }}" id="{{ $st->slug }}" class="radio-btn">
                            <label for="{{ $st->slug }}" class="radio-label">{{ $st->title }}</label>
                            <span class="count count_subj_{{ $st->id }}">{{ $st->count_tour }}</span>
                        </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-2">
            <div class="col-1">
                <div class="price-widget widget tour">
                    <div class="title-widget">
                        <div class="title">Theo Giá</div>
                    </div>
                    <div class="content-widget">
                        <div><a href="javascript:void(0);" title="" class="btn-reset hide">Xóa</a></div>
                        <div class="price-wrapper">
                            <div data-range_min="0" data-range_max="50000000" data-cur_min="0" data-cur_max="50000000" class="nstSlider">
                                <div class="leftGrip indicator">
                                    <div class="number"></div>
                                </div>
                                <div class="rightGrip indicator">
                                    <div class="number"></div>
                                </div>
                            </div>
                            <div class="leftLabel">0 đ</div>
                            <div class="rightLabel">50,000,000 đ</div>
                            <input type="hidden" name="filter_price" class="sliderValue" value="0,50000000" /></div>
                    </div>
                </div>
            </div>
            <div class="col-1">
                <div class="rating-widget widget">
                    <div class="title-widget">
                        <div class="title">Tiêu Chuẩn</div>
                    </div>
                    <div class="content-widget">
                        <div><a href="javascript:void(0);" title="" class="btn-reset hide">
                                Clear				</a></div>
                        <div class="radio-selection">
                            <div class="radio-btn-wrapper">
                                <input type="checkbox" name="filter_stars[]" value="5"  id="5stars" class="radio-btn">
                                <label for="5stars" class="radio-label stars stars5">5 Sao</label>
                                <span class="count count_start_5">{{ $counttours_1star }}</span>
                            </div>
                            <div class="radio-btn-wrapper">
                                <input type="checkbox" name="filter_stars[]" value="4"  id="4stars" class="radio-btn">
                                <label for="4stars" class="radio-label stars stars4">4 Sao</label>
                                <span class="count count_start_4">{{ $counttours_2star }}</span>
                            </div>
                            <div class="radio-btn-wrapper">
                                <input type="checkbox" name="filter_stars[]" value="3"  id="3stars" class="radio-btn">
                                <label for="3stars" class="radio-label stars stars3">3 Sao</label>
                                <span class="count count_start_3" >{{ $counttours_3star }}</span>
                            </div>
                            <div class="radio-btn-wrapper">
                                <input type="checkbox" name="filter_stars[]" value="2"  id="2stars" class="radio-btn">
                                <label for="2stars" class="radio-label stars stars2">2 Sao</label>
                                <span class="count count_start_2">{{ $counttours_4star }}</span>
                            </div>
                            <div class="radio-btn-wrapper">
                                <input type="checkbox" name="filter_stars[]" value="1"  id="1stars" class="radio-btn">
                                <label for="1stars" class="radio-label stars stars1">1 Sao</label>
                                <span class="count count_start_1">{{ $counttours_5star }}</span>
                            </div>				</div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>