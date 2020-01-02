<?php
if(isset($hotel)) {
    $selecthoteltypes = $hotel->hoteltypes;
    $selecthotelcharacters = $hotel->hotelcharacters;
}
?>
<div class="panel-body">
    @foreach($selecthoteltype as $key=>$value)
        <div class="col-md-12 type-root">
            <input value="{!!  $value->id !!}" type="checkbox" name="hoteltype[]"
                    @if(isset($hotel))
                   {!! $selecthoteltypes->contains('id',$value->id)?'checked':'' !!}
                    @else
                        checked
                    @endif
                    />
            {!! $value->title !!}
            <button class="btn btn-danger room-type-del pull-right" type="button" title="Xóa loại">
                <i class="fa fa-remove fa-2" ></i>
            </button>
            <button class="btn btn-info room-type-edit pull-right" type="button" title="Sửa loại">
                <i class="fa fa-pencil-square-o fa-2" ></i>
            </button>
            <button class="btn btn-primary room-character-add pull-right" type="button" title="Thêm đặc trưng">
                <i class="fa fa-plus fa-2" ></i>
            </button>
            <?php
            $hotelchars = $value->hotelcharacters
            ?>
            @foreach($hotelchars as $htc)
                <div class="col-md-12 character-root">
                    <input value="{!!  $htc->id !!}" type="checkbox" name="hotelchar[]"
                    @if(isset($hotel))
                           {!! $selecthotelcharacters->contains('id',$htc->id)?'checked':'' !!}
                    @else
                        checked
                    @endif
                            />
                    {!! $htc->title !!}
                    <button class="btn btn-success room-character-del pull-right" type="button" title="Xóa đặc trưng">
                        <i class="fa fa-remove fa-2" ></i>
                    </button>
                    <button class="btn btn-warning room-character-edit pull-right" type="button" title="Sửa đặc trưng">
                        <i class="fa fa-pencil-square-o fa-2" ></i>
                    </button>
                </div>
            @endforeach
        </div>
        <div class="clearfix"></div>
    @endforeach
</div>