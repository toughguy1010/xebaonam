<div class="col-xs-4">
    <div class="box-all-nd">
        <div class="header-panel">
            <a class="head-title" href="<?php echo $link ?>" title="<?php echo $page['title']; ?>">
                <h3><?php echo $page['title']; ?></h3>
            </a>
        </div>
        <div class="box-nd">
            <div class="nd-nd">	
                <div class="img-box-nd">
                    <div class="img-box">
                        <a href="<?php echo $link; ?>" title="<?php echo $page['title']; ?>">
                            <img src="<?php echo ClaHost::getImageHost() . $page['image_path'] . 's280_280/' . $page['image_name']; ?>" alt="<?php echo $page['title']; ?>"/>
                        </a>
                    </div>
                </div>
                <p>
                    <?php
                    echo $page['meta_description'];
                    ?>
                </p>	
            </div>
        </div><!--end-box-nd-->	
    </div>
</div>