<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'brand-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#basicinfo">
                        <?php echo Yii::t('brand', 'brand_basicinfo'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#brand_gallery">
                        Gallery
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#brand_menu">
                        Ảnh menu
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#brand_catering">
                        Catering
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#brandSeo">
                        <?php echo Yii::t('brand', 'brand_seo'); ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="basicinfo" class="tab-pane active">
                    <?php
                    $this->renderPartial('partial/tab_basic_info', array(
                        'model' => $model,
                        'form' => $form,
                    ));
                    ?>
                </div>
                <div id="brand_gallery" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tab_images', array(
                        'model' => $model,
                        'form' => $form,
                    ));
                    ?>
                </div>
                <div id="brand_menu" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tab_menu', array(
                        'model' => $model,
                        'form' => $form,
                    ));
                    ?>
                </div>
                <div id="brand_catering" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tab_catering', array(
                        'model' => $model,
                        'form' => $form,
                    ));
                    ?>
                </div>
                <div id="brandSeo" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tab_seo', array(
                        'model' => $model,
                        'form' => $form,
                    ));
                    ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
<script>
    jQuery(document).on('click', '.delimgaction', function () {
        if (confirm('<?php echo Yii::t('album', 'album_delete_image_confirm'); ?>')) {
            var thi = $(this);
            var href = thi.attr('href');
            if (href) {
                jQuery.ajax({
                    url: href,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (res) {
                        if (res.code == 200) {
                            jQuery(thi).closest('.alimgitem').remove();
                            updateImgBox();
                        }
                    }
                });
            }
        }
        return false;
    });
</script>