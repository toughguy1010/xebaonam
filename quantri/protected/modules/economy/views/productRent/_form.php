<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'product-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        $from_create = Yii::app()->request->getParam('create');
        ?>

        <div class="tabbable">
            <ul class="nav nav-tabs padding-12" id="myTab">
                <li class="<?php if(!$from_create) echo 'active' ?>">
                    <a data-toggle="tab" href="#basicinfo">
                        <?php echo Yii::t('product', 'product_group_basicinfo'); ?>
                    </a>
                </li>
<!--                <li class="--><?php //if($from_create) echo 'active' ?><!--">-->
<!--                    <a data-toggle="tab" href="#products">-->
<!--                        --><?php //echo Yii::t('product', 'product_group_products'); ?>
<!--                    </a>-->
                </li>
            </ul>

            <div class="tab-content">
<!--                <div id="basicinfo" class="tab-pane --><?php //if(!$from_create) echo 'active' ?><!--">-->
                    <?php
                    $this->renderPartial('partial/tabbasicinfo', array('model' => $model, 'form' => $form));
                    ?>
<!--                </div>-->
<!--                <div id="products" class="tab-pane --><?php //if($from_create) echo 'active' ?><!--">-->
<!--                    --><?php
//                    $this->renderPartial('partial/products', array('model' => $model));
//                    ?>
<!--                </div>-->
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->