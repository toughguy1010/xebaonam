<style text='text/style'>
    .attach-file-box{position: relative;padding:5px; border-bottom: 1px solid #ccc; background-color: #fff;}
    .attach-file-box .deleteFile{position: absolute; top: 3px; right: 3px; }
</style>
<div class="row">
    <div class="col-xs-12">
        <div class="well uploadBox" id="dropzone">
            <h2 class="text-center"><?php echo Yii::t('file', 'attach_upload_header_title') ?></h2>
            <div class="padding-15 margin-15">
                <?php
                $this->widget('common.widgets.upload.Upload', array(
                    'id' => 'attachupload',
                    'uploader' => Yii::app()->createUrl('economy/attach/upload'),
                    'fileSizeLimit' => 1024 * 1024 * 1000,
                    'type' => 'attach',
                    'buttonStyle' => 'style2',
                    'buttontext' => Yii::t('file', 'file_create'),
                ));
                ?>
            </div>
            <div class="">
                <div class="box-value">
                    <?php
                    $attachFiles = (isset($attachFiles) && !$model->isNewRecord) ? $attachFiles : ProductFiles::getFiles(array('product_id' => $model->id));
                    foreach ($attachFiles as $attach) {
                        ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="attach-file-box">
                                    <label><?php echo $attach['display_name']; ?></label>
                                    <a href="<?php echo Yii::app()->createUrl('economy/attach/delete', array('id' => $attach['id'])) ?>" class="deleteFile"><i class="icon icon-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <p class="text-center bigger-120"><?php echo Yii::t('file', 'attach_upload_help'); ?></p>
            <p class="text-center"><?php echo Yii::t('file', 'attach_upload_help2'); ?></p>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(function () {
        jQuery(document).on('click', '.attach-file-box .deleteFile', function () {
            if (confirm("<?php echo Yii::t('notice', 'areyousuredelete'); ?>") == true) {
                //
                var _this = jQuery(this);
                var href = _this.attr('href');
                if (href && href != '#') {
                    jQuery.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        url: href,
                        success: function (res) {
                            if(res.code==200){
                                _this.closest('.row').remove();
                            }
                        }
                    });
                } else {
                    _this.closest('.row').remove();
                }
            } else {
            }
            return false;
        });
    });
</script>