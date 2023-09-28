<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#news-categories-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});

jQuery(document).on('change','.updateorder',function(){
var url = jQuery(this).attr('rel');
var or  = jQuery(this).val();
   jQuery.ajax({
        type: 'POST',
        url: url,
        data: {or: or},
        success: function(){
            $.fn.yiiGridView.update('news-categories-grid');
        }
   }); 
});

");
?>

<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('service', 'manager_question'); ?>
        </h4>

    </div>
    <div class="widget-body">
        <div class="widget-main">

            <div class="search-active-form" style="position: relative; margin-top: 10px;">
                <?php
                $this->renderPartial('_search', array(
                    'model' => $model,
                ));
                ?>
            </div><!-- search-form -->

            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'service-categories-grid',
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
                    array(
                        'class' => 'CCheckBoxColumn',
                        'value' => '$data["id"]',
                        'selectableRows' => 150,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    'campaign_id' => array(
                        'name' => 'campaign_id',
                        'value' => function($data) {
                            $campaign = QuestionCampaign::model()->findByPk($data->campaign_id);
                            return (isset($campaign->name) && $campaign->name) ? $campaign->name : '';
                        }
                    ),
                    'username' => array(
                        'name' => 'username',
                        'type' => 'raw',
                    ),
                    'email' => array(
                        'name' => 'email',
                    ),
                    'content' => array(
                        'name' => 'content',
                    ),
                    'answer' => array(
                        'name' => 'answer',
                        'type' => 'raw',
                        'value' => function($data) {
                            return (isset($data->answer) && $data->answer) ? 'Đã trả lời' : '<b>Chưa trả lời</b>';
                        }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update} {delete} ',
                        'buttons' => array(
                            'update' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("service/question/update", array("id" => $data["id"]))',
                                'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                            ),
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("service/question/delete", array("id" => $data["id"]))',
                                'options' => array('class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
                            ),
                        ),
                        'htmlOptions' => array(
                            'style' => 'width: 150px;',
                            'class' => 'button-column',
                        ),
                    ),
                    'translate' => array(
                        'header' => Yii::t('common', 'translate'),
                        'type' => 'raw',
                        'visible' => ClaSite::showTranslateButton() ? true : false,
                        'htmlOptions' => array('class' => 'button-column'),
                        'value' => function($data) {
                            $this->widget('application.widgets.translate.translate', array('baseUrl' => '/service/question/update', 'params' => array('id' => $data['id'])));
                        }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>