<div class="gia-lichkhoihanh-tour">
    <div class="top-giohang clearfix">
        <div class="col-md-8">
            <span><i class="fa fa-check"></i> Thời gian  : <strong>{!! $tour->period !!}</strong></span><br>
            <span><i class="fa fa-check"></i> Phương tiện  : <strong>{!! $tour->traffic !!}</strong></span><br>
        </div>
    </div>
    <?php
    $eventtime =  Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $eventtimeconfig->content);
    $eventtimeend =  $eventtime->copy()->addHour(2);
    $now = Carbon\Carbon::now();
    $inEvent = $now->between($eventtime, $eventtimeend);
    ?>
    @if($tour->isGolden()&&$inEvent)
        <div class="golden-tag">Hình Tag Event</div>
    @endif
    <div class="headline"><h2> <span aria-hidden="true" class="icon-calculator"></span> Kiểm Tra Giá & Lịch Khởi Hành </h2></div>
    <div class="row nopadding sky-form check-khoihanh">
        <div class="col-md-3">Khởi Hành</div>
        <div class="col-md-5">
            <fieldset>
                <section name="startdate">
                    <label class="select state-success">
                        <?php
                        $startdates = $tour->startdates()->where('startdate','>',new \DateTime())->orderBy('startdate','ASC')->get();
                        ?>
                        @if($order->id != '')
                            @if($startdates->contains($order->startdate->id))
                                <select name="selectedstartdate" class="selectedstartdate" id="OrderStartdate" onchange="GetAddings(this)">
                                    <option value="">Chọn khởi hành</option>
                                    <span aria-hidden="true" class="icon-calendar"></span>
                                    @foreach($startdates as $index=>$value)
                                        @if($order->id != '')
                                            @if($tour->isGolden()&&$inEvent)
                                                <option value="{!! $value->id !!}" {!! $order->startdate->id==$value->id?'selected':''  !!} data-event="{!! $value->percent !!}" data-ticket="{!! $value->countPromotionCode() !!}">{!! date_format(date_create($value->startdate),'d/m/Y') !!} {!! $value->percent!=0?'(-'.$value->percent.'%)':'' !!}</option>
                                            @else
                                                <option value="{!! $value->id !!}" {!! $order->startdate->id==$value->id?'selected':''  !!} >{!! date_format(date_create($value->startdate),'d/m/Y') !!}</option>
                                            @endif
                                        @else
                                            @if($tour->isGolden()&&$inEvent)
                                                <option value="{!! $value->id !!}" data-event="{!! $value->percent !!}" data-ticket="{!! $value->countPromotionCode() !!}">{!! date_format(date_create($value->startdate),'d/m/Y') !!} {!! $value->percent!=0?'(-'.$value->percent.'%)':'' !!}</option>
                                            @else
                                                <option value="{!! $value->id !!}" >{!! date_format(date_create($value->startdate),'d/m/Y') !!}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            @else
                                <select name="selectedstartdate" class="selectedstartdate" id="OrderStartdate" onchange="GetAddings(this)">
                                    <option value="">Chọn khởi hành</option>
                                    <span aria-hidden="true" class="icon-calendar"></span>
                                         <option value="{!! $order->startdate->id !!}" selected>{!! date_format(date_create($order->startdate->startdate),'d/m/Y') !!}</option>
                                </select>
                            @endif
                        @else
                                <select name="selectedstartdate" class="selectedstartdate" id="OrderStartdate" onchange="GetAddings(this)">
                                    <option value="">Chọn khởi hành</option>
                                    <span aria-hidden="true" class="icon-calendar"></span>
                                    @foreach($startdates as $index=>$value)
                                        @if($order->id != '')
                                            <option value="{!! $value->id !!}" {!! $order->startdate->id==$value->id?'selected':''  !!}>{!! date_format(date_create($value->startdate),'d/m/Y') !!}</option>
                                        @else
                                            <option value="{!! $value->id !!}" >{!! date_format(date_create($value->startdate),'d/m/Y') !!}</option>
                                        @endif
                                    @endforeach
                                </select>
                        @endif
                        <i></i>
                    </label>
                </section>
            </fieldset>
        </div>
    </div>
    <div class="row nopadding sky-form check-khoihanh">
        <div class="col-md-3">Người lớn</div>
        <div class="col-md-5">
            <fieldset>
                <section name="startdate">
                    <label class="input">
                        @if(isset($order))
                        <input type="number" name="adult" placeholder="1" min="1" value="{!! $order->adult !!}">
                        @else
                        <input type="number" name="adult" placeholder="1" min="1" value="">
                        @endif
                    </label>
                </section>
            </fieldset>
        </div>
        <div class="col-md-4 text-right">= <strong class="adult_total"></strong></div>
    </div>
    <div class="row nopadding sky-form check-khoihanh">
        <div class="col-md-3">Trẻ em</div>
        <div class="col-md-5">
            <fieldset>
                <section name="startdate">
                    <label class="input">
                        @if(isset($order))
                            <input type="number" name="child" placeholder="0" min="0" value="{!! $order->child?$order->child:0 !!}">
                        @else
                            <input type="number" name="child" placeholder="0" min="0" value="">
                        @endif
                    </label>
                </section>
            </fieldset>
        </div>
        <div class="col-md-4 text-right">= <strong class="child_total"></strong></div>
    </div>
    <div class="row nopadding sky-form check-khoihanh">
        <div class="col-md-3">Em bé</div>
        <div class="col-md-5">
            <fieldset>
                <section name="startdate">
                    <label class="input">
                        @if(isset($order))
                            <input type="number" name="baby" placeholder="0" min="0" value="{!! $order->baby?$order->baby:0 !!}">
                        @else
                            <input type="number" name="baby" placeholder="0" min="0" value="">
                        @endif
                    </label>
                </section>
            </fieldset>
        </div>
        <div class="col-md-4 text-right">= <strong class="baby_total"></strong></div>
    </div>
    <div class="row nopadding sky-form addingrow required">
        <div class="col-md-3 adding_name"></div>
        <div class="col-md-5">
            <input type="hidden" value="" name="addingtype[]">
            <input type="hidden" value="" name="addingobj[]" class="addingobj">
            <input type="hidden" value="" name="addingprice[]" class="adding-price">
            <fieldset>
                <section name="startdate">
                    <label class="input">
                         <input type="number" value="" name="amount[]" class="amount">
                    </label>
                </section>
            </fieldset>
        </div>
        <div class="col-md-4 adding-amount text-right">
            = <strong class="adding_total"></strong>
        </div>
    </div>
    <div class="row nopadding sky-form addingrow standard">
        <div class="col-md-3">
            <div class="form-group">
                <select name="standard" class="form-control" id="AddingStandard">
                    <option value="" data-price="0">Mặc định</option>
                </select>
            </div>
        </div>
        <div class="col-md-5">
            <input type="hidden" value="" name="addingtype_standard[]">
            <input type="hidden" value="" name="addingobj_standard[]" class="addingobj">
            <input type="hidden" value="" name="addingprice_standard[]" class="adding-price">
            <fieldset>
                <section name="startdate">
                    <label class="input">
                        <input type="number" value="" class="amount" name="amount_standard[]">
                    </label>
                </section>
            </fieldset>
        </div>
        <div class="col-md-4 adding-amount text-right">
            = <strong class="adding_total"></strong>
        </div>
    </div>
    <div class="row nopadding sky-form check-khoihanh">
        <div class="col-md-3">Tổng cộng</div>
        <div class="col-md-9 text-right">
            = <strong class="total"></strong>
        </div>
    </div>
    <div class="clearfix"></div>
</div>