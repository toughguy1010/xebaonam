<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/upload/ajaxupload.min.js"></script>
<div class="widget widget-box">
    <div class="widget-header">
        <h4><?php echo Yii::t('realestate', 'update'); ?></h4>
        
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php $this->renderPartial('_form', array('model' => $model, 'listdistrict' => $listdistrict, 'listprovince' => $listprovince, 'real_estate_project_info' => $real_estate_project_info, 'news_category' => $news_category,'realestateCategory'=>$realestateCategory)); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#RealEstateavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/content/realestate/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#RealEstateProject_avatar').val(obj.data.avatar);
                        if (jQuery('#RealEstateavatar_img img').attr('src')) {
                            jQuery('#RealEstateavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#RealEstateavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#RealEstateavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });


    });
</script>
<script type="text/javascript">
    jQuery(document).on('change', '#RealEstateProject_province_id', function () {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
            data: 'pid=' + jQuery('#RealEstateProject_province_id').val(),
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(jQuery('#RealEstateProject_province_id'), 'right', 20, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#RealEstateProject_district_id').html(res.html);
                }
                w3HideLoading();
            },
            error: function () {
                w3HideLoading();
            }
        });
    });
</script>
