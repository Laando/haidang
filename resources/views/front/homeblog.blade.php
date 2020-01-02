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
@stop
@section('styles')

@stop
@section('main')
<main>
    <div class="col-lg-11 col-md-12 container">
        <div class="mt-3">
            <div class="mb-3 col-12 text-center text-uppercase">
                <h4>{{ $subjectblog_blog->title }}</h4>
            </div>
            @if(strtolower($subjectblog_blog->slug) === 'tin-tuc')
            <div class="mb-5">
                <form class="row"  method="get">
                    <label for="" class="col-2 mt-2 text-center d-lg-block d-none">TÌM KIẾM</label>
                    <div class="form-group col-lg-10 mb-2 position-relative">
                        <input name="query" value="{{ \Illuminate\Support\Facades\Input::get('query') }}" type="text" placeholder="Gõ từ khóa" class="form-control rounded-0" style="width:100%">
                        <button type="submit" class="btn rounded-0 ml-2 mb-2 pr-2 pl-2 position-absolute bg-oganre text-white" style="right:15px;top:0;"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
            @else
                <div class="mb-md-3 d-md-block d-none">
                    <form class="form-inline" method="get">
                        <div class="form-group mx-1 wline-sm-100 mb-2" style="width:28%">
                            <select name="destination" class="form-control rounded-0" style="width:100%">
                                <option value="">Tất cả</option>
                                @foreach($destinationpoints_blog as $dp)
                                    <option {{ \Illuminate\Support\Facades\Input::get('destination')=== $dp->slug ? 'selected':''}} {{ $dp->slug===$destinationpoint_blog->slug }} value="{{ $dp->slug }}">{{ $dp->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mx-1 wline-sm-100 mb-2" style="width:19%">
                            <select name="category" class="form-control rounded-0" style="width:100%">
                                <option value="">Tất cả</option>
                                @foreach($subjectblogs_blog as $key=>$dp)
                                    <option {{ \Illuminate\Support\Facades\Input::get('category')=== strtolower($key) ? 'selected':''}} value="{{ $key }}">{{ $dp }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mx-1 mb-2 position-relative w-768-100" style="width:49%">
                            <input name="query" value="{{ \Illuminate\Support\Facades\Input::get('query') }}" type="text" placeholder="Gõ từ khóa" class="form-control rounded-0" style="width:100%">
                            <button type="submit" class="bg-oganre text-white btn rounded-0 ml-2 mb-2 pr-2 pl-2 position-absolute" style="right:0;top:0"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
                <form class="form-inline" method="get">
                <!-- begin mobile -->
                <div class="d-md-none d-block" style="width:100%">
                    <div class="d-flex mx-a15" style="width:100%">
                        <div class="w-50 px-0 find-res">
                            <input type="text" name="query" class="form-control rounded-0 border-right-0" placeholder="Nhập từ khóa" style="width:100%">
                        </div>
                        <div class="w-50 px-0">
                            <button type="button" id="btn-go" class="btn rounded-0 w-50 w-uset-320 mb-2 bg-white border" style="margin-right: -4px"><span class="small">Địa điểm</span></button>
                            <button type="button" id="btn-cato" class="btn rounded-0 w-50 w-uset-320 mb-2 bg-white border"><span class="small">Danh mục</span></button>
                        </div>
                    </div>

                <div class="position-fixed popup-mobile-cato w-100">
                    <div class="d-flex justify-content-between px-3 py-2 align-items-center bg-ed1d25 ">
                        <p class="text-white mb-0 close-mobile">Đóng</p>
                        <p class="text-white mb-0">Chọn danh mục</p>
                        <p class="text-white mb-0">Xong</p>
                    </div>
                    <div class="input-group p-2 bg-white">
                        <div class="input-group-prepend find_blog" style="z-index: 99">
                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-search"></i></span>
                        </div>
                        <input id="find_subject_blog" type="text" class="form-control border-left-0 find_blog_value" placeholder="Tìm chủ đề">
                    </div>
                    <div class="bg-white">
                        <div class="tab-pane " style="overflow-x: scroll;max-height: 300px;">
                            @foreach($subjectblogs_blog as $key=>$dp)
                                    <button class="{{ str_slug($dp)==\Illuminate\Support\Facades\Input::get('category') ?'':'bg-white' }} border-0 text-left py-2 align-items-center col-md-6" name="category" value="{{ str_slug($dp) }}">
                                        <img class="mx-3" src="/images/icon-51.png" width="15" height="15">{{ $dp }}
                                    </button >
                            @endforeach

                        </div>
                    </div>
                </div>
                <div class="position-fixed popup-mobile-go w-100">
                    <div class="d-flex justify-content-between px-3 py-2 align-items-center bg-ed1d25 ">
                        <p class="text-white mb-0 close-mobile">Đóng</p>
                        <p class="text-white mb-0">Chọn địa điểm</p>
                        <p class="text-white mb-0">Xong</p>
                    </div>
                    <div class="input-group p-2 bg-white">
                        <div class="input-group-prepend find_blog" style="z-index: 99">
                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-search"></i></span>
                        </div>
                        <input id="find_destination_blog" type="text" class="form-control border-left-0 find_blog_value" placeholder="Tìm địa điểm">
                    </div>
                    <div class="bg-white">
                        <div class="tab-pane " style="overflow-x: scroll;max-height: 300px;">
                            @foreach($destinationpoints_blog as $dp)
                                <button class=" {{ $dp->slug===\Illuminate\Support\Facades\Input::get('destination') ?'':'bg-white' }} border-0 text-left py-2 align-items-center col-md-6" name="destination" value="{{ $dp->slug }}">
                                    <img class="mx-3" src="/images/icon-51.png" width="15" height="15">{{ $dp->title }}
                                </button>
                            @endforeach

                        </div>
                    </div>
                </div>
                </div>
                </form>
            @endif
            <div class="content">
                <div class="row mb-4">
                    @foreach($home_blogs as $index=>$blog)
                        <?php
                        $date = date_format(date_create($blog->created_at),'d/m/Y') ;
                        $images = $blog->images ? explode(';', $blog->images) : [];
                        $image = count($images) ? rtrim($images[0], '.') : '';
                        if($agent->isMobile()){
                            $image = imgageMobile($image , 600 , 400);
                        }
                        ?>
                    <div class="col-md-6 col-12 ">
                        <div class="media py-2">
                            <div class="col-lg-4 col-6 pl-0">
                                <a href="{!! asset('tin-tuc/' . $blog->slug) !!}">
                                    <figure  class="bg-figure border-0" style="min-height:165px;background-size: cover;background-image:url('image/{{ $image }}')"></a>
                            </div>
                            <div class="media-body py-2">
                                <a href="{!! asset('tin-tuc/' . $blog->slug) !!}"><strong class="post-summary2 text-dark w-img-100 d-inline-block mb-2 text-primary">{!! $blog->title !!}</strong></a>
                                <div class="d-sm-block d-none">
                                    <p class="post-summary3">
                                        {!! catchu(strip_tags($blog->description,'<br>'),150) !!}
                                    </p>
                                </div>
                                <p class="mb-0 mt-auto"><small>{!! $date!!}</small></p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-center link">{!! $links !!}</div>
            </div>
        </form>

    </div>
</main>
@stop
@section('scripts')
    <script>

    </script>
@stop