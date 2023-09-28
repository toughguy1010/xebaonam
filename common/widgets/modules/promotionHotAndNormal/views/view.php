<?php if (count($data)) {
    $aryNornal = $data['normal'];
    $aryHot = $data['hot'];
    $firstHotPromotion = ClaArray::getFirst($aryHot);
    $aryHot = ClaArray::removeFirstElement($aryHot);
    $secondHotPromotion = ClaArray::getFirst($aryHot);
    $aryHot = ClaArray::removeFirstElement($aryHot);
    $ary1 = array_chunk($aryNornal, 4);
    $ary2 = array_chunk($aryNornal, 2);
} ?>
<div class="hot-deal-page">
    <div class="ctn-hot-deal">
        <div class="row">
            <div class="cell-hot-deal clearfix">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="item-categories-product hot-deal-big">
                        <div class="title-cate-thue-do">
                            <a href="<?php echo $firstHotPromotion['link'] ?>"
                               title="<?php echo $firstHotPromotion['name'] ?>" class="img-cate-thue-do">
                                <?php if ($firstHotPromotion['image_path']) ?>
                                <img
                                    src="<?php echo ClaHost::getImageHost() . $firstHotPromotion['image_path'] . 's600_600/' . $firstHotPromotion['image_name']; ?>"
                                    alt="<?php echo $firstHotPromotion['name']; ?>"/>
                            </a>
                            <h2>
                                <a href="<?php echo $firstHotPromotion['link'] ?>"><?php echo $firstHotPromotion['name']; ?></a>
                            </h2>
                            <p><?php echo $firstHotPromotion['sortdesc']; ?></p>
                            <a href="<?php echo $firstHotPromotion['link']; ?>" class="view-detail">Chi tiết</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="box-none-boder">
                        <?php
                        if (isset($ary1[0]) && count($ary1[0])) {
                            foreach ($ary1[0] as $key => $val) {
                                ?>
                                <div class="item-categories-product">
                                    <div class="img-categories-product">
                                        <a href="<?php echo $val['link'] ?>" title="<?php echo $val['name'] ?>"
                                           class="img-cate-thue-do">
                                            <?php if (isset($val['image_path']) && isset($val['image_name']) && $val['image_path'] && $val['image_name']) ?>
                                            <img
                                                src="<?php echo ClaHost::getImageHost() . $val['image_path'] . 's350_350/' . $val['image_name']; ?>"
                                                alt="<?php echo $val['name']; ?>"/>
                                        </a>
                                    </div>
                                    <div class="title-categories-product">
                                        <h2>
                                            <a href="<?php echo $val['link'] ?>"><?php echo $val['name']; ?></a>
                                        </h2>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
            </div>
            <?php
            if (isset($ary1[1]) && count($ary1[1])) { ?>
                <div class="cell-hot-deal clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="item-categories-product hot-deal-big">
                            <div class="title-cate-thue-do">
                                <a href="<?php echo $secondHotPromotion['link'] ?>"
                                   title="<?php echo $secondHotPromotion['name'] ?>" class="img-cate-thue-do">
                                    <?php if ($secondHotPromotion['image_path']) ?>
                                    <img
                                        src="<?php echo ClaHost::getImageHost() . $secondHotPromotion['image_path'] . 's600_600/' . $secondHotPromotion['image_name']; ?>"
                                        alt="<?php echo $firstHotPromotion['name']; ?>"/>
                                </a>
                                <h2><a href=""><?php echo $secondHotPromotion['name']; ?></a></h2>
                                <p><?php echo $secondHotPromotion['sortdesc']; ?></p>
                                <a href="<?php echo $secondHotPromotion['link']; ?>" class="view-detail">Chi
                                    tiết</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="box-none-boder">
                            <?php
                            if (isset($ary1[1]) && count($ary1[1])) {
                                foreach ($ary1[1] as $key => $val) {
                                    ?>
                                    <div class="item-categories-product">
                                        <div class="img-categories-product">
                                            <a href="<?php echo $val['link'] ?>" title="<?php echo $val['name'] ?>"
                                               class="img-cate-thue-do">
                                                <?php if (isset($val['image_path']) && isset($val['image_name']) && $val['image_path'] && $val['image_name']) ?>
                                                <img
                                                    src="<?php echo ClaHost::getImageHost() . $val['image_path'] . 's350_350/' . $val['image_name']; ?>"
                                                    alt="<?php echo $val['name']; ?>"/>
                                            </a>
                                        </div>
                                        <div class="title-categories-product">
                                            <h2>
                                                <a href="<?php echo $val['link'] ?>"><?php echo $val['name']; ?></a>
                                            </h2>
                                        </div>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php
            if (isset($ary2[4]) && count($ary2[4])) { ?>
                <div class="cell-hot-deal clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="item-km-50">
                            <div class="ctn-km-50">
                                <div class="title-km-50">
                                    <div class="vertical">
                                        <h2><a href="">CÁC CHƯƠNG TRÌNH KHUYẾN MẠI</a></h2>
                                        <p>Check out the great gear and clothing that's new at UMOVE</p>
                                        <a href="" class="view-detail">Shop Brooks footwear</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--                    <div class="item-km-50">-->
                        <!--                        --><?php
                        //                        $i = 0;
                        //                        if (isset($ary1[2]) && count($ary1[2])) {
                        //                            foreach ($ary1[2] as $key => $val) {
                        //                                if (++$i > 2) continue;
                        //                                ?>
                        <!--                                <div class="item-categories-product">-->
                        <!--                                    <div class="img-categories-product">-->
                        <!--                                        <a href="-->
                        <?php //echo $val['link'] ?><!--" title="--><?php //echo $val['name'] ?><!--"-->
                        <!--                                           class="img-cate-thue-do">-->
                        <!--                                            --><?php //if (isset($val['image_path']) && isset($val['image_name']) && $val['image_path'] && $val['image_name']) ?>
                        <!--                                            <img-->
                        <!--                                                src="-->
                        <?php //echo ClaHost::getImageHost() . $val['image_path'] . 's350_350/' . $val['image_name']; ?><!--"-->
                        <!--                                                alt="-->
                        <?php //echo $val['name']; ?><!--"/>-->
                        <!--                                        </a>-->
                        <!--                                    </div>-->
                        <!--                                    <div class="title-categories-product">-->
                        <!--                                        <h2>-->
                        <!--                                            <a href="-->
                        <?php //echo $val['link'] ?><!--">--><?php //echo $val['name']; ?><!--</a>-->
                        <!--                                        </h2>-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!--                            --><?php //}
                        //                        } ?>
                        <!--                    </div>-->
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="box-none-boder">
                            <?php
                            if (isset($ary2[4]) && count($ary2[4])) {
                                foreach ($ary2[4] as $key => $val) {
                                    ?>
                                    <div class="item-categories-product">
                                        <div class="img-categories-product">
                                            <a href="<?php echo $val['link'] ?>" title="<?php echo $val['name'] ?>"
                                               class="img-cate-thue-do">
                                                <?php if (isset($val['image_path']) && isset($val['image_name']) && $val['image_path'] && $val['image_name']) ?>
                                                <img
                                                    src="<?php echo ClaHost::getImageHost() . $val['image_path'] . 's350_350/' . $val['image_name']; ?>"
                                                    alt="<?php echo $val['name']; ?>"/>
                                            </a>
                                        </div>
                                        <div class="title-categories-product">
                                            <h2>
                                                <a href="<?php echo $val['link'] ?>"><?php echo $val['name']; ?></a>
                                            </h2>
                                        </div>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="cell-hot-deal clearfix">
                <div class="col-xs-12">
                    <div class="box-none-boder">
                        <?php
                        if (isset($ary2[5]) && count($ary2[5])) {
                            foreach ($ary2[5] as $key => $val) {
                                ?>
                                <div class="item-categories-product width25">
                                    <div class="img-categories-product">
                                        <a href="<?php echo $val['link'] ?>" title="<?php echo $val['name'] ?>"
                                           class="img-cate-thue-do">
                                            <?php if (isset($val['image_path']) && isset($val['image_name']) && $val['image_path'] && $val['image_name']) ?>
                                            <img
                                                src="<?php echo ClaHost::getImageHost() . $val['image_path'] . 's350_350/' . $val['image_name']; ?>"
                                                alt="<?php echo $val['name']; ?>"/>
                                        </a>
                                    </div>
                                    <div class="title-categories-product">
                                        <h2>
                                            <a href="<?php echo $val['link'] ?>"><?php echo $val['name']; ?></a>
                                        </h2>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                        <?php
                        if (isset($ary2[6]) && count($ary2[6])) {
                            foreach ($ary2[6] as $key => $val) {
                                ?>
                                <div class="item-categories-product width25">
                                    <div class="img-categories-product">
                                        <a href="<?php echo $val['link'] ?>" title="<?php echo $val['name'] ?>"
                                           class="img-cate-thue-do">
                                            <?php if (isset($val['image_path']) && isset($val['image_name']) && $val['image_path'] && $val['image_name']) ?>
                                            <img
                                                src="<?php echo ClaHost::getImageHost() . $val['image_path'] . 's350_350/' . $val['image_name']; ?>"
                                                alt="<?php echo $val['name']; ?>"/>
                                        </a>
                                    </div>
                                    <div class="title-categories-product">
                                        <h2>
                                            <a href="<?php echo $val['link'] ?>"><?php echo $val['name']; ?></a>
                                        </h2>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .ctn-hot-deal .item-categories-product.width25 {
        width: 25%;
    }
</style>


    