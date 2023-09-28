<div class="hover-table-sp-sp">
    <div class="title-hover-table">
        <b>Chi tiết kim cương</b>
    </div>
    <div class="tt-hover-table-sp-sp">
        <p><b><?php echo $pro['name'];?></b></p>
    </div>
    <div class="ct-tt-hover-table-sp-sp">
        <ul>                  
            <li><span><?php echo $pro['code'];?></span></li>
            <?php foreach ($attributesShow as $key=>$attribute){ ?>
                <li><?php echo $attribute['name']?>:<span><?php echo $attribute['value']?></span></li>                    
            <?php }?>
        </ul>
    </div>
    <div class="box-more-ct">
        <div class="more-ct"><a href="<?php echo $pro['link'];?>" class="active">Xem chi tiết</a></div>
        <div class="more-ct"><a href="#" class="bg-cart-more-more-a"><i class="cart-more-more-a"></i>Thêm vào giỏ hàng</a></div>
        <div class="more-ct"><a href="#" class="bg-love-icon-more-a"><i class="love-icon-more-a"></i>Đánh dấu yêu thích</a></div>
    </div>
</div>