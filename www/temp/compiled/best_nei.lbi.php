<?php if ($this->_var['best_goods']): ?>
<div id="hotsale">
    <div class="hd">热卖推荐</div>
    <div class="mc">
      <?php $_from = $this->_var['best_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['best_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['best_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['best_goods']['iteration']++;
?>
      <dl>
        <dt><a target="_blank" href='<?php echo $this->_var['goods']['url']; ?>'><img src="<?php echo $this->_var['goods']['thumb']; ?>" width="100" height="100" alt='<?php echo htmlspecialchars($this->_var['goods']['name']); ?>' /></a></dt>
        <dd>
          <div class="p-name"><a target="_blank" href='<?php echo $this->_var['goods']['url']; ?>'><?php echo sub_str($this->_var['goods']['name'],20); ?></a></div>
          <div class="p-price" >特价：<font class="shop-price">
            <?php if ($this->_var['goods']['promote_price'] != ""): ?>
            <?php echo $this->_var['goods']['promote_price']; ?>
            <?php else: ?>
            <?php echo $this->_var['goods']['shop_price']; ?>
            <?php endif; ?>
            </font></div>
          <div class="btns"><a target="_blank" href='<?php echo $this->_var['goods']['url']; ?>'>查看详情</a></div>
        </dd>
      </dl>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
</div>
<?php endif; ?>
