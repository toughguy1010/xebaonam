<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('site', 'site_manager'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('/v3admin/sites/create'); ?>" class="btn btn-xs btn-primary">
                <i class="icon-plus"></i>
                <?php echo Yii::t('site', 'site_create'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">

            <?php
            Yii::import('common.extensions.LinkPager.LinkPager');
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'site-settings-grid',
                'dataProvider' => $model->search(),
                'filter' => NULL,
                'enableSorting' => true,
                'pager' => array(
                    'class' => 'LinkPager',
                    'header' => '',
                    'nextPageLabel' => '&raquo;',
                    'prevPageLabel' => '&laquo;',
                    'lastPageLabel' => Yii::t('common', 'last_page'),
                    'firstPageLabel' => Yii::t('common', 'first_page'),
                ),
                'summaryText' => '',
                'itemsCssClass' => 'table table-bordered table-hover',
                'columns' => array(
                    'id',
                    'domain',
                    'type',
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update}  {delete} ',
                        'buttons' => array(
                            'update' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("v3admin/sites/update", array("id" => $data["id"]))',
                                'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                            ),
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("v3admin/sites/delete", array("id" => $data["id"]))',
                                'options' => array('class' => 'icon-trash', 'title' => Yii::t('common', 'update')),
                            ),
                        ),
                        'viewButtonLabel' => '',
                        'updateButtonOptions' => array('class' => 'icon-edit'),
                        'updateButtonImageUrl' => false,
                        'updateButtonLabel' => '',
                        'deleteButtonOptions' => array('class' => 'icon-trash'),
                        'deleteButtonImageUrl' => false,
                        'deleteButtonLabel' => '',
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>