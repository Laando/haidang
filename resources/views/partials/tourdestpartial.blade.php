@foreach($tours as $toursubject)
    <?php
    $arrimg = explode(';',$toursubject->images);
    $image =  checkImage($arrimg[0]);
    ?>
    <!--col-sm-4-->
    <div class="col-sm-6 col-lg-4 top-thongtintour">
        <div class="portfolio_item wow animated flipInX">
            <?php
            $strtmp = '';
            if(isset($type)){
                $strtmp = '?type='.$type;
            }
            ?>
            <a href="{!! asset($toursubject->slug.$strtmp) !!}" data-path-hover="M 180,190 0,158 0,0 180,0 z">
                @foreach($listtournew as $value)
                    @if($toursubject->id == $value)
                        <div class="easy-bg-v2 rgba-default">New</div>
                    @endif
                @endforeach
                <figure style="background-image:url({!! asset('image/'.$image) !!})">
                    <figcaption>
                        <p> <i class="fa fa-clock-o"></i> {!! $toursubject->period !!} | <i class="fa fa-automobile"></i> {!! $toursubject->traffic !!} | <i class="fa fa-hotel"></i> {!! $toursubject->starhotel !!} sao
                        </p>
                        <div class="view_button">Xem</div>
                    </figcaption>
                </figure>
                <h2>{!! $toursubject->title !!}</h2>
            </a>
            <!--gia top-->
            <div class=" col-md-12 clearfix shop-product-prices ">
                <div class="col-md-7 nopadding">
                    <ul class="clearfix list-inline">
                        <?php
                            if(isset($type)){
                                switch($type){
                                    case '2' :
                                        $priceview = $toursubject->star2;
                                        break;
                                    case '3' :
                                        $priceview = $toursubject->star3;
                                        break;
                                    case '4' :
                                        $priceview = $toursubject->star4;
                                        break;
                                    case '5' :
                                        $priceview = $toursubject->star5;
                                        break;
                                    default :
                                        $priceview = $toursubject->adultprice;
                                        break;
                                }

                            } else {
                                $priceview = $toursubject->adultprice;
                            }
                        ?>
                        <?php $countst = $toursubject->startdates()->where('startdate','>',new \DateTime())->count(); ?>
                        <li class="shop-red"> <strong data-price="{!! $priceview !!}">{!! $countst==0?'Tạm dừng':numbertomoney($priceview) !!}</strong>
                            <div class="line-through">Giá gốc: {!! numbertomoney($toursubject->price) !!}</div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-5 nopadding ">
                    <form action="#" class="sky-form">
                        <fieldset>
                            <section>
                                <i class="fa fa-calendar"></i> Lịch khởi hành
                                <label class="select state-success">
                                    <select>
                                        <span aria-hidden="true" class="icon-calendar"></span>
                                        <?php
                                        $countst =     $toursubject->startdates()->where('startdate','>',new \DateTime())->count();
                                        $startdates = $toursubject->startdates()->where('startdate','>',new \DateTime())->orderBy('startdate','ASC')->get();
                                        $totalfirst = 0
                                        ?>
                                        @foreach($startdates as $index=>$value)
                                            <?php
                                            $addings = $value->addings()->whereHas('addingcate',function($q) {
                                                $q->where('isForced','=',1);
                                            })->get();
                                            $totaladdings = $addings->sum('price');
                                            if($index==0) $totalfirst = $totaladdings;
                                            ?>
                                            <option value="{!! $totaladdings !!}">{!! date_format(date_create($value->startdate),'d/m/Y') !!}</option>
                                        @endforeach
                                    </select>
                                    <i></i>
                                </label>
                            </section>
                        </fieldset>
                    </form>
                </div>
            </div>
            <!--end gia top-->
        </div>
    </div>
    <!--end col-sm-4-->
@endforeach