<?php if ($model->isNewRecord) { ?>
    <a id="addVideos" href="javascript:void(0);" class="btn btn-sm btn-light"
       onclick="alert('<?php echo Yii::t('product', 'product_rel_addproduct_disable_help'); ?>');">
        <?php echo Yii::t('product', 'product_group_addproduct'); ?>
    </a>
<?php } else { ?>
    <!--    <link rel="stylesheet" href="--><?php //echo Yii::app()->request->baseUrl; ?><!--/js/colorbox/style3/colorbox.css"></link>-->
    <!--    <script src="--><?php //echo Yii::app()->request->baseUrl; ?><!--/js/colorbox/jquery.colorbox-min.js"></script>-->
    <a id="addVideos"
       href="<?php echo Yii::app()->createUrl('economy/course/addVideoToRelation', array('pid' => $model->id)) ?>"
       class="btn btn-sm btn-primary">
        <?php echo Yii::t('course', 'add_exist_video'); ?>
    </a>
    <a href="<?php echo Yii::app()->createUrl('media/video/create') ?>"
       target="_blank"
       class="btn btn-sm btn-primary">
        <?php echo Yii::t('course', 'add_new_video'); ?>
    </a>

    <?php
//    Yii::import('common.extensions.LinkPager.LinkPager');
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'video-groups-grid',
        'dataProvider' => $model->SearchVideosRel(),
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
            'number' => array(
                'header' => '#',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
                'htmlOptions' => array('width' => '30px',),
            ),
            'name' => array(
                'name' => 'Tiêu đề - Title',
                'type' => 'raw',
                'value' => function ($data) {
                    $val = Videos::model()->findByPk($data->video_id)->video_title;
                    return ($val) ? $val : '</span color="red">Video không tồn tại</span>';
                },
            ),
            'order' => array(
                'header' => 'Thứ tự',
                'type' => 'raw',
                'value' => function ($data) {
                    return '<input onchange="update(this,' . $data->course_id . ',' . $data->video_id . ')" type="text" value="' . $data->order . '">';
                },
                'htmlOptions' => array('width' => '30px',),
            ),
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
                'deleteButtonUrl' => 'Yii::app()->createUrl("/economy/course/deleteVideoInRel",array("course_id"=>$data["course_id"],"video_id"=>$data["video_id"]))',
            ),
        ),
    ));
    ?>
    <script>
        function update(e, course_id, video_id) {
            $(".loading-shoppingcart").show();
            var courseid = course_id;
            var videoid = video_id;
            var order_num = e.value;
            var url = "<?php echo Yii::app()->createUrl("/economy/course/updateOrder", array("id" => $model->id));?>";
            $.ajax({
                url: url,
                dataType: "json",
                data: {course_id: courseid, order_num: order_num, video_id: videoid},
                success: function (msg) {
                    $(".loading-shoppingcart").hide();
                    if (msg.code != 200){
                        location.reload();
                    }
                }
            });
        }
        jQuery(document).ready(function () {
            $("#addVideos").colorbox({width: "80%", maxHeight: '100%', overlayClose: false});
            <?php if (Yii::app()->request->getParam('create')) { ?>
            $("#addVideos").trigger('click');
            <?php } ?>
        });
    </script>
<?php } ?>