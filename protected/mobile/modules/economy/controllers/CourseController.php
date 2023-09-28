<?php

class CourseController extends PublicController {

    public $layout = '//layouts/course';
    
    
    /**
     * course index
     */
    public function actionIndex() {
        
        $this->render('index');
    }

    /**
     * View course detail
     */
    public function actionDetail($id) {
        $course = Course::getCourseDetail($id);
        if (!$course || $course['status'] == ActiveRecord::STATUS_DEACTIVED) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        if ($course['site_id'] != $this->site_id) {
            $this->sendResponse(404);
        }

        $courseInfo = CourseInfo::model()->findByPk($id);
        $rel_course_lecturer = RelCourseLecturer::model()->findByAttributes(array('course_id' => $id));
        $lecturer = Lecturer::model()->findByPk($rel_course_lecturer->lecturer_id);
        //
        $this->pageTitle = $this->metakeywords = $course['name'];
        $this->metadescriptions = $course['sort_description'];
        if (isset($courseInfo['meta_keywords']) && $courseInfo['meta_keywords']) {
            $this->metakeywords = $courseInfo['meta_keywords'];
        }
        if (isset($courseInfo['meta_description']) && $courseInfo['meta_description']) {
            $this->metadescriptions = $courseInfo['meta_description'];
        }
        if (isset($courseInfo['meta_title']) && $courseInfo['meta_title']) {
            $this->metaTitle = $courseInfo['meta_title'];
        }
        if ($course['image_path'] && $course['image_name']) {
            $this->addMetaTag(ClaHost::getImageHost() . $course['image_path'] . 's1000_1000/' . $course['image_name'], 'og:image', null, array('property' => 'og:image'));
        }
        $this->addMetaTag('article', 'og:type', null, array('property' => 'og:type'));
        //
        $category = CourseCategories::model()->findByPk($course['cat_id']);
        $this->breadcrumbs = array(
            $category->cat_name => Yii::app()->createUrl('/economy/course/category', array('id' => $category->cat_id, 'alias' => $category->alias)),
        );

        $this->render('detail', array(
            'course' => $course,
            'courseInfo' => $courseInfo,
            'lecturer' => $lecturer,
        ));
    }

    /**
     * Course category
     * @param type $id
     */
    public function actionCategory($id) {

        $category = CourseCategories::model()->findByPk($id);
        if (!$category) {
            $this->sendResponse(404);
        }
        //
        $this->pageTitle = $this->metakeywords = $category->cat_name;
        $this->metadescriptions = $category->cat_description;
        if (isset($category->meta_keywords) && $category->meta_keywords) {
            $this->metakeywords = $category->meta_keywords;
        }
        if (isset($category->meta_description) && $category->meta_description) {
            $this->metadescriptions = $category->meta_description;
        }
        if (isset($category->meta_title) && $category->meta_title) {
            $this->metaTitle = $category->meta_title;
        }
        //
        $this->breadcrumbs = array(
            $category->cat_name => Yii::app()->createUrl('/economy/course/category', array('id' => $category->cat_id, 'alias' => $category->alias)),
        );
        //
        $pagesize = Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $listcourse = Course::getCourseInCategory($id, array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = Course::countCourseInCate($id);
        //
        $this->render('category', array(
            'listcourse' => $listcourse,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'category' => $category,
        ));
    }

    /**
     * Đăng ký học
     */
    public function actionRegister() {

        $model = new CourseRegister();
        $model->unsetAttributes();
        $url_back = $_POST['url_back'];

        if (isset($_POST['CourseRegister'])) {
            
            $model->attributes = $_POST['CourseRegister'];
            
            if ($model->save()) {
                $this->redirect($url_back);
            }
            
        }
    }

}

?>