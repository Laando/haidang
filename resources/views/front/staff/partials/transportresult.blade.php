@foreach($transports as $index => $t)
<div class="col-md-3">
    <div class="panel panel-yellow">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-automobile fa-3x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge">{!! $t->countOrderSeats() !!}</div>
                    <div>chỗ</div>
                </div>
            </div>
        </div>
        <a data-id="{!! $t->id !!}" data-order="{!! $index+1 !!}" onclick="getSeatList(this)">
            <div class="panel-footer">
                <span class="pull-left">Xe {!! $index+1 !!} {!! $t->is_bed?'Giường nằm':'' !!}</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>
@endforeach