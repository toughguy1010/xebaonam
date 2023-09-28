<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class PublicController extends Controller {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/main';
    public $layoutForAction = ''; // Layout for each action
    public $viewForAction = ''; // view for each action

    /**
     * defaul class for content
     */
    public $classCssContent = 'contain-gird-big';

    /**
     * những widget của page đó
     * @var type
     */
    public $WidgetsFromPage = null;

    /**
     * default controller
     * @var type
     */
    public function init() {
        //pageTitle
        if (Yii::app()->siteinfo['site_title'])
            $this->pageTitle = Yii::app()->siteinfo['site_title'];
        //Meta keyword
        if (Yii::app()->siteinfo['meta_keywords'])
            $this->metakeywords = Yii::app()->siteinfo['meta_keywords'];
        //Meta description
        if (Yii::app()->siteinfo['meta_description'])
            $this->metadescriptions = Yii::app()->siteinfo['meta_description'];
        // Meta description
        if (isset(Yii::app()->siteinfo['meta_title']) && Yii::app()->siteinfo['meta_title']) {
            $this->metaTitle = Yii::app()->siteinfo['meta_title'];
        }
        // Access Statistic
        parent::init();
    }

    protected function beforeRender($view) {
        // favicon
        if (Yii::app()->siteinfo['favicon'])
            Yii::app()->clientScript->registerLinkTag('shortcut icon', null, Yii::app()->siteinfo['favicon'], null);
        // Meta keyword
        if ($this->metakeywords != '') {
            Yii::app()->clientScript->registerMetaTag($this->metakeywords, 'keywords', null, array('name' => 'keywords'));
        }
        // Meta description
        if ($this->metadescriptions != '') {
            Yii::app()->clientScript->registerMetaTag($this->metadescriptions, 'description', null, array('name' => 'description'));
        }
        // Meta description
        if ($this->metaTitle != '') {
            //Yii::app()->clientScript->registerMetaTag($this->metaTitle, null, null, array('name' => 'title'));
            $this->pageTitle = $this->metaTitle;
        }
        // Meta Canotical
        if (!$this->linkCanonical) {
            $this->linkCanonical = ClaSite::getFullCurrentUrl();
        }
//        if ($category['avatar_path'] && $category['avatar_name']) {
//            $this->addMetaTag(ClaHost::getImageHost() . $category['avatar_path'] . 's1000_1000/' . $category['avatar_name'], 'og:image', null, array('property' => 'og:image'));
//        }
        // google analytics
        $googleanalytics = trim(Yii::app()->siteinfo['google_analytics']);
        if ($googleanalytics != '') {
            Yii::app()->clientScript->setHeadString($googleanalytics);
        }
        // hiển thị các thẻ script trước thẻ đóng body
        $post_end_script = trim(Yii::app()->siteinfo['post_end_script']);
        if (isset($post_end_script) && $post_end_script != '') {
            Yii::app()->clientScript->setBodyEndScript($post_end_script);
        }
        // prevent Bing Bot
        // $bingMeta = '<meta name="bingbot" content="noindex,nofollow" />' . "\n" . '<meta name="msnbot" content="noindex,nofollow" />' . "\n";
        // Yii::app()->clientScript->setHeadString($bingMeta);
        // Them ga cho site demo
        if (Yii::app()->isDemo) {
            $demoGA = "<script>
              (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
              (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
              m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
              })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

              ga('create', 'UA-9881028-7', 'auto');
              ga('send', 'pageview');

            </script>";
            //
            Yii::app()->clientScript->setHeadString($demoGA);
        }
        // Nếu trang hiện tại là link trang chủ thì chuyển layout của nó về là home
        if (ClaSite::getLinkKey() == ClaSite::getHomeKey(Yii::app()->siteinfo)) {
            //Nếu chưa có layout home thì giữ nguyên layout hiện tại
            if ($this->getLayoutFile('//layouts/home'))
                $this->layout = '//layouts/home';
        }
        //
        if ($this->layout != '//layouts/home') {
            if ($this->layoutForAction && $this->getLayoutFile($this->layoutForAction))
                $this->layout = $this->layoutForAction;
            elseif (($layoutFile = $this->getLayoutFile($this->layout)) === false)
                $this->layout = '//layouts/main';
        }
        //
        return parent::beforeRender($view);
    }

    //
    public function render($view, $data = null, $return = false) {
        if ($this->beforeRender($view)) {
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/web3nhat.min.js?v=' . VERSION, CClientScript::POS_END);
            /**
             * *****************************************************************************************************************************************
             * check SSO
             */
            if (ClaSite::isSSO()) {
                if (Yii::app()->user->isGuest && $this->site_id != ClaSite::getRootSiteId()) {
                    $checkSess = Yii::app()->session[ClaSSO::browse_session_name];
                    //$checkSess = false;
                    if (!$checkSess) {
                        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/sso.js?v=' . VERSION, CClientScript::POS_END);
                        Yii::app()->clientScript->registerScript('sso', "brokerGetAttach='" . Yii::app()->createUrl('sso/broker/getattach', array(ClaSSO::param_current_url_name => ClaSSO::urlEncode(ClaSite::getCurrentUrl()))) . "';", CClientScript::POS_HEAD);
                        Yii::app()->session[ClaSSO::browse_session_name] = 1;
                    }
                }
            }
            // ******************************************************************************************************************************************
            if (Yii::app()->siteinfo['load_main_css']) {
                Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/main.min.css?v=' . VERSION);
            }
            $output = $this->renderPartial($view, $data, true);
            $output.= $this->widget('common.widgets.managerwidget.managerwidget', array(), true);
            $output.= $this->widget('common.widgets.statistic.statistic', array(), true);
            // widget nhận thông báo
            $output.= $this->widget('Flashes', array(), true);
            if(isset(Yii::app()->siteinfo['enable_snow']) && Yii::app()->siteinfo['enable_snow']){
                $output.= $this->widget('snow', array(), true);
            }
            // if (Yii::app()->siteinfo['show_adsnano']) {
            // $output.= $this->widget('Adsnano', array(), true);
            // }
            // add custom style to out put
            if (Yii::app()->siteinfo['stylecustom']) {
                $output = '<style type="text/css">' . Yii::app()->siteinfo['stylecustom'] . "</style>" . $output;
            }
            //
            //
            if (($layoutFile = $this->getLayoutFile($this->layout)) !== false)
                $output = $this->renderFile($layoutFile, array('content' => $output), true);
            //
            $this->afterRender($view, $output);
            //
            $output = $this->processOutput($output);
            // Cache page
            if (ClaSite::isCachePage()) {
                if (!ClaSite::ShowModule() && !ClaSite::getAdminSession()) {
                    $set = Yii::app()->cache->set($this->getPageCacheKey(), $output);
                }
            }
            if ($return)
                return $output;
            else
                echo $output;
        }
    }

    //
    function beforeAction($action) {
        /**
         * Vao trang chu neu dc set mot url trong phan quan ly menu nao day thi redirect den url do
         */
        if (ClaSite::isHomeUrl()) {
            // cho http://lieutruongphong.vn
            if(!Yii::app()->request->isAjaxRequest && Yii::app()->language && Yii::app()->language != ClaSite::getDefaultLanguage() && ClaSite::isMultiLanguage() && $this->site_id==1492){
                $url = Yii::app()->homeUrl.'?'.ClaSite::LANGUAGE_KEY.'='.Yii::app()->language;
                if (ClaSite::getCurrentUrl() != $url) {
                    Yii::app()->request->redirect($url);
                }
            }
            $siteinfo = Yii::app()->siteinfo;
            if (isset($siteinfo['default_page_path']) && $siteinfo['default_page_path'] != '' && isset($siteinfo['default_page_params'])) {
                $url = Yii::app()->createAbsoluteUrl($siteinfo['default_page_path'], json_decode($siteinfo['default_page_params'], true));
                if (ClaSite::getFullCurrentUrl() != $url) {
                    Yii::app()->request->redirect($url);
                }
            }
        }
        // Load from
        $fr = Yii::app()->request->getParam('fr', '');
        if (isset($fr) && $fr) {
            $_SESSION['fr'] = $fr;
        }
        // load page from cache
        if (ClaSite::isCachePage()) {
            $pageHtml = Yii::app()->cache->get($this->getPageCacheKey());
            if ($pageHtml) {
                echo $pageHtml;
                Yii::app()->end();
            }
        }
        //
        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.js' => false,
            );
        }
        if (!Yii::app()->request->isAjaxRequest) {
            // Lấy tất cả các widget trong page này
            $this->WidgetsFromPage = Widgets::getWidgetsFromPage();
        }
        return parent::beforeAction($action);
    }

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CaptchaAction',
                'backColor' => 0xEEEEEE,
                'maxLength' => 3,
            ),
        );
    }

    public function getPageCacheKey() {
        $site_id = $this->site_id;
        $isMobile = ClaSite::isMobile();
        $currentUrl = ClaSite::getCurrentUrl();
        $language = Yii::app()->language;
        $key = base64_encode($site_id . ':' . $language . ':' . $currentUrl . ':' . $isMobile);
        return $key;
    }

//
//    public function filters() {
//        return array(
//            array(
//                'common.extensions.html.ECompressHtmlFilter',
//                'gzip' => false,
//                'doStripNewlines' => true,
//                'actions' => '*'
//            ),
//        );
//    }
}
