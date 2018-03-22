<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="http://localhost/" />
<meta name="Generator" content=" v5_0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link rel="stylesheet" type="text/css" href="themes/68ecshopcom_360buy/css/article.css" />
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-1.9.1.min.js"></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?> 
<div class="w1210">
    <div class="blank"></div>
    <?php echo $this->fetch('library/ur_here.lbi'); ?>
    <div class="clearfix">
        <div class="right-con">
        	<div class="right-inner">
                <div class="mod-tit">
                    <?php echo $this->_var['lang']['article_list']; ?>
                    <div class="article-search">
                        <form action="<?php echo $this->_var['search_url']; ?>" name="search_form" method="post">
                          <input name="keywords" type="text" id="requirement" size="40" value="<?php echo $this->_var['search_value']; ?>" class="input"/>
                          <input name="id" type="hidden" value="<?php echo $this->_var['cat_id']; ?>" />
                          <input name="cur_url" id="cur_url" type="hidden" value="" />
                          <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="btn" />
                        </form>
                    </div>
                </div>
                <?php if ($this->_var['artciles_list']): ?>
                <div class="article-list">
                	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <th><?php echo $this->_var['lang']['article_title']; ?></th>
                          <th><?php echo $this->_var['lang']['article_author']; ?></th>
                          <th><?php echo $this->_var['lang']['article_add_time']; ?></th>
                        </tr>
                        <?php $_from = $this->_var['artciles_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
                        <tr>
                          <td><a style="text-decoration:none" href="<?php echo $this->_var['article']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['article']['title']); ?>" class="f6"><?php echo $this->_var['article']['short_title']; ?></a></td>
                          <td align="center"><?php echo $this->_var['article']['author']; ?></td>
                          <td align="center"><?php echo $this->_var['article']['add_time']; ?></td>
                        </tr>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </table>
                </div>
                <?php else: ?>
                <div class="notice-noresult clearfix">
                    <div class="noresult-con">
                		<i class="noresult-icon"></i>
                        <p class="noresult-text">抱歉，没有找到相关的文章</p>
                        <a class="main-btn" href="javascript:window.history.back(-1);">点击返回上一步</a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="blank15"></div>
            <?php if ($this->_var['artciles_list']): ?>
            <?php echo $this->fetch('library/pages.lbi'); ?> 
            <?php endif; ?>
        </div>
        <div class="left-con"> 
            <?php echo $this->fetch('library/article_category_tree.lbi'); ?> 
              
        </div>
    </div>
</div>
<div class="site-footer">
  <div class="footer-related"> 
    <?php echo $this->fetch('library/help.lbi'); ?> 
    <?php echo $this->fetch('library/page_footer.lbi'); ?> 
  </div>
</div>
</body>
<script type="text/javascript">
document.getElementById('cur_url').value = window.location.href;
</script>
</html>
