<?php

/**
 * get course in the category
 */
class courseIncategory extends WWidget
{
    public $course;
    public $limit = 10;
    public $cat_id = 0;
    public $course_hot = 0;
    public $course_in_cate = 0;
    public $category = null;
    public $child_category = null;
    protected $name = 'courseIncategory'; // name of widget
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
        $config_courseIncategory = new config_courseIncategory('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_courseIncategory->limit)) {
            $this->limit = (int)$config_courseIncategory->limit;
        }
        if ($config_courseIncategory->widget_title) {
            $this->widget_title = $config_courseIncategory->widget_title;
        }
        if (isset($config_courseIncategory->show_wiget_title)) {
            $this->show_widget_title = $config_courseIncategory->show_wiget_title;
        }
        if (isset($config_courseIncategory->cat_id)) {
            $this->cat_id = $config_courseIncategory->cat_id;
        }
        // Get All infomation
        if (isset($config_courseIncategory->full)) {
            $this->full = $config_courseIncategory->full;
        }
        // Get course hot
        if (isset($config_courseIncategory->course_hot)) {
            $this->course_hot = $config_courseIncategory->course_hot;
        }
        // Get child cat course
        if (isset($config_courseIncategory->course_in_cate)) {
            $this->course_in_cate = $config_courseIncategory->course_in_cate;
        }

        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));

        if ($viewname != '') {
            $this->view = $viewname;
        }
        // get hot course
        $this->course = Course::getCourseInCategory($this->cat_id, array('limit' => $this->limit, 'onlyisHot' => $this->course_hot));
        $this->category = CourseCategories::model()->findByPk($this->cat_id);
        // Get cat course their course
        if ($this->course_in_cate == 1) {
            $claCategory = new ClaCategory(array('create' => true, 'type' => 'course'));
            $claCategory->application = false;
            $cat_child = $claCategory->getSubCategory($this->category->cat_id);
            if (count($cat_child)) {
                foreach ($cat_child as $cat) {
                    $this->data[$cat['cat_id']] = $cat;
                    $new_in_cate = Course::getCourseInCategory($cat['cat_id'], array('limit' => $this->limit, 'course_in_cate' => $this->course_in_cate));
                    $this->data[$cat['cat_id']]['course'] = $new_in_cate;
                }
            }
        }
        //
        $this->category = $this->category->attributes;
        $this->category['link'] = '';
        if ($this->category)
            $this->category['link'] = Yii::app()->createUrl('/economy/course/category', array('id' => $this->category['cat_id'], 'alias' => $this->category['alias']));

        parent::init();
    }

    public
    function run()
    {
        if ($this->course_in_cate == 1) {
            $this->render($this->view, array(
                'course' => $this->course,
                'category' => $this->category,
                'data' => $this->data
            ));
        } else {
            $this->render($this->view, array(
                'course' => $this->course,
                'category' => $this->category,
            ));
        }
    }
}
