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
    {!! HTML::style('assets/froala/css/froala_editor.min.css') !!}
    {!! HTML::style('assets/froala/css/froala_style.min.css') !!}
    {!! HTML::style('assets/froala/css/themes/royal.min.css') !!}
    {!! HTML::style('assets/froala/css/plugins/char_counter.min.css') !!}
    {!! HTML::style('assets/froala/css/plugins/code_view.min.css') !!}
    {!! HTML::style('assets/froala/css/plugins/colors.min.css') !!}
    {!! HTML::style('assets/froala/css/plugins/emoticons.min.css') !!}
    {!! HTML::style('assets/froala/css/plugins/file.min.css') !!}
    {!! HTML::style('assets/froala/css/plugins/fullscreen.min.css') !!}
    {!! HTML::style('assets/froala/css/plugins/image.min.css') !!}
    {!! HTML::style('assets/froala/css/plugins/image_manager.min.css') !!}
    {!! HTML::style('assets/froala/css/plugins/line_breaker.min.css') !!}
    {!! HTML::style('assets/froala/css/plugins/table.min.css') !!}
    {!! HTML::style('assets/froala/css/plugins/video.min.css') !!}
@stop
@section('main')
    <!--=== Content Side Left Right ===-->
<style>
    .status-update {
        position: fixed;
        top: 30px;
        background-color: #A8FFD3;
        color: red;
        line-height: 30px;
        width: 150px;
        text-align: center;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 3px rgba(0,0,0,.4);
        -moz-box-shadow: 0 1px 3px rgba(0,0,0,.4);
        box-shadow: 0 1px 3px rgba(0,0,0,.4)
    }
    .sky-form .tooltip {
        z-index: 100000!important;
        position: fixed!important;
    }
    .sky-form .tooltip .tooltip-inner{
        font-size: 10pt!important;
        line-height:20px;
    }
    .adult_total , .child_total
    {
        color:blue;
    }
    .total {
        color: red;
    }
</style>
    <div class="content-side-right">
        <!--=== Breadcrumbs ===-->
        {!! Breadcrumbs::render('userhome') !!}
        <!--=== End Breadcrumbs ===-->
        <!--Nội dung bài viết tour-->
        <div class="container content">
            <div class="row">
                <!-- Begin Content -->
                <div class="col-md-12 thongtin-user">
                    <ul class="nav nav-tabs">
                        <li {!! $page==1?'class="active"':'' !!}><a href="#thongtin-user" data-toggle="tab">Thông Tin Cá Nhân</a></li>
                        <li {!! $page==2?'class="active"':'' !!}><a href="#donhang" data-toggle="tab">Đơn Hàng</a></li>
                        <li {!! $page==3?'class="active"':'' !!}><a href="#lichsudangky" data-toggle="tab">Lịch Sử Đăng Ký</a></li>
                        <li {!! $page==4?'class="active"':'' !!} id="link-eventanh"><a href="#eventanh" data-toggle="tab">Event thi ảnh</a></li>
                    </ul>
                    <!-- Tabs -->
                    <div class="tab-v1">
                        <div class="tab-content">
                            @if($user!=null)
                            <!-- Success Forms -->
                            <div class="tab-pane fade {!! $page==1?'active in':'' !!}" id="thongtin-user">
                                <div class="col-md-4">
                                    <!-- Update-Form -->
                                    {!! Form::open(['url' => 'userhome/update', 'method' => 'post', 'role' => 'form','class'=>'sky-form']) !!}
                                    @if(Session::has('updateUser'))
                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <strong>Đăng nhập của bạn có lỗi</strong>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @endif
                                    @if(session()->has('ok'))
                                        @include('partials/error', ['type' => 'success', 'message' => session('ok')])
                                    @endif
                                        <fieldset>
                                            <section>
                                                <label class="input">
                                                    <i class="icon-append fa fa-user"></i>
                                                    {!! Form::text('username', $user->username, array('placeholder' => 'Tên đăng nhập','id'=>'username')) !!}
                                                    <b class="tooltip tooltip-bottom-right">Tên đăng nhập (bắt buộc)</b>
                                                </label>
                                            </section>
                                            <section>
                                                <label class="input">
                                                    <i class="icon-append fa fa-phone"></i>
                                                    {!! Form::input('tel', 'phone', $user->phone, ['placeholder' => 'Số điện thoại','id'=>'phone','disabled'=>'disabled']) !!}
                                                    <b class="tooltip tooltip-bottom-right">Nhập số điện thoại ( bắt buôt )</b>
                                                </label>
                                            </section>
                                            <section>
                                                <label class="input">
                                                    <i class="icon-append fa fa-user"></i>
                                                    {!! Form::text('fullname', $user->fullname, array('placeholder' => 'Họ và tên','id'=>'fullname')) !!}
                                                    <b class="tooltip tooltip-bottom-right">Nhập họ tên của bạn</b>
                                                </label>
                                            </section>
                                            <section>
                                                <label class="input">
                                                    <i class="icon-append fa fa-envelope"></i>
                                                    {!! Form::input('email', 'email', $user->email, ['placeholder' => 'Email','id'=>'email' ]) !!}
                                                    <b class="tooltip tooltip-bottom-right">Nhập mail của bạn</b>
                                                </label>
                                            </section>
                                            <section>
                                                <label class="input">
                                                    <i class="icon-append fa fa-lock"></i>
                                                    {!! Form::input('password', 'oldpassword', null, ['placeholder' => 'Mật khẩu cũ','id'=>'oldpassword']) !!}
                                                    <b class="tooltip tooltip-bottom-right">Nhập mật khẩu ( bắt buột )</b>
                                                </label>
                                            </section>
                                            <section>
                                                <label class="input">
                                                    <i class="icon-append fa fa-lock"></i>
                                                    {!! Form::input('password', 'password', null, ['placeholder' => 'Mật khẩu mới','id'=>'password']) !!}
                                                    <b class="tooltip tooltip-bottom-right">Nhập mật khẩu ( bắt buột )</b>
                                                </label>
                                            </section>
                                            <section>
                                                <label class="input">
                                                    <i class="icon-append fa fa-lock"></i>
                                                    {!! Form::input('password', 'password_confirmation', null, ['placeholder' => 'Xác nhận mật khẩu mới','id'=>'password_confirmation']) !!}
                                                    <b class="tooltip tooltip-bottom-right">Nhập lại mật khẩu ( bắt buột )</b>
                                                </label>
                                            </section>
                                        </fieldset>
                                        <fieldset>
                                            <section>
                                                <label class="select">
                                                    {!! Form::select('gender', array('1' => 'Nam', '2' => 'Nữ','3'=>'Khác'),$user->gender,array('class'=>'selectpicker form-control')) !!}
                                                    <i></i>
                                                </label>
                                            </section>
                                            <section>
                                                <label class="input">
                                                    <i class="icon-append fa fa-briefcase"></i>
                                                    {!! Form::text('address', $user->address, array('placeholder' => 'Địa chỉ','id'=>'address')) !!}
                                                    <b class="tooltip tooltip-bottom-right">Địa chỉ nhà bạn</b>
                                                </label>
                                            </section>
                                            <section>
                                                <label class="input">
                                                    <i class="icon-append fa fa-calendar"></i>
                                                    {!! Form::text('dob', date_format(date_create($user->dob),'d/m/Y'), array('placeholder' => 'Ngày sinh','id'=>'finish')) !!}
                                                    <b class="tooltip tooltip-bottom-right">Ngày sinh của bạn</b>
                                                </label>
                                            </section>
                                        </fieldset>
                                        <div class="">
                                            <label>
                                                {!! Form::checkbox('getmail', '1', $user->getmail==1?true:false );!!} Nhận mail từ Hải Đăng Travel
                                            </label>
                                        </div>
                                        <button type="submit"  class="btn-u btn-u-red trim">XÁC NHẬN</button>
                                    {!! Form::close() !!}
                                    <!-- End Update-Form -->
                                </div>
                                <div class="col-md-8">
                                    <!--=== Parallax Counter v1 ===-->
                                    <div class="parallax-counter-v1 parallaxBg row tichlydiem-pax ">
                                        <h2 class="title-v2 title-light title-center">Xin chào {!! $user->fullname !!}</h2>
                                        <p class="space-xlg-hor text-center color-light">Chào mừng bạn đã đến với www.haidangtravel.com<br>
                                            Bạn đã tham gia vào <strong> {!! date_format(date_create($user->create_at),'d/m/Y') !!}</strong>
                                        </p>
                                        <div class="margin-bottom-10">
                                            <div class="col-md-12">
                                                <div class="counters">
                                                    <span class="counter">{!! $user->point !!}</span>
                                                    <h4>ĐIỄM TÍCH LŨY BẠN ĐÃ CÓ</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="margin-bottom-20"></div>
                                        <div class="text-center">   <a rel="pulse-shrink" class="btn-u btn-u-blue pulse-shrink"><span aria-hidden="true" class="icon-present"></span> HƯỚNG DẪN NHẬN QUÀ TẶNG</a></div>
                                    </div>
                                    <!--=== Parallax Counter v1 ===-->
                                </div>
                                <!--/ Success states for elements -->
                            </div>
                            <!-- End Success Forms -->
                            @endif
                            <!-- danghang -->
                            <div class="tab-pane fade {!! $page==2?'active in':'' !!}" id="donhang">
                            @if($user==null && session('noregister')!='true')
                                        <!--index_middle-->
                                        <div class="index_middle">
                                            <h3 class="text-center">ĐĂNG NHẬP ĐỂ TIẾP TỤC ĐẶT TOUR</h3>
                                            <div class="col-md-4 index_middle-col"><span>Đăng nhập bằng</span>
                                                <button class="btn btn-block btn-facebook-inversed rounded" onclick="window.location='oauth/facebook'">
                                                    <i class="fa fa-facebook"></i> Facebook
                                                </button>
                                                <button class="btn btn-block btn-googleplus-inversed rounded" onclick="window.location='oauth/google'">
                                                    <i class="fa fa-google-plus"></i> Google+
                                                </button>
                                                <button class="btn btn-block btn-twitter-inversed rounded" onclick="window.location='oauth/twitter'">
                                                    <i class="fa fa-twitter"></i> Twitter
                                                </button>
                                            </div>
                                            <div class="col-md-4 index_middle-col"><span>Đăng Nhập tài khoản Hải Đăng</span>
                                                <!-- Reg-Form -->
                                                {!! Form::open(['url' => 'auth/login', 'method' => 'post', 'role' => 'form','class'=>'login-form sky-form']) !!}
                                                    <fieldset>
                                                        <section>
                                                            <label class="input">
                                                                <i class="icon-append fa fa-user"></i>
                                                                <input type="text" name="log" placeholder="Nhập : User hoặc Mail hoặc Phone">
                                                                <b class="tooltip tooltip-bottom-right">Nhập tài khoản của bạn</b>
                                                            </label>
                                                        </section>
                                                        <section>
                                                            <label class="input">
                                                                <i class="icon-append fa fa-lock"></i>
                                                                <input type="password" name="password" placeholder="Nhập mật khẩu">
                                                                <b class="tooltip tooltip-bottom-right">Nhập mật khẩu của bạn</b>
                                                            </label>
                                                        </section>
                                                    </fieldset>
                                                    <button rel="trim" class="btn-u btn-u-red trim">ĐĂNG NHẬP</button>
                                                {!! Form::close() !!}
                                                <!-- End Reg-Form -->
                                            </div>
                                            <div class="col-md-4 text-center"><a href="{!! asset('noregister') !!}" class="btn_no_acc"></a></div>
                                        </div>
                                        <!--end index_middle-->
                                </div>
                            @else
                                <div class="col-md-6">
                                    @if(session('carterror')!=null)
                                        <div class="alert  alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Close</span>
                                            </button>
                                            {!! session('carterror') !!}
                                        </div>
                                    @endif
                                    @if(Cart::count()>0)
                                @foreach($cart as $row)
                                <?php
                                    $tour = $row->options->tour;
                                    $arrimg = explode(';',$tour->images);
                                    $image =  checkImage($arrimg[0]);
                                ?>
                                <!--giá và lịch khởi hành tour-->
                                {!! Form::open(['url' => 'updateCart', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
                                <div class="gia-lichkhoihanh-tour">
                                    <input type="hidden" name="rid" value="{!! $row->rowid !!}"/>
                                    <div class="top-giohang clearfix">
                                        <div class="col-md-4 box-shadow shadow-effect-2">
                                            <img class="img-responsive img-bordered" src="{!! asset('image/'.$image) !!}" alt="{!! $tour->title !!}">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="pull-right del-giohang"> <a><i class="fa fa-times-circle"></i> </a></div>
                                            <h5>{!! $tour->title !!}</h5>
                                            <span><i class="fa fa-check"></i> Thời gian  : <strong>{!! $tour->period !!}</strong></span><br>
                                            <span><i class="fa fa-check"></i> Phương tiện  : <strong>{!! $tour->traffic !!}</strong></span><br>
                                        </div>
                                    </div>
                                    <?php
                                    $eventtime =  Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $eventtimeconfig->content);
                                    $eventtimeend =  $eventtime->copy()->addHour(2);
                                    $now = Carbon\Carbon::now();
                                    $inEvent = $now->between($eventtime, $eventtimeend);
                                    ?>
                                    @if($tour->isGolden()&&$inEvent)
                                        <input type="hidden" name="isEvent" value="1" id="isEvent"/>
                                        <div class="golden-tag">Còn lại {!! $tour->countPromotionCode() !!} vé</div>
                                    @endif
                                    <div class="headline"><h2> <span aria-hidden="true" class="icon-calculator"></span> Kiểm Tra Giá & Lịch Khởi Hành </h2></div>
                                    <div class="row nopadding sky-form">
                                        <fieldset>
                                            <section>
                                                <div class="nopadding inline-group">
                                                    @if($tour->star0 != 0)
                                                    <label class="radio"><input type="radio" name="starhotel" value="{!! $tour->star0 !!}" {!! $row->price==$tour->star0?'checked':'' !!}><i class="rounded-x"></i>Nhà nghỉ</label>
                                                    @endif
                                                    @if($tour->star1 != 0)
                                                    <label class="radio"><input type="radio" name="starhotel" value="{!! $tour->star1 !!}" {!! $row->price==$tour->star1?'checked':'' !!}><i class="rounded-x"></i>1 Sao</label>
                                                        @endif
                                                        @if($tour->star2 != 0)
                                                    <label class="radio"><input type="radio" name="starhotel" value="{!! $tour->star2 !!}" {!! $row->price==$tour->star2?'checked':'' !!}><i class="rounded-x"></i>2 Sao</label>
                                                        @endif
                                                        @if($tour->star3 != 0)
                                                            <label class="radio"><input type="radio" name="starhotel" value="{!! $tour->star3 !!}" {!! $row->price==$tour->star3?'checked':'' !!}><i class="rounded-x"></i>3 Sao</label>
                                                        @endif
                                                        @if($tour->star4 != 0)
                                                            <label class="radio"><input type="radio" name="starhotel" value="{!! $tour->star4 !!}" {!! $row->price==$tour->star4?'checked':'' !!}><i class="rounded-x"></i>4 Sao</label>
                                                        @endif
                                                        @if($tour->star5 != 0)
                                                            <label class="radio"><input type="radio" name="starhotel" value="{!! $tour->star5 !!}" {!! $row->price==$tour->star5?'checked':'' !!}><i class="rounded-x"></i>5 Sao</label>
                                                        @endif
                                                        @if($tour->rs2 != 0)
                                                            <label class="radio"><input type="radio" name="starhotel" value="{!! $tour->rs2 !!}" {!! $row->price==$tour->rs2?'checked':'' !!}><i class="rounded-x"></i>RS 2 Sao</label>
                                                        @endif
                                                        @if($tour->rs3 != 0)
                                                            <label class="radio"><input type="radio" name="starhotel" value="{!! $tour->rs3 !!}" {!! $row->price==$tour->rs3?'checked':'' !!}><i class="rounded-x"></i>RS 3 Sao</label>
                                                        @endif
                                                        @if($tour->rs4 != 0)
                                                            <label class="radio"><input type="radio" name="starhotel" value="{!! $tour->rs4 !!}" {!! $row->price==$tour->rs4?'checked':'' !!}><i class="rounded-x"></i>RS 4 Sao</label>
                                                        @endif
                                                        @if($tour->rs5 != 0)
                                                            <label class="radio"><input type="radio" name="starhotel" value="{!! $tour->rs5 !!}" {!! $row->price==$tour->rs5?'checked':'' !!}><i class="rounded-x"></i>RS 5 Sao</label>
                                                        @endif
                                                </div>
                                            </section>
                                        </fieldset>
                                    </div>
                                    <div class="row nopadding sky-form check-khoihanh">
                                        <div class="col-md-3">Khởi Hành</div>
                                        <div class="col-md-5">
                                            <fieldset>
                                                <section name="startdate">
                                                    <label class="select state-success">
                                                        <select name="selectedstartdate" class="selectedstartdate">
                                                            <?php
                                                            $startdates = $tour->startdates()->where('startdate','>',new \DateTime())->orderBy('startdate','ASC')->get();
                                                                $selectedstartdate = $tour->startdates()->whereId($row->id)->first();
                                                            ?>
                                                            <span aria-hidden="true" class="icon-calendar"></span>
                                                            @foreach($startdates as $index=>$value)
                                                                    @if($tour->isGolden()&&$inEvent)
                                                                        <option value="{!! $value->id !!}" data-event="{!! $value->percent !!}" data-ticket="{!! $value->countPromotionCode() !!}" {!! date_format(date_create($value->startdate),'d/m/Y')==date_format(date_create($selectedstartdate->startdate),'d/m/Y')?'selected':'' !!}>{!! date_format(date_create($value->startdate),'d/m/Y') !!} {!! $value->percent!=0?'(-'.$value->percent.'%)':'' !!}</option>
                                                                    @else
                                                                        <option value="{!! $value->id !!}" {!! date_format(date_create($value->startdate),'d/m/Y')==date_format(date_create($selectedstartdate->startdate),'d/m/Y')?'selected':'' !!}>{!! date_format(date_create($value->startdate),'d/m/Y') !!}</option>
                                                                    @endif

                                                            @endforeach
                                                        </select>
                                                        <i></i>
                                                    </label>
                                                </section>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-4 text-right">= <strong class="startdate_price"></strong></div>
                                    </div>
                                    <div class="row nopadding sky-form check-khoihanh">

                                    </div>
                                    <div class="row nopadding sky-form check-khoihanh">
                                        <div class="col-md-3">Người lớn</div>
                                        <div class="col-md-5">
                                            <fieldset>
                                                <section name="startdate">
                                                    <label class="input">
                                                        <input type="number" name="soluong" placeholder="1" min="1" value="{!! $row->qty !!}">
                                                    </label>
                                                </section>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-4 text-right">= <strong class="adult_total"></strong></div>
                                    </div>
                                    <div class="row nopadding sky-form check-khoihanh">
                                        <div class="col-md-3">Trẻ em</div>
                                        <div class="col-md-5">
                                            <fieldset>
                                                <section name="startdate">
                                                    <label class="input">
                                                        <input type="number" name="sotreem" placeholder="1" min="0" value="{!! $row->options->child !!}">
                                                    </label>
                                                </section>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-4 text-right">= <strong class="child_total"></strong></div>
                                    </div>
                                    <div class="row nopadding sky-form check-khoihanh yearob">
                                        @foreach($row->options->year as $index => $year)
                                            <div class="checkyear clearfix">
                                                <input type="hidden" name="cchosen[]" value="{!! $year['chosen'] !!}"/>
                                                <div class="col-md-3">Năm sinh</div>
                                                <div class="col-md-3">
                                                    <fieldset>
                                                        <section>
                                                            <label class="select state-success">
                                                                <select name="year[]">
                                                                <?php $d  = date('Y')?>
                                                                @for($i=0;$i<=10;$i++)
                                                                    <option value="{!! $d-$i  !!}" {!! $d-$i==$year['year']?'selected':''  !!}>{!! $d-$i  !!}</option>
                                                                @endfor
                                                                </select>
                                                                <i></i>
                                                                </label>
                                                            </section>
                                                        </fieldset>
                                                    </div>
                                                <div class="col-md-2">
                                                    <label class="checkbox state-success" >
                                                        <input type="checkbox" name="checkbox" {!! 1==$year['chosen']?'checked':''  !!}>
                                                        <i data-toggle="tooltip" data-placement="left" title="Chọn vé chỗ ngồi cho trẻ em"></i>
                                                        </label>
                                                    </div>
                                                <div class="col-md-4 text-right">= <strong class="child_total"></strong></div>
                                                </div>
                                        @endforeach
                                    </div>
                                    <div class="row nopadding sky-form check-khoihanh">
                                        <div class="col-md-3">Tổng cộng</div>
                                        <div class="col-md-9 text-right"><span class="discount" style="text-decoration: line-through "></span>
                                            = <strong class="total"></strong>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                {!! Form::close() !!}
                                <!--End giá và lịch khởi hành tour-->
                                @endforeach
                                        @else
                                            <div class="notice-cart">Bạn không có giỏ hàng nào</div>
                                        @endif
                                </div>
                                <div class="col-md-6">
                                    <!-- Reg-Form -->
                                    {!! Form::open(['url' => 'submitCart', 'method' => 'post', 'class' => 'sky-form','id'=>'sky-form4']) !!}
                                        <header><h5>THÔNG TIN GIAO VOUCHER</h5>

                                        </header>
                                        <div class="clear"></div>
                                        <?php
                                            if($user!=null){
                                                $username = $user->username;
                                                $phone = $user->phone;
                                                $fullname = $user->fullname;
                                                $email = $user->email;
                                                $gender = $user->gender;
                                                $address = $user->address;
                                                $readonly = 'readonly';
                                            } else {
                                                $username ='';
                                                $phone ='';
                                                $fullname ='';
                                                $email='';
                                                $gender ='';
                                                $address ='';
                                                $readonly = ' ';
                                            }
                                        ?>
                                    @if(Session::has('submitCart'))

                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <strong>Đăng nhập của bạn có lỗi</strong>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @endif
                                        <fieldset>
                                            <section>
                                                <label class="input">
                                                    <i class="icon-append fa fa-user"></i>
                                                    {!! Form::text('username', $username, array('placeholder' => 'Tên đăng nhập','id'=>'username')) !!}
                                                    <b class="tooltip tooltip-bottom-right">Tên đăng nhập (bắt buộc)</b>
                                                </label>
                                            </section>
                                            <section>
                                                <label class="input">
                                                    <i class="icon-append fa fa-phone"></i>
                                                    {!! Form::input('tel', 'phone', $phone, ['placeholder' => 'Số điện thoại','id'=>'phone']) !!}
                                                    <b class="tooltip tooltip-bottom-right">Nhập số điện thoại ( bắt buôt )</b>
                                                </label>
                                            </section>
                                            <section>
                                                <label class="input">
                                                    <i class="icon-append fa fa-user"></i>
                                                    {!! Form::text('fullname', $fullname, array('placeholder' => 'Họ và tên','id'=>'fullname')) !!}
                                                    <b class="tooltip tooltip-bottom-right">Nhập họ tên của bạn</b>
                                                </label>
                                            </section>
                                            <section>
                                                <label class="input">
                                                    <i class="icon-append fa fa-envelope"></i>
                                                    {!! Form::input('email', 'email', $email, ['placeholder' => 'Email','id'=>'email']) !!}
                                                    <b class="tooltip tooltip-bottom-right">Nhập mail của bạn</b>
                                                </label>
                                            </section>
                                            @if($user==null)
                                            <section>
                                                <label class="input">
                                                    <i class="icon-append fa fa-lock"></i>
                                                    {!! Form::input('password', 'password', null, ['placeholder' => 'Mật khẩu','id'=>'password']) !!}
                                                    <b class="tooltip tooltip-bottom-right">Nhập mật khẩu ( bắt buột )</b>
                                                </label>
                                            </section>
                                            <section>
                                                <label class="input">
                                                    <i class="icon-append fa fa-lock"></i>
                                                    {!! Form::input('password', 'password_confirmation', null, ['placeholder' => 'Xác nhận mật khẩu','id'=>'password_confirmation']) !!}
                                                    <b class="tooltip tooltip-bottom-right">Nhập lại mật khẩu ( bắt buột )</b>
                                                </label>
                                            </section>
                                            @endif
                                        </fieldset>
                                        <fieldset>
                                            <section>
                                                <label class="select">
                                                    {!! Form::select('gender', array('1' => 'Nam', '2' => 'Nữ','3'=>'Khác'),$gender,array('class'=>'selectpicker form-control')) !!}
                                                    <i></i>
                                                </label>
                                            </section>
                                                <section>
                                                    <label class="input">
                                                        <i class="icon-append fa fa-briefcase"></i>
                                                        {!! Form::text('address', $address, array('placeholder' => 'Địa chỉ','id'=>'address')) !!}
                                                        <b class="tooltip tooltip-bottom-right">Địa chỉ giao nhận</b>
                                                    </label>
                                                </section>
                                        </fieldset>

                                            <button type="submit" class="btn-u">Xác Nhận Đơn Hàng</button>

                                    {!! Form::close() !!}
                                    <!-- End Reg-Form -->
                                </div>
                            </div>
                            <!-- End donhang -->
                            @endif
                            @if($user!=null)
                            <!-- Disabled Forms -->
                            <div class="tab-pane fade {!! $page==3?'active in':'' !!}" id="lichsudangky">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th class="col-md-7">TÊN TOUR</th>
                                        <th class="col-md-2">NGÀY ĐẶT</th>
                                        <th class="col-md-2">TÌNH TRẠNG</th>
                                        <th class="col-md-1">XEM</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $index=>$order)
                                        <?php
                                            $addings = $order->startdate->addings()->whereHas('addingcate' , function($q) {
                                                $q->where('isForced','=',1);
                                            })->get();
                                            $totalforcedadding = 0;
                                            foreach($addings as $adding)
                                                {
                                                    $totalforcedadding += $adding->price;
                                                }
                                            $sellprice = $totalforcedadding + $order->price;
                                        ?>
                                    <tr>
                                        <td>{!! $index+1 !!}</td>
                                        <td><a href="{!! asset($order->startdate->tour->slug) !!}">{!! $order->startdate->tour->title !!}</a></td>
                                        <td>{!! date_format(date_create($order->created_at),'d/m/Y') !!}</td>
                                        <td>{!! getStatusOrder($order->status) !!}</td>
                                        <td>  <!-- Modal -->
                                            <button class="btn-u" data-toggle="modal" data-target="#myModal{!! $index+1 !!}">XEM ĐƠN HÀNG

                                            </button>
                                            <div class="modal fade" id="myModal{!! $index+1 !!}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                            <span class="label label-info rounded"><i class="fa fa-asterisk"></i> Mã code : HD{!! $order->id !!}</span>
                                                            <h6>TÊN TOUR : <strong>{!! $order->startdate->tour->title !!}</strong></h6>
                                                            <div class="thoigian-dattour">
                                                                <ul class="list-inline posted-info">
                                                                    <li>Ngày khởi hành : {!! date_format(date_create($order->startdate->startdate),'d/m/Y') !!}</li>
                                                                    <li>Ngày xác nhận : {!! $order->approve_date!=null?date_format(date_create($order->approve_date),'d/m/Y'):'<strong style="color:red">Chưa xác nhận</strong>' !!}</li>
                                                                    <li><span class="label label-warning"><i class="fa fa-bookmark"></i> Điểm tích lỹ: {!! round(($order->total)/1000,0) !!}</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix modal-body">
                                                            <!--Hover Rows-->
                                                            <div class="col-md-12 nopadding clearfix">
                                                                <div class="panel panel-yellow margin-bottom-40">
                                                                    <div class="panel-heading">
                                                                        <h3 class="panel-title"><i class="fa fa-gear"></i> Chi tiết</h3>
                                                                    </div>
                                                                    <table class="table table-hover">
                                                                        <thead>
                                                                        <tr>

                                                                            <th>Nội Dung</th>
                                                                            <th>Số Lượng</th>
                                                                            <th>Giá</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>

                                                                            <td>Người lớn</td>
                                                                            <td>{!! $order->adult !!}</td>
                                                                            <td class="text-right">{!! numbertomoney($sellprice * $order->adult) !!}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Trẻ em</td>
                                                                            <td>{!! count(explode(';',trim($order->childlist,';'))) !!}</td>
                                                                            <td></td>
                                                                        </tr>
                                                                        <tr>

                                                                            <td>Phụ Thu </td>
                                                                            <td>(bao gồm vé trẻ em)</td>
                                                                            <td class="text-right">{!! numbertomoney($order->addingamount) !!}</td>
                                                                        </tr>
                                                                        <tr>

                                                                            <td>Giảm</td>
                                                                            <td>=</td>
                                                                            <td class="text-right"><strong>-{!! numbertomoney($order->discount) !!}</strong></td>
                                                                        </tr>
                                                                        <tr>

                                                                            <td>Giảm giờ vàng</td>
                                                                            <td>=</td>
                                                                            <td class="text-right"><strong>-{!! numbertomoney($order->discountgold) !!}</strong></td>
                                                                        </tr>
                                                                        <tr>

                                                                            <td>Tổng</td>
                                                                            <td>=</td>
                                                                            <td class="text-right"><strong style="color:red">{!! numbertomoney($order->total) !!}</strong></td>
                                                                        </tr>

                                                                        <tr>

                                                                            <td>Đặt cọc</td>
                                                                            <td>-</td>
                                                                            <td class="text-right">{!! numbertomoney($order->deposit) !!}</td>
                                                                        </tr>
                                                                        <tr>

                                                                            <td>Còn Lại</td>
                                                                            <td>=</td>
                                                                            <td class="text-right"><strong style="color:blue">{!! numbertomoney($order->total-$order->deposit) !!}</strong></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="margin-bottom-35">
                                                                <p>Số Ghế</p>
                                                                <?php $cseats = $order->seats()pluck('number')->all()  ?>
                                                                @foreach($cseats as $index=>$value)
                                                                    <span class="badge badge-u">{!! $value<10?'0'.$value:$value !!}</span>
                                                                @endforeach
                                                            </div>
                                                            <!--End Hover Rows-->
                                                            <!-- End Modal --></td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade {!! $page==4?'active in':'' !!}" id="eventanh">
                                <div class="col-md-12">
                                    @if(session()->has('ok-event'))
                                        @include('partials/error', ['type' => 'success', 'message' => session('ok-event')])
                                    @endif
                                        @if(session()->has('fail-event'))
                                            @include('partials/error', ['type' => 'danger', 'message' => session('fail-event')])
                                        @endif
                                    <button class="btn-u" data-toggle="modal" data-target="#eventanh-add">Tạo mới bài dự thi</button>
                                    <div class="modal fade froala-editor" id="eventanh-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                    <h2>Bài viết không thể chỉnh sửa khi đã kiểm duyệt !</h2>
                                                    <h6><strong>Tạo mới</strong></h6>
                                                </div>
                                                <div class="clearfix modal-body">
                                                    {!! Form::open(['url' => 'eventblog/create', 'method' => 'post', 'class' => 'form-horizontal panel','files' => true]) !!}
                                                    <div class="panel-body">
                                                        {!! Form::control('text', 0, 'title', $errors, trans('back/blogs.title')) !!}
                                                        {!! Form::selection('destinationpoint', $selectdestination , null, 'Chọn điểm đến') !!}
                                                        {!! Form::control('textarea', 0, 'description', $errors, trans('back/blogs.description')) !!}
                                                        {!! Form::control('textarea', 0, 'content', $errors, trans('back/blogs.content'))!!}
                                                        <div class="form-group images">
                                                            <label for="images" class="control-label">Hình đại diện</label>
                                                            <div class="images-1">
                                                                {!! Form::file('images-1',array('class'=>'images-1')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            {!! Form::submit('Tạo mới') !!}
                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                    <hr/>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th class="col-md-7">BÀI THI</th>
                                        <th class="col-md-2">NGÀY GỬI</th>
                                        <th class="col-md-2">LƯỢT XEM</th>
                                        <th class="col-md-2">TÌNH TRẠNG</th>
                                        <th class="col-md-1"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($eventposts as $index=>$eventpost)
                                        <?php
                                        ?>
                                        <tr>
                                            <td>{!! $index+1 !!}</td>
                                            <td><a href="{!! asset('tin-tuc/'.$eventpost->slug.'.html') !!}">{!! $eventpost->title !!}</a></td>
                                            <td>{!! date_format(date_create($eventpost->created_at),'d/m/Y') !!}</td>
                                            <td>{!! $eventpost->view !!}</td>
                                            <td>{!! $eventpost->publish==0?'Đang kiểm duyệt':'Đã kiểm duyệt' !!}</td>
                                            <td>  <!-- Modal -->
                                                <button class="btn-u" data-toggle="modal" data-target="#eventanh{!! $index+1 !!}"><i class="fa fa-pencil-square-o"></i>
                                                </button>
                                                <div class="modal fade froala-editor" id="eventanh{!! $index+1 !!}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                <h2>Bài viết không thể chỉnh sửa khi đã kiểm duyệt !</h2>
                                                                <h6><strong>{!! $eventpost->title !!}</strong></h6>
                                                            </div>
                                                            <div class="clearfix modal-body">
                                                                {!! Form::open(['url' => 'eventblog/edit', 'method' => 'post', 'class' => 'form-horizontal panel','files' => true]) !!}
                                                                <input type="hidden" name="id" value="{!! $eventpost->id !!}"/>
                                                                <div class="panel-body">
                                                                    {!! Form::control('text', 0, 'title', $errors, trans('back/blogs.title'),$eventpost->title) !!}
                                                                    {!! Form::selection('destinationpoint', $selectdestination , $eventpost->destinationpoint_id, 'Chọn điểm đến') !!}
                                                                    {!! Form::control('textarea', 0, 'description', $errors, trans('back/blogs.description'),$eventpost->description) !!}
                                                                    {!! Form::control('textarea', 0, 'content', $errors, trans('back/blogs.content') ,$eventpost->content )!!}
                                                                    <div class="form-group images">
                                                                        <label for="images" class="control-label">Hình đại diện</label>
                                                                        <div class="images-1">
                                                                            {!! Form::file('images-1',array('class'=>'images-1')) !!}
                                                                        </div>
                                                                        @if($eventpost->images!='')
                                                                            <div class="form-group ">
                                                                                <?php
                                                                                $arrimg = explode(';',trim($eventpost->images,';'));
                                                                                ?>
                                                                                @foreach($arrimg as $img)
                                                                                    <div class="col-md-4">{!! HTML::image('image/'.$img,'',array('class'=>'img-responsive')) !!}
                                                                                @endforeach
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            <div class="col-sm-12">
                                                                {!! Form::submit('Cập nhật') !!}
                                                            </div>
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Disabled Forms -->
                            @endif
                        </div>
                    </div>
                    <!-- End Tabs-->
                </div>
                <!-- End Content -->
            </div>
        </div>

        <!-- End Nội dung bài viết tour-->
        @include('front.footer')
    </div>
    <!--=== End Content Side Left Right ===-->
    @if(Session::has('submitSuccess'))
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
        location = '{!! asset('du-thi-anh.html') !!}';
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
                data: {starhotel:starhotel,selectedstartdate:startdate,soluong:adult,sotreem:child,year:year,cchosen:chosen, _token: token},
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
    </script>
    {!! HTML::script('js/user.js') !!}
    <script>
        @foreach($cart as $row)
        <?php
            $tour = $row->options->tour;
            $startdates = $tour->startdates()->where('startdate','>',new \DateTime())->orderBy('startdate','ASC')->get();
        ?>
        @foreach($startdates as $index=>$value)
        var isForcedAddings_{!! $value->id !!}  = '{ "addings" : [' +
        <?php
            $addings = $value->addings()->whereHas('addingcate' , function($q) {
                  $q->where('isForced','=',1);
            })->get();
        ?>
        @foreach($addings as $index=>$adding)
        '{"title":"{!! $adding->addingcate->title !!}","price":"{!! $adding->price !!}"}{!! $index+1<count($addings)?',':'' !!}' +
        @endforeach
    '] , "childgtsix" : [' +
        <?php
             $adding = $value->addings()->whereHas('addingcate' , function($q) {
                  $q->whereId(2);
             })->first();
        ?>
        @if($adding!=null)
        '{"title":"{!! $adding->addingcate->title !!}","price":"{!! $adding->price !!}"}{!! $index+1<count($addings)?',':'' !!}' +
        @endif

        '] , "childltsix" : [' +
        <?php
             $adding = $value->addings()->whereHas('addingcate' , function($q) {
                  $q->whereId(3);
             })->first();
        ?>
        @if($adding!=null)
        '{"title":"{!! $adding->addingcate->title !!}","price":"{!! $adding->price !!}"}{!! $index+1<count($addings)?',':'' !!}' +
        @endif
        '] , "childltsix50" : [' +
        <?php
             $adding = $value->addings()->whereHas('addingcate' , function($q) {
                  $q->whereId(5);
             })->first();
        ?>
        @if($adding!=null)
        '{"title":"{!! $adding->addingcate->title !!}","price":"{!! $adding->price !!}"}{!! $index+1<count($addings)?',':'' !!}' +
        @endif
']}';
        @endforeach
        @endforeach
    </script>
@stop
