ecshop的FCKeditor 远程保存图片插件
插件介绍：
在FCKeditor中复制网页内容时，其中的图片仍然保存在源站点上，使用该插件可将这些图片文件保存到站长自己的服务器上。
使用方法：
1)
把解压出的文件夹savehttpfiles放到includes\fckeditor\editor\plugins下

2)、

修改 fckconfig.js
  1.追加一行内容如下
  FCKConfig.Plugins.Add( 'savehttpfiles');
  2.在编辑器的工具栏上加一个按钮,书写如下
FCKConfig.ToolbarSets["Default"] = [
	['Source','SyntaxHighlighter','UGeSHi','savehttpfiles','DocProps','-','Save','NewPage','Preview','-','Templates'],
	['Cut','Copy','Paste','PasteText','PasteWord','-','Print','SpellCheck'],
	['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField'],
	'/',
	['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
	['OrderedList','UnorderedList','-','Outdent','Indent','Blockquote','CreateDiv'],
	['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
	['Link','Unlink','Anchor'],
	['Image','Flash','UpFileBtn','Table','Rule','Smiley','SpecialChar','PageBreak'],
	'/',
	['Style','FontFormat','FontName','FontSize'],
	['TextColor','BGColor'],
	['FitWindow','ShowBlocks','-','About']		// No comma for the last row.
] ;

FCKConfig.ToolbarSets["Normal"] = [
  ['Cut','Copy','Paste','PasteText','PasteWord','-','Undo','Redo','-','Find','Replace','-','RemoveFormat'],
  ['Link','Unlink','-','Image','Flash','UpFileBtn','Table'],
  ['FitWindow','-','Source','SyntaxHighlighter','UGeSHi','savehttpfiles'],
  '/',
  ['FontFormat','FontSize'],
  ['Bold','Italic','Underline'],
  ['OrderedList','UnorderedList','-','Outdent','Indent'],
  ['JustifyLeft','JustifyCenter','JustifyRight'],
  ['TextColor','BGColor']
] ;