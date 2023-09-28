<?php

/**
 * @author: PhongPhamHong<minhcoltech@gmail.com>
 * Class for upload handel on server

 * overrided from:
 *  @author John Ciacia <Sidewinder@extreme-hq.com>
 *  @version 1.0
 *  @copyright Copyright (c) 2007, John Ciacia
 *  @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * 
 * @date: 12/23/2013
 */
require './UploadBase.php';
require './Resize.php';

class Uploadhandel extends UploadBase {

    /**
     * default max size
     */
    const MAX_FILE_SIZE = 500000;

    /**
     * type upload
     */
    const UPLOAD_IMAGE = 1;
    const UPLOAD_FILES = 2;

    /**
     * folder prefix name for resize and crop
     */
    const PRE_FIX_FOLDER_RESIZE = 's';
    const PRE_FIX_FOLDER_CROP = 'c';

    /**
     * upload type
     */
    protected $uploadType;

    /**
     * array allowed extension for upload image
     */
    protected $allowedImgExt = array('gif', 'jpg', 'jpeg', 'png', 'bmp', 'ico');
    protected $allowedImgSize = array(
        '50_50' => '50_50',
        '80_80' => '80_80',
        '100_100' => '100_100',
        '150_150' => '150_150',
        '200_200' => '200_200',
        '220_200' => '200_220',
        '300_300' => '300_300',
        '330_330' => '330_330',
        '350_350' => '350_350',
        '400_400' => '400_400',
        '500_500' => '500_500',
        '550_550' => '550_550',
        '600_600' => '600_600',
        '700_700' => '700_700',
        '800_800' => '800_800',
        '900_900' => '900_900',
        '1000_1000' => '1000_1000',
        '1100_1100' => '1100_1100',
        '1200_1200' => '1200_1200',
        '1300_1300' => '1300_1300',
        '1400_1400' => '1400_1400',
    );

    /**
     * base DIR folder to upload
     */
    public function getBaseDir() {
        return DS . 'media' . DS;
    }

    /**
     * get base DIR for image folder
     */
    public function getBaseDirImage() {
        return $this->getBaseDir() . 'images' . DS;
    }

    /**
     * get base DIR for files
     */
    public function getBaseDirFile() {
        return $this->getBaseDir() . 'files' . DS;
    }

    /**
     * true: create thumb
     * false: not create thumb
     * default is true
     * 
     * @var boolen
     */
    protected $createThumb = true;

    /**
     * dir upload
     */
    protected $dirUpload;

    /**
     * resize image object
     * 
     * @var Resize
     */
    protected $resizeModel;

    public function getUploadType() {
        return $this->uploadType;
    }

    public function getCreateThumb() {
        return $this->createThumb;
    }

    public function setUploadType($uploadType) {
        $this->uploadType = $uploadType;
    }

    public function setCreateThumb($createThumb) {
        $this->createThumb = $createThumb;
    }

    public function getResizeModel() {
        return $this->resizeModel;
    }

    public function getDirUpload() {
        return $this->dirUpload;
    }

    public function setDirUpload($dirUpload) {
        $this->dirUpload = $dirUpload;
    }

    /**
     * @minhbn <minhcoltech@grmail.com>
     * 
     * construct
     */
    public function __construct($_FILE) {
        if (isset($_FILE['tmp_name'])) {
            /**
             * set defaul values
             */
            $this->SetFileName($_FILE['name']);
            $this->SetTempName($_FILE['tmp_name']);
            $this->resizeModel = new Resize();
            //$this->setErrors('name_empty');
            //return false;
        }
    }

    /**
     * @minhbn <minhcoltech@grmail.com>
     * 
     * start upload images
     *  + set some default value like maxumum file size, SetValidExtensions
     *  + set SetUploadDirectory
     * @param type $server_path
     * @return boolen
     */
    public function save() {
        /* set max file size */
        if ($this->MaximumFileSize > self::MAX_FILE_SIZE) {
            $this->MaximumFileSize = self::MAX_FILE_SIZE;
        }
        /* if upload image */
        if ($this->uploadType === self::UPLOAD_IMAGE) {
            /* set allowed extension */
            if (!$this->ValidExtensions) {
                $this->SetValidExtensions($this->allowedImgExt);
            }
            $this->SetUploadDirectory($this->getBaseDirImage());
        } else {
            $this->SetUploadDirectory($this->getBaseDirFile());
        }
        /* set dir to upload */
        $this->buildDirFromParam();

        /* start upload */
        $result = $this->UploadFile();
        /* if createThumb is true and type upload is image, start creating thumb */
        if ($this->createThumb && $this->resizeModel && $this->uploadType == self::UPLOAD_IMAGE) {
            try {
                if (!$this->resizeModel->getResource($url))
                    $this->resizeModel->setImageFile($this->getFullDir() . $this->FileName);
            } catch (Exception $e) {
                //  $this->resizeModel = null;
            }
        }

        return $result;
    }

    /**
     * @minhbn <minhcoltech@grmail.com>
     * render file thumb name
     * Dir is:
     *  + if resize with width and height. Folder name is started with prefix 's'
     *  + if resize crop. Folder name is started with prefix 'c'
     *  + folder located in folder of original file
     * @return array  
     */
    public function renderFileThumb($size = array()) {
        $count = count($size);
        $dir = $this->GetUploadDirectory();
        $folderResize = null;
        $thumbname = $this->getOriginalFileName() . '.' . $this->getFileExtension();
        if ($count == 1) {
            $folderResize = self::PRE_FIX_FOLDER_RESIZE . array_shift($size);
        } else if ($count == 2) {
            list($w, $h) = $size;
            $w = intval($w);
            $h = intval($h);
            $folderResize = self::PRE_FIX_FOLDER_RESIZE . $w . '_' . $h;
        } else if ($count > 2) {
            list($x1, $x2, $y1, $y2) = $size;
            $x1 = intval($x1);
            $x2 = intval($x2);
            $y1 = intval($y1);
            $y2 = intval($y2);
            $folderResize = self::PRE_FIX_FOLDER_CROP . $x1 . '_' . $x2 . '_' . $y1 . '_' . $y2;
        }
        $dir = $dir . $folderResize . DS;

        return array(
            'fulldir' => __DIR__ . $dir . $thumbname,
            'folder' => $folderResize,
            'file' => $thumbname
        );
    }

    /**
     * @minhbn <minhcoltech@grmail.com>
     * get file name without extension
     * 
     * @param string name
     */
    public function getOriginalFileName() {
        $path = pathinfo($this->FileName);
        return isset($path['filename']) ? $path['filename'] : null;
    }

    /**
     * @minhbn <minhcoltech@grmail.com>
     * 
     * create dir from array to upload
     * @param Uploadhandel dirUpload
     * @return string dir
     */
    public function buildDirFromParam() {
        $dir = $this->GetUploadDirectory();
        if (is_array($this->dirUpload)) {
            $dir .= implode(DS, $this->dirUpload) . DS;
        }
        $this->SetUploadDirectory($dir);
    }

    /**
     * validate image ext 
     * @param type $ext
     * @return boolean
     */
    public function validateImageExtension($ext = '') {
        return true;
        if ($ext) {
            if (in_array($ext, $this->allowedImgExt))
                return true;
        }
        return false;
    }

    /**
     * Validate image size 
     * @param type $width
     * @param type $height
     * @return boolean
     */
    public function ValidateImageSize($width = 0, $height = 0) {
        $width = (int) $width;
        $height = (int) $height;
        if (isset($this->allowedImgSize[$width . '_' . $height]))
            return true;
        return false;
    }

}
