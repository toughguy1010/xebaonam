<div class="brand-explore-page">
    <div class="container">
        <div class="title-inpage">
            <div class="left-title">
                <h2 class="">THUÊ ĐỒ</h2>
            </div>
            <div class="right-title">
                <ul>
                    <li><a href="<?php echo Yii::app()->createUrl('economy/product/rentProductdetail').'#thue-do'?>">HƯỚnG DẪN THUÊ ĐỒ</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('economy/product/rentProductdetail').'#chinh-sach'?>">CHÍNH SÁCH THUÊ ĐỒ</a></li>
                    <li>
                        <a href="javascript:void(0);"><i class="fa fa-search"></i></a>
                    </li>
                </ul>
                <div class="header-search-hiden">
                    <form class="form-search" id="search_mini_form">
                        <input class="input-text" type="text" value="" placeholder="Tìm kiếm...">
                        <button class="search-btn-bg" title="Tìm kiếm" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="ctn-categories-product ctn-thue-do-p">
            <?php if (isset($data) && count($data)) { ?>
                <?php foreach ($data as $key => $value) {
                    ?>
                    <div class="cate-thue-do-p">
                        <div class="item-categories-product">
                            <div class="title-cate-thue-do">
                                <h2><a href="<?php echo Yii::app()->createUrl('economy/product/rentProductdetail',array('id'=>$value['rent_id']))?>"><?php echo $value['name'] ?></a></h2>
                                <p><?php echo $value['description'] ?></p>
                                <a href="<?php echo Yii::app()->createUrl('economy/product/rentProductdetail',array('id'=>$value['rent_id']))?>" class="view-detail">Chi tiết</a>
                            </div>
                        </div>
                        <?php if (isset($value['item']) && count($value['item'])) { ?>
                            <?php
                            $i =0;
                            foreach ($value['item'] as $pkey => $product) {
                                if (++$i > 7) {
                                    continue;
                                }
                                ?>
                                <div class="item-categories-product">
                                    <div class="img-categories-product">
                                        <a href="<?php echo Yii::app()->createUrl('economy/product/rentProductdetail',array('id'=>$value['rent_id']))?>">
                                            <img
                                                src="<?php echo ClaHost::getImageHost(), $product['avatar_path'], 's280_280/', $product['avatar_name'] ?>"
                                                alt="<?php echo $product['name']; ?>">
                                        </a>
                                    </div>
                                    <div class="title-categories-product">
                                        <h2><a href="<?php echo Yii::app()->createUrl('economy/product/rentProductdetail',array('id'=>$value['rent_id']))?>">
                                                <?php echo HtmlFormat::sub_string($product['display_name'], 50); ?>
                                            </a>
                                        </h2>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

    </div>
</div>

