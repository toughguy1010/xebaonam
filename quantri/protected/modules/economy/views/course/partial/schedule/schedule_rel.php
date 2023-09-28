<?php if (isset($model->isNewRecord) && $model->isNewRecord) { ?>
    <a id="addSchedule" href="javascript:void(0);" class="btn btn-sm btn-light"
       onclick="alert('<?php echo Yii::t('course', 'schedule_create_disable_help'); ?>');">
        <?php echo Yii::t('course', 'schedule_create'); ?>
    </a>
<?php } else { ?>
<!--    add js-->

    <a id="addSchedule"
       href="<?php echo Yii::app()->createUrl('economy/course/addSchedule', array('pid' => $model->id)) ?>"
       class="btn btn-sm btn-primary">
        <?php echo Yii::t('course', 'schedule_create'); ?>
    </a>
    <?php
    Yii::import('common.extensions.LinkPager.LinkPager');
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'schedule-groups-grid',
        'dataProvider' => $model->SearchSchedule(),
        'itemsCssClass' => 'table table-bordered table-hover vertical-center',
        'filter' => null,
        'enableSorting' => false,
        'pager' => array(
            'class' => 'LinkPager',
            'header' => '',
            'nextPageLabel' => '&raquo;',
            'prevPageLabel' => '&laquo;',
            'lastPageLabel' => Yii::t('common', 'last_page'),
            'firstPageLabel' => Yii::t('common', 'first_page'),
        ),
        'columns' => array(
            'course_open' => array(
                'name' => Yii::t('course','course_open'),
                'value' => function ($data) {
                    return ($data->course_open) ? date('d-m-Y', $data->course_open) : '';
                }
            ),
            'course_finish' => array(
                'name' => Yii::t('course','course_finish'),
                'value' => function ($data) {
                    return ($data->course_finish) ? date('d-m-Y', $data->course_finish) : '';
                }
            ),
            'price' => array(
                'name' => Yii::t('course','price'),
//                'value' => function ($data) {
//                    return ($data->course_finish) ? date('d-m-Y', $data->course_finish) : '';
//                }
            ),
            'price_member' => array(
                'name' => Yii::t('course','price_member'),
//                'value' => function ($data) {
//                    return ($data->course_finish) ? date('d-m-Y', $data->course_finish) : '';
//                }
            ),

//            'status',
            array(
                'class' => 'CButtonColumn',
                'template' => '{delete} ',
                'viewButtonLabel' => '',
                'updateButtonOptions' => array('class' => 'icon-edit'),
                'updateButtonImageUrl' => false,
                'updateButtonLabel' => '',
                'deleteButtonOptions' => array('class' => 'icon-trash'),
                'deleteButtonImageUrl' => false,
                'deleteButtonLabel' => '',
                'deleteButtonUrl' => 'Yii::app()->createUrl("/economy/course/deleteSchedule",array("id"=>$data["id"]))',
            ),
        ),
    ));
    ?>
    <script>
        jQuery(document).ready(function () {
            $("#addSchedule").colorbox({width: "80%", maxHeight: '100%', overlayClose: false});
            <?php if (Yii::app()->request->getParam('create')) { ?>
            $("#addSchedule").trigger('click');
            <?php } ?>
        });
    </script>
<?php } ?>