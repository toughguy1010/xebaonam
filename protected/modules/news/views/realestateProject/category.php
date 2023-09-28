<?php if (isset($list_realestateProject) && count($list_realestateProject)) { ?>
    <div class="new-project">
        <?php foreach ($list_realestateProject as $realestate) { ?>
            <div class="box-prọject">
                <div class="box-img">
                    <a href="<?php echo $realestate['link'] ?>">
                        <?php if ($realestate['image_path'] && $realestate['image_name']) { ?>
                            <img src="<?php echo ClaHost::getImageHost() . $realestate['image_path'] . 's800_800/' . $realestate['image_name'] ?>"
                                 alt="<?php echo $realestate['name'] ?>">
                        <?php } ?>
                    </a>
                    <div class="in-the-list">

                        <p class="finish"><?php echo $realestate['type'] ?></p>
                    </div>
                </div>
                <div class="box-info">
                    <div class="title-project">
                        <h4><a href="<?php echo $realestate['link'] ?>"><?php echo $realestate['name'] ?></a></h4>
                    </div>
                    <div class="description-project">
                        <p>
                            <b>Địa chỉ: </b><?php
                            echo $realestate['full_address']; ?> <br>
                            <b>Giá mỗi căn: </b><?php echo $realestate['price_range']; ?><br>
                            <b>Diện tích: </b><?php echo $realestate['area']; ?><br>
                            <b>Quy mô: </b> <?php echo $realestate['sort_description']; ?>
                        </p>
                    </div>
                    <div class="share-social">
                        <img src="/themes/introduce/w3ni253/css/img/social.png">
                    </div>
                </div>
            </div>
        <?php }
        ?>
    </div>
    <div class='product-page'>
        <?php
        $this->widget('common.extensions.LinkPager.LinkPager', array(
            'itemCount' => $totalitem,
            'pageSize' => $limit,
            'header' => '',
            'htmlOptions' => array('class' => 'W3NPager',), // Class for ul
            'selectedPageCssClass' => 'active',
        ));
        ?>
    </div>
<?php } ?>