<div class="wrapper-mobile-nav">
    <div class="header-topbar">
        <div class="topbar-search search-mobile">
            <form role="search" method="get" class="search-form" action="">
                <input type="text" placeholder="Search here..." class="search-field search-input form-control searchbox" name="s" />
                <button type="submit" class="searchbutton btn-search fa fa-search"></button>
            </form>
        </div>
    </div>
    <div class="header-main">
        <div class="menu-mobile">
            <ul id="menu-main-navigation" class="nav-links nav navbar-nav slzexploore-menu">
                <li id="menu-item-548" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-45 current_page_item current-menu-ancestor current-menu-parent current_page_parent current_page_ancestor menu-item-has-children menu-item-548 active dropdown menu-item-depth1"><a class="main-menu" href=""><i class="fa  "></i>Trang Chủ</a>
                </li>
                <li id="menu-item-555" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-555 dropdown menu-item-depth1"><a class="main-menu" href=""><i class="fa  "></i>Du Lịch<span class="label label-danger">New</span><span class="icons-dropdown"><i class="fa fa-angle-down"></i></span></a>
                    <ul class="dropdown-menu dropdown-menu-1 exploore-dropdown-menu-1">
                        <li id="menu-item-534" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-534">
                            <a class="link-page" href="{{ asset('tour-trong-nuoc') }}"><i class="fa  "></i>Trong Nước</a></li>
                        <li id="menu-item-558" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-558">
                            <a class="link-page" href="{{ asset('tour-nuoc-ngoai') }}"><i class="fa  "></i>Nước Ngoài</a></li>
                    </ul>
                </li>
                <li id="menu-item-554" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-554 dropdown menu-item-depth1"><a class="main-menu" href="{{asset('tin-tuc/Du-lich-doan')}}"><i class="fa  "></i>Du Lịch Đoàn</a>
                    <ul class="dropdown-menu dropdown-menu-1 exploore-dropdown-menu-1">
                        @foreach($danhmuc_tourdoan as $subjectblog)
                        <li id="menu-item-535" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-535">
                            <a class="link-page" href="{{ asset('tin-tuc/'.$subjectblog->slug) }}"><i class="fa  "></i>{{$subjectblog->title}}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li id="menu-item-1342" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1342 dropdown menu-item-depth1"><a class="main-menu" href="{{asset('tin-tuc')}}"><i class="fa  "></i>Bài Viết</a>
                </li>
                <li id="menu-item-2742" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-2742 dropdown "><a class="link-page" href="{{asset('tro-giup/lien-he-gioi-thieu')}}"><span class="fa fa-angle-right icons-dropdown"></span><i class="fa  "></i>Giới Thiệu</a>
                </li>
                <li id="menu-item-562" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-562 dropdown menu-item-depth1"><a class="main-menu" href=""><i class="fa  "></i>Bảng Giá<span class="icons-dropdown"><i class="fa fa-angle-down"></i></span></a>
                    <ul class="dropdown-menu dropdown-menu-1 exploore-dropdown-menu-1">
                        <li id="menu-item-564" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-564">
                            <a class="link-page" href="{{ asset('bang-gia/1') }}"><i class="fa  "></i>Tour Trong Nước</a></li>
                        <li id="menu-item-629" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-629">
                            <a class="link-page" href="{{ asset('bang-gia/2') }}"><i class="fa  "></i>Tour Nước Ngoài</a></li>
                        <li id="menu-item-629" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-629">
                            <a class="link-page" href="{{ asset('bang-gia/4') }}"><i class="fa  "></i>SUPERSALE</a></li>
                        <li id="menu-item-629" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-629">
                            <a class="link-page" href="{{ asset('bang-gia/3') }}"><i class="fa  "></i>Tour Đoàn</a></li>
                    </ul>
                </li>
                <li id="menu-item-1239" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1239 mega-menu dropdown">
                    <a class="main-menu" href="#"><span class="text"><i class="fa  "></i>Điểm Đến </span>></a>
                    <div class="dropdown-menu mega-menu-content clearfix">
                        <ul class="mega-content-wrap">
                            <li class="mega-wrap">
                                <?php
                                $count_dd_trongnuoc = $diemden_trongnuoc->count();
                                $loop_count  = ceil($count_dd_trongnuoc /3) ;
                                ?>
                                    @for($i = 1 ; $i <= 3 ; $i++)
                                <div class="mega-menu-column col-md-3">
                                    <ul class="mega-menu-column-box">
                                        <li id="menu-item-1156" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1156 mega-menu-title sub-menu "><a href="javascript:void(0)" class="sf-with-ul"><i class="fa  "></i><span>Trong Nước</span></a>
                                            <ul class="dropdown-menu dropdown-menu-1">
                                                @foreach($diemden_trongnuoc as $index=>$dp)
                                                    @if($index < $i*$loop_count && $index >= ($i-1)*$loop_count)
                                                <li><a class="link-page" href="{{ asset('diem-den/'.$dp->title) }}"><span class="text"><i class="fa  fa-ship menu-icon"></i>Tour {{ $dp->title }}</span></a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                    @endfor
                                <div class="mega-menu-column col-md-3">
                                    <ul class="mega-menu-column-box">
                                        <li id="menu-item-1543" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1543 mega-menu-title sub-menu "><a href="javascript:void(0)" class="sf-with-ul"><i class="fa  "></i><span>Nước Ngoài</span></a>
                                            <ul class="dropdown-menu dropdown-menu-1">
                                                @foreach($diemden_nuocngoai as $index=>$dp)
                                                    @if($index < $loop_count)
                                                <li id="menu-item-1075"><a class="link-page" href="{{ asset('diem-den/'.$dp->title) }}"><span class="text"><i class="fa  fa-ship menu-icon"></i>Tour {{ $dp->title }}</span></a></li>
                                                    @endif()
                                                @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <ul class="topbar-right pull-right list-unstyled list-inline login-widget">
            <li><a href="{{ asset('login') }}" class="item">Đăng Nhập</a></li>
            <li><a href="{{ asset('logout') }}" class="item">Đăng Ký</a></li>
        </ul>
    </div>
</div>