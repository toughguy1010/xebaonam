<div class="order-sale-page float-full pad-70-0">
    <div class="container">
        <div class="order-sale_s2 float-full">
            <div class="title-1 center">
                <h2><span><?= Yii::t('translate', 'complete_notice') ?></span></h2>
                <div class="desc">
                    <p><?= Yii::t('translate', 'thank_notice') ?></p>
                </div>
            </div>
            <div class="w3n-order content-order-sale-s4 float-full" style="min-width: 800px">
                <div class="content-order-sale-s2 float-full">
                    <div id="shopcart">
                    </div>
                </div>
                <div class="ctn-check-orderpaper">
                    <h2 style="text-transform: uppercase">CÔNG TY CỔ PHẦN EXPERTRANS TOÀN CẦU</h2>
                    <br>
                    <h3><?= Yii::t('translate', 'request_number') ?> <?= $interpretationOrder->id; ?></h3>
                    <div class="check-info-order">
                        <h4><?= Yii::t('translate', 'customer_infomation') ?></h4>
                        <ul style="list-style:none;list-style-type: none;padding: 0">
                            <li style="list-style-type: none"><b><?= Yii::t('translate', 'name') ?>
                                    : </b><?= $interpretationOrder['name'] ?></li>
                            <br>
                            <li style="list-style-type: none"><b><?= Yii::t('translate', 'email') ?>
                                    :</b> <?= $interpretationOrder['email'] ?></li>
                            <br>
                            <li style="list-style-type: none"><b><?= Yii::t('translate', 'tell') ?>
                                    :</b> <?= $interpretationOrder['tell'] ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <table style="margin-top: 40px" class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th class="col-1"><?= Yii::t('translate', 'from_lang') ?></th>
                        <th class="col-2"><?= Yii::t('translate', 'to_lang') ?></th>
                        <th class="col-3"><?= Yii::t('translate', 'interpretation_type') ?></th>
                        <th class="col-3"><?= Yii::t('translate', 'day') ?></th>
                        <th class="col-3"><?= Yii::t('translate', 'customer_infomation') ?></th>
                        <th class="col-3"><?= Yii::t('translate', 'total_price') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($items) {
                        $totalPrice = 0;
                        foreach ($items as $key => $value) {
                            $model = TranslateInterpretation::model()->findByPk($value['interpretation_id']);
                            ?>
                            <tr>
                                <td class="file-name">
                                    <h4><?= ClaLanguage::getCountryName($model->from_lang) ?></h4>
                                </td>
                                <td class="file-name">
                                    <h4><?= ClaLanguage::getCountryName($model->to_lang) ?></h4>
                                </td>
                                <td class="file-name">
                                    <h4>
                                        <?php if ($params['options'] == 1) {
                                            $txt = 'Escort Negotiation';
                                        } else if ($params['options'] == 2) {
                                            $txt = 'Consecutive Inter';
                                        } else {
                                            $txt = 'Simultaneous Inter';
                                        }
                                        echo $txt;
                                        ?>
                                    </h4>
                                </td>
                                <td class="file-name">
                                    <h4><?= $interpretationOrder['day'] ?></h4>
                                </td>
                                <td class="file-name">
                                    <h4>
                                        <?php if ($params['option'] == 1) {
                                            $price = $model->escort_negotiation_inter_price;
                                        } else if ($params['option'] == 2) {
                                            $price = $model->consecutive_inter_price;
                                        } else {
                                            $price = $model->simultaneous_inter_price;
                                        }
                                        echo HtmlFormat::money_format($price);
                                        ?>
                                    </h4>
                                </td>
                                <td class="file-name">
                                    <h4><?= HtmlFormat::money_format($interpretationOrder['day'] * $price) ?></h4>
                                </td>
                            </tr>
                            <?php
                            $totalPrice += $interpretationOrder['day'] * $price;
                        } ?>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="total">
                    <div class="right">
                        <p>
                            Tổng tiền:
                            <span style="color: red">
                                <?= ($interpretationOrder->total_price != '0.00') ? ($interpretationOrder->total_price) . ' ' . $interpretationOrder['currency'] : 'Vui lòng liên hệ' ?>
                            </span>
                        </p>
                    </div>
                </div>


                <?php
                if ($interpretationOrder->total_price == '0.00') {
                    ?>
                    <p style="color: red">
                        Với nhưng file không đúng định dạng hoặc hệ thông không thể đọc được xác từ ngữ chúng tôi sẽ
                        liên hệ báo giá lại vói quý khách sau khoảng 30 phút! Xin cám ơn!
                    </p>
                    <?php
                }
                ?>
                <style>
                    .table-bordered {
                        border: 1px solid #ddd;
                    }

                    .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
                        border: 1px solid #ddd;
                    }
                </style>
            </div>
            <div class="row">
                <div style="display: inline-block">
                    <div class="col-xs-6">
                        <div class="foot-check-orderpaper">
                            <a href="<?= Yii::app()->createUrl('economy/interpretation/printBill', array('id' => $interpretationOrder['id'], 'key' => $interpretationOrder['key'])) ?>"
                               id="" class="btn btn-info">
                                <i class="fa fa-print"></i>
                                <?= Yii::t('translate','print_bill')?>
                            </a>
                            <!--                            <a href="javascript:void(0)" id="printorder" class="btn btn-info">-->
                            <!--                                <i class="fa fa-print"></i>-->
                            <!--                                In thông tin đơn hàng-->
                            <!--                            </a>-->
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <a class="btn btn-info" href=""> <?= Yii::t('shoppingcart', 'back_to_home_page') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery('#printorder').on('click', function () {
        w = window.open();
        w.document.write($('.w3n-order').html());
        w.print();
        w.close();
    });
</script>
