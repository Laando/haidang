<div class="modal fade" id="editStartdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    {!! Form::model($startdate, ['route' => ['startdate.update', $startdate->id], 'method' => 'post', 'class' => 'startdate_form','files' => true]) !!}

<input type="hidden" name="startdateid" value="{!! $startdate->id !!}"/>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Sửa khởi hành</h4>
        </div>
        <div class="modal-body">
            <div class="form-group input-group">
                <span class="input-group-addon">Ngày khởi hành</span>
                <input type="text" class="form-control datepicker" id="editstart" placeholder="Sửa ngày khởi hành (Chỉ admin)" name="startdate" required value="{!! date_format(date_create($startdate->startdate),'d/m/Y') !!}">
            </div>
            <div class="form-group input-group">
                <span class="input-group-addon">Số chổ</span>
                <input type="number" class="form-control" placeholder="Số chỗ mở tour" name="seat" required value="{!! $startdate->seat !!}" id="edit_seat">
            </div>
            @foreach($startdate->transports as $index=>$transport)
                <div class="col-md-12 transport-item" data-transport-id="{!! $transport->id !!}">
                    <div class="col-md-2">Xe {!! $index+1 !!}</div>
                    <div class="col-md-4 checkbox">
                        <label><input type="checkbox" name="is_bed" {!! $transport->is_bed?'checked':'' !!} {!! $transport->seats()->whereNotNull('order_id')->count()>0?'disabled':'' !!}>Giường nằm ({!! $transport->seats()->whereNotNull('order_id')->count()!!})</label>
                    </div>
                    <div class=" col-md-6">
                        <div class="form-group input-group">
                            <span class="input-group-addon">Số chổ</span>
                            <input type="number" disabled class="form-control" placeholder="Số chỗ mở tour" value="{!! $transport->seats->count() !!}">
                        </div>
                    </div>
                </div>

            @endforeach
            <div class="form-group input-group">
                <span class="input-group-addon">Phương tiện</span>
                <input type="text" class="form-control" placeholder="Phương tiện di chuyển" name="traffic" required value="{!! $startdate->traffic !!}">
            </div>
            @if(count($addings)>0)
            @foreach($addings as $index => $value)
            <div class="adding-field-old">
                <input type="hidden" name="oldaddingid[]" value="{!! $value->id !!}"/>
                <label><i class="fa fa-close delete-adding" id="{!! $value->id !!}"></i> Phụ thu :</label>
                <div class="form-group input-group adding">
                    <span class="input-group-addon">Loại :</span>
                    <select name="oldaddingcate[]">
                        @foreach($addingcates as $addingcate)
                        <option value="{!! $addingcate->id !!}" {!! $addingcate->id==$value->addingcate_id?'selected="selected"':'' !!}>{!! $addingcate->title !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group input-group adding">
                    <span class="input-group-addon">Số tiền :</span>
                    <input type="text" class="form-control price {!! $value->addingcate_id==2||$value->addingcate_id==5?'percentmask':'moneymask' !!}" placeholder="Số tiền phụ thu" name="oldprice[]" required value="{!! $value->price !!}">
                </div>
            </div>
            @endforeach
            @endif

            <div class=""><button type="button" class="btn btn-default adding add"><i class="fa fa-plus fa-2 add"></i></button><div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>


    </div>
    </div>
    {!! Form::close() !!}
    </div>