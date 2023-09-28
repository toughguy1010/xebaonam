<?php

class PostController extends PublicController {

    public $layout = '//layouts/post';

    /**
     * View follow category
     */
    public function actionCategory($id) {
        $category = PostCategories::model()->findByPk($id);
        if (!$category)
            $this->sendResponse(400);
        //
//        if(isset($category->layout_action) && $category->layout_action){
//            $this->layoutForAction = $category->layout_action;
//        }
        $this->layoutForAction = '//layouts/' . $category->layout_action;
        if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
            $this->layoutForAction = $this->layout;
        }

        $this->pageTitle = $this->metakeywords = $category->cat_name;
        $this->metadescriptions = $category->cat_description;
        if (isset($category->meta_keywords) && $category->meta_keywords)
            $this->metakeywords = $category->meta_keywords;
        if (isset($category->meta_description) && $category->meta_description)
            $this->metadescriptions = $category->meta_description;
        if (isset($category->meta_title) && $category->meta_title)
            $this->metaTitle = $category->meta_title;
        //
        $this->breadcrumbs = array(
            $category->cat_name => Yii::app()->createUrl('/content/post/category', array('id' => $category->cat_id, 'alias' => $category->alias)),
        );
        //       
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        $pagesize = Yii::app()->request->getParam(ClaSite::PAGE_SIZE_VAR);

        /*
         * Get custom pagesize
         * */
        $allowed_page_size =  explode(',',Yii::app()->siteinfo['allowed_page_size']);
        $pageSizeAry = (isset(Yii::app()->siteinfo['site_page_size'])) ? Yii::app()->siteinfo['site_page_size'] : array();
        if (!$pagesize && count($allowed_page_size) > 0 && count($pageSizeAry) > 0){
//            $pageSizeAry = ClaSite::getSitePageSizeInfo();
            $is_allowed = in_array(ClaSite::getLinkKey(),$allowed_page_size);
            if($is_allowed && isset($pageSizeAry[ClaSite::getLinkKey()]) && count($pageSizeAry[ClaSite::getLinkKey()]) > 0){
                $pagesize = $pageSizeAry[ClaSite::getLinkKey()];
            };
        }

        if (!$pagesize)
            $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        //
        $posts = Posts::getPostsInCategory($id, array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = Posts::countPostInCate($id);
        //
        $this->viewForAction = 'category';
         //
        if(isset($category->view_action) && $category->view_action){
            $this->viewForAction = $category->view_action;
        }

        //
        $this->render($this->viewForAction, array(
            'category' => $category,
            'posts' => $posts,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
        ));
    }

    /**
     * View post detail
     */
    public function actionDetail($id) {
        $post = Posts::getPostDetaial($id);
        if (!$post) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        //
        $this->pageTitle = $this->metakeywords = $post['title'];
        $this->metadescriptions = $post['sortdesc'];
        if (isset($post['meta_keywords']) && $post['meta_keywords'])
            $this->metakeywords = $post['meta_keywords'];
        if (isset($post['meta_description']) && $post['meta_description'])
            $this->metadescriptions = $post['meta_description'];
        if (isset($post['meta_title']) && $post['meta_title'])
            $this->metaTitle = $post['meta_title'];
        //
        $category = PostCategories::model()->findByPk($post['category_id']);
        $this->breadcrumbs = array(
            $category->cat_name => Yii::app()->createUrl('/content/post/category', array('id' => $category->cat_id, 'alias' => $category->alias)),
            $post['title'] => '',
        );

        $this->layoutForAction = '//layouts/' . $category->layout_action.'_detail';
        if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
            $this->layoutForAction = $this->layout;
        }

        $this->render('detail', array('post' => $post));
    }

    /**
     * @Hatv
     * get content post 
     * giavien
     */
    public function actionGetDetailAjax() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->request->getParam('id');
            $model = Posts::model()->findByPk($id);
            $lazyload_html_view = '//content/post/ajax_detail_html';
            if (($lazyFile = $this->getLayoutFile($lazyload_html_view)) === false) {
                $lazyload_html_view = 'ajax_detail_html';
            }
            if (count($model)) {
                $items = $this->renderPartial($lazyload_html_view, array(
                    'model' => $model,
                        ), true);
            }
            $this->jsonResponse(200, array(
                'items' => $items,
            ));
        }
    }

}
