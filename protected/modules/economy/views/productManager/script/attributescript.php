<script type="text/javascript">    
    function close_new_attr(id){
        jQuery('#new_attr_conten_'+id).css('display','none');
        jQuery('#is_newattr_'+id).css('display','inline');
        jQuery('#attribute_option_'+id).val('');
//        jQuery('#attribute_option_code'+id).val('');
        
    }
    function new_attr(id){          
        if(id && jQuery('#attribute_option_'+id).val()!=""){
            jQuery('.att-loading-'+id).show();
            jQuery.ajax({
                url: "<?php echo Yii::app()->createUrl("economy/productAttribute/ajaxAddOption")?>",
                global: false,
                type: "POST",
                data:  {'attrid':id,'name':jQuery('#attribute_option_'+id).val()},
                dataType: "html",
                success: function(data){  
                    jQuery('.att-loading-'+id).hide();              
                    var mycart = JSON.parse(data);  
                    if(mycart.action=="success"){    
                        $('#Attribute_'+id).append(mycart.content);                                   
                    }else if(mycart.action=="error"){
                        if(mycart.content){                           
                            alert(mycart.content);
                        }                                   
                    }
                    close_new_attr(id);
                }
            });
        
        }else{
            alert('Bạn vui lòng nhập tên giá trị!');
            jQuery('#attribute_option_'+id).focus();
        }
        
        
    }
    
    function is_newattr_click(m,lang){            
        if(lang){
            jQuery(m).css('display','none');
            jQuery('#new_attr_conten_'+lang).css('display','inline');
        }
    }
</script>