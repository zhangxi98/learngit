<?php
/**
 * FCKeditor保存远程图片插件
 * @author 68ecshop(794094199@qq.com)
 * @copyright  Copyright (c) 2011,  68ecshop (http://www.68ecshop.com)
 *
 */
//说明：
require_once './ServerXMLHTTP.php';
require_once './config.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
<!--
body {
font-size:10pt;
}
-->
</style>
<body bgcolor="#E3E3C7" leftmargin="0" rightmargin="0">
<SCRIPT LANGUAGE="JavaScript">
  var dialog = window.parent;
  var oEditor = dialog.InnerDialogLoaded();
  var FCKLang = oEditor.FCKLang;
  var xEditor = oEditor.FCK;
  var a = xEditor.GetXHTML();
  dialog.SetOkButton(true);
  function Ok(){return true;}
<?php
	set_time_limit(0);
	$files=$_POST['files'];
	$fileNum=count($files);
	$realFileNum=0;
	$imgArray=array('.gif','.jpg','.png','.jpeg','.bmp');

	$typeArray=array();
	ob_start();
	for($i=0;$i<$fileNum;$i++)
	{
		$type=strrchr(trim($files[$i]),".");
		if($files[$i]!='' && in_array($type,$imgArray))
		{
			$now=time()."-".$i;
			$filename= date('Ym').'/'.$now.strrchr(trim($files[$i]),".");
			//$filename=md5_file(trim($files[$i])).strrchr(trim($files[$i]),".");
			$savetime=SaveHTTPFile(trim($files[$i]),$saveFilePath,$filename);
?>
			a=a.replace("<?php echo trim($files[$i]);?>","<?php echo $displayUrl.'/'.$filename;?>");
<?php
		}
	}
	ob_end_flush();
?>
xEditor.SetHTML(a);
</script>
<font clor=red>文件已经保存成功<br/>
</font>
</body>