<?php
if (isset($doctors) && $doctors) {
    foreach ($doctors as $doctor) {
        ?> 
        <div class="col-md-3 col-sm-6 col-xs-6">
            <div class="all-exprest-on-page-info">
                <div class="img-exprest-on-page">
                    <img src="<?php echo ClaHost::getImageHost(), $doctor['avatar_path'], $doctor['avatar_name'] ?>" />
                </div>
                <div class="exprest-info">
                    <p class="exprest-name-box">
                        <?php echo $doctor['initials_name'] ?>
                        <br>
                        <?php echo $doctor['name'] ?>
                    </p>
                </div>
            </div>
        </div>
        <?php
    }
}
?>