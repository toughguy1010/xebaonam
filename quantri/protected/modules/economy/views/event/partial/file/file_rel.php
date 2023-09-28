<?php if ($model->isNewRecord) { ?>
    <a id="addFile" href="javascript:void(0);" class="btn btn-sm btn-light"
       onclick="alert('<?php echo Yii::t('product', 'product_rel_addproduct_disable_help'); ?>');">
        <?php echo Yii::t('product', 'product_group_addproduct'); ?>
    </a>
<?php } else { ?>
    <a id="addFile"
       href="<?php echo Yii::app()->createUrl('economy/event/addfiletorelation', array('pid' => $model->id)) ?>"
       class="btn btn-sm btn-primary">
        <?php echo Yii::t('event', 'add_file'); ?>
    </a>
    <a target="_blank"
       href="<?php echo Yii::app()->createUrl('media/file/create') ?>"
       class="btn btn-sm btn-primary">
        <?php echo Yii::t('file', 'add_new_file'); ?>
    </a>
    <?php
    Yii::import('common.extensions.LinkPager.LinkPager');
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'file-groups-grid',
        'dataProvider' => $model->SearchFileRel(),
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
                'header' => 'Display Name',
                'type' => 'raw',
                'value' => function ($data) {
                    $val = Files::model()->findByPk($data->file_id);
                    return $val ? '' . $val->display_name . '' : 'Tin <span style="color: #cc0000;">ID: ' . $data->file_id . '</span> không tồn tại';
                },
            ),
            'download' => array(
                'header' => 'download',
                'type' => 'raw',
                'htmlOptions' => array('width' => '20px',),
                'value' => function ($data) {
                    $api = new ClaAPI();
                    $respon = $api->createUrl(array(
                        'basepath' => 'media/media/downloadfile',
                        'params' => json_encode(array('id' => $data->file_id)),
                        'absolute' => 'true',
                    ));
                    if ($respon) {
                        return '<a href="' . $respon['url'] . '"><i class="icon-download" style="font-size: 19px;"></i></a>';
                    }
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
                'deleteButtonUrl' => 'Yii::app()->createUrl("/economy/event/deleteFileInRel",array("event_id"=>$data["event_id"],"file_id"=>$data["file_id"]))',
            ),
        ),
    ));
    ?>
    <script>
        jQuery(document).ready(function () {
            $("#addFile").colorbox({width: "80%", maxHeight: '100%', overlayClose: false});
            <?php if (Yii::app()->request->getParam('create')) { ?>
            $("#addFile").trigger('click');
            <?php } ?>
        });
    </script>
<?php } ?>