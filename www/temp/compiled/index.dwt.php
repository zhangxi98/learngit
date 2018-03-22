<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="http://localhost/" />
<meta name="Generator" content=" v5_0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta name="renderer" content="webkit" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link rel="alternate" type="application/rss+xml" title="RSS|<?php echo $this->_var['page_title']; ?>" href="<?php echo $this->_var['feed_url']; ?>" />
<link rel="stylesheet" type="text/css" href="themes/68ecshopcom_360buy/css/index.css" />
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jump.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/tab.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-lazyload.js" ></script>
<script type="text/javascript">
var compare_no_goods = "<?php echo $this->_var['lang']['compare_no_goods']; ?>";
var btn_buy = "<?php echo $this->_var['lang']['btn_buy']; ?>";
var is_cancel = "<?php echo $this->_var['lang']['is_cancel']; ?>";
var select_spe = "<?php echo $this->_var['lang']['select_spe']; ?>";
</script>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,index.js')); ?>
</head>
<body><?php 
$k = array (
  'name' => 'add_url_uid',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
	<?php echo $this->fetch('library/page_header_index.lbi'); ?>
    <div class="banner">
		<?php echo $this->fetch('library/index_ad.lbi'); ?>
        <div class="right-sidebar">
			<?php echo $this->fetch('library/recommend_right_promotion.lbi'); ?>	
            <div class="proclamation">
					<ul class="tabs-nav">
                    	<li class="tabs-selected">
							<h3>商城公告</h3>
						</li>
						<li>
							<h3>会员注册</h3>
						</li>
					</ul>
                    

					<div class="tabs-panel tabs-hide">
						<a href="/register.php" title="会员注册" class="store-join-btn" target="_blank">&nbsp;</a>
						<a href="/user.php" target="_blank" class="store-join-help">
							<i class="icon-cog"></i>
							会员注册
						</a>
					</div>
			</div>
        </div>
    </div>
    <?php echo $this->fetch('library/index_ad_groups.lbi'); ?>

    <div class="w1210 index-sale">
			<?php echo $this->fetch('library/stores_tab.lbi'); ?>
			<?php echo $this->fetch('library/recommend_promotion.lbi'); ?>
			<?php echo $this->fetch('library/recommend_hot_sale.lbi'); ?>
			<?php echo $this->fetch('library/recommend_hot.lbi'); ?>
			<?php echo $this->fetch('library/recommend_best.lbi'); ?>
			<?php echo $this->fetch('library/recommend_new.lbi'); ?>					
	</div>
    <div class="w1210 floor-list">
			<div class="floor"></div>
			
<?php $this->assign('cat_goods',$this->_var['cat_goods_5']); ?><?php $this->assign('goods_cat',$this->_var['goods_cat_5']); ?><?php $this->assign('sort_order',$this->_var['goods_cat_5_sort_order']); ?><?php $this->assign('ext_info',$this->_var['goods_cat_5_ext_info']); ?><?php echo $this->fetch('library/cat_goods.lbi'); ?>
<?php $this->assign('cat_goods',$this->_var['cat_goods_6']); ?><?php $this->assign('goods_cat',$this->_var['goods_cat_6']); ?><?php $this->assign('sort_order',$this->_var['goods_cat_6_sort_order']); ?><?php $this->assign('ext_info',$this->_var['goods_cat_6_ext_info']); ?><?php echo $this->fetch('library/cat_goods.lbi'); ?>
<?php $this->assign('cat_goods',$this->_var['cat_goods_2']); ?><?php $this->assign('goods_cat',$this->_var['goods_cat_2']); ?><?php $this->assign('sort_order',$this->_var['goods_cat_2_sort_order']); ?><?php $this->assign('ext_info',$this->_var['goods_cat_2_ext_info']); ?><?php echo $this->fetch('library/cat_goods.lbi'); ?>
<?php $this->assign('cat_goods',$this->_var['cat_goods_4']); ?><?php $this->assign('goods_cat',$this->_var['goods_cat_4']); ?><?php $this->assign('sort_order',$this->_var['goods_cat_4_sort_order']); ?><?php $this->assign('ext_info',$this->_var['goods_cat_4_ext_info']); ?><?php echo $this->fetch('library/cat_goods.lbi'); ?>

	</div>
    <script type="text/javascript" src="themes/68ecshopcom_360buy/js/indexPrivate.min.js"></script>
    <?php echo $this->fetch('library/right_sidebar.lbi'); ?>
    <?php echo $this->fetch('library/page_footer_index.lbi'); ?>
    <?php echo $this->fetch('library/arrive_notice.lbi'); ?>
    <?php echo $this->fetch('library/left_sidebar.lbi'); ?>
</body>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/home_index.js"></script>
<script type="text/javascript">
	$(".brand-con").hover(function(){
		var num = $(this).find("li").length;
		if(num > 10){
			$(this).find(".brand-btn").fadeTo('fast',0.4);	
		}
	},
	function(){
		$(this).find(".brand-btn").fadeTo('fast',0);	
	})

</script>
</html>