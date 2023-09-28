<div class="form-group no-margin-left">
    <?php echo $form->labelEx($courseInfo, 'itinerary', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">

        <?php if (isset($model->isNewRecord) && $model->isNewRecord) { ?>
            <button class="btn btn-sm btn-light"
                    onclick="alert('<?php echo Yii::t('course', 'schedule_create_disable_help'); ?>');"
                    type="button">
                Thêm thuộc tính
            </button>
        <?php } else { ?>
            <div id="showday2">
                <button class="btn btn-sm btn-info" onclick="add_op()" type="button">Thêm thông tin mô tả</button>
                <hr>
                <?php
                $itinerary = json_decode($courseInfo->itinerary, true);
                if (count($itinerary)) {
                    foreach ($itinerary as $key => $val) { ?>
                        <div class="form-group no-margin-left">
                            <input class="span12 col-sm-5" name="CourseDynamicField[name][]"
                                   value="<?php echo $val['name'] ?>"
                                   id="CourseDynamicField_name" type="text">
                            <input class="span12 col-sm-5" name="CourseDynamicField[content][]"
                                   value="<?php echo strip_tags($val['content']) ?>"
                                   id="CourseDynamicField_name" type="text">
                            <div class="col-sm-2">
                                <button class="btn btn-sm btn-danger" type="button" onclick="removeFrom(this)">Xóa
                                </button>
                            </div>
                        </div>
                        <?
                    }
                }
                ?>
            </div>
        <?php } ?>
    </div>
</div>
<!---->

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($courseInfo, 'review', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">

        <?php if (isset($model->isNewRecord) && $model->isNewRecord) { ?>
            <button class="btn btn-sm btn-light"
                    onclick="alert('<?php echo Yii::t('course', 'schedule_create_disable_help'); ?>');"
                    type="button">
                Thêm thuộc tính
            </button>
        <?php } else { ?>
            <div id="showday3">
                <button class="btn btn-sm btn-info" onclick="add_op_review()" type="button">Thêm thông tin mô tả
                </button>
                <hr>
                <?php
                $itinerary = json_decode($courseInfo->review, true);
                if (count($itinerary)) {
                    foreach ($itinerary as $key => $val) { ?>
                        <div class="form-group no-margin-left">
                            <input type="file" class="span12 col-sm-2" name="CourseReviewDynamicField[file][]"
                                   id="CourseReviewDynamicField_file">
                            <input class="span12 col-sm-4" name="CourseReviewDynamicField[name][]"
                                   value="<?php echo $val['name'] ?>"
                                   id="CourseReviewDynamicField_name" type="text">
                            <input class="span12 col-sm-4" name="CourseReviewDynamicField[content][]"
                                   value="<?php echo strip_tags($val['content']) ?>"
                                   id="CourseReviewDynamicField_name" type="text">
                            <div class="col-sm-2">
                                <button class="btn btn-sm btn-danger" type="button" onclick="removeFrom(this)">Xóa
                                </button>
                            </div>
                        </div>
                        <?
                    }
                }
                ?>
            </div>
        <?php } ?>
    </div>
</div>
<!---->
<script>
    function add_op() {
        $("#showday2").append('<div class="form-group no-margin-left">            <input class="span12 col-sm-5" name="CourseDynamicField[name][]" placeholder="Tên" value="" id="CourseDynamicField_name" type="text">            <input placeholder="Nội dung" class="push-sm-1 col-sm-5" name="CourseDynamicField[content][]" value="" id="CourseDynamicField_name" type="text">            <div class="col-sm-2">            <button class="btn btn-sm btn-danger" type="button" onclick="removeFrom(this)">Xóa            </button>            </div>            </div>');

    }
    function add_op_review() {
        $("#showday3").append('<div class="form-group no-margin-left">  <input type="file" class="span12 col-sm-2" name="CourseReviewDynamicField[file][]"  id="CourseReviewDynamicField_file">  <input class="span12 col-sm-4" name="CourseReviewDynamicField[name][]" placeholder="Tên" value="" id="CourseReviewDynamicField_name" type="text">            <input placeholder="Nội dung" class="push-sm-1 col-sm-4" name="CourseReviewDynamicField[content][]" value="" id="CourseReviewDynamicField_name" type="text">            <div class="col-sm-2">            <button class="btn btn-sm btn-danger" type="button" onclick="removeFrom(this)">Xóa            </button>            </div>            </div>');

    }
    function removeFrom(ev) {
        $(ev).parent().parent().remove();
    }

</script>