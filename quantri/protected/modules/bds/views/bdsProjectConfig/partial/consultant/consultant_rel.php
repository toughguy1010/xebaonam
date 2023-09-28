<?php if ($model->isNewRecord) { ?>
    <a id="addConsultant" href="javascript:void(0);" class="btn btn-sm btn-light"
       onclick="alert('<?php echo Yii::t('bds_project_config', 'disable_help'); ?>');">
        <?php echo Yii::t('bds_project_config', 'consultant_add'); ?>
    </a>
<?php } else { ?>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/style3/colorbox.css"></link>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>
    <a id="addConsultant"
       href="<?php echo Yii::app()->createUrl('bds/BdsProjectConfig/addConsultantToRelation', array('pid' => $model->id)) ?>"
       class="btn btn-sm btn-primary">
        <?php echo Yii::t('bds_project_config', 'consultant_add'); ?>
    </a>
    <a target="_blank"
       href="<?php echo Yii::app()->createUrl('economy/consultant/create') ?>"
       class="btn btn-sm btn-primary">
        <?php echo Yii::t('bds_project_config', 'consultant_add_new'); ?>
    </a>
    <?php
    Yii::import('common.extensions.LinkPager.LinkPager');
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'consultant-groups-grid',
        'dataProvider' => $model->SearchConsultantRel(),
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

//                'header' => '',
//                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
//                'htmlOptions' => array('width' => '30px',),
            'name' => array(
                'type' => 'raw',
                'value' => function ($data) {
                    return ($val = Consultant::model()->findByPk($data->consultant_id)->name) ? $val : 'Không tồn tại';
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
                'deleteButtonUrl' => 'Yii::app()->createUrl("/bds/bdsProjectConfig/deleteConsultantInRel",array("bds_project_config_id"=>$data["bds_project_config_id"],"consultant_id"=>$data["consultant_id"]))',
            ),
        ),
    ));
    ?>
    <script>
        jQuery(document).ready(function () {
            $("#addConsultant").colorbox({width: "80%", maxHeight: '100%', overlayClose: false});
            <?php if (Yii::app()->request->getParam('create')) { ?>
            $("#addConsultant").trigger('click');
            <?php } ?>
        });
    </script>
<?php } ?>