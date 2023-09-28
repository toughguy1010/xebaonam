<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="item-footer">
        <?php if ($show_widget_title) { ?>
            <h2><?php echo $widget_title ?></h2>
        <?php } ?>
        <p style="margin-top:20px;"><span><i class="fa fa-map-marker"></i>Address:</span> <?= $siteinfo['address'] ?></p>
        <p><i class="fa fa-phone"></i><span>Phone:</span> 
            <a style="color: #FFFFFF;" href="tel:<?= $siteinfo['phone'] ?>"><?= $siteinfo['phone'] ?></a>
        </p>
        <?php if ($showemail) { ?>
            <p>
                <i class="fa fa-envelope"></i><span>Email:</span> 
                <a style="color: #FFFFFF" href="mailto:<?= $siteinfo['admin_email'] ?>"><?= $siteinfo['admin_email'] ?></a>  
            </p>
        <?php } ?>
    </div>
</div>