<?php
$firstcheck = true;
$price_charges = explode("|", $startdate->gia_phu_thu);
$name_charges =explode("|", $startdate->ten_phu_thu);
// $is_show=explode("|", $startdate->phuthu_show);

$phuthu=0;
foreach ($price_charges as $key => $value) {
    if ($name_charges[$key]=="Phụ thu cuối tuần") {
        $phuthu +=$value;
    }
}
?>

                                                @if($tour->star0!=0 && $tour->star0!='')
                                                    <option value="{!! $tour->star0+$phuthu !!}" {!! old('starhotel')==$tour->star0?'selected':'' !!} {!! old('starhotel')==null?'selected':'' !!} {!! $firstcheck==true?'selected':'' !!} > Nhà nghỉ : {!! numbertomoney($tour->star0+$phuthu) !!}</option>
                                                    <?php $firstcheck = false; ?>
                                                @endif
                                                @if($tour->star1!=0 && $tour->star1!='')
                                                    <option value="{!! $tour->star1+$phuthu !!}" {!! old('starhotel')==$tour->star1?'selected':'' !!} {!! old('starhotel')==null?'selected':'' !!} {!! $firstcheck==true?'selected':'' !!}> KS 1 Sao : {!! numbertomoney($tour->star1+$phuthu) !!}</option>
                                                    <?php $firstcheck = false; ?>
                                                @endif
                                                @if($tour->star2!=0 && $tour->star2!='')
                                                    <option value="{!! $tour->star2+$phuthu !!}" {!! old('starhotel')==$tour->star2?'selected':'' !!} {!! old('starhotel')==null?'selected':'' !!} {!! $firstcheck==true?'selected':'' !!}> KS 2 Sao : {!! numbertomoney($tour->star2+$phuthu) !!}</option>
                                                    <?php $firstcheck = false; ?>
                                                @endif
                                                @if($tour->star3!=0 && $tour->star3!='')
                                                    <option value="{!! $tour->star3+$phuthu !!}" {!! old('starhotel')==$tour->star3?'selected':'' !!} {!! $firstcheck==true?'selected':'' !!}> KS 3 Sao : {!! numbertomoney($tour->star3+$phuthu) !!}</option>
                                                    <?php $firstcheck = false; ?>
                                                @endif
                                                @if($tour->star4!=0 && $tour->star4!='')
                                                    <option value="{!! $tour->star4+$phuthu !!}" {!! old('starhotel')==$tour->star4?'selected':'' !!} {!! $firstcheck==true?'selected':'' !!}> KS 4 Sao : {!! numbertomoney($tour->star4+$phuthu) !!}</option>
                                                    <?php $firstcheck = false; ?>
                                                @endif
                                                @if($tour->star5!=0 && $tour->star5!='')
                                                    <option value="{!! $tour->star5+$phuthu !!}" {!! old('starhotel')==$tour->star5?'selected':'' !!} {!! $firstcheck==true?'selected':'' !!}> KS 5 Sao : {!! numbertomoney($tour->star5+$phuthu) !!}</option>
                                                    <?php $firstcheck = false; ?>
                                                @endif
                                                @if($tour->rs2!=0 && $tour->rs2!='')
                                                    <option value="{!! $tour->rs2+$phuthu !!}" {!! old('starhotel')==$tour->rs2?'selected':'' !!} {!! $firstcheck==true?'selected':'' !!}> RS 2 Sao : {!! numbertomoney($tour->rs2+$phuthu) !!}</option>
                                                    <?php $firstcheck = false; ?>
                                                @endif
                                                @if($tour->rs3!=0 && $tour->rs3!='')
                                                    <option value="{!! $tour->rs3+$phuthu !!}" {!! old('starhotel')==$tour->rs3?'selected':'' !!} {!! $firstcheck==true?'selected':'' !!}> RS 3 Sao : {!! numbertomoney($tour->rs3+$phuthu) !!}</option>
                                                    <?php $firstcheck = false; ?>
                                                @endif
                                                @if($tour->rs4!=0 && $tour->rs4!='')
                                                    <option value="{!! $tour->rs4 +$phuthu !!}" {!! old('starhotel')==$tour->rs4?'selected':'' !!} {!! $firstcheck==true?'selected':'' !!}> RS 4 Sao : {!! numbertomoney($tour->rs4+$phuthu) !!}</option>
                                                    <?php $firstcheck = false; ?>
                                                @endif
                                                @if($tour->rs5!=0 && $tour->rs5!='')
                                                    <option value="{!! $tour->rs5+$phuthu !!}" {!! old('starhotel')==$tour->rs5?'selected':'' !!} {!! $firstcheck==true?'selected':'' !!}> RS 5 Sao : {!! numbertomoney($tour->rs5+$phuthu) !!}</option>
                                                    <?php $firstcheck = false; ?>
                                                @endif