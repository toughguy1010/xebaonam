<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'themes-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'theme_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'theme_id', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'theme_id'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'theme_name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'theme_name', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'theme_name'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'rules', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <div class="listcheck">
                    <?php
                    $checkall = ($model->isNewRecord && !$model->rules ) ? true : false;
                    if (!$checkall) {
                        $rules = json_decode($model->rules, true);
                    }
                    //
                    $menus = Themes::getMenuKeyArr();
                    foreach ($menus as $module => $info) {
                        $checked = false;
                        if (!$checkall) {
                            if (isset($rules[$module])) {
                                $checked = true;
                            }
                        }
                        ?>
                        <label class="labelcheckmenu">
                            <input <?php echo ($checkall || $checked) ? 'checked="checked"' : '' ?> type="checkbox" value="<?php echo $module; ?>" class="checkmenu" name="checkmenu[<?php echo $module; ?>][module]"> <?php echo $info['title']; ?>
                        </label>
                        <?php
                        foreach ($info['items'] as $skey => $sinfo) {
                            $checked2 = false;
                            if (isset($rules[$module][$skey]))
                                $checked2 = true;
                            ?>
                            <label class="labelcheckmenu">
                                <input <?php echo ($checkall || $checked2) ? 'checked="checked"' : '' ?> type="checkbox" value="<?php echo $skey; ?>" class="checkmenu" name="checkmenu[<?php echo $module; ?>][]"> <?php echo $sinfo['title']; ?>
                            </label>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('theme', 'theme_create') : Yii::t('theme', 'theme_update'), array('class' => 'btn btn-info', 'id' => 'savetheme')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->