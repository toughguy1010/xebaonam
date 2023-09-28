<?php

class ApiController extends PublicController {

    function actionIndex() {
        $this->jsonResponse(200);
    }

    function actionCreatesite() {
        //
        $site = new SiteSettings();
        $site->attributes = $_POST;
        $site->site_id = null;
        //
        if ($site->validate()) {
            if ($site->save(false)) {
                $domain = new Domains();
                $domain->domain_id = $site->domain_default;
                $domain->site_id = $site->site_id;
                $domain->user_id = $site->user_id;
                $domain->domain_default = Domains::DOMAIN_DEFAULT_YES;
                $domain->save(false);
                $this->jsonResponse(200, array(
                    'site_id' => $site->site_id,
                ));
            }
        } else {
            $this->jsonResponse(400, array(
                'errors' => $site->getJsonErrors(),
            ));
        }
    }

    /**
     * copy theme data, execute data.sql in theme
     */
    function actionCopythemedata() {
        $site_id = $_POST['site_id'];
        $user_id = ($_POST['user_id']) ? $_POST['user_id'] : 0;
        $theme_id = $_POST['theme_id'];
        $theme_id_copy = $_POST['theme_id_copy'];
        $datapath = $_POST['datapath'];
        if ($site_id && $datapath && file_exists($datapath)) {
            // insert default data for site
            $sql = '';
            $sql = trim(file_get_contents($datapath));
            $sql = str_replace(array('[site_id]', '[user_id]', '[now]'), array($site_id, $user_id, time()), $sql);
            if ($sql) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $respond = Yii::app()->db->createCommand($sql)->execute();
                    $transaction->commit();
                    if ($respond) {
                        $this->jsonResponse(200);
                    } else {
                        $this->jsonResponse(400, array('message' => 'SQL have a error'));
                    }
                } catch (Exception $e) {
                    $this->jsonResponse(400, array('message' => 'SQL have a error'));
                    $transaction->rollback();
                }
            }
        } else
            $this->jsonResponse(400);
    }

    /**
     * create url 
     */
    public function actionCreateurl() {
        $basepath = $_POST['basepath'];
        $params = isset($_POST['params']) ? json_decode($_POST['params'], true) : array();
        $absolute = isset($_POST['absolute']) ? $_POST['absolute'] : false;
        $url = '';
        if ($basepath) {
            if ($absolute)
                $url = Yii::app()->createAbsoluteUrl($basepath, $params);
            else
                $url = Yii::app()->createUrl($basepath, $params);

            $this->jsonResponse(200, array(
                'url' => $url,
            ));
        }
        //
        $this->jsonResponse(400);
    }

    /**
     * 
     * @param type $action
     * @return boolean
     */
    public function beforeAction($action) {
        $key = $_POST['key'];
        if (!ClaGenerate::decrypt($key))
            return false;
        return parent::beforeAction($action);
    }

}
