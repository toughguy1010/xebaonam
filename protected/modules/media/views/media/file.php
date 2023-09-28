<div class="download">
    <?php
    Yii::import('common.extensions.LinkPager.LinkPager');
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'folder-grid',
        'itemsCssClass' => 'table table-bordered table-hover',
        'dataProvider' => $dataprovider,
        'filter' => null,
        'pager' => array(
            'class' => 'LinkPager',
            'header' => '',
            'nextPageLabel' => '&raquo;',
            'prevPageLabel' => '&laquo;',
            'lastPageLabel' => Yii::t('common', 'last_page'),
            'firstPageLabel' => Yii::t('common', 'first_page'),
        ),
        'columns' => array(
            'display_name',
            'size' => array(
                'name' => 'size',
                'value' => function($data) {
            return Files::GetStringSizeFormat($data->size);
        }
            ),
            'extension',
            'created_time' => array(
                'name' => 'created_time',
                'type' => 'raw',
                'value' => function($data) {
            return date('m-d-Y', $data->created_time);
        }
            ),
            'download' => array(
                'header' => Yii::t('common', 'download'),
                'type' => 'raw',
                'value' => function($data) {
            return '<a href="' . Yii::app()->createUrl('media/media/downloadfile', array('id' => $data->id)) . '">' . Yii::t('common', 'download') . '</a>';
        }
            )
        ),
    ));
    ?>
</div>