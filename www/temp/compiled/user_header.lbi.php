<div id="site-nav">
  <div class="sn-container w1210"> 
    <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js,common.min.js')); ?> 
    <font id="login-info" class="sn-login-info"><?php 
$k = array (
  'name' => 'member_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></font>
    <ul class="sn-quick-menu">
      <li class="sn-mytaobao menu-item">
        <div class="sn-menu"> 
          <a class="menu-hd" href="user.php" target="_top" rel="nofollow">我的信息<b></b></a>
          <div id="menu-2" class="menu-bd">
            <div class="menu-bd-panel"> 
            	<a href="user.php?act=order_list" target="_top" rel="nofollow">已买到的宝贝</a> 
                <a href="user.php?act=address_list" target="_top" rel="nofollow">我的地址管理</a> 
            </div>
          </div>
        </div>
      </li>
      <li class="sn-mystores"> 
      </li>
      <li class="sn-cart mini-cart menu"> 
        <a id="mc-menu-hd" class="sn-cart header-icon main-color" href="flow.php" target="_top" rel="nofollow"><i></i>购物车</a> 
      </li>
      <li class="sn-favorite menu-item">
        <div class="sn-menu"> 
          <a class="menu-hd" href="user.php?act=collection_list" target="_top" rel="nofollow">收藏夹<b></b></a>
          <div id="menu-4" class="menu-bd">
            <div class="menu-bd-panel"> 
            	<a href="user.php?act=collection_list" target="_top" rel="nofollow">收藏的宝贝</a> 
            </div>
          </div>
        </div>
      </li>
      <li class="sn-separator"></li>
      <script type="text/javascript">
		function show_qcord(){
			var qs=document.getElementById('sn-qrcode');
			qs.style.display="block";
		}
		function hide_qcord(){
			var qs=document.getElementById('sn-qrcode');
			qs.style.display="none";
		}
	  </script>
      <li class="menu-item">
        <div class="sn-menu"> 
          <a class="menu-hd sn-mobile" href="" target="_top">手机版<b></b></a>
          <div class="menu-bd sn-qrcode" id="menu-5">
            <ul>
              <li class="app_down"> 
              	<a href="#" target="_top" class="app_store">
                	<p>手机客户端</p>
                </a> 
              </li>
            </ul>
          </div>
        </div>
      </li>
      <li class="sn-seller menu-item">
        <div class="sn-menu">
        <div class="menu-bd" id="menu-6">
          <ul>
            <li>
              <h3>商家：</h3>
              <?php $_from = $this->_var['navigator_list']['top']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_top_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_top_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_top_list']['iteration']++;
?> 
              <a href="<?php echo $this->_var['nav']['url']; ?>" <?php if ($this->_var['nav']['opennew'] == 1): ?>target="_blank" <?php endif; ?>><?php echo $this->_var['nav']['name']; ?></a> 
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
            </li>
            <li>
              <h3>帮助：</h3>
              <a href="help.php" target="_top" title="帮助中心">帮助中心</a> 
            </li>
          </ul>
        </div>
        </div>
      </li>
    </ul>
  </div>
</div>
<script>
header_login();
function header_login()
{	
	Ajax.call('login_act_ajax.php', '', loginactResponse, 'GET', 'JSON', '1', '1');
}
function loginactResponse(result)
{
	var MEMBERZONE =document.getElementById('login-info');
	MEMBERZONE.innerHTML= result.memberinfo;
}
</script>