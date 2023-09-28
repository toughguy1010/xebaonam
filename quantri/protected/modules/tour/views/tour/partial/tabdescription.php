<div class="form-group no-margin-left">
    <?php echo $form->labelEx($tourInfo, 'price_include', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($tourInfo, 'price_include', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($tourInfo, 'price_include'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($tourInfo, 'schedule', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($tourInfo, 'schedule', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($tourInfo, 'schedule'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($tourInfo, 'policy', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($tourInfo, 'policy', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($tourInfo, 'policy'); ?>
    </div>
</div>


<div class="form-group no-margin-left">
    <?php echo $form->labelEx($tourInfo, 'review', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">

        <?php if (isset($model->isNewRecord) && $model->isNewRecord) { ?>
            <button class="btn btn-sm btn-light"
                    onclick="alert('<?php echo Yii::t('course', 'schedule_create_disable_help'); ?>');"
                    type="button">
                Thêm thuộc tính
            </button>
        <?php } else { ?>
            <div id="showday3">
                <button class="btn btn-sm btn-info" onclick="add_op_review()" type="button">Thêm đánh giá
                </button>
                <hr>
                <?php
                $itinerary = json_decode($tourInfo->review, true);
                if (count($itinerary)) { ?>
                    <?php foreach ($itinerary as $key => $val) { ?>
                        <div class="form-group no-margin-left">
                            <input class="span12 col-sm-2" name="TourReviewDynamicField[name][]"
                                   value="<?php echo $val['name'] ?>"
                                   id="TourReviewDynamicField_name" type="text">
                            <input class="span12 col-sm-6" name="TourReviewDynamicField[content][]"
                                   value="<?php echo strip_tags($val['content']) ?>"
                                   id="TourReviewDynamicField_name" type="text">
                            <div class="col-sm-2">
                                <button class="btn btn-sm btn-danger" type="button" onclick="removeFrom(this)">Xóa
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
<!---->

<!---->
<script>
    function add_op_review() {
        $("#showday3").append('<div class="form-group no-margin-left">  <input class="span12 col-sm-2" name="TourReviewDynamicField[name][]" placeholder="Tên" value="" id="TourReviewDynamicField_name" type="text">            <input placeholder="Nội dung" class="span12 col-sm-6" name="TourReviewDynamicField[content][]" value="" id="TourReviewDynamicField_name" type="text">            <div class="col-sm-2">            <button class="btn btn-sm btn-danger" type="button" onclick="removeFrom(this)">Xóa            </button>            </div>            </div>');

    }

    function removeFrom(ev) {
        $(ev).parent().parent().remove();
    }

</script>