<div class="order-sale-page float-full pad-70-0">
    <div class="container">
        <div class="order-sale_s4 float-full">
            <div class="title-1 center">
                <h2><span><?= Yii::t('translate', 'six_step') ?></span></h2>
                <div class="desc">
                    <p><?= Yii::t('translate', 'confirm') ?></p>
                </div>
            </div>
            <div class="content-order-sale-s4 float-full">
                <div class="content-order-sale-s2 float-full">
                    <div id="shopcart">
                        <?php
                        $shoppingCart = Yii::app()->customer->getShoppingCartTranslate();
                        $langs = $shoppingCart->getLangs();
                        $files = $shoppingCart->getFiles();
                        ?>
                    </div>
                </div>
                <div class="table-responsive">
                    <table style="margin-top: 40px" class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th><?= Yii::t('translate', 'from_lang') ?></th>
                            <th><?= Yii::t('translate', 'to_lang') ?></th>
                            <th><?= Yii::t('translate', 'interpretation_type') ?></th>
                            <th><?= Yii::t('translate', 'number_day') ?></th>
                            <th><?= Yii::t('translate', 'price_per_day') ?></th>
                            <th><?= Yii::t('translate', 'total_price') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $totalPrice = 0;
                        if ($list_lang) { ?>
                            <?php foreach ($list_lang as $key => $value) { ?>
                                <tr>
                                    <td class="file-name">
                                        <h4><?= ClaLanguage::getCountryName($value->from_lang) ?></h4>
                                    </td>
                                    <td class="file-name">
                                        <h4><?= ClaLanguage::getCountryName($value->to_lang) ?></h4>
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
                                        <h4><?= $params['day'] ?></h4>
                                    </td>
                                    <td class="file-name">
                                        <h4>
                                            <?php if ($params['option'] == 1) {
                                                $price = $value->escort_negotiation_inter_price;
                                            } else if ($params['option'] == 2) {
                                                $price = $value->consecutive_inter_price;
                                            } else {
                                                $price = $value->simultaneous_inter_price;
                                            }
                                            echo HtmlFormat::money_format($price);
                                            ?>
                                        </h4>
                                    </td>
                                    <td class="file-name">
                                        <h4><?= HtmlFormat::money_format($params['day'] * $price) ?></h4>
                                    </td>
                                </tr>
                                <?php
                                $totalPrice += $params['day'] * $price;
                            } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="total">
                    <div class="right">
                        <p>
                            <?= Yii::t('translate','total')?>:
                            <span style="color: red">
                                <?= HtmlFormat::money_format($totalPrice) . ' USD'; ?>
                            </span>
                        </p>
                    </div>
                </div>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'action' => '',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'htmlOptions' => array('class' => 'form-horizontal widget-form'),
                ));
                ?>
                <div class="extra-information col-md-6 col-xs-12">
                    <div class="title-1 center">
                        <h2><span><?= Yii::t('translate', 'advance_info') ?></span></h2>
                    </div>
                    <div class="content-extra ">
                        <table class="table table-bordered">
                            <tbody>

                            <tr>
                                <td><?php echo $form->labelEx($model, 'name'); ?></td>
                                <td>
                                    <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('name'), 'title' => $model->getAttributeLabel('name'))); ?>
                                    <?php echo $form->error($model, 'name'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $form->labelEx($model, 'email'); ?></td>
                                <td>
                                    <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('email'), 'title' => $model->getAttributeLabel('email'))); ?>
                                    <?php echo $form->error($model, 'email'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $form->labelEx($model, 'tell'); ?></td>
                                <td>
                                    <?php echo $form->textField($model, 'tell', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('tell'), 'title' => $model->getAttributeLabel('tell'))); ?>
                                    <?php echo $form->error($model, 'tell'); ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="extra-information col-md-6 col-xs-12">
                    <div class="title-1 center">
                        <h2><span><?= Yii::t('translate', 'payment_info') ?></span></h2>
                    </div>
                    <div class="content-extra">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td><?php echo $form->labelEx($model, 'payment_method'); ?></td>
                                <td>
                                    <div class="list-payment standart-checkbox">
                                        <?php echo $form->radioButtonList($model, 'payment_method', TranslateOrder::getPaymentMethod()); ?>
                                        <?php echo $form->error($model, 'payment_method'); ?>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="bottom-order-sale">
                        <div class="button-1">
                            <a href="<?= Yii::app()->createUrl('economy/shoppingcartTranslate/selectOption') ?>">
                                <button type="button">   <?= Yii::t('translate', 'back') ?></button>
                            </a>
                        </div>
                        <div class="button-2">
                            <?php echo CHtml::submitButton(Yii::t('translate', 'next_step'), array('class' => 'btn button-2', 'id' => '', 'style' => '')); ?>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

