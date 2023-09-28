<div class="container">
    <div class="news-detail pad-70-0">
        <div class="form-bao-gia">
            <div class="form">

                <div class="col-xs-12 text-center" style="padding-bottom: 40px">
                    <h2 style="text-transform: uppercase">Đăng kí báo giá BPO thành công</h2>
                </div>
                <div class="row-5">
                    <div style="text-align: center">
                        <p>Dưới đây là các thông tin bạn đăng kí</p>
                    </div>
                </div>
            </div>

            <div id="inbaogia">
                <h2 class="tittle">Thông tin yêu cầu</h2>
                <div class="info">
                    <table style="width: 500px;margin: auto;margin-bottom: 10px">
                        <tr>
                            <td><?= Yii::t('translate', 'name') ?></td>
                            <td><?= $model->name ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('translate', 'phone') ?></td>
                            <td><?= $model->phone ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('translate', 'email') ?></td>
                            <td><?= $model->email ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('translate', 'country') ?></td>
                            <td><?= ClaLanguage::getCountryName($model->country) ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('translate', 'service') ?></td>
                            <td><?= $model->service ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('translate', 'currency') ?></td>
                            <td><?= $model->currency ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('translate', 'payment_method') ?></td>
                            <td><?= Orders::getPaymentMethod()[$model->payment_method] ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('translate', 'note') ?></td>
                            <td><span><?= $model->note ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div style="text-align: center">
                <p><?= Yii::t('translate', 'notice_sucsess') ?></p>
            </div>
            <!--Hatv-->
            <div class="button">

            </div>
        </div>
    </div>
</div>
<style>
    table {
        margin-bottom: 20px;
    }

    table tr td:first-child {
        font-weight: bold;
    }

    #inbaogia .tittle {
        text-transform: uppercase;
        text-align: center;
        margin-top: 20px;
        margin-bottom: 20px;
    }
</style>
