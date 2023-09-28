<style type="text/css">
    #sortable li{
        list-style-type: none;
        float: left;
        width: 150px;
    }
    #algalley .alimgbox .alimglist .alimgitem{
        width: 100%;
    }
</style>
<div class="form-group no-margin-left">
    <?php echo CHtml::label('Gallery', null, array('class' => 'col-sm-2 control-label')); ?>
    <div class="controls col-sm-10">

        <?php
        $this->widget('common.widgets.upload.Upload', array(
            'type' => 'images',
            'id' => 'imageupload',
            'buttonheight' => 25,
            'path' => array('products', $this->site_id, Yii::app()->user->id),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => 'Thêm ảnh',
            'displayvaluebox' => false,
            'oncecomplete' => "return callbackImage(da);",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ));
        ?>

        <div id="algalley" class="algalley">
            <!--<span style="font-size: 12px;color: blue"><i>* Kéo thả để thay đổi vị trí</i></span>-->
            <div style="display:none" id="Albums_imageitem_em_"
                 class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
            <div class="alimgbox">
                <div class="alimglist">
                    <ul id="sortable">
                        <?php
                        if (!$model->isNewRecord) {
                            $images = $model->getImages(array('type' => BrandImages::IMAGE_GALLERY));
                            foreach ($images as $image) {
                                $this->renderPartial('imageitem', array('image' => $image));
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    function callbackImage(da) {
        var firstitem = jQuery('#algalley .alimglist').find('.ui-state-default:first');
        var html = '<li class="ui-state-default">';
        html += '<div class="alimgitem">';
        html += '<div class="alimgitembox">';
        html += '<div class="delimg">';
        html += '<a href="#" class="new_delimgaction">';
        html += '<i class="icon-remove"></i>';
        html += '</a>';
        html += '</div>';
        html += '<div class="alimgthum">';
        html += '<img src="' + da.imgurl + '">';
        html += '</div>';
        html += '<div class="alimgaction">';
        html += '<input class="position_image" type="hidden" name="order_img[]" value="newimage[]" />';
//        html += '<input type="radio" value="new_' + da.imgid + '" name="setava">';
//        html += '<span>Đặt làm ảnh đại diện</span>';
        html += '</div>';
        html += '<input type="hidden" value="' + da.imgid + '" name="newimage[]" class="newimage" />';
        html += '</div>';
        html += '</div>';
        html += '</li>';


        if (firstitem.html()) {
            firstitem.before(html);
        } else {
            jQuery('#algalley #sortable').append(html);
        }
    }

    $(function () {
        $("#sortable").sortable({
            stop: function (event, ui) {
                var img_id = $(ui.item).find('.position_image').val();
                if (img_id == 'newimage') {
                    $(ui.item).find('.newimage').attr('name', 'newimage[0][' + ui.item.index() + ']')
                }
            }
        });
        $("#sortable").disableSelection();
    });
</script>
