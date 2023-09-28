<div class="profile-user">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box-profile">
                <h2>Setting</h2>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <ul>
                            <li>
                                <label class="label-text"><span class="req">*</span> Cell Phone</label>
                                <div class="pull-left">
                                    <input type="text" placeholder="Cell Phone" value="Cell Phone" maxlength="50"
                                           class="inputbox-type" required="">
                                </div>
                            </li>
                            <li>
                                <label class="label-text">* Mobile Provider</label>
                                <div class="pull-left select-question-box">
                                    <select class="input-remove-attr" required="" aria-required="true">
                                        <option selected="selected" value="-1">Select Mobile Provider</option>
                                        <option value="93">3 (Three) - UK</option>
                                        <option value="12">Airpeak</option>
                                        <option value="100">AirVoice</option>
                                        <option value="13">Alaska Communications Systems</option>
                                        <option value="22">Alaska Wireless</option>
                                        <option value="9">Alltel</option>
                                        <option value="23">Appalachian Wireless</option>
                                        <option value="83">aql - UK</option>
                                        <option value="1">AT&amp;T</option>
                                        <option value="101">AT&amp;T (former Cingular Customers)</option>
                                        <option value="73">Australia - Text Messaging Doesn't Work Sorry</option>
                                        <option value="24">Bluegrass Cellular</option>
                                        <option value="7">Boost Mobile</option>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <label class="label-text"><span class="req">*</span>Day Phone</label>
                                <div class="pull-left">
                                    <input type="text" placeholder="Day Phone" value="nguyen" maxlength="50"
                                           class="inputbox-type" required="">
                                </div>
                            </li>
                            <li>
                                <label class="label-text"><span class="req">*</span>Night Phone</label>
                                <div class="pull-left">
                                    <input type="text" placeholder="Day Phone" value="nguyen" maxlength="50"
                                           class="inputbox-type" required="">
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <ul>
                            <li>
                                <label class="label-text"><span class="req">*</span>Address</label>
                                <div class="pull-left">
                                    <input type="text" placeholder="Address" value="Address" maxlength="50"
                                           class="inputbox-type" required="">
                                </div>
                            </li>
                            <li>
                                <label class="label-text">Country</label>
                                <div class="pull-left select-question-box">
                                    <select class="input-remove-attr" required="" aria-required="true">
                                        <option value="4">Australia</option>
                                        <option value="3">Canada</option>
                                        <option value="2">United Kingdom</option>
                                        <option selected="selected" value="1">United States of America</option>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <label class="label-text"><span class="req">*</span>Zip/Postal Code</label>
                                <div class="pull-left">
                                    <input type="text" placeholder="Zip/Postal Code" value="Zip/Postal Code"
                                           maxlength="50" class="inputbox-type" required="">
                                </div>
                            </li>
                            <li>
                                <label class="label-text"><span class="req">*</span>State/Province</label>
                                <div class="pull-left">
                                    <input type="text" placeholder="State/Province" value="State/Province"
                                           maxlength="50" class="inputbox-type" required="">
                                </div>
                            </li>
                            <li>
                                <label class="label-text"><span class="req">*</span>City</label>
                                <div class="pull-left">
                                    <input type="text" placeholder="City" value="City" maxlength="50"
                                           class="inputbox-type" required="">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'user-model-form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'htmlOptions' => array(
                        'class' => 'form-horizontal',
                    ),
                ));
                ?>
                <div class="note-setting">

                    <ul>
                        <li class="app-reminder-text"><strong>Appointment Reminders By:</strong>
                            <p>
                                <?php echo $form->checkBox($model_info, 'notify_by_email', array('class' => 'fieldremem')); ?>
                                <?php echo $form->label($model_info, 'notify_by_email', array('class' => '')); ?>
                            </p>
                            <p>
                                <?php echo $form->checkBox($model_info, 'notify_by_sms', array('class' => 'fieldremem')); ?>
                                <?php echo $form->label($model_info, 'notify_by_sms', array('class' => '')); ?>
                            </p>
                            <p>
                                <?php echo $form->checkBox($model_info, 'notify_by_push_notification', array('class' => 'fieldremem')); ?>
                                <?php echo $form->label($model_info, 'notify_by_push_notification', array('class' => '')); ?>
                            </p>
                        </li>
                        <li class="app-reminder-text"><strong>Special Announcement Email:</strong>
                            <p>
                                <?php echo $form->checkBox($model_info, 'business_email_notify', array('class' => 'fieldremem')); ?>
                                <?php echo $form->label($model_info, 'business_email_notify', array('class' => '')); ?>
                            </p>
                            <p>
                                <?php echo $form->checkBox($model_info, 'admin_email_notify', array('class' => 'fieldremem')); ?>
                                <?php echo $form->label($model_info, 'admin_email_notify', array('class' => '')); ?>
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="change-info-user">
                    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'create') : Yii::t('common', 'save'), array('class' => 'edit-user')); ?>
<!--                    <a class="edit-user" href="">Edit</a>-->
<!--                    <a class="save-edit" href="">Save</a>-->
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
