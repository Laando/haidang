<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="StartDateModal" aria-labelledby="StartDateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        {!! Form::open(['method' => 'post', 'class' => 'form-horizontal panel']) !!}
        <input type="hidden" name="startdate_id" value=""/>
        <div class="modal-content" style="padding: 20px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Chi tiết ngày khởi hành</h4>
            </div>
            <div class="modal-body" id="StartDateDetail">
                <input type="hidden" name="id" value="" id="StartdateID">
                {!! Form::control('text', 0, 'startdate', $errors, 'Ngày khởi hành',null,null,'Ngày khởi hành') !!}
                {!! Form::control('number', 0, 'startdate_seat', $errors, 'Số chỗ',null,null,'Số chỗ' , 'text-right') !!}
                {!! Form::selection('startdate_traffic', $vehicles->pluck('vehicle','idtypeVehicle'), null , 'Chọn phương tiện khởi hành') !!}
                {!! Form::control('text', 0, 'startdate_adult_price', $errors, 'Giá người lớn' ,null,null,'Giá người lớn' , 'moneymask text-right') !!}
                {!! Form::control('text',  0,'startdate_baby_price', $errors, 'Giá em bé',null,null,'Giá em bé' , 'moneymask text-right') !!}
                {!! Form::control('text',  0,'startdate_child_price', $errors, 'Giá trẻ em',null,null,'Giá trẻ em', 'moneymask text-right') !!}
                <h3>Các khoản phụ thu</h3>
                <div class="row" id="adding-list">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Tên khoản</th>
                                <th>Số tiền</th>
                                <th>Đối tượng / Tiêu chuẩn</th>
                                <th>Bắt buộc</th>
                                <th>Có chỗ</th>
                                <th>̃</th>
                            </tr>

                            </thead>
                            <tbody id="startdateTbody">
                            <tr>
                                <td> {!! Form::control('text', 0, 'adding_name[]', $errors, null,null,null,'Tên' ) !!}</td>
                                <td> {!! Form::control('text', 0, 'adding_price[]', $errors, null,null,null,'Tiền' , ' moneymask') !!}</td>
                                <td> {!! Form::select('adding_obj[]', [0=>'Tất cả' ,1=>'Trẻ em' ,2=>'Em bé', 3=>'1 sao' ,4=>'2 sao' ,  5=>'3 sao' , 6=>'4 sao' ,  7=>'5 sao'   ], null, ['class' => 'form-control']) !!}</td>
                                <td> {!! Form::checkbox('adding_required[]' , 1 , false) !!}</td>
                                <td> {!! Form::checkbox('adding_hasSeat[]' , 1 , false) !!}</td>
                                <td>
                                    <buttton onclick="removeAddingExtra(this)"><i class="fa fa-remove"></i>
                                    </buttton>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-success" type="button" onclick="AddRow(this , 'startdateTbody')"><i
                                class="fa fa-plus fa-2"></i></button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="UpdateStarDate(this)">Lưu</button>
                <button type="button" class="btn btn-danger" onclick="DeleteSartDate(this)">Xóa</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div><!-- /.modal-content -->
        {!! Form::close() !!}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->