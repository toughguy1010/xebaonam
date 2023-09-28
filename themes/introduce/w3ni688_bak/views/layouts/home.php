<?php
$this->beginContent('//layouts/main_index');
?>
<!-- menu slider news -->


<div class="menu_slider_news">
    <div class="container">
        <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK1));
        ?>
    </div>
</div>

<div class="main_v">
    <div class="container">
        <div class="content_p">
             <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK2)); ?>
        <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK4)); ?>
        </div>
       

        <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK5)); ?>
    </div>

</div>
<?php
echo $content;
?>

<?php $this->endContent(); ?>
