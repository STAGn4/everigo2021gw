<?php

/** This file is part of KCFinder project
  *
  *      @desc Base configuration file
  *   @package KCFinder
  *   @version 3.12
  *    @author Pavel Tzonkov <sunhater@sunhater.com>
  * @copyright 2010-2014 KCFinder Project
  *   @license http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license http://opensource.org/licenses/LGPL-3.0 LGPLv3
  *      @link http://kcfinder.sunhater.com
  */

/* IMPORTANT!!! Do not comment or remove uncommented settings in this file
   even if you are using session configuration.
   See http://kcfinder.sunhater.com/install for setting descriptions */

// ログイン確認 ＋ 出版社ID取得
require_once($_SERVER['DOCUMENT_ROOT'].'/../libdb/AdminController.php');

class Controller extends AdminController {
    function init() {
        parent::init();

        $this->__defaultAction = 'process';
    }
}

$controller = new Controller();
$controller->run();

$islogin = true; // true:no login / false: login
if(isset($_SESSION['id'])) {
    $islogin = false;
}

// 管理画面確認用 サイトURL調整
$hostURL = $_SESSION['publisher_url'];
if(isset($_SESSION['publisher_url']) && preg_match('|/$|', $_SESSION['publisher_url'])) {
    $hostURL = rtrim($_SESSION['publisher_url'], "/");
}

$_CONFIG = array(


// GENERAL SETTINGS

    'disabled' => $islogin,
    'uploadURL' => $hostURL . "/web/", // ブラウザ側表示用
    'uploadDir' => $_SERVER['DOCUMENT_ROOT'] . "/web/", // アップロード先
    'theme' => "default",

    'types' => array(

    // (F)CKEditor types
        'files'   =>  "",
        'flash'   =>  "swf",
        'images'  =>  "*img",

    // TinyMCE types
        'file'    =>  "",
        'media'   =>  "swf flv avi mpg mpeg qt mov wmv asf rm",
        'image'   =>  "*img",
    ),


// IMAGE SETTINGS

    'imageDriversPriority' => "imagick gmagick gd",
    'jpegQuality' => 90,
    'thumbsDir' => ".thumbs",

    'maxImageWidth' => 0,
    'maxImageHeight' => 0,

    'thumbWidth' => 100,
    'thumbHeight' => 100,

    'watermark' => "",


// DISABLE / ENABLE SETTINGS

    'denyZipDownload' => false,
    'denyUpdateCheck' => false,
    'denyExtensionRename' => false,


// PERMISSION SETTINGS

    'dirPerms' => 0755,
    'filePerms' => 0644,

    'access' => array(

        'files' => array(
            'upload' => true,
            'delete' => true,
            'copy'   => true,
            'move'   => true,
            'rename' => true
        ),

        'dirs' => array(
            'create' => true,
            'delete' => true,
            'rename' => true
        )
    ),

    // 拒否リスト 今は無効
    'deniedExts' => "exe com msi bat cgi pl php phps phtml php3 php4 php5 php6 py pyc pyo pcgi pcgi3 pcgi4 pcgi5 pchi6",
    // 許可リスト
    'allowedExts' => "gif jpg jpeg png pdf doc docx xls xlsx txt zip csv",
    // アップロードファイルサイズ
    'uploadMaxsize' => "10MB",
    // トータルのアップロードファイルサイズ
    'totalUploadMaxsize' => "20MB",
    // ディレクトリのトータルのアップロードファイルサイズ
    'dirMaxsize' => "1GB",


// MISC SETTINGS

    'filenameChangeChars' => array(/*
        ' ' => "_",
        ':' => "."
    */),

    'dirnameChangeChars' => array(/*
        ' ' => "_",
        ':' => "."
    */),

    'mime_magic' => "",

    'cookieDomain' => "",
    'cookiePath' => "",
    'cookiePrefix' => 'KCFINDER_',


// THE FOLLOWING SETTINGS CANNOT BE OVERRIDED WITH SESSION SETTINGS

    '_normalizeFilenames' => false,
    '_check4htaccess' => false, // .htaccess を出力しないように
    '_tinyMCEPath' => "/admin/js/tinymce",

    '_sessionVar' => "KCFINDER",
    //'_sessionLifetime' => 30,
    //'_sessionDir' => "/full/directory/path",
    //'_sessionDomain' => ".mysite.com",
    //'_sessionPath' => "/my/path",

    //'_cssMinCmd' => "java -jar /path/to/yuicompressor.jar --type css {file}",
    //'_jsMinCmd' => "java -jar /path/to/yuicompressor.jar --type js {file}",

);

?>
