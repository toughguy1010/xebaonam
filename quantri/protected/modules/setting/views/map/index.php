<?php
//hatv
echo ($map_api_key) ? 'Mã API:' . $map_api_key : '<p style="color:red"> Chưa nhật mã Google_Map_API, Sẽ có thể không load được map (<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" TARGET="_blank"> Hướng dẫn</a>)<p>';
/* @var $this MapController */
/* @var $model Maps */
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#maps-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="row">
    <div class="col-sm-5">
        <div class="widget-box">
            <div class="widget-header widget-header-flat">
                <h4 class="smaller">
                    Các địa điểm
                </h4>
            </div>
            <div class="widget-body">   
                <div class="widget-main">
                    <?php
                    Yii::import('common.extensions.LinkPager.LinkPager');
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'maps-grid',
                        'itemsCssClass' => 'table table-bordered table-hover',
                        'pager' => array(
                            'class' => 'LinkPager',
                            'header' => '',
                            'nextPageLabel' => '&raquo;',
                            'prevPageLabel' => '&laquo;',
                            'lastPageLabel' => Yii::t('common', 'last_page'),
                            'firstPageLabel' => Yii::t('common', 'first_page'),
                        ),
                        'summaryText' => '',
                        'dataProvider' => $model->search(),
                        'filter' => null,
                        'columns' => array(
                            'name',
//                            'address',
//                            'email',
//                            'phone',
//                            'website',
                            'headoffice' => array(
                                'name' => 'headoffice',
                                'type' => 'raw',
                                'htmlOptions' => array('style' => 'text-align:center; min-width:105px;'),
                                'value' => function($data) {
                            if ($data->headoffice == Maps::IS_HEADOFFICE)
                                return '<i class="icon-check"></i>';
                            return '';
                        }
                            ),
                            array(
                                'class' => 'CButtonColumn',
                                'template' => '{update}  {delete} ',
                                'viewButtonLabel' => '',
                                'updateButtonOptions' => array('class' => 'icon-edit'),
                                'updateButtonImageUrl' => false,
                                'updateButtonLabel' => '',
                                'deleteButtonOptions' => array('class' => 'icon-trash'),
                                'deleteButtonImageUrl' => false,
                                'deleteButtonLabel' => '',
                            ),
                            'translate' => array(
                                'header' => Yii::t('common', 'translate'),
                                'type' => 'raw',
                                'visible' => ClaSite::showTranslateButton() ? true : false,
                                'htmlOptions' => array('class' => 'button-column'),
                                'value' => function($data) {
                            $this->widget('application.widgets.translate.translate', array('baseUrl' => '/setting/map/update', 'params' => array('id' => $data->id)));
                        }
                            ),
                        ),
                    ));
                    ?>
                    <p class="alert alert-info">
                        <?php echo Yii::t('map', 'map_help') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-7">
        <?php
        $this->renderPartial('create', array('model' => $model, 'map_api_key' => $map_api_key));
        ?>
    </div>
</div>