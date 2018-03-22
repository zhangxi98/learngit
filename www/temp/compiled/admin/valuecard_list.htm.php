<!-- $Id: valuecard_list.htm 14216 2008-03-10 02:27:21Z testyang $ -->

<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<!-- 订单搜索 -->
<div class="form-div">
  <form action="javascript:searchVc()" name="searchForm">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    <?php echo $this->_var['lang']['vc_sn']; ?><input name="vc_sn" type="text" id="vc_sn" size="15">
    <?php echo $this->_var['lang']['is_used']; ?>
    <select name="is_used" id="is_used">
      <option value="-1"><?php echo $this->_var['lang']['select_please']; ?></option>
	  <option value="0">未使用</option>
	  <option value="1">已使用</option>
    </select>
    <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
  </form>
</div>

<form method="POST" action="valuecard.php?act=batch&vc_type=<?php echo $_GET['vc_type']; ?>" name="listForm">
<!-- start user_bonus list -->
<div class="list-div" id="listDiv">
<?php endif; ?>

  <table cellpadding="3" cellspacing="1">
    <tr>
      <th>
        <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox">
        <?php echo $this->_var['lang']['bonus_sn']; ?></th>
      <th><?php echo $this->_var['lang']['vc_pwd']; ?></th>
      <th><?php echo $this->_var['lang']['type_money']; ?></th>
      <th><?php echo $this->_var['lang']['use_date_valid']; ?></th>
      <th><?php echo $this->_var['lang']['add_time']; ?></th>
	  <th><?php echo $this->_var['lang']['is_used']; ?></th>
	  <th><?php echo $this->_var['lang']['user_name']; ?></th>
	  <th><?php echo $this->_var['lang']['used_time']; ?></th>
      <th><?php echo $this->_var['lang']['handler']; ?></th>
    </tr>
    <?php $_from = $this->_var['vc_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'bonus');if (count($_from)):
    foreach ($_from AS $this->_var['bonus']):
?>
    <tr>
      <td><span><input value="<?php echo $this->_var['bonus']['vc_id']; ?>" name="checkboxes[]" type="checkbox"><?php echo $this->_var['bonus']['vc_sn']; ?></span></td>      
      <td><?php echo $this->_var['bonus']['vc_pwd']; ?></td>      
      <td align=center><?php echo $this->_var['vctype']['type_money_format']; ?></td>
      <td align=center><?php echo $this->_var['vctype']['valid_time']; ?></td>
      <td align=center><?php echo $this->_var['bonus']['add_time_format']; ?></td>
	  <td align=center><?php echo $this->_var['bonus']['is_used']; ?></td>
	  <td align=center><?php echo $this->_var['bonus']['user_name']; ?></td>
	  <td align=center><?php echo $this->_var['bonus']['used_time_format']; ?></td>
      <td align="center">
        <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['bonus']['vc_id']; ?>, '<?php echo $this->_var['lang']['drop_confirm']; ?>', 'remove_bonus')"><img src="images/icon_drop.gif" border="0" height="16" width="16"></a>
        </td>
    </tr>
    <?php endforeach; else: ?>
    <tr><td class="no-records" colspan="11"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>

  <table cellpadding="4" cellspacing="0">
    <tr>
      <td><input type="submit" name="drop" id="btnSubmit" value="<?php echo $this->_var['lang']['drop']; ?>" class="button" disabled="true" />
      <?php if ($this->_var['show_mail']): ?><input type="submit" name="mail" id="btnSubmit1" value="<?php echo $this->_var['lang']['send_mail']; ?>" class="button" disabled="true" /><?php endif; ?></td>
      <td align="right"><?php echo $this->fetch('page.htm'); ?></td>
    </tr>
  </table>

<?php if ($this->_var['full_page']): ?>
</div>
<!-- end user_bonus list -->
</form>

<script type="text/javascript" language="JavaScript">
  listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
  listTable.pageCount = <?php echo $this->_var['page_count']; ?>;
  listTable.query = "query_bonus";

  <?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
  listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

  
  onload = function()
  {
    // 开始检查订单
    startCheckOrder();
    document.forms['listForm'].reset();
  }

    function searchVc()
    {
        listTable.filter['vc_sn'] = Utils.trim(document.forms['searchForm'].elements['vc_sn'].value);
        listTable.filter['is_used'] = document.forms['searchForm'].elements['is_used'].value;
        listTable.filter['page'] = 1;
        listTable.loadList();
    }

  
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>