<style type="text/css">
    #loading {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        color: #ffffff;
        width: 200px;
        height: 50px;
        border-radius: 10px;
        background: #333;
        line-height: 50px;
        text-align: center;
        opacity: 0.5;
        font-size: 20px;
    }
</style>
<div id="loading">Loading...</div>
<?php if (count($jobs)) { ?>
    <div class="list-item-job">
        <h2>
            <span><?php echo number_format($totalitem, 0, ',', '.'); ?></span> công việc được tìm thấy
            <input style="float:right" class="span2" size="16" type="text" value="12-02-2012">
        </h2>
        <?php foreach ($jobs as $job) { ?>
            <div class="item-job-company">
                <div class="logo-company">
                    <a href="<?php echo $job['link']; ?>" title="<?php echo $job['position']; ?>">
                        <img src="<?php echo ClaHost::getImageHost() . $job['image_path'] . 's200_200/' . $job['image_name']; ?>" alt="<?php echo $job['news_title']; ?>" />
                    </a>
                </div>
                <div class="content-requirment">
                    <h3>
                        <a href="<?php echo $job['link']; ?>" title="<?php echo $job['position']; ?>"><?php echo $job['position']; ?></a>
                    </h3>
                    <?php if ($job['company']) { ?>
                        <p><?php echo $job['company'] ?></p>
                    <?php } ?>
                    <?php
                    $locations = explode(',', $job['location']);
                    $location_text = Jobs::getListLocationText($locations, array('provinces' => $provinces));
                    ?>
                    <p><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo $location_text; ?></p>
                    <a href=""><i class="fa fa-money" aria-hidden="true"></i>Đăng nhập để xem mức lương</a>
                    <p>Cập nhật: Hôm nay</p>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="paginate">
        <?php
        $this->widget('common.extensions.LinkPager.LinkPager', array(
            'itemCount' => $totalitem,
            'pageSize' => $limit,
            'header' => '',
            'htmlOptions' => array('class' => 'pagination',), // Class for ul
            'selectedPageCssClass' => 'active',
        ));
        ?>
    </div>
<?php } ?>