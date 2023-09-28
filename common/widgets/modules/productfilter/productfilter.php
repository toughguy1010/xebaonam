<?php

class productfilter extends WWidget {

    public $a;
    protected $name = 'productfilter'; // name of widget
    protected $view = 'ajax'; // view of widget ajax,pjax    

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
//        $themename = Yii::app()->theme->name;
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.' . $this->name . '.'.$this->view;
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
        $cat_id = Yii::app()->request->getParam('id', 0);
        $category = $category = ProductCategories::model()->findByPk($cat_id);
        //$vmax = ProductHelper::helper()->getMaxFielddAttribute(1,2);
        if ($category && $category->attribute_set_id) {
            $attributes = FilterHelper::helper()->getAttributesOptions($category->attribute_set_id);
            $this->render($this->view, array(
                'category' => $category,
                'attributes' => $attributes,
            ));
        }
    }

}
