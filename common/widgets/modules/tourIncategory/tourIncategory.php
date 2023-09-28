<?php

/**
 * get tour in the category
 */
class tourIncategory extends WWidget
{
    public $tours;
    public $limit = 10;
    public $cat_id = 0;
    public $full = 0;
    public $tour_hot = 0;
    public $tour_in_cate = 0;
    public $category = null;
    public $child_category = null;
    protected $name = 'tourIncategory'; // name of widget
    protected $view = 'view'; // view of widget
    public $data = array(); //

    public function init()
    {
//        return array();
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_tourIncategory = new config_tourIncategory('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_tourIncategory->limit)) {
            $this->limit = (int)$config_tourIncategory->limit;
        }
        if ($config_tourIncategory->widget_title) {
            $this->widget_title = $config_tourIncategory->widget_title;
        }
        if (isset($config_tourIncategory->show_wiget_title)) {
            $this->show_widget_title = $config_tourIncategory->show_wiget_title;
        }
        if (isset($config_tourIncategory->cat_id)) {
            $this->cat_id = $config_tourIncategory->cat_id;
        }
        // Get All infomation
        if (isset($config_tourIncategory->full)) {
            $this->full = $config_tourIncategory->full;
        }
        // Get tour hot
        if (isset($config_tourIncategory->tour_hot)) {
            $this->tour_hot = $config_tourIncategory->tour_hot;
        }
        // Get child cat tour
        if (isset($config_tourIncategory->tour_in_cate)) {
            $this->tour_in_cate = $config_tourIncategory->tour_in_cate;
        }

        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        // get hot tour
        $this->tours = Tour::getTourInCategory($this->cat_id, array('limit' => $this->limit, 'full' => $this->full, 'tour_hot' => $this->tour_hot));

        $this->category = TourCategories::model()->findByPk($this->cat_id);
        // Get cat tour their tour
        if ($this->tour_in_cate == 1) {
            $claCategory = new ClaCategory(array('create' => true, 'type' => 'tour'));
            $claCategory->application = false;
            $cat_child = $claCategory->getSubCategory($this->category->cat_id);
            if (count($cat_child)) {
                foreach ($cat_child as $cat) {
                    $this->data[$cat['cat_id']] = $cat;
                    $new_in_cate = Tour::gettourInCategory($cat['cat_id'], array('limit' => $this->limit, 'tour_in_cate' => $this->tour_in_cate));
                    $this->data[$cat['cat_id']]['tour'] = $new_in_cate;
                }
            }
        }
        //
        $this->category = $this->category->attributes;
        $this->category['link'] = '';
        $this->category['link_list'] = '';
        if ($this->category) {
            $this->category['link'] = Yii::app()->createUrl('/tour/tour/category', array('id' => $this->category['cat_id'], 'alias' => $this->category['alias']));
            $this->category['link_list'] = Yii::app()->createUrl('/tour/tour/categoryList', array('id' => $this->category['cat_id'], 'alias' => $this->category['alias']));
        }
//            $this->$child_category = ClaCategory;
        parent::init();
    }

    public
    function run()
    {
        if ($this->tour_in_cate == 1) {
            $this->render($this->view, array(
                'tours' => $this->tours,
                'category' => $this->category,
                'data' => $this->data
            ));
        } else {
            $this->render($this->view, array(
                'tours' => $this->tours,
                'category' => $this->category,
            ));
        }
    }
}
