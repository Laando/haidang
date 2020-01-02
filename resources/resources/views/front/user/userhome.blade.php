@extends('front.template')
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
    <!-- Facebook Conversion Code for Đăng ký - FB- 20/08/2015 -->
    <script>(function() {
            var _fbq = window._fbq || (window._fbq = []);
            if (!_fbq.loaded) {
                var fbds = document.createElement('script');
                fbds.async = true;
                fbds.src = '//connect.facebook.net/en_US/fbds.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(fbds, s);
                _fbq.loaded = true;
            }
        })();
        window._fbq = window._fbq || [];
        window._fbq.push(['track', '6032628477009', {'value':'0.00','currency':'VND'}]);
    </script>
    <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6032628477009&amp;cd[value]=0.00&amp;cd[currency]=VND&amp;noscript=1" /></noscript>
@stop
@section('styles')
    <!-- Include Editor plugins CSS style. -->

@stop
@section('main')
    <main>
        <div class="col-lg-11 col-12 container px-xs-0">
            <div class="banner position-relative zindex-fixed mta75" style="z-index: 3;margin-top: -50px;">
                <div class="bannertop owl-carousel nav-none owl-theme">
                    <?php
                        $expiresAt = \Carbon\Carbon::now()->addMinutes(10);
                        $user_banner = \Illuminate\Support\Facades\Cache::remember('user_banner', $expiresAt, function () {
                            return \App\Models\Banner::where('type', 'like', 'user_banner')->orderBy('priority', 'ASC')->get();
                        });
                    ?>
                    @foreach($user_banner as $banner)
                        @php
                            if($agent->isMobile()){
                                $banner->images = imgageMobile($banner->images , 600 , 400);
                            }
                        @endphp
                        <a href="{{ $banner->url }}"><img src="{{ asset('image/'.$banner->images) }}" class="banner-home img-fluid w-100" alt="{{ $banner->title }}"></a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-sm-11 col-12 my-5 p-0 container big-border">
            <div class="row">
                <div class="col-3">
                    <?php
                        $user = auth()->user();
                        $avatar = 'image/avatar/'.$user->avatar;
                    ?>
                    <img src="{{ asset($avatar) }}" class="img-fluid" />
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link text-dark pt-4 pb-4 rounded-0 bg-ebebeb border-fff-left active" id="v-pills-info" data-toggle="pill" href="#info" role="tab" aria-controls="info" aria-selected="true">THÔNG TIN</a>
                        <a class="nav-link text-dark pt-4 pb-4 rounded-0 bg-ebebeb border-fff-left" id="v-pills-history" data-toggle="pill" href="#history" role="tab" aria-controls="history" aria-selected="false">LỊCH SỬ ĐẶT TOUR</a>
                        <a class="nav-link text-dark pt-4 pb-4 rounded-0 bg-ebebeb border-fff-left" id="v-pills-favorite" data-toggle="pill" href="#favorite" role="tab" aria-controls="favorite" aria-selected="false">TOUR YÊU THÍCH</a>
                        <a class="nav-link text-dark pt-4 pb-4 rounded-0 bg-ebebeb border-fff-left" id="v-pills-score" data-toggle="pill" href="#score" role="tab" aria-controls="score" aria-selected="false">ĐIỂM - QUÀ TẶNG</a>
                    </div>
                </div>
                <div class="col-9 mr-xs-0 position-relative">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="v-pills-info">
                            <form class="w-50 wline-sm-77 mt-4 ml-sm-5 ml-3 ">
                                <div class="form-group">
                                    <label for="">Họ tên</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                                @if($user->gender === '1')
                                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ông.</button>
                                                @else
                                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Bà.</button>
                                                @endif
                                        </div>
                                        <input type="text" class="form-control" aria-label="Text input with dropdown button" value="{{ $user->fullname }}" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="">
                                                <i class="fas fa-envelope"></i>
                                            </label>
                                        </div>
                                        <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Số điện thoại</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-mobile-alt"></i></button>
                                        </div>
                                        <input type="text" class="form-control" aria-label="Text input with dropdown button" value="{{ $user->phone }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Địa chỉ</label>
                                    <input type="text" class="form-control" aria-label="" value="{{ $user->address }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Giới tính</label>
                                    <div class="d-block">
                                        @if($user->gender === '1')
                                        <button type="button" class="btn btn-primary text-rgba rounded-0">
                                            <img src="{{ asset('images') }}/icon-30.png" height="30" />
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                        @else
                                        <button type="button" class="btn btn-ea4697 rounded-0 text-rgba">
                                            <img src="{{ asset('images') }}/icon-31.png" height="30" />
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="right-poin p-2 position-absolute bottom-a33">
                                    <button class="btn btn-lg  w-unset btn-wanning btn-block bg-color-line text-light rounded-0 m-auto text-uppercase" type="submit">Cập nhập</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="v-pills-history">
                            <table class="table table-striped mr-3 mt-4">
                                <tr>
                                    <th class="w-50">Tên tour</th>
                                    <th class="w-25">Ngày đặt</th>
                                    <th class="w-25">Trạng thái</th>
                                </tr>
                                @if(count($orders) > 0)
                                    <?php
                                        $status_name = ['Hủy' ,'Chờ xác nhận' ,'Đã thu cọc' , 'Kết thúc']
                                    ?>
                                    @foreach($orders as $index => $order)
                                    <tr>
                                        <td>{{ $order->startdate->tour? $order->startdate->tour->title : 'Tour đã bị xóa'}}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $status_name[$order->status*1] }}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                        <div class="tab-pane fade" id="favorite" role="tabpanel" aria-labelledby="v-pills-favorite">
                            <table class="table table-striped mr-3 mt-4">
                                <tr>
                                    <th class="w-50">Tên tour</th>
                                    <th class="w-25">Tiêu chuẩn</th>
                                    <th class="w-25">Thời gian</th>
                                </tr>
                                <tr>
                                    <td colspan="3"> Chờ xử lý</td>
                                </tr>

                            </table>
                        </div>
                        <div class="tab-pane fade position-relative" id="score" role="tabpanel" aria-labelledby="v-pills-score">
                            <h6 class="mt-3">SỐ ĐIỂM ĐANG CÓ <span class="h4 ff5400">{{ thousandsep($user->point) }}</span> ĐIỂM</h6>
                            <table class="table table-striped mr-3 mt-4">
                                <tr>
                                    <th class="w-50">Tên quà tặng</th>
                                    <th class="w-25">Số điểm sử dụng</th>
                                    <th class="w-25">Hạn dùng</th>
                                </tr>
                                @if(count($gifts) > 0)
                                    @foreach($gifts as $index=>$gift)
                                        <tr>
                                            <td>{{ $gift->title }}</td>
                                            <td>{{ $gift->point }}</td>
                                            <td>{{ $gift->expire }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                            <div class="right-poin top-unset p-2 position-absolute bottom-a33" style="top:-13px; bottom:unset">
                                <button class="btn btn-lg  w-unset btn-wanning btn-block bg-color-line text-light rounded-0 m-auto text-uppercase" type="submit" onclick="GoGift()">Đổi quà</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-efefef p-2 d-sm-none d-block">
            <div class="text-center w-100">
                <p class="font-weight-bold flex-nowrap">Ưu đãi khi sử dụng Haidangtravel App</p>
            </div>
            <div class="row mx-0">
                <div class="col-4 px-2 text-center">
                    <img src="images/icon-45.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
                    <p class="font-weight-bold">Mua sắm & thanh toán thuận tiện</p>
                </div>
                <div class="col-4 px-2 text-center">
                    <img src="images/icon-46.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
                    <p class="font-weight-bold">Nhiều ưu đãi hơn trên app</p>
                </div>
                <div class="col-4 px-2 text-center">
                    <img src="images/icon-47.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
                    <p class="font-weight-bold">Theo dõi đơn hàng dễ dàng</p>
                </div>
            </div>
            <div class="my-2">
                <button class="btn w-100 btn-wanning btn-block bg-color-line text-light rounded-0" type="button">Tải App</button>
            </div>
        </div>
        <div class="bg-oganre p-2 d-sm-none d-block">
            <div class="my-2">
                <button class="btn w-100 btn-wanning btn-block bg-ed1c24 text-light rounded-0 text-uppercase" type="button">Xem thông tin haidangtravel</button>
            </div>
        </div>
    </main>
        <!-- End Nội dung bài viết tour-->
        @include('front.footer')
    </div>
    <!--=== End Content Side Left Right ===-->
    @if(Session::has('submitSuccess'))
        <!-- Google Code for &#272;&#7863;t tour Conversion Page -->
        <script type="text/javascript">
            /* <![CDATA[ */
            var google_conversion_id = 973763657;
            var google_conversion_language = "en";
            var google_conversion_format = "3";
            var google_conversion_color = "ffffff";
            var google_conversion_label = "EQyuCOeCs28Qyeip0AM";
            var google_remarketing_only = false;
            /* ]]> */
        </script>
        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
        </script>
        <noscript>
            <div style="display:inline;">
                <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/973763657/?label=EQyuCOeCs28Qyeip0AM&amp;guid=ON&amp;script=0"/>
            </div>
        </noscript>
        @include('front.user.partials.congratulations')
    @endif
@stop
    @section('ready')
        $('.del-giohang').find('.fa.fa-times-circle').click(function(){
        delCart($(this));
        })
        doCalculateCart();
        @if(Session::has('submitSuccess'))
            $('#congratulations').modal('show');
        @endif
        enableEditor();
        $('#link-eventanh').click(function(){
        location = '{!! asset('eventblog') !!}';
        });
        $('#send_confirm_code').click(function(){
            notify('Mã xác nhận đã được gửi vào email của bạn ! Hãy điền vào form mã xác nhận và nhấn Xác Nhận Email');
        });
@stop
@section('scripts')
    <!-- froala editor -->
    {!! HTML::script('assets/froala/js/froala_editor.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/align.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/char_counter.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/code_view.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/colors.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/emoticons.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/entities.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/file.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/font_family.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/font_size.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/fullscreen.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/image.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/image_manager.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/inline_style.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/line_breaker.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/link.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/lists.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/paragraph_format.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/paragraph_style.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/quote.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/save.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/table.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/url.min.js') !!}
    {!! HTML::script('assets/froala/js/plugins/video.min.js') !!}

    <script>
        function updateCart(form){
            var rid = $(form).find('input[name="rid"]').val();
            var starhotel = $(form).find('input[name="starhotel"]:checked').val();
            var startdate = $(form).find('.selectedstartdate option:selected').val();
            var adult = $(form).find('input[name="soluong"]').val();
            var child = $(form).find('input[name="sotreem"]').val();
            var year =[];
            var chosen=[];
            $(form).find('.checkyear').each(function(index,element) {
                var selectedyear = $(element).find('select').val();
                var selectedchosen = $(element).find('input[name="cchosen[]"]').val() || 0;
                year[year.length] = selectedyear;
                chosen[chosen.length]= selectedchosen;
            });
            var token = _globalObj._token;
            $.ajax({
                url: 'http://'+window.location.host+'/updateCart',
                type: "POST",
                data: {rid: rid,starhotel:starhotel,selectedstartdate:startdate,soluong:adult,sotreem:child,year:year,cchosen:chosen, _token: token},
                success: function (data, textStatus, jqXHR) {
                    if(data=='ok'||data=='') {
                        console.log(data);
                    } else {
                        jsonobj = $.parseJSON(data);
                        console.log(jsonobj);
                    }
                }
            });
        }
        function GoGift() {
            window.location = '/userhome/gift';
        }
    </script>
    {!! HTML::script('js/user.js') !!}
@stop
