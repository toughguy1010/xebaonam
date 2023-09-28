<?php
//
$category = new ClaCategory();
$category->type = ClaCategory::CATEGORY_JOBS;
$category->generateCategory();
$arr = array('' => Yii::t('category', 'category_parent_0'));
//
$option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);
//
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'jobs-form',
    'htmlOptions' => array('class' => 'form-horizontal'),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
        ));
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<div class="widget-box" style="margin-bottom: 20px;">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('work', 'work_info'); ?>
        </h4>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'jobs_category_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <div class="input-group">
                                <?php echo $form->dropDownList($model, 'jobs_category_id', $option, array('class' => 'form-control')); ?>
                                <div class="input-group-btn" style="padding-left: 10px;">
                                    <a href="<?php echo Yii::app()->createUrl('work/jobscategory/addcat', array('pa' => ClaCategory::CATEGORY_ROOT) + $_GET) ?>"
                                       id="addCate" class="btn btn-primary btn-sm" style="line-height: 16px;">
                                        <?php echo Yii::t('category', 'category_add'); ?>
                                    </a>
                                </div>
                            </div>
                            <?php echo $form->error($model, 'jobs_category_id'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'position', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'position', array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($model, 'position'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'company', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'company', array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($model, 'company'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'degree', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $this->widget('common.extensions.echosen.Chosen', array(
                                'model' => $model,
                                'attribute' => 'degree',
                                'data' => Jobs::getDegree(),
                                'value' => $model->degree,
                                'htmlOptions' => array('class' => 'span12 col-sm-12'),
                            ));
                            ?>
                            <?php echo $form->error($model, 'degree'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'trade_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $selectedTrade = array();
                            if (!$model->isNewRecord) {
                                $trades = $model->getTrades();
                                foreach ($trades as $key => $trade)
                                    $selectedTrade[$key] = array('selected' => 'selected');
                            }

                            $this->widget('common.extensions.echosen.Chosen', array(
                                'model' => $model,
                                'attribute' => 'trade_id',
                                'multiple' => true,
                                'data' => Trades::getTradeArr(),
                                'value' => $model->trade_id,
                                'htmlOptions' => array(
                                    'class' => 'span12 col-sm-12',
                                    'options' => $selectedTrade,
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'trade_id'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'typeofwork', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $selectedType = array();
                            if (!$model->isNewRecord) {
                                $typeofworks = $model->getTypeofwork();
                                foreach ($typeofworks as $key => $typeofwork)
                                    $selectedType[$key] = array('selected' => 'selected');
                            }
                            $this->widget('common.extensions.echosen.Chosen', array(
                                'model' => $model,
                                'attribute' => 'typeofwork',
                                'multiple' => true,
                                'data' => Jobs::getTypeOfJob(),
                                'value' => $model->typeofwork,
                                'htmlOptions' => array(
                                    'class' => 'span12 col-sm-12',
                                    'options' => $selectedType,
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'typeofwork'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'country_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $this->widget('common.extensions.echosen.Chosen', array(
                                'model' => $model,
                                'attribute' => 'country_id',
                                'data' => (new JobsCountry())->options(['promt' => 'Chọn quốc gia']),
                                'value' => $model->country_id,
                                'htmlOptions' => array(
                                    'class' => 'span12 col-sm-12',
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'level'); ?>
                        </div>
                    </div>
                    <?php
                    $language = ClaSite::getLanguageTranslate();
                    if ($language == '' || $language == 'vi') {
                        ?>
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'location', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <?php
                                $selected = array();
                                if (!$model->isNewRecord) {
                                    $locations = $model->getLocations();
                                    foreach ($locations as $key => $location)
                                        $selected[$key] = array('selected' => 'selected');
                                }

                                $this->widget('common.extensions.echosen.Chosen', array(
                                    'model' => $model,
                                    'attribute' => 'location',
                                    'multiple' => true,
                                    'placeholderMultiple' => $model->getAttributeLabel('location'),
                                    'data' => LibProvinces::getListProvinceArr(),
                                    'htmlOptions' => array(
                                        'class' => 'span12 col-sm-12',
                                        'options' => $selected,
                                    ),
                                ));
                                ?>
                                <?php echo $form->error($model, 'location'); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'location_text', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'location_text', array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($model, 'location_text'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'quantity', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'quantity', array('class' => 'span12 col-sm-12', 'onkeypress' => 'return isNumberKey(event);')); ?>
                            <?php echo $form->error($model, 'quantity'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'salaryrange', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'salaryrange', Jobs::getSalaryRangeTypes(), array('class' => 'span12 col-sm-12')); ?>
                            <div class="clearfix"></div>
                            <div id="salaryRange" class="row list-inline" style="padding-top: 15px; <?php if ($model->salaryrange != Jobs::SALARYRANGE_DETAIL) echo 'display: none;'; ?>">
                                <?php echo CHtml::label($model->getAttributeLabel('salary_min'), null, array('class' => 'col-sm-1', 'style' => 'width:80px;')); ?>
                                <?php echo $form->textField($model, 'salary_min', array('class' => 'col-sm-2')); ?>
                                <?php echo CHtml::label($model->getAttributeLabel('salary_max'), null, array('class' => 'col-sm-1', 'style' => 'width:80px;')); ?>
                                <?php echo $form->textField($model, 'salary_max', array('class' => 'col-sm-2', 'onkeypress' => 'return isNumberKey(event);')); ?>
                                <?php echo CHtml::label('(' . Jobs::getCurrencyPerMonthText() . ')', null, array('class' => 'col-sm-1', 'style' => 'width:80px;')); ?>
                            </div>
                            <?php echo $form->error($model, 'salaryrange'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'level', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $this->widget('common.extensions.echosen.Chosen', array(
                                'model' => $model,
                                'attribute' => 'level',
                                'data' => Jobs::getLevelTypes(),
                                'value' => $model->level,
                                'htmlOptions' => array(
                                    'class' => 'span12 col-sm-12',
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'level'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'experience', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $this->widget('common.extensions.echosen.Chosen', array(
                                'model' => $model,
                                'attribute' => 'experience',
                                'data' => Jobs::getExperienceTypes(),
                                'value' => $model->experience,
                                'htmlOptions' => array(
                                    'class' => 'span12 col-sm-12',
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'level'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'short_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'short_description', array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($model, 'short_description'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($model, 'description'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'requirement', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'requirement', array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($model, 'requirement'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'includes', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'includes', array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($model, 'includes'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'benefit', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'benefit', array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($model, 'benefit'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'expirydate', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                                'model' => $model, //Model object
                                'name' => 'Jobs[expirydate]', //attribute name
                                'mode' => 'date', //use "time","date" or "datetime" (default)
                                'value' => ((int) $model->expirydate > 0 ) ? date('d-m-Y', (int) $model->expirydate) : '',
                                'language' => 'vi',
                                'options' => array(
                                    'showSecond' => true,
                                    'dateFormat' => 'dd-mm-yy',
                                    'controlType' => 'select',
                                    //'showOn' => 'button',
                                    'tabularLevel' => null,
                                    'minDate' => date('d-m-Y')
                                //'addSliderAccess' => true,
                                //'sliderAccessArgs' => array('touchonly' => false),
                                ), // jquery plugin options
                                'htmlOptions' => array(
                                    'class' => 'span12 col-sm-12',
                                )
                            ));
                            ?>
                            <?php echo $form->error($model, 'expirydate'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'publicdate', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                                'model' => $model, //Model object
                                'name' => 'Jobs[publicdate]', //attribute name
                                'mode' => 'datetime', //use "time","date" or "datetime" (default)
                                'value' => ((int) $model->publicdate > 0 ) ? date('d-m-Y H:i:s', (int) $model->publicdate) : date('d-m-Y H:i:s'),
                                'language' => 'vi',
                                'options' => array(
                                    'showSecond' => true,
                                    'dateFormat' => 'dd-mm-yy',
                                    'timeFormat' => 'HH:mm:ss',
                                    'controlType' => 'select',
                                    'stepHour' => 1,
                                    'stepMinute' => 1,
                                    'stepSecond' => 1,
                                    //'showOn' => 'button',
                                    'showSecond' => true,
                                    'changeMonth' => true,
                                    'changeYear' => false,
                                    'tabularLevel' => null,
                                ), // jquery plugin options
                                'htmlOptions' => array(
                                    'class' => 'span12 col-sm-12',
                                )
                            ));
                            ?>
                            <?php echo $form->error($model, 'publicdate'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                            <div style="clear: both;"></div>
                            <div id="newsavatar" style="display: block; margin-top: 10px;">
                                <div id="jobsavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                                    <?php if ($model->image_path && $model->image_name) { ?>
                                        <img src="<?php echo ClaHost::getImageHost() . $model->image_path . 's100_100/' . $model->image_name; ?>" style="width: 100%;" />
                                    <?php } ?>
                                </div>
                                <div id="jobsavatar_form" style="display: inline-block;">
                                    <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                                </div>
                            </div>
                            <?php echo $form->error($model, 'avatar'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'ishot', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">                            
                            <?php echo $form->checkBox($model, 'ishot'); ?>
                            <?php echo $form->error($model, 'ishot'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'order', array('class' => 'span12 col-sm-12', 'onkeypress' => 'return isNumberKey(event);')); ?>
                            <?php echo $form->error($model, 'order'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($model, 'status'); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="widget-box" style="margin-bottom: 20px;">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('work', 'work_contact'); ?>
        </h4>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'contact_username', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <div class="controls col-sm-10">
                    <?php echo $form->textField($model, 'contact_username', array('class' => 'span12 col-sm-12')); ?>
                    <?php echo $form->error($model, 'contact_username'); ?>
                </div>
            </div>
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'contact_email', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <div class="controls col-sm-10">
                    <?php echo $form->textField($model, 'contact_email', array('class' => 'span12 col-sm-12')); ?>
                    <?php echo $form->error($model, 'contact_email'); ?>
                </div>
            </div>
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'contact_phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <div class="controls col-sm-10">
                    <?php echo $form->textField($model, 'contact_phone', array('class' => 'span12 col-sm-12')); ?>
                    <?php echo $form->error($model, 'contact_phone'); ?>
                </div>
            </div>
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'contact_address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <div class="controls col-sm-10">
                    <?php echo $form->textField($model, 'contact_address', array('class' => 'span12 col-sm-12')); ?>
                    <?php echo $form->error($model, 'contact_address'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('work', 'work_interview'); ?>
        </h4>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'has_interview', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <div class="controls col-sm-10">                            
                    <?php echo $form->checkBox($model, 'has_interview'); ?>
                    <?php echo $form->error($model, 'has_interview'); ?>
                </div>
            </div>
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'interview_time', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <div class="controls col-sm-10">
                    <?php
                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                        'model' => $model, //Model object
                        'name' => 'Jobs[interview_time]', //attribute name
                        'mode' => 'datetime', //use "time","date" or "datetime" (default)
                        'value' => ((int) $model->interview_time > 0 ) ? date('d-m-Y H:i:s', (int) $model->interview_time) : date('d-m-Y H:i:s'),
                        'language' => 'vi',
                        'options' => array(
                            'showSecond' => true,
                            'dateFormat' => 'dd-mm-yy',
                            'timeFormat' => 'HH:mm:ss',
                            'controlType' => 'select',
                            'stepHour' => 1,
                            'stepMinute' => 1,
                            'stepSecond' => 1,
                            //'showOn' => 'button',
                            'showSecond' => true,
                            'changeMonth' => true,
                            'changeYear' => false,
                            'tabularLevel' => null,
                        ), // jquery plugin options
                        'htmlOptions' => array(
                            'class' => 'span12 col-sm-12',
                        )
                    ));
                    ?>
                    <?php echo $form->error($model, 'interview_time'); ?>
                </div>
            </div>
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'interview_endtime', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <div class="controls col-sm-10">
                    <?php
                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                        'model' => $model, //Model object
                        'name' => 'Jobs[interview_endtime]', //attribute name
                        'mode' => 'datetime', //use "time","date" or "datetime" (default)
                        'value' => ((int) $model->interview_endtime > 0 ) ? date('d-m-Y H:i:s', (int) $model->interview_endtime) : date('d-m-Y H:i:s'),
                        'language' => 'vi',
                        'options' => array(
                            'showSecond' => true,
                            'dateFormat' => 'dd-mm-yy',
                            'timeFormat' => 'HH:mm:ss',
                            'controlType' => 'select',
                            'stepHour' => 1,
                            'stepMinute' => 1,
                            'stepSecond' => 1,
                            //'showOn' => 'button',
                            'showSecond' => true,
                            'changeMonth' => true,
                            'changeYear' => false,
                            'tabularLevel' => null,
                        ), // jquery plugin options
                        'htmlOptions' => array(
                            'class' => 'span12 col-sm-12',
                        )
                    ));
                    ?>
                    <?php echo $form->error($model, 'interview_endtime'); ?>
                </div>
            </div>
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'interview_address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <div class="controls col-sm-10">
                    <?php echo $form->textField($model, 'interview_address', array('class' => 'span12 col-sm-12')); ?>
                    <span style="color: blue;"><i>Nhập đầy đủ, ví dụ: 335 cầu giấy, Mai Dịch, Cầu Giấy, Hà Nội.</i></span>
                    <?php echo $form->error($model, 'interview_address'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="control-group form-group buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('work', 'job_create') : Yii::t('news', 'news_edit'), array('class' => 'btn btn-info', 'id' => 'savenews')); ?>
</div>
<?php $this->endWidget(); ?>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<script>
    jQuery(document).ready(function () {

        CKEDITOR.replace("Jobs_includes", {
            height: 200,
            language: '<?php echo Yii::app()->language ?>'
        });
        CKEDITOR.replace("Jobs_description", {
            height: 200,
            language: '<?php echo Yii::app()->language ?>'
        });
        CKEDITOR.replace("Jobs_requirement", {
            height: 200,
            language: '<?php echo Yii::app()->language ?>'
        });
        CKEDITOR.replace("Jobs_benefit", {
            height: 200,
            language: '<?php echo Yii::app()->language ?>'
        });

        jQuery('#Jobs_salaryrange').on('change', function () {
            var thi = jQuery(this);
            if (thi.val() ==<?php echo Jobs::SALARYRANGE_DETAIL; ?>)
                jQuery('#salaryRange').show();
            else
                jQuery('#salaryRange').hide();
        });

        jQuery('#jobsavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/work/jobs/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Jobs_avatar').val(obj.data.avatar);
                        if (jQuery('#jobsavatar_img img').attr('src')) {
                            jQuery('#jobsavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#jobsavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#jobsavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });

    });
</script>