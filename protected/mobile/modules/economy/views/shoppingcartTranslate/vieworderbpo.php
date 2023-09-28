<div class="order-sale-page float-full pad-70-0">
    <div class="container">
        <div class="order-sale_s2 float-full">
            <div class="title-1 center">
                <h2><span><?= Yii::t('translate', 'complete_notice') ?></span></h2>
                <div class="desc">
                    <p><?= Yii::t('translate', 'thank_notice') ?></p>
                </div>
            </div>
            <div class="w3n-order content-order-sale-s4 float-full">
                <div class="content-order-sale-s2 float-full">
                    <div id="shopcart">
                        <?php
                        $shoppingCart = Yii::app()->customer->getShoppingCartTranslate();
                        $langs = $shoppingCart->getLangs();
                        $files = $shoppingCart->getFiles();
                        ?>
                    </div>
                </div>
                <div class="ctn-check-orderpaper" style="text-align: center">
                    <h2 style="text-transform: uppercase">CÔNG TY CỔ PHẦN EXPERTRANS TOÀN CẦU</h2>
                    <br>
                    <div class="check-info-order">
                        <h4><?= Yii::t('translate', 'customer_infomation') ?></h4>
                        <table class="table-bordered">
                            <tr>
                                <td><?= $model->getAttributeLabel('name') ?>:</td>
                                <td><?= $model['name'] ?></td>
                            </tr>
                            <tr>
                                <td><?= $model->getAttributeLabel('email') ?>:</td>
                                <td><?= $model['email'] ?></td>
                            </tr>
                            <tr>
                                <td><?= $model->getAttributeLabel('phone') ?>:</td>
                                <td><?= $model['phone'] ?></td>
                            </tr>
                            <tr>
                                <td><?= $model->getAttributeLabel('company') ?>:</td>
                                <td><?= $model['company'] ?></td>
                            </tr>
                            <tr>
                                <td><?= $model->getAttributeLabel('country') ?>:</td>
                                <td> <?= ClaLocation::getCountryName($model['country']) ?></td>
                            </tr>
                            <tr>
                                <td><?= $model->getAttributeLabel('service') ?></td>
                                <td><?= $model['service'] ?></td>
                            </tr>
                            <tr>
                                <td><?= $model->getAttributeLabel('currency') ?></td>
                                <td><?= $model['currency'] ?></td>
                            </tr>
                            <tr>
                                <td><?= $model->getAttributeLabel('payment_method') ?></td>
                                <td><?= TranslateOrder::getPaymentMethod()[$model['payment_method']] ?></td>
                            </tr>
                            <tr>
                                <td><?= $model->getAttributeLabel('note') ?></td>
                                <td><?= $model['note'] ?></td>
                            </tr>
                        </table>
                    </div>
                    <p><?= Yii::t('translate','bpo_bill_note')?></p>
                    <a class="btn btn-info" href=""><?= Yii::t('shoppingcart','back_to_home_page')?></a>
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
<style>
    tr td:first-child {
        font-weight: bold;
    }

    .table-bordered {
        border: 1px solid #ddd;
    }

    .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
        border: 1px solid #ddd;
    }
</style>
