<div style="width: 400px; max-width: 100%; display:inline-block; padding-top: 25px;">
    <div class="col-xs-12 no-padding">
        <div class="  control-group form-group">
            <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-4 control-label no-padding-left')); ?>
            <div class="controls col-sm-8">
                <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>

        <div class="  control-group form-group">
            <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-4 control-label no-padding-left')); ?>
            <div class="controls col-sm-8">
                <?php echo $form->textField($model, 'address', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'address'); ?>
            </div>
        </div>

        <div class="  control-group form-group">
            <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-4 control-label no-padding-left')); ?>
            <div class="controls col-sm-8">
                <?php echo $form->textField($model, 'email', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>

        <div class="  control-group form-group">
            <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-4 control-label no-padding-left')); ?>
            <div class="controls col-sm-8">
                <?php echo $form->textField($model, 'phone', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'phone'); ?>
                <?php echo $form->hiddenField($model, 'latlng'); ?>
            </div>
        </div>
    </div>
</div><!-- form -->