<?php
$f = $model->getConfig();
?>
<div class="widget widget-box">
    <div class="widget-header">
        <h4><?= Yii::t('affilliate', 'affilliate_config') ?></h4>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'user-model-form',
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'htmlOptions' => array(
                            'class' => 'form-horizontal',
                        ),
                    ));
                    ?>
                    <div class="profileif">
                        <?php for ($i = 0; $i < 6; $i++) {  ?>
                            <div class="control-group form-group">
                                <label class="control-label col-sm-2 error required" for="AffConfigs_configs">Cấu hình cho F<?= $i ?> <span class="required">*</span></label>
                                <div class="controls col-sm-10 error">
                                    <input class="span9 form-control" name="configs[<?= $i ?>]" value="<?= $f[$i] ?>" type="number">
                                </div>
                            </div>
                        <?php } ?>
                        <div class="control-group form-group buttons">
                            <div class="col-sm-offset-2 col-sm-10">
                                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'create') : Yii::t('common', 'save'), array('class' => 'btn btn-info')); ?>
                            </div>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>