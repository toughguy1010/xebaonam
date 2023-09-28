<?php 
    $att_carat = 10004;
    $att_price_stand = 10017;
    $price_per_carat = 0;
    if(isset($attributesShow[$att_carat]['value']) && $attributesShow[$att_carat]['value']>0 && $pro['price']){
        $price_per_carat = round($pro['price']/$attributesShow[$att_carat]['value']);
    }
    $rate_sale = 0;
    if($price_per_carat && isset($attributesShow[$att_price_stand]['value']) && $attributesShow[$att_price_stand]['value']>0){        
        $rate_sale = round(($attributesShow[$att_price_stand]['value'] - $price_per_carat)/$attributesShow[$att_price_stand]['value'],2)*100;
    }
?>

<?php if(count($attributesShow)){?>
    <div class="hover-table-sp-sp">
        <div class="arrow"></div>
        <div class="title-hover-table">
            <b>Chi tiết kim cương</b>
        </div>
        <div class="tt-hover-table-sp-sp">
            <p><b><?php echo $pro['name'];?></b></p>
        </div>
        <div class="ct-tt-hover-table-sp-sp">
            <ul>                  
                <li>Mã kim cương : <span style="padding-left:8px;"><?php echo $pro['code'];?></span></li>
                <?php foreach ($attributesShow as $key=>$attribute){ ?>
                <li><?php echo $attribute['name']?> : <span style="padding-left:8px;">
                    <?php echo ($attribute['frontend_input']=='price')?HtmlFormat::money_format($attribute['value'])." đ":$attribute['value']?></span>
                </li>                    
                <?php }?>
                <li>Giá (carat) : <span style="padding-left:8px;"><?php echo HtmlFormat::money_format($price_per_carat). " đ";?></span></li>
                <?php if($rate_sale>0){ ?>
                <li>% Sale : <span style="padding-left:8px;"><?php echo $rate_sale." %";?></span></li>    
                <?php }?>
            </ul>
        </div>
        <div class="box-more-ct">
            <div class="more-ct"><a href="<?php echo $pro['link'];?>" class="active">Xem chi tiết</a></div>
            <div class="more-ct"><a href="<?php echo Yii::app()->createUrl('economy/shoppingcart/add',array('pid'=>$pro['id']));?>" class="bg-cart-more-more-a addtocart noredirect"><i class="cart-more-more-a"></i>Thêm vào giỏ hàng</a></div>        
        </div>
    </div>
<?php }?>