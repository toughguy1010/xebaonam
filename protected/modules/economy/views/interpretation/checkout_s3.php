<div class="order-sale-page float-full pad-70-0">
    <div class="container">
        <div class="order-sale_s2 float-full">
            <div class="title-1 center">
                <h2><span style="text-transform: uppercase"><?= Yii::t('translate', 'six_step') ?></span></h2>
                <p><?= Yii::t('translate', 'step') ?> 1: <?= Yii::t('translate', 'select_country') ?></p>
            </div>
            <form action="<?= Yii::app()->createUrl('economy/interpretation/selectLang') ?>" method="get">
                <div class="content-order-sale-s2_2 float-full">
                    <div class="header-order-sale_s2_2">
                        <div class="row">
                            <div class="col-xs-3"></div>
                            <div class="col-xs-6">
                                <?php
                                $ct = ClaLocation::getCountries();
                                echo CHtml::dropDownList('lang_from', '', array('' => Yii::t('translate', 'select_country')) + $ct, array(
                                    'class' => 'wide select input-1',
                                    'id' => 'selectlang',
                                ));
                                ?>
                            </div>
                            <div class="col-xs-3"></div>
                        </div>
                    </div>
                </div>
                <div class="" style="text-align: center; margin:auto; margin-top: 20px">
                    <button type="submit" class="btn btn-success" style="margin-top: 30px">
                        <?= Yii::t('translate', 'next_step') ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
