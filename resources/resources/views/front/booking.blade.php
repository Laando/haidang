@extends('front.template')
@section('title')
    <title>Trang booking tour</title>
@stop
@section('meta')
            <?php
            $arrimg = explode(';',$tour->images);
            $image =  checkImage($arrimg[0]);
            $vehicles = \App\Models\Traffic::all();
            ?>
    <meta name="keywords" content="{!! $tour->seokeyword !!}" />
    <meta name="description" content="{!! $tour->seodescription !!}" />
    <meta name="og:title" content="{!! $tour->title !!}"/>
    <meta name="og:image" content="{!! asset('image/'.$image) !!}"/>
    <meta name="og:description" content="{!! $tour->seodescription !!}"/>
    <meta name="DC.title" content="{!! $tour->title !!}">
    <meta name="DC.subject" content="{!! $tour->seodescription !!}">
@stop
@section('styles')
    {!! HTML::style('css/bootstrap-datetimepicker.min.css') !!}
@stop
@section('main')
<main class="text-center">
    <div class="container">
        <div class="mt-3">
            <div class="row mb-md-5 mb-2 mx-0">
                <div class="col-lg-4 col-md-5 col-12 pl-md-0 mb-md-0 mb-2">
                    <div class="row">
                        <div class="col-md-12 col-4 m-auto pr-md-3 pr-0">
                            <img src="{!! asset('image/'.$image) !!}" class="img-fluid" alt="user">
                        </div>
                        <div class="col-md-12 col-8 m-auto">
                            <div class="row m-0 border mt-md-2" style="border-color:#000!important">
                                <div class="col-md-4 col-12 p-sm-3 p-2 p text-gray fs-13">Số ngày: {{ $tour->period }}</div>
                                <div class="col-md-8 col-12 x-xs-large x-large p-sm-2 p-1 color-ff5400 text-white font-weight-bold">{{ numbertomoney($startdate->adult_price) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7 col-12 p-0 border " style="border-color:#000!important">
                    <table class="table table-group-info">
                        <thead>
                        <tr class="text-left">
                            <th colspan="4">
                                {{ $tour->title }}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="border-0 text-left">
                        <tr>
                            @php
                           $id_part = $tour->id . '';
                           $total_char = strlen($id_part);
                           for ($i = $total_char; $i < 5; $i++) {
                               $id_part = '0' . $id_part;
                           }
                           $code_order = 'HD' . $id_part . date_format(date_create($tour->created_at), 'y');
                            @endphp
                            <td class="font-weight-bold">Mã tour</td>
                            <td colspan="3">{{ $code_order }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Ngày Khởi hành:</td>
                            <td>{{ date_format(date_create($startdate->startdate), 'd/m/Y')  }}</td>
                            <td>Tiêu chuẩn: </td>
                            @php
                                $adding_standard = '';
                                $addings = \GuzzleHttp\json_decode($startdate->addings);
                                $tour_standard = $cartItem['standard']; // id
                                foreach ($addings as $index => $adding) {
                                    if ($tour_standard) {
                                        if ($adding->obj * 1 === $tour_standard * 1) {
                                            //$tour_result->standard_price = $adding->price * 1;
                                            $adding_standard = $adding->name ;
                                        }
                                    }
                                }
                            @endphp
                            <td>{{ $cartItem['standard'] === null ? $tour->starhotel.' sao' : $adding_standard }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Phương tiện:</td>
                            <td colspan="3">{{ $vehicles->filter(function ($value, $key) use ($startdate) { return $value->idtypeVehicle == $startdate->traffic;})->first()->vehicle }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="fs-13 text-danger p-3 mt-4 d-md-block d-none">
                        <p class="text-justify ff5400 mb-0">Khách nữ từ 55 tuổi trở lên, khách nam từ 60 tuổi trở lên đi tour một mình và khách mang thai trên 4 tháng (16 tuần) vui lòng đăng ký tour trực tiếp tại văn phòng của HAIDANGTRAVEL. Không áp dụng đăng ký tour online đối với khách từ 70 tuổi trở lên</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3 bg-f5f5f5">
            <div class=" pl-0 pr-0">
                <a class="p-3 col-12 text-center text-uppercase" data-toggle="collapse" data-target="#Show" aria-expanded="false" aria-controls="true">
                    <p class="h5 mb-0">XEM GIÁ TOUR CƠ BẢN</p>
                </a>
                <div id="Show" class="collapse" aria-labelledby="First">
                    <table class="mb-3 table table-bordered text-left bg-white">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Người lớn</th>
                            <th>Trẻ em</th>
                            <th>Trẻ nhỏ</th>
                        </tr>
                        </thead>
                        <tbody class="text-right">
                        <tr>
                            <td class="text-left">Giá tour cơ bản</td>
                            <td>{{ numbertomoney($startdate->adult_price) }}</td>
                            <td>{{ numbertomoney($startdate->child_price) }}</td>
                            <td>{{ numbertomoney($startdate->baby_price) }}</td>
                        </tr>
                        @foreach($addings as $index=>$adding)
                            <tr>
                                <td class="text-left">{{ $adding->name }} {{ $adding->required==='true'?'(khoản bắt buộc)':'' }}</td>
                                <td colspan="3">{{ numbertomoney($adding->price) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="bg-f5f5f5">
            <div class="p-3 col-12 text-center text-uppercase">
                <p class="h5 mb-0">Số lượng</p>
            </div>
            {!! Form::open(['class' => 'py-3','id' => 'TourResult']) !!}
                <div class="form-row mx-0">
                    <input name="tour_startdate_id" value="{{ $startdate->id }}" type="hidden">
                    <input name="tour_standard" value="{{ $cartItem['standard'] }}" type="hidden">
                    <div class="form-group px-3 col-md-6">
                        <label for="">NGƯỜI LỚN/ <span class="ff5400">{{ numbertomoney($startdate->adult_price) }}</span></label>
                        <input name="tour_adult" type="text" class="form-control rounded-0" value="{{ $cartItem['adult'] }}" onkeyup="TourResult()">
                    </div>
                    <div class="form-group px-3 col-md-6">
                        <label for="">TRẺ EM/ <span class="ff5400">{{ numbertomoney($startdate->child_price) }}</span></label>
                        <input name="tour_child" type="text" class="form-control rounded-0" value="{{ $cartItem['child'] }}" onkeyup="TourResult()">
                    </div>
                    <div class="form-group px-3 col-md-6">
                        <label for="">EM BÉ/ <span class="ff5400">{{ $startdate->baby_price*1===0 ? 'Miễn phí' :numbertomoney($startdate->baby_price) }}</span></label>
                        <input  name="tour_baby"type="text" class="form-control rounded-0" value="{{ $cartItem['baby'] }}" onkeyup="TourResult()">
                    </div>
                    <div class="form-group px-3 col-md-6 position-relative mt-md-auto my-3">
                        <input type="text" class="form-control rounded-0 border-right-0" placeholder="NHẬP MÃ GIẢM GIÁ" style="width:100%" id="PromotionCode">
                        <div class="position-absolute" style="top:0;right:15px">
                            <button type="button" class="btn rounded-0 mb-2 bg-oganre text-white" onclick="CheckPromotionCode(this)">KIỂM TRA</button>
                        </div>
                    </div>
                </div>
                <div class="bg-f5f5f5 py-3 px-sm-2 px-1 " id="tour-result">
                    <table class="table table-bordered bg-white">
                        <thead class="text-center">
                        <tr>
                            <th></th>
                            <th>Bắt buộc</th>
                            <th>Số lượng</th>
                            <th>Giá tiền</th>
                            <th>Tổng cộng</th>
                        </tr>
                        </thead>
                        <tbody class="text-right" id="tbody-result">

                        </tbody>
                    </table>
                </div>
            {!! Form::close() !!}
        </div>
        <div class="my-2">
            <div class="text-center">
                <button type="button" class="btn rounded-0 small bg-f5f5f5 w-100" id="btn-child">QUY ĐỊNH VỀ TRẺ EM</button>
            </div>
            <div class="w-100 bg-f5f5f5 d-md-block pb-2" id="note-child" style="display: none;">
                <p class="text-justify ff5400 px-3">Khách nữ từ 55 tuổi trở lên, khách nam từ 60 tuổi trở lên đi tour một mình và khách mang thai trên 4 tháng (16 tuần) vui lòng đăng ký tour trực tiếp tại văn phòng của HAIDANGTRAVEL. Không áp dụng đăng ký tour online đối với khách từ 70 tuổi trở lên</p>
            </div>
        </div>
        <div class="d-md-none d-block">
            <button type="button" id="btn-info" class="btn my-md-5 my-3 w-100 pl-4 pr-4 text-center text-uppercase bg-oganre rounded-0 text-white">TIẾP TỤC</button>
        </div>
        @if(\Illuminate\Support\Facades\Auth::guest())
        <div class="bg-f5f5f5 d-md-block mb-3" id="note-info" style="display: none;">
            <div class="p-3 col-12 text-center text-uppercase">
                <p class="h5 mb-0">thông tin liên hệ</p>
            </div>
            <div class="tab row mx-0">
                <button class="tablinks col-6  active" onmouseover="openCity(event, 'In')">ĐÃ CÓ TÀI KHOẢN</button>
                <button class="tablinks col-6" onmouseover="openCity(event, 'Out')">CHƯA CÓ TÀI KHOẢN</button>
            </div>
            <div id="In" class="tabcontent mt-3" style="display:block">
                <form method="post" action="{{ asset('login') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="backUrl" value="/booking">
                    <div class="form-row mx-0">
                        <div class="form-group px-3 col-md-6">
                            <label for="regemail">Email / Số điện thoại</label>
                            <input id="regemail" type="text" placeholder="" name="email"
                                   class="form-control rounded-0" value="{{ old('email') }}">
                        </div>
                        <div class="form-group px-3 col-md-6">
                            <label for="regpassword">Mật khẩu</label>
                            <input id="regpassword" type="password" name="password" placeholder="" class="form-control rounded-0">
                        </div>
                    </div>
                    <button type="submit" class="btn my-3 w-100 pl-4 pr-4 text-center text-uppercase bg-oganre rounded-0 text-white">ĐỒNG Ý</button>
                </form>
            </div>
            <div id="Out" class="tabcontent mt-3" >
                <form method="post" class="register" id="register_member" >
                    {{ csrf_field() }}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Lỗi đăng ký</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-row mx-0">
                        <div class="form-group px-3 col-md-6">
                            <label for="regphone">Số điện thoại<span class="small">(Bắt buộc)</span></label>
                            <input id="regphone" type="text" placeholder="" class="form-control rounded-0"
                                   value="{{ old('regphone') }}" name="regphone"
                                   data-validation-error-msg-required="Vui lòng nhập số điện thoại"
                                   data-validation-error-msg-number="Số điện thoại phải là chữ số"
                                   data-validation-error-msg-minlength="Số điện thoại ít nhất 8 ký tự"
                                   data-validation-error-msg-maxlength="Số điện thoại nhiều nhất 12 ký tự"/>
                            <label for="regphone" class="error regphone"></label>
                        </div>
                        <div class="form-group px-3 col-md-6">
                            <label for="">Email</label>
                            <input id="regfullname" type="text" placeholder="" class="form-control rounded-0"
                                   value="{{ old('regfullname') }}" name="regfullname"
                                   data-validation-error-msg-required="Vui lòng nhập họ và tên"
                            />
                            <label for="regfullname" class="error regfullname"></label>
                        </div>
                        <div class="form-group px-3 col-md-6">
                            <label for="">Họ tên</label>
                            <input id="regfullname" type="text" placeholder="" class="form-control rounded-0"
                                   value="{{ old('regfullname') }}" name="regfullname"
                                   data-validation-error-msg-required="Vui lòng nhập họ và tên"
                            />
                            <label for="regfullname" class="error regfullname"></label>
                        </div>
                        <div class="form-group px-3 col-md-6">
                            <label for="">Mật khẩu</label>
                            <input id="password" type="password" placeholder="" class="form-control rounded-0" name="password"
                                   data-validation-error-msg-required="Xin vui lòng đánh password"
                                   data-validation-error-msg-minlength="Password ít nhất 8 chữ số"/>
                            <label for="password" class="error password"></label>
                        </div>
                        <div class="form-group px-3 col-md-12">
                            <label for="">Địa chỉ</label>
                            <input id="regaddress" type="text" placeholder="" class="form-control form-input"
                                   value="{{ old('regaddress') }}" name="regaddress"
                            <label for="regaddress" class="error regaddress"></label>
                        </div>
                    </div>
                    <button type="submit" class="btn my-3 w-100 pl-4 pr-4 text-center text-uppercase bg-oganre rounded-0 text-white">ĐỒNG Ý</button>
                </form>
            </div>
        </div>
        @else
            <button type="button" class="btn my-3 w-100 pl-4 pr-4 text-center text-uppercase bg-oganre rounded-0 text-white" data-toggle="modal" data-target="#ConfigOrderModal">ĐỒNG Ý</button>
        @endif
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
<!-- Modal -->
<div class="modal fade" id="ConfigOrderModal" tabindex="-1" role="dialog" aria-labelledby="ConfigOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Xác nhận đơn hàng !</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Đơn hàng của bạn sẽ được xác nhận ! Chúng tôi sẽ liên hệ bạn sớm nhất khi nhận được xác nhận đơn hàng này !
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="ConfirmOrder()">Xác nhận</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
    <script>
        $(document).ready(function(e){
            TourResult();
        });
    </script>
@stop