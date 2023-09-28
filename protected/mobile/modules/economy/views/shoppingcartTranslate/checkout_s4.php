<?php
$shoppingCart = Yii::app()->customer->getShoppingCartTranslate();
$langs = $shoppingCart->getLangs();
$files = $shoppingCart->getFiles();
?>
<div class="order-sale-page float-full pad-70-0">
    <div class="container">
        <div class="order-sale_s3 float-full">
            <div class="title-1 center">
                <h2><span><?= Yii::t('translate', 'translation_quality') ?></span></h2>
                <div class="desc">
                    <p><?= Yii::t('translate', '3_service') ?></p>
                </div>
            </div>
            <div class="content-order-sale-s3 float-full">
                <div class="list-price-pack">
                    <ul>
                        <li>
                            <div class="img-title-pack">
                                <div class="img-pack">
                                    <img src="<?php echo Yii::app()->theme->baseUrl . '/demo/images/price-1.png' ?>"
                                         class="img-responsive" alt="Image">
                                </div>
                                <div class="title-pack">
                                    <h4><?= Yii::t('translate', 'standard_pack') ?></h4>
                                </div>
                            </div>
                            <?php
                            $i = 0;
                            if (count($langs)) {
                                foreach ($langs as $lang) {
                                    if (++$i > 1) {
                                        continue;
                                    }
                                    ?>
                                    <div class="price-pack">
                                        <p><?= $lang['price'] . ' ' . $lang['currency'] ?>
                                            / <?= Yii::t('translate', 'from') ?></p>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <div class="desc-pack">
                                <p><?= Yii::t('translate', 'translator_level') ?>:<?= Yii::t('translate', 'standard') ?>
                                    .</p>
                                <p><?= Yii::t('translate', 'apply_for') ?>
                                    : <?= Yii::t('translate', 'apply_for_standard') ?></p>
                                <div class="select-pack">
                                    <a href="<?= Yii::app()->createUrl('economy/shoppingcartTranslate/selectOption', array('option' => 1)) ?>">
                                        <?= Yii::t('translate', 'select_service') ?>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="img-title-pack">
                                <div class="img-pack">
                                    <img src="<?php echo Yii::app()->theme->baseUrl . '/demo/images/price-2.png' ?>"
                                         class="img-responsive" alt="Image">
                                </div>
                                <div class="title-pack">
                                    <h4><?= Yii::t('translate', 'business_pack') ?></h4>
                                </div>
                            </div>
                            <?php
                            $i = 0;
                            if (count($langs)) {
                                foreach ($langs as $lang) {
                                    if (++$i > 1) {
                                        continue;
                                    }
                                    ?>
                                    <div class="price-pack">
                                        <p><?= $lang['price_business'] . ' ' . $lang['currency'] ?>
                                            / <?= Yii::t('translate', 'from') ?></p>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <div class="desc-pack">
                                <p><?= Yii::t('translate', 'translator_level') ?>: <?= Yii::t('translate', 'exactly') ?>
                                    .</p>
                                <p><?= Yii::t('translate', 'apply_for') ?>
                                    : <?= Yii::t('translate', 'apply_for_business') ?></p>
                                <div class="select-pack">
                                    <a href="<?= Yii::app()->createUrl('economy/shoppingcartTranslate/selectOption', array('option' => 2)) ?>">
                                        <?= Yii::t('translate', 'select_service') ?>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="img-title-pack">
                                <div class="img-pack">
                                    <img src="<?php echo Yii::app()->theme->baseUrl . '/demo/images/price-3.png' ?>"
                                         class="img-responsive" alt="Image">
                                </div>
                                <div class="title-pack">
                                    <h4><?= Yii::t('translate', 'advanced_pack') ?></h4>
                                </div>
                            </div>
                            <div class="price-pack">
                                <p><?= Yii::t('translate', 'contact') ?></p>
                            </div>
                            <div class="desc-pack">
                                <p><?= Yii::t('translate', 'translator_level') ?>
                                    : <?= Yii::t('translate', 'advanced') ?>.</p>
                                <p><?= Yii::t('translate', 'apply_for') ?>
                                    : <?= Yii::t('translate', 'apply_for_advance') ?></p>
                                <div class="select-pack">
                                    <a href="<?= Yii::app()->createUrl('economy/shoppingcartTranslate/selectOption', array('option' => 3)) ?>">
                                        <?= Yii::t('translate', 'select_service') ?>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="bottom-order-sale">
                    <div class="button-1">
                        <a href="<?= Yii::app()->createUrl('economy/shoppingcartTranslate/selectLang') ?>">
                            <button><?= Yii::t('translate', 'back') ?></button>
                    </div>
                </div>
                <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK7)); ?>
            </div>
        </div>
    </div>
</div>
<style>
    .list-price-pack ul li {
        width: 100%;
    }
</style>
	