<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="MiscalculateModal" aria-labelledby="StartDateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        {!! Form::open(['method' => 'post', 'class' => 'form-horizontal panel']) !!}
        <input type="hidden" name="startdate_id" value=""/>
        <div class="modal-content" style="padding: 20px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Bảng chiết tính</h4>
            </div>
            <div class="modal-body" id="MiscalculateDetail">
                <input type="hidden" name="id" value="" id="StartdateID">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>CHI</th>
                        <th>SỐ LƯỢNG KHÁCH</th>
                        <th>GIÁ</th>
                        <th>SỐ LƯỢNG</th>
                        <th>THÀNH TIỀN</th>
                        <th>THUẾ VAT</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="7" class="text-center">Thông tin khách</td>
                    </tr>
                    <tr >
                        <td>Người lớn</td>
                        <td><input type="text" class="form-control" id="total_adult"></td>
                        <td><input type="text" class="form-control" id="adult_price"></td>
                        <td><input type="text" class="form-control" id="adult_number"></td>
                        <td><input type="text" class="form-control" id="total_adult_price"></td>
                        <td><input type="text" class="form-control" id="total_adult_tax"></td>
                        <td><input type="checkbox" class="form-control" name="checkrow"></td>
                    </tr>
                    <tr >
                        <td>Trẻ em</td>
                        <td><input type="text" class="form-control" id="total_child"></td>
                        <td><input type="text" class="form-control" id="child_price"></td>
                        <td><input type="text" class="form-control" id="child_number"></td>
                        <td><input type="text" class="form-control" id="total_child_price"></td>
                        <td><input type="text" class="form-control" id="total_child_tax"></td>
                        <td><input type="checkbox" class="form-control" name="checkrow"></td>
                    </tr>
                    <tr >
                        <td>Tổng cộng</td>
                        <td><input type="text" class="form-control" id="total_customer"></td>
                        <td></td>
                        <td></td>
                        <td><input type="text" class="form-control" id="total_customer_price"></td>
                        <td><input type="text" class="form-control" id="total_customer_tax"></td>
                        <td><input type="checkbox" class="form-control" name="checkrow"></td>
                    </tr>
                    <tr id="DetailPay">
                        <td colspan="7" class="text-center">Các khoản chi</td>
                    </tr>
                    @foreach($miscalculates as $index=>$miscalculate)
                        <tr data-miscalculate-id="{{ $miscalculate->id }}">
                            <td>{{ $miscalculate->title }}</td>
                            <td><input type="text" class="form-control" id="total_miscalculate_amount"></td>
                            <td><input type="text" class="form-control" id="miscalculate_price"></td>
                            <td><input type="text" class="form-control" id="total_miscalculate_number"></td>
                            <td><input type="text" class="form-control" id="total_miscalculate_price"></td>
                            <td><input type="text" class="form-control" id="total_miscalculate_tax"></td>
                            <td><input type="checkbox" class="form-control" name="checkrow"></td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" class="text-center">Bảng tính</td>
                        </tr>
                        <tr>
                            <td>TỔNG CHI PHÍ</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input type="text" class="form-control" id="total_amount"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>VAT 10%</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input type="text" class="form-control" id="total_tax_amount"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>VAT THỰC</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input type="text" class="form-control" id="total_real_tax_amount"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>GIÁ NET</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input type="text" class="form-control" id="sell_net_price"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>GIÁ BÁN</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input type="text" class="form-control" id="sell_price"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>LÃI MỐI KHÁCH</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input type="text" class="form-control" id="interest"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>TỔNG LÃI TOUR</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input type="text" class="form-control" id="total_interest"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>TỈ LỆ LÃI</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input type="text" class="form-control" id="interest_percent"></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="UpdateMiscalculate(this)">Lưu</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div><!-- /.modal-content -->
        {!! Form::close() !!}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<style>
    #MiscalculateDetail table input {
        text-align: right;
    }
</style>