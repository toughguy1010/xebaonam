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
            <?php echo Yii::t('affiliate', 'manager_affiliate'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('affiliate/expertransAffiliateLink/create'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('affiliate', 'create'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">

            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'affiliate-categories-grid',
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
                   
                    'money' => [
                        'name' => 'money',
                        'value' => function($data) {
                            return number_format($data->money, 0, ',', '.');
                        }
                    ],
                    'note',
                    'status' => [
                        'name' => 'status',
                        'value' => function($data) {
                            return AffiliateTransferMoney::getNameStatus($data->status);
                        }
                    ],

                ),
            ));
            ?>
        </div>
    </div>
</div>