<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'price', array('class' => 'numberFormat span2 col-sm-2')); ?>
        <?php echo $form->error($model, 'price', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'number_plate_fee', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'number_plate_fee', array('class' => 'numberFormat span2 col-sm-2')); ?>
        <?php echo $form->error($model, 'number_plate_fee', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'registration_fee', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'registration_fee', array('class' => 'numberFormat span2 col-sm-2')); ?>
        <?php echo $form->error($model, 'registration_fee', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'inspection_fee', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'inspection_fee', array('class' => 'numberFormat span2 col-sm-2')); ?>
        <?php echo $form->error($model, 'inspection_fee', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'road_toll', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'road_toll', array('class' => 'numberFormat span2 col-sm-2')); ?>
        <?php echo $form->error($model, 'road_toll', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'insurance_fee', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'insurance_fee', array('class' => 'numberFormat span2 col-sm-2')); ?>
        <?php echo $form->error($model, 'insurance_fee', array(), true, false); ?>
    </div>
</div>