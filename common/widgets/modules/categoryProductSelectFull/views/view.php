<?php if (isset($data) && count($data)) { ?>
    <?php if ($level == 0) { ?>
        <?php if ($show_widget_title) { ?>
            <div class="panel-heading">
                <?php echo $widget_title; ?>
            </div>
        <?php } ?>
        <div id="cssmenu" class="<?php echo (ClaSite::getLinkKey() == ClaSite::getHomeKey()) ? 'menu_page_home' : 'menu_page_sub';?>">
        <?php } ?>
        <ul>
            <?php
            foreach ($data as $cat_id => $category) {
                $c_link = $category['link'];
                ?>
                <li class="<?php echo count($category['children']) ? 'has-sub' : '' ?>">
                    <?php if (isset($category['icon_path']) && $category['icon_path'] != '' && isset($category['icon_name']) && $category['icon_name'] != '') { ?>
                        <img class="img1" src="<?php echo ClaHost::getImageHost() . $category['icon_path'] . $category['icon_name'] ?>" />
                    <?php } ?>
                    <a href="<?php echo $c_link ?>" title="<?php echo $category['cat_name'] ?>"><?php echo $category['cat_name']; ?></a>
                    <?php
                    $this->render($this->view, array(
                        'data' => $category['children'],
                        'level' => $level + 1,
                    ));
                    ?>
                </li>
            <?php } ?>
        </ul>
    <?php if ($level == 0) { ?>
    </div>
<?php } } ?>
<script type="text/javascript">
    
    var home_page = '<?php echo (ClaSite::getLinkKey() == ClaSite::getHomeKey()) ? 'menu_page_home' : 'menu_page_sub';?>';
    jQuery(document).ready(function() {
        if( home_page == 'menu_page_sub' ) {
            jQuery('#cssmenu').css('display', 'none');
            jQuery('.box-menu').hover(function() {
                jQuery('#cssmenu').css('display', 'block');
            }, function() {
                jQuery('#cssmenu').css('display', 'none');
            })
        }
    });
    
</script>