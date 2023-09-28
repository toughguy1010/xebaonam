<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'languages_map', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php
        $maxLang = 3;
        $languagesMap = array();
        if (!$model->isNewRecord) {
            $languagesMap = $model->getLanguagesMap();
        }
        for ($i = 1; $i <= $maxLang; $i++) {
            $selected = array();
            if (isset($languagesMap[$i - 1]) && $languagesMap[$i - 1]) {
                $selected[$languagesMap[$i - 1]] = array('selected' => 'selected');
            }
            echo "<div class='col-sm-4'> <span>Language $i: </span>";
            $this->widget('common.extensions.echosen.Chosen', array(
                'name' => "SitesAdmin[languages_map][$i]",
                'attribute' => "SitesAdmin[languages_map][$i]",
                //'multiple' => false,
                'placeholderMultiple' => $model->getAttributeLabel('languages_map'),
                'data' => array('' => '') + ClaSite::getLanguageSupport(),
                'htmlOptions' => array(
                    'class' => 'span12 col-sm-12',
                    'options' => $selected,
                ),
            ));
            echo "</div>";
        }
        ?>
        <?php echo $form->error($model, 'languages_map'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'storage_limit', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'storage_limit', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'storage_limit'); ?>
        </span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'fee_extend', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'fee_extend', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'fee_extend'); ?>
        </span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'fee_extend_text', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'fee_extend_text', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'fee_extend_text'); ?>
        </span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'expiration_date', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php
        $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
            'model' => $model, //Model object
            'name' => 'SitesAdmin[expiration_date]', //attribute name
            'mode' => 'date', //use "time","date" or "datetime" (default)
            'value' => ((int) $model->expiration_date > 0 ) ? date('d-m-Y H:i:s', (int) $model->expiration_date) : '',
            'language' => 'vi',
            'options' => array(
                'dateFormat' => 'dd-mm-yy',
                'timeFormat' => 'HH:mm:ss',
                'controlType' => 'select',
                //'stepHour' => 1,
                //'stepMinute' => 1,
                //'stepSecond' => 1,
                //'showOn' => 'button',
                'showSecond' => true,
                'changeMonth' => true,
                'changeYear' => true,
                'tabularLevel' => null,
            //'addSliderAccess' => true,
            //'sliderAccessArgs' => array('touchonly' => false),
            ), // jquery plugin options
            'htmlOptions' => array(
                'class' => 'span12 col-sm-12',
            )
        ));
        ?>
        <?php echo $form->error($model, 'expiration_date'); ?>
    </div>
</div>
<div class="control-group form-group buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'update') : Yii::t('common', 'update'), array('class' => 'btn btn-info')); ?>
</div>