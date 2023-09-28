<?php

class CourseController extends PublicController {

    public $layout = '//layouts/course';

    /**
     * course index
     */
    public function actionIndex() {
        $this->breadcrumbs = array(
            Yii::t('course', 'subject') => Yii::app()->createUrl('/economy/course/index')
        );
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
        // Get one lecturer
//        $rel_course_lecturer = RelCourseLecturer::model()->findByAttributes(array('course_id' => $id));
//        $lecturer = Lecturer::model()->findByPk($rel_course_lecturer->lecturer_id);
        // Get Many lecturer
        $rel_course_lecturers = RelCourseLecturer::model()->findAllByAttributes(array('course_id' => $id));

        if (isset($rel_course_lecturers) && count($rel_course_lecturers)) {
            $ids = array_map(function ($rel_course_lecturers) {
                return $rel_course_lecturers->lecturer_id;
            }, $rel_course_lecturers);
            $lecturers = Lecturer::model()->findAllByAttributes(array("id" => $ids));
        }
        if (!isset($lecturers)) {
            $lecturers = null;
        }
        if (isset($lecturers) && count($lecturers)) {
            $lecturer = $lecturers[0];
        }
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
            'lecturers' => $lecturers,
        ));
    }

    /**
     * Course category
     * @param type $id
     */
    public function actionCategory($id) {
        $this->layoutForAction = '//layouts/course_category';
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
        $pagesize = CourseHelper::helper()->getPageSize();
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $listcourse = Course::getCourseInCategory($id, array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = Course::countCourseInCate($id);
        //
        if ($category['image_path'] && $category['image_path']) {
            $this->addMetaTag(ClaUrl::getImageUrl($category['image_path'], $category['image_name'], array('width' => 1000, 'height' => 1000, 'full' => true)), 'og:image', null, array('property' => 'og:image'));
        }
        //
        $this->render('category', array(
            'listcourse' => $listcourse,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'category' => $category,
        ));
    }

    /**
     * Dùng cho site w3ni 328 . Show tất cả khóa học trong danh mục không phân trang
     * Course category
     * @param type $id
     */
    public function actionCategoryUnLimit($id) {

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
            $category->cat_name => Yii::app()->createUrl('/economy/course/categoryunlimit', array('id' => $category->cat_id, 'alias' => $category->alias)),
        );
        //
        $pagesize = Course::countCourseInCate($id);
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $totalitem = Course::countCourseInCate($id);
        $listcourse = Course::getCourseInCategory($id, array(
                    'limit' => $totalitem,
                    ClaSite::PAGE_VAR => $page,
        ));
        //
        //
        $this->render('category_unlimit', array(
            'listcourse' => $listcourse,
//            'limit' => $pagesize,
//            'totalitem' => $totalitem,
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
                //Email
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'courseregsuccess',
                ));
                if ($mailSetting) {
                    $data = array(
                        'link' => '<a href="' . Yii::app()->createAbsoluteUrl('quantri/economy/course/listRegister') . '">Link</a>',
                        'customer_name' => $model->name,
                        'customer_regis_date' => date('d/m/Y', $model->created_time),
                        'customer_email' => $model->email,
                        'customer_number' => $model->phone,
                        'course_name' => Course::getCourseDetail($model->course_id)['name'],
                        'customer_massage' => $model->message
                    );
                    //
                    $content = $mailSetting->getMailContent($data);
                    $subject = $mailSetting->getMailSubject($data);
                    //
                    if ($content && $subject) {
                        Yii::app()->mailer->send('', Yii::app()->siteinfo['admin_email'], $subject, $content);
                    }
                }
                Yii::app()->user->setFlash("success", 'Bạn đã đăng kí thành công.');
                $this->redirect($url_back);
            }
        }
    }

}

?>