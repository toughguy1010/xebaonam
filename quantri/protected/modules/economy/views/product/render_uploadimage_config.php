<?php
$this->widget('common.widgets.upload.Upload', array(
    'type' => 'images',
    'id' => 'imageupload'.$count_new,
    'buttonheight' => 25,
    'path' => array('pconfig', $this->site_id, Yii::app()->user->id),
    'limit' => 100,
    'multi' => true,
    'imageoptions' => array(
        'resizes' => array(array(200, 200))
    ),
    'buttontext' => 'Thêm ảnh',
    'displayvaluebox' => false,
    'oncecomplete' => "var firstitem   = jQuery('#algalley_configurable_".$count_new." .alimglist').find('.alimgitem:first');var alimgitem   = '<div class=\"alimgitem\"><div class=\"alimgitembox\"> <div class=\"delimg\"><a href=\"#\" class=\"new_delimgaction\"><i class=\"icon-remove\"></i></a></div><div class=\"alimgthum\"><img src=\"'+da.imgurl+'\"></div><input type=\"hidden\" value=\"'+da.imgid+'\" name=\"attribute_cf[new][".$count_new."][1111][]\" class=\"newimage\" /></div></div>';if(firstitem.html()){firstitem.before(alimgitem);}else{jQuery('#algalley_configurable_".$count_new." .alimglist').append(alimgitem);}; updateImgBox();",
    'onUploadStart' => 'ta=false;',
    'queuecomplete' => 'ta=true;',
));
?>