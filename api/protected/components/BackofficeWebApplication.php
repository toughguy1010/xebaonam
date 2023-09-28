<?php

/**
 * Description of PublicWebApplication
 *
 * @author minhbn
 * @property array $siteinfo
 */
class BackofficeWebApplication extends WebApplication
{

    public $siteinfo = array();
    public $themeinfo = array();
    public $isDemo = false;
    public $ruleLanguage = array();
    public $changeLanguage = true;
    public $comment = true;
    //
    //put your code here
    protected function init()
    {
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
        }
        if (isset(Yii::app()->user->id) && (!ClaUser::isSupperAdmin() || !ClaUser::isNanoAdmin())) {
            ClaSite::checkDisable();
        }

        //
        $this->siteinfo = ClaSite::getSiteInfo();
        //
        if (!$this->siteinfo || !count($this->siteinfo)) {
            Yii::app()->end();
        }
        if ($this->siteinfo['site_title']) {
            $this->name = Yii::app()->siteinfo['site_title'];
        }
        $this->urlManager->addRules(ClaSite::getAdminSiteRules());
        //
        return parent::init();
    }

    //
    function createUrl($route, $params = array(), $ampersand = '&', $language = '')
    {
        if ($language) {
            $backLanguage = Yii::app()->language;
            $languages = ClaSite::getLanguagesForSite();
            if (isset($languages[$language])) {
                Yii::app()->language = $language;
                Yii::app()->urlManager->addRules(ClaSite::getAdminSiteRules(), false);
            } else {
                $language = '';
            }
        }
        $url = parent::createUrl($route, $params, $ampersand);
        if ($language) {
            Yii::app()->language = $backLanguage;
            Yii::app()->urlManager->addRules(ClaSite::getAdminSiteRules(), false);
        }
        $url = str_replace('/api','', $url);
        return $url;
    }
}
