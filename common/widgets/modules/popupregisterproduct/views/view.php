<?php 
	$form = $this->beginWidget('CActiveForm', array(
	    'enableAjaxValidation' => false,
	    'enableClientValidation' => true,
	    'action' => Yii::app()->createUrl('/economy/popupregisterproduct/creater', ['popup_id' => $popup['id']]),
	    'htmlOptions' => array(
	        'class' => 'form-horizontal',
			'id' => 'form_regiters-form',
	    ),
	));
	?>
	<div class="regis control-group form-group">
	    <?php echo $form->labelEx($form_regiters, 'name', array('class' => 'col-sm-3 control-label ')); ?>
	    <div class="controls col-sm-9">
	        <?php echo $form->textField($form_regiters, 'name', array('class' => 'span9 form-control')); ?>
	        <?php echo $form->error($form_regiters, 'name'); ?>
	    </div>
	</div>
	<div class="regis control-group form-group">
	    <?php echo $form->labelEx($form_regiters, 'phone', array('class' => 'col-sm-3 control-label ')); ?>
	    <div class="controls col-sm-9">
	        <?php echo $form->textField($form_regiters, 'phone', array('class' => 'span9 form-control')); ?>
	        <?php echo $form->error($form_regiters, 'phone'); ?>
	    </div>
	</div>
	<div class="regis control-group form-group">
	    <?php echo $form->labelEx($form_regiters, 'email', array('class' => 'col-sm-3 control-label ')); ?>
	    <div class="controls col-sm-9">
	        <?php echo $form->textField($form_regiters, 'email', array('class' => 'span9 form-control')); ?>
	        <?php echo $form->error($form_regiters, 'email'); ?>
	    </div>
	</div>
	<div class="regis control-group form-group">
	    <?php echo $form->labelEx($form_regiters, 'note', array('class' => 'col-sm-3 control-label ')); ?>
	    <div class="controls col-sm-9">
	        <?php echo $form->textArea($form_regiters, 'note', array('class' => 'span9 form-control')); ?>
	        <?php echo $form->error($form_regiters, 'note'); ?>
	    </div>
	</div>
	<div class ="regis control-group form-group" style="margin-top: 5px;">
	    <?php echo $form->labelEx($form_regiters, 'province_id', array('class' => 'col-sm-3 control-label ')); ?>
	    <div class="controls col-sm-9">
	        <?php
	        echo $form->dropDownList($form_regiters, 'province_id', $listprovince, array('class' => 'span9 form-control',));
	        ?>
	        <?php echo $form->error($form_regiters, 'province_id'); ?>
	    </div>
	</div>
	<div class ="regis control-group form-group" style="margin-top: 5px;">
	    <?php echo $form->labelEx($form_regiters, 'district_id', array('class' => 'col-sm-3 control-label ')); ?>
	    <div class="controls col-sm-9">
	        <?php
	        echo $form->dropDownList($form_regiters, 'district_id', [], array('class' => 'span9 form-control',));
	        ?>
	        <?php echo $form->error($form_regiters, 'district_id'); ?>
	    </div>
	</div>
	<div class ="regis control-group form-group" style="margin-top: 5px;">
	    <?php echo $form->labelEx($form_regiters, 'ward_id', array('class' => 'col-sm-3 control-label ')); ?>
	    <div class="controls col-sm-9">
	        <?php
	        echo $form->dropDownList($form_regiters, 'ward_id', [], array('class' => 'span9 form-control',));
	        ?>
	        <?php echo $form->error($form_regiters, 'ward_id'); ?>
	    </div>
	</div>
	<div class="regis control-group form-group">
	    <?php echo $form->labelEx($form_regiters, 'address', array('class' => 'col-sm-3 control-label ')); ?>
	    <div class="controls col-sm-9">
	        <?php echo $form->textField($form_regiters, 'address', array('class' => 'span9 form-control')); ?>
	        <?php echo $form->error($form_regiters, 'address'); ?>
	    </div>
	</div>
	<div class="form-group" style="padding-top: 10px;">
	    <div class="col-sm-offset-3 col-sm-9">
	        <?php echo CHtml::submitButton(Yii::t('common', 'regiter_contact'), array('tabindex' => 10, 'class' => 'regis btn btn-primary',)); ?>
	    </div>
	</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    jQuery(document).on('change', '#PopupRegisterProductForm_province_id', function() {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
            data: 'pid=' + jQuery('#PopupRegisterProductForm_province_id').val(),
            dataType: 'JSON',
            beforeSend: function() {
                w3ShowLoading(jQuery('#PopupRegisterProductForm_province_id'), 'right', 20, 0);
            },
            success: function(res) {
                if (res.code == 200) {
                    jQuery('#PopupRegisterProductForm_district_id').html(res.html);
                }
                w3HideLoading();
            },
            error: function() {
                w3HideLoading();
            }
        });
    });
    jQuery(document).on('change', '#PopupRegisterProductForm_district_id', function() {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getward') ?>',
            data: 'did=' + jQuery('#PopupRegisterProductForm_district_id').val(),
            dataType: 'JSON',
            beforeSend: function() {
                w3ShowLoading(jQuery('#PopupRegisterProductForm_district_id'), 'right', 20, 0);
            },
            success: function(res) {
                if (res.code == 200) {
                    jQuery('#PopupRegisterProductForm_ward_id').html(res.html);
                }
                w3HideLoading();
            },
            error: function() {
                w3HideLoading();
            }
        });
    });
</script>
