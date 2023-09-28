<?php

class RealestateProjectController extends PublicController
{

    public $layout = '//layouts/real_estate_project';

    /**
     * real estate index
     */
    public function actionIndex()
    {
        //
        $this->layoutForAction = '//layouts/real_estate_index';
        //
        $this->breadcrumbs = array(
            Yii::t('product', 'product') => Yii::app()->createUrl('/economy/product'),
        );
        $this->render('index');
    }

    public function actionList()
    {
        $this->layoutForAction = '//layouts/real_estate_list';
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_manager') => Yii::app()->createUrl('/news/realestateProject/list'),
        );
        $user_id = Yii::app()->user->id;
        $this->render('list_project', array(
            'user_id' => $user_id
        ));
    }

    /**
     * trang chi tiết bất động sản
     */
    public function actionDetail($id)
    {
        // Layout
        $this->layoutForAction = '//layouts/real_estate_detail';
        // Load project vs Info
        $real_estate = RealEstateProject::model()->findByPk($id);
        $project_info = RealEstateProjectInfo::model()->findByPk($id);
        // Load Relation News
        $news_in_cate = News::getNewsInCategory($real_estate['news_category_id'], array('limit' => 10));
        // Load Video Relation - Default get 10
        $videos = RealEstateVideoRelation::getVideoInRel($id);
        if (!$real_estate) {
            $this->sendResponse(404);
        }
        if ($real_estate->site_id != $this->site_id) {
            $this->sendResponse(404);
        }

//        $this->pageTitle = $this->metakeywords = $project_info->project_name;
        if (isset($project_info->meta_keywords) && $project_info->meta_keywords) {
            $this->metakeywords = $project_info->meta_keywords;
        }
        if (isset($project_info->meta_description) && $project_info->meta_description) {
            $this->metadescriptions = $project_info->meta_description;
        }
        if (isset($project_info->meta_title) && $project_info->meta_title) {
            $this->metaTitle = $project_info->meta_title;
        }

//        $project = array();
//        if ($real_estate->project_id) {
//            $project = RealEstateProject::model()->findByPk($real_estate->project_id);
//        }

        $this->pageTitle = $this->metakeywords = $real_estate->name;
        $this->metadescriptions = $real_estate->sort_description;

        if ($real_estate['image_path'] && $real_estate['image_name']) {
            $this->addMetaTag(ClaHost::getImageHost() . $real_estate['image_path'] . 's1000_1000/' . $real_estate['image_name'], 'og:image', null, array('property' => 'og:image'));
        }

        $user = Users::getCurrentUser();

        $this->addMetaTag('article', 'og:type', null, array('property' => 'og:type'));
        //
        $this->breadcrumbs = array(
            $real_estate->name => Yii::app()->createUrl('/news/realestateProject/detail', array(
                'id' => $real_estate->id,
                'alias' => $real_estate->alias)),
            $real_estate['name'] => '',
        );

        //
        $this->render('detail', array(
            'model' => $real_estate,
            'user' => $user,
            'project_info' => $project_info,
            'news_in_cate' => $news_in_cate,
            'videos' => $videos,
        ));
    }

    /**
     * Đăng ký học
     */
    public function actionRegister()
    {

        $model = new RealEstateProjectRegister();
        $model->unsetAttributes();
        $url_back = isset($_POST['url_back']) ? $_POST['url_back'] : '';

        if (isset($_POST['RealEstateProjectRegister'])) {

            $model->attributes = $_POST['RealEstateProjectRegister'];

            if ($model->save()) {
                //Email
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'realestateRegSuccess',
                ));
                if ($mailSetting) {
                    $data = array(
                        'link' => '<a href="' . Yii::app()->createAbsoluteUrl('quantri/economy/course/listRegister') . '">Link</a>',
                        'customer_name' => $model->name,
                        'customer_regis_date' => date('d/m/Y', $model->created_time),
                        'customer_email' => $model->email,
                        'customer_number' => $model->phone,
                        'course_name' => RealEstateProject::getProjectDetail($model->project_id)['name'],
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
                $this->redirect($url_back);
            }else{
                $this->redirect($url_back);
            }
        }
    }

    /**
     * @param $id
     */
    public function actionCategory($id) {
        $category = RealEstateCategories::model()->findByPk($id);
        if (!$category) {
            $this->sendResponse(404);
        }
        $this->breadcrumbs = array(
            $category['cat_name'] => Yii::app()->createUrl('/news/realestateProject/category', array('id' => $category['cat_id'], 'alias' => $category['alias'])),
        );
        //
        $this->pageTitle = $this->metakeywords = $category->cat_name;
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
        $pagesize = Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //

        $realestateProject = RealEstateProject::getRealestateProjectInCategory($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = RealEstateProject::getRealestateProjectInCategory($id,array(),true);
        //
        $this->render('category', array(
            'list_realestateProject' => $realestateProject,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'category' => $category,
        ));
    }
}
