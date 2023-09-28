<?php
$options = ($model->id)?ProductAttributeOption::model()->getOptionByAttribute($model->id):array();
//$max_sort_order = ($model->id)?ProductAttributeOption::model()->getMaxSort($model->id):2;
$coptions = count($options);
Yii::app()->clientScript->registerScript('attribute_option', "        
        var count_new = 0;
        var type_option = ".$model->type_option.";
        var htmlOp = '';
        jQuery(document).on('click','.addattri',function(){
            var length  = jQuery('#att_options').find('.attributeitem').length;
            if(length==1){
                jQuery('#att_options').find('.attributeitem').find('.removeattri').css({'display':'inline-block'});
            }
            var thi = jQuery(this);
            count_new++;                        
            htmlOp = '<div class=\"attributeitem controls row\"><input name=\"aoptions[new]['+count_new+'][value]\" class=\"col-sm-4\" type=\"text\" value=\"\"/><input name=\"aoptions[new]['+count_new+'][sort_order]\" class=\"col-sm-1\" type=\"text\" value=\"0\"/>';
            if(type_option == 1){
                htmlOp +='<input name=\"aoptions_new_'+count_new+'_ext_image\" class=\"col-sm-2\" type=\"file\" value=\"\">';
                htmlOp +='<input name=\"aoptions[new]['+count_new+'][ext]\" class=\"col-sm-2\" type=\"hidden\" value=\"\"/>';
            }else if(type_option == 2){
                htmlOp +='<div class=\"bootstrap-colorpicker col-sm-2\"><input name=\"aoptions[new]['+count_new+'][ext]\" id=\"colorpicker-'+count_new+'\" class=\"input-small colorpicker\" type=\"text\" value=\"\"/></div>';
            }else{
                htmlOp +='<input name=\"aoptions[new]['+count_new+'][ext]\" class=\"col-sm-2\" type=\"text\" value=\"\"/>';
            }
            htmlOp +='<input type=\"radio\" value=\"n-'+count_new+'\" class=\"col-sm-2\" name=\"aoptions[default_value]\" class=\"input-radio\"/><span class=\"help-inline action\"><i class=\"addattri icon-plus\"></i><i class=\"removeattri icon-minus\"></i></span></div>';
            jQuery(thi).parents('.attributeitem').after(htmlOp);
            if(type_option == 2){
                jQuery('#colorpicker-'+count_new).colorpicker();
            }
            return false;
        });
        
        jQuery(document).on('click', '.removeattri', function() {
            var length  = jQuery('#att_options').find('.attributeitem').length;
            if (length > 1) {
                var thi = jQuery(this);
                if(jQuery(thi).parents('.attributeitem').hasClass('opupdate')){
                    jQuery(thi).parents('#att_options').append('<input name=\"aoptions[delete]['+jQuery(thi).parents('.attributeitem').attr('id')+']\" type=\"hidden\" value=\"'+jQuery(thi).parents('.attributeitem').attr('id')+'\">');
                }
                jQuery(thi).parents('.attributeitem').remove();
                if(length == 2)
                    jQuery('#att_options').find('.attributeitem').find('.removeattri').fadeOut('fast');
            }
            return false;
        }); 
        
        jQuery(function(){
            $('.colorpicker').colorpicker();
        });
    ");
?>
<style>
    #att_options .controls{margin-left: 0px;}
    #att_options .action{line-height: 30px;padding-top: 5px;}
    /*    #att_options .action *{font-size: 12px;}*/
    #att_options .action i{margin: 10px 5px; cursor: pointer; float: left;}
    #att_options .attributeitem{margin-top: 8px;}
    #att_options .attributeitem input{margin-right: 20px;}
    #att_options .attributeitem-head{margin-top: 8px;}
    #att_options .attributeitem-head span.head-t{margin-right: 20px;}
    #att_options .attributeitem-head span.head-d{margin-right: 20px;text-align: center;}
</style>

<div id="att_options">    
    <div class="attributeitem-head controls row">
        <span class="col-sm-4 head-t">Giá trị</span>
        <span class="col-sm-1 head-t">Thứ tự</span>
        <span class="col-sm-2 head-t ext-value"><?php if($model->type_option == 3){?>Giá (+/-) thêm vào giá sp<?php }else{?>Mở rộng<?php }?></span>
        <span class="col-sm-2 head-d">Giá trị mặc định</span>
                
    </div>
    <?php       
    if ($options && $coptions) {
        foreach ($options as $key => $opt) {
            ?>
            <div class="attributeitem controls row opupdate" id="<?php echo $opt['id']; ?>">
                <input name="aoptions[update][<?php echo $opt['id']; ?>][value]" class="col-sm-4" type="text" value="<?php echo $opt['value']; ?>">
                <input name="aoptions[update][<?php echo $opt['id']; ?>][sort_order]" class="col-sm-1" type="text" value="<?php echo $opt['sort_order']; ?>">                
                <?php if($model->type_option==1){?>
                    <div class="col-sm-2">
                        <input name="aoptions_update_<?php echo $opt['id']; ?>_ext_image" type="file" value="">
                        <input name="aoptions[update][<?php echo $opt['id']; ?>][ext]" class="col-sm-2" type="hidden" value="<?php echo $opt['ext']; ?>">
                        <?php if($opt['ext']){?>
                        <img src="<?php echo $opt['ext']; ?>" width="30" height="30"/>
                        <?php }?>
                    </div>
                <?php }elseif($model->type_option==2){?>
                    <div class="bootstrap-colorpicker col-sm-2">
                        <input name="aoptions[update][<?php echo $opt['id']; ?>][ext]" id="colorpicker-<?php echo $opt['id']; ?>" class="input-small colorpicker" type="text" value="<?php echo $opt['ext']; ?>">
                    </div>
                <?php }else{?>
                    <input name="aoptions[update][<?php echo $opt['id']; ?>][ext]" class="col-sm-2" type="text" value="<?php echo $opt['ext']; ?>">
                <?php }?>
                <input type="radio" value="u-<?php echo $opt['id']; ?>" <?php if($opt['id']==$model->default_value) echo 'checked=="checked"'; ?> class="col-sm-2" name="aoptions[default_value]" class="input-radio">
                <span class="help-inline action">
                    <i class="addattri icon-plus"></i>
                    <i class="removeattri icon-minus"></i>
                </span>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="attributeitem controls row">
            <input name="aoptions[new][0][value]" class="col-sm-4" type="text" value=""/>
            <input name="aoptions[new][0][sort_order]" class="col-sm-1" type="text" value="0"/>            
            <?php if($model->type_option==1){?>
                <input name="aoptions_new_0_ext_image" class="col-sm-2" type="file" value="">
                <input name="aoptions[new][0][ext]" class="col-sm-2" type="hidden" value="">
            <?php }elseif($model->type_option==2){?>
                <div class="bootstrap-colorpicker col-sm-2">
                    <input name="aoptions[new][0][ext]" id="colorpicker-0" class="input-small colorpicker" type="text" value="">
                </div>
            <?php }else{?>
                <input name="aoptions[new][0][ext]" class="col-sm-2" type="text" value="">
            <?php }?>
            <input type="radio" value="n-0" class="col-sm-2" name="aoptions[default_value]" class="input-radio"/>
            <span class="help-inline action">
                <i class="addattri icon-plus"></i>
                <i class="removeattri icon-minus" style="display: none;"></i>
            </span>
        </div>
    <?php } ?>
</div>