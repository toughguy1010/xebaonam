<?php $themUrl = Yii::app()->theme->baseUrl; ?>
<?php
//
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/colorbox/jquery.colorbox-min.js');
//
?>

<div class="top-detail">
    <div class="row">
        <div class="col-sm-8">
            <?php
            $images = $model->getImagesByType(1);
            $first = reset($images);
            ?>
            <div class="box-view-img">
                <div class="box-img-large">
                    <?php if ($first) { ?>
                        <a class="product-img-small product-img-large" href="<?php echo ClaHost::getImageHost() . $first['path'] . 's800_600/' . $first['name'] ?>">
                            <img src="<?php echo ClaHost::getImageHost() . $first['path'] . 's330_330/' . $first['name'] ?>">
                        </a>
                    <?php } ?>
                </div>
                <div class="box-item">
                    <?php if ($images && count($images)) { ?>

                        <ul class="clearfix">
                            <?php foreach ($images as $img) { ?>
                                <li>
                                    <a class="product-img-small" href="<?php echo ClaHost::getImageHost() . $img['path'] . 's800_600/' . $img['name']; ?>">
                                        <img src="<?php echo ClaHost::getImageHost() . $img['path'] . 's150_150/' . $img['name']; ?>">
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <h4 class="title-name-da">
                <?php
                echo $model['name'];
                ?>
            </h4>
            <div class="description-project">
                <p>
                    <b>Địa chỉ: </b><?php echo $model['address'] . '-' . $model['district_name'] . '-' . $model['province_name']; ?><br>
                    <b>Giá mỗi căn: </b><?php echo $model['price_range']; ?><br>
                    <b>Dện tích: </b><?php echo $model['area']; ?><br>
                    <b>Quy mô: </b><?php echo $model['sort_description']; ?>
                </p>
            </div>
            <div class="registered-action mua">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm-mua"><span>Đăng ký mua</span></button>
                <div class="modal fade bs-example-modal-sm-mua" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                    <div class="modal-dialog modal-sm-mua">
                        <div class="modal-content ">
                            <div class="header-popup clearfix"> <i class="icon-popup"></i>
                                <div class="title-popup">Đăng ký mua </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="cont">
                                <p class="more-popup">
                                    Bạn vui lòng nhập đầy đủ thông tin dưới đây. Tư vấn viên của chúng tôi sẽ gọi điện cho bạn
                                </p>
                                <form class="form-horizontal popup w3f-form" role="form" id="w3n-submit-form" action="/site/form/submit/id/6" method="post">
                                    <div class="form-group w3-form-group pop-ng ">
                                        <span class=" width-td">Họ và tên: </span> 
                                        <div class=" w3-form-field width-ip ">
                                            <input class="form-control w3-form-input input-text  " type="text" value="" name="W3NF[35][c21]" id="W3NF_35_c21"  placeholder="Ví dụ:Nguyễn Văn A">

                                        </div>
                                    </div>
                                    <div class="form-group w3-form-group pop-ng  ">
                                        <span class="width-td">Chọn dự án</span>

                                        <div class=" w3-form-field width-r">
                                            <select class="form-control width-r">
                                                <option>Chọn dự án </option>
                                                <option>DỰ ÁN HPU LANDMARK </option>
                                                <option>DỰ ÁN HPU LANDMARK </option>
                                                <option>DỰ ÁN HPU LANDMARK </option>
                                                <option>DỰ ÁN HPU LANDMARK </option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group w3-form-group pop-ng ">
                                        <span class=" width-td">Địa chỉ: </span> 
                                        <div class=" w3-form-field width-ip ">
                                            <input class="form-control w3-form-input input-text  " type="text" value="" name="W3NF[35][c21]" id="W3NF_35_c21"  placeholder="Ví dụ: 01234567">

                                        </div>
                                    </div>
                                    <div class="form-group w3-form-group pop-ng ">
                                        <span class=" width-td">Điện thoại: </span> 
                                        <div class=" w3-form-field width-ip ">
                                            <input class="form-control w3-form-input input-text  " type="text" value="" name="W3NF[35][c21]" id="W3NF_35_c21"  placeholder="Ví dụ: 01234567">

                                        </div>
                                    </div>
                                    <div class="form-group w3-form-group pop-ng ">
                                        <span class=" width-td">Email: </span> 
                                        <div class=" w3-form-field width-ip ">
                                            <input class="form-control w3-form-input input-text  " type="text" value="" name="W3NF[35][c21]" id="W3NF_35_c21"  placeholder="Ví dụ: abc@gmail.com">

                                        </div>
                                    </div>
                                    <div class="w3-form-group form-group">
                                        <div class=" w3-form-button">
                                            <div class="registered-action1">
                                                <button type="button" class="btn btn-primary"><span>Đăng ký </span></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK1));
            ?>

        </div>
    </div>
</div>
<div class="cont-detail">
    <div class="product-detail-more">
        <div class="tab">
            <ul role="tablist" class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" role="tab" href="#gioi-thieu-du-an">Giới thiệu dự án</a></li>
                <li class=""><a data-toggle="tab" role="tab" href="#tong-the-giao-thong">Tông thể giao thông</a></li>
                <li class=""><a data-toggle="tab" role="tab" href="#cac-tieu-chi-cua-du-an">Các chỉ tiêu của dự án</a></li>
                <li class=""><a data-toggle="tab" role="tab" href="#phoi-canh-du-an">Phối cảnh dự án</a></li>
                <li class=""><a data-toggle="tab" role="tab" href="#mat-bang-chi-tiet">Mặt bằng chi tiết</a></li>
                <li class=""><a data-toggle="tab" role="tab" href="#tien-do-du-an">Tiến độ dự án</a></li>
                <li class=""><a data-toggle="tab" role="tab" href="#ban-do-vi-tri">Bản đồ vị trí</a></li>
            </ul>

            <div class="tab-content">
                <div id="gioi-thieu-du-an" class="tab-pane fade active">
                    <h3 class="block-title">Giới thiệu dự án</h3>
                    <?php
                    if ($project_info['description']) {
                        echo $project_info['description'];
                    } else {
                        echo 'Đang cập nhập....';
                    }
                    ?>
                </div>
                <div id="tong-the-giao-thong" class="tab-pane fade">
                    <!--<h3 class="block-title">Tổng thể giao thông</h3>-->
                    <?php
                    if ($project_info['traffic']) {
                        echo $project_info['traffic'];
                    } else {
                        echo 'Đang cập nhập....';
                    }
                    ?>
                </div>
                <div id="cac-tieu-chi-cua-du-an" class="tab-pane fade">
                    <!--<h3 class="block-title">Các chỉ tiêu dự</h3>-->
                    <?php
                    if ($project_info['target']) {
                        echo $project_info['target'];
                    } else {

                        echo ' <h3 class="block-title">Giới thiệu dự án</h3>', 'Đang cập nhập....';
                    }
                    ?>

                </div>
                <div id="phoi-canh-du-an" class="tab-pane fade images-lq">
                    <?php
                    $images_land = $model->getImagesByType(2);
//                    $first = reset($images_land);
                    ?>
                    <h3 class="block-title">Phối cảnh dự án</h3>
                    <?php if ($images_land && count($images_land)) { ?>
                        <ul class="clearfix">
                            <?php foreach ($images_land as $img) { ?>
                                <li>
                                    <a class="project-img-small" href="<?php echo ClaHost::getImageHost() . $img['path'] . 's800_600/' . $img['name']; ?>">
                                        <img src="<?php echo ClaHost::getImageHost() . $img['path'] . 's200_200/' . $img['name']; ?>">
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>

                    <?php // echo $model['name'];   ?>

                </div>
                <div id="mat-bang-chi-tiet" class="tab-pane fade images-lq">
                    <?php
                    $images_ground = $model->getImagesByType(3);
//                    $first = reset($images_ground);
                    ?>
                    <h3 class="block-title">Mặt bẳng dự án</h3>
                    <?php if ($images_ground && count($images_ground)) { ?>
                        <ul class="clearfix">
                            <?php foreach ($images_ground as $img) { ?>
                                <li>
                                    <a class="project-ground-img-small" href="<?php echo ClaHost::getImageHost() . $img['path'] . 's800_600/' . $img['name']; ?>">
                                        <img src="<?php echo ClaHost::getImageHost() . $img['path'] . 's200_200/' . $img['name']; ?>">
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>

                    <?php // echo $model['name'];   ?>

                </div>
                <div id="tien-do-du-an" class="tab-pane fade news-footer">
                    <h3 class="block-title">Cập nhật tiến độ dự án</h3>
                    <?php
                    if ($news_in_cate) {
                        ?>
                        <ul>
                            <?php
                            foreach ($news_in_cate as $news) {
                                ?>
                                <li><a href="<?php echo $news['link'] ?>" title="<?php echo $news['news_title'] ?>"><?php echo $news['news_title'] ?></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                    }
                    ?>
                </div>
                <div id="ban-do-vi-tri" class="tab-pane fade">
                    <?php
                    if ($project_info['map']) {
                        echo $project_info['map'];
                    } else {
                        echo 'Đang cập nhập....';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery(document).on('click', '.product-info-conf-list .product-info-conf-item a', function () {
            $(this).closest('.product-info-conf').find('.product-info-conf-list .product-info-conf-item a').removeClass('active');
            $(this).addClass('active');
            var dataInput = $(this).attr('data-input');
            if (dataInput) {
                $(this).closest('.product-info-conf').find('.attrConfig-input').val(dataInput);
            }
            return false;
        });
    });

//    colorbox project iamge
    if (jQuery('.top-detail .box-view-img').length) {
        $(".top-detail .box-view-img a.product-img-large").colorbox({rel: 'product-img-large', innerHeight: 600, innerWidth: 800});
        $(".top-detail .box-view-img a.product-img-small").colorbox({rel: 'product-img-small', innerHeight: 600, innerWidth: 800});
        jQuery('.product-detail .box-view-img a.product-img-small').on('mouseover', function () {
            thumb_img_w = (typeof thumb_img_w != 'undefined') ? thumb_img_w : 330;
            thumb_img_h = (typeof thumb_img_h != 'undefined') ? thumb_img_h : 330;
            var href = jQuery(this).attr('href');
            var src = jQuery(this).find('img').attr('src');
            var thumb = jQuery(this).find('img').attr('data-thumb-image');
            if (href) {
                var clo = jQuery(this).closest('.box-view-img');
                clo.find('.product-img-main a.product-img-large').attr('href', href);
                if (!thumb)
                    clo.find('.product-img-main a.product-img-large img').attr('src', src.replace('\/s50_50\/', '\/s' + thumb_img_w + '_' + thumb_img_h + '\/'));
                else
                    clo.find('.product-img-main a.product-img-large img').attr('src', thumb);
            }
            return false;
        });
    }
//    colorbox land iamge
    if (jQuery('#phoi-canh-du-an').length) {
        $("#phoi-canh-du-an a.project-img-small").colorbox({rel: 'project-img-small', innerHeight: 600, innerWidth: 800});
        jQuery('#phoi-canh-du-an  a.project-img-small').on('mouseover', function () {
            thumb_img_w = (typeof thumb_img_w != 'undefined') ? thumb_img_w : 330;
            thumb_img_h = (typeof thumb_img_h != 'undefined') ? thumb_img_h : 330;
            var href = jQuery(this).attr('href');
            var src = jQuery(this).find('img').attr('src');
            var thumb = jQuery(this).find('img').attr('data-thumb-image');
            if (href) {
                var clo = jQuery(this).closest('.box-view-img');
                clo.find('#phoi-canh-du-an a.project-img-small').attr('href', href);
                if (!thumb)
                    clo.find('#phoi-canh-du-an a.project-img-small img').attr('src', src.replace('\/s50_50\/', '\/s' + thumb_img_w + '_' + thumb_img_h + '\/'));
                else
                    clo.find('#phoi-canh-du-an a.project-img-small img').attr('src', thumb);
            }
            return false;
        });
    }
//    colorbox ground iamge
    if (jQuery('#mat-bang-chi-tiet').length) {
        $("#mat-bang-chi-tiet a.project-ground-img-small").colorbox({rel: 'project-ground-img-small', innerHeight: 600, innerWidth: 800});
        jQuery('.product-detail .box-view-img a.product-img-small').on('mouseover', function () {
            thumb_img_w = (typeof thumb_img_w != 'undefined') ? thumb_img_w : 330;
            thumb_img_h = (typeof thumb_img_h != 'undefined') ? thumb_img_h : 330;
            var href = jQuery(this).attr('href');
            var src = jQuery(this).find('img').attr('src');
            var thumb = jQuery(this).find('img').attr('data-thumb-image');
            if (href) {
                var clo = jQuery(this).closest('.box-view-img');
                clo.find('#mat-bang-chi-tiet a.project-ground-img-small').attr('href', href);
                if (!thumb)
                    clo.find('#mat-bang-chi-tiet a.project-ground-img-small img').attr('src', src.replace('\/s50_50\/', '\/s' + thumb_img_w + '_' + thumb_img_h + '\/'));
                else
                    clo.find('#mat-bang-chi-tiet a.project-ground-img-small img').attr('src', thumb);
            }
            return false;
        });
    }
</script>