@extends('front.staff.template')
@section('styles')
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') !!}
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') !!}
@stop
@section('main')
    <div class="content">
        <?php $user = \Auth::user();?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Thông tin khách</h4>
                        </div>
                        <div class="content">
                            <form>
                                <div class="form-group">
                                    <div class="col-md-12" style="padding-left: 6px !important">
                                        <label>Số điện thoại</label>
                                        <input type="text" class="form-control" placeholder="Số điện thoại" id="phone" value="{{Request::get('order_id') ? $order->phone : ''}}" {{Request::get('order_id') ? 'disabled' : ''}} onchange="checkUser('phone')">
                                        <span class="text-danger" id="phoneValidate"></span>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Tên</label>
                                        <input type="text" class="form-control" placeholder="Tên" id="username" value="{{Request::get('order_id') ? $order->customer_name : ''}}" {{Request::get('order_id') ? 'disabled' : ''}}>
                                        <span class="text-danger" id="userValidate"></span>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Mail</label>
                                        <input type="text" class="form-control" placeholder="Mail" value="{{Request::get('order_id') ? $customer->email : ''}}" {{Request::get('order_id') ? 'disabled' : ''}} onchange="checkUser('email')" id="email">
                                        <span class="text-danger" id="emailValidate"></span>
                                    </div>
                                    @if(!Request::get('order_id'))
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Mật khẩu</label>
                                                <input class="form-control" autocomplete="new-password" placeholder="Mật khẩu" id="password" type="password" value="12345678" @if($user->role->slug != 'admin') {{'disabled'}} @endif>
                                            </div>
                                            <span class="text-danger" id="passwordValidate"></span>
                                        </div>
                                    @endif
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Địa chỉ</label>
                                            <input type="text" class="form-control" placeholder="Địa chỉ" id="address" value="{{Request::get('order_id') ? $customer->address : ''}}" {{Request::get('order_id') ? 'disabled' : ''}}>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <label>Giới tính</label>
                                        <select class="selectpicker form-control" id="gender" name="gender" {{Request::get('order_id') ? 'disabled' : ''}}>
                                            <option value="1" {{Request::get('order_id') && $customer->gender == 1 ? 'selected' : ''}}>Nam</option>
                                            <option value="2" {{Request::get('order_id') && $customer->gender == 2 ? 'selected' : ''}}>Nữ</option>
                                            <option value="3" {{Request::get('order_id') && $customer->gender == 3 ? 'selected' : ''}}>Khác</option>
                                        </select>
                                    </div>
                                    @if(!Request::get('order_id'))
                                        <div class="col-md-4" style="margin-top: 25px; margin-left: 20px" id="processCustomerInfo">
                                        </div>
                                    @endif
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--THONGTINDONGHANG-->
                <div class="col-sm-7">
                    <input type="hidden" value="0" name="id">
                    <div class="panel panel-default" id="order-information">
                        <input type="hidden" value="" name="user" id="user">
                        <div class="panel-heading">
                            Thông tin đơn hàng 
                            <div class="print" style="float: right;"><a href=""><i class="fa fa-print"></i></a></div>
                        </div>
                        <!-- /.panel-heading -->
                        @if(!Request::get('order_id') || (Request::get('order_id') && $order->status != 0 && $order->status != 3))
                            <div class="panel-body">
                                <form action="{{Request::get('order_id') ? route('editProcessOrder', ['id' => Request::get('order_id')]) : route('createProcessOrder')}}" method="POST" onsubmit="validateForm();">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="email" id="email_order" value="{{Request::get('order_id') ? $customer->email : ''}}">
                                    <div class="col-sm-12 nopadding">
                                        <div class="form-group">
                                            <label>Tên Tour</label>
                                            <select name="tour" class="form-control" id="tour" {{Request::get('order_id') ? 'disabled' : ''}} onchange="loadTourData();">
                                                @foreach($tours as $tour)
                                                    <option value="{{$tour->id}}" {{Request::get('order_id') && $tour->id == $order->tourstaff_id ? 'selected' : ''}}>{{$tour->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span id="loadTourData"></span>
                                        <span id="loadingAdding"></span>
                                        <div class="form-group">
                                            <select name="status" id="status" class="form-control">
                                                <option value="4" {{Request::get('order_id') && $order->status == 4 ? 'selected' : ''}}>Giữ chổ</option>
                                                <option value="2" {{Request::get('order_id') && $order->status == 2 ? 'selected' : ''}}>Đã cọc</option>
                                                <!-- <option value="3" {{Request::get('order_id') && $order->status == 3 ? 'selected' : ''}}>Hoàn tất</option> -->
                                            </select>
                                        </div>
                                        <button type="submit">Xác nhận</button>
                                        @if(Request::get('order_id'))
                                            <a href="{{route('cancelOrder', ['id' => Request::get('order_id')])}}" style="text-decoration: none"><button type="button" style="float: right;">Huỷ đơn hàng</button></a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="panel-body">
                                <div class="col-sm-12 nopadding">
                                    <?php $start_date = $order->startdate;?>
                                    <div class="form-group">
                                        <label>Tên Tour</label>
                                        <div class="">{{$tour->title}}</div>
                                        <div class="top-giohang clearfix">
                                            <div class="col-md-8">
                                                <span><i class="fa fa-check"></i> Thời gian: <strong>{{$tour->period}}</strong></span><br>
                                                <span><i class="fa fa-check"></i> Phương tiện: <strong>{{$tour->traffic}}</strong></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Khởi hành:</label>
                                        <div class="">{!! date_format(date_create($start_date->startdate),'d/m/Y') !!}</div>
                                    </div>
                                    <div class="form-group">
                                        <label>Trạng thái:</label>
                                        <div class="">{!! getStatusOrder($order->status) !!}</div>
                                    </div>
                                    <div class="form-group">
                                        <label>Giá tiền:</label>
                                        <div class="">{!! number_format($order->price) . ' đ' !!}</div>
                                    </div>
                                    <div class="form-group">
                                        <label>Người lớn:</label>
                                        <div class="">SL {{$order->adult}} = <span class="">{{ number_format($order->adult * $order->price) . ' đ' }}</span></div>
                                    </div>
                                    <?php 
                                        $price = $order->price;
                                        $adding_childs_price = $start_date->adding_childs_price ? json_decode($start_date->adding_childs_price) : '';
                                        $adding_childs = $order->adding_childs ? json_decode($order->adding_childs) : '';

                                        $underTwoAmount = $adding_childs ? $adding_childs->underTwo : 0;
                                        $underTwoPrice = $adding_childs_price ? ($price * $adding_childs_price->underTwo / 100) : 0;

                                        $twoToSixAmount = $adding_childs ? $adding_childs->twoToSix : 0;
                                        $twoToSixPrice = $adding_childs_price ? ($price * $adding_childs_price->twoToSix / 100) : 0;
                                        
                                        $sixToTenAmount = $adding_childs ? $adding_childs->sixToTen : 0;
                                        $sixToTenPrice = $adding_childs_price ? ($price * $adding_childs_price->sixToTen / 100) : 0;
                                        
                                        $seatPriceAmount = $adding_childs ? $adding_childs->seatPrice : 0;
                                        $seatPrice = $adding_childs_price ? $adding_childs_price->seatPrice : 0;

                                        $adding_price = $start_date->adding_price ? json_decode($start_date->adding_price) : '';
                                        $adding_price_amount = $order->adding_price ? json_decode($order->adding_price ) : 0;

                                        $car = $start_date->car_lists && !is_null($order->car_index ) && $order->car_index >= 0 ? json_decode($start_date->car_lists)[$order->car_index] : '';
                                        $order_info = $car && isset($car->order_info->{'order_' . $order->id}) ? $car->order_info->{'order_' . $order->id} : [];
                                        $isBed = 0;
                                        if($car && $car->isBed){
                                            $isBed = 1;
                                        }
                                    ?>
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Phụ Thu</th>
                                                <th>Số lượng</th>
                                                <th>Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Trẻ em dưới 2 tuổi</td>
                                                <td>{{$underTwoAmount}}</td>
                                                <td id="">{{number_format($underTwoAmount * $underTwoPrice) . ' đ'}}</td>
                                            </tr>
                                            <tr>
                                                <td>Trẻ em từ 2 đến 6 tuổi</td>
                                                <td>{{$twoToSixAmount}}</td>
                                                <td id="">{{number_format($twoToSixAmount * $twoToSixPrice) . ' đ'}}</td>
                                            </tr>
                                            <tr>
                                                <td>Trẻ em từ 6 đến 10 tuổi</td>
                                                <td>{{$sixToTenAmount}}</td>
                                                <td id="">{{number_format($sixToTenAmount * $sixToTenPrice) . ' đ'}}</td>
                                            </tr>
                                            <tr>
                                                <td>Ghế ngồi trẻ em</td>
                                                <td>{{$seatPriceAmount}}</td>
                                                <td id="">{{number_format($seatPrice * $seatPriceAmount) . ' đ'}}</td>
                                            </tr>
                                            <tr>
                                                <td>Phụ thu cuối tuần </td>
                                                <td></td>
                                                <td>{{$adding_childs_price && isset($adding_childs_price->weekend) ? number_format($adding_childs_price->weekend) . ' đ' : 0 . ' đ' }}</td>
                                            </tr>
                                            @if($adding_price)
                                                @foreach($adding_price as $index => $adding)
                                                    <?php $amount = $adding_price_amount ? $adding_price_amount[$index] : $adding_price_amount?>
                                                    <tr>
                                                        <td>{{$adding->label}} </td>
                                                        <td>{{$amount}}</td>
                                                        <td>{{number_format($amount * $adding->price) . ' đ'}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="form-group">
                                        <label>Khuyến mãi:</label>
                                        <div class="">{{number_format($order->discount) . ' đ'}}</div>
                                    </div>
                                    <div class="form-group">
                                        <label>Tiền cọc:</label>
                                        <div class="">{{number_format($order->deposit) . ' đ'}}</span></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Tổng còn lại:</label>
                                        <div class="">{{number_format($order->total) . ' đ'}}</span></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Đại lý :</label>
                                        <div class="">{{$order->deal}}</span></div>
                                    </div>
                                    <?php 
                                        $room_lists = $order->room_lists ? json_decode($order->room_lists) : '';
                                        $rooms = '';
                                        if($room_lists){
                                            if($room_lists[0]){
                                                $rooms .= $room_lists[0] . ' P.ĐƠN | ';
                                            }
                                            if($room_lists[1]){
                                                $rooms .= $room_lists[1] . ' P.2 | ';
                                            }
                                            if($room_lists[2]){
                                                $rooms .= $room_lists[2] . ' P.3 | ';
                                            }
                                            if($room_lists[3]){
                                                $rooms .= $room_lists[3] . ' P.4';
                                            }
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label>Danh sách phòng :</label>
                                        <div class="">{{$rooms}}</span></div>
                                    </div>
                                    @if($car)
                                        <?php 
                                            $order_info = isset($car->order_info->{'order_' . $order->id}) ? $car->order_info->{'order_' . $order->id} : [];
                                            $checked = '';
                                            if(count($order_info)){
                                                foreach ($order_info as $index => $value) {
                                                    if($index == count($order_info) - 1){
                                                        $checked .= $value;
                                                    }else{
                                                        $checked .= $value . ', ';
                                                    }
                                                }
                                            }
                                        ?>
                                        <label>Xe {{$order->index + 1}}</label>
                                        <p class="text-success" id="seatChecked">Đơn hàng đã chọn ghế: {{$checked ? $checked : 'Đã hủy'}}</p>
                                    @endif
                                    @if($user->role->slug == 'admin' && $order->status == 0)
                                        <a href="{{route('deleteOrder', ['id' => Request::get('order_id')])}}" style="text-decoration: none"><button type="button" style="float: right;">Xóa đơn hàng</button></a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!--END THONGTINDONHANG-->
            </div>
        </div>
    </div>
@stop
@section('scripts')
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') !!}
    {!! HTML::script('assets/js/plugins/datepicker.js') !!}
    {!! HTML::script('js/jquery.inputmask.min.js') !!}
    {!! HTML::script('js/jquery.inputmask.numeric.extensions.min.js') !!}
    <script type="text/javascript">
        loadTourData();
        calculateTotal();
        function loadTourData(){
            var tour_id = document.getElementById('tour').value;
            if(tour_id){
                $.ajax({
                    type: 'GET',
                    dataType: 'html',
                    url: '/staff/order/ajax-tour?tour_id=' + tour_id + '&order_id=' + '<?php echo(Request::get('order_id'))?>',
                    success: function (response) {
                        $('#loadTourData').html(response);
                        getStarDate(null);
                    }
                });
            }
        }

        function getStarDate(key) {
            var date_id = document.getElementById('startdate').value;
            var tour_id = document.getElementById('tour').value;
            if(date_id){
                $.ajax({
                    type: 'GET',
                    dataType: 'html',
                    url: '/staff/process-order/ajax?date_id=' + date_id + '&order_id=' + '<?php echo(Request::get('order_id'))?>' + '&tour_id=' + tour_id,
                    success: function (response) {
                        $('#loadingAdding').html(response);
                        if(key){
                            $('#adult').val('');
                        }
                        getCarMap();
                    }
                });
            }else{
                $('#loadingAdding').html('');
            }
        }

        function getCarMap(){
            var date_id = document.getElementById('startdate').value;
            var car_index = document.getElementById('car_index').value;
            if(car_index){
                $.ajax({
                    type: 'GET',
                    dataType: 'html',
                    url: '/staff/process-order/ajax?car_index=' + car_index + '&date_id=' + date_id + '&order_id=' + '<?php echo(Request::get('order_id'))?>',
                    success: function (response) {
                        $('#carMap').html(response);
                    }
                });
            }else{
                $('#carMap').html('');
            }
        }

        function checkUser(key){
            if(key == 'email'){
                var data = document.getElementById('email').value
            }
            if(key == 'phone'){
                var data = document.getElementById('phone').value
            }            
            if(data){
                $.ajax({
                    type: 'GET',
                    url: key == 'email' ? '/staff/ajax-email/?email=' + data + '&phone=' : '/staff/ajax-email/?email=' + '&phone=' + data,
                    success: function (response) {
                        var user = response;
                        if( Array.isArray(user) ){
                            $('#username').val('').attr('disabled', false);
                            $('#address').val('').attr('disabled', false);
                            $('#gender').val(1).attr('disabled', false);
                            $('#password').attr('disabled', false);
                            $('#processCustomerInfo').html('<button type="button" class="btn btn-info btn-fill pull-right" onclick="createUser()">Tạo tài khoản</button>')
                            document.getElementById('email_order').value = '';
                        }else{
                            if(key == 'phone'){
                                $('#email').val(user.email).attr('disabled', true);
                            }
                            if(key == 'email'){
                                $('#phone').val(user.phone).attr('disabled', true);
                            }
                            $('#username').val(user.username).attr('disabled', true);
                            $('#address').val(user.address).attr('disabled', true);
                            $('#gender').val(user.gender).attr('disabled', true);
                            $('#password').attr('disabled', true);
                            $('#emailValidate').html('');
                            $('#paswordValidate').html('');
                            $('#userValidate').html('');
                            $('#phoneValidate').html('');
                            $('#processCustomerInfo').html('<button type="button" class="btn btn-info btn-fill pull-right" disabled>Đã tạo tài khoản</button>')
                            document.getElementById('email_order').value = document.getElementById('email').value;
                        }
                    }
                });
            }else{
                $('#username').val('').attr('disabled', false);
                $('#phone').val('').attr('disabled', false);
                $('#email').val('').attr('disabled', false);
                $('#address').val('').attr('disabled', false);
                $('#gender').val(1).attr('disabled', false);
                $('#password').attr('disabled', false);
                $('#processCustomerInfo').html('');
                $('#emailValidate').html('');
                $('#paswordValidate').html('');
                $('#userValidate').html('');
                $('#phoneValidate').html('');
                document.getElementById('email_order').value = '';
            }
        }

        function createUser(){
            var email = document.getElementById('email').value;
            var phone = document.getElementById('phone').value;
            var address = document.getElementById('address').value;
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            var gender = document.getElementById('gender').value;
            if(phone.indexOf(' ') >= 0){
                $('#phoneValidate').html('Số điện thoại không được có khoảng trắng');
            }else{
                $.ajax({
                type: 'GET',
                url: '/staff/ajax-email/?email=' + email + '&phone=' + phone + '&address=' + address + '&username=' + username + '&action=create' + '&password=' + password + '&gender=' + gender,
                success: function (response) {
                    if( !Array.isArray(response) ){
                        var error = response;
                        for(var i in error){
                            $('#' + i).html(error[i]);
                        }
                        document.getElementById('email_order').value = '';
                    }else{
                        $('#emailValidate').html('');
                        $('#passwordValidate').html('');
                        $('#userValidate').html('');
                        $('#phoneValidate').html('');
                        $('#processCustomerInfo').html('');
                        alert('Tạo tài khoản thành công');
                        document.getElementById('email_order').value = document.getElementById('email').value;
                    }
                }
                });
            }
        }

        function validateForm(){
            var email_order = $('#email_order').val();
            // if(!email_order){
            //     alert('Tạo thông tin khách hàng trước khi xác nhận')
            //     event.preventDefault(); 
            //     return false;
            // }
            var startdate = $('#startdate').val();
            if(!startdate){
                alert('Không có ngày khởi hành')
                event.preventDefault(); 
                return false;
            }
            return true
        }
    </script>
@stop