<h3><?php echo $model->name ?></h3>

<div>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'news-categories-grid',
        'dataProvider' => $model_code->search(),
        'itemsCssClass' => 'table table-bordered table-hover vertical-center',
        'summaryText' => false,
        'filter' => null,
        'enableSorting' => false,
        'columns' => array(
            'code' => array(
                'name' => 'code',
                'type' => 'raw',
            ),
            'used' => array(
                'name' => 'used',
                'type' => 'raw',
            ),
            'total' => array(
                'name' => 'Tổng số',
                'value' => function($data) {
                    return CouponCampaign::getTotalCampaign($data->campaign_id);
                }
            ),
        ),
    ));
    ?>
</div>

