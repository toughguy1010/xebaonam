<?php

class ratingcommentsproductform extends WWidget
{

    public $data = array();
    public $link = '';
    public $limit = 5;
    public $assets = '';
    protected $view = 'view'; // view of widget
    protected $name = 'ratingcommentsproductform';
    protected $product_id = '';
    protected $grouprating = '';
    protected $comment = array();
    protected $linkkey = 'economy/product/detail';
    protected $action = '';
    public $model = '';

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $ratingcommentprd = new config_ratingcommentsproductform('', array('page_widget_id' => $this->page_widget_id));

        if ($ratingcommentprd) {
            $this->widget_title = $ratingcommentprd->widget_title;
        }
        if (!$this->link)
            $this->link = ClaSite::getFullCurrentUrl();
        // set name for widget, default is class name
        if ($this->linkkey == ClaSite::getLinkKey()) {
            $this->product_id = Yii::app()->request->getParam('id');
            $this->action = Yii::app()->createUrl('economy/product/addrating', array(id => $this->product_id));
        }
        if ($this->product_id) {
            $product = Product::model()->findByPk($this->product_id);
            if ($product) {
                $this->model = new ProductRating;
                $this->grouprating = ProductRating::getAllCommentRatingScore($this->product_id);
            }
        }
        $this->registerClientScript();
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
    }

    public function run()
    {
        $this->render($this->view, array(
            'model' => $this->model,
            'link' => $this->link,
            'action' => $this->action,
            'product_id' => $this->product_id,
        ));
    }

    public function registerClientScript()
    {
        $this->assets = $assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets');
        $client = Yii::app()->clientScript;
        $client->registerScriptFile($assets . "/js/jquery.rateyo.min.js", CClientScript::POS_END);
        $client->registerCssFile($assets . "/css/jquery.rateyo.min.css");
    }

}
