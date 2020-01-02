@extends('front.template')
<?php
$image = 'assets/img/logo1-default.png';
if (isset($destinationpoint)) {
    $arrimg = explode(';', $destinationpoint->images);
    $image = checkImage($arrimg[0]);
    $image = 'image/' . $image;
    $seotitle = '';
    $seokeyword = '';
    $seodescription = '';
    $seotitle .= 'Tour du lịch ';
    $seokeyword .= '';
    $seodescription = '';
    $seotitle .= 'Tin Tức';
    $seokeyword .= $destinationpoint->seokeyword;
    $seodescription .= $destinationpoint->seodescription;

}
?>
@section('title')
    <title>{!! $seotitle !!}</title>
@stop
@section('meta')
    <meta name="keywords" content="{!! $seokeyword !!}"/>
    <meta name="description" content="{!! $seodescription !!}"/>
    <meta name="og:title" content="{!! $seotitle !!}"/>
    <meta name="og:image" content="{!!asset('assets/img/logo1-default.png')!!}"/>
    <meta name="og:description" content="{!! $seodescription !!}"/>
    <meta name="DC.title" content="{!! $seotitle !!}">
    <meta name="DC.subject" content="{!! $seodescription !!}">
@stop
@section('styles')

@stop
@section('main')
    <style>
        .content-news img{
            max-width: 100%;
            height: auto;
        }
    </style>
    <main>
        <div class="container">
            <div class="row my-2">
                <div class="col-lg-8 col-md-12 p-3">
                    <div class="text-md-left border-bottom">
                        <a class="text-dark w-100 ">
                            <h3><?= $blog->title ?></h3>
                        </a>
                        <?php $arrimg = explode(';', $blog->images);?>
                        <div class="d-flex">
                            <p class="fs-13 font-weight-bold color-ffa100 mr-2"><?= $blog->admin->fullname ?></p>
                            <p class="fs-13 font-weight-bold color-9c9"><i
                                        class="far fa-clock mx-1"></i><?php echo date('d/m/Y', strtotime($blog->created_at)) ?>
                            </p>
                        </div>
                        <div class="d-flex mb-1">
                            <div class="addthis_sharing_toolbox"></div>
                        </div>
                    </div>
                    <div class="mt-2 border-bottom">
                        <div class="font-weight-bold">
                            <p class="text-justify">
                                {!! strip_tags($blog->description,'<br><p>') !!}
                            </p>
                        </div>
                        <ul class="link list-circle">
                            @foreach($relateblogs as $b)
                                <li class="mb-0"><a class="color-9c9" href="{{ asset('tin-tuc/'.$b->slug) }}">{{ $b->title }} ({{ date('d/m/Y', strtotime($b->created_at)) }})</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="content-news my-3 text-justify">
                        {!!$blog->content !!}
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="px-2 pt-3 ">
                        <div class="header-news">
                            <h4 class="ml-2">Tin mới nhất</h4>
                        </div>
                        <div class="mt-1 row">
                            @foreach($mostviewblogs as $b)
                                <?php $arrimg = explode(';', $b->images);?>
                                <div class="media col-lg-12 col-sm-6 col-12">
                                    <a href="{{ asset('tin-tuc/'.$b->slug) }}">
                                    <div class="w-120x120 pl-0 m-1 bg-img-center"
                                         style="background-image:url('{{ asset('/image/'.$arrimg[0]) }}')">
                                        <!--<img class="img-thumbnail border-0" src="">-->
                                    </div>
                                    </a>
                                    <div class="media-body ">
                                        <a href="{{ asset('tin-tuc/'.$b->slug) }}"><strong class="post-summary2 text-dark w-img-100 d-inline-block mb-2 text-primary">{{ $b->title }}</strong></a>
                                        <p>({{ date('d/m/Y', strtotime($b->created_at)) }})</p>
                                        <div class="">
                                            <p class="post-summary3">
                                                {!! catchu( strip_tags($b->description) , 100 ) !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="px-2 pt-3">
                        <div class="header-news">
                            <h4 class="ml-2">Tin xem nhiều</h4>
                        </div>
                        <div class="mt-1 row">
                            @foreach($mostviewblogs as $b)
                                <?php $arrimg = explode(';', $b->images);?>
                                <div class="media col-lg-12 col-sm-6 col-12">
                                    <a href="{{ asset('tin-tuc/'.$b->slug) }}">
                                        <div class="w-120x120 pl-0 m-1 bg-img-center"
                                             style="background-image:url('{{ asset('/image/'.$arrimg[0]) }}')">
                                            <!--<img class="img-thumbnail border-0" src="">-->
                                        </div>
                                    </a>
                                    <div class="media-body ">
                                        <a href="{{ asset('tin-tuc/'.$b->slug) }}"><strong class="post-summary2 text-dark w-img-100 d-inline-block mb-2 text-primary">{{ $b->title }}</strong></a>
                                        <p>({{ date('d/m/Y', strtotime($b->created_at)) }})</p>
                                        <div class="">
                                            <p class="post-summary3">
                                                {!! catchu( strip_tags($b->description) , 100 ) !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="header-news bg-f3f3f3 py-2">
                    <h4 class="ml-2">Bài viết có liên quan</h4>
                </div>
                <div class="row pt-4 py-2 mx-auto news nav-none owl-carousel owl-theme">
                    @foreach($relateblogs as $b)
                        <?php $arrimg = explode(';', $b->images);?>
                        <a class="text-center" href="{{ asset('tin-tuc/'.$b->slug) }}">
                            <img src="{{ asset('/image/'.$arrimg[0])}}" class="m-auto img-thumbnail" alt="icon-01">
                            <strong class="post-summary3 text-dark w-img-100 d-inline-block mb-2 text-primary">{{ $b->title }}</strong>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5088a8f873c45f91"></script>
@stop