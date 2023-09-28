<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <div class="space-6">
        </div>

        <div class="row">
            <div class="col-sm-12">
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
                                                <?php echo $model['name'] ?>
                                            </li>

                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <?php echo $model['address'] ?>
                                            </li>

                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <?php
                                                $province = LibProvinces::getProvinceDetail($model['province_id']);
                                                echo $province['name'];
                                                ?>
                                            </li>

                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <b class="blue"><?php echo $model['phone'] ?></b>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <?php echo $model['email'] ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div><!-- /span -->
                            </div><!-- row -->

                            <div class="space"></div>

                            <div>
                                <?php $this->renderPartial('_rooms', array('rooms' => $rooms, 'model' => $model)); ?>
                            </div>

                            <div class="hr hr8 hr-double hr-dotted"></div>

                            <div class="row">
                                <div class="col-sm-5 pull-right">
                                    <h4 class="pull-right">
                                        <?php echo Yii::t('common', 'total') ?> :
                                        <span class="red"><?php echo Product::getPriceText(array('price' => $model['booking_total'])); ?></span>
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