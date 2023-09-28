<style type="text/css">
    span.help{
        color: #999999;
        font-size: 11px;
        font-style: italic;
    }
</style>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'banners-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
        ));
        ?>


        <div class="control-group form-group">
            <?php echo $form->label($model, 'title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'title', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'title'); ?>
                <br />
                <span class="help">Enter campaign title. The title is displayed on sign up page and printed on certificate.</span>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->label($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'description'); ?>
                <br />
                <span class="help">Describe campaign. The description is displayed on sign up page.</span>
            </div>
        </div>

        <div class="control-group form-group">
            <label class="col-sm-2 control-label no-padding-left">Price</label>
            <div class="controls col-sm-10">
                <input <?php echo $model->price_type == 1 ? 'checked' : '' ?> type="radio" name="GiftCardCampaign[price_type]" value="1" id="GiftCardCampaign_price_type_1" /> <label for="GiftCardCampaign_price_type_1">Fixed price</label>
                <input type="text" value="<?php echo $model->price_value ?>" name="GiftCardCampaign[price_value]" />
                <br />
                <span class="help">Enter price per one gift certificate.</span>
                <br />
                <input <?php echo $model->price_type == 2 ? 'checked' : '' ?> type="radio" name="GiftCardCampaign[price_type]" value="2" id="GiftCardCampaign_price_type_2" /> <label for="GiftCardCampaign_price_type_2">Flexible price: </label>
                <input type="text" value="<?php echo $model->price_min ?>" name="GiftCardCampaign[price_min]" />
                <input type="text" value="<?php echo $model->price_max ?>" name="GiftCardCampaign[price_max]" />
            </div>
        </div>

        <div class="control-group form-group">
            <label class="col-sm-2 control-label no-padding-left">Certificate expiration</label>
            <div class="controls col-sm-10">
                <input <?php echo $model->expiration == 1 ? 'checked' : '' ?> type="radio" name="GiftCardCampaign[expiration]" value="1" id="GiftCardCampaign_1" /> <label for="GiftCardCampaign_1">Omit Expiration date or Expiration status, it is considered as null expiration or never expires until redeemed</label>
                <br />
                <span class="help">Select option if you don't want to show the expiration date on the certificate form.</span>
                <br />
                <input <?php echo $model->expiration == 2 ? 'checked' : '' ?> type="radio" name="GiftCardCampaign[expiration]" value="2" id="GiftCardCampaign_2" /> <label for="GiftCardCampaign_2">Fixed period: </label>
                <input type="text" value="<?php echo $model->fixed_period ?>" name="GiftCardCampaign[fixed_period]" /> days
                <br />
                <span class="help">Select option if you would like to issue certificates for limited period.</span>
                <br />
                <input <?php echo $model->expiration == 3 ? 'checked' : '' ?> type="radio" name="GiftCardCampaign[expiration]" value="3" id="GiftCardCampaign_3" /> <label for="GiftCardCampaign_3">Fixed date: </label>
                <input type="text" value="<?php echo $model->fixed_date ?>" name="GiftCardCampaign[fixed_date]" />
                <br />
                <span class="help">Select option if you would like to issue certificates valid until defined date.</span>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->label($model, 'expiration_label', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'expiration_label', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'expiration_label'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <label class="col-sm-2 control-label no-padding-left">Sales limit</label>
            <div class="controls col-sm-10">
                <input <?php echo $model->expiration == 1 ? 'checked' : '' ?> type="radio" name="GiftCardCampaign[sales_limit]" value="1" id="GiftCardCampaign_sales_limit_1" /> <label for="GiftCardCampaign_sales_limit_1">Unlimited</label>
                <br />
                <span class="help">Select this option if you would like to sell limited number of certificates.</span>
                <br />
                <input <?php echo $model->expiration == 2 ? 'checked' : '' ?> type="radio" name="GiftCardCampaign[sales_limit]" value="2" id="GiftCardCampaign_sales_limit_2" /> <label for="GiftCardCampaign_sales_limit_2">Limited: </label>
                <input type="text" value="<?php echo $model->limit ?>" name="GiftCardCampaign[limit]" /> certificates
                <br />
                <span class="help">Select this option if you would like to sell limited number of certificates.</span>
            </div>
        </div>

        <div class="control-group form-group">
            <label class="col-sm-2 control-label no-padding-left">Sales period</label>
            <div class="controls col-sm-10">
                <input <?php echo $model->expiration == 1 ? 'checked' : '' ?> type="radio" name="GiftCardCampaign[sales_period]" value="1" id="GiftCardCampaign_sales_period_1" /> <label for="GiftCardCampaign_sales_period_1">Always</label>
                <br />
                <span class="help">Select this option if you would like to sell certificates always.</span>
                <br />
                <input <?php echo $model->expiration == 2 ? 'checked' : '' ?> type="radio" name="GiftCardCampaign[sales_period]" value="2" id="GiftCardCampaign_sales_period_2" /> <label for="GiftCardCampaign_sales_period_2">Period: </label>
                <input type="text" value="<?php echo $model->from_date ?>" name="GiftCardCampaign[from_date]" />
                <input type="text" value="<?php echo $model->to_date ?>" name="GiftCardCampaign[to_date]" />
                <br />
                <span class="help">Select this option if you would like to sell certificates during some period.</span>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->label($model, 'conditions_and_restrictions', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'conditions_and_restrictions', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'conditions_and_restrictions'); ?>
                <br />
                <span class="help">Please describe any restrictions. This info is printed below each certificate. HTML allowed. Leave this field blank if not requires.</span>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'ecards', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <label>
                    <?php echo $form->checkBox($model, 'ecards', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"> Enable ecards</span>
                </label>
                <br />
                <span class="help">Enable this option if you would like to allow users to select ecard.</span>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'personalization', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <label>
                    <?php echo $form->checkBox($model, 'personalization', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"> Enable cerificate personalization</span>
                </label>
                <br />
                <span class="help">Enable this option if you would like to allow users to personalize certificates.</span>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->label($model, 'personaliza_message_length', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'personaliza_message_length', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'personaliza_message_length'); ?>
                <br />
                <span class="help">Enter maximum length of message printed of certificte</span>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'address_option', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <label>
                    <?php echo $form->checkBox($model, 'address_option', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"> Enable address option</span>
                </label>
                <br />
                <span class="help">Enable this option if you would like to allow users to request for sending paper copy of certificate by mail.</span>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->label($model, 'address_label', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'address_label', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'address_label'); ?>
                <br />
                <span class="help">Enter label of checkbox that user must tick to request for sending paper copy of certificate by mail.</span>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'phone_number', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <label>
                    <?php echo $form->checkBox($model, 'phone_number', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"> Ask user for phone number</span>
                </label>
                <br />
                <span class="help">Enable this option if you would like to ask users for phone number. This option is ignored if address option disabled.</span>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <label>
                    <?php echo $form->checkBox($model, 'status', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </div>
        </div>

        <div class="control-group form-group buttons" style="border-bottom: none;">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create campaign' : 'Update campaign', array('class' => 'btn btn-info', 'id' => 'savebanner')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>