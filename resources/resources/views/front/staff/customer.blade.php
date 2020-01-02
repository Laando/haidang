@extends('front.staff.template')
@section('styles')
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') !!}
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') !!}
    {!! HTML::style('assets/froala/css/froala_editor.css') !!}
    {!! HTML::style('assets/froala/css/froala_style.css') !!}
@stop
@section('main')
    <style>
        .ui-datepicker {
            z-index: 1004!important;
        }
    </style>
    <div id="page-wrapper">
        <div class="row">
            {!! Form::open(['url' => 'staff/customer', 'method' => 'get', 'class' => '']) !!}
            <div class=" col-md-4 panel-heading danhsach-pax">
                <div class="bs-example" data-example-ids="select-form-control">
                    <select class="form-control" name="staff">
                        <option value="">Người quản lý</option>
                        @foreach($staffs as $staff)
                        <option value="{!! $staff->id !!}" {!! \Illuminate\Support\Facades\Input::get('staff')==$staff->id?'selected':'' !!} >{!! $staff->fullname !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class=" col-md-4 panel-heading danhsach-pax">
                <div class="bs-example" data-example-ids="select-form-control">
                    <select class="form-control" name="tour">
                        <option value="">Chọn tour</option>
                        @foreach($tours as $tour)
                            <option value="{!! $tour->id !!}" {!! \Illuminate\Support\Facades\Input::get('tour')==$tour->id?'selected':'' !!}>{!! $tour->title !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class=" col-md-4 panel-heading danhsach-pax">
                <div class="bs-example" data-example-ids="select-form-control">
                    <select class="form-control" name="point">
                        <option value="">Điểm tích lũy</option>
                        @foreach($gifts as $gift)
                            <option value="{!! $gift->point !!}" {!! \Illuminate\Support\Facades\Input::get('point')==$gift->point?'selected':'' !!}>{!! $gift->title.'/'.$gift->point !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class=" col-md-3 input-group panel-heading   pull-left">
                    <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    Từ
                                </button>
                            </span>
                    <input class="form-control" type="text" name="start" id="start" placeholder="Chọn ngày khởi hành bắt đầu" {!! \Illuminate\Support\Facades\Input::get('start')!=null?'value="'.Input::get('start').'"':'' !!}/>
            </div>
            <div class=" col-md-3 input-group panel-heading  pull-left ">
                    <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    đến
                                </button>
                            </span>
                    <input class="form-control" type="text" name="end" id="end" placeholder="Chọn ngày khởi hành kết thúc" {!! \Illuminate\Support\Facades\Input::get('end')!=null?'value="'.Input::get('end').'"':'' !!}>
            </div>
            <div class="col-md-3 panel-heading">
                <div class="bs-example" data-example-ids="select-form-control">
                    <select class="form-control" name="member_card_type">
                        <option value="" {!! \Illuminate\Support\Facades\Input::get('member_card_type')==''?'selected':'' !!} >Tất cả</option>
                        @foreach($select_card_type as $key=>$type)
                            <option value="{!! $key !!}" {!! \Illuminate\Support\Facades\Input::get('member_card_type')===$key.''?'selected':'' !!}>{!! $type !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3 input-group panel-heading  pull-left ">
                <input type="text" class="form-control" placeholder="Điên thoại / Tên / Email / Mã Member" name="string" value="{!! \Illuminate\Support\Facades\Input::get('string')!!}">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
            </div>
            <!-- /input-group -->
            {!! Form::close() !!}
            <div class="clearfix"></div>
            @if(session()->has('ok'))
                @include('partials/error', ['type' => 'success', 'message' => session('ok')])
            @endif
            <div class="col-md-12 panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <div class="panel-heading">
                            Tổng hợp khách hàng
                            <div class="pull-right">

                                <a href=""><i class="fa fa-print"></i></a> |
                                <a data-toggle="modal"
                                   data-target="#sendMailModal"><i class="fa fa-mail-forward"> Gửi mail </i></a>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" value="0" onclick="doCheckAll(this)" />
                                </th>
                                <th>STT</th>
                                <th>Tên</th>
                                <th>
                                    Số Điện Thoại
                                </th>
                                <th>
                                    Mail
                                </th>
                                <th>
                                    Số khách đã đăng ký
                                </th>
                                <th>
                                    Điểm
                                </th>
                                <th>
                                    Restar
                                </th>
                                <th>
                                    Xem hóa đơn
                                </th>
                                <th>Cập nhật</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customers as $index=>$customer)
                            <tr>
                                <th>
                                    <input type="checkbox" value="{!! $customer->id !!}" class="checkbox" data-id="{!! $customer->id !!}">
                                </th>
                                <th>{!!$index+1!!}</th>
                                <th><a onclick="giftHistory({!!$customer->id!!})">{!! $customer->fullname==''?$customer->phone:$customer->fullname !!}</a><br/>MB : {!! $customer->member_card !!}</th>
                                <td>{!! $customer->phone !!}</td>
                                <td>{!! $customer->email !!}</td>
                                <td>{!! $customer->totalseat() !!} khách</td>
                                <td>{!! $customer->point !!} điểm</td>
                                <td>
                                    <a data-id="{!! $customer->id !!}" onclick="selectGift(this)">Chọn Quà</a>
                                </td>
                                <td>
                                    <a onclick="customerOrder({!!$customer->id!!})">SL {!! $customer->orders()->count() !!}</a>
                                </td>
                                <td>
                                    <a href="{!! asset('user/'.$customer->id.'/edit') !!}" ><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.col-lg-12 -->
        <div class="pull-right link">{!! $links !!}</div>
    </div>
    <!-- /.row -->
    </div>
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Chọn quà cho khách hàng </h4>
                </div>
                <div class="modal-body" id="gift-list">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info  reset">Reset</button>
                    <button type="button" class="btn btn-primary" onclick="updateGift(this)">Chọn</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="giftHistory">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Lịch sử nhận quà </h4>
                </div>
                <div class="modal-body" id="gift-history">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="customerOrder">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Lịch sử các hóa đơn</h4>
                </div>
                <div class="modal-body" id="customer-order">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade froala-editor" id="sendMailModal">
        <form>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Nội dung gửi mail !</h4>
                    </div>
                    <div class="modal-body" >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Số người 1 lần gửi (mặc định 50)</label>
                                    <input type="number" min="10" class="form-control" value="50" id="EmailTotal">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Trang gửi (mặc định 1)</label>
                                    <input type="number" min="1" class="form-control" value="1" id="EmailPage">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <textarea name="content" id="EmailContent"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="SendMail(this)">Gửi mail</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </form>
    </div><!-- /.modal -->

    <!-- /#page-wrapper -->
@stop
@section('scripts')
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') !!}
    {!! HTML::script('assets/js/plugins/datepicker.js') !!}
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
        function doCheckAll(node) {
           if($(node).prop('checked')){
               $('.checkbox').prop('checked',true);
           } else {
               $('.checkbox').prop('checked',false);
           }
        }
        function selectGift(node){
            var customerid = [];
            var id = $(node).attr('data-id')*1;
            customerid[customerid.length] = id;
            getGiftList(customerid,node);
        }
        function chooseAction ()
        {
            $('#gift-list').on('keyup','input[name="amount"]',function(){
                $('#gift-list').find('.notice').html('');
                $('#gift-list').find('input[name="amount"]').prop('disabled',true);
                $(this).addClass('active').prop('disabled',false);
                var lessval =$('#gift-list').find('input[name="less"]').val()*1;
                var point = $(this).attr('data-point')*1;
                if(point*$(this).val()>lessval){
                    $('#gift-list').find('.notice').html('Điểm quà lớn hơn tổng điểm ! Vui lòng chọn lại');
                    $('#updateGifft').prop('disabled',true);
                } else {
                    $('#updateGifft').prop('disabled',false);
                }
            });
        }
        function resetModal(){
                $('.modal-footer').on('click', 'button.reset', function () {
                    $('#gift-list').find('.notice').html('');
                    $('#gift-list').find('input[name="amount"]').removeClass('active').prop('disabled', false).val('');
                });
        }
        function updateGift(node)
        {
            var token = _globalObj._token;
            var customerid = [];
            $('#gift-list').find('input[name="customerid"]').each(function(index,element){
                customerid[customerid.length] = $(element).val();
            })
            var amount = $('#gift-list').find('input.active').val();
            var point = $('#gift-list').find('input.active').attr('data-point');
            $.ajax({
                url: 'http://' + window.location.host + '/staff/updateGift',
                type: "POST",
                data: {customerid:customerid,amount:amount,point:point, _token: token},
                success: function (data, textStatus, jqXHR) {
                    if(data=='ok') {
                        window.location.reload();
                    } else {
                        $('#gift-list').find('.notice').html('Có lỗi');
                    }
                }
            });
            $(node).html('<i class="fa fa-spinner fa-pulse"></i>');
        }
        function giftHistory(id)
        {
            var token = _globalObj._token;
            $.ajax({
                url: 'http://' + window.location.host + '/staff/giftHistory',
                type: "POST",
                data: {id:id, _token: token},
                success: function (data, textStatus, jqXHR) {
                    if(data!='fail') {
                        $('#gift-history').html(data);
                        $('#giftHistory').modal('toggle');
                    }
                }
            });
        }
        function customerOrder(id)
        {
            var token = _globalObj._token;
            $.ajax({
                url: 'http://' + window.location.host + '/staff/customerOrder',
                type: "POST",
                data: {id:id, _token: token},
                success: function (data, textStatus, jqXHR) {
                    if(data!='fail') {
                        $('#customer-order').html(data);
                        $('#customerOrder').modal('toggle');
                    }
                }
            });
        }
        function SendMail(button)
        {
            var token = _globalObj._token;
            let $form = $(button).closest('form');
            let content =  $form.find('#EmailContent').val();
            let total =  $form.find('#EmailTotal').val();
            let page =  $form.find('#EmailPage').val();
            $.ajax({
                url: 'http://' + window.location.host + '/staff/SendMail',
                type: "POST",
                data: {content : content ,total :total ,page: page , _token: token},
                success: function (data, textStatus, jqXHR) {
                    if(data!='fail') {
                        $('#customer-order').html(data);
                        $('#customerOrder').modal('toggle');
                    }
                }
            });
        }
        function getGiftList(customerid,node)
        {
            var token = _globalObj._token;
            $.ajax({
                url: 'http://' + window.location.host + '/staff/giftList',
                type: "POST",
                data: {customerid:customerid, _token: token},
                success: function (data, textStatus, jqXHR) {
                    if(data!='fail') {
                        $('#gift-list').html(data);
                        $('#myModal').modal('toggle');
                        $(node).html('Chọn Quà');
                    }
                }
            });
            $(node).html('<i class="fa fa-spinner fa-pulse"></i>');
        }
    </script>

@stop
@section('ready')
    $( "#start" ).datepicker({
    defaultDate: "-1w",
    setDate : "-1w",
    dateFormat:'dd/mm/yy',
    prevText: '<i class="fa fa-angle-left"></i>',
    nextText: '<i class="fa fa-angle-right"></i>',
    onSelect: function( selectedDate ) {
    $( "#end" ).datepicker( "option", "minDate", selectedDate );
    }
    });
    $( "#end" ).datepicker({
    defaultDate: new Date(),
    setDate : "+1w",
    dateFormat:'dd/mm/yy',
    prevText: '<i class="fa fa-angle-left"></i>',
    nextText: '<i class="fa fa-angle-right"></i>',
    onSelect: function( selectedDate ) {
    $( "#start" ).datepicker( "option", "maxDate", selectedDate );
    }
    });
    chooseAction ();
    resetModal();
    jQuery('.froala-editor').on('show.bs.modal', function (e) {
    jQuery(this).find('textarea').froalaEditor({
    toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'color', 'emoticons', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', '-', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', '|', 'quote', 'insertHR', 'undo', 'redo', 'clearFormatting', 'html','selectAll'],
    theme: 'royal',
    imageUploadURL: 'http://' + window.location.host + '/userimage/picture/upload_image.php',
    imageManagerLoadURL: 'http://' + window.location.host + '/userimage/picture/load_images.php',
    imageManagerDeleteURL: 'http://' + window.location.host + '/userimage/picture/delete_image.php',
    height: 300,
    toolbarSticky: false
    }).on('froalaEditor.image.error', function (e, editor, error ,response) {
    console.log(response);
    var obj = JSON.parse(response);
    jQuery('.fr-message').html( obj.error);
    });
    jQuery('a[href="https://froala.com/wysiwyg-editor"]').remove();
    })
    jQuery('.froala-editor').on('hidden.bs.modal', function (e) {
    jQuery(this).find('textarea').froalaEditor('destroy');
    });
@stop