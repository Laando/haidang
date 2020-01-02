<div class="bannertop owl-carousel owl-theme nav-none nav-res position-relative">
    @foreach($banners as $banner)
        @php
        if($agent->isMobile()){
            $banner->images = imgageMobile($banner->images , 600 , 400);
        }
        @endphp
    <a href="{{ $banner->url }}"><img src="{{ asset('image/'.$banner->images) }}" class="banner-home img-fluid w-100" alt="{{ $banner->title }}"></a>
    @endforeach
</div>
<div class="col-12 mx-auto tour owl-carousel owl-theme">
    <a class="text-center col-15 ">
        <img src="images/icon-01.png" class="p-md-1 m-auto" style="height:70px" alt="icon-01">
        <p>Tour biển đảo</p>
    </a>
    <a class="text-center col-15 ">
        <img src="images/icon-02.png" class="m-auto" style="height:70px" alt="icon-01">
        <p>Tour biển đảo</p>
    </a>
    <a class=" text-center col-15 ">
        <img src="images/icon-03.png" class="m-auto" style="height:70px" alt="icon-01">
        <p>Tour biển đảo</p>
    </a>
    <a class="text-center col-15  ">
        <img src="images/icon-04.png" class="m-auto" style="height:70px" alt="icon-01">
        <p>Tour biển đảo</p>
    </a>
    <a class="text-center col-15 ">
        <img src="images/icon-05.png" class="m-auto" style="height:70px" alt="icon-01">
        <p>Tour biển đảo</p>
    </a>
    <a class="text-center col-15 ">
        <img src="images/icon-06.png" class="m-auto" style="height:70px" alt="icon-01">
        <p>Tour biển đảo</p>
    </a>
    <a class="text-center col-15 ">
        <img src="images/icon-07.png" class="m-auto" style="height:70px" alt="icon-01">
        <p>Tour biển đảo</p>
    </a>
</div> 