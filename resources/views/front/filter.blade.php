<section class="slz-header-sc">
    <div class="tab-search tab-search-long tab-search-default slz-shortcode ">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul role="tablist" class="nav nav-tabs">
                        <li role="presentation" class="tab-btn-wrapper">
                            <a href="#tour4126939905a92141189a7a" aria-controls="tour4126939905a92141189a7a" role="tab" data-toggle="tab" class="tab-btn">
                                <i class="flaticon-people"></i><span>TRONG NƯỚC</span>
                            </a>
                        </li>
                        <li role="presentation" class="tab-btn-wrapper">
                            <a href="#hotel4126939905a92141189a7a" aria-controls="hotel4126939905a92141189a7a" role="tab" data-toggle="tab" class="tab-btn">
                                <i class="flaticon-people"></i><span>NƯỚC NGOÀI</span>
                            </a>
                        </li>
                        <li role="presentation" class="tab-btn-wrapper">
                            <a href="#cruise4126939905a92141189a7a" aria-controls="cruise4126939905a92141189a7a" role="tab" data-toggle="tab" class="tab-btn">
                                <i class="flaticon-transport-4"></i><span>CẨM NANG</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content-bg">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="tab-content" data-placeholder="Choose Location">
                            <div role="tabpanel" id="tour4126939905a92141189a7a" class="tab-pane fade">
                                <div class="find-widget find-tours-widget widget">
                                    <h4 class="title-widgets">TÌM TOUR TONG NƯỚC</h4>
                                    <form class="content-widget" action="{{ asset('tour-trong-nuoc') }}" method="GET">
                                        <div class="text-input small-margin-top">
                                            <div class="place text-box-wrapper">
                                                <label class="tb-label">Bạn Đi Đâu?</label>
                                                <div class="input-group">
                                                    <select class="tb-input select2" name="tour_dest">
                                                        <option value="" selected="selected">Chọn điểm đến</option>
                                                        @foreach($diemden_trongnuoc as $dp)
                                                        <option value="{{ $dp->id }}">{{ $dp->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="input-daterange">
                                                <div class="text-box-wrapper">
                                                    <label class="tb-label">Thời Gian</label>
                                                    <div class="input-group">
                                                        <input class="tb-input" placeholder="YYYY-MM-DD" type="text" value="" name="search_by_date" />
                                                        <i class="tb-icon fa fa-calendar input-group-addon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="place text-box-wrapper"><label class="tb-label">Chủ Đề Tour</label>
                                                <div class="input-group">
                                                    <select class="tb-input selectbox" name="category">
                                                        <option value="" selected="selected">-- Chọn chủ đề --</option>
                                                        @foreach($subjecttours as $sub)
                                                            @if($sub->isOutbound != 1)
                                                            <option value="{{ $sub->id }}">{{ $sub->title }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="submit" name="isOutbound" value="0" data-hover="SEARCH NOW" class="btn btn-slide ">
                                                <span class="text">TÌM KIẾM</span>
                                                <span class="icons fa fa-long-arrow-right"></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div role="tabpanel" id="hotel4126939905a92141189a7a" class="tab-pane fade">
                                <div class="find-widget find-tours-widget widget">
                                    <h4 class="title-widgets">TÌM TOUR NƯỚC NGOÀI</h4>
                                    <form class="content-widget" action="{{ asset('tour-nuoc-ngoai') }}" method="GET">
                                        <div class="text-input small-margin-top">
                                            <div class="place text-box-wrapper">
                                                <label class="tb-label">Bạn Đi Đâu?</label>
                                                <div class="input-group">
                                                    <select class="tb-input select2" name="tour_dest">
                                                        <option value="" selected="selected">Chọn điểm đến</option>
                                                        @foreach($diemden_nuocngoai as $dp)
                                                            <option value="{{ $dp->id }}">{{ $dp->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="input-daterange">
                                                <div class="text-box-wrapper">
                                                    <label class="tb-label">Thời Gian</label>
                                                    <div class="input-group">
                                                        <input class="tb-input" placeholder="YYYY-MM-DD" type="text" value="" name="search_by_date" />
                                                        <i class="tb-icon fa fa-calendar input-group-addon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="place text-box-wrapper"><label class="tb-label">Chủ Đề Tour</label>
                                                <div class="input-group">
                                                    <select class="tb-input selectbox" name="category">
                                                        <option value="" selected="selected">-- Chọn chủ đề --</option>
                                                        @foreach($subjecttours as $sub)
                                                            @if($sub->isOutbound == 1)
                                                                <option value="{{ $sub->id }}">{{ $sub->title }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="submit" name="isOutbound" value="1" data-hover="SEARCH NOW" class="btn btn-slide ">
                                                <span class="text">TÌM KIẾM</span>
                                                <span class="icons fa fa-long-arrow-right"></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div role="tabpanel" id="cruise4126939905a92141189a7a" class="tab-pane fade">
                                <div class="find-widget find-cruises-widget widget">
                                    <h4 class="title-widgets">TÌM KIẾM CẨM NANG</h4>
                                    <form class="content-widget" action="">
                                        <div class="text-input small-margin-top">
                                            <div class="place text-box-wrapper">
                                                <label class="tb-label">Địa điểm?</label>
                                                <div class="input-group">
                                                    <select class="tb-input select2" name="location">
                                                        <option value="" selected="selected">Chọn Địa điểm</option>
                                                        <option value="italia">Đà Lạt</option>
                                                        <option value="japan">Nha Trang</option>
                                                        <option value="london">Phan Thiết</option>
                                                        <option value="new-york">Vũng Tàu</option>
                                                        <option value="paris">Ninh Chữ</option>
                                                        <option value="sweden">Nam Du</option>
                                                        <option value="tokyo">Đà Nẵng</option>
                                                        <option value="spain">Sapa</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="place text-box-wrapper">
                                                <label class="tb-label">Doanh Mục</label>
                                                <div class="input-group">
                                                    <select class="tb-input selectbox" name="category">
                                                        <option value="" selected="selected">-- Chọn Danh Mục --</option>
                                                        <option value="suite">Ẩm Thực</option>
                                                        <option value="superdeluxe">Kinh Nghiệm</option>
                                                        <option value="balcony">Hình Ảnh</option>
                                                        <option value="outside">Tin Tức slzexplooretravel</option>
                                                        <option value="luxury">Showbiz</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="submit" name="search-cruise" value="1" data-hover="SEARCH NOW" class="btn btn-slide ">
                                                <span class="text">TÌM KIẾM</span>
                                                <span class="icons fa fa-long-arrow-right"></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>