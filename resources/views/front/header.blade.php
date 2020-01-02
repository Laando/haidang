<header>
    <section class="topBar_1e6g">
        <div class="container">
            <div class="row" style="margin:0; padding: 0">
                <div class="topBarCol_2wvN topBarColLeft_2fRx">
                    <a href="{{ asset('page/tai-app-haidang')}}" class="topBarLink_2Ybi" rel="nofollow">
                        <span><i class="fas fa-arrow-down"></i> Tải ứng dụng</span>
                    </a>
                    <a href="" class="topBarLink_2Ybi" rel="nofollow">
                        <span> <i class="far fa-bell"></i> Thông báo</span>
                    </a>
                    <a href="" class="topBarLink_2Ybi" rel="nofollow">
                        <span><i class="fas fa-gift"></i> Phiếu quà tặng</span>
                    </a>
                </div>

                <div class="topBarCol_2wvN">
                    <button id="login" class="topBarLink_2Ybi" rel="nofollow">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48" height="48">
                            <g data-name="Layer 2">
                                <g data-name="Layer 1">
                                    <path d="M24,4A20,20,0,1,0,44,24,20,20,0,0,0,24,4Zm0,6a6,6,0,1,1-6,6A6,6,0,0,1,24,10Zm0,28.4A14.4,14.4,0,0,1,12,32c.06-4,8-6.16,12-6.16S35.94,28,36,32A14.4,14.4,0,0,1,24,38.4Z">

                                    </path>
                                    <path d="M0,0H48V48H0Z" fill="none">

                                    </path>
                                </g>
                            </g>
                        </svg>
                        <span>
                            @if(!auth()->check())
                            <a class="text-white fs-13" href="{{ asset('login')}}">ĐĂNG NHẬP</a>/
                            <a class="text-white fs-13" href="{{ asset('register')}}">ĐĂNG KÝ</a>
                            @else
                            <a href="{{ asset('userhome/home')}}" class="item">Chào {{ auth()->user()->fullname }} !</a>
                            <a href="{{ asset('logout')}}" class="item">Thoát</a>
                            @endif
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <div class="stickyWrap_1CJt" style="z-index:11;">
        <div class="stickyContainer_29pF" style="top:0">
            <div class="appHeader_15ts">
                <div class="container">
                    <div class="row headerWrapper_tvuf" style="margin:0; padding: 0">
                        <div class="headerItem_o7OP logoWrap_1Zvr">
                            <div class="container_FsJz">
                                <a aria-label="logo_1s6i" href="/" class="logo_1s6i">
                                    <img src="{{ asset('')}}images/logo.png" alt="Haidangtravel chuyên tổ chức du lịch giá rẻ">
                                </a>
                            </div>
                        </div>
                        <div class="headerItem_o7OP autoWidth_3zfF">
                            <div class="searchBox_1T3n">
                                <form method="get" action="/search">

                                    <div class="inputGroup_3z0d input-group">
                                        <input name="query_home" value="{{ \Illuminate\Support\Facades\Input::get('query_home') }}" class="form-control" placeholder="Tìm kiếm nhanh " aria-label="Tìm kiếm trên nhanh ">
                                        <div class="input-group-append">
                                            <button class="btn searchButton_3d_3 orange">
                                                <i class="fas fa-search" style="font-size: 24px;"></i>Tìm kiếm
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <a href="tel:19002011">
                            <div class="headerItem_o7OP">
                                <div class="recentProductHeader_2GCr" style="  margin-left: 20px;font-size: 1.5rem">
                                    <span class="text_FC-6">19002011 <i class="fas fa-phone-square" ></i></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>