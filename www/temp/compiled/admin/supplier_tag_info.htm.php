<!-- $Id: user_rank_info.htm 15053 2008-10-25 03:07:46Z testyang $ -->
<?php echo $this->fetch('pageheader.htm'); ?>

<div class="main-div">
<form action="supplier_tag.php" method="post" name="theForm" onsubmit="return validate()">
<table width="100%">
  <tr>
    <td class="label"><?php echo $this->_var['lang']['tag_name']; ?>: </td>
    <td><input type="text" name="tag_name" value="<?php echo $this->_var['tag']['tag_name']; ?>"  maxlength="20" /><?php echo $this->_var['lang']['require_field']; ?></td>
  </tr> 
  <tr>
    <td class="label"><?php echo $this->_var['lang']['sort_order']; ?>: </td>
    <td><input type="text" name="sort_order" value="<?php echo $this->_var['tag']['sort_order']; ?>" maxlength="20" /><?php echo $this->_var['lang']['require_field']; ?></td>
  </tr>
  <tr>
        <td class="label"><?php echo $this->_var['lang']['is_groom']; ?>:</td>
        <td><input type="radio" name="is_groom"  value="1" <?php if ($this->_var['tag']['is_groom'] != 0): ?> checked="true"<?php endif; ?>/>
          <?php echo $this->_var['lang']['yes']; ?>
          <input type="radio" name="is_groom"  value="0" <?php if ($this->_var['tag']['is_groom'] == 0): ?> checked="true"<?php endif; ?> />
          <?php echo $this->_var['lang']['no']; ?> 
		</td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <input type="hidden" name="act" value="<?php echo $this->_var['form_action']; ?>" />
      <input type="hidden" name="id" value="<?php echo $this->_var['tag']['tag_id']; ?>" />
      <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />
      <input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" class="button" />
    </td>
  </tr>
</table>
</form>
</div>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,validator.js')); ?>

<script language="JavaScript">
<!--
document.forms['theForm'].elements['tag_name'].focus();

onload = function()
{
  // 开始检查订单
  startCheckOrder();
}

/**
 * 检查表单输入的数据
 */
function validate()
{

    validator = new Validator("theForm");
    validator.required('tag_name', tag_name_empty);
    validator.isInt('sort_order', sort_order_invalid, true);
    return validator.passed();
}


//-->
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>