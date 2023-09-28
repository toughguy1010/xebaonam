<?php

/**
 * Kím kiếm theo khoảng sản phẩm
 */
class productpricerange extends WWidget {

    protected $range = array();
    protected $summaryText = '';
    protected $url = '';
    protected $selected = '';
    protected $linkAll = '';
    protected $name = 'productpricerange'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_productpricerange = new config_productpricerange('', array('page_widget_id' => $this->page_widget_id));
        if ($config_productpricerange->widget_title)
            $this->widget_title = $config_productpricerange->widget_title;
        if (isset($config_productpricerange->show_wiget_title))
            $this->show_widget_title = $config_productpricerange->show_wiget_title;
        if (isset($config_productpricerange->summaryText))
            $this->summaryText = $config_productpricerange->summaryText;
        //
        $priceFrom = Yii::app()->request->getParam(ClaSite::PAGE_PRICE_FROM);
        $priceTo = Yii::app()->request->getParam(ClaSite::PAGE_PRICE_TO);
        //
        $params = $_GET;
        if ($params) {
            unset($params[ClaSite::PAGE_PRICE_FROM]);
            unset($params[ClaSite::PAGE_PRICE_TO]);
        } else
            $params = array();
        //
        $route = Yii::app()->getController()->getRoute();
        if ($route == 'introduce/introduce/index')
            $route = 'economy/product/attributeSearch';
        //
        if (isset($config_productpricerange->range)) {
            $range = $config_productpricerange->range;
            $data = array();
            if ($range) {// Add by Hatv Fix error if $range null
                foreach ($range as $ra) {
                    $_temp = array();
                    $_temp[ClaSite::PAGE_PRICE_FROM] = isset($ra[0]) ? $ra[0] : '';
                    $_temp[ClaSite::PAGE_PRICE_TO] = isset($ra[1]) ? $ra[1] : '';
                    $_temp['link'] = Yii::app()->createUrl($route, $params + ClaArray::AddArrayToEnd($_temp));
                    $_temp['priceText'] = $ra['priceText'];
                    $_temp['active'] = ($priceFrom == $ra[0] && $priceTo == $ra[1]) ? true : false;
                    array_push($data, $_temp);
                }
            }
            $this->range = $data;
        }
        //
        $this->linkAll = Yii::app()->createUrl($route, $params);
        //
//        $themename = Yii::app()->theme->name;
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.' . $this->name . '.view';
//        if ($this->controller->getViewFile($viewname)) {
//            $this->view = $viewname;
//        }
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'range' => $this->range,
            'summaryText' => $this->summaryText,
            'selected' => $this->selected,
            'linkAll' => $this->linkAll,
            'url' => $this->url,
        ));
    }

}
