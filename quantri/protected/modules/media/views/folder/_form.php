<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'folders-form',
            'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'folder_name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'folder_name', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'folder_name'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'folder_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'folder_description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'folder_description'); ?>
            </div>
        </div>

        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('file', 'folder_create') : Yii::t('file', 'folder_edit'), array('class' => 'btn btn-info', 'id' => 'btnSaveFolder')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>
<script type="text/javascript">
<?php if (Yii::app()->request->isAjaxRequest) { ?>
            var formSubmit = true;
            jQuery('#folders-form').on('submit', function () {
                if (!formSubmit)
                    return false;
                formSubmit = false;
                var thi = jQuery(this);
                jQuery.ajax({
                    'type': 'POST',
                    'dataType': 'JSON',
                    'beforeSend': function () {
                        w3ShowLoading(jQuery('#btnSaveFolder'), 'right', 60, 0);
                    },
                    'url': thi.attr('action'),
                    'data': thi.serialize(),
                    'success': function (res) {
                        if (res.code != "200") {
                            if (res.errors) {
                                parseJsonErrors(res.errors);
                            }
                        } else {
                            jQuery.ajax({
                                'type': 'POST',
                                'dataType': 'JSON',
                                'url': '<?php echo Yii::app()->createUrl('suggest/suggest/folder'); ?>',
                                'success': function (res) {
                                    if (res.code == '200') {
                                        if (res.html)
                                            jQuery('#Files_folder_id').html(res.html);
                                        jQuery.colorbox.close();
                                    }
                                }
                            });
                        }
                        w3HideLoading();
                        formSubmit = true;
                    },
                    'error': function () {
                        w3HideLoading();
                        formSubmit = true;
                    }
                });
                return false;
            });
<?php } ?>
</script>