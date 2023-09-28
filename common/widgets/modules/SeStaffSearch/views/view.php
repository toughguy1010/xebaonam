<div class="form-search-inline">
    <form action="<?php echo Yii::app()->createUrl('service/provider') ?>" method="GET" class="form-inline" role="form">
        <div class="form-group">
            <input value="<?= $n_compare ?>" name="n" type="text" class="form-control" placeholder="Tìm theo tên bác sĩ">
        </div>
        <?php if (isset($faculties) && $faculties) { ?>
            <div class="form-group">
                <select name="faculty" class="form-control">
                    <?php foreach ($faculties as $value => $faculty) { ?>
                        <option <?= $faculty_compare == $value ? 'selected' : '' ?> value="<?php echo $value ?>"><?php echo $faculty ?></option>
                    <?php } ?>
                </select>
            </div>
        <?php } ?>
        <div class="form-group">
            <select name="gender" class="form-control">
                <option value="">Giới tính</option>
                <option <?= $gender_compare == ActiveRecord::STATUS_ACTIVED ? 'selected' : '' ?> value="<?php echo ActiveRecord::STATUS_ACTIVED ?>">Nam</option>
                <option <?= $gender_compare == ActiveRecord::STATUS_DEACTIVED ? 'selected' : '' ?> value="<?php echo ActiveRecord::STATUS_DEACTIVED ?>">Nữ</option>
            </select>
        </div>
        <?php if (isset($languages) && $languages) { ?>
            <div class="form-group">
                <select name="lang" class="form-control">
                    <?php foreach ($languages as $value => $language) { ?>
                        <option <?= $lang_compare == $value ? 'selected' : '' ?> value="<?php echo $value ?>"><?php echo $language ?></option>
                    <?php } ?>
                </select>
            </div>
        <?php } ?>
        <?php if (isset($educations) && $educations) { ?>
            <div class="form-group">
                <select name="edu" class="form-control">
                    <?php foreach ($educations as $value => $education) { ?>
                        <option <?= $edu_compare == $value ? 'selected' : '' ?> value="<?php echo $value ?>"><?php echo $education ?></option>
                    <?php } ?>
                </select>
            </div>
        <?php } ?>

        <button type="submit" class="btn btn-default">Tìm kiếm</button>
    </form>
</div>