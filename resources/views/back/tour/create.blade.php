<?php
$user = Auth::user();
?>
@extends('back.template')

@section('main')

 <!-- Entête de page -->
  @include('back.partials.entete', ['title' => trans('back/tours.dashboard'), 'icone' => 'bus', 'fil' => link_to('tour', trans('back/tours.tours')) . ' / ' . trans('back/tours.creation')])
 @if (count($errors) > 0)
     <div class="alert alert-danger">
         <strong>Đăng ký của bạn có lỗi</strong>
         <ul>
             @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
             @endforeach
         </ul>
     </div>
 @endif
 <div class="col-sm-12">
		{!! Form::open(['url' => 'tour', 'method' => 'post', 'class' => 'form-horizontal panel','files' => true]) !!}
             <div class="col-md-12">
                 <div class="panel panel-primary">
                     <div class="panel-body">
                         <div class="col-md-4 col-xs-12">
                             <label>
                                 <input type="radio" name="isOutbound" id="optionsRadios1" value="0"  checked/>
                                 Tour trong nước
                             </label>
                         </div>
                         <div class="col-md-4 col-xs-12">
                             <label>
                                 <input type="radio" name="isOutbound" id="optionsRadios2" value="1" />
                                 Tour nước ngoài
                             </label>
                         </div>
                         <div class="col-md-4 col-xs-12">
                             <label>
                                 <input type="radio" name="isOutbound" id="optionsRadios3" value="2" />
                                 Tour đoàn
                             </label>
                         </div>
                     </div>
                 </div>
             </div>
            <div class="col-md-8 col-xs-12">
                <div class="panel panel-primary">
                <div class="panel-body">

                    {!! Form::control('text', 0, 'title', $errors, trans('back/tours.title')) !!}
                    @if($user->role->slug == 'admin')
                        {!! Form::control('text', 0, 'slug', $errors, 'Đường dẫn - để trắng nếu lấy theo tiêu đề') !!}
                    @endif
                    {!! Form::control('text', 0, 'period', $errors, trans('back/tours.period')) !!}
                    {!! Form::control('text', 0, 'traffic', $errors, trans('back/tours.traffic')) !!}
                    <a class="btn btn-primary" data-toggle="collapse" href="#description-textarea" aria-expanded="false" aria-controls="description-textarea">
                        Giới thiệu
                    </a>
                    <a class="btn btn-primary" data-toggle="collapse" href="#reside-textarea" aria-expanded="false" aria-controls="reside-textarea">
                        Tour bao gồm
                    </a>
                    <a class="btn btn-primary" data-toggle="collapse" href="#ticket-textarea" aria-expanded="false" aria-controls="ticket-textarea">
                        Điểm nổi bật
                    </a>
                    {{--<a class="btn btn-primary" data-toggle="collapse" href="#meal-textarea" aria-expanded="false" aria-controls="meal-textarea">
                        {!! trans('back/tours.meal') !!}
                    </a>
                    <a class="btn btn-primary" data-toggle="collapse" href="#basething-textarea" aria-expanded="false" aria-controls="basething-textarea">
                        {!! trans('back/tours.basething') !!}
                    </a>
                    <a class="btn btn-primary" data-toggle="collapse" href="#traffic-textarea" aria-expanded="false" aria-controls="traffic-textarea">
                        {!! trans('back/tours.traffic') !!}
                    </a>
                    <a class="btn btn-primary" data-toggle="collapse" href="#guide-textarea" aria-expanded="false" aria-controls="guide-textarea">
                        {!! trans('back/tours.guide') !!}
                    </a>
                    <a class="btn btn-primary" data-toggle="collapse" href="#galastage-textarea" aria-expanded="false" aria-controls="galastage-textarea">
                        {!! trans('back/tours.galastage') !!}
                    </a>--}}
                    <a class="btn btn-primary" data-toggle="collapse" href="#childstipulate-textarea" aria-expanded="false" aria-controls="childstipulate-textarea">
                        {!! trans('back/tours.childstipulate') !!}
                    </a>
                    <a class="btn btn-primary" data-toggle="collapse" href="#buycancelstipulate-textarea" aria-expanded="false" aria-controls="bycancelstipulate-textarea">
                        {!! trans('back/tours.buycancelstipulate') !!}
                    </a>
                    <a class="btn btn-primary" data-toggle="collapse" href="#payment-textarea" aria-expanded="false" aria-controls="payment-textarea">
                        {!! trans('back/tours.payment') !!}
                    </a>
                    {{--<a class="btn btn-primary" data-toggle="collapse" href="#insurrance-textarea" aria-expanded="false" aria-controls="insurrance-textarea">
                        {!! trans('back/tours.insurrance') !!}
                    </a>--}}
                    <a class="btn btn-primary" data-toggle="collapse" href="#note-textarea" aria-expanded="false" aria-controls="note-textarea">
                        {!! trans('back/tours.note') !!}
                    </a>
                    <a class="btn btn-primary" data-toggle="collapse" href="#notinclude-textarea" aria-expanded="false" aria-controls="notinclude-textarea">
                        {!! trans('back/tours.notinclude') !!}
                    </a>
                    <a class="btn btn-primary" data-toggle="collapse" href="#takeoff-textarea" aria-expanded="false" aria-controls="takeoff-textarea">
                        {!! trans('back/tours.takeoff') !!}
                    </a>
                    <a class="btn btn-primary" data-toggle="collapse" href="#pricedetail-textarea" aria-expanded="false" aria-controls="takeoff-textarea">
                        {!! 'Giá tour chi tiết' !!}
                    </a>
                    <div id="description-textarea" class="collapse ">
                    {!! Form::control('textarea', 0, 'description', $errors, trans('back/tours.description')) !!}
                    </div>
                    <div id="reside-textarea" class="collapse ">
                    {!! Form::control('textarea', 0, 'reside', $errors, 'Tour bao gồm') !!}
                    </div>
                    <div id="ticket-textarea" class="collapse ">
                        {!! Form::control('textarea', 0, 'ticket', $errors, 'Điểm nổi bật') !!}
                    </div>
                        <div id="meal-textarea" class="collapse ">
                    {!! Form::control('textarea', 0, 'meal', $errors, trans('back/tours.meal')) !!}
                        </div>
                            <div id="basething-textarea" class="collapse ">
                    {!! Form::control('textarea', 0, 'basething', $errors, trans('back/tours.basething')) !!}
                            </div>
                                <div id="traffic-textarea" class="collapse ">
                    {!! Form::control('textarea', 0, 'notetraffic', $errors, trans('back/tours.notetraffic')) !!}
                                </div>
                                    <div id="guide-textarea" class="collapse ">
                    {!! Form::control('textarea', 0, 'guide', $errors, trans('back/tours.guide')) !!}
                                    </div>
                                        <div id="galastage-textarea" class="collapse ">
                    {!! Form::control('textarea', 0, 'galastage', $errors, trans('back/tours.galastage')) !!}
                                        </div>
                                            <div id="childstipulate-textarea" class="collapse ">
                    {!! Form::control('textarea', 0, 'childstipulate', $errors, trans('back/tours.childstipulate')) !!}
                                            </div>
                                                <div id="buycancelstipulate-textarea" class="collapse ">
                    {!! Form::control('textarea', 0, 'buycancelstipulate', $errors, trans('back/tours.buycancelstipulate')) !!}
                                                </div>
                                                    <div id="note-textarea" class="collapse ">
                    {!! Form::control('textarea', 0, 'note', $errors, trans('back/tours.note')) !!}
                                                    </div>
                                                        <div id="payment-textarea" class="collapse ">
                    {!! Form::control('textarea', 0, 'payment', $errors, trans('back/tours.payment')) !!}
                                                        </div>
                    <div id="insurrance-textarea" class="collapse ">
                    {!! Form::control('textarea', 0, 'insurrance', $errors, trans('back/tours.insurrance')) !!}
                                                        </div>
                    <div id="notinclude-textarea" class="collapse ">
                        {!! Form::control('textarea', 0, 'notinclude', $errors, trans('back/tours.notinclude')) !!}
                    </div>
                    <div id="takeoff-textarea" class="collapse ">
                        <?php
                            $defaulttakeoff = 'QUÝ KHÁCH ĐI TOUR KHỞI HÀNH BẰNG Ô TÔ VỚI NHỮNG ĐIỂM ĐÓN SAU :<br>
                    <i class="fa fa-exchange"></i> Đón khách tại Công ty Du lịch Hải Đăng, 225 Bàu Cát, P12, Quận Tân Bình<br>
                    <i class="fa fa-exchange"></i> Đón khách tại Nhà Văn Hóa Thanh Niên, 04 Phạm Ngọc Thạch, Quận 1<br>
                    <i class="fa fa-exchange"></i> Đón khách tại Cây xăng Comeco, Ngã 4 Hàng Xanh, Quận Bình Thạnh<br>
                    <i class="fa fa-exchange"></i> Đón khách tại Ngã 4 Thủ Đức, Quận 9<br>
                    <i class="fa fa-exchange"></i> Đón khách tại Siêu thị Lotte Mart, Ngã 4 Amata, Biên Hòa, Đồng Nai<br>
                    QUÝ KHÁCH ĐI TOUR TUYẾN MIỀN TÂY NHỮNG ĐIỂM ĐÓN SAU :<br>
                    <i class="fa fa-exchange"></i> Đón khách tại Công viên Bàu Cát, 141 Đồng Đen, P11, Quận Tân Bình <br>
                    <i class="fa fa-exchange"></i> Đón khách tại Nhà Văn Hóa Thanh Niên, 04 Phạm Ngọc Thạch, Quận 1<br>
                    <i class="fa fa-exchange"></i> Bến xe miền tây , Q 6 ( bệnh viện Triều An )<br>
                    QUÝ KHÁCH ĐI TOUR KHỞI HÀNH BẰNG MÁY BAY VỚI NHỮNG ĐIỂM ĐÓN SAU :<br>
                    <i class="fa fa-exchange"></i> Quý khách vui lòng tập trung tại nhà ga đối với những khách đi tour khởi hành bằng tàu<br>
                    <i class="fa fa-exchange"></i> Quý khách vui lòng tập trung tại sân bay hoặc các phòng chờ của các hãng bay đối với những khách đi tour khởi hành bằng máy bay<br>';
                        ?>
                        {!! Form::control('textarea', 0, 'takeoff', $errors, trans('back/tours.takeoff'),$defaulttakeoff) !!}
                    </div>
                    <div id="pricedetail-textarea" class="collapse ">
                        {!! Form::control('textarea', 0, 'pricedetail', $errors, 'Giá tour chi tiết') !!}
                    </div>
                    <div class="form-group images">
                        <label for="images" class="control-label">Hình <i class="fa fa-plus fa-2 image add"></i></label>
                        <div class="images-1">
                            {!! Form::file('images-1',array('class'=>'images-1')) !!}<i class="fa fa-close image" onclick="DeleteImage(this)"></i>
                        </div>
                    </div>
                    <div class="form-group end-images">
                        <label for="end-images" class="control-label">Hình cuối tour (full đường dẫn)<i class="fa fa-plus fa-2 end-images add"></i></label>
                        <div class="end-image-input">
                            {!! Form::url('end_images[]','',array('class'=>'form-control')) !!}<i class="fa fa-close end-image" ></i>
                        </div>
                    </div>
                </div>
                </div><!--End panel -->
                <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a data-toggle="collapse"  href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Chi tiết nội dung tour
                            </a>
                            <i class="fa fa-plus fa-2 detail add"></i>
                        </h4>
                    </div>
                    <div class="panel-body" id="detail">
                        <div class="detail">
                            <i class="fa fa-close detail-close"></i>
                            <div class="modal-header">Ngày 1 </div>
                            {!! Form::control('text', 0, 'day[]', $errors, null,1,null,trans('back/tours.day')) !!}
                            {!! Form::control('text', 0, 'title-details[]', $errors, null,null,null,trans('back/tours.title')) !!}
                            {!! Form::control('text', 0, 'images-link[]', $errors, null,null,null,'Link hình ảnh (full)') !!}
                            {!! Form::control('textarea', 0, 'content-1', $errors, null,null,null,trans('back/tours.content')) !!}
                        </div>
                    </div>
                </div><!--End panel -->
                <div class="panel panel-primary">
                    <div class="panel-body">
                            {!! Form::control('text', 0, 'seokeyword', $errors, trans('back/tours.seokeyword')) !!}
                            {!! Form::control('text', 0, 'seodescription', $errors, trans('back/tours.seodescription')) !!}
                            {!! Form::control('text', 0, 'seotitle', $errors, trans('back/tours.seotitle')) !!}
                    </div>
                </div><!--End panel -->
            </div>

        <div class="panel-group col-md-4 col-xs-12" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a data-toggle="collapse"  href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Chủ đề tour
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">

                        @foreach($selectsubject as $key=>$value)
                            <?php
                            $str_outbound  = 'all';
                            if(str_contains($value,';')){
                                $tmp_arr = explode(';',$value);
                                $str_outbound = $tmp_arr[1] == 0 ? 'domestic' : $str_outbound;
                                $str_outbound = $tmp_arr[1] == 1 ? 'outbound' : $str_outbound;
                                $str_outbound = $tmp_arr[1] == 2 ? 'group' : $str_outbound;
                                $str_outbound = $tmp_arr[1] == 3 ? 'all' : $str_outbound;
                                $value = $tmp_arr[0];
                            }
                            ?>
                            <div class="col-md-12">
                                    <input value="{!!  $key !!}" class="{!!  $str_outbound !!}" type="checkbox" name="subjecttours[]">
                                    {!! $value !!}
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse"  href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Điểm khởi hành
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse  in" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        {!! Form::selection('sourcepoint', $selectsource, null, 'Chọn điểm khởi hành') !!}
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse"  href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Điểm đến
                        </a>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse  in" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        <select name="destinationpoint-list">
                            @foreach($selectdestination as $keyd => $valued)
                                <option value="{{$keyd}}">{{$valued}}</option>
                            @endforeach
                        </select>
                        {!! Form::button('Thêm', array('class' => 'btn-add-des')) !!}
                        <div class="destination-result">

                        </div>
                    </div>
                </div>
            </div>
            {{--<div class="panel panel-primary">--}}
                {{--<div class="panel-heading" role="tab" id="headingFour">--}}
                    {{--<h4 class="panel-title">--}}
                        {{--<a class="collapsed" data-toggle="collapse"  href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">--}}
                            {{--Điểm tham quan--}}
                        {{--</a>--}}
                    {{--</h4>--}}
                {{--</div>--}}
                {{--<div id="collapseFour" class="panel-collapse collapse  in" role="tabpanel" aria-labelledby="headingFour">--}}
                    {{--<div class="panel-body">--}}

                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="panel panel-primary">--}}
                {{--<div class="panel-heading" role="tab" id="headingFive">--}}
                    {{--<h4 class="panel-title">--}}
                        {{--<a class="collapsed" data-toggle="collapse"  href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">--}}
                            {{--Vé điểm tham quan--}}
                        {{--</a>--}}
                    {{--</h4>--}}
                {{--</div>--}}
                {{--<div id="collapseFive" class="panel-collapse collapse  in" role="tabpanel" aria-labelledby="headingFive">--}}
                    {{--<div class="panel-body">--}}

                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingSix">
                    <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse"  href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            Khởi hành
                        </a>
                        <i class="fa fa-plus fa-2 startdate add"></i>
                    </h4>
                </div>
                <div id="collapseSix" class="panel-collapse collapse  in" role="tabpanel" aria-labelledby="headingSix">
                    <div class="panel-body" id="startdate">
                        <?php for($i = 0; $i<count($errors);$i++)
                        {
                            if($errors->has('startdate.'.$i)){
                                echo $errors->first('startdate.'.$i, '<small class="help-block">:message</small>');
                            }
                        }
                        ?>
                        <div class="startdate">
                            <i class="fa fa-close startdate-close"></i>
                            <div class="modal-header">Khởi hành 1 </div>
                            <div class="form-group">
                                {!! Form::text('startdate[]','',array('class'=>'form-control datepicker','placeholder'=>trans('back/tours.startdate'))) !!}
                            </div>
                            {!! Form::control('text', 0, 'traffic-startdate[]', $errors, null,null,null,trans('back/tours.traffic')) !!}
                            {!! Form::control('text', 0, 'seat[]', $errors, null,null,null,trans('back/tours.seat')) !!}
                            {!! Form::control('text', 0, 'adding[]', $errors, null,null,null,trans('back/tours.adding')) !!}
                            {!! Form::control('text', 0, 'price_sd[]', $errors, null,null,null,'Giá ngày khởi hành') !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingSeven">
                    <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse"  href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                            Quản lý & giá
                        </a>
                    </h4>
                </div>
                <div id="collapseSeven" class="panel-collapse collapse  in" role="tabpanel" aria-labelledby="headingSeven">
                    <div class="panel-body">
                        @if($user->role->slug=='admin')
                        {!! Form::selection('user', $selectuser, null, 'Người quản lý') !!}
                        @endif
                        Trang chủ <input value="1" type="checkbox" name="homepage" checked="checked">
                        {{--{!! Form::control('number', 0, 'price', $errors, null,null,null,trans('back/tours.price')) !!}--}}
                        {{--{!! Form::control('number', 0, 'adultprice', $errors, null,null,null,trans('back/tours.adultprice')) !!}--}}
                        {{--{!! Form::control('number', 0, 'childprice', $errors, null,null,null,'Giá trẻ em') !!}--}}
                        {!! Form::control('text', 0, 'departure', $errors, null,null,null,'Mật độ khởi hành') !!}
                        <div class="form-group ">
                        Đề xuất <input value="1" type="checkbox" name="suggest">
                        </div>
                        <div class="form-group ">
                        Trạng thái <input value="1" type="checkbox" name="status" checked="checked">
                        </div>
                        <div class="form-group ">
                            <label for="gender" class="control-label">Ưu tiên</label>
                            {!! Form::select('priority', array('1' => '1', '2' => '2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18'),null,array('class'=>'form-control')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingEight">
                    <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse"  href="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                            Khách sạn & Resort
                        </a>
                    </h4>
                </div>
                <div id="collapseEight" class="panel-collapse collapse  in" role="tabpanel" aria-labelledby="headingEight">
                    <div class="panel-body">
                        {{--{!! Form::control('text', 0, 'star0', $errors, null,null,null,trans('back/tours.0star')) !!}--}}
                        {{--{!! Form::control('text', 0, 'star1', $errors, null,null,null,trans('back/tours.1star')) !!}--}}
                        {{--{!! Form::control('text', 0, 'star2', $errors, null,null,null,trans('back/tours.2star')) !!}--}}
                        {{--{!! Form::control('text', 0, 'star3', $errors, null,null,null,trans('back/tours.3star')) !!}--}}
                        {{--{!! Form::control('text', 0, 'star4', $errors, null,null,null,trans('back/tours.4star')) !!}--}}
                        {{--{!! Form::control('text', 0, 'star5', $errors, null,null,null,trans('back/tours.5star')) !!}--}}
                        {{--{!! Form::control('text', 0, 'rs2', $errors, null,null,null,trans('back/tours.rs2')) !!}--}}
                        {{--{!! Form::control('text', 0, 'rs3', $errors, null,null,null,trans('back/tours.rs3')) !!}--}}
                        {{--{!! Form::control('text', 0, 'rs4', $errors, null,null,null,trans('back/tours.rs4')) !!}--}}
                        {{--{!! Form::control('text', 0, 'rs5', $errors, null,null,null,trans('back/tours.rs5')) !!}--}}
                        <div class="form-group ">
                            <label for="gender" class="control-label">Sao khách sạn</label>
                            {!! Form::select('starhotel', array('0' => 'Nhà nghỉ','1' => '1','2' => '2','3'=>'3','4'=>'4','5'=>'5'),null,array('class'=>'form-control')) !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>



            <div class="col-sm-12">

			{!! Form::submit('Tạo mới') !!}
            </div>
		{!! Form::close() !!}
	</div>

@stop

@section('scripts')
    {{--{!! HTML::script('ckeditor/ckeditor.js') !!}--}}
    <script>
        //CKEDITOR.config.filebrowserBrowseUrl = '/browse.php';
        // CKEDITOR.editorConfig = function( config )
        // {
        //     config.toolbar = "Full";
        // };
        // var config = {
        //     codeSnippet_theme: 'Monokai',
        //     height: 100,
        //     filebrowserBrowseUrl: '/filemanager/index.html'
        //
        //     // Remove the redundant buttons from toolbar groups defined above.
        // };
        // CKEDITOR.replace( 'description',config);
        // CKEDITOR.replace( 'reside',config);
        // CKEDITOR.replace( 'meal',config);
        // CKEDITOR.replace( 'basething',config);
        // CKEDITOR.replace( 'notetraffic',config);
        // CKEDITOR.replace( 'guide',config);
        // CKEDITOR.replace( 'galastage',config);
        // CKEDITOR.replace( 'childstipulate',config);
        // CKEDITOR.replace( 'buycancelstipulate',config);
        // CKEDITOR.replace( 'note',config);
        // CKEDITOR.replace( 'payment',config);
        // CKEDITOR.replace( 'insurrance',config);
        // CKEDITOR.replace( 'content-1',config);
        // CKEDITOR.replace( 'takeoff',config);
        // CKEDITOR.replace( 'pricedetail',config);
    </script>
    {!! HTML::script('/assets/summernote/summernote.js') !!}
    {!! HTML::script('js/bootstrap-datepicker.js') !!}
    {!! HTML::script('js/scripta.js') !!}
@stop
@section('styles')
    {!! HTML::style('css/datepicker.css') !!}
    {!! HTML::style('/assets/summernote/summernote.css') !!}
@stop