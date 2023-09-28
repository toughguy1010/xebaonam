<?php

/**
 * Import for http://tptravel.com.vn
 */
class ImporttravelController extends PublicController {

    /**
     * import tour
     */
    function actionTour() {
        set_time_limit(0);
        $oldTours = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('dntour'))
                ->order('id')
                ->limit(1)
                ->offset(0)
                ->queryAll();
        if ($oldTours) {
            //
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_TOUR;
            $category->generateCategory();
            //
            foreach ($oldTours as $oldTour) {
                $model = new Tour;
                $model->unsetAttributes();
                $model->site_id = $this->site_id;
                $model->isnew = Tour::STATUS_ACTIVED;
                $model->position = Tour::POSITION_DEFAULT;
                $model->status = Tour::STATUS_ACTIVED;
                //
                $tourInfo = new TourInfo;
                $tourInfo->site_id = $this->site_id;
                //
                $model->name = trim($oldTour['name']);
                if ($model->name) {
                    $model->alias = HtmlFormat::parseToAlias($model->name);
                }
                $model->price = floatval($oldTour['price']);
                if ($model->price) {
                    $model->price_market = ($oldTour['saleoffPrice']) ? ($model->price + $oldTour['saleoffPrice']) : $model->price * 1.1;
                }
                $model->code = trim($oldTour['code']);
                $model->tour_category_id = $this->getCategoryMap($oldTour['typeTourId']);
                //
                if ($model->tour_category_id) {
                    $categoryTrack = array_reverse($category->saveTrack($model->tour_category_id));
                    $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
                    $model->category_track = $categoryTrack;
                }
                //
                // Diem khoi hanh
                $model->departure_at = trim($oldTour['departureName']);
                // Diem den
                $model->destination = trim($oldTour['destinationName']);
                //
                $model->time = $oldTour['dayDuration'] . ' ngày' . (($oldTour['nightDuration']) ? ' ' . $oldTour['nightDuration'] . ' đêm' : '');
                // tour info
                $tourInfo->price_include = $oldTour['details'];
                $tourInfo->schedule = $oldTour['program'];
                $tourInfo->policy = $oldTour['note'];
                $tourInfo->meta_title = $tourInfo->meta_keywords = trim($model->name);
                $tourInfo->meta_description = $oldTour['description'];
                //
                if ($model->save()) {
                    $tourInfo->tour_id = $model->id;
                    $tourInfo->save();
                    $avatar = ($oldTour['image']) ? 'http://tptravel.com.vn/data/media/1850' . (str_replace('../', '/', $oldTour['image'])) : '';
                    if ($avatar) {
                        $up = new UploadLib();
                        $up->setPath(array($this->site_id, 'tours', (int) date('m')));
                        $up->getFile(array('link' => $avatar, 'filetype' => UploadLib::UPLOAD_IMAGE));
                        $response = $up->getResponse(true);
                        if ($up->getStatus() == '200') {
                            $listImages = array(['path' => $response['baseUrl'], 'name' => $response['name']]);
                            $avatarName = '';
                            $imagePath = '';
                            $avatarID = 0;
                            $i = 0;
                            foreach ($listImages as $image) {
                                if ($i == 0) {
                                    $avatarName = $image['name'];
                                    $imagePath = $image['path'];
                                }
                                $nimg = new TourImages;
                                $nimg->tour_id = $model->id;
                                $nimg->name = $nimg->display_name = trim($image['name']);
                                $nimg->path = $image['path'];
                                $nimg->alias = HtmlFormat::parseToAlias($image['name']);
                                $nimg->site_id = $this->site_id;
                                if ($nimg->save()) {
                                    if ($i == 0) {
                                        $avatarID = $nimg->img_id;
                                    }
                                } else {
                                    var_dump($nimg->getErrors());
                                }
                                $i++;
                            }
                            if ($avatarName) {
                                $model->avatar_path = $imagePath;
                                $model->avatar_name = $avatarName;
                                $model->avatar_id = $avatarID;
                            }
                            $model->save();
                        }
                    }
                    // redirect 301
                    $domain = 'http://tptravel.com.vn';
                    $link1 = '/tour/' . $model['alias'] . '-' . $oldTour['id'] . '.html';
                    if (isset($link1) && trim($link1)) {
                        $redirect = new Redirects();
                        $redirect->scenario = 'create';
                        $redirect->from_url = trim(str_replace($domain, '', $link1));
                        $redirect->to_url = $domain . Yii::app()->createUrl('tour/tour/detail', array('id' => $model->id, 'alias' => $model['alias']));
                        $redirect->save();
                    }
                    //var_dump($oldTour);
                } else {
                    var_dump($model->getErrors());
                }
            }
        }
        echo 'Done';
        die('Ok');
    }

    function getCategoryMap($category_id = 0) {
        $arrMap = $this->getCategoryMapArr();
        $map_id = 0;
        if (isset($arrMap[$category_id])) {
            $map_id = $arrMap[$category_id];
        }
        return $map_id;
    }

    function getCategoryMapArr() {
        return array(
            1 => 184,
            2 => 186,
            3 => 190,
            4 => 185,
            5 => 188,
            6 => 189,
            7 => 191,
            8 => 223,
            9 => 187,
            10 => 222,
            11 => 224,
            12 => 221,
        );
    }

    /**
     * import news
     */
    function actionNews() {
        die('454');
        set_time_limit(0);
        $oldNewss = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('dnnews'))
                ->where('isDeleted<>1')
                ->order('id')
                ->limit(50)
                ->offset(100)
                ->queryAll();
        if ($oldNewss) {
            //
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_NEWS;
            $category->generateCategory();
            //
            foreach ($oldNewss as $oldNews) {
                $model = new News;
                $model->unsetAttributes();
                $model->site_id = $this->site_id;
                $model->status = Tour::STATUS_ACTIVED;
                //
                $model->news_title = trim($oldNews['name']);
                $model->news_category_id = $this->getNewsCategoryMap($oldNews['catId']);
                $model->news_sortdesc = trim($oldNews['description']);
                $model->news_desc = $oldNews['details'];
                $model->meta_keywords = $model->news_title;
                $model->meta_title = $oldNews['titleseo'];
                $model->meta_description = $oldNews['descseo'];
                //
                if ($model->news_category_id) {
                    $categoryTrack = array_reverse($category->saveTrack($model->news_category_id));
                    $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
                    $model->category_track = $categoryTrack;
                }
                if (!(int) $model->news_category_id)
                    $model->news_category_id = null;
                if ($model->publicdate && $model->publicdate != '' && (int) strtotime($model->publicdate))
                    $model->publicdate = (int) strtotime($model->publicdate);
                else
                    $model->publicdate = time();
                //
                if ($model->save()) {
                    $avatar = ($oldNews['icon']) ? 'http://tptravel.com.vn' . (str_replace('../', '/', $oldNews['icon'])) : '';
                    if ($avatar) {
                        $up = new UploadLib();
                        $up->setPath(array($this->site_id, 'news', (int) date('m')));
                        $up->getFile(array('link' => $avatar, 'filetype' => UploadLib::UPLOAD_IMAGE));
                        $response = $up->getResponse(true);
                        if ($up->getStatus() == '200') {
                            $listImages = array(['path' => $response['baseUrl'], 'name' => $response['name']]);
                            $avatarName = '';
                            $imagePath = '';
                            $avatarID = 0;
                            $i = 0;
                            foreach ($listImages as $image) {
                                if ($i == 0) {
                                    $avatarName = $image['name'];
                                    $imagePath = $image['path'];
                                }
                                $nimg = new NewsImages;
                                $nimg->id = $model->news_id;
                                $nimg->name = $nimg->display_name = trim($image['name']);
                                $nimg->path = $image['path'];
                                $nimg->alias = HtmlFormat::parseToAlias($image['name']);
                                $nimg->site_id = $this->site_id;
                                if ($nimg->save()) {
                                    if ($i == 0) {
                                        $avatarID = $nimg->img_id;
                                    }
                                } else {
                                    var_dump($nimg->getErrors());
                                }
                                $i++;
                            }
                            if ($avatarName) {
                                $model->image_path = $imagePath;
                                $model->image_name = $avatarName;
                            }
                            $model->save();
                        }
                    }
                    // redirect 301
                    $domain = 'http://tptravel.com.vn';
                    $link1 = '/tin-tuc/' . $model['alias'] . '-' . $oldNews['id'] . '.html';
                    if (isset($link1) && trim($link1)) {
                        $redirect = new Redirects();
                        $redirect->scenario = 'create';
                        $redirect->from_url = trim(str_replace($domain, '', $link1));
                        $redirect->to_url = $domain . Yii::app()->createUrl('news/news/detail', array('id' => $model->news_id, 'alias' => $model['alias']));
                        $redirect->save();
                    }
                    //var_dump($oldNews);
                } else {
                    var_dump($model->getErrors());
                }
            }
        }
        echo 'Done';
        die('Ok');
    }

    /**
     * import gioi thiệu
     */
    function actionAbout() {
        die('789');
        set_time_limit(0);
        $oldNewss = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('dnabout'))
                ->where('isDeleted<>1')
                ->order('id')
                ->limit(50)
                ->offset(0)
                ->queryAll();
        if ($oldNewss) {
            //
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_NEWS;
            $category->generateCategory();
            //
            foreach ($oldNewss as $oldNews) {
                $model = new News;
                $model->unsetAttributes();
                $model->site_id = $this->site_id;
                $model->status = Tour::STATUS_ACTIVED;
                //
                $model->news_title = trim($oldNews['name']);
                $model->news_category_id = 11389;
                $model->news_sortdesc = trim($oldNews['description']);
                $model->news_desc = $oldNews['details'];
                $model->meta_keywords = $model->news_title;
                $model->meta_title = $oldNews['titleseo'];
                $model->meta_description = $oldNews['descseo'];
                //
                if ($model->news_category_id) {
                    $categoryTrack = array_reverse($category->saveTrack($model->news_category_id));
                    $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
                    $model->category_track = $categoryTrack;
                }
                if (!(int) $model->news_category_id)
                    $model->news_category_id = null;
                if ($model->publicdate && $model->publicdate != '' && (int) strtotime($model->publicdate))
                    $model->publicdate = (int) strtotime($model->publicdate);
                else
                    $model->publicdate = time() + (int) $oldNews['id'];
                //
                if ($model->save()) {
                    $avatar = ($oldNews['icon']) ? 'http://tptravel.com.vn/data/media/1850' . (str_replace('../', '/', $oldNews['icon'])) : '';
                    if ($avatar) {
                        $up = new UploadLib();
                        $up->setPath(array($this->site_id, 'news', (int) date('m')));
                        $up->getFile(array('link' => $avatar, 'filetype' => UploadLib::UPLOAD_IMAGE));
                        $response = $up->getResponse(true);
                        if ($up->getStatus() == '200') {
                            $listImages = array(['path' => $response['baseUrl'], 'name' => $response['name']]);
                            $avatarName = '';
                            $imagePath = '';
                            $avatarID = 0;
                            $i = 0;
                            foreach ($listImages as $image) {
                                if ($i == 0) {
                                    $avatarName = $image['name'];
                                    $imagePath = $image['path'];
                                }
                                $nimg = new NewsImages;
                                $nimg->id = $model->news_id;
                                $nimg->name = $nimg->display_name = trim($image['name']);
                                $nimg->path = $image['path'];
                                $nimg->alias = HtmlFormat::parseToAlias($image['name']);
                                $nimg->site_id = $this->site_id;
                                if ($nimg->save()) {
                                    if ($i == 0) {
                                        $avatarID = $nimg->img_id;
                                    }
                                } else {
                                    var_dump($nimg->getErrors());
                                }
                                $i++;
                            }
                            if ($avatarName) {
                                $model->image_path = $imagePath;
                                $model->image_name = $avatarName;
                            }
                            $model->save();
                        }
                    }
                    // redirect 301
                    $domain = 'http://tptravel.com.vn';
                    $link1 = '/gioi-thieu/' . $model['alias'] . '-' . $oldNews['id'] . '.html';
                    if (isset($link1) && trim($link1)) {
                        $redirect = new Redirects();
                        $redirect->scenario = 'create';
                        $redirect->from_url = trim(str_replace($domain, '', $link1));
                        $redirect->to_url = $domain . Yii::app()->createUrl('news/news/detail', array('id' => $model->news_id, 'alias' => $model['alias']));
                        $redirect->save();
                    }
                    //var_dump($oldNews);
                } else {
                    var_dump($model->getErrors());
                }
            }
        }
        echo 'Done';
        die('Ok');
    }

    /**
     * import news
     */
    function actionService() {
        die('dich vu');
        set_time_limit(0);
        $oldNewss = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('dnservice'))
                ->where('isDeleted<>1')
                ->order('id')
                ->limit(100)
                ->offset(1)
                ->queryAll();
        if ($oldNewss) {
            //
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_NEWS;
            $category->generateCategory();
            //
            foreach ($oldNewss as $oldNews) {
                $model = new News;
                $model->unsetAttributes();
                $model->site_id = $this->site_id;
                $model->status = Tour::STATUS_ACTIVED;
                //
                $model->news_title = trim($oldNews['name']);
                $model->news_category_id = $this->getServiceCategoryMap($oldNews['catId']);
                $model->news_sortdesc = trim($oldNews['description']);
                $model->news_desc = $oldNews['details'];
                $model->meta_keywords = $model->news_title;
                $model->meta_title = $oldNews['titleseo'];
                $model->meta_description = $oldNews['descseo'];
                //
                if ($model->news_category_id) {
                    $categoryTrack = array_reverse($category->saveTrack($model->news_category_id));
                    $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
                    $model->category_track = $categoryTrack;
                }
                if (!(int) $model->news_category_id)
                    $model->news_category_id = null;
                if ($model->publicdate && $model->publicdate != '' && (int) strtotime($model->publicdate))
                    $model->publicdate = (int) strtotime($model->publicdate);
                else
                    $model->publicdate = time() + (int) $oldNews['id'];;
                //
                if ($model->save()) {
                    $avatar = ($oldNews['icon']) ? 'http://tptravel.com.vn/data/media/1850' . (str_replace('../', '/', $oldNews['icon'])) : '';
                    if ($avatar) {
                        $up = new UploadLib();
                        $up->setPath(array($this->site_id, 'news', (int) date('m')));
                        $up->getFile(array('link' => $avatar, 'filetype' => UploadLib::UPLOAD_IMAGE));
                        $response = $up->getResponse(true);
                        if ($up->getStatus() == '200') {
                            $listImages = array(['path' => $response['baseUrl'], 'name' => $response['name']]);
                            $avatarName = '';
                            $imagePath = '';
                            $avatarID = 0;
                            $i = 0;
                            foreach ($listImages as $image) {
                                if ($i == 0) {
                                    $avatarName = $image['name'];
                                    $imagePath = $image['path'];
                                }
                                $nimg = new NewsImages;
                                $nimg->id = $model->news_id;
                                $nimg->name = $nimg->display_name = trim($image['name']);
                                $nimg->path = $image['path'];
                                $nimg->alias = HtmlFormat::parseToAlias($image['name']);
                                $nimg->site_id = $this->site_id;
                                if ($nimg->save()) {
                                    if ($i == 0) {
                                        $avatarID = $nimg->img_id;
                                    }
                                } else {
                                    var_dump($nimg->getErrors());
                                }
                                $i++;
                            }
                            if ($avatarName) {
                                $model->image_path = $imagePath;
                                $model->image_name = $avatarName;
                            }
                            $model->save();
                        }
                    }
                    // redirect 301
                    $domain = 'http://tptravel.com.vn';
                    $link1 = '/dich-vu/' . $model['alias'] . '-' . $oldNews['id'] . '.html';
                    if (isset($link1) && trim($link1)) {
                        $redirect = new Redirects();
                        $redirect->scenario = 'create';
                        $redirect->from_url = trim(str_replace($domain, '', $link1));
                        $redirect->to_url = $domain . Yii::app()->createUrl('news/news/detail', array('id' => $model->news_id, 'alias' => $model['alias']));
                        $redirect->save();
                    }
                    //var_dump($oldNews);
                } else {
                    var_dump($model->getErrors());
                }
            }
        }
        echo 'Done';
        die('Ok');
    }

    function getNewsCategoryMap($category_id = 0) {
        $arrMap = $this->getNewsCategoryMapArr();
        $map_id = 0;
        if (isset($arrMap[$category_id])) {
            $map_id = $arrMap[$category_id];
        }
        return $map_id;
    }

    function getNewsCategoryMapArr() {
        return array(
            1 => 11034,
            2 => 11308,
            3 => 11309,
            4 => 11310,
            5 => 11311,
            6 => 11312,
        );
    }

    function getServiceCategoryMap($category_id = 0) {
        $arrMap = $this->getServiceCategoryMapArr();
        $map_id = 0;
        if (isset($arrMap[$category_id])) {
            $map_id = $arrMap[$category_id];
        }
        return $map_id;
    }

    function getServiceCategoryMapArr() {
        return array(
            1 => 11391,
            2 => 11392,
            3 => 11393,
            4 => 11394,
        );
    }

    /**
     * import subject
     */
    function actionSubject() {
        set_time_limit(0);
        $mapsString = '{"2":"15","3":"16","4":"17","5":"18","9":"19","10":"20","11":"21","12":"22","13":"23","14":"24","15":"25","16":"26","17":"27","18":"28","19":"29","20":"30","21":"31","22":"32","23":"33","24":"34","25":"35","26":"36","27":"37","28":"38","29":"39","30":"40","31":"41","32":"42","33":"43","34":"44","35":"45","36":"46","37":"47","39":"48","40":"49","41":"50","42":"51","43":"52","44":"53","45":"54","46":"55","47":"56","48":"57"}';
        $maps = json_decode($mapsString, true);
        if (!$maps) {
            //
            $oldSubjects = Yii::app()->db->createCommand()->select('*')
                    ->from(ClaTable::getTable('dnsubject'))
                    ->where('isDeleted<>1')
                    ->order('id')
                    ->limit(100)
                    ->offset(1)
                    ->queryAll();
            if ($oldSubjects) {
                //
                $maps = array();
                foreach ($oldSubjects as $oldSubject) {
                    $model = new TourGroups;
                    $model->unsetAttributes();
                    $model->site_id = $this->site_id;
                    $model->status = Tour::STATUS_ACTIVED;
                    //
                    $model->name = trim($oldSubject['name']);
                    $model->description = $oldSubject['details'];
                    $model->meta_keywords = $oldSubject['titleseo'];
                    $model->meta_title = $oldSubject['titleseo'];
                    $model->meta_description = $oldSubject['descseo'];
                    $model->created_time = time() + (int) $oldSubject['id'];
                    //
                    if ($model->save()) {
                        $maps[$oldSubject['id']] = $model->group_id;
                        //
                        $avatar = ($oldSubject['icon']) ? 'http://tptravel.com.vn/data/media/1850' . (str_replace('../', '/', $oldSubject['icon'])) : '';
                        if ($avatar) {
                            $up = new UploadLib();
                            $up->setPath(array($this->site_id, 'tourgroup', (int) date('m')));
                            $up->getFile(array('link' => $avatar, 'filetype' => UploadLib::UPLOAD_IMAGE));
                            $response = $up->getResponse(true);
                            if ($up->getStatus() == '200') {
                                $model->image_path = $response['baseUrl'];
                                $model->image_name = $response['name'];
                                $model->save();
                            }
                        }
                        // redirect 301
                        $domain = 'http://tptravel.com.vn';
                        $link1 = '/' . $oldSubject['displayid'] . '.html';
                        if (isset($link1) && trim($link1)) {
                            $redirect = new Redirects();
                            $redirect->scenario = 'create';
                            $redirect->from_url = trim(str_replace($domain, '', $link1));
                            $redirect->to_url = $domain . Yii::app()->createUrl('tour/tour/group', array('id' => $model->group_id, 'alias' => $model['alias']));
                            $redirect->save();
                        }
                    } else {
                        var_dump($model->getErrors());
                    }
                }
                //
                $domain = ClaSite::getServerName();
                $file = Yii::getPathOfAlias('common') . '/../assets/tourmap.csv';
                if (!is_file($file)) {
                    $myfile = fopen($file, "a");
                    $data = json_encode($maps);
                    fwrite($myfile, $data);
                    fclose($myfile);
                }
            }
        }
        //
        $oldTours = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('dntour'))
                ->order('id')
                ->limit(300)
                ->offset(0)
                ->queryAll();
        foreach ($oldTours as $oldTour) {
            $subs = ($oldTour['subjectId']) ? explode(',', $oldTour['subjectId']) : array();
            $newTour = Tour::model()->findByAttributes(array('name' => $oldTour['name']));
            if (!$newTour || !$subs) {
                continue;
            }
            foreach ($subs as $sub_id) {
                $tourToGroup = new TourToGroups();
                $tourToGroup->group_id = $maps[$sub_id];
                $tourToGroup->tour_id = $newTour['id'];
                $tourToGroup->site_id = $this->site_id;
                $tourToGroup->created_time = time() + (int) $sub_id;
                $tourToGroup->save();
            }
        }
        //
        echo 'Done';
        die('Ok');
    }

}
