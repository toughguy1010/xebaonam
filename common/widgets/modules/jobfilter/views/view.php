<?php if (isset($trades) && count($trades)) { ?>
    <div class="box-filter">
        <h2>NGÀNH NGHỀ</h2>
        <div class="group-check-box">
            <?php foreach ($trades as $trade) { ?>
                <div class="checkbox">
                    <input type="checkbox" class="ais-checkbox" value="<?php echo $trade['trade_id'] ?>">
                    <label><span class="text-clip" title="<?php echo $trade['trade_name'] ?>"><?php echo $trade['trade_name'] ?></span></label>
                    <span class="facet-count pull-right"><?php echo number_format($trade['count_job'], 0, ',', '.') ?></span>
                </div>
            <?php } ?>
        </div>
        <div class="view-more-list-job"><a href="javascript:void(0);">Xem thêm</a></div>
    </div>
<?php } ?>
<?php if (isset($locations) && count($locations)) { ?>
    <div class="box-filter">
        <h2>ĐỊA ĐIỂM</h2>
        <div class="group-check-box">
            <?php foreach ($locations as $province_id => $location) { ?>
                <div class="checkbox">
                    <input type="checkbox" class="ais-checkbox" value="<?php echo $province_id ?>">
                    <label><span class="text-clip" title="<?php echo $location['province_name'] ?>"><?php echo $location['province_name'] ?></span></label>
                    <span class="facet-count pull-right"><?php echo number_format($location['count_job'], 0, ',', '.'); ?></span>
                </div>
            <?php } ?>
        </div>
        <div class="view-more-list-job"><a href="javascript:void(0);">Xem thêm</a></div>
    </div>
<?php } ?>
<?php if (isset($degrees) && count($degrees)) { ?>
    <div class="box-filter">
        <h2>Cấp bậc</h2>
        <div class="group-check-box">
            <?php foreach ($degrees as $degree_id => $degree) { ?>
                <div class="checkbox">
                    <input type="checkbox" class="ais-checkbox" value="<?php echo $degree_id ?>">
                    <label><span class="text-clip" title="<?php echo $degree['name'] ?>"><?php echo $degree['name'] ?></span></label>
                    <span class="facet-count pull-right"><?php echo number_format($degree['count_job'], 0, ',', '.'); ?></span>
                </div>
            <?php } ?>
        </div>
        <div class="view-more-list-job"><a href="javascript:void(0);">Xem thêm</a></div>
    </div>
<?php } ?>
<?php if (isset($typeofworks) && count($typeofworks)) { ?>
    <div class="box-filter">
        <h2>Loại hình</h2>
        <div class="group-check-box">
            <?php foreach ($typeofworks as $typeofwork_id => $typeofwork) { ?>
                <div class="checkbox">
                    <input type="checkbox" class="ais-checkbox" value="<?php echo $typeofwork_id ?>">
                    <label><span class="text-clip" title="<?php echo $typeofwork['name'] ?>"><?php echo $typeofwork['name'] ?></span></label>
                    <span class="facet-count pull-right"><?php echo number_format($typeofwork['count_job'], 0, ',', '.'); ?></span>
                </div>
            <?php } ?>
        </div>
        <div class="view-more-list-job"><a href="javascript:void(0);">Xem thêm</a></div>
    </div>
<?php } ?>
<div class="box-filter">
    <h2>MỨC LƯƠNG</h2>
    <div class="group-check-box">
        <div class="radio">
            <input type="radio" class="" name="jobSalary">
            <label><span class="text-clip" title="IT - Phần mềm">< 10 Triệu</span></label>
        </div>
        <div class="radio">
            <input type="radio" class="" name="jobSalary">
            <label><span class="text-clip" title="IT - Phần mềm">10 - 20 Triệu</span></label>
        </div>
        <div class="radio">
            <input type="radio" class="" name="jobSalary">
            <label><span class="text-clip" title="IT - Phần mềm">20 - 30 Triệu</span></label>
        </div>
        <div class="radio">
            <input type="radio" class="" name="jobSalary">
            <label><span class="text-clip" title="IT - Phần mềm">30 - 40 Triệu</span></label>
        </div>
        <div class="radio">
            <input type="radio" class="" name="jobSalary">
            <label><span class="text-clip" title="IT - Phần mềm">40 - 60 Triệu</span></label>
        </div>
        <div class="radio">
            <input type="radio" class="" name="jobSalary">
            <label><span class="text-clip" title="IT - Phần mềm">> 60 Triệu</span></label>
        </div>
    </div>
    <div class="view-more-list-job"><a href="javascript:void(0);">Xem thêm</a></div>
</div>