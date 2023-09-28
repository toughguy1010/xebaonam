<?php $this->beginContent('//layouts/main'); ?>
<div class="content">
    <div class="container">
        <?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
        <div class="menu-user">
            <ul class="clearfix">
                <li><a href="#" title="#">Thông tin chung</a></li>
                <li class="active"><a href="#" title="#">Cửa hàng yêu thích</a></li>
                <li><a href="#" title="#">Sản phẩm yêu thích</a></li>
            </ul>
        </div>
        <?php echo $content; ?>
    </div>
</div>
<?php $this->endContent(); ?>