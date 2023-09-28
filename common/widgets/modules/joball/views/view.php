<?php
if (isset($jobs) && $jobs) {
    ?>
    <div class="col-lg-9 col-sm-7 col-md-8 col-xs-12 box-hot-job">
        <div class="bg-white pad-15">
            <h2>38 việc làm hot</h2>
            <div class="table-job">
                <table class="rwd-table">
                    <tr class="header-title">
                        <th><h3>Vị trí đang tuyển</h3></th>
                        <th width="120"><h3>Mức lương</h3></th>
                        <th width="120"><h3>Số lượng</h3> </th>
                        <th><h3>Nơi làm việc</h3></th>
                    </tr>
                    <?php foreach ($jobs as $job) { ?>
                        <tr>
                            <td data-th="Vị trí đang tuyển">
                                <?php if ($job['ishot']) { ?>
                                    <span class="label-hot">HOT</span>
                                <?php } ?>
                                <a class="name-job" href=""><?php echo $job['position'] ?></a>
                            </td>
                            <?php
                            $salary_text = Jobs::getSalaryText($job);
                            ?>
                            <td data-th="Mức lương"><?php echo $salary_text ?></td>
                            <td data-th="Số lượng"><?php echo $job['quantity'] ?> người</td>
                            <?php
                            $locations = explode(',', $job['location']);
                            $location_text = Jobs::getListLocationText($locations, array('provinces' => $provinces));
                            ?>
                            <td class="boder-btn" data-th="Nơi làm việc">
                                <?php echo $location_text ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
                <div class="view-more-job">
                    <a href="">
                        Xem thêm việc làm <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>