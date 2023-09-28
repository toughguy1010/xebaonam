<?php if (isset($model->isNewRecord) && $model->isNewRecord) { ?>
    <a id="addNews" href="javascript:void(0);" class="btn btn-sm btn-light"
       onclick="alert('<?php echo Yii::t('product', 'product_rel_addproduct_disable_help'); ?>');">
        <?php echo Yii::t('product', 'product_group_addproduct'); ?>
    </a>
<?php } else { ?>

    <!--    <link rel="stylesheet" href="--><?php //echo Yii::app()->request->baseUrl; ?><!--/js/colorbox/style3/colorbox.css">-->
    <!--    <script src="--><?php //echo Yii::app()->request->baseUrl; ?><!--/js/colorbox/jquery.colorbox-min.js"></script>-->

    <a id="addNews"
       href="<?php echo Yii::app()->createUrl('economy/course/addnewstorelation', array('pid' => $model->id)) ?>"
       class="btn btn-sm btn-primary">
        <?php echo Yii::t('course', 'add_news'); ?>
    </a>
    <?php
    Yii::import('common.extensions.LinkPager.LinkPager');
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'news-groups-grid',
        'dataProvider' => $model->SearchNewsRel(),
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
                'header' => '',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
                'htmlOptions' => array('width' => '30px',),
            ),
            'name' => array(
                'name' => 'Tiêu đề - Title',
                'type' => 'raw',
                'value' => function ($data) {
                    $val = News::model()->findByPk($data->news_id)['news_title'];
                    return (isset($val)) ? $val : 'Tin đã bị xóa hoặc không tồn tại';
                },
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
                'deleteButtonUrl' => 'Yii::app()->createUrl("/economy/course/deleteNewsInRel",array("course_id"=>$data["course_id"],"news_id"=>$data["news_id"]))',
            ),
        ),
    ));
    ?>
    <script>
        jQuery(document).ready(function () {
            $("#addNews").colorbox({width: "80%", maxHeight: '100%', overlayClose: false});
            <?php if (Yii::app()->request->getParam('create')) { ?>
            $("#addNews").trigger('click');
            <?php } ?>
        });
    </script>
<?php } ?>