<div class="order-sale-page float-full pad-70-0">
    <div class="container">
        <div class="order-sale_s2 float-full">
            <div class="title-1 center">
                <h2><span>3 bước đơn giản để hoàn thành dự án</span></h2>
                <div class="desc">
                    <p>Để có một bản dịch hoàn hảo và chính xác, bạn chỉ cần hoàn thành 3 bước đơn giản dưới đây</p>
                </div>
            </div>
            <div class="content-order-sale-s2 float-full">
                <div class="content-order-sale-s2 float-full">
                    <div id="shopcart">
                        <?php
                        $shoppingCart = Yii::app()->customer->getShoppingCartTranslate();
                        $files = $shoppingCart->getFiles();
                        ?>
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th class="col-1">Tên file</th>
                                <th class="col-2">Loại file</th>
                                <th class="col-3">Số lượng từ</th>
                                <th class="col-3">Xóa</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($files) { ?>
                                <?php foreach ($files as $key => $value) { ?>
                                    <tr>
                                        <td class="file-name">
                                            <h4><?= $value['display_name'] ?></h4>
                                        </td>
                                        <td class="file-name">
                                            <?= $value['extension'] ?>
                                        </td>
                                        <td class="count-char"><?= $value['w_qty'] ?>  </td>
                                        <td class="delete-file">
                                            <a onclick="return confirm('<?php echo Yii::t('translate', 'delete_words_from_cart_confirm'); ?>')"
                                               href="<?php echo $this->createUrl('/economy/shoppingcartTranslate/delete', array('key' => $key)); ?>">
                                                <i
                                                        class="fa fa-close"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td class="hightlight-text file-name">
                                        <?= Yii::t('translate', 'total_file') . ': ' . $shoppingCart->countFiles(); ?>
                                    </td>
                                    <td class="hightlight-text count-char">
                                        <?= Yii::t('translate', 'total_word') . ': ' . $shoppingCart->countTotalWords(); ?>
                                    </td>
                                    <td class="hightlight-text delete-file">
                                        <!--                <a href="#"><i class="fa fa-close"></i></a>-->
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="bottom-order-sale">
                    <div class="button-1">
                        <a href="<?= Yii::app()->createUrl('economy/shoppingcartTranslate/order') ?>">
                            <button>Tải file từ thiết bị của bạn</button>
                        </a>
                    </div>
                    <div class="button-2">
                        <a href="<?= Yii::app()->createUrl('economy/shoppingcartTranslate/selectLang') ?>">Bước tiếp
                            theo</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="list-news-category-type-2 float-full">
            <div class="title-1 center">
                <h2><span>Tin tức cập nhật</span></h2>
            </div>
            <div class="row multi-columns-row">
                <div class="item-news-category col-lg-4">
                    <div class="img-news">
                        <a href="#">
                            <img src="<?php echo Yii::app()->theme->baseUrl . '/demo/images/type-1-img-news-category-1.jpg' ?>"
                                 class="img-responsive" alt="Image">
                        </a>
                    </div>
                    <div class="caption-news">
                        <h4><a href="#">Dịch chứng từ bảo hiểm</a></h4>
                        <div class="date-time">
                            <p><i class="fa fa-clock-o"></i> 02/03/2018</p>
                            <p class="separated">|</p>
                            <p>Đăng bởi: Admin</p>
                        </div>
                        <div class="desc">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                            ut labore et dolore magna aliqua.
                        </div>
                        <a href="#" class="read-more-1">Đọc tiếp <i class="fa fa-long-arrow-right"></i></a>
                    </div>
                </div>
                <div class="item-news-category col-lg-4">
                    <div class="img-news">
                        <a href="#">
                            <img src="<?php echo Yii::app()->theme->baseUrl . '/demo/images/type-1-img-news-category-2.jpg' ?>"
                                 class="img-responsive" alt="Image">
                        </a>
                    </div>
                    <div class="caption-news">
                        <h4><a href="#">Dịch website - phần mềm</a></h4>
                        <div class="date-time">
                            <p><i class="fa fa-clock-o"></i> 02/03/2018</p>
                            <p class="separated">|</p>
                            <p>Đăng bởi: Admin</p>
                        </div>
                        <div class="desc">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                            ut labore et dolore magna aliqua.
                        </div>
                        <a href="#" class="read-more-1">Đọc tiếp <i class="fa fa-long-arrow-right"></i></a>
                    </div>
                </div>
                <div class="item-news-category col-lg-4">
                    <div class="img-news">
                        <a href="#">
                            <img src="<?php echo Yii::app()->theme->baseUrl . '/demo/images/type-1-img-news-category-3.jpg' ?>"
                                 class="img-responsive" alt="Image">
                        </a>
                    </div>
                    <div class="caption-news">
                        <h4><a href="#">Dịch chuyên ngành khoa học chuyên ngành khoa học</a></h4>
                        <div class="date-time">
                            <p><i class="fa fa-clock-o"></i> 02/03/2018</p>
                            <p class="separated">|</p>
                            <p>Đăng bởi: Admin</p>
                        </div>
                        <div class="desc">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                            ut labore et dolore magna aliqua.
                        </div>
                        <a href="#" class="read-more-1">Đọc tiếp <i class="fa fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

	