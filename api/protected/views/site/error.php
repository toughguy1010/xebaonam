<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <div class="error-container">
            <div class="well">
                <h1 class="grey lighter smaller">
                    <span class="blue bigger-125">
                        <i class="icon-sitemap"></i>
                        <?php echo $code; ?>
                    </span>
                </h1>

                <hr>
                <h3 class="smaller red">
                    <?php echo CHtml::encode($message); ?>
                </h3>

                <hr>
                <div class="space"></div>

                <div class="center">
                    <a href="<?php echo Yii::app()->homeUrl; ?>" class="btn btn-primary">
                        <i class="icon-dashboard"></i>
                        <?php
                        echo Yii::t('common', 'adminpanel');
                        ?>                    </a>
                </div>
            </div>
        </div><!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div>