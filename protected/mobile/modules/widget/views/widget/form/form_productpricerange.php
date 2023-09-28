<style type="text/css">
    .action{display: inline-block; width: 100%;}
    .action-item  {
        position: relative;
        padding: 16px 15px;
        display: block;
        height: 0px;
        width: 32px;
        float: left;
        cursor: pointer;
    }
    .addattri::after {
        content: "";
        position: absolute;
        left: 27%;
        top: 48%;
        width: 50%;
        height: 10%;
        background: #000;
    }
    .addattri::before {
        content: "";
        position: absolute;
        left: 48%;
        top: 27%;
        width: 10%;
        height: 50%;
        background: #000;
    }
    .removeattri::after {
        content: "";
        position: absolute;
        left: 27%;
        top: 48%;
        width: 50%;
        height: 10%;
        background: #000;
    }

</style>
<script>
    jQuery(document).on('click', '.addattri', function() {
        var length = jQuery('#pricerange').find('.attributeitem').length;
        if (length == 1) {
            jQuery('#pricerange').find('.attributeitem').find('.removeattri').css({'display': 'block'});
        }
        var thi = jQuery(this);
        jQuery(thi).parents('.attributeitem').after('<div class="row attributeitem"><div class="col-xs-3"><input type="text" class="form-control" placeholder="price From" name="config_productpricerange[range][0][]"/></div><div class="col-xs-3"><input type="text" class="form-control" placeholder="price To" name="config_productpricerange[range][1][]"/></div><div class="col-xs-4"><input type="text" class="form-control" placeholder="price Text" name="config_productpricerange[range][priceText][]" /></div><div class="col-xs-2"><span class="help-inline action"><i class="action-item addattri icon-plus"></i><i class="action-item removeattri icon-minus"></i></span></div>');
        return false;
    });

    jQuery(document).on('click', '.removeattri', function() {
        var length = jQuery('#pricerange').find('.attributeitem').length;
        if (length > 1) {
            var thi = jQuery(this);
            jQuery(thi).parents('.attributeitem').remove();
            if (length == 2)
                jQuery('#pricerange').find('.attributeitem').find('.removeattri').fadeOut('fast');
        }
        return false;
    });
</script>
<div class="form" style="margin: 10px;">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'widget-config-form',
        'action' => Yii::app()->createUrl('widget/widget/saveconfig', array('pwid' => $model->page_widget_id)),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'form-horizontal widget-form'),
    ));
    ?>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'widget_title', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-9">
            <?php echo $form->textField($model, 'widget_title', array('class' => 'form-control ckeditor', 'style' => 'width: 100%;')); ?>
            <?php echo $form->error($model, 'widget_title'); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'summaryText', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-9">
            <?php echo $form->textField($model, 'summaryText', array('class' => 'form-control ckeditor', 'style' => 'width: 100%;')); ?>
            <?php echo $form->error($model, 'summaryText'); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'range', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-9" id="pricerange">
            <?php if ($model->range && count($model->range)) { ?>
                <?php foreach ($model->range as $range) { ?>
                    <div class="row attributeitem">
                        <div class="col-xs-3">
                            <input type="text" class="form-control" placeholder="price From" name="config_productpricerange[range][0][]" value="<?php echo $range[0]; ?>"/>
                        </div>
                        <div class="col-xs-3">
                            <input type="text" class="form-control" placeholder="price To" name="config_productpricerange[range][1][]" value="<?php echo $range[1]; ?>"/>
                        </div>
                        <div class="col-xs-4">
                            <input type="text" class="form-control" placeholder="price Text" name="config_productpricerange[range][priceText][]" value="<?php echo $range['priceText']; ?>"/>
                        </div>
                        <div class="col-xs-2">
                            <span class="help-inline action">
                                <i class="action-item addattri icon-plus"></i>
                                <i class="action-item removeattri icon-minus"></i>
                            </span>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="row attributeitem">
                <div class="col-xs-3">
                    <input type="text" class="form-control" placeholder="price From" name="config_productpricerange[range][0][]"/>
                </div>
                <div class="col-xs-3">
                    <input type="text" class="form-control" placeholder="price To" name="config_productpricerange[range][1][]"/>
                </div>
                <div class="col-xs-4">
                    <input type="text" class="form-control" placeholder="price Text" name="config_productpricerange[range][priceText][]" />
                </div>
                <div class="col-xs-2">
                    <span class="help-inline action">
                        <i class="action-item addattri icon-plus"></i>
                        <i class="action-item removeattri icon-minus"></i>
                    </span>
                </div>
            </div>

        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'show_wiget_title', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-9">
            <?php echo $form->checkBox($model, 'show_wiget_title'); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'showallpage', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-9">
            <?php echo $form->checkBox($model, 'showallpage'); ?>
        </div>
    </div>
    <div class="form-group buttons">
        <div class="col-sm-offset-3 col-sm-9">
            <?php echo CHtml::submitButton(Yii::t('common', 'save'), array('class' => 'btn btn-primary', 'id' => 'savewidgetconfig')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->