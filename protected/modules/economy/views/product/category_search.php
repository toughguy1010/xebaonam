<?php 
    $att_show_table = array(10003,10004,10005,10006,10007,10008,10020);  
    $sort = Yii::app()->request->getParam('fi_sort',-23);    
?>
<?php if (count($products)) {?>
    <div class="product-category-search"> 
        <div class="list">
            <div class="box-table-sp-sp">
                <div class="box-title-colleft-sp-sp">
                    <span>Kết quả: <b> <?php echo $totalitem;?> </b>kim cương</span>
                </div>
                <div class="box-list-more-sp-sp-list">
                    <div class="box-search-sp-table">
                        <div style="overflow: hidden;" class="box-option-search-main">
                            <div class="box-fi-sort">Sắp xếp  
                                <select id="fi_sort" name="fi_sort" class="sort-filter">
                                    <option <?php if(!$sort) echo 'selected="selected"'; ?> value="0">Mặc định</option>
                                    <option <?php if($sort==23) echo 'selected="selected"'; ?> value="23">Carat tăng dần</option>
                                    <option <?php if($sort==-23) echo 'selected="selected"'; ?> value="-23">Carat giảm dần</option>
                                    <option <?php if($sort==='price') echo 'selected="selected"'; ?> value="price">Giá tăng dần</option>
                                    <option <?php if($sort==='-price') echo 'selected="selected"'; ?> value="-price">Giá giảm dần</option>
                                </select>                                
                            </div>
                            <div style="float:right;" class="box-product-page">
                                <div style="max-width: 450px; text-align: right;" class='product-page'>
                                    <?php
                                    $this->widget('common.extensions.LinkPager.LinkPager', array(
                                        'itemCount' => $totalitem,
                                        'pageSize' => $limit,
                                        'header' => '',
                                        'selectedPageCssClass' => 'active',
                                    ));
                                    ?>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="table-products table-responsive">
                    <table style="margin-bottom: 10px;" class="table table-bordered">
                        <thead>
                            <tr class="top-table">
                                <th>Mã SP</th>
                                <?php if(count($attributesShow)){
                                        foreach ($attributesShow as $attribute){
                                            if(in_array($attribute['id'], $att_show_table))
                                                echo '<th>'.$attribute['name'].'</th>';
                                        }
                                }?>
                                <th>Giá (đ)</th>
                                <th>Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i=0;
                        foreach ($products as $pro) {
                            $i++;
                            $price = HtmlFormat::money_format($pro['price']);
                            if ($price == 0)
                                $price_label = Product::getProductPriceNullLabel();
                            else
                                $price_label = $price;
                            ?>                
                            <tr class="white-table <?php echo ($i==1)?"first":'';?>" id="<?php echo $pro['id'];?>">
                                <!--<th class="box-one-table-td" scope="row"><input type="checkbox" value="checkbox" name="ngoclan"></th>-->
                                <td class="box-one-table-td"><?php echo $pro['code'];?></td>
                                <?php 
                                    if(count($attributesShow)){
                                        foreach ($attributesShow as $key=>$attribute){                                            
                                            $attributesShow[$key]["value"]= AttributeHelper::helper()->getValueAttribute($attribute,$pro['cus_field'.$attribute['field_product']],$pro['cus_field'.$attribute['field_product']]);
                                            if(in_array($attribute['id'],$att_show_table)){
                                                if($attribute['frontend_input']=='textnumber' || $attribute['frontend_input']=='price'){
                                                    echo '<td class="box-one-table-td">'.  HtmlFormat::money_format($attributesShow[$key]["value"]).'</td>';
                                                }else{
                                                    echo '<td class="box-one-table-td">'.$attributesShow[$key]["value"].'</td>';
                                                }
                                            }
                                        }
                                    }
                                ?>                            
                                <td class="product-detail-price box-one-table-td"><?php echo $price_label;?></td>
                                <td><a class="btn button" href="<?php echo $pro['link'];?>">Xem</a></td>
                            </tr>                                                           
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div style="padding-top:0px;" class="box-list-more-sp-sp-list">
                    <div class="box-search-sp-table">
                        <div style="overflow: hidden;" class="box-option-search-main">
                            <div style="float: left;">Hiển thị 
                            <select id="page_size_bottom" class="ShowPageSize">
                                <option <?php if($limit==10) echo 'selected="selected"'; ?> value="10">10</option>
                                <option <?php if($limit==24) echo 'selected="selected"'; ?> value="24">24</option>
                                <option <?php if($limit==48) echo 'selected="selected"'; ?> value="48">48</option></select>
                            </select>
                            Sản Phẩm/ Trang
                            </div>
                            <div style="float:right;" class="box-product-page">
                                <div style="max-width: 450px; text-align: right;" class='product-page'>
                                    <?php
                                    $this->widget('common.extensions.LinkPager.LinkPager', array(
                                        'itemCount' => $totalitem,
                                        'pageSize' => $limit,
                                        'header' => '',
                                        'selectedPageCssClass' => 'active',
                                    ));
                                    ?>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
<script type="text/javascript">
    jQuery(function(){   
        //$('.box-hover-table-sp-sp').html(jQuery.data( document.body, "pro_hover_"+$(".table-products tbody tr.first").attr('id')));
        //$('.box-hover-table-sp-sp').show();        
        $( ".table-products tbody tr" ).hover(
            function() {
                $( ".table-products tbody tr").removeClass('gray-table');
                $( this ).addClass('gray-table');  
                var offset = $( this ).offset();              
                var offsetC = $('#centerCol').offset();
                var pro_id = $( this ).attr('id');
                if(jQuery.data( document.body, "pro_hover_"+$( this ).attr('id'))){
                    $('.box-hover-table-sp-sp').html(jQuery.data( document.body, "pro_hover_"+pro_id));
                    $('.box-hover-table-sp-sp').css({'top':(offset.top-offsetC.top-107)+'px'});
                    $('.box-hover-table-sp-sp').show();
                }else{
                    $.ajax({
                        url: '<?php echo Yii::app()->createUrl('economy/product/ajaxProHover',array('att_set_id'=>$category['attribute_set_id']));?>',
                        type:'GET',
                        dataType:'html',
                        data:{"id":pro_id},
                        beforeSend: function(xhr) {
                            $('.box-hover-table-sp-sp').append('<div class="loading" style="top:200px;left:20px;">Đang tải ...</div>');
                        },
                        complete: function(data) {  
                            jQuery.data(document.body, "pro_hover_"+pro_id,data.responseText);
                            $('.box-hover-table-sp-sp').html(data.responseText);                          
                        }
                      });
                    $('.box-hover-table-sp-sp').css({'top':(offset.top-offsetC.top-107)+'px'});
                    $('.box-hover-table-sp-sp').show();
                }
              
            }, function() {
                $( this ).removeClass('gray-table');
            }
        );
        $( ".table-products tbody tr.first").trigger('mouseenter');
        
        $( ".ShowPageSize" ).change(function() {            
            runFilter();
        });
        
        $( "#fi_sort" ).change(function() {            
            runFilter();
        });
        
        $('.product-page ul li a').click(function(event){
            var link = $(this).attr('href');
            event.preventDefault();            
            clearTimeout(time_out_filter);
            time_out_filter = setTimeout(function(){                
                runFilter(link);                        
            },1000 ); 
        });
    });
</script>
<?php }else{
    echo "Không tìm thấy sản phẩm nào.";
} ?>