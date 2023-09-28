<!--<style>
    #sortable, #sortable_interior {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 100%;
    }

    #sortable li, #sortable_interior li {
        margin: 3px 3px 3px 0;
        padding: 1px;
        float: left;
        width: 200px;
        height: 210px;
        text-align: center;
    }

    #algalley .alimgbox .alimglist .alimgitem, #algalley_interior .alimgbox .alimglist .alimgitem {
        width: 100%;
    }

    #algalley .alimgbox .alimglist .alimgitem .alimgitembox, #algalley_interior .alimgbox .alimglist .alimgitem .alimgitembox {
        height: 200px;
        position: relative;
    }

    #algalley .alimgbox .alimglist .alimgitem .alimgaction, #algalley_interior .alimgbox .alimglist .alimgitem .alimgaction {
        position: absolute;
        bottom: 0px;
    }
</style>-->

<div class="form-group no-margin-left">
    <?php echo CHtml::label(Yii::t('product', 'product_image'), null, array('class' => 'col-sm-2 control-label')); ?>
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
            'oncecomplete' => "var firstitem   = jQuery('#algalley .alimglist').find('.ui-state-default:first');var alimgitem   = '<li class=\"ui-state-default\"><div class=\"alimgitem\"><div class=\"alimgitembox\"> <div class=\"delimg\"><a href=\"#\" class=\"new_delimgaction\"><i class=\"icon-remove\"></i></a></div><div class=\"alimgthum\"><img src=\"'+da.imgurl+'\"></div><div class=\"alimgaction\"><input class=\"position_image\" type=\"hidden\" name=\"order_img[0][]\" value=\"newimage[0[]]\" /><input type=\"radio\" value=\"new_'+da.imgid+'\" name=\"setava\"><span>" . Yii::t('album', 'album_set_avatar') . "</span></div><input type=\"hidden\" value=\"'+da.imgid+'\" name=\"newimage[0][]\" class=\"newimage\" /></div></div></li>';if(firstitem.html()){firstitem.before(alimgitem);}else{jQuery('#algalley #sortable').append(alimgitem);}; updateImgBox();",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ));
        ?>

        <div id="algalley" class="algalley">
            <span style="font-size: 12px;color: blue"><i>* Kéo thả để thay đổi vị trí</i></span>
            <div style="display:none" id="Albums_imageitem_em_"
                 class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
            <div class="alimgbox">
                <div class="alimglist">
                    <ul id="sortable">
                        <?php
                        if (!$model->isNewRecord) {
                            $images = $model->getImages(array('group_img' => 0));
                            foreach ($images as $image) {
                                $this->renderPartial('imageitem', array('image' => $image, 'avatar_id' => $model->avatar_id, 'group_img' => 0));
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
        $("#sortable").sortable({
            stop: function (event, ui) {
                var img_id = $(ui.item).find('.position_image').val();
                if (img_id == 'newimage') {
                    $(ui.item).find('.newimage').attr('name', 'newimage[0][' + ui.item.index() + ']');
                }
            }
        });
        $("#sortable").disableSelection();
        //
        jQuery(document).on('click', '.show-tag .alimgitem img', function (e) {
            var imgX = jQuery(this).offset().left;
            var imgY = jQuery(this).offset().top;
            var pageX = e.pageX;
            var pageY = e.pageY;
            return imageTag.addItem(jQuery(this), jQuery(this).parent(), pageX - imgX, pageY - imgY);
        });
        //
        jQuery('#product-form').on('submit', function () {
            imageTag.prepareData();
        });
    });
    imageTag = {
        showTag: function (object) {
            var cloLi = jQuery(object).closest('li');
            cloLi.parent().find('li').removeClass('show-tag');
            cloLi.addClass('show-tag');
            var img = cloLi.find('.alimgitem img:first');
            var imgsrc = img.attr('src');
            imgsrc = imgsrc.replace('s500_500', 's1000_1000');
            img.attr('src', imgsrc);
            jQuery('html, body').scrollTop(cloLi.offset().top);
            //
            var href = jQuery(object).attr('href');
            img.load(function () {
                if (href && !jQuery(object).hasClass('loaded')) {
                    jQuery.ajax({
                        url: href,
                        type: 'POST',
                        dataType: 'JSON',
                        success: function (res) {
                            if (res.code == 200) {
                                var data = res.data;
                                for (var i = 0; i < data.length; i++) {
                                    var rate = img.width() / data[i]['info']['from_width'];
                                    var posX = rate * data[i]['info']['left'];
                                    var posY = rate * data[i]['info']['top'];
                                    imageTag.addItem(img, img.parent(), posX, posY, data[i]['box_item']);
                                }
                            }
                        }
                    });
                    jQuery(object).addClass('loaded')
                }
            });
            return false;
        },
        parseData: function (str, obj) {
            var retStr = str;
            for (var x in obj) {
                retStr = retStr.replace(new RegExp(x, 'g'), obj[x]);
            }
            return retStr;
        },
        addItem: function (fromElement, targetElement, posX, posY, elementHtml) {
            var boxX = targetElement.offset().left;
            var boxY = targetElement.offset().top;
            var imgX = fromElement.offset().left;
            var imgY = fromElement.offset().top;
            var realPosX = imgX - boxX + posX;
            var realPosY = imgY - boxY + posY;
            if (!elementHtml || elementHtml == '') {
                //var elementHtml = '<div class="imageTagBox" style="position: absolute; left: ' + posX + 'px; top: ' + posY + 'px;"><div class="imageTagAction"><a href="#" onclick="return imageTag.removeItem(this);" class="act-delete"><i class="icon-remove"></i></a></div><div class="imageTagAction edit"><a href="#" onclick="return imageTag.editItem(this);" class="act-delete"><i class="icon-edit"></i></a></div><a href="#" class="imgTag"><i class="icon-tag"></i></a></div>';
                elementHtml = '' + <?php echo json_encode($this->renderPartial('partial/tag/box_default', array(), true)); ?>
            }
            elementHtml = this.parseData(elementHtml, {'_vari_real_left_': realPosX, '_vari_real_top_': realPosY, '_vari_left_': posX, '_vari_top_': posY});
            targetElement.append(elementHtml);
            return false;
        },
        editItem: function (object) {
            var imageTagBox = jQuery(object).closest('.imageTagBox');
            if (imageTagBox.find('.imageTagProduct .itpBody').html().length) {
                imageTagBox.find('.imageTagProduct').removeClass('hidden');
                return false;
            }
            var href = jQuery(object).attr('href');
            if (href) {
                jQuery.ajax({
                    url: href,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (res) {
                        if (res.code == 200) {
                            imageTagBox.find('.imageTagProduct .itpBody').html(res.html);
                            imageTagBox.find('.imageTagProduct').removeClass('hidden');
                        }
                    }
                });
            }
            return false;
        },
        showBoxAddProduct: function (object) {
            var showTag = jQuery(object).closest('.show-tag');
            showTag.find('.itpData').removeClass('active');
            jQuery(object).closest('.itpBody').find('.itpData').addClass('active');
            jQuery(".addProductToTag").colorbox({width: "80%", maxHeight: '100%', overlayClose: false});
            return false;
        },
        removeItem: function (object) {
            var href = jQuery(object).attr('href');
            if (href && href != '#') {
                var message = jQuery(object).data('message');
                if (!message) {
                    message = 'Bạn có chắc chắn muốn xóa không?';
                }
                if (confirm(message)) {
                    jQuery.ajax({
                        url: href,
                        type: 'POST',
                        dataType: 'JSON',
                        success: function (res) {
                            if (res.code == 200) {
                                jQuery(object).closest('.imageTagBox').remove();
                            }
                        }
                    });
                }
            } else {
                jQuery(object).closest('.imageTagBox').remove();
            }
            return false;
        },
        prepareData: function () {
            jQuery('.alimgitem').each(function () {
                var count = 0;
                var _this = jQuery(this);
                var tags = [];
                _this.find('.imageTagBox').each(function () {
                    tags[count] = {};
                    tags[count]['tag'] = jQuery(this).data('tag'); // luu tag_id
                    tags[count]['left'] = jQuery(this).data('left');
                    tags[count]['top'] = jQuery(this).data('top');
                    tags[count]['update'] = jQuery(this).data('update');
                    tags[count]['from_width'] = _this.find('img:first').width();
                    tags[count]['from_height'] = _this.find('img:first').height();
                    var newProducts = [];
                    jQuery(this).find('.imageTagProduct .itpBody .itpData .new').each(function () {
                        newProducts.push(jQuery(this).data('product'));
                    });
                    tags[count]['new_products'] = newProducts.join(',');
                    count++;
                });
                _this.find('.imgTagData').val(JSON.stringify(tags));
            });
        },
        embed: function (object) {
            jQuery(object).colorbox({width: "80%", maxHeight: '100%', overlayClose: false});
        }
    };
</script>

<script type="text/javascript">
    imageTagPublic = {
        showTag: function (object) {
            var parent = jQuery(object).parent();
            parent.css({"position": "relative"});
            var img = jQuery(object);
            if (jQuery(object).hasClass('load')) {
                var info = jQuery(object).data('info');
                var data = JSON.parse(atob(info));
                console.log(data);
                for (var i = 0; i < data.length; i++) {
                    var rate = img.width() / data[i]['info']['from_width'];
                    var posX = rate * data[i]['info']['left'];
                    var posY = rate * data[i]['info']['top'];
                    this.addItem(img, img.parent(), posX, posY, data[i]['box_item']);
                }
            }
            return false;
        },
        parseData: function (str, obj) {
            var retStr = str;
            for (var x in obj) {
                retStr = retStr.replace(new RegExp(x, 'g'), obj[x]);
            }
            return retStr;
        },
        addItem: function (fromElement, targetElement, posX, posY, elementHtml) {
            var boxX = targetElement.offset().left;
            var boxY = targetElement.offset().top;
            var imgX = fromElement.offset().left;
            var imgY = fromElement.offset().top;
            var realPosX = imgX - boxX + posX;
            var realPosY = imgY - boxY + posY;
            if (!elementHtml) {
                elementHtml = '';
            }
            elementHtml = this.parseData(elementHtml, {'_vari_real_left_': realPosX, '_vari_real_top_': realPosY, '_vari_left_': posX, '_vari_top_': posY});
            targetElement.append(elementHtml);
            return false;
        }
    };

    jQuery(function () {
        jQuery('.imageTag').on('load', function () {
            imageTagPublic.showTag(this);
        });
        jQuery('.imageTag').on('click', function () {
            imageTagPublic.showTag(this);
        });
        jQuery('.imageTag').trigger('click');
    });
</script>