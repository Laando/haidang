
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript">
        document.documentElement.className = document.documentElement.className + ' yes-js js_active js'
    </script>
    @yield('title')
    <link href="{!!asset('images/favicon.ico') !!}" rel="shortcut icon" type="image/x-icon" />
    <meta name="geo.region" content="vi-vn" />
    <meta name="language" content="VI-VN">
    <meta name="author" content="Hải Đăng Travel - Thắp sáng niềm tin" />
    <meta name="distribution" content="Global" />
    <meta name="revisit-after" content="1 days" />
    <meta name="copyright" content="Haidangtravel" />
    <meta name="robots" content="FOLLOW,INDEX" />
    <meta property="og:site_name" content="HAIDANG TRAVEL"/>
    <meta property="og:url" content="{!! Request::fullUrl() !!}" />
    <meta property="fb:app_id" content="547213038750090" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="vi_vn" />
    <meta property="article:author" content="https://www.facebook.com/haidangtravel225" />
    <meta property="article:publisher" content="https://www.facebook.com/haidangtravel225" />
    <meta name="DC.creator" content="HAIDANG TRAVEL">
    @yield('meta')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('')}}assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('')}}assets/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('')}}assets/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('')}}css/main.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('')}}css/toastr.min.css">
    @yield('styles')
</head>

<body>
        @include('front.header')
        @yield('main')
        @include('front.footer')
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="{{ asset('')}}assets/bootstrap-4.3.1-dist/js/bootstrap.bundle.js"></script>
        <script src="{{ asset('')}}assets/bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('')}}assets/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>
        <script src="{{ asset('')}}js/toastr.min.js"></script>
        <script src="{{ asset('')}}js/main.js"></script>
        <script src="{{ asset('')}}js/jquery.inputmask.min.js"></script>
        <script>
            var _globalObj = {'_token':'{{csrf_token()}}'};
            @if($agent->isMobile())
            $('.owl-carousel.categoryhome').owlCarousel({
                // autoplay: true,
                // loop: true,
                //margin: 10,
                //responsiveClass:true,
                nav: false,
                navText: ["<div class='nav-btn prev-slide'></div>", "<div class='nav-btn next-slide'></div>"],
                responsive: {
                    0: {
                        items: 1 
                    },
                    600: {
                        items: 1 
                    },
                    1200: {
                        items: 8 ,
                       // autoWidth : true ,
                        autoHeight : true ,
                        center : true
                    }
                }
            })
            @endif
            $('.owl-carousel.hotplace').owlCarousel({
                autoplay: true,
                loop: true,
                margin: 10,
                nav: false,
                navText: ["<div class='nav-btn prev-slide'></div>", "<div class='nav-btn next-slide'></div>"],
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1200: {
                        items: 4
                    }
                }
            })
            $('.owl-carousel.banner').owlCarousel({
                autoplay: true,
                loop: true,
                // margin: 10,
                nav: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1200: {
                        items: 2
                    }
                }
            })
            $('.owl-carousel.bannertop ').owlCarousel({
                autoplay: true,
                loop: true,
                margin: 10,
                nav: false,
                dots: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1200: {
                        items: 1
                    }
                }
            })
            $('.owl-carousel.service ').owlCarousel({
                autoplay: true,
                loop: true,
                margin: 10,
                nav: false,
                navText: ["<div class='nav-btn prev-slide'></div>", "<div class='nav-btn next-slide'></div>"],
                responsive: {
                    0: {
                        items: 3
                    },
                    600: {
                        items: 3
                    },
                    1200: {
                        items: 6
                    }
                }
            })
            $('.owl-carousel.cup ').owlCarousel({
                autoplay: true,
                loop: true,
                margin: 10,
                nav: false,
                navText: ["<div class='nav-btn prev-slide'></div>", "<div class='nav-btn next-slide'></div>"],
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 5
                    },
                    1200: {
                        items: 7
                    }
                }
            })
            $('.owl-carousel.tour ').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                dots: false,
                navText: [
                    '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
                    '<i class="fa fa-arrow-right" aria-hidden="true"></i>'],
                responsive: {
                    0: {
                        items: 4
                    },
                    600: {
                        items: 5
                    },
                    1200: {
                        items: 7
                    }
                }
            })
            $('.owl-carousel.news ').owlCarousel({
                autoplay: true,
                loop: true,
                margin: 10,
                nav: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1200: {
                        items: 4
                    }
                }
            })
            $('#thumbs.owl-carousel ').owlCarousel({
                nav: false,
                dots: false
            })
        </script>
        {!! HTML::script('js/form.js') !!}
        {!! HTML::script('js/helper.js') !!}
        {!! HTML::script('js/user.js') !!}
        @yield('scripts')
        <script type="text/javascript">
            jQuery(document).ready(function() {
                @yield('ready')
                @yield('loginmodal')
                @yield('dropdown')
            });
        </script>
</body>
</html>