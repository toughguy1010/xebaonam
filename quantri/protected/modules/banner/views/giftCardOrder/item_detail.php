<div class="widget-box">
    <div class="widget-header">
        <h4>
            Gift Certificates - Certificates
        </h4>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Certificate</th>
                        <th>Owner</th>
                        <th>Campaign</th>
                        <th>Value</th>
                        <th>Balance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?= strtoupper($model['id']) ?>
                            <br />
                            <span style="color: green">Expires: <?= date('Y-m-d', $order['expiration_date']) ?></span>
                        </td>
                        <td><?= $model['owner'] ?></td>
                        <td>
                            <?php
                            $campaign = GiftCardCampaign::model()->findByPk($order['campaign_id']);
                            echo $campaign->title;
                            ?>
                        </td>
                        <td><?= $model['total_price'] ?> USD</td>
                        <td>
                            <?= $model['balance'] ?> USD
                            <br />
                            <a href="<?php echo Yii::app()->createUrl('banner/giftCardOrder/trackBalance', array('id' => $model['id'])) ?>">Track balance</a>
                        </td>
                        <td>
                            <?php
                            $api = new ClaAPI();
                            $url_view = $api->createUrl(array(
                                'basepath' => '/media/giftCard/certificatePreview',
                                'params' => json_encode(array('id' => $model->id)),
                                'absolute' => 'true',
                            ));
                            ?>
                            <a target="_blank" href="<?php echo $url_view['url'] ?>">
                                <img src="<?php echo Yii::app()->getBaseUrl(true) ?>/css/images_giftcard/view.png" />
                            </a>
                            &nbsp;&nbsp;
                            <?php if (!$model->block) { ?>
                                <a onclick="return confirm('Are you sure Block this certificate?')" href="<?php echo Yii::app()->createUrl('/banner/giftCardOrder/blockCertificate', array('id' => $model->id)) ?>">
                                    <img src="<?php echo Yii::app()->getBaseUrl(true) ?>/css/images_giftcard/block.png" />
                                </a>
                            <?php } else { ?>
                                <a onclick="return confirm('Are you sure Unlock this certificate?')" href="<?php echo Yii::app()->createUrl('/banner/giftCardOrder/unlockCertificate', array('id' => $model->id)) ?>">
                                    <img src="<?php echo Yii::app()->getBaseUrl(true) ?>/css/images_giftcard/unlock.png" />
                                </a>
                            <?php } ?>
                            <!--                            &nbsp;&nbsp;
                                                        <a href="">
                                                            <img src="<?php echo Yii::app()->getBaseUrl(true) ?>/css/images_giftcard/edit.png" />
                                                        </a>-->

                            &nbsp;&nbsp;
                            <a onclick="return confirm('Are you sure Redeem this certificate?')" href="<?php echo Yii::app()->createUrl('/banner/giftCardOrder/redeemCertificate', array('id' => $model->id)) ?>">
                                <img src="<?php echo Yii::app()->getBaseUrl(true) ?>/css/images_giftcard/redeem.png" />
                            </a>

                            &nbsp;&nbsp;
                            <a onclick="return confirm('Are you sure Delete this certificate?')" href="<?php echo Yii::app()->createUrl('/banner/giftCardOrder/deleteCertificate', array('id' => $model->id)) ?>">
                                <img src="<?php echo Yii::app()->getBaseUrl(true) ?>/css/images_giftcard/delete.png" />
                            </a>

                            &nbsp;&nbsp;
                            <!--                            <a href="">
                                                            <img src="<?php echo Yii::app()->getBaseUrl(true) ?>/css/images_giftcard/show.png" />
                                                        </a>-->
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<br />
<br />
<br />
<div>
    <div>
        <p>
            <img src="<?php echo Yii::app()->getBaseUrl(true) ?>/css/images_giftcard/view.png" />
            Display certificate
        </p>
        <p>
            <img src="<?php echo Yii::app()->getBaseUrl(true) ?>/css/images_giftcard/block.png" />
            Block certificate
        </p>
        <p>
            <img src="<?php echo Yii::app()->getBaseUrl(true) ?>/css/images_giftcard/unlock.png" />
            Unlock certificate
        </p>
<!--        <p>
            <img src="<?php echo Yii::app()->getBaseUrl(true) ?>/css/images_giftcard/edit.png" />
            Edit certificate details
        </p>-->

        <p>
            <img src="<?php echo Yii::app()->getBaseUrl(true) ?>/css/images_giftcard/redeem.png" />
            Redeem certificate
        </p>

        <p>
            <img src="<?php echo Yii::app()->getBaseUrl(true) ?>/css/images_giftcard/delete.png" />
            Delete certificate
        </p>
<!--        <p>
            <img src="<?php echo Yii::app()->getBaseUrl(true) ?>/css/images_giftcard/show.png" />
            Display payment transactions
        </p>-->
    </div>
</div>