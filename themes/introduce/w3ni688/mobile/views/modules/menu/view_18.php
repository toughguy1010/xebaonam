
<?php if (isset($data) && count($data)) { ?>

<div class="cs-nd">
    <div class="container clear-float">
        <div class="row">
             <?php foreach ($data as $menu_id => $menu) {?>
            <div class="chinhsach">
                <h2><a href="#"><?php echo $menu['menu_title']; ?></a></h2>
                 <?php if ($menu['items'] && count($menu['items'])){ ?>
                    <div class="content-chinhsach">
                        <?php foreach ($menu['items'] as $key => $menu2){?>
                        <p>
                            <a href="<?php echo $m_link; ?>"><i class="fa fa-star"></i> 
                                <?php echo $menu2['menu_title']; ?>
                            </a>
                        </p>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

           <?php }?>
       </div>
       <!-- <div class="clear"></div> -->
    </div>
</div>
<?php }?>