<?php

/**
 * @author minhbn <minhcoltech@gmail.com>
 * Album controller
 */
class MediaController extends PublicController
{

     public $layout = '//layouts/media';

     //
     public function actionFolderDetail($id)
     {

          //
          $folders = Folders::model()->findByPk($id);
          // Nhóm danh mục file
          $files = Files::getAllFile();
          //
         //breadcrumbs
         $this->breadcrumbs = array(
             Yii::t('common', 'download') => Yii::app()->createUrl('/media/media/folder'),
             $folders->folder_name =>  Yii::app()->createUrl('media/media/folderDetail', array('id' => $folders->folder_id, 'alias' => $folders->alias))
         );
          $file = new Files();
          $file->unsetAttributes();
          $file->site_id = $this->site_id;
          $file->folder_id = $folders->folder_id;
          $dataprovider = $file->search();
          //
          $this->render('folder_detail', array(
               'folders' => $folders,
               'model' => $file,
               'dataprovider' => $dataprovider,
          ));
     }

     //
     public function actionFolder()
     {
          //breadcrumbs
          $this->breadcrumbs = array(
               Yii::t('common', 'download') => Yii::app()->createUrl('/media/media/folder'),
          );
          //
          $folders = Folders::getAllFolders();
          // Nhóm danh mục file
          $files = Files::getAllFile();
          if(count($folders) && count($files)){
               foreach ($folders as $folder){
                    foreach ($files as $file){
                         if ($folder['folder_id'] == $file['folder_id']){
                              $id = $folder['folder_id'];
                              $folders[$id]['files'][] = $file;
                              unset($file);
                         }
                    }
               }
          }

          //
          $file = new Files();
          $file->unsetAttributes();
          $file->site_id = $this->site_id;
          $dataprovider = $file->search();
          //
          $this->render('folder', array(
               'folders' => $folders,
               'model' => $file,
               'dataprovider' => $dataprovider,
          ));
     }

     public function actionFile()
     {
          //breadcrumbs
          $this->breadcrumbs = array(
               Yii::t('common', 'download') => Yii::app()->createUrl('/media/media/folder'),
          );
          //
          $folder_id = Yii::app()->request->getParam('fid');
          if (!$folder_id)
               $this->sendResponse(400);
          $folder = Folders::model()->findByPk($folder_id);
          if (!$folder)
               $this->sendResponse(404);
          if ($folder->site_id != $this->site_id)
               $this->sendResponse(404);

          $this->breadcrumbs = array_merge($this->breadcrumbs, array(
               $folder->folder_name => Yii::app()->createUrl('/media/media/file', array('fid' => $folder_id)),
          ));
          //
          $file = new Files();
          $file->unsetAttributes();
          $file->folder_id = $folder->folder_id;
          $dataprovider = $file->search();
          //
          $this->render('file', array(
               'folder' => $folder,
                'model' => $file,
               'dataprovider' => $dataprovider,
          ));
     }

     //
     public function actionDownloadfile($id)
     {
          $file = Files::model()->findByPk($id);
          if ($file) {
               $read = (Yii::app()->request->getParam('read', false)) ? true : false;
               $up = new UploadLib();
               $up->download(array(
                    'path' => $file->path,
                    'name' => $file->name,
                    'extension' => Files::getMimeType($file->extension),
                    'realname' => HtmlFormat::parseToAlias($file->display_name) . '.' . $file->extension,
                    'readOnline' => $read
               ));
          }
          Yii::app()->end();
     }

     public function actionDetailfile($id)
     {
          $file = Files::model()->findByPk($id);
          $this->breadcrumbs = array(
               Yii::t('common', 'download') => Yii::app()->createUrl('/media/media/folder'),
               $file->display_name => Yii::app()->createUrl('media/media/detailfile'),
          );
          $this->render('detail', array(
               'file' => $file
          ));
     }

     public function actionSiteContactForm()
     {
          $model = new SiteContactForm();
          $model->unsetAttributes();

          if (isset($_POST['SiteContactForm'])) {
               $model->attributes = $_POST['SiteContactForm'];
               $file = $_FILES['image_src'];
               if ($file && $file['name']) {
                    $model->image_src = 'true';
                    $extensions = SiteContactForm::allowExtensions();
                    if (!isset($extensions[$file['type']])) {
                         $model->addError('image_src', Yii::t('banner', 'banner_invalid_format'));
                    }
               }
               if (!$model->getErrors()) {
                    $up = new UploadLib($file);
                    $up->setPath(array($this->site_id, 'print_image'));
                    $up->uploadFile();
                    $response = $up->getResponse(true);
                    //
                    if ($up->getStatus() == '200') {
                         $model->image_src = ClaHost::getMediaBasePath() . $response['baseUrl'] . $response['name'];
                    } else {
                         $model->image_src = '';
                    }
                    //
                    if ($model->save()) {
                         Yii::app()->user->setFlash('success', Yii::t('contact', 'contact_success_msg'));
                         $this->redirect(array('siteContactForm'));
                    }
               }
          }

          $this->render('contact_form', array(
               'model' => $model,
          ));
     }

     /**
      * Download file cv user job
      * @param type $id
      */
     public function actionDownloadfilecv($id)
     {
          $file = UserJobFiles::model()->findByPk($id);
          if ($file) {
               $up = new UploadLib();
               $up->download(array(
                    'path' => $file->path,
                    'name' => $file->name,
                    'extension' => UserJobFiles::getMimeType($file->extension),
                    'realname' => HtmlFormat::parseToAlias($file->display_name) . '.' . $file->extension,
               ));
          }
          Yii::app()->end();
     }

     /**
      * @hatv
      * Delete file user
      * @param type $id
      */
     public function actionDeleteUserFile($id)
     {
          if (!Yii::app()->user->isGuest) {
               $user_id = Yii::app()->user->id;
               $userinfo = ClaUser::getUserInfo($user_id);
               $model = UserJobFiles::model()->findByPk($id);
               if ($user_id != $model->user_id || $model->site_id != $this->site_id || $userinfo['site_id'] != $this->site_id) {
                    return false;
               }
               $model->delete();
               Yii::app()->user->setFlash('success', Yii::t('status', 'update_success'));
               if (!isset($_GET['ajax'])) {
                    $this->redirect(Yii::app()->createUrl('profile/profile/profileEventIndex'));
               }
          }
     }
}
