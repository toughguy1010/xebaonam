<div class="col-xs-12 no-padding">
    <div class="widget-main">
        <h3>Các comment liên quan</h3>                     
        <?php
        Yii::import('common.extensions.LinkPager.LinkPager');
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'comment-grid',
            'dataProvider' => $answer->search(),
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
                    'header' => '#',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
                ),
                //'news_id',
                'name' => array(
                    'name' => 'Tên',
                    'type' => 'raw',
                    'value' => function($data) {
                        return '<a href="javascript:void(0)">' . $data->name . '</a>';
                    },
                ),
                'email_phone',
//                    'rating',
                'content',
                'created_time' => array(
                    'name' => 'created_time',
                    'type' => 'raw',
                    'value' => function($data) {
                        return date('d/m/Y - h:s:t', $data->created_time);
                    },
                ),
                array(
                    'header' => 'Action',
                    'class' => 'CButtonColumn',
                    'template' => '{show}{hide}{delete}',
                    'buttons' => array
                        (
                        'delete' => array
                            (
                            'url' => 'Yii::app()->createUrl("/economy/comment/deleteans", array("id"=>$data->id))',
                            'options' => array('class' => 'icon-trash'),
                            'imageUrl' => false,
                             'label' => '',
                        ),
                        'show' => array
                            (
//                            'class' => 'icon-eye',
                            'visible' => '($data->status == ActiveRecord::STATUS_DEACTIVED) ? true : false',
//                            'imageUrl' => '',
                            'url' => 'Yii::app()->createUrl("/economy/comment/showans", array("id"=>$data->id))',
                            'options' => array('class' => 'icon-eye-slash'),
                            'label' => '',
                        ),
                        'hide' => array
                            (
//                            'icon' => 'icon-eye',
                            'visible' => '($data->status != ActiveRecord::STATUS_DEACTIVED) ? true : false',
//                            'imageUrl' => '',
                            'url' => 'Yii::app()->createUrl("/economy/comment/hideans", array("id"=>$data->id))',
                            'options' => array('class' => 'icon-eye'),
                            'label' => '',
                        ),
                    ),
                ),
            ),
        ));
        ?>
    </div>
</div>