<?php
$user = Auth::user();
?>
@extends('back.template')

@section('main')

    <!-- Entête de page -->
    @include('back.partials.entete', ['title' => trans('back/tours.dashboard'), 'icone' => 'bus', 'fil' => link_to('tour', trans('back/tours.tours')) . ' / ' . trans('back/tours.edit')])
    <div class="col-sm-12">
        {!! Form::model($tour, ['route' => ['tour.update',$tour->id], 'method' => 'patch', 'class' => 'form-horizontal panel' , 'id' => 'editTour','files' => true]) !!}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input id="TourId" type="hidden" name="tour_id" value="{{ $tour->id }}">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="col-md-4 col-xs-12">
                        <label>
                            <input type="radio" name="isOutbound" id="optionsRadios1"
                                   value="0" {!! $tour->isOutbound*1===0?'checked':'' !!}/>
                            Tour trong nước
                        </label>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <label>
                            <input type="radio" name="isOutbound" id="optionsRadios2"
                                   value="1" {!! $tour->isOutbound*1===1?'checked':'' !!}/>
                            Tour nước ngoài
                        </label>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <label>
                            <input type="radio" name="isOutbound" id="optionsRadios2"
                                   value="2" {!! $tour->isOutbound*1===2?'checked':'' !!}/>
                            Tour đoàn
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-body">

                    {!! Form::control('text', 0, 'title', $errors, trans('back/tours.title')) !!}
                    @if($user->role->slug == 'admin')
                        {!! Form::control('text', 0, 'slug', $errors, 'Đường dẫn - để trắng nếu lấy theo tiêu đề') !!}
                    @endif
                    {!! Form::control('text', 0, 'period', $errors, trans('back/tours.period')) !!}
                    {!! Form::control('text', 0, 'traffic', $errors, trans('back/tours.traffic')) !!}
                    <a class="btn btn-primary" data-toggle="collapse" href="#description-textarea" aria-expanded="false"
                       aria-controls="description-textarea">
                        Giới thiệu
                    </a>
                    <a class="btn btn-primary" data-toggle="collapse" href="#reside-textarea" aria-expanded="false"
                       aria-controls="reside-textarea">
                        Tour bao gồm
                    </a>
                    <a class="btn btn-primary" data-toggle="collapse" href="#ticket-textarea" aria-expanded="false"
                       aria-controls="ticket-textarea">
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
                    <a class="btn btn-primary" data-toggle="collapse" href="#childstipulate-textarea"
                       aria-expanded="false" aria-controls="childstipulate-textarea">
                        {!! trans('back/tours.childstipulate') !!}
                    </a>
                    <a class="btn btn-primary" data-toggle="collapse" href="#buycancelstipulate-textarea"
                       aria-expanded="false" aria-controls="bycancelstipulate-textarea">
                        {!! trans('back/tours.buycancelstipulate') !!}
                    </a>
                    <a class="btn btn-primary" data-toggle="collapse" href="#payment-textarea" aria-expanded="false"
                       aria-controls="payment-textarea">
                        {!! trans('back/tours.payment') !!}
                    </a>
                    {{--<a class="btn btn-primary" data-toggle="collapse" href="#insurrance-textarea" aria-expanded="false" aria-controls="insurrance-textarea">
                        {!! trans('back/tours.insurrance') !!}
                    </a>--}}
                    <a class="btn btn-primary" data-toggle="collapse" href="#note-textarea" aria-expanded="false"
                       aria-controls="note-textarea">
                        {!! trans('back/tours.note') !!}
                    </a>
                    <a class="btn btn-primary" data-toggle="collapse" href="#notinclude-textarea" aria-expanded="false"
                       aria-controls="notinclude-textarea">
                        {!! trans('back/tours.notinclude') !!}
                    </a>
                    <a class="btn btn-primary" data-toggle="collapse" href="#takeoff-textarea" aria-expanded="false"
                       aria-controls="takeoff-textarea">
                        {!! trans('back/tours.takeoff') !!}
                    </a>
                    <a class="btn btn-primary" data-toggle="collapse" href="#pricedetail-textarea" aria-expanded="false"
                       aria-controls="takeoff-textarea">
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
                        {!! Form::control('textarea', 0, 'takeoff', $errors, trans('back/tours.takeoff')) !!}
                    </div>
                    <div id="pricedetail-textarea" class="collapse ">
                        {!! Form::control('textarea', 0, 'pricedetail', $errors, 'Giá tour chi tiết') !!}
                    </div>
                    <div class="form-group images">
                        <label for="images" class="control-label">Hình <i class="fa fa-plus fa-2 image add"></i></label>
                        <div class="images-1">
                            {!! Form::file('images[]',array('class'=>'images-1')) !!}<i class="fa fa-close image"
                                                                                        onclick="DeleteImage(this)"></i>
                        </div>
                    </div>

                    @if($tour->images!='')
                        <div class="form-group ">
                            <?php
                            $arrimg = explode(';', trim($tour->images, ';'));

                            ?>
                            @foreach($arrimg as $img)
                                <div class="col-md-4">{!! HTML::image('image/'.$img,'',array('class'=>'img-responsive','data-del'=>$img)) !!}
                                    <i class="fa fa-close fa-2x del-image"></i></div>
                            @endforeach
                        </div>
                    @endif
                    <div class="form-group end-images">
                        <label for="end-images" class="control-label">Hình cuối tour (full đường dẫn)<i
                                    class="fa fa-plus fa-2 end-images add"></i></label>
                        <?php
                        $end_images = array();
                        if ($tour->end_images != '') {
                            $end_images = explode(';', trim($tour->end_images, ';'));
                        }
                        ?>
                        <div class="clearfix"></div>
                        @if(count($end_images)==0)
                            <div class="end-image-input">
                                {!! Form::url('end_images[]','',array('class'=>'form-control')) !!}<i
                                        class="fa fa-close end-image"></i>
                            </div>
                        @endif
                        @foreach($end_images as $img)
                            <div class="end-image-input col-md-4">
                                <div>{!! Form::url('end_images[]',$img , array('class'=>'form-control')) !!}<i
                                            class="fa fa-close end-image"></i></div>
                                <div>{!! HTML::image($img,'',array('class'=>'img-responsive')) !!}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div><!--End panel -->
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Chi tiết nội dung tour
                        </a>
                        <i class="fa fa-plus fa-2 detail add"></i>
                    </h4>
                </div>
                <div class="panel-body" id="detail">
                    @if(count($details)>0)
                        <?php $count = 1;?>
                        @foreach($details as $detail)
                            <div class="detail">
                                <i class="fa fa-close detail-close"></i>
                                <div class="modal-header">Ngày {!!$count !!} </div>
                                {!! Form::control('text', 0, 'day[]', $errors, null,$detail->day,null,trans('back/tours.day')) !!}
                                {!! Form::control('text', 0, 'title-details[]', $errors, null,$detail->title,null,trans('back/tours.title')) !!}
                                {!! Form::control('text', 0, 'images-link[]', $errors, null,$detail->image,null,'Link hình ảnh (full)') !!}
                                {!! Form::control('textarea', 0, 'content-'.$count, $errors, null,$detail->content,null,trans('back/tours.content')) !!}
                            </div>
                            <?php $count++;?>
                        @endforeach
                    @else
                        <div class="detail">
                            <i class="fa fa-close detail-close"></i>
                            <div class="modal-header">Ngày 1</div>
                            {!! Form::control('text', 0, 'day[]', $errors, null,1,null,trans('back/tours.day')) !!}
                            {!! Form::control('text', 0, 'title-details[]', $errors, null,null,null,trans('back/tours.title')) !!}
                            {!! Form::control('text', 0, 'images-link[]', $errors, null,null,null,'Link hình ảnh (full)') !!}
                            {!! Form::control('textarea', 0, 'content-1', $errors, null,null,null,trans('back/tours.content')) !!}
                        </div>
                    @endif
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

        <div class="panel-group col-md-12 col-xs-12 row row-eq-height" id="accordion" role="tablist"
             aria-multiselectable="true">
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Chủ đề tour
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">

                        @foreach($selectsubject as $key=>$value)
                            <?php
                            $str_outbound = 'domestic';
                            //                                if(in_array($key,$outbound_sub)) $str_outbound = 'outbound';
                            if (str_contains($value, ';')) {
                                $tmp_arr = explode(';', $value);
                                $str_outbound = $tmp_arr[1] == 0 ? 'domestic' : $str_outbound;
                                $str_outbound = $tmp_arr[1] == 1 ? 'outbound' : $str_outbound;
                                $str_outbound = $tmp_arr[1] == 2 ? 'group' : $str_outbound;
                                $str_outbound = $tmp_arr[1] == 3 ? 'all' : $str_outbound;
                                $value = $tmp_arr[0];
                            }
                            ?>
                            <div class="col-md-4">
                                <input value="{!!  $key !!}" class="{!!  $str_outbound !!}" type="checkbox"
                                       name="subjecttours[]"
                                @foreach($selectedsubjecttours as $index=>$v)
                                    {{ $v==$key?'checked="checked"':'' }}
                                        @endforeach
                                />
                                {!! $value !!}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="padding-left:0px;padding-right:0px">
                <div class="panel panel-primary col-md-6" style="padding-left: 0px;    padding-right: 0px;">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false"
                               aria-controls="collapseTwo">
                                Điểm khởi hành
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse  in" role="tabpanel"
                         aria-labelledby="headingTwo">
                        <div class="panel-body">
                            {!! Form::selection('sourcepoint', $selectsource, null, 'Chọn điểm khởi hành') !!}
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary col-md-6" style="padding-left: 0px;    padding-right: 0px;">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false"
                               aria-controls="collapseThree">
                                Điểm đến
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse  in" role="tabpanel"
                         aria-labelledby="headingThree">
                        <div class="panel-body">
                            <select name="destinationpoint-list" class="form-control">
                                @foreach($selectdestination as $keyd => $valued)
                                    <option value="{{$keyd}}">{{$valued}}</option>
                                @endforeach
                            </select>
                            {!! Form::button('Thêm', array('class' => 'btn-add-des')) !!}
                            <div class="destination-result">
                                @foreach($selecteddestinationpoints as $key=>$value)
                                    <div class="float-padding-left col-md-4">{!! $value !!}
                                        <i class="fa fa-close destinationpoint"></i>
                                        <input type="hidden" value="{!! $key !!}" name="destinationpoints[]"/>
                                    </div>
                                @endforeach
                            </div>
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
            {{--<div class="sightpoint-result">--}}
            {{--@foreach($selectedsightpoints as $key=>$value)--}}
            {{--<div class="float-padding-left">{!! $value !!}--}}
            {{--<i class="fa fa-close sightpoint"></i>--}}
            {{--<input type="hidden" value="{!! $key !!}" name="sightpoints[]"/>--}}
            {{--</div>--}}
            {{--@endforeach--}}
            {{--</div>--}}
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
            {{--<div class="sightpointticket-result">--}}
            {{--@foreach($selectedsightpointtickets as $key=>$value)--}}
            {{--<div class="float-padding-left">{!! $value !!}--}}
            {{--<i class="fa fa-close sightpointticket"></i>--}}
            {{--<input type="hidden" value="{!! $key !!}" name="sightpointtickets[]"/>--}}
            {{--</div>--}}
            {{--@endforeach--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            <div class="col-md-12" style="padding-left:0px;padding-right:0px">
                <div class="panel panel-primary col-md-6" style="padding-left: 0px;    padding-right: 0px;">
                    <div class="panel-heading" role="tab" id="headingSeven">
                        <h4 class="panel-title">
                            <a class="collapsed" data-toggle="collapse" href="#collapseSeven" aria-expanded="false"
                               aria-controls="collapseSeven">
                                Quản lý & giá
                            </a>
                        </h4>
                    </div>
                    <div id="collapseSeven" class="panel-collapse collapse  in" role="tabpanel"
                         aria-labelledby="headingSeven">
                        <div class="panel-body">
                            @if($user->role->slug=='admin')
                                {!! Form::selection('user', $selectuser, $tour->user_id, 'Người quản lý') !!}
                            @endif
                            Trang chủ <input value="1" type="checkbox"
                                             name="homepage" {!! $tour->homepage==1?'checked="checked"':''!!}'/>
                            {{--{!! Form::control('number', 0, 'price', $errors, null,null,null,trans('back/tours.price')) !!}--}}
                            {{--{!! Form::control('number', 0, 'adultprice', $errors, null,null,null,trans('back/tours.adultprice')) !!}--}}
                            {{--{!! Form::control('number', 0, 'childprice', $errors, null,null,null,'Giá trẻ em') !!}--}}
                            {!! Form::control('text', 0, 'departure', $errors, null,null,null,'Mật độ khởi hành') !!}
                            <div class="form-group ">
                                Đề xuất <input value="1" type="checkbox"
                                               name="suggest" {!! $tour->isSuggest==1?'checked="checked"':''!!}>
                            </div>
                            <div class="form-group ">
                                Trạng thái <input value="1" type="checkbox"
                                                  name="status" {!! $tour->status==1?'checked="checked"':''!!}/>
                            </div>
                            <div class="form-group ">
                                <label for="gender" class="control-label">Ưu tiên</label>
                                {!! Form::select('priority', array('1' => '1', '2' => '2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18'),null,array('class'=>'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary col-md-6" style="padding-left: 0px;    padding-right: 0px;">
                    <div class="panel-heading" role="tab" id="headingEight">
                        <h4 class="panel-title">
                            <a class="collapsed" data-toggle="collapse" href="#collapseEight" aria-expanded="false"
                               aria-controls="collapseEight">
                                Khách sạn & Resort
                            </a>
                        </h4>
                    </div>
                    <div id="collapseEight" class="panel-collapse collapse  in" role="tabpanel"
                         aria-labelledby="headingEight">
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
        </div>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingSix">
                    <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse" href="#collapseSix" aria-expanded="false"
                           aria-controls="collapseSix">
                            Khởi hành
                        </a>
                    </h4>
                </div>
                <div id="collapseSix" class="panel-collapse collapse  in" role="tabpanel" aria-labelledby="headingSix">
                    <div class="panel-body" id="startdate">
                        <?php for ($i = 0; $i < count($errors); $i++) {
                            if ($errors->has('startdate.' . $i)) {
                                echo $errors->first('startdate.' . $i, '<small class="help-block">:message</small>');
                            }
                        }
                        $startdates = $tour->startdates->sortBy(function ($sd, $key) {
                            return \Carbon\Carbon::createFromFormat('Y-m-d' , $sd->startdate)->toArray()['timestamp'];
                        });
                        ?>
                        @if(count($startdates)>0)
                            <?php  $count = 1;?>
                            @foreach($startdates as $startdate)

                                <div class="startdate-group col-md-4" id="startdate_old">
                                    <input type="hidden" name="startdate_id" value="{!! $startdate->id !!}"/>
                                    <a class="btn btn-primary" data-toggle="collapse" href="#oldstartdate-{!!$count !!}"
                                       aria-expanded="false" aria-controls="oldstartdate-{!!$count !!}">
                                        Khởi hành : {!! date_format(date_create($startdate->startdate),'d/m/Y') !!}
                                    </a> <i class="fa fa-plus change-promotion"
                                            data-id="{!! $startdate->id !!}"></i><input type="number"
                                                                                        name="promotioncode"
                                                                                        value="{!! $startdate->promotion_codes()->count() !!}"
                                                                                        style="width: 30px;text-align: right"/>
                                    Đặt
                                    : {!! $startdate->whereHas('promotion_codes',function($q) { $q->where('order_id','is not',null);})->count() !!}
                                    <br/><input class="event-check" type="checkbox" name="event"
                                                value="{!! $startdate->isEvent !!}"
                                                {!! $startdate->isEvent==1?'checked':''   !!} data-id="{!! $startdate->id !!}"/>Event
                                    || Giảm <input class="percent-change" type="number" placeholder="%" name="percebt"
                                                   value="{!! $startdate->percent !!}"
                                                   style="width: 50px;text-align: right"
                                                   data-id="{!! $startdate->id !!}"/>%
                                    <button class="btn btn-success" type="button" data-toggle="modal"
                                            data-target="#StartDateModal" data-id="{{ $startdate->id }}"><i
                                                class="fa icon-wrench">Chi tiết</i></button>
                                    <button class="btn btn-danger" onclick="DeleteStartDate({!! $startdate->id !!})"
                                            type="button">Xóa
                                    </button>
                                </div>
                                <?php $count++;?>
                            @endforeach
                        @endif
                    </div>
                    <button class="btn btn-success" type="button" data-toggle="modal" data-target="#StartDateModal"><i
                                class="fa fa-plus fa-2">Thêm
                            mới</i></button>
                </div>
            </div>
        </div>
        <div class="col-sm-6 text-center">

            {!! Form::submit('Cập nhật') !!}

        </div>

        <hr/>
        @if($user->role->slug=='admin')
            <div class="col-sm-6 text-center">
                <input type="submit" name="Copy" value="Copy" class="btn btn-default"
                       title="Không copy hình và ngày khởi hành"/>
            </div>
        @endif
        {!! Form::close() !!}
        @include('partials.startdatemodal')
    </div>

@stop

@section('scripts')
    {{--{!! HTML::script('ckeditor/ckeditor.js') !!}--}}
    <script>
        //CKEDITOR.config.filebrowserBrowseUrl = '/browse.php';
        // CKEDITOR.editorConfig = function( config )
        // {
        //     config.toolbarGroups = [
        //         {"name":"basicstyles","groups":["basicstyles"]},
        //         {"name":"links","groups":["links"]},
        //         {"name":"paragraph","groups":["list","blocks"]},
        //         {"name":"document","groups":["mode"]},
        //         {"name":"insert","groups":["insert"]},
        //         {"name":"styles","groups":["styles"]},
        //         {"name":"about","groups":["about"]}
        //     ];
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
        // //config['toolbarGroups']= [
        // //    {"name":"basicstyles","groups":["basicstyles"]},
        // //    {"name":"links","groups":["links"]},
        //  //   {"name":"paragraph","groups":["list","blocks"]},
        //  //   {"name":"document","groups":["mode"]},
        //  //   {"name":"insert","groups":["insert"]},
        //  //   {"name":"styles","groups":["styles"]},
        //  //   {"name":"about","groups":["about"]}
        // //];
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
        // CKEDITOR.replace( 'takeoff',config);
        // CKEDITOR.replace( 'pricedetail',config);
        // $('div.detail').each(function(index , element){
        //     CKEDITOR.replace( 'content-'+(index+1),config);
        // });


    </script>
    {!! HTML::script('/assets/summernote/summernote.js') !!}
    {!! HTML::script('js/bootstrap-datepicker.js') !!}
    {!! HTML::script('js/bootstrap-datepicker.vi.min.js', ['charset'=>'UTF-8']) !!}
    {!! HTML::script('js/scripta.js') !!}
    {!! HTML::script('js/form.js') !!}
    {!! HTML::script('js/helper.js') !!}
    {!! HTML::script('js/jquery.inputmask.min.js') !!}
    {!! HTML::script('js/jquery.inputmask.numeric.extensions.min.js') !!}
@stop
@section('styles')
    {!! HTML::style('css/datepicker.css') !!}
    {!! HTML::style('/assets/summernote/summernote.css') !!}
    <style>
        .startdate-group, .startdate.col-md-4 {
            border: 1px solid #6b9aff;
        }

        .startdate_detail {
            display: none;
        }

        #startdateTbody .form-group {
            margin-left: 0px;
            margin-right: 0px;
        }
    </style>
@stop