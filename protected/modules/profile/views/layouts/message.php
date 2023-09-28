<?php $this->beginContent('//layouts/main'); ?>
<div id="main">
    <div id="lprofile" class="row form">
        <div id="profileleft" class="col-xs-12 col-md-3">
            <?php
            $this->renderPartial('application.modules.profile.views.layouts.partial.profile_left')
            ?>
        </div>
        <div id="profilecenter" class="col-xs-12 col-md-9">
            <?php echo $content; ?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>