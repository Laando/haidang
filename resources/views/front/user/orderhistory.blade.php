<div id="page-content" class="col-md-9 col-xs-12">
    <div class="tour-info table-responsive">
        <table class="table">
            <tbody>
                <tr>
                    <th>Tên Tour</th>
                    <th>Ngày Đặt</th>
                    <th>Trạng Thái</th>
                    <th>Chi Tiết</th>
                </tr>
                <?php foreach($orders as $item) : ?>
                    <?php //echo "<pre>";print_r($item);die; ?>
                <tr>
                    <td class="name"><?= $item->tourstaff->title ?></td>
                    <td class="price-adult"><?= date_format(date_create($item->created_at), 'd/m/Y')?></td>
                    <td class="price-child">{!! getStatusOrder($item->status) !!}</td>
                    <td class="availabel"> 
                        <a href data-toggle="modal" data-target="#<?php echo $item->id ?>">Chi Tiết</a>
                        <!-- Modal -->
                        
                        <div id="<?= $item->id ?>" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                            <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="oderinfo">
                                            <ul class="list-inline posted-info">
                                                <li>Ngày khởi hành : <?= date_format(date_create($item->startdate->startdate), 'd/m/Y') ?></li>
                                                <li>Ngày xác nhận : <strong style="color:red">{{$item->aprrove_date ? date_format(date_create($item->aprrove_date), 'd/m/Y') : 'Chưa xác nhận'}}</strong></li>
                                            </ul>
                                            <div class="oder-a">Code đơn hàng : <label>{{$item->order_code}}</label></div>
                                            <div class="oder-a">Số lượng ghế :
                                                <?= $item->startdate->seat ?>
                                            </div>
                                        </div>
                                        <table class="table table-hover">
                                            <?php 
                                                $deposit = $item->deposit ? $item->deposit : 0;
                                                $discount = $item->discount ? $item->discount : 0;
                                            ?>
                                            <tbody>
                                                <tr>
                                                    <td>Người lớn</td>
                                                    <td><?= $item->adult ?></td>
                                                    <td class="text-right"><?= number_format($item->price * $item->adult) ?> đ</td>
                                                </tr>
                                                <?php
                                                    $adding_childs = $item->adding_childs ? json_decode($item->adding_childs) : '';
                                                    $childAmount = 0;
                                                    if($adding_childs){
                                                        foreach ($adding_childs as $value) {
                                                            $childAmount = $childAmount + $value;
                                                        }
                                                    }
                                                ?>
                                                <tr>
                                                    <td>Trẻ em</td>
                                                    <td>{{$childAmount}}</td>
                                                    <td class="text-right">@if($childAmount) {{ number_format($item->total - $item->price * $item->adult) . ' đ' }} @else {{ '0 đ'}} @endif</td>
                                                </tr>
                                                <tr>
                                                    <td>Tổng</td>
                                                    <td><i class="fa fa-exchange" aria-hidden="true"></i></td>
                                                    <td class="text-right"><strong style="color:red"><?= number_format($item->total) ?> đ</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Đặt cọc</td>
                                                    <td><i class="fa fa-long-arrow-right" aria-hidden="true"></i></td>
                                                    <td class="text-right">{{number_format($deposit)}} đ</td>
                                                </tr>
                                                <tr>
                                                    <td>Giảm giá</td>
                                                    <td><i class="fa fa-long-arrow-right" aria-hidden="true"></i></td>
                                                    <td class="text-right">{{number_format($discount)}} đ</td>
                                                </tr>
                                                <tr>
                                                    <td>Còn Lại</td>
                                                    <td><i class="fa fa-exchange" aria-hidden="true"></i></td>
                                                    <td class="text-right"><strong style="color:blue"><?= number_format($item->total - ($deposit + $discount)) ?> đ</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>      
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>