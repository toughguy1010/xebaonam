<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'att-form',
            'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
            'enableAjaxValidation' => false,
        ));
        ?>
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#tab_basic_info">
                        <?php echo Yii::t('attribute', 'attribute_tab_basic_info'); ?>
                    </a>
                </li>

                <li class="">
                    <a data-toggle="tab" href="#tab_value">
                        <?php echo Yii::t('attribute', 'attribute_tab_value'); ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="tab_basic_info" class="tab-pane active">
                    <?php
                    $this->renderPartial('partial/tab_basic_info', array('model' => $model, 'form' => $form));
                    ?>
                </div>
                <div id="tab_value" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tab_value', array('model' => $model));
                    ?>
                </div>
            </div>
        </div>        
        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'create') : Yii::t('common', 'update'), array('class' => 'btn btn-info')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->