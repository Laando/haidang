<div class="col-md-12">
    <?php $car_lists = $startdate->car_lists ? json_decode($startdate->car_lists) : [];?>
    @if(count($car_lists))
        @foreach($car_lists as $index => $car)
            <div class="col-md-3">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-automobile fa-3x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$car->seat_amount}}</div>
                                <div>chỗ</div>
                            </div>
                        </div>
                    </div>
                    <a style="cursor: pointer;" data-id="32" data-order="1" onclick="getSeatList(<?php echo $index?>, <?php echo $startdate->id?>)">
                        <div class="panel-footer">
                            <span class="pull-left">Xe {{$index + 1}}</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    @endif
</div>
<script>
    function getSeatList(index, startdate_id){
        $.ajax({
            type: 'GET',
            url: '/staff/get-car/?startdate_id=' + startdate_id + '&index=' + index,
            success: function (response) {
                $('#carList').html(response);
            }
        });
    }
</script>