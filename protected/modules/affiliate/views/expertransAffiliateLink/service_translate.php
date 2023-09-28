<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/style3/colorbox.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#translate-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('translate', 'affiliate_link_manager'); ?>
        </h4>
        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('affiliate/affiliateLink/create'); ?>"
               class="btn btn-xs btn-primary"
               style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('translate', 'create_affiliate_link'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="search-active-form" style="position: relative; margin-top: 10px;">
                <?php
                $this->renderPartial('translate_search', array(
                    'model' => $model,
                ));
                ?>
                <div class="pageSizebox" style="position: absolute; right: 0px; top: 0px;">
                    <div class="pageSizealign">
                        <?php
                        $this->widget('common.extensions.PageSize.PageSize', array(
                            'mGridId' => 'translate-grid', //Gridview id
                            'mPageSize' => Yii::app()->request->getParam(Yii::app()->params['pageSizeName']),
                            'mDefPageSize' => Yii::app()->params['defaultPageSize'],
                        ));
                        ?>
                    </div>
                </div>
            </div><!-- search-form -->
            <hr>
            <div class="" style="margin-top: 10px">
                <a href="/affiliate/affiliateLink/createService/id/6"
                   class="getLink btn btn-xs btn-primary"
                   style="margin-right: 20px;">
                    <i class="icon-plus"></i>
                    <?php echo Yii::t('translate', 'Tạo link affilate BPO'); ?>
                </a>
                <a href="/affiliate/affiliateLink/createService/id/6"
                   class="getLink btn btn-xs btn-primary"
                   style="margin-right: 20px;">
                    <i class="icon-plus"></i>
                    <?php echo Yii::t('translate', 'Tạo link affilate Liên hệ'); ?>
                </a>
                <hr>
            </div>
            <?php
            Yii::import('common.extensions.LinkPager.LinkPager');
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'translate-grid',
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
//                    'id',
                    'from_lang' => array(
                        'name' => 'from_lang',
                        'value' => function ($data) {
                            if ($data->from_lang)
                                return ClaLanguage::getCountryName($data->from_lang);
                            return '';
                        }
                    ),
                    'to_lang' => array(
                        'name' => 'to_lang',
                        'value' => function ($data) {
                            if ($data->to_lang)
                                return ClaLanguage::getCountryName($data->to_lang);
                            return '';
                        }
                    ),
                    'price' => array(
                        'name' => 'price',
                        'value' => function ($data) {
                            if ($data->price)
                                return ($data->price) . ' ' . $data->currency;
                            return '';
                        }
                    ),
                    'price_business' => array(
                        'name' => 'price_business',
                        'value' => function ($data) {
                            if ($data->price_business)
                                return $data->price_business . ' ' . $data->currency;
                            return '';
                        }
                    ),
//                    'currency'
//                ,
                    'aff_percent' => array(
                        'name' => 'aff_percent',
                        'value' => function ($data) {
                            if ($data->aff_percent)
                                return $data->aff_percent;
                            return '';
                        }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{_copy}',
                        'buttons' => array(
                            '_copy' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("affiliate/affiliateLink/createService", array("id" => $data->id))',
                                'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-link btn btn-primary getLink', 'title' => 'Get link'),
                            ),
                        ),
                        'htmlOptions' => array(
                            'style' => 'width: 130px;',
                            'class' => 'button-column',
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
<script type="text/javascript">
    jQuery(function () {
        jQuery(document).on('click', '.getLink', function () {
            var _thi = jQuery(this);
            var url = _thi.attr('href');
            if (!url) {
                url = _thi.attr('src');
            }
            if (!url) {
                return false;
            }
            //
            jQuery.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                beforeSend: function () {
                },
                success: function (res) {
                    if (res.code == 200) {
                        $.colorbox({opacity: 0.5, html: res.html});
                    }
                }
            });
            return false;
        });
    });
</script>