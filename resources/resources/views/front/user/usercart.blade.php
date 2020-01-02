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
    <!-- Page Title -->
    <section class=" page-title">
        <div class="container">
            <div class="page-title-wrapper">
                <div class="page-title-content">
                    {!! Breadcrumbs::render('cart') !!}
                </div>
            </div>
        </div>
    </section>
    <!-- Content section -->
    <div class="section section-padding page-detail padding-top padding-bottom">
        <div class="container">
            <div class="row">
                <div id="page-content" class="col-md-12 col-xs-12">
                    <div id="post-662" class="post-662 page type-page status-publish hentry" >
                        <div class="section-page-content clearfix ">
                            <div class="entry-content">
                                <div class="woocommerce">
                                    @if(!auth()->check())
                                    <div class="woocommerce-info">Tính năng này chỉ được sử dụng khi có tài khoản ! Bạn đã có tài khoản? <a href="#showLogin" data-toggle="collapse"  class="showlogin">Đăng nhập tại đây</a></div>
                                        <div class="collapse {!! $errors->any()?'in':'' !!} " id="showLogin">
                                            @include('auth.loginform')
                                        </div>
                                        <div class="woocommerce-info">Nếu chưa có tài khoản vui lòng đăng ký !<a href="{!! asset('register') !!}" class="showlogin">đăng ký tại đây </a></div>
                                    @else
                                        <?php
                                        $user = auth()->user();
                                        $username = $user->username;
                                        $phone = $user->phone;
                                        $fullname = $user->fullname;
                                        $email = $user->email;
                                        $gender = $user->gender;
                                        $address = $user->address;
                                        ?>
                                    <div class="woocommerce-info">Bạn có mã giảm giá? <a href="#showCoupon"  data-toggle="collapse" class="showcoupon">nhập mã giảm giá tại đây</a></div>

                                    <form id="showCoupon"class="checkout_coupon collapse" method="post">
                                        {{ csrf_field() }}
                                        <p class="form-row form-row-first">
                                            <input type="text" name="coupon_code" class="input-text" placeholder="Nhập mã giảm giá tại đây" id="coupon_code" value="" />
                                        </p>

                                        <p class="form-row form-row-last">
                                            <input type="submit" class="button" name="apply_coupon" value="Sử dụng COUPON" />
                                        </p>

                                        <div class="clear"></div>
                                    </form>

                                    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="col2-set" id="customer_details">
                                            <div class="col-1">
                                                <div class="woocommerce-billing-fields">
                                                    <h3>Thông tin giao hàng</h3>

                                                    <p class="form-row form-row form-row-wide" id="billing_company_field">
                                                        <label for="" class="">Họ tên</label>
                                                        <input type="text" class="input-text " name="fullname" id="" placeholder="Nhập họ tên của bạn"  value="{!! old('fullname')!=''?old('fullname'):$fullname !!}"  />
                                                    </p>

                                                    <p class="form-row form-row form-row-first validate-required validate-email" id="billing_email_field">
                                                        <label for="billing_email" class="">Email<abbr class="required" title="required">*</abbr></label>
                                                        <input type="email" class="input-text " name="email" id="email" placeholder="Nhập mail của bạn"  value="{!! old('email')!=''?old('email'):$email !!}"  />
                                                    </p>

                                                    <p class="form-row form-row form-row-last validate-required validate-phone" id="billing_phone_field">
                                                        <label for="billing_phone" class="">Điện thoại <abbr class="required" title="required">*</abbr></label>
                                                        <input type="text" class="input-text " name="phone" id="phone" placeholder="Nhập điện thoại của bạn"  value="{!! old('phone')!=''?old('phone'):$phone !!}"  />
                                                    </p>
                                                    <div class="clear"></div>


                                                    <p class="form-row form-row form-row-wide address-field validate-required" id="billing_address_1_field">
                                                        <label for="billing_address_1" class="">Địa chỉ <abbr class="required" title="required">*</abbr></label>
                                                        <input type="text" class="input-text " name="address" id="address" placeholder="Nhập địa chỉ của bạn"  value="{!! old('address')!=''?old('address'):$address !!}" />
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="woocommerce-shipping-fields">


                                                    <h3>Thông tin đơn hàng</h3>

                                                    <section class="order-details__section order-details__footer-column">
                                                        <div class="order-details__section-title" data-spm-anchor-id="a2o4n.order-details.0.i0.f8db75abQyuwtX">
                                                            Tour buôn mê thuột hd101      </div>

                                                        <div class="order-details__receipt">
                                                            <div class="order-details__receipt-row">
                                                                <div class="order-details__receipt-column">Người lớn (3)</div>
                                                                <div class="order-details__receipt-column order-details__receipt-column_right">320.000 VND</div>
                                                            </div>
                                                            <div class="order-details__receipt-row">
                                                                <div class="order-details__receipt-column">Trẻ em 1</div>
                                                                <div class="order-details__receipt-column order-details__receipt-column_right">5.000 VND</div>
                                                            </div>
                                                            <div class="order-details__receipt-row">
                                                                <div class="order-details__receipt-column">Trẻ em 2</div>
                                                                <div class="order-details__receipt-column order-details__receipt-column_right">0 VND</div>
                                                            </div>

                                                            <div class="order-details__receipt-summary">
                                                                <div class="order-details__receipt-row">
                                                                    <div class="order-details__receipt-column">
                                                                        <div class="order-details__receipt-summary-label">Tổng</div>
                                                                    </div>
                                                                    <div class="order-details__receipt-column order-details__receipt-column_right">
                                                                        <span class="order-details__receipt-summary-total">320.000 VND</span>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </section>
                                                    <input type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="Đặt tour" data-value="Place order">




                                                </div>
                                            </div>
                                        </div>
                                </form>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop
@section('ready')
    $('.del-giohang').find('.fa.fa-times-circle').click(function(){
        delCart($(this));
    })
    doCalculateCart();
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
        function newCustomer(node){
            if($(node).prop('checked')) {
                $('a[href="#dangky"]').click();
                $(node).prop('checked',false);
            }
        }
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
