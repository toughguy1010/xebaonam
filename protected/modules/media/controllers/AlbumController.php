<?php

/**
 * @author minhbn <minhcoltech@gmail.com>
 * Album controller
 */
class AlbumController extends PublicController {

    public $layout = '//layouts/album';

    /**
     * Lists all models.
     */
    public function actionAll() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('album', 'album') => Yii::app()->createUrl('/media/album/all'),
        );
        //
        $seo = SiteSeo::getSeoByKey(SiteSeo::KEY_ALBUM);
        if (isset($seo->meta_keywords) && $seo->meta_keywords) {
            $this->metakeywords = $seo->meta_keywords;
        }
        if (isset($seo->meta_description) && $seo->meta_description) {
            $this->metadescriptions = $seo->meta_description;
        }
        if (isset($seo->meta_title) && $seo->meta_title) {
            $this->metaTitle = $seo->meta_title;
        }
        //
        $this->pageTitle = Yii::t('album', 'album');
        //
        $pagesize = MediaHelper::helper()->getPageSize();
        $page = MediaHelper::helper()->getCurrentPage();
        //
        $totalitem = Albums::countAllAlbum();
        //
        $albums = Albums::getAllAlbum(array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
        ));
        //
        $this->render('all', array(
            'albums' => $albums,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
        ));
    }

    /**
     * hiển thị chi tiết ảnh trong album
     */
    public function actionDetail($id) {
        //
        $album = $this->loadModel($id);
        if ($album->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }

        //
        $this->pageTitle = $album->album_name;
        $this->metakeywords = $album->album_name;
        $this->metadescriptions = $album->album_description;
        if (isset($album->meta_keywords) && $album->meta_keywords) {
            $this->metakeywords = $album->meta_keywords;
        }
        if (isset($album->meta_description) && $album->meta_description) {
            $this->metadescriptions = $album->meta_description;
        }
        $cat = array();
        if ($album->cat_id) {
            $cat = AlbumsCategories::model()->findByPk($album->cat_id);
        }
        //
        //breadcrumbs
        if (count($cat)) {
            $this->breadcrumbs = array(
                Yii::t('album', 'album') => Yii::app()->createUrl('/media/album/all'),
                $cat->cat_name => Yii::app()->createUrl('/media/album/category', array('id' => $cat->cat_id, 'alias' => $cat->alias)),
                $album->album_name => Yii::app()->createUrl('/media/album/detail', array('id' => $id, 'alias' => $album->alias)),
            );
        } else {
            $this->breadcrumbs = array(
                Yii::t('album', 'album') => Yii::app()->createUrl('/media/album/all'),
                $album->album_name => Yii::app()->createUrl('/media/album/detail', array('id' => $id, 'alias' => $album->alias)),
            );
        }
        //
        $pagesize = isset($album['pagesize']) ? $album['pagesize'] : 9999;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $images = Albums::getImages($id, array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
        ));
        $totalitem = Albums::countImages($id);
        //
        $this->render('detail', array(
            'album' => $album,
            'images' => $images,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Albums the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Albums::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Albums $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'albums-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * View follow category
     */
    public function actionCategory($id) {
        $category = AlbumsCategories::model()->findByPk($id);

        if (!$category) {
            $this->sendResponse(404);
        }
        //
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
            $category->cat_name => Yii::app()->createUrl('/media/album/category', array('id' => $category->cat_id, 'alias' => $category->alias)),
        );
        //
        $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $list_album = Albums::getAlbumsInCategory($id, array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
        ));
        //

        $totalitem = Albums::countAlbumsInCate($id);

        //

        $claCategory = new ClaCategory(array('create' => true, 'type' => ClaCategory::CATEGORY_ALBUMS));
        $claCategory->application = 'frontend';

        $children_category = $claCategory->getSubCategory($id);

        $this->render('category', array(
            'list_album' => $list_album,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'category' => $category,
            'children_category' => $children_category,
        ));
    }

}
