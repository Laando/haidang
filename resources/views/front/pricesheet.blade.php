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
        <div class="col-lg-11 col-12 px-xs-0 container">
            <div class="banner position-relative zindex-fixed mta75" style="z-index: 3;">
                <div class="bannertop owl-carousel nav-none owl-theme">
                    <a href="#"><img src="{{ asset('')}}images/baner-home.png" class="banner-home img-fluid w-100" alt="banner-home"></a>
                </div>
            </div>
        </div>
        <div class="col-lg-11 col-12 container">
            <div class="mb-4 mt-4">
                <form class="form-inline" method="GET">
                    <div class="form-group mr-sm-1 mr-0 mb-2 wline-sm-100" style="width:25%">
                        <select class="form-control rounded-0 bg-yellow border-0" style="width:100%">
                            @php
                                $subjecttour_all  = $subjecttours->merge($subjecttours_out);
                            @endphp
                            @foreach($subjecttour_all as $sub)
                            <option value="{{ $sub->slug }}">{{ $sub->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mr-sm-1 mr-0 mb-2 wline-sm-100" style="width:30%">
                        <select class="form-control rounded-0 bg-yellow border-0" style="width:100%">
                            <option>Mới Nhất</option>
                            <option>Giá Thấp - Cao</option>
                            <option>Giá Cao - Thấp</option>
                            <option>Sắp khởi hành</option>
                            <option>Nhiều người xem</option>
                        </select>
                    </div>
                    <div class="form-group mb-2 wline-sm-100" style="width:25%">
                        <select class="form-control rounded-0 bg-yellow border-0" style="width:100%">
                            @php
                                $destinationpoint_all  = $destinationpoints->merge($destinationpoints_out);
                            @endphp
                            @foreach($destinationpoint_all as $sub)
                                <option value="{{ $sub->slug }}">{{ $sub->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn rounded-0 ml-sm-1 ml-0 mb-2 pr-3 pl-4 px-md-0 bg-oganre text-white w-md-15 wline-sm-100" style="width:18%"><i class="fas fa-search pr-2"></i>TÌM</button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered w-res-763">
                    <thead>
                    <tr>
                        <th class="text-center" style="width:5%">STT</th>
                        <th class="text-left">Tên Tour</th>
                        <th class="text-center" style="width:20%">Ngày khởi hành</th>
                        <th class="text-center" style="width:20%">Giá Tour</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td class="text-left">Tour Đảo Bình Hưng, Ninh Chữ 30/4, Gốm Bàu Trúc Dệt Mỹ Nghiệp Khuyến Mãi</td>
                        <td class="text-center">
                            <select class="form-control rounded-0 border-0 bg-none" style="width:100%">
                                <option>20/04/2019</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td class="text-center">299.000 Đ</td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td class="text-left">Tour Đảo Bà Lụa, Rừng Tràm Trà Sư, Châu Đốc</td>
                        <td class="text-center">
                            <select class="form-control rounded-0 border-0 bg-none" style="width:100%">
                                <option>20/04/2019</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td class="text-center">1.490.000 Đ</td>
                    </tr>
                    <tr>
                        <td class="text-center">3</td>
                        <td class="text-left">Tour Đảo Bình Ba - Tiệc BBQ Hải Sản</td>
                        <td class="text-center">
                            <select class="form-control rounded-0 border-0 bg-none" style="width:100%">
                                <option>20/04/2019</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td class="text-center">1.490.000 Đ</td>
                    </tr>
                    <tr>
                        <td class="text-center">4</td>
                        <td class="text-left">Tour Hà Tiên Châu Đốc, Hà Tiên, Rạch Giá, Miếu Bà Chúa Xứ</td>
                        <td class="text-center">
                            <select class="form-control rounded-0 border-0 bg-none" style="width:100%">
                                <option>20/04/2019</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td class="text-center">1.490.000 Đ</td>
                    </tr>
                    <tr>
                        <td class="text-center">5</td>
                        <td class="text-left">Tour Nha Trang - Đồng giá</td>
                        <td class="text-center">
                            <select class="form-control rounded-0 border-0 bg-none" style="width:100%">
                                <option>20/04/2019</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td class="text-center">1.490.000 Đ</td>
                    </tr>
                    <tr>
                        <td class="text-center">6</td>
                        <td class="text-left">Tour Đà Lạt Một Thoáng Mộng Mơ, Đồi Mộng Mơ, Chùa Thiên Vương Cổ Sát 2N2D</td>
                        <td class="text-center">
                            <select class="form-control rounded-0 border-0 bg-none" style="width:100%">
                                <option>20/04/2019</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td class="text-center">1.490.000 Đ</td>
                    </tr>
                    <tr>
                        <td class="text-center">7</td>
                        <td class="text-left">Tour Đà Lạt 30/4 thành phố ngàn hoa, Vườn Hoa Cẩm Tú Cầu, Đồi Chè Cầu Đất, Cổng Trời 3N2D</td>
                        <td class="text-center">
                            <select class="form-control rounded-0 border-0 bg-none" style="width:100%">
                                <option>20/04/2019</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td class="text-center">1.490.000 Đ</td>
                    </tr>
                    <tr>
                        <td class="text-center">8</td>
                        <td class="text-left">Tour Đà Lạt 30/4 Hồ Tuyền Lâm, Linh Quy Pháp Ấn, Tiệc nướng BBQ KDL Nam Qua 3N3D</td>
                        <td class="text-center">
                            <select class="form-control rounded-0 border-0 bg-none" style="width:100%">
                                <option>20/04/2019</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td class="text-center">1.490.000 Đ</td>
                    </tr>
                    <tr>
                        <td class="text-center">9</td>
                        <td class="text-left">Tour Hà Tiên Châu Đốc 30/4, Rạch Giá, Miếu Bà Chúa Xứ</td>
                        <td class="text-center">
                            <select class="form-control rounded-0 border-0 bg-none" style="width:100%">
                                <option>20/04/2019</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td class="text-center">1.490.000 Đ</td>
                    </tr>
                    <tr>
                        <td class="text-center">10</td>
                        <td class="text-left">Tour Cà Mau, Bạc Liêu, Sóc Trăng, Cánh Đồng Quạt Gió</td>
                        <td class="text-center">
                            <select class="form-control rounded-0 border-0 bg-none" style="width:100%">
                                <option>20/04/2019</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td class="text-center">1.490.000 Đ</td>
                    </tr>
                    <tr>
                        <td class="text-center">11</td>
                        <td class="text-left">Tour Phan Thiết Mũi Né, Thác Giang Điền, Đồi cát Bàu Trắng, Công Viên Tượng Cát</td>
                        <td class="text-center">
                            <select class="form-control rounded-0 border-0 bg-none" style="width:100%">
                                <option>20/04/2019</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td class="text-center">1.490.000 Đ</td>
                    </tr>
                    <tr>
                        <td class="text-center">12</td>
                        <td class="text-left">Tour Đà Lạt 30/4, BBQ Hàn Quốc, Hồ Tuyền Lâm Vào Rừng Ngắm Lá Phong, Nông Trại Vạn Thành 3N3D</td>
                        <td class="text-center">
                            <select class="form-control rounded-0 border-0 bg-none" style="width:100%">
                                <option>20/04/2019</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td class="text-center">1.490.000 Đ</td>
                    </tr>
                    <tr>
                        <td class="text-center">13</td>
                        <td class="text-left">Tour du lich Đảo Bình Ba Nha Trang, khám phá Vinpearland, Biển Dốc Lếch</td>
                        <td class="text-center">
                            <select class="form-control rounded-0 border-0 bg-none" style="width:100%">
                                <option>20/04/2019</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td class="text-center">1.490.000 Đ</td>
                    </tr>
                    <tr>
                        <td class="text-center">14</td>
                        <td class="text-left">Tour Đảo Điệp Sơn Nha Trang, con đường dưới biển, khu du lịch Hòn Chồng</td>
                        <td class="text-center">
                            <select class="form-control rounded-0 border-0 bg-none" style="width:100%">
                                <option>20/04/2019</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td class="text-center">1.490.000 Đ</td>
                    </tr>
                    <tr>
                        <td class="text-center">15</td>
                        <td class="text-left">Tour Nha Trang Con Sẽ Trẻ, Khu du lịch sealife, Bãi Biển Bãi Dài, Vinpearland</td>
                        <td class="text-center">
                            <select class="form-control rounded-0 border-0 bg-none" style="width:100%">
                                <option>20/04/2019</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td class="text-center">1.490.000 Đ</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="bg-efefef p-2 d-sm-none d-block">
            <div class="text-center w-100">
                <p class="font-weight-bold flex-nowrap">Ưu đãi khi sử dụng Haidangtravel App</p>
            </div>
            <div class="row mx-0">
                <div class="col-4 px-2 text-center">
                    <img src="{{ asset('')}}images/icon-45.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
                    <p class="font-weight-bold">Mua sắm & thanh toán thuận tiện</p>
                </div>
                <div class="col-4 px-2 text-center">
                    <img src="{{ asset('')}}images/icon-46.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
                    <p class="font-weight-bold">Nhiều ưu đãi hơn trên app</p>
                </div>
                <div class="col-4 px-2 text-center">
                    <img src="{{ asset('')}}images/icon-47.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
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
@stop

