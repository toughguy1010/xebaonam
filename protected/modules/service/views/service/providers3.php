<?php
$data = isset($data) ? $data : array();
foreach ($data as $info) {
    ?>
    <div class="infor-booking style-3">
        <div class="staff">
            <?php
            foreach ($info['info'] as $provider) {
                ?>
                <div class="info-staff">
                    <div class="img-info-staff">
                        <a href="javascript:void(0)">
                            <?php if ($provider['provider']['avatar_path'] && $provider['provider']['avatar_name']) { ?>
                                <img src="<?php echo ClaHost::getImageHost(), $provider['provider']['avatar_path'], 's200_200/', $provider['provider']['avatar_name'] ?>" alt="<?php echo $provider['provider']['name'] ?>">
                            <?php } else { ?>
                                <img src="<?php echo Yii::app()->baseUrl . '/images/no-image.png'; ?>" alt="<?php echo $provider['provider']['name'] ?>">
                            <?php } ?>
                        </a>
                    </div>
                    <div class="title-staff">
                        <h2>
                            <a href="javascript:void(0)"><?php echo $provider['provider']['name']; ?></a>
                        </h2>
                        <span>
                            <?php echo $provider['service']['name']; ?>
                        </span>
                        <?php if ($provider['providerService']['price'] > 0) { ?>
                            <span>
                                Price $<?php echo HtmlFormat::money_format($provider['providerService']['price']); ?>
                            </span>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php
        $this->renderPartial('timeline', array('data' => $info));
        ?>
    </div>
    <?php
}
?>
