<div id="filter">
  <form method="GET" name="listform" action="<?php echo $this->_var['actname']; ?>">
    <div class="fore1">
      <dl class="order">
        <dd class="first <?php if ($this->_var['pager']['sort'] == 'goods_id'): ?>curr<?php endif; ?>"><a href="<?php echo $this->_var['shangjian']; ?>">上架<b class="icon-order-<?php if ($this->_var['pager']['sort'] == 'goods_id'): ?><?php echo $this->_var['pager']['order']; ?><?php else: ?>DESC<?php endif; ?>ending"></b></a></dd>
        <dd class="<?php if ($this->_var['pager']['sort'] == 'salenum'): ?>curr<?php endif; ?>"><a href="<?php echo $this->_var['xiaoliang']; ?>">销量<b class="icon-order-<?php if ($this->_var['pager']['sort'] == 'salenum'): ?><?php echo $this->_var['pager']['order']; ?><?php else: ?>DESC<?php endif; ?>ending"></b></a></dd>
        <dd class="<?php if ($this->_var['pager']['sort'] == 'shop_price'): ?>curr<?php endif; ?>"><a href="<?php echo $this->_var['jiage']; ?>">价格<b class="icon-order-<?php if ($this->_var['pager']['sort'] == 'shop_price'): ?><?php echo $this->_var['pager']['order']; ?><?php else: ?>DESC<?php endif; ?>ending"></b></a></dd>
        <dd class="<?php if ($this->_var['pager']['sort'] == 'last_update'): ?>curr<?php endif; ?>"><a href="<?php echo $this->_var['gengxin']; ?>">更新<b class="icon-order-<?php if ($this->_var['pager']['sort'] == 'last_update'): ?><?php echo $this->_var['pager']['order']; ?><?php else: ?>DESC<?php endif; ?>ending"></b></a></dd>
        <dd class="<?php if ($this->_var['pager']['sort'] == 'click_count'): ?>curr<?php endif; ?>"><a href="<?php echo $this->_var['renqi']; ?>">人气<b class="icon-order-<?php if ($this->_var['pager']['sort'] == 'click_count'): ?><?php echo $this->_var['pager']['order']; ?><?php else: ?>DESC<?php endif; ?>ending"></b></a></dd>
      </dl>
      <div class="pagin"> 
        <?php if ($this->_var['pager']['page_prev']): ?> 
        <a href="<?php echo $this->_var['pager']['page_prev']; ?>" class="prev"><span class="icon prev-btn"></span></a> 
        <?php else: ?> 
        <a class="prev"><span class="icon prev-disabled"></span></a> 
        <?php endif; ?> 
        <span class="text"><font class="main-color"><?php echo $this->_var['pager']['page']; ?></font>/<?php echo $this->_var['pager']['page_count']; ?></span> 
        <?php if ($this->_var['pager']['page_next']): ?> 
        <a href="<?php echo $this->_var['pager']['page_next']; ?>" class="next"><span class="icon next-btn"></span></a> 
        <?php else: ?> 
        <a class="next"><span class="icon next-disabled"></span></a> 
        <?php endif; ?> 
      </div>
      <div class="total">共<span class="main-color"><?php echo $this->_var['pager']['record_count']; ?></span>个商品</div>
    </div>
    <div class="fore2">
      <div class="filter-btn"><?php if ($this->_var['script_name'] != 'brand'): ?> <a class="filter-tag <?php if ($this->_var['is_stock'] == 1): ?>curr<?php endif; ?>" href="<?php echo $this->_var['script_name']; ?>.php?in_stock=1&category=<?php echo $this->_var['category']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&brand=<?php echo $this->_var['brand_id']; ?>&price_min=<?php echo $this->_var['price_min']; ?>&price_max=<?php echo $this->_var['price_max']; ?>&filter=<?php echo $this->_var['filterid']; ?>&filter_attr=<?php echo $this->_var['filter_attr']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&is_stock=1&sort=<?php echo $this->_var['pager']['sort']; ?>&order=<?php echo $this->_var['pager']['order']; ?>#goods_list" rel='nofollow'><i class="icon"></i><span class="text">仅显示有货</span></a> <?php endif; ?>
        <?php $_from = $this->_var['filterinfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'filter');if (count($_from)):
    foreach ($_from AS $this->_var['filter']):
?> 
        <a href="<?php echo $this->_var['filter']['url']; ?>" class="filter-tag-radio <?php if ($this->_var['filter']['selected']): ?>curr<?php endif; ?>"> <input class="none" type="radio" name="fff" onclick="top.location.href='<?php echo $this->_var['filter']['url']; ?>'" <?php if ($this->_var['filter']['selected']): ?>checked<?php endif; ?>> <i class="icon"></i> <span class="text"><?php echo $this->_var['filter']['name']; ?></span> </a> 
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      </div>
      <div class="filter-mod"> <a href="javascript:;" onClick="javascript:display_mode('list')" title="列表显示" class="filter-type filter-type-list <?php if ($this->_var['pager']['display'] == 'list'): ?>curr<?php endif; ?>"><span class="filter-type-icon"></span></a> <a href="javascript:;" onClick="javascript:display_mode('grid')" title="表格显示" class="filter-type filter-type-grid <?php if ($this->_var['pager']['display'] == 'grid'): ?>curr<?php endif; ?>"><span class="filter-type-icon"></span></a> <a href="javascript:;" onClick="javascript:display_mode('text')" title="文本显示" class="filter-type filter-type-text <?php if ($this->_var['pager']['display'] == 'text'): ?>curr<?php endif; ?>"><span class="filter-type-icon"></span></a> </div>
    </div>
    <input type="hidden" name="category" value="<?php echo $this->_var['category']; ?>" />
    <input type="hidden" name="display" value="<?php echo $this->_var['pager']['display']; ?>" id="display" />
    <input type="hidden" name="brand" value="<?php echo $this->_var['brand_id']; ?>" />
    <input type="hidden" name="price_min" value="<?php echo $this->_var['price_min']; ?>" />
    <input type="hidden" name="price_max" value="<?php echo $this->_var['price_max']; ?>" />
    <input type="hidden" name="filter_attr" value="<?php echo $this->_var['filter_attr']; ?>" />
    <input type="hidden" name="page" value="<?php echo $this->_var['pager']['page']; ?>" />
    <input type="hidden" name="sort" value="<?php echo $this->_var['pager']['sort']; ?>" />
    <input type="hidden" name="order" value="<?php echo $this->_var['pager']['order']; ?>" />
  </form>
</div>
<?php if ($this->_var['goods_list']): ?> 
<form name="compareForm" action="compare.php" method="post" onSubmit="return compareGoods(this);">
  <?php if ($this->_var['pager']['display'] == 'list'): ?>
  <div class="goodsList clearfix"> 
    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_0_27538600_1490260561');$this->_foreach['goods_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods_list']['total'] > 0):
    foreach ($_from AS $this->_var['goods_0_27538600_1490260561']):
        $this->_foreach['goods_list']['iteration']++;
?> 
    <ul class="clearfix <?php if ($this->_foreach['goods_list']['iteration'] % 2 == 0): ?>bgcolor<?php endif; ?> <?php if (($this->_foreach['goods_list']['iteration'] == $this->_foreach['goods_list']['total'])): ?>last<?php endif; ?>">
    	<li class="thumb"> <a href="<?php echo $this->_var['goods_0_27538600_1490260561']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['goods_0_27538600_1490260561']['goods_thumb']; ?>" title="<?php echo htmlspecialchars($this->_var['goods_0_27538600_1490260561']['name']); ?>" class="pic_img_<?php echo $this->_var['goods_0_27538600_1490260561']['goods_id']; ?>"/></a> </li>
        <li class="goodsName"> <a href="<?php echo $this->_var['goods_0_27538600_1490260561']['url']; ?>" target="_blank"> 
          <?php if ($this->_var['goods_0_27538600_1490260561']['goods_style_name']): ?> 
          <?php echo $this->_var['goods_0_27538600_1490260561']['goods_style_name']; ?><br />
          <?php else: ?> 
          <?php echo $this->_var['goods_0_27538600_1490260561']['goods_name']; ?><br />
          <?php endif; ?> 
          </a> 
          <?php if ($this->_var['goods_0_27538600_1490260561']['goods_brief']): ?> 
          <?php echo $this->_var['lang']['goods_brief']; ?><?php echo $this->_var['goods_0_27538600_1490260561']['goods_brief']; ?><br />
          <?php endif; ?> 
        </li>
        <li class="list_price"> 
          <?php if ($this->_var['show_marketprice']): ?> 
          <?php echo $this->_var['lang']['market_price']; ?><font class="market"><?php echo $this->_var['goods_0_27538600_1490260561']['market_price']; ?></font><br />
          <?php endif; ?> 
          <?php if ($this->_var['goods_0_27538600_1490260561']['promote_price'] != ""): ?> 
          <?php echo $this->_var['lang']['promote_price']; ?><font class="shop"><?php echo $this->_var['goods_0_27538600_1490260561']['promote_price']; ?></font><br />
          <?php else: ?> 
          <?php echo $this->_var['lang']['shop_price']; ?><font class="shop"><?php echo $this->_var['goods_0_27538600_1490260561']['shop_price']; ?></font><br />
          <?php endif; ?> 
        </li>
        <li class="action"> 
          <a href="javascript:collect(<?php echo $this->_var['goods_0_27538600_1490260561']['goods_id']; ?>);" class="action-btn collet-btn">收藏</a>
          <?php if ($this->_var['goods_0_27538600_1490260561']['goods_number'] == 0): ?>
          <a href="javascript:tell_me(<?php echo $this->_var['goods_0_27538600_1490260561']['goods_id']; ?>);" class="action-btn addcart-btn sell-over">到货通知</a>
          <?php else: ?>
          <a href="javascript:addToCart(<?php echo $this->_var['goods_0_27538600_1490260561']['goods_id']; ?>);" nctype="add_cart" class="action-btn addcart-btn">加入购物车</a>
          <?php endif; ?>
        </li>
    	<?php if ($this->_var['goods_0_27538600_1490260561']['goods_number'] == 0): ?>
      	<li class="sell-over"></li>
      	<?php endif; ?> 
    </ul>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  </div>
  <?php elseif ($this->_var['pager']['display'] == 'grid'): ?>
  <ul class="list-grid clearfix">
      <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_0_27580400_1490260561');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['goods_0_27580400_1490260561']):
        $this->_foreach['name']['iteration']++;
?> 
      <?php if ($this->_var['goods_0_27580400_1490260561']['goods_id']): ?>
      <li class="item<?php if ($this->_foreach['name']['iteration'] % 4 == 0): ?> last<?php endif; ?>"  id="li_<?php echo $this->_var['goods_0_27580400_1490260561']['goods_id']; ?>">
        <div class="item-con"> 
          <div class="item-tag-box">
          <?php if ($this->_var['goods_0_27580400_1490260561']['is_hot'] == 1): ?><div class="item-tag"><span>爆款</span><i></i></div><?php elseif ($this->_var['goods_0_27580400_1490260561']['is_best'] == 1): ?><div class="item-tag"><span>精品</span><i></i></div><?php elseif ($this->_var['goods_0_27580400_1490260561']['is_new'] == 1): ?><div class="item-tag"><span>新品</span><i></i></div><?php endif; ?>
          </div>
          <div class="item-pic">
          	<a href="<?php echo $this->_var['goods_0_27580400_1490260561']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods_0_27580400_1490260561']['name']); ?>" target="_blank">
            	<img data-original="<?php echo $this->_var['goods_0_27580400_1490260561']['goods_thumb']; ?>" src="themes/68ecshopcom_360buy/images/loading.gif" title="<?php echo htmlspecialchars($this->_var['goods_0_27580400_1490260561']['name']); ?>" class="pic_img_<?php echo $this->_var['goods_0_27580400_1490260561']['goods_id']; ?>"/>
            </a>
          </div>
          <?php if ($this->_var['goods_0_27580400_1490260561']['goods_number'] == 0): ?><a href="<?php echo $this->_var['goods_0_27580400_1490260561']['url']; ?>" target="_blank" class="shop-over"></a><?php endif; ?>
          <div class="item-info">
          	<div class="item-price">
            	<em class="sale-price main-color" title="本店价：<?php if ($this->_var['goods_0_27580400_1490260561']['promote_price'] != ""): ?><?php echo $this->_var['goods_0_27580400_1490260561']['promote_price']; ?><?php else: ?><?php echo $this->_var['goods_0_27580400_1490260561']['shop_price']; ?><?php endif; ?>"><?php if ($this->_var['goods_0_27580400_1490260561']['promote_price'] != ""): ?><?php echo $this->_var['goods_0_27580400_1490260561']['promote_price']; ?><?php else: ?><?php echo $this->_var['goods_0_27580400_1490260561']['shop_price']; ?><?php endif; ?></em>
                <em class="sale-count">已售<?php echo $this->_var['goods_0_27580400_1490260561']['count']; ?>件</em>
            </div>
            <div class="item-name">
            	<a href="<?php echo $this->_var['goods_0_27580400_1490260561']['url']; ?>" target="_blank" title="<?php echo htmlspecialchars($this->_var['goods_0_27580400_1490260561']['name']); ?>"><?php echo htmlspecialchars($this->_var['goods_0_27580400_1490260561']['name']); ?></a>
            </div>
            <div class="item-operate">
            	<a class="operate-btn compare-btn" data-goods="<?php echo $this->_var['goods_0_27580400_1490260561']['goods_id']; ?>" data-type="<?php echo $this->_var['goods_0_27580400_1490260561']['type']; ?>" onclick="Compare.add(<?php echo $this->_var['goods_0_27580400_1490260561']['goods_id']; ?>,'<?php echo htmlspecialchars($this->_var['goods_0_27580400_1490260561']['name']); ?>','<?php echo $this->_var['goods_0_27580400_1490260561']['type']; ?>', '<?php echo $this->_var['goods_0_27580400_1490260561']['goods_thumb']; ?>', '<?php echo $this->_var['goods_0_27580400_1490260561']['shop_price']; ?>')"><i></i>对比</a>
            	<a id="collect_<?php echo $this->_var['goods_0_27580400_1490260561']['goods_id']; ?>" href="javascript:collect(<?php echo $this->_var['goods_0_27580400_1490260561']['goods_id']; ?>); re_collect(<?php echo $this->_var['goods_0_27580400_1490260561']['goods_id']; ?>)" class="operate-btn collet-btn <?php if ($this->_var['goods_0_27580400_1490260561']['is_collet'] == 1): ?>curr<?php endif; ?>"><i></i>收藏</a>
                <a href="<?php echo $this->_var['goods_0_27580400_1490260561']['url']; ?>#os_pinglun" target="_blank" class="operate-btn comment-btn"><i></i><?php echo $this->_var['goods_0_27580400_1490260561']['comment_count']; ?></a> 
                <?php if ($this->_var['goods_0_27580400_1490260561']['goods_number'] == 0): ?>
                <a href="javascript:tell_me(<?php echo $this->_var['goods_0_27580400_1490260561']['goods_id']; ?>);" class="add-cart tell-me" title="到货通知"></a>
                <?php else: ?>
                <a href="javascript:addToCart(<?php echo $this->_var['goods_0_27580400_1490260561']['goods_id']; ?>);" class="add-cart" title="加入购物车"></a>
                <?php endif; ?>
            </div>
          </div>
        </div>
      </li>
      <?php endif; ?> 
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
  <?php elseif ($this->_var['pager']['display'] == 'text'): ?>
  <div class="goodsList clearfix"> 
    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_0_27637200_1490260561');$this->_foreach['goods_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods_list']['total'] > 0):
    foreach ($_from AS $this->_var['goods_0_27637200_1490260561']):
        $this->_foreach['goods_list']['iteration']++;
?>
    <ul class="clearfix<?php if ($this->_foreach['goods_list']['iteration'] % 2 == 0): ?> bgcolor<?php endif; ?><?php if (($this->_foreach['goods_list']['iteration'] == $this->_foreach['goods_list']['total'])): ?> last<?php endif; ?>">
      <li class="goodsName">
      	<a href="<?php echo $this->_var['goods_0_27637200_1490260561']['url']; ?>" target="_blank"> 
        <?php if ($this->_var['goods_0_27637200_1490260561']['goods_style_name']): ?> 
        <?php echo $this->_var['goods_0_27637200_1490260561']['goods_style_name']; ?><br />
        <?php else: ?> 
        <?php echo $this->_var['goods_0_27637200_1490260561']['goods_name']; ?><br />
        <?php endif; ?> 
        </a> 
        <?php if ($this->_var['goods_0_27637200_1490260561']['goods_brief']): ?> 
        <?php echo $this->_var['lang']['goods_brief']; ?><?php echo $this->_var['goods_0_27637200_1490260561']['goods_brief']; ?><br />
        <?php endif; ?> 
      </li>
      <li class="list_price"> 
        <?php if ($this->_var['show_marketprice']): ?> 
        <?php echo $this->_var['lang']['market_price']; ?><font class="market"><?php echo $this->_var['goods_0_27637200_1490260561']['market_price']; ?></font><br />
        <?php endif; ?> 
        <?php if ($this->_var['goods_0_27637200_1490260561']['promote_price'] != ""): ?> 
        <?php echo $this->_var['lang']['promote_price']; ?><font class="shop"><?php echo $this->_var['goods_0_27637200_1490260561']['promote_price']; ?></font><br />
        <?php else: ?> 
        <?php echo $this->_var['lang']['shop_price']; ?><font class="shop"><?php echo $this->_var['goods_0_27637200_1490260561']['shop_price']; ?></font><br />
        <?php endif; ?> 
      </li>
      <li class="action"> 
        <a href="javascript:collect(<?php echo $this->_var['goods_0_27637200_1490260561']['goods_id']; ?>);" class="action-btn collet-btn">收藏</a> 
        <?php if ($this->_var['goods_0_27637200_1490260561']['goods_number'] == 0): ?>
        <a href="javascript:tell_me(<?php echo $this->_var['goods_0_27637200_1490260561']['goods_id']; ?>);" class="action-btn addcart-btn sell-over">到货通知</a>
        <?php else: ?>
        <a href="javascript:addToCart(<?php echo $this->_var['goods_0_27637200_1490260561']['goods_id']; ?>);" nctype="add_cart" class="action-btn addcart-btn">加入购物车</a>
      	<?php endif; ?>
      </li>
    </ul>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  </div>
  <?php endif; ?> 
</form>
<?php else: ?>
<div class="tip-box">
  <i class="tip-icon"></i>
  <div class="tip-text">抱歉！没有搜索到您想要的结果……</div>
</div>
<?php endif; ?>
<script type="Text/Javascript" language="JavaScript">
<!--

re_collect();

function re_collect(id){
  goods_id = (typeof(id) == "undefined" ? 0 : id);
  Ajax.call('user.php?act=re_collect', 'id=' + goods_id, re_collectResponse, 'GET', 'JSON');
}

function re_collectResponse(result){
  if (result.goods_id > 0){
    document.getElementById("collect_" + result.goods_id).className = (result.is_collect == 1 ? "operate-btn collet-btn curr" : "operate-btn collet-btn");
  }else{
    $("a[id^='collect_']").className = "operate-btn collet-btn";
    for(i = 0; i < result.is_collect.length; i++){
      document.getElementById("collect_" + result.is_collect[i]).className = "operate-btn collet-btn curr";
    }
  }
}
function selectPage(sel){
  sel.form.submit();
}

//-->
</script> 
<script type="text/javascript">
window.onload = function(){
  Compare.init();
  fixpng();
}
<?php $_from = $this->_var['lang']['compare_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
<?php if ($this->_var['key'] != 'button_compare'): ?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php else: ?>
var button_compare = '';
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var compare_no_goods = "<?php echo $this->_var['lang']['compare_no_goods']; ?>";
var btn_buy = "<?php echo $this->_var['lang']['btn_buy']; ?>";
var is_cancel = "<?php echo $this->_var['lang']['is_cancel']; ?>";
var select_spe = "<?php echo $this->_var['lang']['select_spe']; ?>";
</script> 
 
<script type="text/javascript" src="js/json2.js"></script> 
<div id="compareBox">
  <div class="menu">
    <ul>
      <li class="current" data-value='compare'>对比栏</li>
      <li data-value='history'>最近浏览</li>
    </ul>
    <a class="hide-compare" href="javascript:;" title="隐藏"></a>
    <div style="clear:both"></div>
  </div>
  <div id="compareList"></div>
  <div id="historyList" style="display:none;">
  	<span id="sc-prev" class="sc-prev scroll-btn"></span>
    <span id="sc-next" class="sc-next scroll-btn"></span>
    <div class="scroll_wrap"> <?php 
$k = array (
  'name' => 'history_list',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?> </div>
  </div>
</div>
<script>
$(function(){
	<?php if (! $_SESSION['user_id'] > 0): ?>
	$('.collet-btn').click(function(){
		$('.pop-login,.pop-mask').show();	
	})
	<?php endif; ?>
	var scroll_height = $('#filter').offset().top;
	$(window).scroll(function(){
		var this_scrollTop = $(this).scrollTop();
		if(this_scrollTop > scroll_height){
			$('#filter').addClass('filter-fixed').css({'left':($(window).width()-$('.filter-fixed').outerWidth())/2});
		}else{
			$('#filter').removeClass('filter-fixed').css('left','');	
		}
	})	
})
</script>
 

