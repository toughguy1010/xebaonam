<div class="folder download">
    <div class="row listfile">
        <?php foreach ($folders as $folder) { ?>
            <div class="col-xs-3">
                <a class="folder-link" href="<?php echo $folder['link']; ?>" title="<?php echo $folder['folder_name']; ?>">
                    <?php echo $folder['folder_name']; ?>
                </a>
            </div>
        <?php } ?>
    </div>
     <?php
     Yii::import('common.extensions.LinkPager.LinkPager');
     $this->widget('zii.widgets.grid.CGridView', array(
          'id' => 'folder-grid',
          'itemsCssClass' => 'table table-bordered table-hover',
          'summaryText' => '',
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
                    'value' => function ($data) {
                         return Files::GetStringSizeFormat($data->size);
                    }
               ),
               'extension',
               'created_time' => array(
                    'name' => 'created_time',
                    'type' => 'raw',
                    'value' => function ($data) {
                         return date('m-d-Y', $data->created_time);
                    }
               ),
               'detail' => array(
                    'header' => Yii::t('common', 'detail'),
                    'type' => 'raw',
                    'value' => function ($data) {
                         return '<a href="' . Yii::app()->createUrl('media/media/detailfile', array('id' => $data->id, 'alias' => HtmlFormat::parseToAlias($data->display_name))) . '">' . Yii::t('common', 'detail') . '</a>';
                    }
               ),
               'download' => array(
                    'header' => Yii::t('common', 'download'),
                    'type' => 'raw',
                    'value' => function ($data) {
                         return '<a href="' . Yii::app()->createUrl('media/media/downloadfile', array('id' => $data->id)) . '">' . Yii::t('common', 'download') . '</a>';
                    }
               )
          ),
     ));
     ?>
</div>