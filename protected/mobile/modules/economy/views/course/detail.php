<div class="product-detail">
    <div class="product-detail-box">
        <h2 class="product-info-title"><?php echo $course['name']; ?></h2>
        <div class="product-detail-img clearfix">
            <div>
                <div class="product-img-main"> 
                    <a class="product-img-small product-img-large cboxElement" onclick="javascript:void(0)"> 
                        <img src="<?php echo ClaHost::getImageHost() . $course['image_path'] . 's400_400/' . $course['image_name'] ?>"> 
                    </a>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="product-detail-info" id="product-detail-info">
            <div class="product-info-col1">
                <?php if ($course['time_for_study']) { ?>
                    <p class="product-detail-saving"><span><?php echo Yii::t('course', 'time_for_study') ?>:</span> <span class="saving-up"><?php echo $course['time_for_study'] ?></span></p>
                <?php } ?>
                <?php if ($course['number_of_students']) { ?>
                    <p class="product-detail-sortdesc"> <span><?php echo Yii::t('course', 'number_of_students') ?>: </span> <span class="condition"><?php echo $course['number_of_students'] ?></span></p>
                <?php } ?>
                <?php if ($course['school_schedule']) { ?>
                    <p class="product-detail-sortdesc"> <span><?php echo Yii::t('course', 'school_schedule') ?>:</span> <span class="condition"><?php echo $course['school_schedule']; ?></span></p>
                <?php } ?>
                <?php if ($course['number_lession']) { ?>
                    <p class="product-detail-sortdesc"> <span><?php echo Yii::t('course', 'number_lession') ?>:</span> <span class="condition"><?php echo $course['number_lession']; ?></span></p>
                <?php } ?>
                <?php if ($course['course_open']) { ?>
                    <p class="product-detail-sortdesc"> <span><?php echo Yii::t('course', 'course_open') ?>:</span> <span class="condition"><?php echo date('d/m/Y', $course['course_open']); ?></span></p>
                <?php } ?>
                <?php if ($course['course_finish']) { ?>
                    <p class="product-detail-sortdesc"><span><?php echo Yii::t('course', 'course_finish') ?>:</span> <span class="condition"><?php echo date('d/m/Y', $course['course_finish']); ?></span></p>
                <?php } ?>
                <?php if ($course['price'] && $course['price'] > 0) { ?>
                    <p class="product-price"><span><?php echo Yii::t('course', 'course_price') ?>:</span><span class="product-detail-price"> <span class="pricetext"><?php echo HtmlFormat::money_format($course['price']) ?></span><span class="currencytext"> VNĐ</span> </span> </p>
                <?php } else { ?>
                    <p class="product-price"><span><?php echo Yii::t('course', 'course_price') ?>:</span><span class="product-detail-price"> <span class="pricetext">Liên hệ</span> </p>
                <?php } ?>
                <?php if ($course['price_market'] && $course['price_market'] > 0) { ?>
                    <p class="product-detail-sortdesc"><span><?php echo Yii::t('course', 'course_price_market') ?>:</span> <span class="old-price"> <?php echo HtmlFormat::money_format($course['price_market']) ?> VNĐ</span></p>
                <?php } ?>
            </div>
            <div class="registered">
                <div class="registered-action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">
                        <span>Đăng ký</span><span class="hiden-mobile"> học ngay </span>
                    </button>

                    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content ">
                                <?php
                                $this->widget('common.widgets.modules.courseRegisterEdu.courseRegisterEdu', array(
                                    'url_return' => 'hungtmdt',
                                    'id' => $course['id']
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="teachear-in">
        <div class="title">
            <h2> <a onclick="javascript:void(0)"><?php echo Yii::t('course', 'lecturer') ?></a></h2>
            <div class="line"></div>
        </div>
        <div class="cont">
            <div class="row">
                <div class="col-md-6 box-left">
                    <div class="box-body">
                        <p class="name"><?php echo $lecturer->name ?></p>
                        <p class="chucdanh"><?php echo $lecturer->job_title ?></p>
                        <p class="company"><?php echo $lecturer->company ?></p>
                        <p class="kinhnghiem">Đã có <?php echo $lecturer->experience ?> năm kinh nghiệm trong giảng dạy.</p>
                        <?php if ($lecturer->phone) { ?>
                            <p class="dt-gv"><?php echo Yii::t('common', 'phone'); ?>: <span><?php echo $lecturer->phone ?></span></p>
                        <?php } ?>
                        <?php if ($lecturer->facebook) { ?>
                            <div class="social-teacher">
                                <ul class="clearfix">
                                    <li>
                                        <a href="<?php echo $lecturer->facebook ?>" target="_blank" class="fb"></a>
                                    </li>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clear"></div>
                    <div class="box-deg">
                        <p><?php echo $lecturer->sort_description ?></p>
                    </div>
                </div>
                <div class="col-md-6 box-right">
                    <div class="avatar">
                        <div class="box-img">
                            <div class="bg-img">
                                <img src="<?php echo Yii::app()->theme->baseUrl ?>/css/img/bg-img2.png">
                            </div>
                            <div class="box-img-cont">
                                <img src="<?php echo ClaHost::getImageHost() . $lecturer->avatar_path . 's330_330/' . $lecturer->avatar_name ?>" alt="<?php echo $lecturer->name ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product-detail-more">
        <div class="tab">
            <div class="title">
                <h2><a onclick="javascript:void(0)"><?php echo Yii::t('course', 'course_content') ?></a></h2>
                <div class="line"></div>
            </div>
            <div class="tab-content">
                <div id="home" class="tab-pane fade active">
                    <?php echo $courseInfo['description']; ?>
                </div>
            </div>
        </div>
    </div>
</div>