<div class="jobdetail">
    <h3 class="newstitle"><?php echo $job['position']; ?></h3>
    <p class="newstime"><?php echo Yii::t('work','job_createdate').': '.date('d/m/Y', $job['created_time']) ?></p>
    <table class="table">
        <tr class="active">
            <td colspan="4">
                <h4><?php echo Yii::t('work', 'work_info'); ?></h4>
            </td>
        </tr>
        <tr>
            <td class="td-job-position">
                <b>
                    <?php echo Yii::t('work', 'job_position'); ?>
                </b>
            </td>
            <td colspan="3">
                <div class="job-position"><?php echo $job['position']; ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <b><?php echo Yii::t('work', 'job_degree'); ?></b>
            </td>
            <td>
                <?php echo Jobs::getDegreeText($job); ?>
            </td>
            <td>
                <b><?php echo Yii::t('work', 'job_experience'); ?></b>
            </td>
            <td>
                <?php echo Jobs::getExperienceText($job); ?>
            </td>
        </tr>
        <tr>
            <td>
                <b><?php echo Yii::t('work', 'job_trade'); ?></b>
            </td>
            <td>
                <?php echo Jobs::getTradeText($job, array('trades' => $trades)); ?>
            </td>
            <td>
                <b><?php echo Yii::t('work', 'job_level'); ?></b>
            </td>
            <td>
                <?php echo Jobs::getLevelText($job); ?>
            </td>
        </tr>
        <tr>
            <td>
                <b><?php echo Yii::t('work', 'job_typeofwork'); ?></b>
            </td>
            <td>
                <?php echo Jobs::getTypeOfJobText($job); ?>
            </td>
            <td>
                <b><?php echo Yii::t('work', 'job_location'); ?></b>
            </td>
            <td>
                <?php echo Jobs::getLocationText($job, array('provinces' => $provinces)); ?>
            </td>
        </tr>
        <tr>
            <td>
                <b><?php echo Yii::t('work', 'job_salaryrange'); ?></b>
            </td>
            <td>
                <?php echo Jobs::getSalaryText($job); ?>
            </td>
            <td>
                <b><?php echo Yii::t('work', 'job_quantity'); ?></b>
            </td>
            <td>
                <?php echo $job['quantity']; ?>
            </td>
        </tr>
        <tr>
            <td>
                <b>
                    <?php echo Yii::t('work', 'job_description'); ?>
                </b>
            </td>
            <td colspan="3">
                <?php echo $job['description']; ?>
            </td>
        </tr>
        <?php if ($job['requirement']) { ?>
            <tr>
                <td>
                    <b>
                        <?php echo Yii::t('work', 'job_requirement'); ?>
                    </b>
                </td>
                <td colspan="3">
                    <?php echo $job['requirement']; ?>
                </td>
            </tr>
        <?php } ?>
        <?php if ($job['benefit']) { ?>
            <tr>
                <td>
                    <b>
                        <?php echo Yii::t('work', 'job_benefit'); ?>
                    </b>
                </td>
                <td colspan="3">
                    <?php echo $job['benefit']; ?>
                </td>
            </tr>
        <?php } ?>
        <?php if ($job['includes']) { ?>
            <tr>
                <td>
                    <b>
                        <?php echo Yii::t('work', 'job_includes'); ?>
                    </b>
                </td>
                <td colspan="3">
                    <?php echo $job['includes']; ?>
                </td>
            </tr>
        <?php } ?>
        <?php if ($job['expirydate'] > 0) { ?>
            <tr>
                <td>
                    <b>
                        <?php echo Yii::t('work', 'job_expirydate'); ?>
                    </b>
                </td>
                <td colspan="3">
                    <?php echo date('d-m-Y', $job['expirydate']); ?>
                </td>
            </tr>
        <?php } ?>
        <tr class="active">
            <td colspan="4">
                <h4><?php echo Yii::t('work', 'work_contact'); ?></h4>
            </td>
        </tr>
        <tr>
            <td>
                <b>
                    <?php echo Yii::t('work', 'job_contact_username'); ?>
                </b>
            </td>
            <td colspan="3">
                <?php echo $job['contact_username']; ?>
            </td>
        </tr>
        <?php if ($job['contact_email']) { ?>
            <tr>
                <td>
                    <b>
                        <?php echo Yii::t('work', 'job_contact_email'); ?>
                    </b>
                </td>
                <td colspan="3">
                    <?php echo $job['contact_email']; ?>
                </td>
            </tr>
        <?php } ?>
        <?php if ($job['contact_phone']) { ?>
            <tr>
                <td>
                    <b>
                        <?php echo Yii::t('work', 'job_contact_phone'); ?>
                    </b>
                </td>
                <td colspan="3">
                    <?php echo $job['contact_phone']; ?>
                </td>
            </tr>
        <?php } ?>
        <?php if ($job['contact_address']) { ?>
            <tr>
                <td>
                    <b>
                        <?php echo Yii::t('work', 'job_contact_address'); ?>
                    </b>
                </td>
                <td colspan="3">
                    <?php echo $job['contact_address']; ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
