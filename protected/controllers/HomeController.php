<?php

/**
 * Description of HomeController
 *
 * @author bachminh
 */
class HomeController extends PublicController {

    public function actionIndex() {
        $siteinfo = ClaSite::getSiteInfo();
        switch ($siteinfo['site_type']) {
            case 1: {
                    $this->redirect(Yii::app()->createUrl('/news/news'));
                }break;
        }
    }

    /**
     * Lưu lại truy cập của user
     */
    public function actionUseraccess() {
        $userAccess = new ClaUserAccess();
        $userAccess->checkAccess();
        echo Yii::app()->language;
        exit();
    }

     function actionPush() {
        //$url = isset($_POST['endPoint']) ? $_POST['endPoint'] : 'https://fcm.googleapis.com/fcm/send';
        $url = 'https://onesignal.com/api/v1/notifications';
        $message = Yii::app()->request->getParam('message','Nanoweb demo notification');
        $id = 'fd46986b-ba24-4cba-80fc-d6e2c0b632c8';
        $key = 'NTAzMmMwZjEtNjIyYi00ZTEyLTkzYTMtMGFmN2QxMjllMzhj';
        $fields = array(
            'filters' => array(
                array(
                    'field' => 'last_session',
                    'relation' => '<',
                    'hours_ago' => '1.1',
                ),
            ),
            'app_id' => '00975106-d3b7-4d1e-859f-6f68b37de929',
            'headings' => array(
                "en" => 'Nanoweb',
            ),
            'url' => 'http://nanoweb.vn',
            'subtitle' => array(
                "en" => 'test',
            ),
            'contents' => array(
                "en" => $message,
            ),
        );
        $fields = json_encode($fields);
        $headers = array(
            'Authorization: Basic ' . $key,
            'Content-Type: application/json;charset=UTF-8'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);
        Yii::app()->end();
    }
    
}
