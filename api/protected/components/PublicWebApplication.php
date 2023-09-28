<?php

/**
 * Description of PublicWebApplication
 *
 * @author minhbn
 * @property array $siteinfo
 */
class PublicWebApplication extends WebApplication
{

    public $siteinfo = array();
    public $isDemo = false;
    public $isMobile;

    //put your code here
    protected function init()
    {
        if (ClaSite::isBot()) {
            die('Hi');
        }
        $this->setId('public');
        // change db
        if (ClaSite::isDemoDomain()) {
            $this->db->setActive(false);
            $this->db->connectionString = $this->dbdemo->connectionString;
            $this->db->username = $this->dbdemo->username;
            $this->db->password = $this->dbdemo->password;
            $this->db->setActive(true);
            $this->isDemo = true;
            //
            Yii::app()->cache->keyPrefix = 'demo';
            // prevent index in demo
            $bingMeta = '<meta name="robots" content="noindex,nofollow" />' . "\n" . '<meta name="googlebot" content="noindex,nofollow" />' . "\n";
            Yii::app()->clientScript->setHeadString($bingMeta);
            if (ClaSite::isGoogleBot()) {
                die('Hi');
            }
        }
        $this->siteinfo = ClaSite::getSiteInfo();
        //
        if (!$this->siteinfo || !count($this->siteinfo)) {
            die(Yii::t('common', 'pagenotfound'));
        }
        if (!isset($this->siteinfo['site_id'])) {
            die(Yii::t('common', 'pagenotfound'));
        }
        // disable site
        ClaSite::checkDisable();
        $this->name = Yii::app()->siteinfo['site_title'];
        $this->defaultController = ClaSite::getDefaultController($this->siteinfo);
        // check current url and redirect to setting url
        // Redirects::redirect301();
        // Load theme
        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
        //Set theme path
        Yii::app()->themeManager->setBasePath(Yii::getPathOfAlias('root') . '/themes/' . $sitetypename);
        //Set theme baseUrl
        Yii::app()->themeManager->setBaseUrl(Yii::app()->baseUrl . '/themes/' . $sitetypename);
        //Set theme name
        Yii::app()->theme = Yii::app()->siteinfo['site_skin'];
        //
        $this->isMobile = ClaSite::isMobile();
        //
        if ($this->isMobile) {
            if (is_dir(Yii::getPathOfAlias('root') . '/themes/' . $sitetypename . '/' . Yii::app()->siteinfo['site_skin'] . '/' . ClaSite::MOBILE_ALIAS))
                Yii::app()->theme = Yii::app()->siteinfo['site_skin'] . '/' . ClaSite::MOBILE_ALIAS;
            else {
                if (isset(Yii::app()->siteinfo['mobile_skin_default']) && Yii::app()->siteinfo['mobile_skin_default'] && is_dir(Yii::getPathOfAlias('root') . '/themes/' . ClaSite::MOBILE_DEFAULT_FOLDER . '/' . Yii::app()->siteinfo['mobile_skin_default'])) {
                    //Set theme path
                    Yii::app()->themeManager->setBasePath(Yii::getPathOfAlias('root') . '/themes/' . ClaSite::MOBILE_DEFAULT_FOLDER);
                    //Set theme baseUrl
                    Yii::app()->themeManager->setBaseUrl(Yii::app()->baseUrl . '/themes/' . ClaSite::MOBILE_DEFAULT_FOLDER);
                    //Set theme name
                    Yii::app()->theme = Yii::app()->siteinfo['mobile_skin_default'];
                } else
                    $this->isMobile = null; // Nếu không có theme cho mobile thì lấy theme ban đầu và controller ban đầu
            }
        }
        // load url rules

        $this->urlManager->addRules(ClaSite::getPublicSiteRules());

        //auto create url
        // $temp = '@' . str_replace('.html', '', $_SERVER['REQUEST_URI']);
        // $temp = str_replace('@/', '',  $temp);
        // if (isset($GLOBALS['__data_configs']['urls'][$temp])) {
        //     $view =  new PublicController('news');
        //     $view->_url = $GLOBALS['__data_configs']['urls'][$temp];
        //     $view->_mlayout = V3Layout::model()->findByAttributes(['site_id' => $this->siteinfo['site_id'], 'url' => $view->_url]);
        //     if ($view->_mlayout) {
        //         $GLOBALS['__V3_LAYOUT_ID'] = $view->_mlayout->v3_layout_id;
        //         $view->beforeAction('detail');
        //         $view->renderV3();
        //         Yii::app()->end();
        //     }
        // }
        return parent::init();
    }

    /**
     *
     * @param type $route
     * @param type $params
     * @param type $ampersand
     * @return type
     * nếu là tiếng anh, nhật,... thì thêm biến lang cho params
     */
    public function createUrl($route, $params = array(), $ampersand = '&') {
        if ($this->language && $this->language != ClaSite::getDefaultLanguage() && $route && $route != '/' && $route != $this->defaultController && ClaSite::isMultiLanguage()) {
            $params = $params + array(ClaSite::LANGUAGE_KEY => $this->language);
        }
        return $this->getUrlManager()->createUrl($route, $params, $ampersand);
    }

    public function createAbsoluteUrl($route, $params = array(), $schema = '', $ampersand = '&') {
        if ($this->language && $this->language != ClaSite::getDefaultLanguage() && $route && $route != '/' && $route != $this->defaultController && ClaSite::isMultiLanguage()) {
            $params = $params + array(ClaSite::LANGUAGE_KEY => $this->language);
        }
        //
        $url = $this->createUrl($route, $params, $ampersand);
        if (strpos($url, 'http') === 0)
            return $url;
        else
            return $this->getRequest()->getHostInfo($schema) . $url;
    }

    function getUserIP()
    {
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];
        $ip = '';
        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }

        return $ip;
    }
}
