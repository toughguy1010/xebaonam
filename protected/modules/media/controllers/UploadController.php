<?php

/**
 * @author minhbn <minhcoltech@gmail.com>
 * Upload router
 */
class UploadController extends Controller {

    /**
     * upload image
     */
    public function actionUploadimage() {

        if (Yii::app()->request->isPostRequest) {
            $file = $_FILES['Filedata'];
            if (!$file) {
                echo json_encode(array('code' => 1, 'message' => 'File không tồn tại'));
                return;
            }
            $fileinfo = pathinfo($file['name']);
            if (!in_array(strtolower($fileinfo['extension']), Images::getImageExtension())) {
                echo json_encode(array('code' => 1, 'message' => 'File không đúng định dạng'));
                return;
            }
            $filesize = $file['size'];
            if ($filesize < 1 || $filesize > 8 * 1024 * 1000) {
                echo json_encode(array('code' => 1, 'message' => 'Cỡ file không đúng'));
                return;
            }
            //
            $path = Yii::app()->request->getPost('path');
            $path = json_decode($path, true);
            if (!$path) {
                echo json_encode(array('code' => 1, 'message' => 'Đường dẫn không đúng'));
                return;
            }
            //
            $imageoptions = Yii::app()->request->getPost('imageoptions');
            $imageoptions = json_decode($imageoptions, true);
            //
            $resizes = isset($imageoptions ['resizes']) ? $imageoptions ['resizes'] : array();
            $up = new UploadLib($file);
            $up->setPath($path);
            $up->setResize($resizes);
            $up->uploadImage();
            $response = $up->getResponse(true);
            if ($up->getStatus() == '200') {
                $imgtemp = new ImagesTemp();
                $imgtemp->img_id = ClaGenerate::getUniqueCode();
                $imgtemp->name = $response['name'];
                $imgtemp->path = $response['baseUrl'];
                $imgtemp->display_name = $response['original_name'];
                $imgtemp->description = isset($response['mime']) ? $response['mime'] : '';
                $imgtemp->alias = HtmlFormat::parseToAlias($imgtemp->display_name);
                $imgtemp->site_id = $this->site_id;
                $imgtemp->width = $response['imagesize'][0];
                $imgtemp->height = $response['imagesize'][1];
                $imgtemp->resizes = json_encode($resizes);
                if ($imgtemp->save()) {
                    $this->jsonResponse(200, array(
                        'imgid' => $imgtemp->img_id,
                        'imagepath' => ClaHost::getImageHost() . '/' . $imgtemp->path,
                        'imagename' => $imgtemp->name,
                        'imgurl' => ClaHost::getImageHost() . $imgtemp->path . 's250_250/' . $imgtemp->name,
                        'imgfullurl' => ClaHost::getImageHost() . $imgtemp->path . $imgtemp->name,
                    ));
                }
            }
            echo json_encode($response);

            Yii::app()->end();
        }
    }

}
