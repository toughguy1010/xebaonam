<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('coupon', 'manager_coupon_campaign'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('setting/couponCampaign/create'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('coupon', 'create'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">

            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'car-categories-grid',
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
                    'name' => array(
                        'name' => 'Tên chiến dịch',
                        'value' => function($data) {
                            return $data->name;
                        }
                    ),
                    'released_date' => array(
                        'name' => 'Bắt đầu',
                        'value' => function($data) {
                            return ($data->released_date) ? date('d-m-Y H:i:s', $data->released_date) : '';
                        }
                    ),
                    'expired_date' => array(
                        'name' => 'Kết thúc',
                        'value' => function($data) {
                            return ($data->expired_date) ? date('d-m-Y H:i:s', $data->expired_date) : '';
                        }
                    ),
                    'content' => array(
                        'name' => 'Nội dung',
                        'value' => function($data) {
                            return CouponCampaign::getContentCampaign($data);
                        }
                    ),
                    'coupon_number' => array(
                        'name' => 'Số mã',
                        'value' => function($data) {
                            return $data->coupon_number;
                        }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{view} {delete} ',
                        'buttons' => array(
                            'update' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("setting/couponCampaign/update", array("id" => $data["id"]))',
                                'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                            ),
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("setting/couponCampaign/delete", array("id" => $data["id"]))',
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