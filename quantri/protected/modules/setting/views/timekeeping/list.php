<?php
/* @var $this NewsController */
/* @var $model News */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#redirect-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            Quản lý chấm công
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('setting/timekeeping/create'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                Tạo mới
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <?php
            Yii::import('common.extensions.LinkPager.LinkPager');
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'redirect-grid',
                'dataProvider' => $model->search(),
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
                    ),
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => 100,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    'name' => array(
                        'name' => 'name',
                        'type' => 'raw',
                    ),
                    'filepath' => array(
                        'name' => 'filepath',
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{_preview} {update} ',
                        'htmlOptions' => array(
                            'style' => 'width: 150px;',
                            'class' => 'button-column',
                        ),
                        'buttons' => array(
                            '_preview' => array(
                                        'label' => '',
                                        'imageUrl' => false,
                                        'type' => 'raw',
                                        'url' => function($data) {
                                            $api = new ClaAPI();
                                            $respon = $api->createUrl(array(
                                                'basepath' => '/site/timekeeping/show',
                                                'params' => json_encode(array('id' => $data->id, 'alias' => $data->alias)),
                                                'absolute' => 'true',
                                            ));
                                            if ($respon) {
                                                return $respon['url'];
                                            }
                                        },
                                                'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-search', 'title' => 'Preview', 'target' => '_blank'),
                                            ),
                            'update' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("/setting/timekeeping/update", array("id" => $data->id))',
                                'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                            ),
                        ),
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>