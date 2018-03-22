<?php
/**
 * FCKeditor保存远程图片插件
 * @author 68ecshop(794094199@qq.com)
 * @copyright  Copyright (c) 2011,  68ecshop (http://www.68ecshop.com)
 *
 */
function getmicrotime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}

function SaveHTTPFile($fFileHTTPPath,$fFileSavePath,$fFileSaveName)
{
	//记录程序开始的时间
	$BeginTime=getmicrotime();
	//取得文件名
	$fFileSaveName=$fFileSavePath."/".$fFileSaveName;

	make_dir(dirname($fFileSaveName));
	//取得文件的内容
	ob_start();
	readfile($fFileHTTPPath);
	$img = ob_get_contents();
	ob_end_clean();
	//$size = strlen($img);

	//保存到本地
	$fp2=@fopen($fFileSaveName, "a");
	fwrite($fp2,$img);
	fclose($fp2);

	//记录程序运行结束的时间
	$EndTime=getmicrotime();

	//返回运行时间
	return($EndTime-$BeginTime);
}
/**
 * 检查目标文件夹是否存在，如果不存在则自动创建该目录
 *
 * @access      public
 * @param       string      folder     目录路径。不能使用相对于网站根目录的URL
 *
 * @return      bool
 */
function make_dir($folder)
{
    $reval = false;

    if (!file_exists($folder))
    {
        /* 如果目录不存在则尝试创建该目录 */
        @umask(0);

        /* 将目录路径拆分成数组 */
        preg_match_all('/([^\/]*)\/?/i', $folder, $atmp);

        /* 如果第一个字符为/则当作物理路径处理 */
        $base = ($atmp[0][0] == '/') ? '/' : '';

        /* 遍历包含路径信息的数组 */
        foreach ($atmp[1] AS $val)
        {
            if ('' != $val)
            {
                $base .= $val;

                if ('..' == $val || '.' == $val)
                {
                    /* 如果目录为.或者..则直接补/继续下一个循环 */
                    $base .= '/';

                    continue;
                }
            }
            else
            {
                continue;
            }

            $base .= '/';

            if (!file_exists($base))
            {
                /* 尝试创建目录，如果创建失败则继续循环 */
                if (@mkdir(rtrim($base, '/'), 0777))
                {
                    @chmod($base, 0777);
                    $reval = true;
                }
            }
        }
    }
    else
    {
        /* 路径已经存在。返回该路径是不是一个目录 */
        $reval = is_dir($folder);
    }

    clearstatcache();

    return $reval;
}
?>