<?php
/**
 * FCKeditor保存远程图片插件
 * @author 68ecshop(794094199@qq.com)
 * @copyright  Copyright (c) 2011,  68ecshop (http://www.68ecshop.com)
 *
 */
 define('ROOT_PATH', preg_replace('/includes(.*)/i', '', str_replace('\\', '/', __FILE__)));
 if (isset($_SERVER['PHP_SELF']))
{
    define('PHP_SELF', $_SERVER['PHP_SELF']);
}
else
{
    define('PHP_SELF', $_SERVER['SCRIPT_NAME']);
}

$root_path = preg_replace('/includes(.*)/i', '', PHP_SELF);
//设置图片保存绝对路径
$saveFilePath=ROOT_PATH . '/images/upload/fckautosave';
//设置显示的链接地址
$displayUrl=$root_path .'images/upload/fckautosave';;
?>