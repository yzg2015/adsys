<?php
/**
 * Created by PhpStorm.
 * User: NUC
 * Date: 2018/4/18
 * Time: 16:55
 */

echo  strtotime('+2 week');
$start_time_1 = '2018-12-21';
if(!preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/',$start_time_1)){
    $start_time_1 = date('Y-m-d');
}


exit();

require(dirname(__FILE__).'/httpupload.class.php');



function sendCurlPost()
{
    $vars = array();
    $poat = array('name'=>'E:\test\adsys\admail\121.txt','tmp_name'=>'E:\test\adsys\admail\121.jpg','type'=>'image/jpeg','size'=>55544);
    $vars['list_id'] = 1176005;
    $vars['name'] ='cesshi';
    $vars['subject'] ='subsject';
    $vars['content'] ='test';
    /* 初始化并执行curl请求 */
    $ch = curl_init();
    $vars["foo"]="bar";
    if (class_exists('\CURLFile')) {// 这里用特性检测判断php版本
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        // $vars['file'] = array(new \CURLFile(dirname(__FILE__).'\121.jpg'));//>=5.5
        $vars['file']  = '@' . dirname(__FILE__).'\121.jpg';
    } else {
        if (defined('CURLOPT_SAFE_UPLOAD')) {
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
        }
        $vars['file']  = '@' . dirname(__FILE__).'\121.jpg';
    }

    $opts = array(
        CURLOPT_TIMEOUT        => 5,
        CURLOPT_HTTPAUTH=>CURLAUTH_BASIC,
        CURLOPT_USERPWD=>'wanjing:Wanjing456@',
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_BINARYTRANSFER=>1,
        CURLOPT_URL            => 'http://www.bestedm.org/mm-ms/apinew/template.php?do=add-tpl',
        CURLOPT_HTTPHEADER=>Array("Content-Type:multipart/form-data; boundary=---------------------------32642708628732"),
        CURLOPT_POST           => 1,
        CURLOPT_POSTFIELDS     =>  $vars,
        CURLOPT_USERAGENT      => $_SERVER['HTTP_USER_AGENT'],
        CURLOPT_SSL_VERIFYPEER      => FALSE,
        CURLOPT_SSL_VERIFYHOST      => FALSE,
        CURLOPT_HEADER=>0,

    );
    curl_setopt_array($ch, $opts);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code ;
    $data  = curl_exec($ch);

    curl_close($ch);
    return $data;
}
//
var_dump(sendCurlPost());



