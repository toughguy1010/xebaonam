<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'product-form',
            'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#settings">
                        <?php echo Yii::t('media', 'slider_setting'); ?>
                    </a>
                </li>

                <li class="">
                    <a data-toggle="tab" href="#slides">
                        <?php echo Yii::t('media', 'slider_slides'); ?>
                    </a>
                </li>

                <li class="">
                    <a data-toggle="tab" href="#functions" id="pro-att-t">
                        <?php echo Yii::t('media', 'slider_functions'); ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="settings" class="tab-pane active">
                    <?php
                    $this->renderPartial('partial/setting', array('model' => $model, 'SliderSetting' => $SliderSetting, 'form' => $form));
                    ?>
                </div>
                <div id="slides" class="tab-pane">
                     <?php
                    $this->renderPartial('partial/slide', array('model' => $model, 'SliderSetting' => $SliderSetting, 'form' => $form));
                    ?>
                </div>
                <div id="functions" class="tab-pane">
                    <?php
                    //$this->renderPartial('partial/tabattributes', array('model' => $model, 'productInfo' => $productInfo));
                    ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>