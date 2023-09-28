<style type="text/css">
	.input-text-50 {
		width: 50%;
		float: left;
	}
	body .form-control {
		border-radius: 0px;
	}
	.regiter-domain-box label {
		margin-top: 10px;
	}
	.regiter-domain-box input, .regiter-domain-box select {
		padding: 2px 10px; 
	}
</style>
<div class="widget widget-box">
    <div class="widget-header">
    	<h4>
         	Đăng ký tên miền <b><?= $model->domainName.'.'.$model->tld ?></b>
        </h4>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
					<div class="regiter-domain-box">
					    <div class="in-xc" style="padding: 0px 20px">
					    	<?php
							    $form = $this->beginWidget('CActiveForm', array(
							        'id' => 'regiter-domain-form',
							        'enableAjaxValidation' => false,
							        'enableClientValidation' => true,
							        'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form'),
							    ));
					    		?>
					    		<div class=" w3-form-field item-input requied">
					    			<label><?= Yii::t('domain', 'domain') ?>:</label>
					    			<div class="cnt-input">
						                <?php echo $form->textField($model, 'domainName', array('class' => 'form-control w3-form-input input-text-50', 'placeholder' => Yii::t('domain', 'domainName'))); ?>
						                <?php echo $form->textField($model, 'tld', array('class' => 'form-control w3-form-input input-text-50', 'placeholder' => Yii::t('domain', 'tld'))); ?>    				
					    			</div>
					                <?php echo $form->error($model, 'domainName'); ?>
					                <?php echo $form->error($model, 'tld'); ?>
					            </div>
					            <div class=" w3-form-field item-input ">
					            	<label><?= Yii::t('domain', 'quantity') ?>:</label>
					            	<div class="cnt-input">
					                	<?php 
					                        $model->quantity = $model->quantity ? $model->quantity : 1;
					                        echo $form->dropDownList($model, 'quantity', $model->getOptionsQuantity(), ['class' =>'form-control w3-form-input input-text']); ?>
					               </div>
					                <?php echo $form->error($model, 'quantity'); ?>
					                <p>
					                    Giá đăng ký: <?= number_format($model->Price, 0, ',', '.') ?> VNĐ/năm(Chưa gồm VAT)  
					                    <br/>
					                    Giá cập nhật đăng ký:
					                    <span id="price-domain">
					                        <?php 
					                            $price = ApiZcom::getWhoIsPriceAuto($model->tld, $model->quantity);
					                            $price = ($price !== false && isset($price['ResellerPrice'])) ? $price['ResellerPrice'] : 0;
					                            if($price) { ?>
					                                <?= number_format($price, 0, ',', '.') ?>
					                                 + <?= ApiZcom::getVAT() ?>% VAT = 
					                                <?= number_format(ApiZcom::getSumVAT($price), 0, ',', '.') ?>
					                                 VND                             
					                            <?php } else {
					                                echo "liên hệ";
					                            }
					                        ?>
					                    </span>
					                    <script type="text/javascript">
					                        $('#RegiterDomainZcom_quantity').change(function () {
					                            changePrice();
					                        });
					                        $('#RegiterDomainZcom_tld').change(function () {
					                            changePrice();
					                        });
					                        function changePrice() {
					                            loadAjax('<?= Yii::app()->createUrl('/domain/zcom/getPrice'); ?>', {tld : $('#RegiterDomainZcom_tld').val(), quantity : $('#RegiterDomainZcom_quantity').val()}, $('#price-domain'));
					                        }
					                    </script>
					                </p>
					            </div>
					            <div class=" w3-form-field item-input ">
					            	<label><?= Yii::t('domain', 'Role') ?>:</label>
					            	<div class="cnt-input">
					            		<?php echo $form->dropDownList($model, 'Role', $model->getOptionsRoles(), ['class' =>'form-control w3-form-input input-text']); ?>
					               </div>
					                <?php echo $form->error($model, 'Role'); ?>
					            </div>
					            <div class=" w3-form-field item-input " id="Organization">
					            	<label><?= Yii::t('domain', 'Organization') ?>:</label>
					            	<div class="cnt-input">
					                	<?php echo $form->textField($model, 'Organization', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('domain', 'Organization'))); ?>
					               </div>
					                <?php echo $form->error($model, 'Organization'); ?>
					            </div>
					            <div class=" w3-form-field item-input ">
					            	<label>Họ và tên người đăng ký:</label>
					            	<div class="cnt-input">
					                	<?php echo $form->textField($model, 'FirstName', array('class' => 'form-control w3-form-input input-text-50', 'placeholder' => Yii::t('domain', 'FirstName'))); ?>
					                	<?php echo $form->textField($model, 'LastName', array('class' => 'form-control w3-form-input input-text-50', 'placeholder' => Yii::t('domain', 'LastName'))); ?>
					               </div>
					                <?php echo $form->error($model, 'FirstName'); ?>
					                <?php echo $form->error($model, 'LastName'); ?>
					            </div>
					            <div class=" w3-form-field item-input ">
					            	<label><?= Yii::t('domain', 'Phone') ?>:</label>
					            	<div class="cnt-input">
					                	<?php echo $form->textField($model, 'Phone', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('domain', 'Phone'))); ?>
					               </div>
					                <?php echo $form->error($model, 'Phone'); ?>
					            </div>
					            <div class=" w3-form-field item-input ">
					            	<label><?= Yii::t('domain', 'Email') ?>:</label>
					            	<div class="cnt-input">
					                	<?php echo $form->textField($model, 'Email', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('domain', 'Email'))); ?>
					               </div>
					                <?php echo $form->error($model, 'Email'); ?>
					            </div>
					            <div class=" w3-form-field item-input ">
					            	<label><?= Yii::t('domain', 'NationCode') ?>:</label>
					            	<div class="cnt-input">
					                	<?php echo $form->textField($model, 'NationCode', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('domain', 'NationCode'))); ?>
					               </div>
					                <?php echo $form->error($model, 'NationCode'); ?>
					            </div>
					            <div class=" w3-form-field item-input ">
					            	<label><?= Yii::t('domain', 'Sex') ?>:</label>
					            	<div class="cnt-input">
					            		<?php echo $form->dropDownList($model, 'Sex', $model->getOptionsSexs(), ['class' =>'form-control w3-form-input input-text']); ?>
					               </div>
					                <?php echo $form->error($model, 'Sex'); ?>
					            </div>
					            <div class=" w3-form-field item-input ">
					            	<label><?= Yii::t('domain', 'Birthday') ?>:</label>
					            	<div class="cnt-input">
					                	<?php echo $form->textField($model, 'Birthday', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('domain', 'Birthday'))); ?>
					               </div>
					                <?php echo $form->error($model, 'Birthday'); ?>
					            </div>
					            <div class=" w3-form-field item-input ">
					            	<label><?= Yii::t('domain', 'MobilePhone') ?>:</label>
					            	<div class="cnt-input">
					                	<?php echo $form->textField($model, 'MobilePhone', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('domain', 'MobilePhone'))); ?>
					               </div>
					                <?php echo $form->error($model, 'MobilePhone'); ?>
					            </div>
					            <div class=" w3-form-field item-input ">
					            	<label><?= Yii::t('domain', 'Fax') ?>:</label>
					            	<div class="cnt-input">
					                	<?php echo $form->textField($model, 'Fax', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('domain', 'Fax'))); ?>
					               </div>
					                <?php echo $form->error($model, 'Fax'); ?>
					            </div>
					            <div class=" w3-form-field item-input ">
					            	<label><?= Yii::t('domain', 'State') ?>:</label>
					            	<div class="cnt-input">
					                	<?php echo $form->dropDownList($model, 'State', ['' => 'Chọn'] + RegiterDomainZcom::getOptionProvines(), ['class' =>'form-control w3-form-input input-text']); ?>
					               </div>
					                <?php echo $form->error($model, 'State'); ?>
					            </div>
					            <div class=" w3-form-field item-input ">
					            	<label><?= Yii::t('domain', 'Street1') ?>:</label>
					            	<div class="cnt-input">
					                	<?php echo $form->textField($model, 'Street1', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('domain', 'Street1'))); ?>
					               </div>
					                <?php echo $form->error($model, 'Street1'); ?>
					            </div>
					            <div class=" w3-form-field item-input ">
					            	<label><?= Yii::t('domain', 'Street2') ?>:</label>
					            	<div class="cnt-input">
					                	<?php echo $form->textField($model, 'Street2', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('domain', 'Street2'))); ?>
					               </div>
					                <?php echo $form->error($model, 'Street2'); ?>
					            </div>
					            <div class=" w3-form-field item-input ">
					            	<label><?= Yii::t('domain', 'PostalCode') ?>:</label>
					            	<div class="cnt-input">
					                	<?php echo $form->textField($model, 'PostalCode', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('domain', 'PostalCode'))); ?>
					               </div>
					                <?php echo $form->error($model, 'PostalCode'); ?>
					            </div>
					            <p style="margin-top: 10px; color: red">
					            	<?php 
						            	if($model->errorAll) {
						            		echo $model->errorAll;
						            	}
						            ?>
					            </p>
					            <?php if(!$model->accountID) { ?>
					            	<div class="center">
					            		<p class="xne">Vui lòng đăng ký tài khoản cho email trước khi đăng ký tên miền.</p>
						            	<button class="btn btn-primary rigister">Đăng ký tài khoản cho email</button>
						            </div>
					            <?php } else { ?>
						            <div class="center">
						            	<button class="btn btn-primary rigister">Đăng ký tên miền</button>
						            </div>
						        <?php } ?>
					    	<?php $this->endWidget();?>
					    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).on('change', '#RegiterDomainZcom_Role', function () {
		if($(this).val() == 'I') {
			$('#Organization').css('display', 'none');
		} else {
			$('#Organization').css('display', 'block');
		}
	});
	$(document).ready(function () {
		$('#RegiterDomainZcom_Role').change();
        $('.rigister').click(function () {
            $(this).css('display', 'none');
            $('body').append('<div class="loadAjax" id="loadAjax" style="left: 0px; top: 0px; position: fixed;width: 100%; height: 100%; z-index: 999999999; display: flex;"> <div style="margin: auto; width: 300px; height: 50px; padding: 10px;font-size: 16;background: #fff; border: 1px solid #ebebeb">Thông tin đăng được xử lý. Vui lòng chờ trong giây lát...</div></div>');
            $('html').attr('style', 'overflow:hidden');
        });
	});

	function loadAjax(url, data, div, type='GET') {
        $('body').append('<div class="loadAjax" id="loadAjax" style="left: 0px; top: 0px; position: fixed;width: 100%; height: 100%; z-index: 999999999; display: flex;"> <div style="margin: auto; width: 50px; height: 50px; padding: 10px; background: #fff; border: 1px solid #ebebeb">Chờ.. </div></div>');
        $('html').attr('style', 'overflow:hidden');
        $.ajax({
            url: url,
            data: data,
            type: type,
            success: function(result){
                div.html(result);
                $('#loadAjax').remove();
                $('html').attr('style', '');
            }
        });
    }
</script>