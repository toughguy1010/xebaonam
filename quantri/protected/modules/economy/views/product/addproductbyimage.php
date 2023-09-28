<style>
    #algalleyImg {min-height: 100px;}
    #algalleyImg li{list-style: none;}
    #algalleyImg .alimgbox .alimglist .alimgitem{width: 33.33%;float: left;}
    #algalleyImg .alimgbox .alimglist .alimgitem img{width: 100%; max-width: 100%; display: block; border: none; position: relative; max-height: initial;}
    #algalleyImg .alimgbox .alimglist .alimgitem .alimgitembox{margin: 0px 10px 10px 0px; border: 1px solid #DDD;position: relative; height: auto;}
    #algalleyImg .alimgbox .alimglist .alimgitem .alimgitembox:hover{border: 1px solid #999;}
    #algalleyImg .alimgbox .alimglist .alimgitem .alimgitembox .alimgthum{margin: 5px; overflow: hidden; display: block; width: 95%; height: auto;}
    #algalleyImg .alimgbox .alimglist .active .alimgitembox{border: 1px solid #999;}
    #algalleyImg .alimgbox .alimglist .alimgitem .alimgaction{margin: 0px 5px 5px 5px; text-align: center;}
    #algalleyImg .alimgbox .alimglist .alimgitem .alimgaction input[type=radio]{margin: 0px 5px 0px 0px;}
    #algalleyImg .alimgbox .alimglist:after{clear: both;}
    #algalleyImg .alimgbox .alimglist .alimgitem .alimgitembox .delimg{position: absolute; top: 5px; right: 5px; background-color: #FFF; display: none;z-index: 100;}
    #algalleyImg .alimgbox .alimglist .alimgitem .alimgitembox:hover .delimg{display: block;}
    #algalleyImg .alimgbox .alimglist .alimgitem .alimgitembox .delimg a{color: red;font-size:18px;}

</style>
<script type="text/javascript">
    var indexManager = {
        index: 0,
        getIndex: function () {
            return this.index;
        },
        setIndex: function (ind) {
            this.index = ind;
        },
        increaseIndex: function () {
            this.index += 1;
        }
    };
</script>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'product-byimage-form',
    'htmlOptions' => array('class' => 'form-horizontal'),
    'enableAjaxValidation' => false,
        ));
?>
<div class="widget widget-box no-border">
    <div class="widget-header header-color-green2">
        <h4>
            <?php echo Yii::t('product', 'product_addproduct_byimage') . " '" . $model->name . "'"; ?>
        </h4>
        <div class="widget-toolbar no-border">
            <?php echo CHtml::submitButton(Yii::t('product', 'choiced_product_save'), array('class' => 'btn btn-xs btn-primary', 'id' => 'btnProductSaveByImage')); ?>
        </div>
    </div>
    <div class="widget-body" style="border: none;">
        <div class="widget-main">
            <div class="row" style="overflow: hidden; min-height: 600px;">
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="form-group no-margin-left">
                                <?php echo CHtml::label(Yii::t('product', 'product_image'), null, array('class' => 'col-sm-2 control-label')); ?>
                                <div class="controls col-sm-10">

                                    <?php
                                    $this->widget('common.widgets.upload.Upload', array(
                                        'type' => 'images',
                                        'id' => 'imageuploadByImg',
                                        'buttonheight' => 25,
                                        'path' => array($this->site_id, 'products', Yii::app()->user->id),
                                        'limit' => 100,
                                        'multi' => true,
                                        'imageoptions' => array(
                                            'resizes' => array(array(200, 200))
                                        ),
                                        'buttontext' => 'Thêm ảnh',
                                        'displayvaluebox' => false,
                                        'oncecomplete' => "var firstitem   = jQuery('#algalleyImg .alimglist').find('#sortableImg');var alimgitem   = '<li class=\"ui-state-default\"><div class=\"alimgitem\"><div class=\"alimgitembox\"> <div class=\"delimg\"><a href=\"#\" class=\"new_delimgaction\"><i class=\"icon-remove\"></i></a></div><div class=\"alimgthum\"><img src=\"'+da.imgurl+'\"></div><div class=\"alimgaction\"><div class=\"row\"><div class=\"col-xs-12\"><input type=\"text\" name=\"newimage['+indexManager.getIndex()+'][name]\" placeholder=\"Tên\" class=\"col-xs-12 form-control\"><textarea class=\"form-control\" placeholder=\"Miêu tả ngắn\" name=\"newimage['+indexManager.getIndex()+'][short_des]\"></textarea></div></div><input class=\"position_image\" type=\"hidden\" name=\"newimage['+indexManager.getIndex()+'][order]\" value=\"\" /></div><input type=\"hidden\" value=\"'+da.imgid+'\" name=\"newimage['+indexManager.getIndex()+'][id]\" class=\"newimage\" /></div></div></li>';if(firstitem.html()){firstitem.before(alimgitem);}else{jQuery('#algalley #sortable').append(alimgitem);}; updateImgBox(); indexManager.increaseIndex();",
                                        'onUploadStart' => 'ta=false;',
                                        'queuecomplete' => 'ta=true;',
                                    ));
                                    ?>

                                    <div id="algalleyImg" class="algalley">
                                        <div style="display:none" id="Albums_imageitem_em_"
                                             class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
                                        <div class="alimgbox">
                                            <div class="alimglist">
                                                <ul id="sortableImg">
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>

                                $.fn.listHandlers = function (events, outputFunction) {
                                    return this.each(function (i) {
                                        var elem = this,
                                                dEvents = $(this).data('events');
                                        if (!dEvents) {
                                            return;
                                        }
                                        $.each(dEvents, function (name, handler) {
                                            if ((new RegExp('^(' + (events === '*' ? '.+' : events.replace(',', '|').replace(/^on/i, '')) + ')$', 'i')).test(name)) {
                                                $.each(handler, function (i, handler) {
                                                    outputFunction(elem, 'n' + i + ': [' + name + '] : ' + handler);
                                                });
                                            }
                                        });
                                    });
                                };
                                //
                                $(function () {
                                    $("#sortableImg").sortable({
                                        stop: function (event, ui) {
                                            var img_id = $(ui.item).find('.position_image').val();
                                            if (img_id == 'newimage') {
                                                $(ui.item).find('.newimage').attr('name', 'newimage[0][' + ui.item.index() + ']');
                                            }
                                        }
                                    });
                                    $("#sortableImg").disableSelection();
                                    //
                                    jQuery(document).on('click', '.show-tag .alimgitem img', function (e) {
                                        var imgX = jQuery(this).offset().left;
                                        var imgY = jQuery(this).offset().top;
                                        var pageX = e.pageX;
                                        var pageY = e.pageY;
                                        return imageTag.addItem(jQuery(this), jQuery(this).parent(), pageX - imgX, pageY - imgY);
                                    });
                                    //
                                });
                                jQuery(document).ready(function () {
                                    jQuery('#btnProductSaveByImage').on('click', function () {
                                        if (jQuery(this).hasClass('imageTag')) {
                                            var addHtml = jQuery(this).closest('form').find('table tbody').html();
                                            jQuery('.show-tag .itpData.active tbody').append(addHtml);
                                        }
                                        return true;
                                    });
<?php if ($isAjax) { ?>
                                        var formSubmit = true;
                                        jQuery('#product-byimage-form').on('submit', function () {
                                            if (!formSubmit)
                                                return false;
                                            formSubmit = false;
                                            var thi = jQuery(this);
                                            jQuery.ajax({
                                                'type': 'POST',
                                                'dataType': 'JSON',
                                                'beforeSend': function () {
                                                    w3ShowLoading(jQuery('#btnProductSave'), 'left', -40, 0);
                                                },
                                                'url': thi.attr('action'),
                                                'data': thi.serialize(),
                                                'success': function (res) {
                                                    if (res.code != "200") {
                                                        if (res.errors) {
                                                            parseJsonErrors(res.errors);
                                                        }
                                                    } else {
                                                        $.fn.yiiGridView.update('product-groups-grid');
                                                        $.fn.yiiGridView.update('product-groups-grid-1');
                                                        $.fn.yiiGridView.update('product-groups-grid-2');
                                                        $.colorbox.close();
                                                    }
                                                    w3HideLoading();
                                                    formSubmit = true;
                                                },
                                                'error': function () {
                                                    w3HideLoading();
                                                    formSubmit = true;
                                                }
                                            });
                                            return false;
                                        });

<?php } ?>
                                    //
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->endWidget();
?>
<?php $this->renderPartial('partial/script', array('isAjax' => $isAjax)); ?>