@extends('front.staff.template')
@section('styles')
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') !!}
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') !!}
@stop
@section('main')
    <style>
        .checkbox input.amount{
            width: 60px;
        }
        #userselect ul li:hover {
            color : green;
            background-color: #ffffff;
        }
        #userselect ul li{
            cursor: pointer;
        }
        .adult_total , .child_total , .adding_total , .baby_total
        {
            color:blue;
        }
        .total {
            color: red;
        }
    </style>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-sm-6 margin-top">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Thông tin khách hàng
                    </div>
                    <?php
                    if($useredit!=null){
                        $userid = $useredit->id;
                        $username = $useredit->username;
                        $phone = $useredit->phone;
                        $fullname = $useredit->fullname;
                        $email = $useredit->email;
                        $gender = $useredit->gender;
                        $address = $useredit->address;
                        $readonly = 'readonly';
                        $tourid = $order->startdate->tour->id;
                        $btntext = 'Cập nhật';
                    } else {
                        $userid = '';
                        $username ='';
                        $phone ='';
                        $fullname ='';
                        $email='';
                        $gender ='';
                        $address ='';
                        $readonly = ' ';
                        $tourid = '';
                        $btntext = 'Giữ chỗ';
                        if($tour!=null) $tourid = $tour->id;
                    }
                    ?>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        {!! Form::open(['url' => '', 'method' => 'post', 'class' => 'sky-form','id'=>'sky-form4']) !!}
                            <div class="alert alert-danger collapse" id="userselect" >
                                <strong></strong>
                                <ul>

                                </ul>
                            </div>
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
                                @if($useredit==null)
                                    <section>
                                        <label class="input">
                                            <i class="icon-append fa fa-lock"></i>
                                            {!! Form::input('password', 'password', '12345678', ['placeholder' => 'Mật khẩu','id'=>'password']) !!}
                                            <b class="tooltip tooltip-bottom-right">Nhập mật khẩu ( bắt buột )</b>
                                        </label>
                                    </section>
                                    <section>
                                        <label class="input">
                                            <i class="icon-append fa fa-lock"></i>
                                            {!! Form::input('password', 'password_confirmation', '12345678', ['placeholder' => 'Xác nhận mật khẩu','id'=>'password_confirmation']) !!}
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
                            @if($useredit==null)
                        <button type="button" class="btn btn-danger" id="createUser">Ok</button>
                        @endif
                        {!! Form::close() !!}

                        <div class="transport-map">
                            @if($user->id==$order->tourstaff_id||$user->role->slug=='admin')
                            @include('front.staff.partials.transportmap')
                            @endif
                        </div>

                    </div>
                    <!-- .panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-6 -->
            {!! Form::open(['url' => 'function/createOrder', 'method' => 'post','id'=>'createOrderForm']) !!}
            <div class="col-sm-6 margin-top">
                <input type="hidden" value="{!! $order->id !!}" name="id"/>
                <div class="panel panel-default" id="order-information">
                    <input type="hidden" value="{!! $userid !!}" name="user" id="user"/>
                    <div class="panel-heading">
                        Thông tin đơn hàng <div class="print"><a href=""><i class="fa fa-print"></i></a></div>
                    </div>
                    @if(Session::has('createError'))
                        @if (count($errors) > 0 )
                            <div class="alert alert-danger">
                                <strong>Tạo mới Order có lỗi</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @endif

                    @if(Session::has('StatusError'))

                        @if (count($errors) > 0 )
                            <div class="alert alert-danger">
                                <strong>Chỉnh sửa Order có lỗi</strong>
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
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="col-sm-12 nopadding">
                            <div class="form-group">
                                <label>Tên Tour</label>
                                <select name="tour" class="form-control" id="tour">
                                    <option value="">Chọn tour</option>
                                    @foreach($tours as $tourview)
                                    <option value="{!! $tourview->id !!}" {!! $tourid==$tourview->id?'selected':'' !!} >{!! $tourview->title !!}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-lg-12 col-md-12 nopadding tongtien-donhang">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="calculate-table">
                                            <?php
                                                if($order->id!=''){
                                                    $tour = $order->startdate->tour;
                                            } else {
                                                    if($tour==null)
                                                        $tour = null;
                                                }
                                            ?>
                                        @if($tour!=null)
                                        @include('front.user.partials.calculatetable')
                                        @endif
                                        </div>

                                    </div>
                                    <!-- /.col-lg-12 -->
                                </div>
                                <div class="addings-list">
                                    @include('front.staff.partials.addings')
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon">thu cọc :</span>
                                    <input type="text" class="form-control moneymask" placeholder="Nhập thu cọc" name="deposit" value="{!! $order->deposit !!}">
                                </div>
                                <div class="form-group">
                                    <label>Địa chỉ giao nhận</label>
                                    <input type="text" class="form-control" placeholder="Địa chỉ giao nhận" name="address" value="{!! $order->address !!}">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon">Giảm giá giờ vàng :</span>
                                    <input type="text" class="form-control moneymask" placeholder="Nhập giảm giá giờ vàng" name="discountgold" value="{!! $order->discountgold !!}">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon">Giảm giá :</span>
                                    <input type="text" class="form-control moneymask" placeholder="Nhập giảm giá" name="discount" value="{!! $order->discount !!}">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon">Lý do giảm giá</span>
                                    <input type="text" class="form-control" placeholder="Nhập lý do giảm giá" name="discount_reason" value="{!! $order->discount_reason !!}">
                                </div>
                                <?php
                                    $codes = $order->promotion_codes;
                                ?>
                                @if(count($codes)>0)
                                <div class="form-group input-group">
                                    <span class="input-group-addon">List code giảm giờ vàng</span>
                                    <br/>
                                    @foreach($codes as $code)
                                    <span>{!! $code->code !!}</span><br/>
                                    @endforeach
                                </div>
                                @endif
                                <div class="form-group input-group">
                                    <span class="input-group-addon">Cơ cấu phòng</span>
                                    <input type="text" class="form-control" placeholder="Nhập cơ cấu phòng" name="room" value="{!! $order->room !!}">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon">Ghi chú</span>
                                    <input type="text" class="form-control" placeholder="Nhập ghi chú" name="notice" value="{!! $order->notice !!}">
                                </div>
                                @if($order->id !='')
                                    @if($order->tourstaff_id != $order->staff_id)
                                <div class="form-group input-group">
                                    <span class="input-group-addon">Người gửi tour </span>
                                    <input type="text" class="form-control" placeholder="" value="{!! $order->staff->fullname !!}" readonly>
                                </div>
                                    @endif
                                @endif
                                <!-- /.row -->
                            </div><!--tong tien-->
                            <div class="soghe-right">

                                    <div class="form-group">
                                        <label>Quản lý</label>
                                        @if($user->role->slug=='admin')
                                        <select name="staff" class="form-control" id="staff">
                                            <option value="">Chọn người quản lý</option>
                                            @foreach($staffs as $staff)
                                                <option value="{!! $staff->id !!}" {!! $order->staff_id==$staff->id?'selected':'' !!}>{!! $staff->fullname !!}</option>
                                            @endforeach
                                        </select>
                                        @else
                                            @if($order->id!='')
                                            <span>{!! $order->staff->fullname !!}</span>
                                            @endif
                                        @endif
                                    </div>
                                @if($user->role->slug=='admin')
                                    <div class="form-group">
                                        <label>Tình trạng</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" {!! $order->status==1?'selected':'' !!}>Chưa xác nhận</option>
                                            <option value="2" {!! $order->status==2?'selected':'' !!}>Đã xác nhận</option>
                                            <option value="3" {!! $order->status==3?'selected':'' !!}>Hoàn tất</option>
                                            <option value="0" {!! $order->status==0?($order->id==''?'':'selected'):'' !!}>Hủy</option>
                                        </select>
                                    </div>
                                @else
                                    @if($order->id!='')
                                    <div class="form-group">
                                        <label>Tình trạng</label>
                                        <span>{!! getStatusOrder($order->status) !!}</span>
                                    </div>
                                    @endif
                                @endif
                                <button type="submit" class="btn btn-warning" name="giveOrder" value="1" >{!! $btntext!!}</button>
                                @php
                                    $btn_show = false;
                                    if($order->id!='') {
                                        if($user->role->slug=='admin'||$user->id==$order->tourstaff->id){
                                            if($order->id!='') {
                                                $btn_show = true;
                                            }
                                        }
                                    }
                                @endphp

                                <button type="submit" class="btn btn-info" name="confirmOrder" value="1" id="ConfirmOrderBtn">Xác nhận</button>


                                <button type="submit" class="btn btn-danger" name="cancelOrder" value="1" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này ?')">Hủy</button>
                            </div>

                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-6 -->
                </div>
                <!-- /.row -->
            </div>
            {!!  Form::close()  !!}
            
@stop
@section('scripts')
                {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') !!}
                {!! HTML::script('js/bootstrap-datepicker.js') !!}
                {!! HTML::script('js/bootstrap-datepicker.vi.min.js', ['charset'=>'UTF-8']) !!}
                {!! HTML::script('js/jquery.inputmask.min.js') !!}
                {!! HTML::script('js/jquery.inputmask.numeric.extensions.min.js') !!}
                {!! HTML::script('js/staff.js') !!}
                {!! HTML::script('js/form.js') !!}
                {!! HTML::script('js/helper.js') !!}

                @if($order->id != '')
                    <script>
                        var order_addings  =  $.parseJSON('{!! $order->addings !!}');
                    </script>
                @endif
@stop
@section('ready')
        @if($order->id != '')
            window['current_addings'] = $.parseJSON('{!! $order->startdate->addings !!}');
            @php
                $order->startdate->addings = '';
            @endphp
            window['current_startdate'] = $.parseJSON('{!! \GuzzleHttp\json_encode($order->startdate) !!}');
            $('#OrderStartdate').change();
        @endif
            doCalculateCart();
            doCalculateAdding()
            loadInputMask();
@stop