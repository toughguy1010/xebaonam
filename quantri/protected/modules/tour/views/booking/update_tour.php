<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <div class="space-6">
        </div>

        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="widget-box transparent invoice-box">
                    <div class="widget-header widget-header-large">
                        <div class="col-xs-8">

                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'orders-form',
                                'enableAjaxValidation' => false,
                                'htmlOptions' => array('class' => 'form-inline'),
                            ));
                            ?>
                            <label><?php echo $model->getAttributeLabel('status'); ?> : </label>
                            <?php echo $form->dropDownList($model, 'status', TourBooking::statusArray()); ?>
                            <?php echo CHtml::submitButton(Yii::t('common', 'update'), array('class' => 'btn btn-sm btn-primary', 'style' => 'margin-left:20px;')); ?>
                            <?php $this->endWidget(); ?>
                        </div>
                        <div class="widget-toolbar no-border invoice-info">
                            <span class="invoice-info-label"><?php echo Yii::t('shoppingcart', 'invoice') ?>:</span>
                            <span class="red">#<?php echo $model->booking_id; ?></span>

                            <br>
                            <span class="invoice-info-label"><?php echo Yii::t('common', 'date') ?>:</span>
                            <span class="blue"><?php echo date('m-d-Y H:i:s', $model->created_time); ?></span>
                        </div>

                        <div class="widget-toolbar hidden-480">
                            <a href="#">
                                <i class="icon-print"></i>
                            </a>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main padding-24">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                                            <b><?php echo Yii::t('shoppingcart', 'billing-text') ?></b>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <ul class="list-unstyled spaced">
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <?= Yii::t('common', 'name') ?>:
                                                <strong><?php echo $model['name'] ?></strong>
                                            </li>

                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <?= Yii::t('common', 'address') ?>:
                                                <strong><?php echo $model['address'] ?></strong>
                                            </li>

                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <?= Yii::t('book_room', 'province_id') ?>: <strong><?php
                                                    echo $province['name'];
                                                    ?></strong>

                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <?= Yii::t('common', 'phone') ?>: <b
                                                        class="blue"><?php echo $model['phone'] ?></b>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <?= Yii::t('common', 'email') ?>: <strong><?php echo $model['email'] ?></strong>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <?= Yii::t('book_room', 'passport') ?>: <strong><?php echo $model['passport'] ?></strong>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <?= Yii::t('book_room', 'flight_number') ?>
                                                : <strong><?php echo $model['flight_number'] ?></strong>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                                            <b><?php echo Yii::t('book_room', 'book_tour_text') ?></b>
                                        </div>
                                    </div>

                                    <div>
                                        <ul class="list-unstyled  spaced">
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <?= Yii::t('book_room', 'length') ?>:
                                                <strong><?php echo $model['length'] ?></strong>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <?= Yii::t('book_room', 'tour_style') ?>: <?php
                                                $tour_style = TourStyle::model()->findByPk($model['tour_style']);
                                                ?><strong><?= $tour_style['name'] ?></strong>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <?= Yii::t('book_room', 'star_rating') ?>: <?php
                                                $star_rating = TourHotelGroup::model()->findByPk($model['star_rating']);
                                                ?><strong><?= $star_rating['name'] ?></strong>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <?= Yii::t('book_room', 'places_to_visit') ?>: <strong><?php
                                                    $places_to_visit_id = explode(" ", $model['places_to_visit']);
                                                    $i = 0;
                                                    foreach ($places_to_visit_id as $value) {
                                                        $i++;
                                                        $places_to_visit = TourTouristDestinations::model()->findByPk($value);
                                                        echo $places_to_visit['name'] . ($i != count($places_to_visit_id) ? ", " : "");
                                                    }
                                                    ?></strong>

                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <?= Yii::t('book_room', 'adults') ?>:
                                                <strong><?php echo ($model['adults'] > 0) ? $model['adults'] : "" ?></strong>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <?= Yii::t('book_room', 'children') ?>:
                                                <strong><?php echo ($model['children'] > 0) ? $model['children'] : "" ?></strong>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- row -->

                            <div class="space"></div>

                            <div>
                                <?php $this->renderPartial('_tours', array('tours' => $tours, 'model' => $model)); ?>
                            </div>

                            <div class="hr hr8 hr-double hr-dotted"></div>

                            <div class="row">
                                <div class="col-sm-5 pull-right">
                                    <h4 class="pull-right">
                                        <?php echo Yii::t('common', 'total') ?> :
                                        <span class="red"><?php echo ($model['booking_total'] > 0) ? Product::getPriceText(array('price' => $model['booking_total'])) : Yii::t('common', 'contact'); ?></span>
                                    </h4>
                                </div>
                            </div>

                            <div class="space-6"></div>
                            <?php if ($model['note']) { ?>
                                <div class="well">
                                    <?php echo $model['note'] ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div>