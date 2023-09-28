<div class="listnews">
    <div class="list">
        <?php if (count($listcourse)) { ?>
            <?php
            foreach ($listcourse as $course) {
                ?>
                <div class="list-item">
                    <div class="list-content">
                        <div class="list-content-box">
                            <?php if ($course['image_path'] && $course['image_name']) { ?>
                                <div class="list-content-img">
                                    <a href="<?php echo $course['link']; ?>">
                                        <img src="<?php echo ClaHost::getImageHost() . $course['image_path'] . 's200_200/' . $course['image_name']; ?>">
                                    </a>
                                </div>
                            <?php } ?>
                            <div class="list-content-body">
                                <span class="list-content-title">
                                    <a href="<?php echo $course['link']; ?>">
                                        <?php echo $course['name']; ?>
                                    </a>
                                </span>
                                <div class="list-content-detail">
                                    <p>
                                        <?php
                                        echo $course['sort_description'];
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    
</div>