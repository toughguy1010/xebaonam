<?php 
    $maxPrice = Product::model()->getMaxPrice("product_category_id=".$category->cat_id);
    $maxPrice = ($maxPrice)?$maxPrice:50000000;
?>
<div class="filter-left-contain">            
    <div style="overflow:hidden;" class="box-title-colleft-sp-sp">
        <span><b>Tìm kiếm kim cương</b><a class="icon-box20" href="<?php echo Yii::app()->createUrl('economy/product/categorySearch',array('id'=>$category->cat_id,'alias'=>$category->alias))?>"><i></i>Reset</a></span>
    </div>    
    <?php      
    if ($count = count($attributes)) {
        $i=0;
        foreach ($attributes as $key => $attribute) {
            $i++;
            if($i==7){?>
                <a href="javascript:void(0);" class="view-more-att" style="display:inline-block;font-weight: bold;line-height: 20px;margin:10px 0px -10px 0px;" rel="nofollow">Xem thêm bộ lọc</a>
                <div class="atts-more" style="display:none;">
            <?php }
            if (is_int($key)) {
                if($key == 10003){
                ?> 
                    <div class="att-filter-shape box-shape-sp-sp">
                        <div class="att-title title-shape-sp-sp"><?php echo $attribute['att']['name'] ?></div>
                        <div class="att-list-box-shape shape-sp-sp clearfix">
                            <ul class="att-filter-ops-shape">
                                <?php
                                $ind=0;                               
                                foreach ($attribute['options'] as $att) {
                                    $ind++;
                                    ?>
                                    <li class="<?php if ($ind % 5 == 0) { ?>last<?php }?> <?php if ($att['checked']) { ?>active<?php } ?>">
                                        <a id="atop_<?php echo $key; ?>_<?php echo $att['index_key']; ?>" class="op-ft kimcuong-<?php echo $ind;?> <?php if ($att['checked']) { ?>active<?php } ?>" href="<?php echo $att['link']; ?>" rel="nofollow" title="<?php echo $att['name'];?>"><i></i></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <?php $this->render('items/ajax_item_price',array("maxv"=>  ceil($maxPrice/1000000)*1000000));?>
                <?php                 
                }elseif($key == 10004){                    
                    $this->render('items/ajax_item_range_decimal',array('attribute'=>$attribute));
                }elseif($attribute['att']['frontend_input']=='textnumber' || $attribute['att']['frontend_input']=='price'){                    
                    $this->render('items/ajax_item_range',array('attribute'=>$attribute));
                }else{?>
                    <div class="att-filter">
                        <div class="att-title title-more-box-box"><?php echo $attribute['att']['name'] ?></div>
                        <div class="att-list-box clearfix">
                            <ul class="att-filter-ops">
                                <?php
                                $ind=0;                               
                                foreach ($attribute['options'] as $att) {
                                    $ind++;
                                    ?>
                                    <li class="<?php if ($ind % 4 == 0) { ?>last<?php }?> <?php if ($att['checked']) { ?>active<?php } ?>">
                                        <a id="atop_<?php echo $key; ?>_<?php echo $att['index_key']; ?>" class="op-ft <?php if ($att['checked']) { ?>active<?php } ?>" href="<?php echo $att['link']; ?>" rel="nofollow"><?php echo $att['name'];?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php } 
            }
            if($i==$count){?>
                </div>       
        <?php
                }
            }
        ?>
    <?php } ?>

</div>
<script type="text/javascript">
    var time_out_filter; 
    var params_filter = {};
    jQuery(function(){
        $( ".op-ft" ).click(function(event) {
            if($(this).hasClass('active')){
                $(this).removeClass('active');
                $(this).parent().removeClass('active');
            }else{
                $(this).addClass('active');
                $(this).parent().addClass('active');
            }
            event.preventDefault();            
            clearTimeout(time_out_filter);
            time_out_filter = setTimeout(function(){
                runFilter();                        
            },1000 );
        });                
    })
    
    function runFilter(url){
        var url = (url)?url:location.href;
        ajaxFilter(url,prepareParam());
    }
    function prepareParam(){
        params_filter={};
        var key;
        var val;
        //filter attribute select
        $( ".op-ft.active" ).each(function(index) {
            val = $(this).attr('id');
            val = val.replace('atop_','');              
            key = 'fi_'+parseInt(val.split('_')[0]);
            val = parseInt(val.split('_')[1]);
            if(params_filter[key] != undefined && val){                  
                params_filter[key]=params_filter[key]+','+val;
            }else{
                params_filter[key]=val;
            }
        });
        //price                
        if(jQuery('#active_ftop_price').val()==1){
            params_filter['fi_pmin']=economy.ToNumber(jQuery('#min_price').val());            
            params_filter['fi_pmax']=economy.ToNumber(jQuery('#max_price').val());
        }
        //range
        $( ".op-ft-range" ).each(function(index) {            
            key = $(this).attr('name');
            val = $(this).val();                
            if($('.active_'+$(this).attr('id')).val()==1){
                params_filter[key]=val;
            }            
        });
        //page size
        params_filter['psize'] = $( ".ShowPageSize" ).val();
        //sort
        val=$( "#fi_sort" ).val();
        if(val){
            params_filter['fi_sort'] = val;
        }
                
        return params_filter;
    }
        
    function ajaxFilter(url,params){         
        $.ajax({
            url: url,
            type:'GET',
            dataType:'html',
            data:decodeURIComponent($.param(params)),
            beforeSend: function(xhr) {
               $('#main-products').append('<div class="loading">Đang tải ...</div>');
            },
            complete: function(data) {                    
              $('#main-products').html(data.responseText);
              $('.box-hover-table-sp-sp').hide();
            }
          })
    }
    jQuery(function(){
        $( ".view-more-att" ).click(function() {
            $( ".atts-more" ).toggle( "fast", function() {
                // Animation complete.
            });
        });
    });
</script>
