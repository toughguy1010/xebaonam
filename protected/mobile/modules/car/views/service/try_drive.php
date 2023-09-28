<div class="buycar registered-news clearfix">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'schedule-repair-form',
        'action' => Yii::app()->createUrl('car/service/resgisterTryDrive', array('id' => $form_id)),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form'),
    ));
    ?>
    <div class="from-left">
        <div class="form-group w3-form-group pop-ng  ">
            <span class="width-td">TIÊU ĐỀ</span>
            <div class=" w3-form-field width-r ">
                <?php echo $form->textField($model, 'title', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('car', 'title'))); ?>
                <?php echo $form->error($model, 'title'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group pop-ng  ">
            <span class="width-td">Mẫu xe</span>
            <div class=" w3-form-field width-r">
                <select id="CarForm_car_id" name="CarForm[car_id]" onchange="getImage()" class="form-control width-r">
                    <option>--Tất cả--</option>
                    <?php
                    if (count($cars)) {
                        foreach ($cars as $car) {
                            ?>
                            <option value="<?php echo $car['id'] ?>"><?php echo $car['name'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <script type="text/javascript">
                function getImage() {
                    var car_id = $("#CarForm_car_id").val();
                    var url = '<?php echo $this->createUrl('getImageCar') ?>';
                    $.ajax({
                        url: url,
                        data: {car_id: car_id},
                        type: 'get',
                        dataType: 'json',
                        success: function (data) {
                            if (data.code == 200) {
                                $(".reg-car img").attr('src', data.src);
                            }
                        }
                    });
                }
            </script>
        </div>
        <div class="form-group w3-form-group pop-ng  ">
            <span class="width-td">HỌ TÊN</span>
            <div class=" w3-form-field width-r ">
                <?php echo $form->textField($model, 'user_name', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('car', 'user_name'))); ?>
                <?php echo $form->error($model, 'user_name'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group pop-ng  ">
            <span class="width-td">EMAIL</span>
            <div class=" w3-form-field width-r ">
                <?php echo $form->textField($model, 'email', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('common', 'email'))); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group pop-ng  ">
            <span class="width-td">Số điện thoại</span>
            <div class=" w3-form-field width-r ">
                <?php echo $form->textField($model, 'phone', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('common', 'phone'))); ?>
                <?php echo $form->error($model, 'phone'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group pop-ng  ">
            <span class="width-td">THỜI GIAN</span>
            <div class="w3-form-field width-r">
                <?php
                $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                    'model' => $model, //Model object
                    'name' => 'CarForm[time]', //attribute name
                    'mode' => 'datetime', //use "time","date" or "datetime" (default)
                    'value' => ((int) $model->time > 0 ) ? date('d-m-Y H:i:s', (int) $model->time) : date('d-m-Y H:i:s'),
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
                    //'addSliderAccess' => true,
                    //'sliderAccessArgs' => array('touchonly' => false),
                    ), // jquery plugin options
                    'htmlOptions' => array(
                        'class' => 'form-control w3-form-input input-text',
                    )
                ));
                ?>
                <?php echo $form->error($model, 'time'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group pop-ng  ">
            <span class="width-td">ĐỊA CHỈ</span>
            <div class=" w3-form-field width-r ">
                <?php echo $form->textField($model, 'address', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('common', 'address'))); ?>
                <?php echo $form->error($model, 'address'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group pop-ng ">
            <span class=" width-td">NỘI DUNG </span> 
            <div class=" w3-form-field width-r ">
                <?php echo $form->textArea($model, 'content', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('car', 'content'))); ?>
                <?php echo $form->error($model, 'content'); ?>
            </div>
        </div>
    </div>

    <div class="from-right">
        <div class="reg-car">
            <img src="<?php echo Yii::app()->getBaseUrl(true), '/css/images/blank_car.png'; ?>" class="img-responsive" style="text-align:center" id="showimage">
        </div>
        <div class="w3-form-group form-group">
            <div class=" w3-form-button clearfix">
                <div class="registered-action1">
                    <button type="submit" class="btn btn-primary"><span>Đăng ký </span></button>
                </div>
            </div>
        </div>
    </div>
    <?php
    $this->endWidget();
    ?>
</div>