<?php

/**
 * lọc sản phẩm
 */
class productGearExplorer extends WWidget
{

    public $category_id = null;
    public $priceFilter = 1;
    public $highestPrice = 0;
    public $minPrice = 0;
    protected $name = 'productGearExplorer'; // name of widget
    protected $view = 'view'; // view of widget ajax,pjax    
    protected $baseUrl = 'economy/product/category';
    protected $params = array();
    protected $attributes = array(); // Thuộc tính cho phép lọc của danh mục
    protected $category = null; // Danh mục
    protected $basepath = ''; // 
    protected $formUrl = '';
    protected $assets = '';
    protected $aryListProvince = array();
    public $manufacturersOptions = array();

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
            $themename = Yii::app()->theme->name;
            $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
            $this->basepath = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.' . $this->name;
        }
        // Load config
        $config_productFilterInCat = new config_productFilterInCat('', array('page_widget_id' => $this->page_widget_id));
        if ($config_productFilterInCat->widget_title)
            $this->widget_title = $config_productFilterInCat->widget_title;
        if (isset($config_productFilterInCat->show_wiget_title))
            $this->show_widget_title = $config_productFilterInCat->show_wiget_title;
        if (isset($config_productFilterInCat->priceFilter))
            $this->priceFilter = $config_productFilterInCat->priceFilter;
        //
        //

        if (!$this->category_id) {
            if ($this->baseUrl == ClaSite::getLinkKey()) {
                $this->category_id = Yii::app()->request->getParam('id');
            }
        }

        Yii::import("application.modules.economy.helper.FilterHelper", true);
        $this->baseUrl = 'economy/product/attributeSearch';
        $options = array(
            'route' => Yii::app()->createUrl($this->baseUrl),
        );
        $attributes = FilterHelper::helper()->getAttributesSystemOptions($options);

        if (isset($attributes) && count($attributes)) {
            foreach ($attributes as $key => $att) {
                if ($att['att']->code != 'hoat-dong-cua-umove' && $att['att']->code != 'gioi-tinh-do-tuoi' &&  $att['frontend_input']->code =='frontend_input' ) {
                    unset($attributes[$key]);
                }
            }
        }
        $this->attributes = $attributes;


        $_params = $this->params = $_GET;
        //
        unset($_params['fi_pmin']);
        unset($_params['fi_pmax']);
        $this->formUrl = Yii::app()->createUrl($this->baseUrl, $_params);
        //
//        $this->registerClientScript();
        //Get Province

        $this->aryListProvince = WeatherLocation::getAllLocationArr();

        parent::init();
    }

    //
    public function run()
    {
        $this->render($this->view, array(
            'category' => $this->category,
            'attributes' => $this->attributes,
            'priceFilter' => $this->priceFilter,
            'baseUrl' => $this->baseUrl,
            'params' => $this->params,
            'formUrl' => $this->formUrl,
            'manufacturersOptions' => $this->manufacturersOptions,
            'highestPrice' => $this->highestPrice,
            'minPrice' => $this->minPrice,
            'aryListProvince' => $this->aryListProvince,
        ));
    }

    public function registerClientScript()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            if (!defined("PRODUCTFILTERINCATE_REGISTERSCRIPT")) {
                define("PRODUCTFILTERINCATE_REGISTERSCRIPT", true);
                $this->assets = $assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets');
                $client = Yii::app()->clientScript;
                //$js = $client->registerScriptFile($assets . '/' . $this->style . "/js/script.js", CClientScript::POS_END);
                $css = $client->registerCssFile($assets . "/css/style.css");
            }
        }
    }

}
