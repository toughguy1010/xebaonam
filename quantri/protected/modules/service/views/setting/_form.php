<div class="row">
    <div class="col-xs-12 no-padding">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#general">
                        <?php echo Yii::t('service', 'general'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#holidays">
                        <?php echo Yii::t('service', 'holidays'); ?>
                    </a>
                </li>

                <li class="">
                    <a data-toggle="tab" href="#business_hours">
                        <?php echo Yii::t('service', 'business_hours'); ?>
                    </a>
                </li>

            </ul>
            <div class="tab-content">
                <div id="general" class="tab-pane active">
                    <?php
                    $this->renderPartial('partial/general', array( 'GeneralModel' => $GeneralModel,));
                    ?>
                </div>
                <div id="holidays" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/holidays', array());
                    ?>
                </div>
                <div id="business_hours" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/business_hours', array('businessHours' => $businessHours,));
                    ?>
                </div>
            </div>
        </div>
    </div><!-- form -->
</div>