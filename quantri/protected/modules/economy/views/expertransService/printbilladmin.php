<div class="width-form-hd">
    <div class="page-detail-video">
        <div class="detail-video">
            <div class="container">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-hd">
                        <div class="logo-form-hd">
                            <div class="img-form-hd">
                                <img height="120px" src="<?php echo Yii::app()->siteinfo['site_logo'] ?>">
                            </div>
                            <div class="des-form-hd">
                                <h2> <?php echo Yii::app()->siteinfo['site_title'] ?></h2>
                                <p><?= strip_tags( Yii::app()->siteinfo['contact'])?></p>
                            </div>
                        </div>
                        <div class="ctn-form-hd">
                            <h2>Phiếu xác nhận giao hàng</h2>
                            <form>
                                <div class="form-item-hd width-50 border-tab">
                                    <label>Tên khách hàng: </label>
                                    <p><?php echo $model['billing_name'] ?></p>
                                </div>
                                <div class="form-item-hd width-50">
                                    <label>Điện thoại: </label>
                                    <p><?php echo $model['billing_phone'] ?></p>
                                </div>
                                <div class="form-item-hd">
                                    <label>Địa chỉ nhà: </label>
                                    <p> <?php echo $model['billing_address'] ?></p>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th> <?php echo Yii::t('shoppingcart', 'product_name'); ?></th>
                                            <th><?php echo Yii::t('shoppingcart', 'bill_product_quantity'); ?></th>
                                            <th><?php echo Yii::t('shoppingcart', 'Số IMEI/SN (Mã SP)'); ?></th>
                                            <th><?php echo Yii::t('shoppingcart', 'bill_product_price'); ?></th>
                                            <th><?php echo Yii::t('shoppingcart', 'bill_product_total'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $n = 0;
                                        foreach ($products as $product) { ?>
                                            <tr>
                                                <td>
                                                    <?php echo ++$n; ?>
                                                </td>
                                                <td>
                                                    <?php echo $product["name"]; ?>
                                                </td>
                                                <td style="">
                                                    <?php echo($product["product_qty"]); ?>
                                                </td>
                                                <td style="">
                                                    <?php echo($product["code"]); ?>
                                                </td>

                                                <td><?php echo Product::getPriceText($product); ?></td>
                                                <td><?php echo Product::getTotalPrice($product, $product["product_qty"]); ?></td>
                                            </tr>
                                        <?php }; ?>
                                        <tr>
                                            <td class="span-b" colspan="3" rowspan="4"></td>
                                            <td  rowspan="4"> </td>
                                            <td style="font-weight: bold; text-align: right">1. Tổng giá</td>
                                            <td><?php echo Product::getPriceText(array('price' => $model['old_order_total'])); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold; text-align: right">2. Giảm giá (<?php echo $model['discount_percent'].' %'; ?>)</td>
                                            <td><?php echo Product::getPriceText(array('price' => $model['discount_for_dealers'])); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold; text-align: right">3. Phí vận chuyển</td>
                                            <td><?php echo Product::getPriceText(array('price' => $model['transport_freight'])); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold; text-align: right">Tổng cộng (1-2+3)</td>
                                            <td><?php echo Product::getPriceText(array('price' => $model['order_total'])); ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="note-form-hd">
                                    <div class="note-item">
                                        <p>
                                            Nhân viên bán hàng <span>(Ký, ghi rõ họ tên)</span>
                                        </p>
                                    </div>
                                    <div class="note-item">
                                        <p>
                                            Kế toán <span>(Ký, ghi rõ họ tên)</span>
                                        </p>
                                    </div>
                                    <div class="note-item">
                                        <p>
                                            Thủ kho <span>(Ký, ghi rõ họ tên)</span>
                                        </p>
                                    </div>
                                    <div class="note-item">
                                        <p>
                                            Xác nhận của khách hàng <span>(Ký, ghi rõ họ tên)</span>
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <style type="text/css">
                        @import url('https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&subset=latin-ext,vietnamese');

                        .width-form-hd {
                            margin: 0 auto;
                            width: 1000px;
                        }

                        .form-hd {
                            padding: 4%;
                            float: left;
                            width: 100%;
                            background: #fff;
                        }

                        .table-responsive {
                            margin-top: 25px;
                        }

                        .logo-form-hd {
                            float: left;
                            width: 100%;
                            margin-bottom: 30px;
                        }

                        .img-form-hd {
                            float: left;
                            margin-right: 20px;
                        }

                        .des-form-hd h2 {
                            font-weight: 600;
                            font-size: 16px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                            margin-bottom: 6px;
                            margin-top: 0px;
                        }

                        .des-form-hd {
                            margin-top: 15px;
                        }

                        .des-form-hd p {
                            font-size: 14px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                            margin: 0px;
                            margin-bottom: 6px;
                        }

                        .ctn-form-hd {
                            float: left;
                            width: 100%;
                        }

                        .ctn-form-hd h2 {
                            font-weight: 900;
                            font-size: 19px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                            text-align: center;
                            margin-top: 20px;
                            margin-bottom: 30px;
                        }

                        .form-item-hd {
                            float: left;
                            width: 100%;
                            margin-bottom: 10px;
                            display: flex;
                            overflow: hidden;
                            box-sizing: border-box;
                        }

                        .border-tab {
                            border-right: 20px solid #fff;
                        }

                        .form-item-hd label {
                            float: left;
                            margin-right: 10px;
                            font-size: 15px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                            white-space: nowrap;
                        }

                        .form-item-hd p {
                            float: left;
                            font-weight: 400;
                            font-size: 15px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                            margin: 0px;
                        }

                        .width-50 {
                            width: 50%;
                            float: left;
                        }

                        .table-responsive {
                            min-height: .01%;
                            overflow-x: auto;
                            float: left;
                            width: 100%;
                            font-size: 14px;
                            text-align: center;
                        }

                        .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
                            border-bottom-width: 2px;
                            text-align: center;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                        }

                        .span-b {
                            font-weight: 600;
                            font-size: 15px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                        }

                        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                            padding: 8px;
                            line-height: 1.42857143;
                            vertical-align: top;
                            border-top: 1px solid #ddd;
                        }

                        .table > thead > tr > th {
                            vertical-align: bottom;
                            border-bottom: 2px solid #ddd;
                        }

                        .table > caption + thead > tr:first-child > td, .table > caption + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table > thead:first-child > tr:first-child > th {
                            border-top: 0;
                        }

                        .table-bordered {
                            border: 1px solid #4a4646;
                        }

                        .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
                            border: 1px solid #4a4646;
                        }

                        .note-form-hd {
                            float: left;
                            width: 100%;
                            margin-top: 20px;
                            margin-bottom: 30px;
                        }

                        .note-item {
                            float: left;
                            width: 25%;
                            text-align: center;
                        }

                        .note-item p {
                            display: block;
                            font-weight: 600;
                            font-style: italic;
                            font-size: 15px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                        }

                        .note-item p span {
                            display: block;
                            font-weight: 300;
                            font-size: 15px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                        }

                        .table {
                            text-align: center;
                            width: 100%;
                            max-width: 100%;
                            margin-bottom: 20px;
                            font-weight: 300;
                            font-size: 15px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                        }

                        .table a {
                            font-weight: 300;
                            font-size: 15px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                            color: #333;
                            text-decoration: none;
                        }

                        table {
                            border-spacing: 0;
                            border-collapse: collapse
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>
</div>
