<footer>
    <div class="bg-f5f5f5">
        <div class="container">
            <div class="text-center row justify-content-center">

                <div class="col-md-6 col-lg-3 item_13ry" style=" padding: 10px; margin: 0;width: 50%;">
                    <a href="{{ asset('page/tai-app-haidang')}}"  rel="nofollow" >
                        <div class="iconBox_3BrW">
                            <img src="/images/icon_apphd.png" class="img-fluid w-100" alt="tải app Haidangtravel">
                        </div>
                        <h3 class="title_2y2L">Tải App Haidangtravel</h3>
                        <p class="description_2VJu text-desc">Mua Tour trong tầm tay của bạn, Cực Nhanh Nhiều ưu đãi</p>
                    </a>
                </div>
                <div class="col-md-6 col-lg-3 item_13ry" style="width: 50%; padding: 10px; margin: 0 ; border-left: solid 1px #b3b3b373 ">
                    <a href="{{asset('page/gioi-thieu')}}" rel="nofollow">
                        <div class="iconBox_3BrW">
                            <img src="/images/gioitheu_ft_hd.png" class="img-fluid w-100" alt="tải app Haidangtravel">
                        </div>
                        <h3 class="title_2y2L">GIỚI THIỆU Haidangtravel</h3>
                        <p class="description_2VJu text-desc">Haidangtravel luôn tự hào là đơn vị lữ hành top 1 tại HCM-VN</p>
                    </a>
                </div> 
                <div class="col-md-6 col-lg-3 item_13ry" style="width: 50%; padding: 10px; margin: 0 ; border-left: solid 1px #b3b3b373">
                    <a href="{{asset('page/chinh-sach-rieng-tu')}}" rel="nofollow">
                        <div class="iconBox_3BrW">
                            <img src="/images/chinhsach_icon.png" class="img-fluid w-100" alt="tải app Haidangtravel">
                        </div>
                        <h3 class="title_2y2L">Chính sách riêng tư</h3>
                        <p class="description_2VJu text-desc">Tìm hiểu cách mà chúng tôi xử lý, bảo vệ những thông tin cá nhân của bạn</p>
                    </a>
                </div> 
                <div class="col-md-6 col-lg-3 item_13ry" style="width: 50%; padding: 10px; margin: 0 ; border-left: solid 1px #b3b3b373">
                    <a href="{{asset('page/thanh-tich-dat-duoc')}}" rel="nofollow">
                        <div class="iconBox_3BrW">
                            <img src="/images/thanhtich_icon.png" class="img-fluid w-100" alt="tải app Haidangtravel">
                        </div>
                        <h3 class="title_2y2L">THÀNH THÍCH ĐẠT ĐƯỢC</h3>
                        <p class="description_2VJu text-desc">Những thành tích sau 13 năm thành lập và phát triển</p>
                    </a>
                </div> 



            </div>
        </div>
    </div>
    <div class="container text-center text-lg-left mt-5">
        <div class="row mt-3">
            <div class="col-lg-2 mx-auto mb-4">
                <h6 class="text-uppercase font-weight-bold">hỗ trợ khách hàng</h6>
                <p class="mb-0 color-d32f2e font-weight-bold">Đặt tour: 19002011</p>
                <p class="small">(Miễn ph: 8h-17h từ T2 đến T7)</p>
                <p class="mb-0 color-d32f2e font-weight-bold">Tư vấn: 0948991080</p>
                <p class="small">(Miễn phí:8h-16h từ T2 đến CN)</p>
                <a href="{{asset('page/yeu-cau-ho-tro')}}"><p>Gửi yêu cầu hỗ trợ</p></a>
                <a href="{{asset('page/huong-dan-dat-hang')}}"><p>Hướng dẫn đặt hàng</p></a>
                <a href="{{asset('page/hinh-thuc-thanh-toan')}}"><p>Hình thức thanh toán</p></a>
                <a href="{{asset('page/hinh-thuc-mua-huy-tour')}}"><p>Hình thức mua, hủy tour</p></a>
            </div>
            <div class="col-lg-2 mx-auto mb-4">
                <h6 class="text-uppercase font-weight-bold">Tour trong nước</h6>
                @foreach($diemden_trongnuoc as $index=>$dp)
                    <p><a href="{{ asset('diem-den/'.$dp->slug) }}" class="color-000">{{ $dp->title }}</a></p>
                @endforeach
            </div>
            <div class="col-lg-2 mx-auto mb-4">
                <h6 class="text-uppercase font-weight-bold">Tour nước ngoài</h6>
                @foreach($diemden_nuocngoai as $index=>$dp)
                    <p><a href="{{ asset('diem-den/'.$dp->slug) }}" class="color-000" >{{ $dp->title }}</a></p>
                @endforeach
            </div>
           
        </div>
    </div>
    <div class="footer-copyright text-center py-3">
        <p class="color-d32f2e mb-0 font-weight-bold">TRỤ SỞ CHÍNH Tòa nhà Building Haidang 367 Tân Sơn, Phường 15, Quận Tân Bình, thành phố Hồ Chí Minh</p>
        <p>Haidang Travel là doanh nghiệp chuyên tổ chức du lịch, teambuilding, event trong và ngoài nước</p>
    </div>
</footer>