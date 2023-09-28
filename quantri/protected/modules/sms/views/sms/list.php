<?php
/* @var $this NewsController */
/* @var $model News */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#sms-sended-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('sms', 'message_sended'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('sms/sms/sendsms'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('sms', 'sendsms'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="search-active-form" style="position: relative; margin-top: 10px;">
                <?php
                $this->renderPartial('_search', array(
                    'model' => $model,
                ));
                ?>
                <div class="pageSizebox" style="float: right;margin-bottom: 10px;">
                    <div class="pageSizealign">
                        <?php
                        $this->widget('common.extensions.PageSize.PageSize', array(
                            'mGridId' => 'customer-group-grid', //Gridview id
                            'mPageSize' => Yii::app()->request->getParam(Yii::app()->params['pageSizeName']),
                            'mDefPageSize' => Yii::app()->params['defaultPageSize'],
                        ));
                        ?>
                    </div>
                </div>
            </div><!-- search-form -->
            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'sms-sended-grid',
                'dataProvider' => $model->search(),
                'itemsCssClass' => 'table table-bordered table-hover vertical-center',
                'summaryText' => false,
                'filter' => null,
                'enableSorting' => false,
                'columns' => array(
                    'number' => array(
                        'header' => '',
                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
                        'htmlOptions' => array('style' => 'width: 50px; text-align: center;')
                    ),
                    'text_message' => array(
                        'header' => Yii::t('sms', 'text_message'),
                        'name' => 'text_message',
                        'type' => 'raw',
                    ),
                    'count_message' => array(
                        'name' => 'count_message',
                        'type' => 'raw',
                    ),
                    'type' => array(
                        'name' => 'type',
                        'type' => 'raw',
                        'value' => 'Sms::getTypeInput($data->type)'
                    ),
                    'group_customer_id' => array(
                        'name' => 'group_customer_id',
                        'value' => 'SmsCustomerGroup::getGroupnameById($data->group_customer_id)'
                    ),
                    'number_person' => array(
                        'name' => 'number_person',
                        'type' => 'raw',
                    ),
                    'ary_provider' => array(
                        'name' => 'ary_provider',
                        'type' => 'raw',
                    ),
                    'created_time' => array(
                        'name' => 'created_time',
                        'value' => function($data) {
                            return date('d-m-Y H:i:s', $data->created_time);
                        }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{view}',
                        'header' => Yii::t('sms', 'view_detail_sms'),
                        'buttons' => array(
                            'update' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("sms/smsCustomer/update", array("id" => $data["id"]))',
                                'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                            ),
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("sms/smsCustomer/delete", array("id" => $data["id"]))',
                                'options' => array('class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
                            ),
                        ),
                        'htmlOptions' => array(
                            'style' => 'width: 150px;',
                            'class' => 'button-column',
                        ),
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>