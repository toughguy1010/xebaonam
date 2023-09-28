<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/upload/ajaxupload.min.js"></script>
<?php
$listprivince = array('' => '') + LibProvinces::getListProvinceArr();
if (!$model->isNewRecord && isset($model->province_id)) {
    $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
} else {
    $listdistrict = array('' => '');
}
?>
<div class="row">
    <div class="col-xs-12 no-padding">
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
        <div class="profileif">
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'user_name', array('class' => 'control-label col-sm-2')); ?>
                <div class="controls col-sm-10">
                    <?php echo $form->textField($model, 'user_name', array('class' => 'span9 form-control')); ?>
                    <?php echo $form->error($model, 'user_name'); ?>
                </div>
            </div>
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'email', array('class' => 'control-label col-sm-2')); ?>
                <div class="controls col-sm-10">
                    <?php echo $form->textField($model, 'email', array('class' => 'span9 form-control')); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>
            </div>
            <?php if ($model->isNewRecord) { ?>
                <div class="control-group form-group">
                    <?php echo $form->labelEx($model, 'password', array('class' => 'control-label col-sm-2')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->passwordField($model, 'password', array('class' => 'span9 form-control')); ?>
                        <?php echo $form->error($model, 'password'); ?>
                    </div>
                </div>
                <div class="control-group form-group">
                    <?php echo $form->labelEx($model, 'passwordConfirm', array('class' => 'control-label col-sm-2')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->passwordField($model, 'passwordConfirm', array('class' => 'span9 form-control')); ?>
                        <?php echo $form->error($model, 'passwordConfirm'); ?>
                    </div>
                </div>
            <?php } else { ?>
                <div class="control-group form-group">
                    <?php echo $form->labelEx($model, 'newPassword', array('class' => 'control-label col-sm-2')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->passwordField($model, 'newPassword', array('class' => 'span9 form-control')); ?>
                        <?php echo $form->error($model, 'newPassword'); ?>
                    </div>
                </div>
            <?php } ?>
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'birthday', array('class' => 'control-label col-sm-2')); ?>
                <div class="controls col-sm-10">
                    <?php
                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'birthday',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth' => true,
                            'changeYear' => true,
                            'tabularLevel' => null,
                            'yearRange' => "-80:+0",
                        ),
                        'language' => '',
                        'htmlOptions' => array(
                            'autocomplete' => 'on',
                            'placeholder' => $model->getAttributeLabel('birthday'),
                            'tabindex' => 9,
                            'value' => $model->birthday ? $model->birthday : '',
                            'class' => 'span9 form-control',
                        ),
                    ));
                    ?>
                    <?php echo $form->error($model, 'birthday'); ?>
                </div>
            </div>

            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'sex', array('class' => 'control-label col-sm-2')); ?>
                <div class="controls col-sm-10">
                    <?php
                    echo $form->dropDownList($model, 'sex', ClaUser::getListSexArr(), array('class' => 'span9 form-control',));
                    ?>
                    <?php echo $form->error($model, 'sex'); ?>
                </div>
            </div>
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'addresss', array('class' => 'control-label col-sm-2')); ?>
                <div class="controls col-sm-10">
                    <?php echo $form->textField($model, 'addresss', array('class' => 'span9 form-control')); ?>
                    <?php echo $form->error($model, 'addresss'); ?>
                </div>
            </div>
            <?php if (ClaUser::isSupperAdmin() && !$model->isNewRecord) { ?>
                <div class="control-group form-group">
                    <?php echo $form->labelEx($model, 'status', array('class' => 'control-label col-sm-2')); ?>
                    <div class="controls col-sm-10">
                        <?php
                        echo $form->dropDownList($model, 'status', ClaUser::getBlockUser(), array('class' => 'span9 form-control',));
                        ?>
                        <?php echo $form->error($model, 'status'); ?>
                    </div>
                </div>
            <?php } ?>
            <?php if (ClaUser::isSupperAdmin()) { ?>
                <div class="control-group form-group">
                    <?php echo $form->labelEx($model, 'is_root', array('class' => 'control-label col-sm-2')); ?>
                    <div class="controls col-sm-10">
                        <label class="labelcheckpage">
                            <strong>
                                <?php echo $form->checkBox($model, 'is_root'); ?>
                                <?php echo $model->getAttributeLabel('is_root'); ?>
                            </strong>
                        </label>
                        <?php echo $form->error($model, 'is_root'); ?>
                    </div>
                </div>
            <?php } ?>
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, Yii::t('user', 'permission'), array('class' => 'control-label col-sm-2')); ?>
                <div class="controls col-sm-10">
                    <div class="form-group no-margin-left">
                        <label class="labelcheckpage">
                            <strong>
                                <?php echo $form->checkBox($model, 'permission_limit'); ?>
                                <?php echo Yii::t('user', 'permission_limit'); ?>
                            </strong>
                        </label>
                        <div class="listcheck" id="permissionList"
                             style="margin-left: 50px; margin-top: 10px; <?php echo (!$model->permission_limit) ? 'display:none;' : ''; ?>">
                            <?php
                            $rules = $model->getPermissionArr();
                            foreach ($permissions as $key => $label) {
                                $checked = false;
                                if (in_array($key, $rules)) {
                                    $checked = true;
                                }
                                ?>
                                <label class="labelcheckpage">
                                    <input <?php echo ($checked) ? 'checked="checked"' : '' ?> type="checkbox"
                                                                                               value="<?php echo $key; ?>"
                                                                                               class="checkpage"
                                                                                               name="permission[]"> <?php echo $label; ?>
                                </label>
                            <?php } ?>
                        </div>
                        <script type="text/javascript">
                            jQuery(function () {
                                jQuery('#UsersAffilliate_permission_limit').on('change', function () {
                                    if ($(this).prop('checked')) {
                                        $('#permissionList').show();
                                    } else {
                                        $('#permissionList').hide();
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
            <div class="control-group form-group buttons">
                <div class="col-sm-offset-2 col-sm-10">
                    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'create') : Yii::t('common', 'save'), array('class' => 'btn btn-info')); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>