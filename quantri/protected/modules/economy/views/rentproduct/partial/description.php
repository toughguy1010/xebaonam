<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'sortdesc', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <input name="us-ck" type="checkbox" id="ck-check" value="" style="">
        <label for="ck-check" style="font-size: 12px;color: blue;pointer:cursor">Sử dụng
            trình soạn thảo</label>
        <?php echo $form->textArea($model, 'sortdesc', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'sortdesc'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <div class="span12">
            <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
            <?php echo $form->error($model, 'description'); ?>
        </div>
    </div>
</div>