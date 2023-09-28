<?php 
$tg = $data['data'];
if(is_array($tg)) { ?>
    <h2>Tên miền <?= $domain ?> đã được sở hữu bởi:</h2>
    <ul class="info-whois">
        <?php if(isset($tg['Registrant Name']) && $tg['Registrant Name']) { ?>
            <li>
                <span class="title">
                    Chủ sở hữu: 
                </span>
                <span class="value">
                    <?= $tg['Registrant Name'] ?>
                </span>
            </li>
        <?php } ?>
        <?php if(isset($tg['Registrant Email']) && $tg['Registrant Email']) { ?>
            <li>
                <span class="title">
                    Email chủ sở hữu: 
                </span>
                <span class="value">
                    <?= $tg['Registrant Email'] ?>
                </span>
            </li>
        <?php } ?>
        <?php if(isset($tg['Registrant Phone']) && $tg['Registrant Phone']) { ?>
            <li>
                <span class="title">
                    Số Điện thoại chủ sở hữu: 
                </span>
                <span class="value">
                    <?= $tg['Registrant Phone'] ?>
                </span>
            </li>
        <?php } ?>
        <?php if(isset($tg['Registrant Name']) && $tg['Registrant Name']) { ?>
            <li>
                <span class="title">
                    Công ty: 
                </span>
                <span class="value">
                    <?= $tg['Registrant Organization'] ?>
                </span>
            </li>
        <?php } ?>
        <?php if(isset($tg['Registrar']) && $tg['Registrar']) { ?>
            <li>
                <span class="title">
                    Đại lý trung gian: 
                </span>
                <span class="value">
                    <?= $tg['Registrar'] ?>
                </span>
            </li>
        <?php } ?>
        <?php if(isset($tg['Registrar Abuse Contact Email']) && $tg['Registrar Abuse Contact Email']) { ?>
            <li>
                <span class="title">
                    Email địa lý: 
                </span>
                <span class="value">
                    <?= $tg['Registrar Abuse Contact Email'] ?>
                </span>
            </li>
        <?php } ?>
        <?php if(isset($tg['Registrar Abuse Contact Phone']) && $tg['Registrar Abuse Contact Phone']) { ?>
            <li>
                <span class="title">
                    Số điện thoại địa lý: 
                </span>
                <span class="value">
                    <?= $tg['Registrar Abuse Contact Phone'] ?>
                </span>
            </li>
        <?php } ?>
        <?php if(isset($tg['Creation Date'])) { ?>
            <li>
                <span class="title">
                    Ngày đăng ký: 
                </span>
                <span class="value">
                    <?= $tg['Creation Date'] ?>
                </span>
            </li>
        <?php } ?>
        <?php if(isset($tg['Registrar Registration Expiration Date'])) { ?>
            <li>
                <span class="title">
                    Ngày hết hạn: 
                </span>
                <span class="value">
                    <?= $tg['Registrar Registration Expiration Date'] ?>
                </span>
            </li>
        <?php } ?>
        <?php if(isset($tg['Name Server'])) { ?>
            <li>
                <span class="title">
                    Server name: 
                </span>
                <span class="value">
                    <?= is_array($tg['Name Server']) ? implode('<br/>', $tg['Name Server']) :  $tg['Name Server'] ?>
                </span>
            </li>
        <?php } ?>
    </ul>
    <h2>Thông tin đầy đủ:</h2>
    <div>
        <?= $data['message'] ?>
    </div>
<?php } else { ?>
    <h2>Tên miền <?= $domain ?> đã được sở hữu bởi:</h2>
    <?= $data['data'] ?>
<?php } ?>
<?php if($first) { ?>
    <script type="text/javascript">
        $('#waiting-load-add').html('<img src="<?= Yii::app()->homeUrl ?>images/ajax-loader.gif" />');
        loadAjaxAppend('<?= Yii::app()->createUrl('/domain/domain/getviewAdd'); ?>', {domain : '<?= $domain ?>', start : 0}, $('#box-view-add'));
    </script>
<?php } ?>
