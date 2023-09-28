<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'layout_action', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <span style="color:blue;font-size: 11"></span>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'layout_action', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'layout_action'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'view_action', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <span></span>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'view_action', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'view_action'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'news_category_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'news_category_id', $news_category, array('class' => 'span10 col-sm-12',)); ?>
        <?php echo $form->error($model, 'news_category_id'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'custom_number_1', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'custom_number_1', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'custom_number_1'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'custom_number_2', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'custom_number_2', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'custom_number_2'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'custom_number_3', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'custom_number_3', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'custom_number_3'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'custom_number_4', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'custom_number_4', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'custom_number_4'); ?>
    </div>
</div>


<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'email', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'facebook', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'facebook', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'facebook'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'youtube', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'youtube', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'youtube'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'hotline', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'hotline', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'hotline'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'short_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'short_description', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'short_description'); ?>
    </div>
</div>