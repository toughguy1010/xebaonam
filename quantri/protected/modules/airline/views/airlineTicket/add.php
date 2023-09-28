<?php
//
$category = new ClaCategory();
$category->type = ClaCategory::CATEGORY_AIRLINE_TICKET;
$category->generateCategory();
$arr = array('' => Yii::t('category', 'category_parent_0'));
//
$option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);
//
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('airline', 'create') : Yii::t('airline', 'update'); ?>
        </h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'language-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'name', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'name'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'ticket_category_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <div class="input-group">
                                <?php echo $form->dropDownList($model, 'ticket_category_id', $option, array('class' => 'form-control')); ?>
                                <div class="input-group-btn" style="padding-left: 10px;">
                                    <a href="<?php echo Yii::app()->createUrl('airline/airlineTicketCategory/addcat', array('pa' => ClaCategory::CATEGORY_ROOT) + $_GET) ?>"
                                       id="addCate" class="btn btn-primary btn-sm" style="line-height: 16px;">
                                           <?php echo Yii::t('category', 'category_add'); ?>
                                    </a>
                                </div>
                            </div>
                            <?php echo $form->error($model, 'ticket_category_id'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'provider_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'provider_id', AirlineProvider::optionProvider(), array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($model, 'provider_id'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'price', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'price'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'departure', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'departure', AirlineLocation::optionLocation(), array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($model, 'departure'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'departure_date', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                                'model' => $model, //Model object
                                'name' => 'AirlineTicket[departure_date]', //attribute name
                                'mode' => 'date', //use "time","date" or "datetime" (default)
                                'value' => ((int) $model->departure_date > 0) ? date('d-m-Y', (int) $model->departure_date) : date('d-m-Y'),
                                'language' => 'vi',
                                'options' => array(
                                    'dateFormat' => 'dd-mm-yy',
                                    'timeFormat' => 'HH:mm:ss',
                                    'controlType' => 'select',
                                    'stepHour' => 1,
                                    'stepMinute' => 1,
                                    'stepSecond' => 1,
                                    //'showOn' => 'button',
                                    'showSecond' => false,
                                    'changeMonth' => true,
                                    'changeYear' => false,
                                    'tabularLevel' => null,
                                ), // jquery plugin options
                                'htmlOptions' => array(
                                    'class' => 'span12 col-sm-12',
                                )
                            ));
                            ?>
                            <?php echo $form->error($model, 'departure_date'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'destination', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'destination', AirlineLocation::optionLocation(), array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($model, 'destination'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'destination_date', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                                'model' => $model, //Model object
                                'name' => 'AirlineTicket[destination_date]', //attribute name
                                'mode' => 'date', //use "time","date" or "datetime" (default)
                                'value' => ((int) $model->destination_date > 0) ? date('d-m-Y', (int) $model->destination_date) : date('d-m-Y'),
                                'language' => 'vi',
                                'options' => array(
                                    'dateFormat' => 'dd-mm-yy',
                                    'timeFormat' => 'HH:mm:ss',
                                    'controlType' => 'select',
                                    'stepHour' => 1,
                                    'stepMinute' => 1,
                                    'stepSecond' => 1,
                                    //'showOn' => 'button',
                                    'showSecond' => false,
                                    'changeMonth' => true,
                                    'changeYear' => false,
                                    'tabularLevel' => null,
                                ), // jquery plugin options
                                'htmlOptions' => array(
                                    'class' => 'span12 col-sm-12',
                                )
                            ));
                            ?>
                            <?php echo $form->error($model, 'destination_date'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                            <div id="airlineTicketavatar" style="display: block; margin-top: 0px;">
                                <div id="airlineTicketavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                                    <?php if ($model->avatar_path && $model->avatar_name) { ?>
                                        <img src="<?php echo ClaHost::getImageHost() . $model->avatar_path . 's100_100/' . $model->avatar_name; ?>" style="width: 100%;" />
                                    <?php } ?>
                                </div>
                                <div id="airlineTicketavatar_form" style="display: inline-block;">
                                    <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                                </div>
                            </div>
                            <?php echo $form->error($model, 'avatar'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArrayNews(), array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($model, 'status'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('airline', 'create') : Yii::t('airline', 'update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#airlineTicketavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/airline/airlineTicket/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#AirlineTicket_avatar').val(obj.data.avatar);
                        if (jQuery('#airlineTicketavatar_img img').attr('src')) {
                            jQuery('#airlineTicketavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#airlineTicketavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#airlineTicketavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });


    });
</script>
