<?php
/* @var $this MenuController */
/* @var $model Menus */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-xs-12 no-padding">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'menus-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'menu_group', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownlist($model, 'menu_group', Menus::getMenuGroupArr(), array('class' => 'span12 col-sm-12', 'disabled' => 'disabled')); ?>
                <?php echo $form->error($model, 'menu_group'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'menu_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'menu_title', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'menu_title'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'parent_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'parent_id', $options, array('class' => 'span12 col-sm-12', 'disable' => 'disable')); ?>
                <?php echo $form->error($model, 'parent_id'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'menu_linkto', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php
                echo $form->radioButtonList($model, 'menu_linkto', Menus::getLinkToArr(), array(
                    'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                    'labelOptions' => array('style' => 'display:inline'),
                    'class' => 'linkto',
                        )
                );
                ?>
                <?php echo $form->error($model, 'menu_linkto'); ?>
            </div>
        </div>

        <div class="control-group form-group" style="<?php echo ($model->menu_linkto == Menus::LINKTO_INNER) ? 'display: block' : 'display: none'; ?>">
            <?php echo $form->labelEx($model, 'menu_link', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'menu_values', Menus::getInnerLinks(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'menu_values'); ?>
            </div>
        </div>

        <div class="control-group form-group" style="<?php echo ($model->menu_linkto == Menus::LINKTO_OUTER) ? 'display: block' : 'display: none'; ?>">
            <?php echo $form->labelEx($model, 'menu_link', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'menu_link', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'menu_link'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'menu_order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'menu_order', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'menu_order'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'menu_target', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownlist($model, 'menu_target', Menus::getTagetArr(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'menu_target'); ?>
            </div>
        </div>

        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('menu', 'menu_create') : Yii::t('menu', 'menu_update'), array('class' => 'btn btn-info')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->
<script>
    jQuery('input.linkto').change(function() {
        var val = jQuery(this).val();
        if (val ==<?php echo Menus::LINKTO_OUTER ?>) {
            jQuery('#Menus_menu_link').closest('.control-group').show();
            jQuery('#Menus_menu_values').closest('.control-group').hide();
        } else {
            jQuery('#Menus_menu_link').closest('.control-group').hide();
            jQuery('#Menus_menu_values').closest('.control-group').show();
        }
    });
</script>