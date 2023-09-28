
<div class="work_create">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'RecruitmentNews-form',
	  'enableClientValidation' => false,
                'clientOptions' => array(
                'validateOnSubmit' => true,
            ),

)); ?>

	<p class="note">Các dòng có <span class="required">(*)</span> là bắt buộc nhập.</p>
	<?php echo $form->errorSummary($model,'Thông tin chưa chính xác .'); ?>

	<!-- BEGIN BOX BASIC-->
	<div class="box-item basic">
		<div class="title">Thông tin công ty</div>
		<div class="w-row">
                  
			<label class="" for="company_name">Tên công ty *</label>
                        
                         
                         
			<?php if(count($obj_uCompany)>0):?>
                        
				
				<?php echo $form->dropDownList($model,'company_id',CHtml::listData($obj_uCompany,'company_id','company_name'),array('class'=>'available_com','style'=>'width:305px',"id"=>"uCompany_id"))?>
		             
				<?php echo $form->textField($model,"company_name",array("class"=>"other_text","style"=>"display:none"));?>
				<?php echo $form->error($model,"company_id");?>
				
		<?php else:?>
			<?php echo $form->textField($model,"company_name");?>
			<?php echo $form->error($model,"company_name");?>
		<?php endif;?>

		</div>
		<div class="w-row">
			<label class="" for="company_name">Địa chỉ công ty *</label>
			<?php echo $form->textField($model,'company_address',array('value'=>!is_null($model->company_address) ? $model->company_address : "","class"=>"company_address"));?>
			<?php echo $form->error($model,'company_address');?>
		</div>
                  <input type='hidden' name='session' value='<?= Generate::getSession()?>' />
		<div class="w-row">
                    <label class="" for="company_name">Thông tin về công ty *</label>
			<?php echo $form->textField($model,'company_info'); ?>
			<?php echo $form->error($model,'company_info');?>		
		</div>
	</div><!-- BOX BASIC-->
	
	<div class="box-item detail-item">
	<div class="title">Thông tin đăng tuyển</div>
		<div class="w-row">
			<?php echo $form->labelEx($model,'position'); ?>
			<?php echo $form->textField($model,'position',array('size'=>40,'maxlength'=>128)); ?>
			<?php echo $form->error($model,'position'); ?>
		</div>
		
		<div class="w-row">
			<?php echo $form->labelEx($model,'office'); ?>
			<?php echo $form->dropDownList($model,'office',Yii::app()->params['office']); ?>
			<?php echo $form->error($model,"office");?>
		</div>
		
		<div class="w-row">
			<?php echo $form->labelEx($model,'trade_id'); ?>
			<?php echo $form->dropDownList($model,'trade_id',$trade,array('data-placeholder'=>'Chọn ngành nghề','multiple'=>'multiple','size'=>20,'style'=>"width: 304px;")); ?>
			<?php echo $form->error($model,"trade_id");?>
		</div>
	
		<div class="w-row">
			<?php echo $form->labelEx($model,'typeofwork'); ?>
			<?php echo $form->dropDownList($model,'typeofwork',Yii::app()->params['typeOfWork']); ?>
			<?php echo $form->error($model,"typeofwork");?>
		</div>
		
		
		<div class="w-row">
			<?php echo $form->labelEx($model,'provinces');?>
			<?php echo $form->dropDownList($model,'provinces',$region,array('data-placeholder'=>'Chọn nơi làm việc','multiple'=>'multiple','size'=>20,'style'=>"width: 304px;")); ?>
			<?php echo $form->error($model,"provinces");?>
		</div>
	
		<div class="w-row">
			<?php echo $form->labelEx($model,'amount'); ?>
			<?php echo $form->textField($model,'amount',array('size'=>10,'maxlength'=>128)); ?>
			<?php echo $form->error($model,"amount");?>
		</div>
	
		<div class="w-row">
			<?php echo $form->labelEx($model,'payrate'); ?>
			<?php echo $form->dropDownList($model,'payrate',Yii::app()->params['payrate'],array('style'=>'width:150px')); ?>
			<?php echo $form->error($model,"payrate");?>
		</div>
		
		<div class="row1" id="hide" <?php if($model->payrate!='0'):?>style="display:none;"<?php endif ?>>
		<span id="space" style="">&nbsp;&nbsp;&nbsp;</span>
		<div class="intro">Tối thiểu<?php echo $form->textField($model,'salary_min',array(
										'autocomplete'=>'off',	
										'onkeypress'	=>'return isNumberKey(event)'
										));?> &nbsp;-&nbsp;
			Tối đa<?php echo $form->textField($model,'salary_max',array(
										'autocomplete'=>'off',	
										'onkeypress'	=>'return isNumberKey(event)',
										));?>
			<div class="intro1">
				(	USD/ tháng)
			<?php //echo $form->radioButtonList($model,'currency',$currency_array);?></div>
		</div>
	
		</div>
		
		<div class="w-row">
		<?php echo $form->labelEx($model,'level'); ?>
		<?php echo $form->dropDownList($model,'level',Yii::app()->params['level']); ?>
		<?php echo $form->error($model,'level'); ?>
		</div>
	
		<div class="w-row">
			<?php echo $form->labelEx($model,'experience'); ?>
			<?php echo $form->dropDownList($model,'experience',Yii::app()->params['experience']); ?>
			<?php echo $form->error($model,'experience'); ?>
		</div>
		<div class="w-row">
			<?php echo $form->labelEx($model,'includes'); ?>
			<?php echo $form->textArea($model,'includes',array('cols'=>60,'rows'=>8)); ?>
			<?php echo $form->error($model,'includes'); ?>
		</div>
		
		
			<div class="w-row">
                         
			<?php echo $form->labelEx($model,'expiryday'); ?>	
			<?php 
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'attribute'=>'expiryday',
				'model'=>$model,
				// additional javascript options for the date picker plugin
				'options'=>array(
					'showAnim'=>'fold',
					'dateFormat'=>'dd-mm-yy',
				),
				'htmlOptions'=>array(
					'style'=>'height:20px;'
				),
			));
					?>(dd-mm-yyyy)
                                        <?php echo $form->error($model,"expiryday");?>
		</div>

		<div class="w-row">
			<?php echo $form->labelEx($model,'description'); ?>
			<?php echo $form->textArea($model,'description',array('cols'=>60,'rows'=>8)); ?>
			<?php echo $form->error($model,"description");?>
		</div>
	</div><!-- END BOX- DETAIL-ITEM -->

		<!-- BEGIN BOX USER CONTACT-->
	<div class="box-item basic">
		<div class="title">Thông tin liên hệ</div>
		<?php $user_info=User::model()->findByPk(Yii::app()->user->id);?>
		<div class="w-row">
			<label class="" for="company_name">Tên người liên hệ *</label>
			<?php echo $form->textField($model,'username',array('value'=>!is_null($model->username) ? $model->username :$user_info['fullname']));?>
			<?php echo $form->error($model,'username');?>
		</div>
		<div class="w-row">
			<label class="" for="company_name">Email :</label>
			<?php echo $form->textField($model,'email',array('value'=>!is_null($model->email) ? $model->email :$user_info['emailaddress']));?>
			<?php echo $form->error($model,'email');?>
		</div>
		<div class="w-row">
			<label class="" for="company_name">Địa chỉ :</label>
			<?php echo $form->textField($model,'address',array('value'=>!is_null($model->address) ? $model->address :$user_info['address']));?>
			<?php echo $form->error($model,'address');?>
		</div>
		
		<div class="w-row">
			<label class="" for="company_name">Sdt :</label>
			<?php echo $form->textField($model,'sdt',array('value'=>!is_null($model->sdt) ? $model->sdt :$user_info['phone']));?>
			<?php echo $form->error($model,'sdt');?>
		</div>
		
		<div class="w-row">
			<label class="" for="company_name">Website :</label>
			<?php echo $form->textField($model,'website',array('value'=>!is_null($model->website) ? $model->website :$user_info['website']));?>
			<?php echo $form->error($model,'website');?>
			
		</div>
	</div><!-- BOX USER CONTACT-->


	<div class="w-row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Tạo mới' : 'Lưu',array('style'=>'height:30px;')); ?>
		<?php echo CHtml::button('Quay lại',array('submit'=>array('work/index'),'style'=>'height:30px;'));?>
		
	</div>	
<?php $this->endWidget(); ?>
</div><!-- form -->

	