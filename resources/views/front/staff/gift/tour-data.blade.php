<div class="col-lg-12 col-md-12 nopadding tongtien-donhang">
    <div class="row">
        <div class="col-lg-12">
            <div class="calculate-table">
                <div class="gia-lichkhoihanh-tour">
                    <div class="top-giohang clearfix">
                        <div class="col-md-8">
                            <span><i class="fa fa-check"></i> Thời gian: <strong>{{$tour->period}}</strong></span><br>
                            <span><i class="fa fa-check"></i> Phương tiện: <strong>{{$tour->traffic}}</strong></span>
                        </div>
                    </div>
                    <hr>
                    <div class="row nopadding sky-form check-khoihanh">
                        <div class="col-md-3">Khởi Hành</div>
                        <div class="col-md-5">
                            <fieldset>
                                <section name="startdate">
                                    <label class="select state-success">
                                        <select onchange="getStarDate(1)" name="startdate" id="startdate" required="">
                                            @foreach($tour->activeDates as $date)
                                                <option value="{{$date->id}}" {{Request::get('order_id') && $order->startdate_id == $date->id ? 'selected' : ''}}>{{date_format(date_create($date->startdate),'d/m/Y')}}</option>
                                            @endforeach
                                        </select>
                                        <i></i>
                                    </label>
                                </section>
                            </fieldset>
                        </div>
                        <div class="col-md-4 text-right" id="price"></div>
                    </div>
                    <div class="row " aria-expanded="true" style="">
                        <div class="checkyear clearfix">
                            <div class="col-md-3">Tiêu chuẩn</div>
                            <div class="col-md-3">
                                <fieldset>
                                    <section>
                                        <label class="select">
                                            <select class="" name="book_standard" id="book_standard" onchange="changeStandard()">
                                                @if($tour->star0!=0 && $tour->star0!='')
                                                    <option value="{!! $tour->star0 !!}" {!! old('starhotel')==$tour->star0?'selected':'' !!} {!! old('starhotel')==null?'selected':'' !!} {{Request::get('order_id') && $tour->star0 == $order->price ? 'selected' : '' }}> Nhà nghỉ - {!! number_format($tour->star0) . ' đ' !!}</option>
                                                @endif
                                                @if($tour->star1!=0 && $tour->star1!='')
                                                    <option value="{!! $tour->star1 !!}" {!! old('starhotel')==$tour->star1?'selected':'' !!} {!! old('starhotel')==null?'selected':'' !!} {{Request::get('order_id') && $tour->star1 == $order->price ? 'selected' : '' }}> KS 1 Sao - {!! number_format($tour->star1) . ' đ' !!}</option>
                                                @endif
                                                @if($tour->star2!=0 && $tour->star2!='')
                                                    <option value="{!! $tour->star2 !!}" {!! old('starhotel')==$tour->star2?'selected':'' !!} {!! old('starhotel')==null?'selected':'' !!} {{Request::get('order_id') && $tour->star2 == $order->price ? 'selected' : '' }}> KS 2 Sao - {!! number_format($tour->star2) . ' đ' !!}</option>
                                                @endif
                                                @if($tour->star3!=0 && $tour->star3!='')
                                                    <option value="{!! $tour->star3 !!}" {!! old('starhotel')==$tour->star3?'selected':'' !!} {{Request::get('order_id') && $tour->star3 == $order->price ? 'selected' : '' }}> KS 3 Sao - {!! number_format($tour->star3) . ' đ' !!}</option>
                                                @endif
                                                @if($tour->star4!=0 && $tour->star4!='')
                                                    <option value="{!! $tour->star4 !!}" {!! old('starhotel')==$tour->star4?'selected':'' !!} {{Request::get('order_id') && $tour->star4 == $order->price ? 'selected' : '' }}> KS 4 Sao - {!! number_format($tour->star4) . ' đ' !!}</option>
                                                @endif
                                                @if($tour->star5!=0 && $tour->star5!='')
                                                    <option value="{!! $tour->star5 !!}" {!! old('starhotel')==$tour->star5?'selected':'' !!} {{Request::get('order_id') && $tour->star5 == $order->price ? 'selected' : '' }}> KS 5 Sao - {!! number_format($tour->star5) . ' đ' !!}</option>
                                                @endif
                                                @if($tour->rs2!=0 && $tour->rs2!='')
                                                    <option value="{!! $tour->rs2 !!}" {!! old('starhotel')==$tour->rs2?'selected':'' !!} {{Request::get('order_id') && $tour->rs2 == $order->price ? 'selected' : '' }}> RS 2 Sao - {!! number_format($tour->rs2) . ' đ' !!}</option>
                                                @endif
                                                @if($tour->rs3!=0 && $tour->rs3!='')
                                                    <option value="{!! $tour->rs3 !!}" {!! old('starhotel')==$tour->rs3?'selected':'' !!} {{Request::get('order_id') && $tour->rs3 == $order->price ? 'selected' : '' }}> RS 3 Sao - {!! number_format($tour->rs3) . ' đ' !!}</option>
                                                @endif
                                                @if($tour->rs4!=0 && $tour->rs4!='')
                                                    <option value="{!! $tour->rs4 !!}" {!! old('starhotel')==$tour->rs4?'selected':'' !!} {{Request::get('order_id') && $tour->rs4 == $order->price ? 'selected' : '' }}> RS 4 Sao - {!! number_format($tour->rs4) . ' đ' !!}</option>
                                                @endif
                                                @if($tour->rs5!=0 && $tour->rs5!='')
                                                    <option value="{!! $tour->rs5 !!}" {!! old('starhotel')==$tour->rs5?'selected':'' !!} {{Request::get('order_id') && $tour->rs5 == $order->price ? 'selected' : '' }}> RS 5 Sao - {!! number_format($tour->rs5) . ' đ' !!}</option>
                                                @endif
                                            </select>
                                        </label>
                                    </section>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="row sky-form">
                        <div class="col-md-3">Người lớn</div>
                        <div class="col-md-5">
                            <fieldset>
                                <section name="startdate">
                                    <label class="input">
                                        <input type="number" name="adult" id="adult" placeholder="Số người lớn" min="1" value="{{Request::get('order_id') ? $order->adult : ''}}" required onkeydown="calculateTotal()" onkeyup="calculateTotal()">
                                    </label>
                                </section>
                            </fieldset>
                        </div>
                        <div class="col-md-4 text-right" id="adult_total"></div>
                    </div>
                    <!-- <div class="row nopadding sky-form check-khoihanh">
                        <div class="col-md-3">Trẻ em</div>
                        <div class="col-md-5">
                            <fieldset>
                                <section name="">
                                    <label class="input">
                                        <input type="number" id="childAmount" name="childamount" min="0" value="{{Request::get('order_id') ? $order->childlist : ''}}" onchange="initChildAmount()" placeholder="Số trẻ em">
                                    </label>
                                </section>
                            </fieldset>
                        </div>
                    </div>
                    <?php $list_year = Request::get('order_id') && $order->list_child_years ? json_decode($order->list_child_years) : []; ?>
                    <div id="checkChildAge">
                        @if(count($list_year))
                            <?php $thisYear = intval(date('Y'));?> 
                            @foreach($list_year as $index => $year)
                            <div class="row nopadding sky-form check-khoihanh">
                                <div class="checkyear clearfix">
                                    <div class="col-md-2">Năm sinh trẻ {{$index + 1}}</div><div class="col-md-3"><fieldset><section><label class="select state-success"><select id="childYear_{{$index + 1}}" name="childYear[]" onchange="checkAddingAge();">
                                        <?php for($i = $thisYear; $i >= $thisYear - 10; $i--):?>
                                            <option value="{{$i}}" @if($i == $year->year) {{'selected'}} @endif;>{{$i}}</option>
                                        <?php endfor;?>
                                        </select><i></i></label></section></fieldset>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="" style="margin: 0;">
                                            <input type="hidden" id="isSeat_{{$index + 1}}" name="isSeat[]" value="{{$year->isSeat}}">
                                            <input id="check_seat_{{$index + 1}}" @if($year->isSeat): {{'checked'}} @endif type="checkbox" onclick="checkSeat();">
                                            <label for="check_seat_{{$index + 1}}">Ghế ngồi</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>