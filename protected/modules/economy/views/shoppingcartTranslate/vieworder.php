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
                        <?php
                        $shoppingCart = Yii::app()->customer->getShoppingCartTranslate();
                        $langs = $shoppingCart->getLangs();
                        $files = $shoppingCart->getFiles();
                        ?>
                    </div>
                </div>
                <div class="ctn-check-orderpaper">
                    <h2 style="text-transform: uppercase">CÔNG TY CỔ PHẦN EXPERTRANS TOÀN CẦU</h2>
                    <br>
                    <h3><?= Yii::t('translate', 'request_number') ?><?= $translateOrder['id']; ?></h3>
                    <div class="check-info-order">
                        <h4><?= Yii::t('translate', 'customer_infomation') ?></h4>
                        <ul style="list-style:none;list-style-type: none;padding: 0">
                            <li style="list-style-type: none"><b><?= Yii::t('translate', 'name'); ?>
                                    : </b><?= $translateOrder['name'] ?></li>
                            <br>
                            <li style="list-style-type: none"><b><?= Yii::t('translate', 'email'); ?>
                                    :</b> <?= $translateOrder['email'] ?></li>
                            <br>
                            <li style="list-style-type: none"><b><?= Yii::t('translate', 'tell'); ?>
                                    :</b> <?= $translateOrder['tell'] ?></li>
                            <br>
                            <li style="list-style-type: none"><b><?= Yii::t('shoppingcart', 'payment_method'); ?>
                                    :</b> <?= TranslateOrder::getPaymentMethod()[$translateOrder['payment_method']] ?>
                            </li>
                            <br>
                            <li style="list-style-type: none"><b><?= Yii::t('shoppingcart', 'payment_status'); ?>
                                    :</b> <?= TranslateOrder::getPaymentStatus()[$translateOrder['payment_status']] ?>
                            </li>
                        </ul>
                    </div>
                </div>

                <table style="margin-top: 40px;min-width: 800px" class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th class="col-3"><?= Yii::t('translate', 'translate') ?></th>
                        <th class="col-1"><?= Yii::t('translate', 'file_name') ?></th>
                        <th class="col-3"><?= Yii::t('translate', 'type') ?></th>
                        <th class="col-3"><?= Yii::t('translate', 'words') ?></th>
                        <th class="col-3"><?= Yii::t('translate', 'total_price') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($items) {

                        ?>
                        <?php foreach ($items as $key => $value) { ?>
                            <tr>

                                <td class="count-char"><?= ClaLanguage::getCountryName($value['from']) . ' -> ' . ClaLanguage::getCountryName($value['to']); ?> </td>
                                <td class="file-name">
                                    <?php
                                    $files = json_decode($value['file']);
                                    foreach ($files as $key => $file) {
                                        echo '<p><a target="_blank" href="' . Yii::app()->createUrl('economy/shoppingcartTranslate/downloadfile', array('id' => $key)) . '">' . $file->display_name . '</a></p>';
                                    }
                                    ?>
                                </td>
                                <td class="count-char"><?= TranslateLanguage::getOptionsName($value['option']); ?>  </td>
                                <td class="count-char"><?= $value['words']; ?>  </td>
                                <td class="count-char"><?= ($value['price'] != '0.00') ? HtmlFormat::money_format($value['price']) . ' ' . $value['currency'] : 'Liên hệ'; ?>  </td>
                            </tr>
                        <?php } ?>

                    <?php } ?>
                    </tbody>
                </table>
                <div class="total">
                    <div class="left">
                        <p><?= Yii::t('translate', 'translate_from') ?><?= ClaLanguage::getCountryName($shoppingCart->getFromLang()) ?></p>
                        <p><?= Yii::t('translate', 'number_of_language') ?><?= count($items) ?>
                        </p>
                    </div>
                    <div class="right">
                        <p>
                            <?= Yii::t('common', 'total') . ': '; ?>
                            <span style="color: red">
                                <?= ($translateOrder->total_price != '0.00') ? ($translateOrder->total_price) . ' ' . $translateOrder['currency'] : Yii::t('translate', 'contact') ?>
                            </span>
                        </p>
                    </div>
                </div>
                <?php
                if ($translateOrder->total_price == '0.00') {
                    ?>
                    <p style="color: red">
                        <?= Yii::t('translate', 'order_notice') ?>
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
                            <a href="<?= Yii::app()->createUrl('economy/shoppingcartTranslate/printBill', array('id' => $translateOrder['id'], 'key' => $translateOrder['key'])) ?>"
                               id="" class="btn btn-info">
                                <i class="fa fa-print"></i>
                                <?= Yii::t('translate', 'print_bill') ?>
                            </a>
                            <!--                            <a href="javascript:void(0)" id="printorder" class="btn btn-info">-->
                            <!--                                <i class="fa fa-print"></i>-->
                            <!--                                In thông tin đơn hàng-->
                            <!--                            </a>-->
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <a class="btn btn-info" href=""><?= Yii::t('shoppingcart', 'back_to_home_page') ?></a>
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
