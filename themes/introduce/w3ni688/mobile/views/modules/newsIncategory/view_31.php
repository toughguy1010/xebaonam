<?php if (count($news)) { ?>
    <div class="title">
        <a href="<?php echo $category['link'] ?>" title="<?php echo $category['cat_name'] ?>"><h2><?php echo $category['cat_name'] ?></h2></a>
    </div>   
    <?php foreach ($news as $ne) { ?>
        <div class="box-news">
            <div class="box-img img-news">
                <a href="<?php echo $ne['link'] ?>" title="<?php echo $ne['news_title'] ?>"> 
                    <img alt="<?php echo $ne['news_title'] ?>" src="<?php echo ClaHost::getImageHost(), $ne['image_path'], 's200_200/', $ne['image_name'] ?>" />
                </a> 
            </div>
            <div class="box-info">
                <h4>
                    <a href="<?php echo $ne['link'] ?>" title="<?php echo $ne['news_title'] ?>"><?php echo $ne['news_title'] ?></a> 
                </h4>
            </div>
        </div>
    <?php
    }
}
?>
