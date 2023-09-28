<style type="text/css">
    .page-content{
        background: #f7f5f5;
    }
    .box-cv-member{
        width: 100%;
        float: left;
    }
    .cv-pdf{
        width: 80%;
        background: #fff;
        padding: 30px;
        margin: 0 auto;
        font-family: times new roman,times,serif;
        font-size: 16px;
        box-shadow: 3px 3px 3px #ddd;
    }
    .header-cv{
        float: left;
        width: 100%;
        margin-bottom: 15px;
    }
    .name-member{
        float: left;
    }
    .img-member{
        float: right;
    }
    .img-member img{
        height: 180px;
    }
    .name-member h2{
        font-size: 35px;
        font-family: times new roman,times,serif;
        text-transform: uppercase;
        font-weight: 600;
        margin: 15px 0px;
    }
    .name-member h3{
        font-weight: 600;
        font-size: 20px;
    }
    .position-apply{
        margin-top: 40px;
    }
    .position-apply p{
        font-weight: 600;
        font-size: 18px;
        float: left;
        width: 100%;
        margin-bottom: 5px;
    }
    .position-apply span{
        font-weight: 600;
        font-size: 18px;
        float: left;
        width: 100%;
        color: #0a2049;
    }
    .content-cv tr{
        border: 1px solid #ddd;
        padding: 5px;
    }
    .content-cv tr td{
        padding: 10px 8px !important;
        font-family: times new roman,times,serif;
        font-size: 16px;
    }
    .bor-right{
        border-right: 1px solid #ddd;
        text-align: center;
        vertical-align: middle !important;
    }
    .content-cv h4{
        font-size: 19px;
        font-family: times new roman,times,serif;
        text-transform: uppercase;
        font-weight: 600;
    }
    .content-cv p{
        font-size: 17px;
    }
    .dowload-pdf{
        margin-top: 10px;
        text-align: right;
    }
    .dowload-pdf img{
        margin-top: -5px;
        margin-right: 6px;
    }
    .dowload-pdf a{
        padding: 10px 15px;
        border: 1px solid #ddd;
    }
    .dowload-pdf a:hover{
        background: #ebebeb;
    }
    @media screen and (max-width : 992px) {
        .cv-pdf{
            width: 90%;
            background: #fff;
            padding: 30px;
            margin: 0 auto;
            font-family: times new roman,times,serif;
            font-size: 16px;
            box-shadow: 3px 3px 3px #ddd;
        }
    }
    @media screen and (max-width : 767px) {
        .cv-pdf{
            width: 99%;
            background: #fff;
            padding: 30px;
            margin: 0 auto;
            font-family: times new roman,times,serif;
            font-size: 16px;
            box-shadow: 3px 3px 3px #ddd;
        }
    }
</style>
<div class="cv-pdf">
    <div class="header-cv">
        <div class="name-member">
            <h2>Sơ yếu lý lịch</h2>
            <h3>[<?php echo $model->name ?>]</h3>
            <div class="position-apply">
                <p>Ứng tuyển: </p>
                <span><?php echo $job->position ?></span>
            </div>
        </div>
        <div class="img-member">
            <a href="javascript:void(0)">
                <img src="<?php echo ClaHost::getImageHost(), $model->avatar_path, $model->avatar_name ?>" />
            </a>
        </div>
    </div>
    <div class="content-cv">
        <table class="table">
            <tbody>
                <tr class="active center">
                    <td colspan="4">
                        <h4>Thông tin cá nhân</h4>
                    </td>
                </tr>
                <tr>
                    <td width="120" class="bor-right td-job-position"><b>Họ tên</b></td>
                    <td colspan="3"><?php echo $model->name ?></td>
                </tr>
                <tr>
                    <td class="bor-right"><b>Ngày sinh</b></td>
                    <td colspan="3"><?php echo $model->birthday ?></td>
                </tr>
                <tr>
                    <td class="bor-right"><b>Email</b></td>
                    <td colspan="3"><a href=""><?php echo $model->email ?></a></td>
                </tr>
                <tr>
                    <td class="bor-right"><b>Số điện thoại</b></td>
                    <td colspan="3"><?php echo $model->hotline ?></td>
                </tr>
                <tr>
                    <td class="bor-right"><b>Địa chỉ</b></td>
                    <td colspan="3"><?php echo $model->address ?></td>
                </tr>
                <tr>
                    <td class="bor-right"><b>Quê quán</b></td>
                    <td colspan="3">Viet nam</td>
                </tr>
                <tr class="active center">
                    <td colspan="4">
                        <h4>Sơ lược</h4>
                    </td>
                </tr>
                <tr>
                    <td class="bor-right"><b>Lý do ứng tuyển</b></td>
                    <td colspan="3">
                        <p>
                            <span style="font-size:16px;">
                                <span style="font-family:times new roman,times,serif;">
                                    <?php echo $model->reason_apply ?>
                                </span>
                            </span>
                        </p>
                    </td>
                </tr>
                <tr class="active center">
                    <td colspan="4">
                        <h4>Học vấn</h4>
                    </td>
                </tr>
                <?php
                $knowledge = JobApply::getKnowledgeHistory($model->id);
                if ($knowledge) {
                    foreach ($knowledge as $item) {
                        $arr = array();
                        if ($item['qualification_type']) {
                            $arr[] = 'Hệ: ' . $item['qualification_type'];
                        }
                        if ($item['qualification_type']) {
                            $arr[] = 'Ngành: ' . $item['major'];
                        }
                        if ($item['school']) {
                            $arr[] = 'Trường: ' . $item['school'];
                        }
                        $school = implode(' - ', $arr);
                        ?>
                        <tr>
                            <td class="bor-right"><b>Trường</b></td>
                            <td colspan="3"><?php echo $school ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td class="bor-right"><b>Chứng chỉ khác</b></td>
                    <td colspan="3"><?php echo $model->certificate ?></td>
                </tr>
                <?php
                $history = JobApply::getWorkHistory($model->id);
                if (isset($history) && $history) {
                    ?>
                    <tr class="active center">
                        <td colspan="4">
                            <h4>Kinh nghiệm làm việc</h4>
                        </td>
                    </tr>
                    <?php foreach ($history as $his) { ?>
                        <tr>
                            <td class="bor-right"><b><?php echo $his['time_work'] ?></b></td>
                            <td colspan="3">
                                <p>
                                    <span style="font-size:16px;">
                                        <span style="font-family:times new roman,times,serif;">
                                            – Công ty: <?php echo $his['company'] ?> <br>
                                            – Chức vụ: <?php echo $his['degree'] ?><br>
                                            - Lý do nghỉ việc: <?php echo $his['reason_offwork'] ?><br>
                                        </span>
                                    </span>
                                </p>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <!--    <div class="dowload-pdf">
            <a href=""><img src="images/pdf_icon.gif"> Tải hồ sơ dạng pdf</a>
        </div>-->
</div>
