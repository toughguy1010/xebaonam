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
        <div class="col-lg-3">
            <div class="block block-bordered">
                <div class="block-header">
                    <h3 class="block-title text-center"><i class="fa fa-mouse-pointer"></i> Click</h3>
                </div>
                <div class="block-content">
                    <div class="pull-r-l pull-t">
                        <table class="block-table text-center bg-gray-lighter">
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
        <div class="col-lg-3">
            <div class="block block-bordered">
                <div class="block-header">
                    <h3 class="block-title text-center"><i class="fa fa-cart-arrow-down"></i> Đơn hàng</h3>
                </div>
                <div class="block-content">
                    <div class="pull-r-l pull-t">
                        <table class="block-table text-center bg-gray-lighter" style="table-layout:fixed;">
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
                                    <div class="h6 text-muted text-uppercase push-5-t">Hủy</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="block block-bordered">
                <div class="block-header">
                    <h3 class="block-title text-center">
                        <i class="fa fa-money"></i> Giới thiệu
                    </h3>
                </div>
                <div class="block-content">
                    <div class="pull-r-l pull-t">
                        <table class="block-table text-center bg-gray-lighter" style="table-layout:fixed;">
                            <tbody>
                            <tr>
                                <td class="border-r">
                                    <div class="t-report t-tran-success h3 push-5" id=""><span
                                                id="valid-conversion-payout-value"><?= number_format($commission[Orders::ORDER_COMPLETE], 0, ',', '.') ?></span></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Thành công</div>
                                </td>
                                <td class="border-r">
                                    <div class="t-report t-tran-pending h3 push-5" id=""><span
                                                id="pending-conversion-payout-value"><?= number_format($commission[Orders::ORDER_WAITFORPROCESS], 0, ',', '.') ?></span></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Chờ duyệt</div>
                                </td>
                                <td>
                                    <div class="t-report t-tran-cancel h3 push-5" id=""><span
                                                id="invalid-conversion-payout-value"><?= number_format($commission[Orders::ORDER_DESTROY], 0, ',', '.') ?></span></span>
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
        <div class="col-lg-3">
            <div class="block block-bordered">
                <div class="block-header">
                    <h3 class="block-title text-center">
                        <i class="fa fa-money"></i> Hoa hồng (₫)
                    </h3>
                </div>
                <div class="block-content">
                    <div class="pull-r-l pull-t">
                        <table class="block-table text-center bg-gray-lighter" style="table-layout:fixed;">
                            <tbody>
                            <tr>
                                <td class="border-r">
                                    <div class="t-report t-tran-success h3 push-5" id=""><span
                                                id="valid-conversion-payout-value"><?= number_format($commission[Orders::ORDER_COMPLETE], 0, ',', '.') ?></span><sup>₫</sup></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Thành công</div>
                                </td>
                                <td class="border-r">
                                    <div class="t-report t-tran-pending h3 push-5" id=""><span
                                                id="pending-conversion-payout-value"><?= number_format($commission[Orders::ORDER_WAITFORPROCESS], 0, ',', '.') ?></span><sup>₫</sup></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Chờ duyệt</div>
                                </td>
                                <td>
                                    <div class="t-report t-tran-cancel h3 push-5" id=""><span
                                                id="invalid-conversion-payout-value"><?= number_format($commission[Orders::ORDER_DESTROY], 0, ',', '.') ?></span><sup>₫</sup></span>
                                    </div>
                                    <div class="h6 text-muted text-uppercase push-5-t">Hủy</div>
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
        <ul class="nav nav-tabs" data-toggle="tabs" id="abc8">
            <li class="active" id="tour_tab_cvs">
                <a href="javascript:void(0)">Đơn hàng</a>
            </li>
            <li class="" id="tour_tab_cvs">
                <a href="javascript:void(0)">Yêu cầu giới thiệu</a>
            </li>
        </ul>
        <div class="block-content tab-content">
            <div class="tab-pane active" id="tabs1_conversion">
                <div align="right">
                    <div class="form-group">
                        <div class="btn-group">
                            <button class="btn btn-default" type="button" disabled="">Xuất báo cáo</button>
                            <a href="<?= Yii::app()->createUrl('affiliate/affiliate/exportReportOrder') ?>"
                               class="btn btn-default">.csv</a>
                        </div>
                    </div>
                </div>
                <div class="table_block">
                    <div class="table-responsive">
                        <div id="table-conversion-list_wrapper"
                             class="dataTables_wrapper form-inline dt-bootstrap dataTables_extended_wrapper no-footer">
                            <table class="table table-striped table-vcenter table-hover dataTable no-footer"
                                   id="table-conversion-list" role="grid" aria-describedby="table-conversion-list_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="STT">STT</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Thời gian">Thời
                                        gian
                                    </th>
                                    <th class="hidden-sm hidden-md hidden-xs sorting_disabled" rowspan="1" colspan="1"
                                        aria-label="Thời gian Click">Thời gian Click
                                    </th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Trạng thái">Trạng
                                        thái
                                    </th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Số lượng">Giá</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Số lượng">Số
                                        lượng
                                    </th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Hoa hồng">Hoa
                                        hồng
                                    </th>
                                </tr>
                                <?php
                                if (isset($orderItems) && $orderItems) {
                                    foreach ($orderItems as $item) {
                                        ?>
                                        <tr role="row" class="filter">
                                            <td rowspan="1" colspan="1"><?= $item['id'] ?></td>
                                            <td rowspan="1"
                                                colspan="1"><?= date('d-m-Y H:i', $item['created_time']) ?></td>
                                            <td class="hidden-sm hidden-md hidden-xs" rowspan="1"
                                                colspan="1"><?= date('d-m-Y H:i', $item['click_time']) ?></td>
                                            <td rowspan="1"
                                                colspan="1"><?= AffiliateOrder::getOrderStatusName($item['order_status']); ?></td>
                                            <td class="hidden-sm hidden-md hidden-xs" rowspan="1"
                                                colspan="1"><?= number_format($item['product_price'], 0, ',', '.') ?> đ
                                            </td>
                                            <td class="hidden-sm hidden-md hidden-xs" rowspan="1"
                                                colspan="1"><?= $item['product_qty'] ?></td>
                                            <td rowspan="1"
                                                colspan="1"><?= number_format($item['commission'], 0, ',', '.') ?> đ
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </thead>
                            </table>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>