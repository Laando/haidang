<?php $adding_childs_price = $startdate->adding_childs_price ? json_decode($startdate->adding_childs_price) : '';?>
<input type="hidden" name="adding_price[]" id="underTwo" value={{ $adding_childs_price ? $adding_childs_price->underTwo : 0}}>
<input type="hidden" name="adding_price[]" id="twoToSix" value={{ $adding_childs_price ? $adding_childs_price->twoToSix : 0}}>
<input type="hidden" name="adding_price[]" id="sixToTen" value={{ $adding_childs_price ? $adding_childs_price->sixToTen : 0}}>
<input type="hidden" name="adding_price[]" id="seatPrice" value={{ $adding_childs_price ? $adding_childs_price->seatPrice : 0}}>
<input type="hidden" name="adding_price[]" id="weekend" value={{ $adding_childs_price ? $adding_childs_price->weekend : 0}}>