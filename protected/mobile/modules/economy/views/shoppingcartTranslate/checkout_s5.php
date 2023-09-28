<div class="order-sale-page float-full pad-70-0">
    <div class="container">
        <div class="order-sale_s4 float-full">
            <div class="title-1 center">
                <h2><span><?= Yii::t('translate', 'your_order'); ?></span></h2>
                <div class="desc">
                    <p><?= Yii::t('translate', 'last_step'); ?> </p>
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
                <table style="margin-top: 40px" class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th class="col-1"><?= Yii::t('translate', 'file_name') ?></th>
                        <th class="col-2"><?= Yii::t('translate', 'file_type') ?></th>
                        <th class="col-3"><?= Yii::t('translate', 'words') ?></th>
                        <th class="col-3"><?= Yii::t('translate', 'delete') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($files) { ?>
                        <?php foreach ($files as $key => $value) { ?>
                            <tr>
                                <td class="file-name">
                                    <h4><?= $value['display_name'] ?></h4>
                                </td>
                                <td class="count-char"><?= $value['extension']; ?>  </td>
                                <td class="count-char"><?= $value['w_qty']; ?>  </td>
                                <td class="delete-file">
                                    <a onclick="return confirm('<?php echo Yii::t('translate', 'delete_words_from_cart_confirm'); ?>')"
                                       href="<?php echo $this->createUrl('/economy/shoppingcartTranslate/delete', array('key' => $key)); ?>">
                                        <i
                                                class="fa fa-close"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>

                    <?php } ?>
                    </tbody>
                </table>
                <div class="total">
                    <div class="left">
                        <p><?= Yii::t('translate', 'translate_from') . ': ' . ClaLanguage::getCountryName($shoppingCart->getFromLang()) ?></p>
                        <p><?= Yii::t('translate', 'service_option') . ': ' . TranslateLanguage::getOptionsName($shoppingCart->getOption()); ?></p>
                        <p><?= Yii::t('translate', 'number_of_language') . ': ' . count($langs) ?>:
                            <?php
                            foreach ($langs as $key => $lang) {
                                echo ClaLanguage::getCountryName($lang['to_lang']) . ', ';
                            }
                            ?>
                        </p>
                    </div>
                    <div class="right">
                        <p>
                            <?= Yii::t('common', 'total') . ': '; ?>
                            <span style="color: red">
                                <?= ($shoppingCart->getTotalPrice()) ? ($shoppingCart->getTotalPrice() . ' ' . $shoppingCart->getCurrency()) : Yii::t('site', 'contact'); ?>
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
                <div class="extra-information col-md-6">
                    <div class="title-1 center">
                        <h2><span><?= Yii::t('translate', 'advance_info') ?></span></h2>
                    </div>
                    <div class="content-extra">
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
                <div class="extra-information col-md-6">
                    <div class="title-1 center">
                        <h2><span><?= Yii::t('shoppingcart', 'billing-text') ?></span></h2>
                    </div>
                    <div class="content-extra">
                        <table class="table table-bordered">
                            <tbody>
                            <?php if ($shoppingCart->getTotalPrice()) { ?>
                                <tr>
                                    <td><?php echo $form->labelEx($model, 'payment_method'); ?></td>
                                    <td>
                                        <div class="list-payment standart-checkbox">
                                            <?php echo $form->radioButtonList($model, 'payment_method', TranslateOrder::getPaymentMethod()); ?>
                                            <?php echo $form->error($model, 'payment_method'); ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td><?php echo $form->labelEx($model, 'payment_method'); ?></td>
                                    <td>
                                        <div class="list-payment standart-checkbox">
                                            <?php echo $form->radioButtonList($model, 'payment_method', array(
                                                1 => Yii::t('translate', 'contact'),
                                                2 => Yii::t('translate', 'tranport')
                                            )); ?>
                                            <?php echo $form->error($model, 'payment_method'); ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="bottom-order-sale">
                        <div class="button-1">
                            <a href="<?= Yii::app()->createUrl('economy/shoppingcartTranslate/selectOption') ?>">
                                <button type="button"><?= Yii::t('translate', 'back'); ?></button>
                            </a>
                        </div>
                        <div class="button-2">
                            <?php echo CHtml::submitButton(Yii::t('shoppingcart', 'order_complete'), array('class' => 'btn button-2', 'id' => '', 'style' => '')); ?>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
                <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK7)); ?>
            </div>
        </div>
    </div>
</div>

	