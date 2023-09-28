<!-- Include Required Prerequisites -->
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css"/>
<form method="GET" id="form-search-daterange">
    <input type="hidden" name="start_date" id="start_date"/>
    <input type="hidden" name="end_date" id="end_date"/>
</form>
<input type="text" name="daterange" id="daterange"
       value="<?= str_replace('-', '/', $start_date) ?> - <?= str_replace('-', '/', $end_date) ?>"/>
<script type="text/javascript">
    //
    $(function () {
        //
        $('input[name="daterange"]').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            },
            maxDate: new Date()
        });
        //
        $('#daterange').on('apply.daterangepicker', function (ev, picker) {
            var start_date = picker.startDate.format('DD-MM-YYYY');
            start_date = encodeURI(start_date);
            var end_date = picker.endDate.format('DD-MM-YYYY');
            end_date = encodeURI(end_date);
            $('input#start_date').val(start_date);
            $('input#end_date').val(end_date);
            $('#form-search-daterange').submit();
        });
    });
    //
</script>

<style type="text/css">

</style>

<div class="content">
    <div class="row">
        <div class="col-lg-2">
            <div class="block block-bordered">
                <div class="block-header">
                    <h3 class="block-title text-center"><i class="fa fa-mouse-pointer"></i> Click</h3>
                </div>
                <div class="block-content">
                    <div class="pull-r-l pull-t">
                        <table class="block-table text-center bg-gray-lighter table-bordered" style="width: 100%">
                            <tbody>
                            <tr>
                                <td class="border-r">
                                    <div class="t-report t-click h3 push-5"><span
                                                id="total-click-count-value"><?= $clickCount ?></span></div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Click</div>
                                </td>
                                <td class="" style="width:50%;">
                                    <div class="t-report t-cvr h3 push-5"><span
                                                id="cr-order-convert"><?= number_format($rate, 0, ',', '.') ?>%</span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">CR</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="block block-bordered">
                <div class="block-header">
                    <h3 class="block-title text-center"><i class="fa fa-cart-arrow-down"></i>Biên dịch</h3>
                </div>
                <div class="block-content">
                    <div class="pull-r-l pull-t">
                        <table class="block-table text-center bg-gray-lighter table-bordered"
                               style="table-layout:fixed;">
                            <tbody>
                            <tr>
                                <td class="border-r">
                                    <div class="t-report t-tran-success h3 push-5"><span
                                                id="valid-conversion-count-value"><?= $orderCompleteCount ?></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Thành công</div>
                                </td>
                                <td class="border-r">
                                    <div class="t-report t-tran-pending h3 push-5" id=""><span
                                                id="pending-conversion-count-value"><?= $orderWaitingCount ?></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Chờ duyệt</div>
                                </td>
                                <td>
                                    <div class="t-report t-tran-cancel h3 push-5" id=""><span
                                                id="invalid-conversion-count-value"><?= $orderDestroyCount ?></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Đã hủy</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="block block-bordered">
                <div class="block-header">
                    <h3 class="block-title text-center"><i class="fa fa-cart-arrow-down"></i>Phiên dịch</h3>
                </div>
                <div class="block-content">
                    <div class="pull-r-l pull-t">
                        <table class="block-table text-center bg-gray-lighter table-bordered"
                               style="table-layout:fixed;">
                            <tbody>
                            <tr>
                                <td class="border-r">
                                    <div class="t-report t-tran-success h3 push-5"><span
                                                id="valid-conversion-count-value"><?= $orderInterCompleteCount ?></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Thành công</div>
                                </td>
                                <td class="border-r">
                                    <div class="t-report t-tran-pending h3 push-5" id=""><span
                                                id="pending-conversion-count-value"><?= $orderInterWaitingCount ?></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Chờ duyệt</div>
                                </td>
                                <td>
                                    <div class="t-report t-tran-cancel h3 push-5" id=""><span
                                                id="invalid-conversion-count-value"><?= $orderInterDestroyCount ?></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Đã hủy</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="block block-bordered">
                <div class="block-header">
                    <h3 class="block-title text-center"><i class="fa fa-cart-arrow-down"></i>Yêu cầu BPO</h3>
                </div>
                <div class="block-content">
                    <div class="pull-r-l pull-t">
                        <table class="block-table text-center bg-gray-lighter table-bordered"
                               style="table-layout:fixed;">
                            <tbody>
                            <tr>
                                <td class="border-r">
                                    <div class="t-report t-tran-success h3 push-5"><span
                                                id="valid-conversion-count-value"><?= $orderBpoCompleteCount ?></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Thành công</div>
                                </td>
                                <td class="border-r">
                                    <div class="t-report t-tran-pending h3 push-5" id=""><span
                                                id="pending-conversion-count-value"><?= $orderBpoWaitingCount ?></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Chờ duyệt</div>
                                </td>
                                <td>
                                    <div class="t-report t-tran-cancel h3 push-5" id=""><span
                                                id="invalid-conversion-count-value"><?= $orderBpoDestroyCount ?></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Đã hủy</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="block block-bordered">
                <div class="block-header">
                    <h3 class="block-title text-center"><i class="fa fa-cart-arrow-down"></i>Giới thiệu</h3>
                </div>
                <div class="block-content">
                    <div class="pull-r-l pull-t">
                        <table class="block-table text-center bg-gray-lighter table-bordered"
                               style="table-layout:fixed;">
                            <tbody>
                            <tr>
                                <td class="border-r">
                                    <div class="t-report t-tran-success h3 push-5"><span
                                                id="valid-conversion-count-value"><?= $orderContactCompleteCount ?></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Thành công</div>
                                </td>
                                <td class="border-r">
                                    <div class="t-report t-tran-pending h3 push-5" id=""><span
                                                id="pending-conversion-count-value"><?= $orderContactWaitingCount ?></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Chờ duyệt</div>
                                </td>
                                <td>
                                    <div class="t-report t-tran-cancel h3 push-5" id=""><span
                                                id="invalid-conversion-count-value"><?= $orderContactDestroyCount ?></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Đã hủy</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="block block-bordered">
                <div class="block-header">
                    <h3 class="block-title text-center">
                        <i class="fa fa-money"></i> Hoa hồng
                    </h3>
                </div>
                <div class="block-content">
                    <div class="pull-r-l pull-t">
                        <table class="block-table text-center bg-gray-lighter table-bordered"
                               style="table-layout:fixed;">
                            <tbody>
                            <tr>
                                <td class="border-r">
                                    <div class="t-report t-tran-success h3 push-5" id=""><span
                                                id="valid-conversion-payout-value"><?= ($commission[Orders::ORDER_COMPLETE]) . ' USD' ?></span></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Thành công</div>
                                </td>
                                <td class="border-r">
                                    <div class="t-report t-tran-pending h3 push-5" id=""><span
                                                id="pending-conversion-payout-value"><?= ($commission[Orders::ORDER_WAITFORPROCESS]) . ' USD' ?></span></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Chờ duyệt</div>
                                </td>
                                <td>
                                    <div class="t-report t-tran-cancel h3 push-5" id=""><span
                                                id="invalid-conversion-payout-value"><?= ($commission[Orders::ORDER_DESTROY]) . ' USD' ?></span></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Không duyệt</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="block">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#translate"><?= Yii::t('affiliate','request')?></a>
            </li>
            <li><a data-toggle="tab" href="#bpo"><?= Yii::t('affiliate','bpo')?></a></li>
            <li><a data-toggle="tab" href="#interpretation"><?= Yii::t('affiliate','interpretation')?></a></li>
            <li><a data-toggle="tab" href="#intro"><?= Yii::t('affiliate','intro')?></a></li>
        </ul>
        <div class="block-content tab-content">
            <div id="translate" class="tab-pane fade in active">
                <div class="table_block">
                    <div class="table-responsive">
                        <div id="table-conversion-list_wrapper"
                             class="dataTables_wrapper form-inline dt-bootstrap dataTables_extended_wrapper no-footer">
                            <?php
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'orders-trans-grid',
                                'dataProvider' => $ordertrans->search(),
                                'itemsCssClass' => 'table table-bordered table-hover vertical-center',
                                'filter' => null,
                                'enableSorting' => false,
                                'columns' => array(
                                    'id' => array(
                                        'header' => '#',
                                        'name' => 'id',
                                        'value' => '"#".$data->id',
                                    ),
                                    'name' => array(
                                        'header' => 'Tên',
                                        'name' => 'id',
                                        'value' => '$data->name',
                                    ),
                                    'total_price' => array(
                                        'header' => 'Giá tiền',
                                        'name' => 'id',
                                        'type' => 'html',
                                        'value' => function ($data) {
                                            return ($data->total_price) ? HtmlFormat::money_format($data->total_price) . ' ' . $data->currency : 'Liên hệ';
                                        }
                                    ),
                                    'currency' => array(
                                        'header' => 'Đơn vị tiền tệ',
                                        'name' => 'id',
                                        'value' => '$data->currency',
                                    ),

                                    'payment_method' => array(
                                        'header' => 'Phương thức thanh toán',
                                        'name' => 'id',
                                        'value' => function ($data) {
                                            return TranslateOrder::getPaymentMethod()[$data->payment_method];
                                        }
                                    ),
                                    'status' => array(
                                        'header' => 'Trạng thái',
                                        'name' => 'id',
                                        'value' => function ($data) {
                                            return Orders::getStatusArr()[$data->status];
                                        }
                                    ),
                                    'payment_status' => array(
                                        'header' => 'Tình trạng thanh toán',
                                        'name' => 'id',
                                        'value' => function ($data) {
                                            return TranslateOrder::getPaymentStatus()[$data->payment_status];
                                        }
                                    ),
                                    'created_time' => array(
                                        'name' => 'created_time',
                                        'value' => 'date("d-m-Y, H:i:s",$data->created_time)',
                                    ),
                                ),
                            ));
                            ?>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="bpo" class="tab-pane fade">
                <div class="table_block">
                    <div class="table-responsive">
                        <div id="table-conversion-list_wrapper"
                             class="dataTables_wrapper form-inline dt-bootstrap dataTables_extended_wrapper no-footer">
                            <?php
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'orders-bpo-grid',
                                'dataProvider' => $bpo->search(),
                                'itemsCssClass' => 'table table-bordered table-hover vertical-center',
                                'filter' => null,
                                'enableSorting' => false,
                                'columns' => array(
                                    'id' => array(
                                        'header' => '#',
                                        'name' => 'id',
                                        'value' => '"#".$data->id',
                                    ),
                                    'service' => array(
                                        'header' => 'Dịch vụ',
                                        'name' => 'service',
                                        'value' => '$data->service',
                                    ),
                                    'total_price' => array(
                                        'header' => 'Giá tiền',
                                        'name' => 'id',
                                        'type' => 'html',
                                        'value' => function ($data) {
                                            return ($data->total_price) ? HtmlFormat::money_format($data->total_price) . ' ' . $data->currency : 'Liên hệ';
                                        }
                                    ),

                                    'currency' => array(
                                        'header' => 'Đơn vị tiền tệ',
                                        'name' => 'id',
                                        'value' => '$data->currency',
                                    ),
                                    'payment_status' => array(
                                        'header' => 'Tình trạng thanh toán',
                                        'name' => 'id',
                                        'value' => function ($data) {
                                            return TranslateOrder::getPaymentStatus()[$data->payment_status];
                                        }
                                    ),
                                    'payment_method' => array(
                                        'header' => 'Phương thức thanh toán',
                                        'name' => 'id',
                                        'value' => function ($data) {
                                            return TranslateOrder::getPaymentMethod()[$data->payment_method];
                                        }
                                    ),
                                    'status' => array(
                                        'header' => 'Trạng thái',
                                        'name' => 'id',
                                        'value' => function ($data) {
                                            return Orders::getStatusArr()[$data->status];
                                        }
                                    ),

                                    'created_time' => array(
                                        'name' => 'created_time',
                                        'value' => 'date("d-m-Y, H:i:s",$data->created_time)',
                                    ),
                                ),
                            ));
                            ?>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="interpretation" class="tab-pane fade">
                <div class="table_block">
                    <div class="table-responsive">
                        <div id="table-conversion-list_wrapper"
                             class="dataTables_wrapper form-inline dt-bootstrap dataTables_extended_wrapper no-footer">
                            <?php
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'orders-interprestation-grid',
                                'dataProvider' => $interpretation->search(),
                                'itemsCssClass' => 'table table-bordered table-hover vertical-center',
                                'filter' => null,
                                'enableSorting' => false,
                                'columns' => array(
                                    'name' => array(
                                        'header' => 'Tên',
                                        'name' => 'id',
                                        'value' => '$data->name',
                                    ),
                                    'tell' => array(
                                        'header' => 'Số điện thoại',
                                        'name' => 'id',
                                        'value' => '$data->tell',
                                    ),
                                    'total_price' => array(
                                        'header' => 'Giá tiền',
                                        'name' => 'id',
                                        'type' => 'html',
                                        'value' => function ($data) {
                                            return ($data->total_price) ? HtmlFormat::money_format($data->total_price) . ' ' . $data->currency : 'Liên hệ';
                                        }
                                    ),
                                    'currency' => array(
                                        'header' => 'Đơn vị tiền tệ',
                                        'name' => 'id',
                                        'value' => '$data->currency',
                                    ),
                                    'payment_method' => array(
                                        'header' => 'Phương thức thanh toán',
                                        'name' => 'id',
                                        'value' => function ($data) {
                                            return TranslateOrder::getPaymentMethod()[$data->payment_method];
                                        }
                                    ),
                                    'status' => array(
                                        'header' => 'Trạng thái',
                                        'name' => 'id',
                                        'value' => function ($data) {
                                            return Orders::getStatusArr()[$data->status];
                                        }
                                    ),
                                    'payment_status' => array(
                                        'header' => 'Tình trạng thanh toán',
                                        'name' => 'id',
                                        'value' => function ($data) {
                                            return TranslateOrder::getPaymentStatus()[$data->payment_status];
                                        }
                                    ),
                                    'created_time' => array(
                                        'name' => 'created_time',
                                        'value' => 'date("d-m-Y, H:i:s",$data->created_time)',
                                    ),
                                ),
                            ));
                            ?>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="intro" class="tab-pane fade">
                <div class="table_block">
                    <div class="table-responsive">
                        <div id="table-conversion-list_wrapper"
                             class="dataTables_wrapper form-inline dt-bootstrap dataTables_extended_wrapper no-footer">
                            <?php
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'orders-intro-grid',
                                'dataProvider' => $intro->search(),
                                'itemsCssClass' => 'table table-bordered table-hover vertical-center',
                                'filter' => null,
                                'enableSorting' => false,
                                'columns' => array(
                                    'id' => array(
                                        'header' => '#',
                                        'name' => 'id',
                                        'value' => '"#".$data->id',
                                    ),
                                    'name' => array(
                                        'header' => 'Tên',
                                        'name' => 'id',
                                        'value' => '$data->name',
                                    ),
                                    'total_price' => array(
                                        'header' => 'Giá tiền',
                                        'name' => 'id',
                                        'type' => 'html',
                                        'value' => function ($data) {
                                            return ($data->total_price) ? HtmlFormat::money_format($data->total_price) . ' ' . $data->currency : 'Liên hệ';
                                        }
                                    ),
                                    'status' => array(
                                        'header' => 'Trạng thái',
                                        'name' => 'status',
                                        'value' => function ($data) {
                                            return ExpertransContactFormModel::statusArrayTranslate()[$data->status];
                                        },
                                        'htmlOptions' => array('style' => 'width: 100px; text-align: center;'),
                                    ),


                                    'created_time' => array(
                                        'name' => 'created_time',
                                        'value' => 'date("d-m-Y, H:i:s",$data->created_time)',
                                    ),
                                ),
                            ));
                            ?>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .h3, h3 {
        font-size: 17px !important;
    }
</style>