<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#product-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('course', 'course_register_list'); ?>
        </h4>

        <div class="widget-toolbar no-border">

        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="search-active-form" style="position: relative; margin-top: 10px;">
                <?php
                //                $this->renderPartial('_search', array(
                //                    'model' => $model,
                //                ));
                ?>
                <div class="pageSizebox" style="position: absolute; right: 0px; top: 0px;">
                    <div class="pageSizealign">
                        <?php
                        $this->widget('common.extensions.PageSize.PageSize', array(
                            'mGridId' => 'product-grid', //Gridview id
                            'mPageSize' => Yii::app()->request->getParam(Yii::app()->params['pageSizeName']),
                            'mDefPageSize' => Yii::app()->params['defaultPageSize'],
                        ));
                        ?>
                    </div>
                </div>
            </div><!-- search-form -->
            <div class="clearfix" style="height: 30px;"></div>
            <?php
            Yii::import('common.extensions.LinkPager.LinkPager');
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'course-grid',
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
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => 100,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    'name',
                    'email',
                    'phone',
                    'quantity',
                    'id' => array(
                        'name' => 'id',
                        'type' => 'html',
                        'value' => function ($data) {
                            return '<a href=' . Yii::app()->createUrl("economy/event/viewRegister", array("event_id" => $data->event_id)) . '>' . Yii::app()->controller->getEventName($data->event_id) . '</a>';
                        }
                    ),
                    'created_time' => array(
                        'name' => 'created_time',

                        'value' => function ($data) {
                            return ($data->created_time) ? date('d-m-Y', $data->created_time) : '';
                        }
                    ),
                    'status' => array(
                        'name' => 'status',
                        'value' => function ($data) {
                            return ($data->status == 1) ? 'Tham gia' : 'Chờ duyệt';
                        }
                    ),
                    'user' => array(
                        'name' => '',
                        'value' => function ($data) {
                            return ($data->user_id) ? 'Thành viên' : 'Vãng lai';
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
                        'buttons' => array(
                            'update' => array(
                                'url' => 'Yii::app()->createUrl("economy/event/updateEventRegiter", array("id" => $data->id))',
                            ),
                            'delete' => array(
                                'url' => 'Yii::app()->createUrl("economy/event/deleteEventRegister", array("id" => $data->id))',
                            ),
                        ),
                    ),
//                    'translate' => array(
//                        'header' => Yii::t('common', 'translate'),
//                        'type' => 'raw',
//                        'visible' => ClaSite::showTranslateButton() ? true : false,
//                        'htmlOptions' => array('class' => 'button-column'),
//                        'value' => function ($data) {
//                            $this->widget('application.widgets.translate.translate', array('baseUrl' => '/economy/event/update', 'params' => array('id' => $data->id)));
//                        }
//                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>