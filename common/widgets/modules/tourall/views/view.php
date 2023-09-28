<?php if (isset($tours) && count($tours)) { ?>
    <div class="grid">
        <?php foreach ($tours as $tour) { ?>
            <div class="list-item">
                <div class="list-content clearfix">
                    <div class="list-content-box">
                        <div class="list-content-img"> 
                            <a href="<?php echo $tour['link'] ?>" title="<?php echo $tour['name'] ?>"> 
                                <img alt="<?php echo $tour['name'] ?>" src="<?php echo ClaHost::getImageHost(), $tour['avatar_path'], 's200_200/', $tour['avatar_name']; ?>"> 
                            </a>
                        </div>
                        <div class="list-content-body">
                            <h3 class="list-content-title">
                                <a href="<?php echo $tour['link'] ?>" title="<?php echo $tour['name'] ?>"><?php echo $tour['name'] ?> </a> 
                            </h3>
                            <?php if (isset($tour['price']) && $tour['price'] > 0) { ?>
                                <div class="price">
                                    <p><span>Giá</span> <?php echo number_format($tour['price'], 0, '', '.') ?> đ</p>
                                </div>
                            <?php } ?>
                            <div class="ProductAction clearfix">
                                <div class="ProductActionAdd">
                                    <a href="<?php echo $tour['link'] ?>" title="<?php echo $tour['name'] ?>" class="a-btn-2">
                                        <span class="a-btn-2-text">Chi tiết</span> 
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class='box-product-page clearfix'>
        <?php
        $this->widget('common.extensions.LinkPager.LinkPager', array(
            'itemCount' => $totalitem,
            'pageSize' => $limit,
            'header' => '',
            'selectedPageCssClass' => 'active',
        ));
        ?>
    </div>
    <?php
} 
