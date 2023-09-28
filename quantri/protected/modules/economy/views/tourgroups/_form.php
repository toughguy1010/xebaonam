<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'tour-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        $from_create = Yii::app()->request->getParam('create');
        ?>

        <div class="tabbable">
            <ul class="nav nav-tabs padding-12" id="myTab">
                <li class="<?php if(!$from_create) echo 'active' ?>">
                    <a data-toggle="tab" href="#basicinfo">
                        <?php echo Yii::t('tour_group', 'tour_group_basicinfo'); ?>
                    </a>
                </li>
                <li class="<?php if($from_create) echo 'active' ?>">
                    <a data-toggle="tab" href="#tours">
                        <?php echo Yii::t('tour_group', 'tour_group_tours'); ?>
                    </a>
                </li>
            </ul>
            <?php if(!isset($option)){
                $option = '';
            } ?>
            <div class="tab-content">
                <div id="basicinfo" class="tab-pane <?php if(!$from_create) echo 'active' ?>">
                    <?php
                    $this->renderPartial('partial/tabbasicinfo', array('model' => $model, 'form' => $form, 'option' => $option));
                    ?>
                </div>
                <div id="tours" class="tab-pane <?php if($from_create) echo 'active' ?>">
                    <?php
                    $this->renderPartial('partial/tours', array('model' => $model));
                    ?>
                </div>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->