<?php

error_reporting(0);
require (dirname(__FILE__) . '/Uploadhandel.php');

define('DS', '/');

$reg = '%(.*)\/s([0-9]*)_([0-9]*)\/(.*)%';
$matches = array();
$server = $_SERVER;
$request = urldecode($server['REQUEST_URI']);
preg_match($reg, $request, $matches);
//
if ($matches && $matches[1] && $matches[2] && $matches[3] && $matches[4]) {
    $upload = new Uploadhandel();
    //
    $base_path = $server['DOCUMENT_ROOT'] . DS . $matches[1];
    //
    $file_name = $matches[4];
    //
    $size_width = (int) $matches[2];
    $size_height = (int) $matches[3];
    //
    $file = $base_path . DS . $file_name;
    //
    $FileParts = pathinfo($file_name);
    $ext = strtolower($FileParts['extension']);
    //
    if ($size_height && $size_width && is_file($file) && $upload->validateImageExtension($ext)) {
        $dir = $base_path . DS . 's' . $size_width . '_' . $size_height;
        //
        $resize = new Resize();
        $resize->width = $size_width;
        $resize->height = $size_height;
        //
        $resize->rmkdir($dir);
        $resize->setImageFile($file);
        // resize theo chiều rộng
        $resize->inframeResize();
        //
        if ($resize->save($dir . DS . $file_name)) {
            $ext = isset($upload->mime_types[$FileParts['extension']]) ? $upload->mime_types[$ext] : 'image/jpeg';
            header('HTTP/1.1 200'); // override the 404 response
            header('Content-Type: ' . $ext);
            echo file_get_contents($dir . DS . $file_name);
            flush();
            @ob_flush();
            exit;
        }
    }
}