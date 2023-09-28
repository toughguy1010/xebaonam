<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'banners-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
        ));
        ?>
        <div class="tabbable">
            <!--            <ul class="nav nav-tabs" id="myTab">-->
            <!--                <li class="active">-->
            <!--                    <a data-toggle="tab" href="#basicinfo">-->
            <!--                        --><?php //echo Yii::t('product', 'product_basicinfo'); ?>
            <!--                    </a>-->
            <!--                </li>-->
            <!--            </ul>-->
            <div class="tab-content">
                <div id="basicinfo" class="tab-pane active">
                    <?php
                    $this->renderPartial('partial/tab_info', array('model' => $model, 'form' => $form));
                    ?>
                </div>
            </div>
        </div>
        <div class="control-group form-group buttons" style="border-bottom: none;">
            <?php
            echo CHtml::submitButton($model->isNewRecord ? Yii::t('banner', 'popup_create') : Yii::t('banner', 'popup_edit'),
                array('class' => 'btn btn-info', 'id' => 'savebanner'));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
