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
<link rel="stylesheet" type="text/css" href="themes/68ecshopcom_360buy/css/user.css" />
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery.validate.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/messages_zh.js"></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,user.js')); ?>
<?php if ($this->_var['action'] == 'account_security' || $this->_var['action'] == 'order_detail'): ?>
<script lang='javascript' type='text/javascript'>
var action = '';

function open_surplus_window() {
  if(action == 'close_surplus' || action == 'verify_surplus'){
    if(action == 'close_surplus'){
	document.getElementById("surplus_label2").style.display="none";
	document.getElementById("surplus_password_input2").style.display="none";
    }
    document.getElementById("popup_window").style.display = "";
  }
  else if(action == 'open_surplus'){
    document.getElementById("popup_window").style.display = "";
    document.getElementById("surplus_label2").style.display = "";
    document.getElementById("surplus_password_input2").style.display = "";
  }
}

function close_surplus_window(){
  document.getElementById("surplus_password_input1").value="";
  document.getElementById("surplus_password_input2").value="";
  document.getElementById("popup_window").style.display="none";
  document.getElementById("surplus_label2").style.display="none";
  document.getElementById("surplus_password_input2").style.display="none";
  action = '';
}

function open_surplus(){
  action = 'open_surplus';
  open_surplus_window();
}

function close_surplus(){
  action = 'close_surplus';
  open_surplus_window();
}

function end_input_surplus(){
  if(action == 'open_surplus'){
    var pwd1 = document.getElementById("surplus_password_input1").value;
    var pwd2 = document.getElementById("surplus_password_input2").value;
    var msg = '';
    if(pwd1 !== pwd2){
      msg = "密码不匹配\n";
    }
    if(pwd1.length < 6){
      msg = msg + "您输入的密码太短\n"
    }

    if(msg.length > 0){
      alert(msg);
    }else{
      Ajax.call('user.php?act=open_surplus_password','surplus_password='+pwd1,open_surplus_response,'GET','TEXT',true,true);
    }
  }else if(action == 'close_surplus'){
    var pwd1 = document.getElementById("surplus_password_input1").value;
    Ajax.call('user.php?act=close_surplus_password','surplus_password='+pwd1,close_surplus_response,'GET','TEXT',true,true);
  }else if(action == 'verify_surplus'){
    var pwd1 = document.getElementById("surplus_password_input1").value;
    Ajax.call('user.php?act=verify_surplus_password','surplus_password='+pwd1,verify_surplus_response,'GET','TEXT',true,true);
  }
}

function cancel_input_surplus(){
  close_surplus_window();
}

function open_surplus_response(obj){
  if(obj == 1){
    window.location="user.php?act=account_security";
  }else{
    close_surplus_window();
    alert('开启失败！');
  }
}

function close_surplus_response(obj){
  if(obj == 1){
    window.location="user.php?act=account_security";
  }else{
    close_surplus_window();
    alert('关闭失败！');

  }
}

function verify_surplus_response(result){
  if(result == 1){
    submit_surplus_form();
  }else{
    alert('密码错误！');
  }
}

function check_surplus_open(form){
  var surplus = form[0].value;
  if(surplus > 0){
	var order_amount=$("#order_amount").val();
  	if(surplus>order_amount){
		$('.pop-compare,.pop-mask').show();
		$('.pop-compare .pop-text').html('输入的余额应小于等于应付款金额').css({'padding-top':20,'padding-bottom':20});
		$('.pop-compare').css({'top':($(window).height()-$('.pop-compare').outerHeight())/2});	
	   	//alert('输入的余额应小于等于应付款金额！');
 	 }else{
		Ajax.call("user.php?act=check_surplus_open","",check_surplus_open_response,"GET",true,true);
	 }
   
  }else{  
  	$('.pop-compare,.pop-mask').show();
	$('.pop-compare .pop-text').html('输入的余额必须大于零').css({'padding-top':20,'padding-bottom':20});
	$('.pop-compare').css({'top':($(window).height()-$('.pop-compare').outerHeight())/2});	
	//alert('输入的余额必须大于零！');
  }
  return false;
}

function check_surplus_open_response(result){
  if(result == '1'){
    action = 'verify_surplus';
    open_surplus_window();
  }else{
    submit_surplus_form();
  }
}

function submit_surplus_form(){
  document.getElementById("formFee").submit();
}
</script>
<?php endif; ?>
</head>
<body>

<div class="pop-mask"></div>
<div class="pop-main pop-compare">
	<div class="pop-header">
    	<span>温馨提示</span>
        <a class="pop-close" href="javascript:;" title="关闭"></a>
    </div>
    <div class="pop-con">
    	<i class="pop-icon"></i>
        <p class="pop-text"></p>
        <a href="javascript:;" class="pop-sure main-bg-color">确定</a><a class="cancel-btn none">取消</a>
    </div>
</div>
<?php if ($this->_var['action'] == 'account_security' || $this->_var['action'] == 'order_detail'): ?> 
	<?php echo $this->fetch('library/balance_payment.lbi'); ?>
<?php endif; ?>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="margin-w1210 clearfix"> 
	<?php echo $this->fetch('library/ur_here.lbi'); ?> 
    <div class="user-left">
		<?php echo $this->fetch('library/user_info.lbi'); ?> 
		<?php echo $this->fetch('library/user_menu.lbi'); ?> 
    </div>
    <div class="user-right">
    	<div class="box">
    	 
        <?php if ($this->_var['action'] == 'profile'): ?> 
          <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?> 
          <script type="text/javascript">
          <?php $_from = $this->_var['lang']['profile_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
            var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </script> 
          <script type="text/javascript">
			function setTabCatGoods(name,cursel,n){
				for(i=1;i<=n;i++){
					var menu=document.getElementById(name+i);
					var con=document.getElementById("con_"+name+"_"+i);
					con.style.display=i==cursel?"block":"none";
					menu.className=i==cursel?"active":"";
				}
			}
		  </script>
          <div class="tabmenu">
            <ul class="tab">
              <li class="active" id="tab1" onClick="setTabCatGoods('tab',1,3)">基本信息</li>
              <li class="normal" id="tab2" onClick="setTabCatGoods('tab',2,3)">更换头像</li>
              <li class="normal" id="tab3" onClick="setTabCatGoods('tab',3,3)">实名认证</li>
            </ul>
          </div>
          <div class="ncm-user-profile">
            <div class="ncm-default-form"  id="con_tab_1">
              <form name="formEdit" action="user.php" method="post" onSubmit="return userEdit()">
                <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eee">
                    <tr>
                      <td width="35%" align="right">用户名称：</td>
                      <td width="65%" align="left">
                      	<input type="text" name="username" value="<?php echo $this->_var['profile']['user_name']; ?>" onblur="check_username(this.value)" size="25" class="inputBg" style="ime-mode:disabled" />
                        <span id="username_message" style="color:#E31939"></span>
                      </td>
                    </tr>
                    <tr>
                      <td align="right">出生日期：</td>
                      <td align="left"> 
                      	<?php echo $this->html_select_date(array('field_order'=>'YMD','prefix'=>'birthday','start_year'=>'-60','end_year'=>'+1','display_days'=>'true','month_format'=>'%m','day_value_format'=>'%02d','time'=>$this->_var['profile']['birthday'])); ?> 
                      </td>
                    </tr>
                    <tr>
                      <td align="right">性别：</td>
                      <td align="left">
                        <label>
                          <input type="radio" name="sex" value="0" <?php if ($this->_var['profile']['sex'] == 0): ?>checked="checked"<?php endif; ?> />
                          <?php echo $this->_var['lang']['secrecy']; ?>&nbsp;&nbsp; </label>
                        <label>
                          <input type="radio" name="sex" value="1" <?php if ($this->_var['profile']['sex'] == 1): ?>checked="checked"<?php endif; ?> />
                          <?php echo $this->_var['lang']['male']; ?>&nbsp;&nbsp; </label>
                        <label>
                          <input type="radio" name="sex" value="2" <?php if ($this->_var['profile']['sex'] == 2): ?>checked="checked"<?php endif; ?> />
                          <?php echo $this->_var['lang']['female']; ?> </label>
                       </td>
                    </tr>
                    <?php $_from = $this->_var['extend_info_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['field']):
?> 
                    <?php if ($this->_var['field']['id'] == 6): ?>
                    <tr>
                      <td align="right"><?php echo $this->_var['lang']['passwd_question']; ?>：</td>
                      <td align="left"><select name='sel_question'>
                          <option value='0'><?php echo $this->_var['lang']['sel_question']; ?></option>
                          
              <?php echo $this->html_options(array('options'=>$this->_var['passwd_questions'],'selected'=>$this->_var['profile']['passwd_question'])); ?>              
                        
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td align="right" <?php if ($this->_var['field']['is_need']): ?>id="passwd_quesetion"<?php endif; ?>><?php echo $this->_var['lang']['passwd_answer']; ?>：</td>
                      <td align="left"><input name="passwd_answer" type="text" size="25" class="inputBg" maxlengt='20' value="<?php echo $this->_var['profile']['passwd_answer']; ?>"/>
                        
                        <?php if ($this->_var['field']['is_need']): ?><span style="color:#DD0000"> *</span><?php endif; ?></td>
                    </tr>
                    <?php else: ?>
                    <tr>
                      <td align="right" <?php if ($this->_var['field']['is_need']): ?>id="extend_field<?php echo $this->_var['field']['id']; ?>i"<?php endif; ?>><?php echo $this->_var['field']['reg_field_name']; ?>：</td>
                      <td align="left"><input name="extend_field<?php echo $this->_var['field']['id']; ?>" type="text" class="inputBg" value="<?php echo $this->_var['field']['content']; ?>" <?php if ($this->_var['field']['id'] == 5): ?> readonly="readonly"<?php endif; ?>/>
                        
                        <?php if ($this->_var['field']['is_need']): ?><span style="color:#DD0000"> *</span><?php endif; ?></td>
                    </tr>
                    <?php endif; ?> 
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <tr>
                      	<td colspan="2" align="center">
                        	<label class="submit-border">
                          		<input name="act" type="hidden" value="act_edit_profile" />
                          		<input name="submit" type="submit" class="main-btn main-btn-large" value="<?php echo $this->_var['lang']['confirm_edit']; ?>"  />
                        	</label>
                        </td>
                    </tr>
                </table>
              </form>
            </div>
            <div class="ncm-default-form"  id="con_tab_2" style="display:none">
              <form name="formEdit" action="user.php" method="post" enctype="multipart/form-data" onSubmit="return userEdit()">
                <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eee">
                	<tr>
                    	<td width="35%" align="right">头像预览：</td>
                  	  	<td class="user-avatar">
                        	<?php if ($this->_var['profile']['headimg']): ?><img src="<?php echo $this->_var['profile']['headimg']; ?>" /><?php endif; ?>
                    		<p class="hint">
                            	完善个人信息资料，上传头像图片有助于您结识更多的朋友。<br />
                      			<span style="">头像最佳默认尺寸为120x120像素。</span>
                            </p>
                 		</td>
                	</tr>
                	<tr>
                    	<td width="35%" align="right">更换头像：</td>
                        <td>
                            <div class="ncm-upload-btn"> 
                                <a href="javascript:void(0);"><span><input type="file" name="headimg" ></span></a>
                            </div>
                      	</td>
                    </tr>
                    <tr>
                      	<td colspan="2" align="center">
                        	<label class="submit-border">
                          		<input name="act" type="hidden" value="act_edit_img" />
                          		<input name="submit" type="submit" class="main-btn main-btn-large" value="<?php echo $this->_var['lang']['confirm_edit']; ?>"  />
                        	</label>
                        </td>
                    </tr>
                </table>
              </form>
            </div>
            <div class="ncm-default-form"  id="con_tab_3"  style="display:none"> 
              <?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,region.js,shopping_flow.js')); ?> 
              <script type="text/javascript">
              region.isAdmin = false;
              <?php $_from = $this->_var['lang']['flow_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
              var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              
              onload = function() {
                if (!document.all)
                {
                  document.forms['theForm'].reset();
                }
              }
              
            </script>
              <form name="formIdentity" action="user.php" method="post" onsubmit="return identity()" enctype="multipart/form-data">
                <table width="100%" border="0"  cellpadding="10" cellspacing="1"  bgcolor="#eeeeee">
                  <?php if ($this->_var['profile']['status'] > 0): ?>
                  <tr>
                    <th colspan="2"><?php if ($this->_var['profile']['status'] == 2): ?>认证审核中<?php elseif ($this->_var['profile']['status'] == 1): ?>认证审核通过<?php elseif ($this->_var['profile']['status'] == 3): ?>认证审核不通过，请重新填写！<?php endif; ?></th>
                  </tr>
                  <?php endif; ?>
                  <tr>
                    <td width="28%" align="right"><font class="main-color">*</font>真实姓名：</td>
		    <td width="72%" align="left"><input type="text" name="real_name" value="<?php echo $this->_var['profile']['real_name']; ?>"  class="inputBg"/>
		    <div class="required-notice"><i class="notice-icon"></i><span class="notice-text people-name-notice"></span></div></td>
                  </tr>
                  <tr>
                    <td align="right"><font class="main-color">*</font>身份证号：</td>
		    <td align="left"><input type="text" name="card" value="<?php echo $this->_var['profile']['card']; ?>"  class="inputBg"/>
		    <div class="required-notice"><i class="notice-icon"></i><span class="notice-text people-num-notice"></span></div></td>
                  </tr>
                  <tr>
                    <td align="right"><font class="main-color">*</font>身份证证件照：</td>
                    <td align="left">正面：
                      <input type="file" name="face_card" />
                      <br />
		      <?php if ($this->_var['profile']['face_card'] != ''): ?><img src="<?php echo $this->_var['profile']['face_card']; ?>" width="160" height="160" class="face_img"/><?php endif; ?>
		      <div class="required-notice"><i class="notice-icon"></i><span class="notice-text people-card-notice"></span></div></td>
                  </tr>
                  <tr>
                    <td align="right">&nbsp;</td>
                    <td align="left">反面：
                      <input type="file" name="back_card" />
                      <br />
                      <?php if ($this->_var['profile']['back_card'] != ''): ?><img src="<?php echo $this->_var['profile']['back_card']; ?>" width="150" height="150" class="face_img" /><?php endif; ?></td>
                  </tr>
                  <tr>
                    <td align="right">现居地：</td>
                    <td align="left"><select name="country" id="selCountries" onchange="region.changed(this, 1, 'selProvinces')">
                        <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['0']; ?></option>
                        <?php $_from = $this->_var['country_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'country');if (count($_from)):
    foreach ($_from AS $this->_var['country']):
?>
                        <option value="<?php echo $this->_var['country']['region_id']; ?>" <?php if ($this->_var['profile']['country'] == $this->_var['country']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['country']['region_name']; ?></option>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                      </select>
                      <select name="province" id="selProvinces" onchange="region.changed(this, 2, 'selCities')">
                        <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['1']; ?></option>
                        <?php $_from = $this->_var['province_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
                        <option value="<?php echo $this->_var['province']['region_id']; ?>" <?php if ($this->_var['profile']['province'] == $this->_var['province']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['province']['region_name']; ?></option>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                      </select>
                      <select name="city" id="selCities" onchange="region.changed(this, 3, 'selDistricts')">
                        <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['2']; ?></option>
                        <?php $_from = $this->_var['city_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'city');if (count($_from)):
    foreach ($_from AS $this->_var['city']):
?>
                        <option value="<?php echo $this->_var['city']['region_id']; ?>" <?php if ($this->_var['profile']['city'] == $this->_var['city']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['city']['region_name']; ?></option>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                      </select>
                      <select name="district" id="selDistricts" <?php if (! $this->_var['district_list']): ?>style="display:none"<?php endif; ?>>
                        <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['3']; ?></option>
                        <?php $_from = $this->_var['district_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'district');if (count($_from)):
    foreach ($_from AS $this->_var['district']):
?>
                        <option value="<?php echo $this->_var['district']['region_id']; ?>" <?php if ($this->_var['profile']['district'] == $this->_var['district']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['district']['region_name']; ?></option>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		      </select>
		      <div class="required-notice fl"><i class="notice-icon"></i><span class="notice-text address-notice"></span></div></td>
                  </tr>
                  <tr>
                    <td align="right">详细地址：</td>
		    <td align="left"><input type="text" name="address" value="<?php echo $this->_var['profile']['address']; ?>"  class="inputBg"/>
		    <div class="required-notice"><i class="notice-icon"></i><span class="notice-text address-detail-notice"></span></div></td>
                  </tr>
                  <tr>
                    <td width="28%" align="right">&nbsp;</td>
                    <td align="left">
                    	<input name="act" type="hidden" value="act_identity" />
                        <input name="submit" type="submit" value="确认" class="main-btn main-btn-large" <?php if ($this->_var['profile']['status'] == 2): ?> disabled="disabled"<?php endif; ?>/></td>
                  </tr>
                </table>
              </form>
            </div>
          </div>
        <?php endif; ?> 
         
        <?php if ($this->_var['action'] == 'update_password_'): ?>
          
          <h5 class="user-title user-title-t"><span>修改登录密码</span></h5>
          <div class="blank"></div>
          <form name="formPassword" action="user.php" method="post" onSubmit="return editPassword()" >
            <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
              <tr>
                <td width="28%" align="right" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['old_password']; ?>：</td>
                <td width="76%" align="left" bgcolor="#FFFFFF"><input name="old_password" type="password" size="25"  class="inputBg" /></td>
              </tr>
              <tr>
                <td width="28%" align="right" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['new_password']; ?>：</td>
                <td align="left" bgcolor="#FFFFFF"><input name="new_password" type="password" size="25"  class="inputBg" /></td>
              </tr>
              <tr>
                <td width="28%" align="right" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['confirm_password']; ?>：</td>
                <td align="left" bgcolor="#FFFFFF"><input name="comfirm_password" type="password" size="25"  class="inputBg" /></td>
              </tr>
              <tr>
                <td width="28%" align="right" bgcolor="#FFFFFF">&nbsp;</td>
                <td align="left" bgcolor="#FFFFFF"><input name="act" type="hidden" value="act_edit_password" />
                  <input name="submit" type="submit" class="bnt_blue_1" style="border:none;" value="<?php echo $this->_var['lang']['confirm_edit']; ?>" /></td>
              </tr>
            </table>
          </form>
          <?php endif; ?> 
          
          <?php if ($this->_var['action'] == 'account_security'): ?>
          <h5 class="user-title user-title-t"><span> 安全级别： 
             
           <?php if ($this->_var['info']['is_validated'] == 0 && $this->_var['info']['validated'] == 0 && $this->_var['info']['is_surplus_open'] == 0): ?>很危险&nbsp;<i class="validated1"></i>建议您启动全部安全设置，以保障账户及资金安全<?php endif; ?>
            <?php if ($this->_var['info']['is_validated'] == 0 && $this->_var['info']['validated'] == 0 && $this->_var['info']['is_surplus_open'] == 1): ?>比较危险&nbsp;<i class="validated2"></i>建议您启动全部安全设置，以保障账户及资金安全<?php endif; ?>
            <?php if ($this->_var['info']['is_validated'] == 0 && $this->_var['info']['validated'] == 1 && $this->_var['info']['is_surplus_open'] == 0): ?>比较危险&nbsp;<i class="validated2"></i>建议您启动全部安全设置，以保障账户及资金安全<?php endif; ?>
            <?php if ($this->_var['info']['is_validated'] == 1 && $this->_var['info']['validated'] == 0 && $this->_var['info']['is_surplus_open'] == 0): ?>比较危险&nbsp;<i class="validated2"></i>建议您启动全部安全设置，以保障账户及资金安全<?php endif; ?>
            <?php if ($this->_var['info']['is_validated'] == 0 && $this->_var['info']['validated'] == 1 && $this->_var['info']['is_surplus_open'] == 1): ?>一般&nbsp;<i class="validated3"></i><?php endif; ?>
            <?php if ($this->_var['info']['is_validated'] == 1 && $this->_var['info']['validated'] == 1 && $this->_var['info']['is_surplus_open'] == 0): ?>一般&nbsp;<i class="validated3"></i><?php endif; ?>
            <?php if ($this->_var['info']['is_validated'] == 1 && $this->_var['info']['validated'] == 0 && $this->_var['info']['is_surplus_open'] == 1): ?>一般&nbsp;<i class="validated3"></i><?php endif; ?>
            <?php if ($this->_var['info']['is_validated'] == 1 && $this->_var['info']['validated'] == 1 && $this->_var['info']['is_surplus_open'] == 1): ?>高&nbsp;<i class="validated5"></i><?php endif; ?> 
             
            </span>
	   </h5>
          <div class="blank"></div>
          <div class="m m5" id="safe05">
            <div class="mc">
              <div class="fore1"><s class="fore1_3"></s><strong>登录密码</strong></div>
              <div class="fore2"><span class="ftx-03">互联网账号存在被盗风险，建议您定期更改密码以保护账户安全。</span><span style="color:#CF0F02;"></span></div>
              <div class="fore3"><a href="user.php?act=update_password" class="btn btn-8">&nbsp;&nbsp;修&nbsp;&nbsp;改&nbsp;&nbsp;</a></div>
            </div>
            <div class="mc">
              <div class="fore1"> <s class="<?php if ($this->_var['info']['is_validated'] == 0): ?>fore1_1<?php else: ?>fore1_3<?php endif; ?>"></s><strong>邮箱验证</strong></div>
              <div class="fore2"><?php if ($this->_var['info']['is_validated'] == 0): ?><span style="color:#ED5854;">验证后，可用于快速找回登录密码，接收账户余额变动提醒</span><?php else: ?><span class="ftx-03">您验证的邮箱：<?php echo $this->_var['info']['email']; ?><?php endif; ?></span></div>
              <div class="fore3"><?php if ($this->_var['info']['is_validated'] == 0): ?>
                <input type="button" value="验证邮箱" onclick="window.location.href='user.php?act=re_binding_email'" class="btn btn-7">
                <?php else: ?><a href="user.php?act=update_email" class="btn btn-8">&nbsp;&nbsp;修&nbsp;&nbsp;改&nbsp;&nbsp;</a><?php endif; ?> </div>
            </div>
            <div class="mc">
              <div class="fore1"><s class="<?php if ($this->_var['info']['validated'] == 0): ?>fore1_1<?php else: ?>fore1_3<?php endif; ?>"></s><strong>手机验证</strong></div>
              <div class="fore2"><?php if ($this->_var['info']['validated'] == 0): ?><span style="color:#ED5854;">验证后，可用于快速找回登录密码及支付密码，接收账户余额变动提醒</span><?php else: ?><span class="ftx-03" >您验证的手机：<?php echo $this->_var['info']['mobile_phone']; ?>,若已丢失或停用，请立即更换，避免账户被盗<?php endif; ?></span></div>
              <div class="fore3"><?php if ($this->_var['info']['validated'] == 0): ?>
                <input type="button" value="验证手机" onclick="window.location.href='user.php?act=re_binding'"  class="btn btn-7">
                <?php else: ?><a href="user.php?act=update_phone" class="btn btn-8">&nbsp;&nbsp;修&nbsp;&nbsp;改&nbsp;&nbsp;</a><?php endif; ?></div>
            </div>
            
            
            <div class="mc" id="surplus-mc">
                        <div class="fore1"><s class="<?php if ($this->_var['info']['is_surplus_open'] == 0): ?>fore1_1<?php else: ?>fore1_3<?php endif; ?>"></s><strong>余额支付</strong></div>
						<div class="fore2"><?php if ($this->_var['info']['is_surplus_open'] == 0): ?><span style="color:#ED5854;">开启后，可保障您账户余额支付的安全</span><?php else: ?><span class="ftx-03" >您已开启账户余额支付密码功能<?php endif; ?></span></div>
						<div class="fore3">
                        	<?php if ($this->_var['info']['is_surplus_open'] == 0): ?>
                            <input type="button" value="开启支付密码" onclick="open_surplus()"  class="btn btn-7">
                        	<?php else: ?>
                            <input type="button" value="关闭支付密码" onclick="javascript:close_surplus()"  class="btn btn-7">
                            <?php endif; ?>
                        </div>
                        <div class="fore4">
                        	<p>
                        		<a href="user.php?act=forget_surplus_password">忘记支付密码</a>
                            </p>
                            <p>
                        		<a href="user.php?act=update_surplus_password">修改支付密码</a>
                            </p>
                        </div>
                    </div>
             
          </div>
          <?php endif; ?> 
           
          <?php if ($this->_var['action'] == 'update_surplus_password'): ?> 
          <script>
        function check_new_surplus_password(form){
          var prev_pwd = document.getElementById('prev_surplus_password').value;
          var pwd1 = document.getElementById('new_surplus_password1').value;
          var pwd2 = document.getElementById('new_surplus_password2').value;
          var msg = '';

          if(prev_pwd.length == 0||pwd1.length == 0||pwd2.length == 0){
            msg = '密码不能为空';
            alert(msg);
            return false;
          }

          if(pwd1 != pwd2){
            msg = msg + '密码不匹配\n';
          }
          if(pwd1.length < 6){
            msg = msg + '新密码太短\n';
          }
          if(msg.length > 0){
            alert(msg);
            return false;
          }else{
            return true;
           }
        }
      </script>
          <h5 class="user-title user-title-t"><span>修改支付密码</span></h5>
          <div class="blank"></div>
          <form action="user.php?act=act_update_surplus_password" method="post" onsubmit="return check_new_surplus_password(this)">
            <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
              <tr>
                <td align="right" bgcolor="#FFFFFF">原始支付密码： </td>
                <td align="left" bgcolor="#ffffff"><input type="password" id="prev_surplus_password" name="prev_surplus_password" class="inputBg"/></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#ffffff">新支付密码：</td>
                <td align="left" bgcolor="#ffffff"><input type="password" id='new_surplus_password1' name="new_surplus_password1"  class="inputBg"/></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#ffffff">确认密码：</td>
                <td align="left" bgcolor="#ffffff"><input type="password" id='new_surplus_password2' name="new_surplus_password2"  class="inputBg"/></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#ffffff">&nbsp;</td>
                <td align="left" bgcolor="#ffffff"><input type="submit" class="bnt_blue_1" value="确定" />
                  <input type='hidden' name='course' value='update'/></td>
              </tr>
            </table>
          </form>
          <?php endif; ?> 
          
          <?php if ($this->_var['action'] == 'forget_surplus_password'): ?> 
          <script language='javascript' type='text/javascript'>
        <?php if ($this->_var['info']['is_validated'] == 1): ?>var has_email = true;
        <?php else: ?>var has_email = false;<?php endif; ?>
        <?php if ($this->_var['info']['validated'] == 1): ?>var has_phone = true;
        <?php else: ?>var has_phone = false;<?php endif; ?>
        var method = '';//email,phone
        function display_email_body()
        {
          if(has_email)
          {
            document.getElementById('send_email_tbody').style.display="";
          }
        }

        function hide_email_body()
        {
          if(has_email)
          {
            document.getElementById('send_email_tbody').style.display="none";
          }
        }

        function display_phone_body()
        {
          if(has_phone)
          {
            document.getElementById('send_phone_tbody').style.display="";
          }
        }

        function hide_phone_body()
        {
          if(has_phone)
          {
            document.getElementById('send_phone_tbody').style.display="none";
          }
        }

        function select_none()
        {
          hide_email_body();
          hide_phone_body();
          method = '';
        }

        function select_email()
        {
          display_email_body();
          hide_phone_body();
          method = 'email';
        }

        function select_phone()
        {
          hide_email_body();
          display_phone_body();
          method = 'phone';
        }

        function add_verify_method(method)
        {
          var input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'verify_method';
          input.value = method;
          $$('forget_surplus_form').appendChild(input);
        }
        function check_surplus_form()
        {
          if(method == 'email'){
            var captcha = document.getElementById('v_captcha').value;
            if(captcha.length > 0)
            {
              add_verify_method('email');
              return true;
            }
            else
            {
              alert('请输入验证码！');
              return false;
            }
          }
          else if(method == 'phone')
          {
            var code = document.getElementById('v_code').value;
            if(code.length > 0)
            {
              add_verify_method('phone');
              return true;
            }
            else
            {
              alert('请输入验证码！');
              return false;
            }
          }
          else
          {
            return false;
          }
        }

        function change_option(op)
        {
          if(op.value == 'select_none')
          {
            select_none();
          }
          else if(op.value == 'send_by_email')
          {
            select_email();
          }
          else if(op.value == 'send_by_phone')
          {
            select_phone();
          }
        }
	function get_verify_code()
        {
            var phone = document.getElementById('v_phone').value;
            Ajax.call('user.php?act=get_verify_code', 'phone=' + phone, get_verify_code_response, 'POST', 'JSON');
        }
        function get_verify_code_response(result)
        {
          if(result.result == 'success')
          {
            $$('code_notice').innerHTML=result.message;
            $$('code_btn').disabled=true;
          }
          else
          {
            alert(result.message+'\n请稍后重试！');
          }
        }
        window.onload=function()
        {
          document.getElementById('forget_surplus_form').reset();
        }
      </script>
          <h5 class="user-title user-title-t"><span>忘记支付密码</span></h5>
          <div class="blank"></div>
          <form id='forget_surplus_form' action="user.php?act=act_forget_surplus_password" method="post" onsubmit='return check_surplus_form()'>
            <table id="forget_surplus_password_table" width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
              <tbody>
                <tr>
                  <td align="right" bgcolor="#FFFFFF">找回密码： </td>
                  <td align="left" bgcolor="#ffffff"><select onchange='change_option(this)'>
                      <option value="select_none" selected="selected">请选择找回密码方式</option>
                      
              <?php if ($this->_var['info']['is_validated'] == 1): ?>
                      <option value="send_by_email">邮箱找回密码</option>
                      <?php endif; ?>
              <?php if ($this->_var['info']['validated'] == 1): ?>
                      <option value="send_by_phone">手机找回密码</option>
                      <?php endif; ?>
            
                    </select></td>
                </tr>
              </tbody>
              <?php if ($this->_var['info']['validated'] == 1): ?>
              <tbody id="send_phone_tbody" style="display:none">
                <tr>
                  <td align="right" bgcolor="#FFFFFF">已验证手机号： </td>
                  <td align="left" bgcolor="#FFFFFF"><?php echo $this->_var['info']['mobile_phone']; ?>
                    <input id='v_phone' type="hidden" name="v_phone" value="<?php echo $this->_var['info']['mobile_phone']; ?>"/></td>
                </tr>
                <tr>
                  <td align="right" bgcolor="#FFFFFF">手机验证码： </td>
                  <td align="left" bgcolor="#FFFFFF"><input type="text" id='v_code' name="v_code" class="inputBg" />
                    <input type="button" onclick="get_verify_code(<?php echo $this->_var['info']['mobile_phone']; ?>);" class="main-btn main-btn-large" value="获取手机验证码" id="code_btn"/>
                    <span id="code_notice" style="color:#999"></span></td>
                </tr>
                <tr>
                  <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
                  <td align="left" bgcolor="#FFFFFF"><input type="submit" class="bnt_blue_1" value="提交" /></td>
                </tr>
              </tbody>
              <?php endif; ?>
              <?php if ($this->_var['info']['is_validated'] == 1): ?>
              <tbody id="send_email_tbody" style="display:none">
                <tr>
                  <td align="right" bgcolor="#FFFFFF">已验证邮箱： </td>
                  <td align="left" bgcolor="#FFFFFF"><?php echo $this->_var['info']['email']; ?>
                    <input type="hidden" name="v_email" value="<?php echo $this->_var['info']['email']; ?>"/></td>
                </tr>
                <tr>
                  <td align="right" bgcolor="#ffffff">验证码：</td>
                  <td align="left" bgcolor="#ffffff"><input type="text" id='v_captcha' name="v_captcha"  class="inputBg"/>
                    <img src="captcha.php?is_login=1&<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;margin-left:10px;margin-top:-3px" onClick="this.src='captcha.php?is_login=1&'+Math.random()" /></td>
                </tr>
                <tr>
                  <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
                  <td align="left" bgcolor="#FFFFFF"><input type="submit" class="bnt_blue_1" value="提交" /></td>
                </tr>
              </tbody>
              <?php endif; ?>
            </table>
          </form>
          <?php endif; ?> 
          <?php if ($this->_var['action'] == 'reset_surplus_password' && $this->_var['validated'] == true): ?> 
          <script language='javascript' type='text/javascript'>
      function check_reset_surplus_password(frm)
      {
        var pwd1 = document.getElementById('surplus_password_input1').value;
        var pwd2 = document.getElementById('surplus_password_input2').value;
        var msg = '';

        if(pwd1.length == 0||pwd2.length == 0)
        {
          msg = '密码不能为空';
          alert(msg);
          return false;
        }

        if(pwd1 != pwd2)
        {
          msg = msg + '密码不匹配\n';
        }
        if(pwd1.length < 6)
        {
          msg = msg + '新密码太短\n';
        }
        if(msg.length > 0)
        {
          alert(msg);
          return false;
        }
        else
        {
          return true;
         }
      }
      </script>
          <h5 class="user-title user-title-t"><span>重置余额支付密码</span></h5>
          <div class="blank"></div>
          <form action="user.php?act=act_update_surplus_password" method="post" onsubmit='return check_reset_surplus_password(this)'>
            <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
              <tr>
                <td align="right" bgcolor="#FFFFFF">新支付密码： </td>
                <td align="left" bgcolor="#ffffff"><input type="password" id='surplus_password_input1' name="surplus_password1" class="inputBg"/></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#FFFFFF">确认密码： </td>
                <td align="left" bgcolor="#ffffff"><input type="password" id='surplus_password_input2' name="surplus_password2" class="inputBg"/></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#ffffff">&nbsp;</td>
                <td align="left" bgcolor="#ffffff"><input type="submit" class="bnt_blue_1" value="确认" />
                  <?php if ($this->_var['verify_method'] == 'phone'): ?>
                  <input type="hidden" name="verify_method" value="phone" />
                  <input type="hidden" name="v_code" value="<?php echo $this->_var['v_code']; ?>" />
                  <?php elseif ($this->_var['verify_method'] == 'email'): ?>
                  <input type="hidden" name="verify_method" value="email" />
                  <input type="hidden" name="hash" value="<?php echo $this->_var['hash']; ?>" />
                  <?php endif; ?>
                  <input type='hidden' name='course' value='reset'/></td>
              </tr>
            </table>
          </form>
          <?php endif; ?> 
           
          
          <?php if ($this->_var['action'] == 'update_email'): ?>
          <h5 class="user-title user-title-t"><span>修改已验证邮箱</span></h5>
          <div class="blank"></div>
          <form action="user.php" method="post">
            <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
              <tr>
                <td align="right" bgcolor="#FFFFFF">已验证邮箱： </td>
                <td align="left" bgcolor="#ffffff"><?php echo $this->_var['email']; ?>
                  <input type="hidden" name="v_email" value="<?php echo $this->_var['email']; ?>"  class="inputBg"/></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#ffffff">验证码：</td>
                <td align="left" bgcolor="#ffffff"><input type="text" name="v_captcha"  class="inputBg"/>
                  <img src="captcha.php?is_login=1&<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;margin-left:10px;margin-top:-3px" onClick="this.src='captcha.php?is_login=1&'+Math.random()" /></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#ffffff">&nbsp;</td>
                <td align="left" bgcolor="#ffffff"><input type="submit" class="bnt_blue_1" value="发送验证邮件" />
                  <input type="hidden" name="act" value="act_update_email" /></td>
              </tr>
            </table>
          </form>
          <?php endif; ?> 
          
          <?php if ($this->_var['action'] == 'act_update_email'): ?>
          <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
            <tr>
              <td bgcolor="#ffffff">已发送验证邮件至：<?php echo $this->_var['v_email']; ?></td>
            </tr>
            <tr>
              <td bgcolor="#ffffff">验证邮件24小时内有效，请尽快登录您的邮箱点击验证链接完成验证。</td>
            </tr>
          </table>
          <?php endif; ?> 
          
          <?php if ($this->_var['action'] == 're_binding_email'): ?>
          <h5 class="user-title user-title-t"><span>邮箱设置信息</span></h5>
          <div class="blank"></div>
          <form action="user.php" method="post">
            <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
              <tr>
                <td width="28%" align="right" bgcolor="#FFFFFF">我的邮箱： </td>
                <td width="72%" align="left" bgcolor="#ffffff"><input type="text" name="new_email" value="<?php if ($this->_var['info']['is_validated'] == 0): ?><?php echo $this->_var['info']['email']; ?><?php endif; ?>"  class="inputBg"/>
                  &nbsp;&nbsp;这里是您想<?php if ($this->_var['info']['is_validated'] != 0): ?>修改<?php endif; ?>绑定的邮箱地址</td>
              </tr>
              <tr>
                <td align="right" bgcolor="#ffffff">验证码：</td>
                <td align="left" bgcolor="#ffffff"><input type="text" name="code"  class="inputBg"/>
                  <img src="captcha.php?is_login=1&<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;margin-left:10px;margin-top:-3px" onClick="this.src='captcha.php?is_login=1&'+Math.random()" /></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#ffffff">&nbsp;</td>
                <td align="left" bgcolor="#ffffff"><input type="submit" class="bnt_blue_1" value="提交" />
                  <input type="hidden" name="act" value="act_binding_email" /></td>
              </tr>
            </table>
          </form>
          <?php endif; ?> 
          
          <?php if ($this->_var['action'] == 'update_phone'): ?> 
          <?php echo $this->smarty_insert_scripts(array('files'=>'sms.js')); ?>
          <h5 class="user-title user-title-t"><span>修改已验证手机</span></h5>
          <div class="blank"></div>
          <form action="user.php" method="post">
            <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
              <tr>
                <td align="right" bgcolor="#FFFFFF">已验证手机： </td>
                <td align="left" bgcolor="#FFFFFF"><?php echo $this->_var['phone']; ?>
                  <input type="hidden" name="v_phone" value="<?php echo $this->_var['phone']; ?>"/></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
                <td align="left" bgcolor="#FFFFFF"><input type="button" onclick="getverifycode2(<?php echo $this->_var['phone']; ?>);" class="bnt_blue_1" value="点击获取" id="v_code_btn"/>
                  <span id="v_code_notice" style="color:#999"></span></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#FFFFFF">手机验证码：</td>
                <td align="left" bgcolor="#FFFFFF"><input type="text" name="v_code" class="inputBg" /></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
                <td align="left" bgcolor="#FFFFFF"><input type="submit" class="bnt_blue_1" value="提交" />
                  <input type="hidden" name="act" value="act_update_phone" /></td>
              </tr>
            </table>
          </form>
          <?php endif; ?> 
          
          <?php if ($this->_var['action'] == 're_binding'): ?> 
          <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>
          <?php echo $this->smarty_insert_scripts(array('files'=>'sms.js')); ?>
          <h5 class="user-title user-title-t"><span>手机号修改结果</span></h5>
          <div class="blank"></div>
          <form action="user.php" method="post" name="binding">
            <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
              <tr>
                <td align="right" bgcolor="#ffffff">手机号：</td>
                <td align="left" bgcolor="#ffffff"><input type="text" id="phone" name="phone" class="inputBg" onblur="check_phone(this.value)"/>
                  <span id="phone_message" style="color:#F00"> *</span></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#ffffff">验证码：</td>
                <td align="left" bgcolor="#ffffff"><input type="text" size="8" name="verifycode" class="inputBg" />
                  <input type="button" onclick="getverifycode1();" class="bnt_blue_1" value="点击获取" id="code_btn"/>
                  <span id="code_notice" style="color:#999"></span></td>
              </tr>
              <tr>
                <td bgcolor="#ffffff">&nbsp;</td>
                <td align="left" bgcolor="#ffffff"><input type="submit" value="提交" class="bnt_blue_1" style="width:100px; height:30px;" />
                  <input type="hidden" name="act" value="binding" /></td>
              </tr>
            </table>
          </form>
          <?php endif; ?> 
         
          <?php if ($this->_var['action'] == 'address_list'): ?> 
          
          <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js,transport.js,region.js,shopping_flow.js')); ?> 
          <script type="text/javascript">
              region.isAdmin = false;
              <?php $_from = $this->_var['lang']['flow_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
              var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              
              onload = function() {
                if (!document.all)
                {
                  document.forms['theForm'].reset();
                }
              }
              
            </script>
          <div class="tabmenu">
            <ul class="tab pngFix">
              <li class="first active">地址列表</li>
            </ul>
          </div>
          <div class="alert alert-success">
            <h4>操作提示：</h4>
            <ul>
              <li>您可对已有的地址进行编辑及删除，亦可新增收货地址</li>
            </ul>
          </div>
          <div class="mar_top">
            <?php $_from = $this->_var['consignee_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('sn', 'consignee');if (count($_from)):
    foreach ($_from AS $this->_var['sn'] => $this->_var['consignee']):
?>
            <form action="user.php" method="post" name="theForm" onsubmit="return checkConsignee(this)">
            <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
                <tr>
                  <td align="right" width="10%"><?php echo $this->_var['lang']['country_province']; ?>：</td>
                  <td colspan="3" align="left"><select name="country" id="selCountries_<?php echo $this->_var['sn']; ?>" onchange="region.changed(this, 1, 'selProvinces_<?php echo $this->_var['sn']; ?>')">
                      <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['0']; ?></option>
                      <?php $_from = $this->_var['country_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'country');if (count($_from)):
    foreach ($_from AS $this->_var['country']):
?>
                      <option value="<?php echo $this->_var['country']['region_id']; ?>" <?php if ($this->_var['consignee']['country'] == $this->_var['country']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['country']['region_name']; ?></option>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </select>
                    <select name="province" id="selProvinces_<?php echo $this->_var['sn']; ?>" onchange="region.changed(this, 2, 'selCities_<?php echo $this->_var['sn']; ?>')">
                      <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['1']; ?></option>
                      <?php $_from = $this->_var['province_list'][$this->_var['sn']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
                      <option value="<?php echo $this->_var['province']['region_id']; ?>" <?php if ($this->_var['consignee']['province'] == $this->_var['province']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['province']['region_name']; ?></option>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </select>
                    <select name="city" id="selCities_<?php echo $this->_var['sn']; ?>" onchange="region.changed(this, 3, 'selDistricts_<?php echo $this->_var['sn']; ?>')">
                      <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['2']; ?></option>
                      <?php $_from = $this->_var['city_list'][$this->_var['sn']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'city');if (count($_from)):
    foreach ($_from AS $this->_var['city']):
?>
                      <option value="<?php echo $this->_var['city']['region_id']; ?>" <?php if ($this->_var['consignee']['city'] == $this->_var['city']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['city']['region_name']; ?></option>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </select>
                    <select name="district" id="selDistricts_<?php echo $this->_var['sn']; ?>" <?php if (! $this->_var['district_list'][$this->_var['sn']]): ?>style="display:none"<?php endif; ?>>
                      <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['3']; ?></option>
                      <?php $_from = $this->_var['district_list'][$this->_var['sn']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'district');if (count($_from)):
    foreach ($_from AS $this->_var['district']):
?>
                      <option value="<?php echo $this->_var['district']['region_id']; ?>" <?php if ($this->_var['consignee']['district'] == $this->_var['district']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['district']['region_name']; ?></option>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </select>
                    <?php echo $this->_var['lang']['require_field']; ?> </td>
                </tr>
                <tr>
                  <td align="right" width="10%"><?php echo $this->_var['lang']['consignee_name']; ?>：</td>
                  <td align="left" width="40%"><input name="consignee" type="text" class="inputBg" id="consignee_<?php echo $this->_var['sn']; ?>" value="<?php echo htmlspecialchars($this->_var['consignee']['consignee']); ?>" />
                    <?php echo $this->_var['lang']['require_field']; ?> </td>
                  <td align="right" width="10%"><?php echo $this->_var['lang']['email_address']; ?>：</td>
                  <td align="left" width="40%"><input name="email" type="text" class="inputBg" id="email_<?php echo $this->_var['sn']; ?>" value="<?php echo htmlspecialchars($this->_var['consignee']['email']); ?>" />
                  </td>
                </tr>
                <tr>
                  <td align="right"><?php echo $this->_var['lang']['detailed_address']; ?>：</td>
                  <td align="left" colspan="3"><input name="address" type="text" class="inputBg" id="address_<?php echo $this->_var['sn']; ?>" value="<?php echo htmlspecialchars($this->_var['consignee']['address']); ?>" style="width: 692px;"/>
                    <?php echo $this->_var['lang']['require_field']; ?></td>
               	</tr>
                <tr>
                  <td align="right"><?php echo $this->_var['lang']['phone']; ?>：</td>
                  <td align="left"><input name="tel" type="text" class="inputBg" id="tel_<?php echo $this->_var['sn']; ?>" value="<?php echo htmlspecialchars($this->_var['consignee']['tel']); ?>"  placeholder="<?php echo $this->_var['lang']['tel_placeholder']; ?>"/></td>
                  <td align="right"><?php echo $this->_var['lang']['backup_phone']; ?>：</td>
                  <td align="left"><input name="mobile" type="text" class="inputBg" id="mobile_<?php echo $this->_var['sn']; ?>" value="<?php echo htmlspecialchars($this->_var['consignee']['mobile']); ?>" />
                </td>
                </tr>
                <tr>
                <!-- 
                  <td align="right"><?php echo $this->_var['lang']['sign_building']; ?>：</td>
                  <td align="left"><input name="sign_building" type="text" class="inputBg" id="sign_building_<?php echo $this->_var['sn']; ?>" value="<?php echo htmlspecialchars($this->_var['consignee']['sign_building']); ?>" /></td>
                -->
                  <td align="right"><?php echo $this->_var['lang']['postalcode']; ?>：</td>
                  <td align="left"><input name="zipcode" type="text" class="inputBg" id="zipcode_<?php echo $this->_var['sn']; ?>" value="<?php echo htmlspecialchars($this->_var['consignee']['zipcode']); ?>" /></td>
                  <td align="right"><?php echo $this->_var['lang']['deliver_goods_time']; ?>：</td>
                  <td align="left"><input name="best_time" type="text"  class="inputBg" id="best_time_<?php echo $this->_var['sn']; ?>" value="<?php echo htmlspecialchars($this->_var['consignee']['best_time']); ?>" /></td>
                </tr>
                <tr>
                <td colspan="4" align="center">
                	<?php if ($this->_var['consignee']['consignee'] && ( $this->_var['consignee']['tel'] || $this->_var['consignee']['mobile'] )): ?>
                    
                    <input type="submit" name="submit" class="main-btn main-btn-large" value="<?php echo $this->_var['lang']['confirm_edit']; ?>" />
                    <input name="button" type="button" class="main-btn main-btn-large"  onclick="if (confirm('<?php echo $this->_var['lang']['confirm_drop_address']; ?>'))location.href='user.php?act=drop_consignee&id=<?php echo $this->_var['consignee']['address_id']; ?>'" value="<?php echo $this->_var['lang']['drop']; ?>" />
                    
                    <?php else: ?>
                    
                    <input type="submit" name="submit" class="main-btn main-btn-large"  value="<?php echo $this->_var['lang']['add_address']; ?>"/>
                    
                    <?php endif; ?>
                    
                    <input type="hidden" name="act" value="act_edit_address" />
                    <input name="address_id" type="hidden" value="<?php echo $this->_var['consignee']['address_id']; ?>" /></td>
                </tr>
              </table>
            </form>
            <div class="blank10"></div>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
          </div>
          <?php endif; ?> 
           
           
          <?php if ($this->_var['action'] == "account_raply" || $this->_var['action'] == "account_log" || $this->_var['action'] == "account_deposit" || $this->_var['action'] == "account_detail"): ?> 
          <script type="text/javascript">
          <?php $_from = $this->_var['lang']['account_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
            var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </script>
          <div class="tabmenu">
              <ul class="tab pngFix">
                <li class="first active"><?php echo $this->_var['lang']['user_balance']; ?></li>
              </ul>
          </div>
          <div class="mar_top">
          <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
            <tr>
              <td align="right">
              	<a href="user.php?act=account_deposit" class="main-color"><?php echo $this->_var['lang']['surplus_type_0']; ?></a> | 
                <a href="user.php?act=account_raply" class="main-color"><?php echo $this->_var['lang']['surplus_type_1']; ?></a> | 
                <a href="user.php?act=account_detail" class="main-color"><?php echo $this->_var['lang']['add_surplus_log']; ?></a> | 
                <a href="user.php?act=account_log" class="main-color"><?php echo $this->_var['lang']['view_application']; ?></a>
              </td>
            </tr>
          </table>
          </div>
          <?php endif; ?> 
          <?php if ($this->_var['action'] == "account_raply"): ?>
          <form name="formSurplus" method="post" action="user.php" onSubmit="return submitSurplus()">
            <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
              <tr>
                <td width="10%" align="right"><?php echo $this->_var['lang']['repay_money']; ?>:</td>
                <td align="left"><input type="text" name="amount" value="<?php echo htmlspecialchars($this->_var['order']['amount']); ?>" class="inputBg" size="30" /></td>
              </tr>
              <tr>
                <td align="right"><?php echo $this->_var['lang']['process_notic']; ?>:</td>
                <td align="left"><textarea name="user_note" cols="55" rows="6" style="border:1px solid #ddd;"><?php echo htmlspecialchars($this->_var['order']['user_note']); ?></textarea></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><input type="hidden" name="surplus_type" value="1" />
                  <input type="hidden" name="act" value="act_account" />
                  <input type="submit" name="submit"  class="main-btn main-btn-large" value="<?php echo $this->_var['lang']['submit_request']; ?>" />
                  <input type="reset" name="reset" class="main-btn main-btn-large" value="<?php echo $this->_var['lang']['button_reset']; ?>" /></td>
              </tr>
            </table>
          </form>
          <?php endif; ?> 
          <?php if ($this->_var['action'] == "account_deposit"): ?>
          <form name="formSurplus" method="post" action="user.php" onSubmit="return submitSurplus()">
            <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
              <tr>
                <td width="10%" align="right"><?php echo $this->_var['lang']['deposit_money']; ?>:</td>
                <td align="left"><input type="text" name="amount"  class="inputBg" value="<?php echo htmlspecialchars($this->_var['order']['amount']); ?>" size="30" /></td>
              </tr>
              <tr>
                <td align="right"><?php echo $this->_var['lang']['process_notic']; ?>:</td>
                <td align="left"><textarea name="user_note" cols="55" rows="6" style="border:1px solid #ddd;"><?php echo htmlspecialchars($this->_var['order']['user_note']); ?></textarea></td>
              </tr>
            </table>
            <div class="blank10"></div>
            <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
              <tr align="center">
                <td colspan="3" align="left"><?php echo $this->_var['lang']['payment']; ?>:</td>
              </tr>
              <tr align="center">
                <td><?php echo $this->_var['lang']['pay_name']; ?></td>
                <td width="60%"><?php echo $this->_var['lang']['pay_desc']; ?></td>
                <td width="17%"><?php echo $this->_var['lang']['pay_fee']; ?></td>
              </tr>
              <?php $_from = $this->_var['payment']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
              <tr>
                <td align="left"><input type="radio" name="payment_id" value="<?php echo $this->_var['list']['pay_id']; ?>" <?php if ($this->_var['list']['pay_code'] == 'alipay_bank'): ?>id="alipay_bank_input"<?php endif; ?>/>
                  <?php echo $this->_var['list']['pay_name']; ?></td>
                <td align="left"><?php echo $this->_var['list']['pay_desc']; ?></td>
                <td align="center"><?php echo $this->_var['list']['pay_fee']; ?></td>
                <?php if ($this->_var['list']['pay_code'] == 'alipay_bank'): ?>
                <tr><td colspan="3" style="background-color:#fff">
                <div class="payment_subbox"  style="display:block"> <?php echo $this->fetch('library/alipay_bank.lbi'); ?> </div>
                </tr></td>
                <?php endif; ?>
              </tr>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              <tr>
                <td colspan="3"  align="center"><input type="hidden" name="surplus_type" value="0" />
                  <input type="hidden" name="rec_id" value="<?php echo $this->_var['order']['id']; ?>" />
                  <input type="hidden" name="act" value="act_account" />
                  <input type="submit" class="main-btn main-btn-large" name="submit" value="<?php echo $this->_var['lang']['submit_request']; ?>" />
                  <input type="reset" class="main-btn main-btn-large" name="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" /></td>
              </tr>
            </table>
          </form>
          <?php endif; ?> 
          <?php if ($this->_var['action'] == "act_account"): ?>
          <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
            <tr>
              <td width="25%" align="right"><?php echo $this->_var['lang']['surplus_amount']; ?></td>
              <td width="80%"><?php echo $this->_var['amount']; ?></td>
            </tr>
            <tr>
              <td align="right"><?php echo $this->_var['lang']['payment_name']; ?></td>
              <td><?php echo $this->_var['payment']['pay_name']; ?></td>
            </tr>
            <tr>
              <td align="right"><?php echo $this->_var['lang']['payment_fee']; ?></td>
              <td><?php echo $this->_var['pay_fee']; ?></td>
            </tr>
            <tr>
              <td align="right" valign="middle"><?php echo $this->_var['lang']['payment_desc']; ?></td>
              <td><?php echo $this->_var['payment']['pay_desc']; ?></td>
            </tr>
            <tr>
              <td colspan="2"><?php echo $this->_var['payment']['pay_button']; ?></td>
            </tr>
          </table>
          <?php endif; ?> 
          <?php if ($this->_var['action'] == "account_detail"): ?>
          <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
            <tr align="center">
              <td><?php echo $this->_var['lang']['process_time']; ?></td>
              <td><?php echo $this->_var['lang']['surplus_pro_type']; ?></td>
              <td><?php echo $this->_var['lang']['money']; ?></td>
              <td><?php echo $this->_var['lang']['change_desc']; ?></td>
            </tr>
            <?php $_from = $this->_var['account_log']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
            <tr>
              <td align="center"><?php echo $this->_var['item']['change_time']; ?></td>
              <td align="center"><?php echo $this->_var['item']['type']; ?></td>
              <td align="center"><?php echo $this->_var['item']['amount']; ?></td>
              <td title="<?php echo $this->_var['item']['change_desc']; ?>">&nbsp;&nbsp;<?php echo $this->_var['item']['short_change_desc']; ?></td>
            </tr>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <tr>
              <td colspan="4" align="center"><div align="right">您当前消费的金额为：<?php echo $this->_var['surplus_amount']; ?></div></td>
            </tr>
            
            <tr>
              <td colspan="4" align="center"><div align="right"><?php echo $this->_var['lang']['current_surplus']; ?>￥<?php echo $this->_var['surplus_yue']; ?></div></td>
            </tr>
          </table>
          <?php echo $this->fetch('library/pages.lbi'); ?> 
          <?php endif; ?> 
          <?php if ($this->_var['action'] == "account_log"): ?>
          <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
            <tr align="center">
              <td><?php echo $this->_var['lang']['process_time']; ?></td>
              <td><?php echo $this->_var['lang']['surplus_pro_type']; ?></td>
              <td><?php echo $this->_var['lang']['money']; ?></td>
              <td><?php echo $this->_var['lang']['process_notic']; ?></td>
              <td><?php echo $this->_var['lang']['admin_notic']; ?></td>
              <td><?php echo $this->_var['lang']['is_paid']; ?></td>
              <td><?php echo $this->_var['lang']['handle']; ?></td>
            </tr>
            <?php $_from = $this->_var['account_log']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
            <tr>
              <td align="center"><?php echo $this->_var['item']['add_time']; ?></td>
              <td align="center"><?php echo $this->_var['item']['type']; ?></td>
              <td align="center"><?php echo $this->_var['item']['amount']; ?></td>
              <td align="center"><?php echo $this->_var['item']['short_user_note']; ?></td>
              <td align="center"><?php echo $this->_var['item']['short_admin_note']; ?></td>
              <td align="center"><?php echo $this->_var['item']['pay_status']; ?></td>
              <td align="center"><?php echo $this->_var['item']['handle']; ?> 
                <?php if (( $this->_var['item']['is_paid'] == 0 && $this->_var['item']['process_type'] == 1 ) || $this->_var['item']['handle']): ?> 
                <a href="user.php?act=cancel&id=<?php echo $this->_var['item']['id']; ?>" onclick="if (!confirm('<?php echo $this->_var['lang']['confirm_remove_account']; ?>')) return false;"><?php echo $this->_var['lang']['is_cancel']; ?></a> 
                <?php endif; ?></td>
            </tr>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <tr>
              <td colspan="7" align="right">您当前消费的金额为：<?php echo $this->_var['surplus_amount']; ?></td>
            </tr>
            
            <tr>
              <td colspan="7" align="right"><?php echo $this->_var['lang']['current_surplus']; ?>￥<?php echo $this->_var['surplus_yue']; ?></td>
            </tr>
          </table>
          <?php echo $this->fetch('library/pages.lbi'); ?> 
          <?php endif; ?> 
           
           
          <?php if ($this->_var['action'] == 'bonus'): ?> 
          <script type="text/javascript">
        <?php $_from = $this->_var['lang']['profile_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
          var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </script>
          <div class="tabmenu">
            <ul class="tab pngFix">
              <li class="active"  > <a href="#">红包</a> </li>
            </ul>
            <span class="ncm-btn" title="<?php echo $this->_var['lang']['bonus_number']; ?>">
            <form name="addBouns" action="user.php" method="post" onSubmit="return addBonus()">
              <input onblur="if(this.value=='') this.value='红包序列号';" onfocus="if(this.value=='红包序列号') this.value='';"  name="bonus_sn" type="text" size="10" class="inputBgb" value="<?php echo $this->_var['lang']['bonus_number']; ?>"/>
              <input type="hidden" name="act" value="act_add_bonus" class="inputBg" />
              <input type="submit" class="bnt_blue_b" style="border:none;" value="<?php echo $this->_var['lang']['add_bonus']; ?>" />
            </form>
            </span> </div>
          <div class="mar_top">
            <div id="tab_tab1_1">
              <ul class="bonus_con">
                <?php if ($this->_var['bonus']): ?> 
                <?php $_from = $this->_var['bonus']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'hong');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['hong']):
        $this->_foreach['name']['iteration']++;
?>
                
                <li <?php if ($this->_foreach['name']['iteration'] % 4 == 0): ?>style="margin:0px 0px 11px 0px"<?php endif; ?>>
                  <p class="bonus_con_1"><strong>￥</strong><span class="type_money"><?php echo $this->_var['hong']['type_money']; ?></span><span class="bonus_status"><?php echo $this->_var['hong']['status']; ?></span></p>
                  <?php if ($this->_var['hong']['bonus_sn']): ?><p>红包序列号：<?php echo empty($this->_var['hong']['bonus_sn']) ? 'N/A' : $this->_var['hong']['bonus_sn']; ?></p><?php endif; ?>
                  <p>发行店铺：<a href="<?php if (! $this->_var['hong']['s_id']): ?>index.php<?php else: ?>supplier.php?suppId=<?php echo $this->_var['hong']['s_id']; ?><?php endif; ?>" target="_blank"><?php if ($this->_var['hong']['supplier_id'] == "自营商"): ?><?php echo $this->_var['hong']['supplier_id']; ?><?php else: ?><?php echo $this->_var['hong']['supplier_id']; ?><?php endif; ?></a></p>
                  <p>使用条件：满<?php echo $this->_var['hong']['min_goods_amount']; ?></p>
                  <p>有效时间：截至<?php echo $this->_var['hong']['use_enddate']; ?></p>
                </li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                <?php else: ?>
                <li><?php echo $this->_var['lang']['user_bonus_empty']; ?></li>
                <?php endif; ?>
              </ul>
              <div class="blank5"></div>
              <?php echo $this->fetch('library/pages.lbi'); ?> </div>
          </div>
          <?php endif; ?> 
           
           
          <?php if ($this->_var['action'] == "vc_login"): ?>
           <div class="tabmenu">
              <ul class="tab pngFix">
                <li class="first active">储值卡充值</li>
              </ul>
          </div>
          <div class="blank"></div>
          <form action="" method="post" name="valueForm" id="valueForm" onSubmit="return valueLogin()">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#ffffff" style="border:1px solid #ddd;">
              <tr bgcolor="#ffffff">
              	<td colspan="2" align="left" style="padding:35px 0px 15px 30px;font-size:15px;">当前账户余额：<?php echo $this->_var['info']['surplus']; ?></td>
              </tr>
              <tr bgcolor="#ffffff">
                <td align="right" height="25px" width="20%">储值卡卡号：</td>
                <td width="80%"><input type="text" name="vcard"  size=30 class="inputBg">
                  <font color=#ff3300>*</font></td>
              </tr>
              <tr bgcolor="#ffffff">
                <td align="right" height="25px" width="20%">密码：</td>
                <td width="80%"><input type="password" name="pwd"   size=30 class="inputBg">
                  <font color=#ff3300>*</font></td>
              </tr>
              <tr bgcolor="#ffffff">
                <td align="right" height="25px" width="20%">充值账号：</td>
                <td width="80%"><input type="text"  name="card" value="<?php echo $_SESSION['user_name']; ?>" size=30 readonly class="inputBg" style="background:#eeeeee;">
                  <font color=#ff3300>* 默认为登录用户，不可编辑</font></td>
              </tr>
              <tr>
                <td></td>
                <td height=30><input type="hidden" name="act" value="vc_login_act">
                   <input name="submit" type="submit" class="main-btn main-btn-large" value="充值"  />
                </td>
              </tr>
              <tr>
                <td colspan=2 height=30></td>
              </tr>
            </table>
          </form>
          <script type="text/javascript">
          function valueLogin()
	 {
		var frm = document.forms['valueForm'];
		var vcard=frm.elements['vcard'].value;
		var pwd = frm.elements['pwd'].value;
		var msg = '';

		if (vcard.length == 0)
		{
			msg +=  '卡号不能为空\n';
		}
		if (pwd.length == 0)
		{
			msg +=  '密码不能为空\n';
		}

		if (msg.length > 0)
		{
			alert(msg);
			return false;
		}
		else
		{
			return true;
		}
	}
        </script> 
          <?php endif; ?> 
           
           
          <?php if ($this->_var['action'] == 'order_list'): ?> 
          
          <div class="tabmenu">
            <ul class="tab">
              <li class="active"> <a href="#"><?php echo $this->_var['lang']['label_order']; ?></a> </li>
            </ul>
          </div>
          <div id="J_Remide" class="remide-box">
            <h3>我的交易提醒：</h3>
            <ul>
              <li<?php if ($_GET['composite_status'] == '0'): ?> style="background:#E6E6E6; color:#FFF"
<?php endif; ?>><a href="user.php?act=order_list&composite_status=<?php echo $this->_var['status']['unconfirmed']; ?>" >未确认订单<span class="num">(<?php echo $this->_var['order_count']['unconfirmed']; ?>)</span></a></li>
              <li<?php if ($_GET['composite_status'] == '100'): ?> style="background:#E6E6E6; color:#FFF"
<?php endif; ?>><a href="user.php?act=order_list&composite_status=<?php echo $this->_var['status']['await_pay']; ?>">待付款<span class="num">(<?php echo $this->_var['order_count']['await_pay']; ?>)</span></a></li>
              <li<?php if ($_GET['composite_status'] == '101'): ?> style="background:#E6E6E6; color:#FFF"
<?php endif; ?>><a href="user.php?act=order_list&composite_status=<?php echo $this->_var['status']['await_ship']; ?>">待发货<span class="num">(<?php echo $this->_var['order_count']['await_ship']; ?>)</span></a></li>
              <li<?php if ($_GET['composite_status'] == '102'): ?> style="background:#E6E6E6; color:#FFF"
<?php endif; ?>><a href="user.php?act=order_list&composite_status=<?php echo $this->_var['status']['finished']; ?>">已成交订单数<span class="num">(<?php echo $this->_var['order_count']['finished']; ?>)</span></a></li>
            </ul>
          </div>
          <div class="extra-r" style="display:none">
            <div class="search-01">
              <input id="ip_keyword" name="" class="s-itxt" value="商品名称、商品编号、订单编号" onfocus="if (this.value==this.defaultValue) this.value=''" onblur="if (this.value=='') this.value=this.defaultValue" onkeydown="javascript:if(event.keyCode==13) OrderSearch('ip_keyword');" type="text">
              <!--input name="" type="button" value="查 询" class="btn-13" onclick="OrderSearch('ip_keyword')" clstag="click|keycount|orderinfo|search"/--> 
              <a href="javascript:;" class="btn-13" onclick="OrderSearch('ip_keyword')" clstag="click|keycount|orderinfo|search">查 询</a> </div>
            <div class="blank"></div>
          </div>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="bought-table">
            <thead>
              <tr class="col-name">
                <th width="32%" style="border-left: 1px solid #E6E6E6;">宝贝</th>
                <th width="10%">属性</th>
                <th width="9%">单价(元)</th>
                <th width="5%">数量</th>
                <th width="13%">售后</th>
                <th width="8%"><?php echo $this->_var['lang']['order_money']; ?></th>
                <th width="10%">状态</th>
                <th width="13%" style="border-right: 1px solid #E6E6E6;">操作</th>
              </tr>
            </thead>
            
            <?php $_from = $this->_var['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
            <tbody class="close-order">
              <tr class="sep-row">
                <td colspan="7"></td>
              </tr>
              <tr class="order-hd">
                <td colspan="8"><span class="no">
                  <label> 订单编号：<span class="order-num"><a href="user.php?act=order_detail&order_id=<?php echo $this->_var['item']['order_id']; ?>" class="main-color"><?php echo $this->_var['item']['order_sn']; ?></a>
                    <?php if ($this->_var['item']['is_suborder']): ?><?php echo $this->_var['item']['is_suborder']; ?><?php endif; ?></span> </label>
                  </span> <span class="deal-time">&nbsp;&nbsp;成交时间：<?php echo $this->_var['item']['order_time']; ?></span> <span class="deal-time">&nbsp;&nbsp;商家店铺：<?php echo $this->_var['item']['shopname']; ?></span>
                  
                  <a href="javascript:chat_online({chat_order_id: '<?php echo $this->_var['item']['order_id']; ?>', chat_supp_id: '<?php echo $this->_var['item']['supplier_id']; ?>'});" title="联系客服"><img src="themes/68ecshopcom_360buy/images/chat/web_logo.png" width="16" height="16" style="vertical-align:top;"/></a>
                  </td>
              </tr>
              <tr class="order-bd last">
                <td align="center" class="baobei no-border-right order_goods_info">
                <?php $_from = $this->_var['item']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>
                  
		  <div class="goods_desc <?php if (($this->_foreach['goods']['iteration'] == $this->_foreach['goods']['total'])): ?>last<?php endif; ?>"> <a class="pic" <?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] != 'package_buy'): ?>href="<?php if ($this->_var['goods']['extension_code'] == 'virtual_good'): ?>virtual_group_goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?><?php else: ?><?php echo $this->_var['goods']['url']; ?><?php endif; ?>"<?php else: ?><?php endif; ?> title="查看宝贝详情" target="_blank"> 
                    <?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] != 'package_buy'): ?> 
                    <img src="<?php echo $this->_var['goods']['thumb']; ?>" alt="查看宝贝详情" width="50" height="50">
                    <?php elseif ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] == 'package_buy'): ?> 
                    <img src="themes/68ecshopcom_360buy/images/jmpic/ico_cart_package.gif" alt="查看宝贝详情" width="50" height="50"/> 
                    <?php endif; ?> 
                    </a>
                    <div class="goods_name"><?php if ($this->_var['goods']['extension_code'] == 'virtual_good'): ?>【虚拟团购】<?php endif; ?> <?php echo $this->_var['goods']['goods_name']; ?></div>
                  </div>
                  
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></td>
                  <td align="center" class="baobei no-border-right order_goods_attr"><?php $_from = $this->_var['item']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>
                  
                  <div class="goods_desc goods_desc_t <?php if (($this->_foreach['goods']['iteration'] == $this->_foreach['goods']['total'])): ?>last<?php endif; ?>"> <?php if ($this->_var['goods']['goods_attr']): ?><?php echo nl2br($this->_var['goods']['goods_attr']); ?><?php endif; ?> </div>
                  
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></td>
                <td align="center" class="baobei no-border-right order_goods_info" style="padding:0px;" ><?php $_from = $this->_var['item']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>
                  
                  <div class="goods_desc price  <?php if (($this->_foreach['goods']['iteration'] == $this->_foreach['goods']['total'])): ?>last<?php endif; ?>" style="padding-left:0px; line-height:50px;"> <?php echo $this->_var['goods']['formated_goods_price']; ?> </div>
                  
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></td>
                <td align="center" class="baobei no-border-right order_goods_info"  style="padding:0px;"><?php $_from = $this->_var['item']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>
                  
                  <div class="goods_desc  <?php if (($this->_foreach['goods']['iteration'] == $this->_foreach['goods']['total'])): ?>last<?php endif; ?>" style="padding-left:0px;line-height:50px;"> <?php echo $this->_var['goods']['goods_number']; ?> </div>
                  
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></td>
 				<td align="center" class="after-service baobei no-border-right order_goods_info" valign="middle">
                <?php if (( $this->_var['item']['shipping_status'] == 0 || $this->_var['item']['shipping_status'] == 3 ) && $this->_var['item']['pay_status'] == 2): ?>
                    <?php if ($this->_var['item']['back_can'] == 1): ?> <a href="user.php?act=back_order&order_id=<?php echo $this->_var['item']['order_id']; ?>&order_all=1&x=1" class="main-color" >退款</a><br />
                    <?php else: ?>
                    <p>[已申请 退款]</p>
                    <?php endif; ?> 
                    <a href="user.php?act=message_list">留言/投诉</a> </div>
				</td>
                <?php else: ?>
				<?php $_from = $this->_var['item']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>
                
            	<?php if (( $this->_var['item']['extension_code'] != 'pre_sale' || $this->_var['item']['pre_sale_status'] > 1 ) && $this->_var['item']['extension_code'] != 'virtual_good'): ?>
                 <div class="goods_desc <?php if (($this->_foreach['goods']['iteration'] == $this->_foreach['goods']['total'])): ?>last<?php endif; ?>"> 
                    <?php if ($this->_var['item']['shipping_status'] != 0 && $this->_var['item']['shipping_status'] != 3): ?> 
                    <?php if ($this->_var['goods']['back_can'] == 1): ?>
                      <p><?php if ($this->_var['item']['shipping_status'] == 1): ?> 
                      <a href="user.php?act=back_order&order_id=<?php echo $this->_var['item']['order_id']; ?>&goods_id=<?php echo $this->_var['goods']['goods_id']; ?>&product_id=<?php echo $this->_var['goods']['product_id']; ?>&x=2" class="main-color">退货</a>
                      <?php else: ?>
                      <a href="user.php?act=back_order&order_id=<?php echo $this->_var['item']['order_id']; ?>&goods_id=<?php echo $this->_var['goods']['goods_id']; ?>&product_id=<?php echo $this->_var['goods']['product_id']; ?>" class="main-color">
                      <?php if ($this->_var['item']['weixiu_time'] == 0): ?>[申请返修 已超期]<?php else: ?>申请返修<?php endif; ?></a><?php endif; ?></p>
                    <?php else: ?>
                    <p>[已申请
                      <?php if ($this->_var['item']['shipping_status'] == 1): ?>退货<?php else: ?>返修<?php endif; ?>
                      ]</p>
                    <?php endif; ?> 
                    <?php endif; ?> 
                    <?php endif; ?>
                    <a href="user.php?act=message_list">留言/投诉</a> </div>
                  
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				 <?php endif; ?> 
				 </td>
				<td rowspan="1" align="center" class="amount no-border-right"><p class="post-type"><strong>
                
                <?php if ($this->_var['item']['extension_code'] == 'pre_sale' && $this->_var['item']['pre_sale_status'] == 1 && $this->_var['item']['pre_sale_deposit'] > 0): ?>
				<?php echo $this->_var['item']['pre_sale_deposit_format']; ?>
				<?php else: ?>
				<?php echo $this->_var['item']['total_fee']; ?>
                <?php endif; ?>
                </strong></p></td>
                <td rowspan="1" align="center" class="trade-status no-border-right"><?php echo $this->_var['item']['order_status']; ?><br/>
                  <a href="user.php?act=order_detail&order_id=<?php echo $this->_var['item']['order_id']; ?>" class="main-color">查看详情</a>
                  <?php if ($this->_var['item']['invoice_no'] && $this->_var['item']['shipping_name'] != '门店自提'): ?>
                  
                  <div style="position:relative">
                  
                  <?php if ($this->_var['item']['result_content']): ?>
                  
                  <div onmouseover="showSubNav('subNav_<?php echo $this->_var['item']['order_id']; ?>');"> 
                    <?php else: ?>
                <div onmouseover="showSubNav2('<?php echo $this->_var['item']['order_id']; ?>','<?php echo $this->_var['item']['invoices']['0']['shipping_name']; ?>','<?php echo $this->_var['item']['invoices']['0']['invoice_no']; ?>');">
                    <?php endif; ?> 
                <a href="javascript:;" class="nav_a">物流跟踪</a></div>
                    <div id="subNav_<?php echo $this->_var['item']['order_id']; ?>" class="wuliu" style="display:none; position:absolute;">
                      <?php if ($this->_var['item']['result_content']): ?> 
                        <div class="hidden_wuliu" onclick="hiddenSubNav('subNav_<?php echo $this->_var['item']['order_id']; ?>')"></div>
                        <ul class="rec-nav">
                        	<li class="selected"><a href='javascript:;'><?php echo $this->_var['item']['shipping_name']; ?></a></li>
                        </ul>
                      <div class="wuliu_info_con">
                      	<div class="wuliu_info_num">运单号：<?php echo $this->_var['item']['invoice_no']; ?></div>
                      	<?php echo $this->_var['item']['result_content']; ?> 
                      </div>
                      <?php else: ?>
                      <div class="hidden_wuliu" onclick="hiddenSubNav('subNav_<?php echo $this->_var['item']['order_id']; ?>')"></div>
						<ul id='ul_i_<?php echo $this->_var['item']['order_id']; ?>' class="rec-nav">
						<?php $_from = $this->_var['item']['invoices']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'invoice_info');$this->_foreach['name_i'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name_i']['total'] > 0):
    foreach ($_from AS $this->_var['invoice_info']):
        $this->_foreach['name_i']['iteration']++;
?>
							<li id="div_i_<?php echo $this->_var['item']['order_id']; ?>_<?php echo $this->_foreach['name_i']['iteration']; ?>"><a href='javascript:;' onclick="get_invoice_info2('<?php echo $this->_var['invoice_info']['shipping_name']; ?>','<?php echo $this->_var['invoice_info']['invoice_no']; ?>','<?php echo $this->_foreach['name_i']['iteration']; ?>','<?php echo $this->_var['item']['order_id']; ?>')">物流<?php echo $this->_foreach['name_i']['iteration']; ?></a></li>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
						</ul>
                      <div id="retData_<?php echo $this->_var['item']['order_id']; ?>"></div>
                      <?php endif; ?> 
                    </div>
                  </div>
                  
                <?php endif; ?> 
                </td>
                <td rowspan="1" align="center" class="other">
                	<?php if ($this->_var['item']['order_status1'] == 2 || $this->_var['item']['order_status1'] == 3): ?>
                  <?php else: ?> 
                  <?php if ($this->_var['item']['pay_status'] == 0 && ! empty ( $this->_var['item']['pay_id'] )): ?> 
                  <a href="user.php?act=order_detail&order_id=<?php echo $this->_var['item']['order_id']; ?>" class="on_money">立即付款</a><br />
                  
                  <?php endif; ?> 
                  <?php endif; ?> 
                  <font class="main-color"><?php echo $this->_var['item']['handler']; ?></font></br>
                  
                  <?php if ($this->_var['item']['shipping_status'] == 2): ?> 
                  <?php if ($this->_var['item']['comment_s'] == 0): ?> 
                  已全部评价 
                  <?php else: ?> 
                  <a href="user.php?act=my_comment&s=<?php echo $this->_var['item']['comment_s']; ?>&order_id=<?php echo $this->_var['item']['order_id']; ?>#commtr_<?php echo $this->_var['item']['comment_s']; ?>" class="on_comment">评价</a> 
                  <?php endif; ?><br />
                  
                  <?php if ($this->_var['item']['shaidan_s'] == 0): ?> 
                  已全部晒单 
                  <?php else: ?> 
                  <a href="user.php?act=shaidan_send&id=<?php echo $this->_var['item']['shaidan_s']; ?>" class="on_comment">晒单</a> 
                  <?php endif; ?><br />
                  
                  <?php endif; ?> 
                  <?php if ($this->_var['item']['shipping_status'] == 2 || $this->_var['item']['order_status1'] == 2 || $this->_var['item']['order_status1'] == 3): ?> 
                  <a href="goods.php?id=<?php echo $this->_var['item']['goods_list']['0']['goods_id']; ?>" target="_blank">再次购买</a> 
                  <?php endif; ?></td>
              </tr>
            </tbody>
            <script language="javascript" type="text/javascript">
		function showSubNav(id)
		{
			if (id != document.getElementById("s_have_hidden").value)
			{
				if (document.getElementById("s_have_hidden").value != 0)
				{
					var s_have_val = document.getElementById("s_have_hidden").value;
					document.getElementById(s_have_val).style.display = 'none';
				}
				document.getElementById(id).style.display = 'block';
				document.getElementById("s_have_hidden").value = id;
			}
		}
        function showSubNav2(id,express_id,express_no)
		{
			var _id = id;
			var id = 'subNav_'+id;
			if (id != document.getElementById("s_have_hidden").value)
			{
				if (document.getElementById("s_have_hidden").value != 0)
				{
					var s_have_val = document.getElementById("s_have_hidden").value;
					document.getElementById(s_have_val).style.display = 'none';
				}
				get_invoice_info2(express_id,express_no,1,_id);
				
				document.getElementById(id).style.display = 'block';
				document.getElementById("s_have_hidden").value = id;
			}
		}

        function hiddenSubNav(id)
		{
			document.getElementById(id).style.display = 'none';
			document.getElementById("s_have_hidden").value = 0;
		}
        </script> 
            
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </table>
          <script type="text/javascript">
          $(function(){
				$('.order_goods_info').find('.goods_desc').each(function(){
					$(this).css('height',$(this).parents('.order_goods_info').siblings('.order_goods_attr').find('.goods_desc').eq($(this).index()).height());
				});
		  })
          </script>
          <input id="s_have_hidden" value="0" type="hidden" />
          <div style="height:30px;line-heihgt:30px;clear:both"></div>
          <?php echo $this->fetch('library/pages.lbi'); ?> 
          <div style="height:30px;line-heihgt:30px;clear:both"></div> 
          <?php endif; ?> 
           
           
          <?php if ($this->_var['action'] == 'track_packages'): ?>
          <div class="tabmenu">
              <ul class="tab pngFix">
                <li class="first active"><?php echo $this->_var['lang']['label_track_packages']; ?></li>
              </ul>
          </div>
          <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#eeeeee" id="order_table">
            <tr align="center">
              <td bgcolor="#ffffff"><?php echo $this->_var['lang']['order_number']; ?></td>
              <td bgcolor="#ffffff"><?php echo $this->_var['lang']['handle']; ?></td>
            </tr>
            <?php $_from = $this->_var['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
            <tr>
              <td align="center" bgcolor="#ffffff"><a href="user.php?act=order_detail&order_id=<?php echo $this->_var['item']['order_id']; ?>"><?php echo $this->_var['item']['order_sn']; ?></a></td>
              <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['query_link']; ?></td>
            </tr>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </table>
          <script>
      var query_status = '<?php echo $this->_var['lang']['query_status']; ?>';
      var ot = document.getElementById('order_table');
      for (var i = 1; i < ot.rows.length; i++)
      {
        var row = ot.rows[i];
        var cel = row.cells[1];
        cel.getElementsByTagName('a').item(0).innerHTML = query_status;
      }
      </script>
          <div class="blank5"></div>
          <?php echo $this->fetch('library/pages.lbi'); ?> 
          <?php endif; ?> 
           
          <?php if ($this->_var['action'] == back_order_detail): ?>
          <div class="tabmenu">
            <ul class="tab pngFix">
              <li class="active">退款/退货/维修详情</li>
            </ul>
          </div>
          <table width="100%" border="0" cellpadding="10" cellspacing="1"  bgcolor="#eeeeee">
            <tr>
              <td width="100%" height=25  bgcolor="#FFFFFF" style="padding-left:10px" colspan="2">原订单号：<?php echo $this->_var['back_shipping']['order_sn']; ?></td>
            </tr>
            <tr>
              <td width="10%" height=25  bgcolor="#FFFFFF" style="padding-left:10px">商品名称：</td>
			  <td width="90%" height=25  bgcolor="#FFFFFF" style="padding-left:10px">
			  <?php $_from = $this->_var['back_shipping']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_info');if (count($_from)):
    foreach ($_from AS $this->_var['goods_info']):
?>
				<a href="goods.php?id=<?php echo $this->_var['goods_info']['goods_id']; ?>"><?php echo $this->_var['goods_info']['goods_name']; ?></a><br />
			  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			  </td>
            </tr>
            <tr>
              <td width="100%" height=25  bgcolor="#FFFFFF"  style="padding-left:10px" colspan="2">售后类型：<?php if ($this->_var['back_shipping']['back_type'] == 1): ?>退货<?php endif; ?><?php if ($this->_var['back_shipping']['back_type'] == 2): ?>换货<?php endif; ?><?php if ($this->_var['back_shipping']['back_type'] == 3): ?>申请返修<?php endif; ?><?php if ($this->_var['back_shipping']['back_type'] == 4): ?>退款（无需退货）<?php endif; ?></td>
            </tr>
          </table>
          <div class="blank"></div>
          <?php if ($this->_var['list_backgoods']['0']): ?>
          <table width="100%" border="0" cellpadding="5" cellspacing="1"  bgcolor="#eeeeee">
            <?php $_from = $this->_var['list_backgoods']['0']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'bgoods');if (count($_from)):
    foreach ($_from AS $this->_var['bgoods']):
?>
            <tr>
              <td width="15%" align=center bgcolor="#FFFFFF"><font color=#ff3300>退回商品</font></td>
              <td width="40%" bgcolor="#FFFFFF"><?php echo $this->_var['bgoods']['goods_name']; ?> </td>
              <?php if ($this->_var['bgoods']['goods_attr']): ?><td width="25%" bgcolor="#FFFFFF"><?php echo nl2br($this->_var['bgoods']['goods_attr']); ?></td><?php endif; ?> 
              <td width="10%" bgcolor="#FFFFFF">数量：<?php if ($this->_var['bgoods']['back_goods_number']): ?><?php echo $this->_var['bgoods']['back_goods_number']; ?><?php endif; ?> </td>
              <td width="10%" bgcolor="#FFFFFF">类型：退货 </td>
            </tr>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	    <tr> <td  align=center bgcolor="#FFFFFF">退款金额</td><td colspan=4 bgcolor="#FFFFFF">应退金额：<?php echo $this->_var['bgoods']['back_goods_money']; ?> </td></tr>
	    <tr><td  align=center bgcolor="#FFFFFF">处理状态</td><td colspan=4 bgcolor="#FFFFFF"><?php echo $this->_var['bgoods']['status_back']; ?></td></tr>
	    <tr><td align=center bgcolor="#FFFFFF">退款状态</td><td colspan=4 bgcolor="#FFFFFF"><?php echo $this->_var['bgoods']['status_refund']; ?> </td></tr>
	    </table>
	<?php endif; ?>
	<?php if ($this->_var['list_backgoods']['3']): ?>
	<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#eeeeee">
    <?php $_from = $this->_var['list_backgoods']['3']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'bgoods');if (count($_from)):
    foreach ($_from AS $this->_var['bgoods']):
?>
	<tr bgcolor=#ffffff >
	<td width="15%" align=center><font color=#ff3300>退回商品</font></td>
	<td width="40%"><?php echo $this->_var['bgoods']['goods_name']; ?> </td>
	<td width="25%"><?php if ($this->_var['bgoods']['goods_attr']): ?><?php echo nl2br($this->_var['bgoods']['goods_attr']); ?><?php endif; ?> </td>
	<td width="10%">数量：<?php if ($this->_var['bgoods']['back_goods_number']): ?><?php echo $this->_var['bgoods']['back_goods_number']; ?><?php endif; ?> </td>
	<td width="10%">类型：申请返修 </td></tr>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	<tr bgcolor=#ffffff ><td align=center>处理状态</td><td colspan=4><?php echo $this->_var['bgoods']['status_back']; ?></td></tr>
	</table>
	<?php endif; ?>
	<?php if ($this->_var['list_backgoods']['4']): ?>
	<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#eeeeee">
	<tr bgcolor=#ffffff>
	<td width="15%" align=center><font color=#ff3300>退回商品</font></td>
	<td>
	<table>
    <?php $_from = $this->_var['list_backgoods']['4']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'bgoods');if (count($_from)):
    foreach ($_from AS $this->_var['bgoods']):
?>
	<tr>
	<td width="40%"><?php echo $this->_var['bgoods']['goods_name']; ?> </td>
	<td width="25%"><?php if ($this->_var['bgoods']['goods_attr']): ?><?php echo nl2br($this->_var['bgoods']['goods_attr']); ?><?php endif; ?> </td>
	<td width="10%">数量：<?php if ($this->_var['bgoods']['back_goods_number']): ?><?php echo $this->_var['bgoods']['back_goods_number']; ?><?php endif; ?> </td>
	</tr>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</table>
	</td>
	<td width="10%">类型：退款<br />（无需退货） </td></tr>
	<tr bgcolor=#ffffff ><td  align=center>退款金额</td><td colspan=4>应退金额：<?php echo $this->_var['back_shipping']['refund_money_1']; ?> </td></tr>
	<tr bgcolor=#ffffff ><td  align=center>处理状态</td><td colspan=4><?php echo $this->_var['back_shipping']['status_back']; ?></td></tr>
	<tr bgcolor=#ffffff ><td  align=center>退款状态</td><td colspan=4><?php echo $this->_var['back_shipping']['status_refund']; ?> </td></tr>
	</table>
          <?php endif; ?>
          <div class="blank"></div>
          <?php if ($this->_var['list_backgoods']['1']): ?>
          <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#eeeeee">
            <?php $_from = $this->_var['list_backgoods']['1']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'bgoods');$this->_foreach['list_backgoods_1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['list_backgoods_1']['total'] > 0):
    foreach ($_from AS $this->_var['bgoods']):
        $this->_foreach['list_backgoods_1']['iteration']++;
?>
            <tr>
              <td width="15%" align=center bgcolor="#FFFFFF"><font color=#ff3300><?php if ($this->_foreach['list_backgoods_1']['iteration'] == 1): ?>退回<?php else: ?>换回<?php endif; ?>商品</font></td>
              <td width="40%" bgcolor="#FFFFFF"><?php echo $this->_var['bgoods']['goods_name']; ?></td>
              <td width="25%" bgcolor="#FFFFFF"><?php if ($this->_var['bgoods']['goods_attr']): ?>属性：<?php echo $this->_var['bgoods']['goods_attr']; ?><?php endif; ?> </td>
              <td width="10%" bgcolor="#FFFFFF">数量：<?php if ($this->_var['bgoods']['back_goods_number']): ?><?php echo $this->_var['bgoods']['back_goods_number']; ?><?php endif; ?> </td>
              <td width="10%" bgcolor="#FFFFFF"><?php if ($this->_foreach['list_backgoods_1']['iteration'] == 1): ?>类型：换货<?php endif; ?></td>
            </tr>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <tr>
              <td align=center bgcolor="#FFFFFF">退款金额</td>
              <td colspan=4 bgcolor="#FFFFFF">应退金额：<?php echo $this->_var['bgoods']['back_goods_money']; ?></td>
            </tr>
            <tr>
              <td align=center  bgcolor="#FFFFFF">处理状态</td>
              <td colspan=4 bgcolor="#FFFFFF"><?php echo $this->_var['bgoods']['status_back']; ?></td>
            </tr>
            <tr>
              <td align=center bgcolor="#FFFFFF">退款状态</td>
              <td colspan=4  bgcolor="#FFFFFF"><?php echo $this->_var['bgoods']['status_refund']; ?> </td>
            </tr>
          </table>
          <div class="blank"></div>
          <table width="100%" border="0" cellpadding="5" cellspacing="1"  bgcolor="#eeeeee">
            <tr>
              <td align=center width="15%"  bgcolor="#FFFFFF">寄回商品<br>
                收件人信息</td>
              <td colspan=4  bgcolor="#FFFFFF">商品寄回地址：<?php echo $this->_var['back_shipping']['country_name']; ?> <?php echo $this->_var['back_shipping']['province_name']; ?> <?php echo $this->_var['back_shipping']['city_name']; ?> <?php echo $this->_var['back_shipping']['district_name']; ?> <?php echo $this->_var['back_shipping']['address']; ?><br>
                邮政编码：<?php echo $this->_var['back_shipping']['zipcode']; ?><br>
                收件人：<?php echo $this->_var['back_shipping']['consignee']; ?><br></td>
            </tr>
            <tr>
              <td align=center width="15%"  bgcolor="#FFFFFF">退款信息</td>
              <td colspan=4  bgcolor="#FFFFFF">应退金额：<?php echo $this->_var['back_shipping']['refund_money_1']; ?>&nbsp;&nbsp;&nbsp;&nbsp;实退金额：<?php echo $this->_var['back_shipping']['refund_money_2']; ?></td>
            </tr>
            <tr>
              <td align=center width="15%"  bgcolor="#FFFFFF">退款形式</td>
              <td colspan=4  bgcolor="#FFFFFF"><?php echo $this->_var['back_shipping']['refund_type_name']; ?></td>
            </tr>
            <tr>
              <td align=center width="15%"  bgcolor="#FFFFFF">退款说明</td>
              <td colspan=4  bgcolor="#FFFFFF"><?php echo $this->_var['back_shipping']['refund_desc']; ?></td>
            </tr>
          </table>
          <?php endif; ?>
          <div class="blank"></div>
	<?php if ($this->_var['back_shipping']['back_type'] != 4 && ( $this->_var['back_shipping']['status_back_1'] < 1 || ( $this->_var['back_shipping']['status_back_1'] > 3 && $this->_var['back_shipping']['status_back_1'] < 6 ) )): ?>
          <div class="tabmenu">
            <ul class="tab pngFix">
              <li class="active"> <a href="#"> 快递信息（请填写您寄回商品的快递信息）：</a> </li>
            </ul>
          </div>
          <form action="user.php" method="post">
            <table width="100%" border="0" cellpadding="7" cellspacing="1" bgcolor="#eeeeee">
              <tr>
                <td width="100%"  style="padding-left:25px;"  bgcolor="#FFFFFF"> 快递公司：
                  <select name="shipping_id" size=1 style="vertical-align:middle;border:1px #ddd solid">
                    <option value="0">请选择快递公司</option>
                    
                    
                
                
	<?php $_from = $this->_var['shipping_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shipping');if (count($_from)):
    foreach ($_from AS $this->_var['shipping']):
?>
	
                
                
                    
                    <option value="<?php echo $this->_var['shipping']['shipping_id']; ?>" <?php if ($this->_var['back_shipping']['shipping_id'] == $this->_var['shipping']['shipping_id']): ?>selected<?php endif; ?> ><?php echo $this->_var['shipping']['shipping_name']; ?> </option>
                    
                    
                
                
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	
              
              
                  
                  </select>
                  快递运单号：
                  <input type="text" name="invoice_no" class="inputBg" size=20 value="<?php echo $this->_var['back_shipping']['invoice_no']; ?>" style=" vertical-align:middle">
                  <input type="submit" name="submit" class="main-btn main-btn-large" value="确定" <?php if ($this->_var['back_shipping']['status_back'] > 0 && $this->_var['back_shipping']['status_back'] < 5): ?>disabled<?php endif; ?>  style=" vertical-align:middle">
                  <input type="hidden" name="back_id" value="<?php echo $this->_var['back_id']; ?>">
                  <input type="hidden" name="act" value="back_order_detail_edit"></td>
              </tr>
            </table>
          </form>
    <?php endif; ?>
    <div class="blank"></div>
    <div class="tabmenu">
            <ul class="tab pngFix">
              <li class="active">留言/回复</li>
            </ul>
    </div>
    <table width="100%" cellspacing="1" cellpadding="6" style="border:1px #dddddd solid">
    <?php if ($this->_var['back_shipping']['postscript']): ?>
      <tr>
        <td width="50" align="right">我说：</td>
        <td><?php echo $this->_var['back_shipping']['postscript']; ?> （<?php echo $this->_var['back_shipping']['add_time']; ?>）</td>
      </tr>
      <?php endif; ?>
            <?php $_from = $this->_var['back_replay']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['value']):
?> 
            <?php if ($this->_var['value']['type'] == 0): ?>
            <tr style="color:#F00">
              <td align="right" bgcolor="#FFFFFF">客服：</td>
              <td bgcolor="#FFFFFF"><?php echo $this->_var['value']['message']; ?> （<?php echo $this->_var['value']['add_time']; ?>）</td>
            </tr>
            <?php else: ?>
            <tr>
              <td align="right" bgcolor="#FFFFFF">我说：</td>
              <td bgcolor="#FFFFFF"><?php echo $this->_var['value']['message']; ?> （<?php echo $this->_var['value']['add_time']; ?>）</td>
            </tr>
            <?php endif; ?> 
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <tr>
        <td valign="top" align="right">我说：</td>
              <td bgcolor="#FFFFFF"><script>
            function check_replay()
            {
                if (document.getElementById("message").value == '')
                {
                    alert("请输入回复内容！");
                    document.getElementById("message").focus();
                    return false;	
                }
            }
            </script>
                <form action="user.php?act=back_replay" method="post" onsubmit="return check_replay()">
                  <input name="back_id" type="hidden" value="<?php echo $this->_var['back_shipping']['back_id']; ?>">
                  <div>
                    <textarea id="message" name="message" style="width:500px; height:60px;"></textarea>
                  </div>
                  <div class="blank"></div>
                  <div>
                    <input type="submit" value="回复" class="main-btn main-btn-large" />
                  </div>
                </form></td>
            </tr>
          </table>
          
          <?php endif; ?> 
          
          <?php if ($this->_var['action'] == back_list): ?>
          <div class="tabmenu">
            <ul class="tab pngFix">
              <li class="active">退款/退货/维修订单列表</li>
            </ul>
          </div>
          <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#eeeeee">
            <tr align="center">
              <th bgcolor="#ffffff">退款/退货/维修<br>
                申请单号</th>
              <th bgcolor="#ffffff">原订单号</th>
              <th bgcolor="#ffffff" width="20%">商品名称</th>
              <th bgcolor="#ffffff">申请时间</th>
              <th bgcolor="#ffffff">应退金额</th>
              <th bgcolor="#ffffff"><?php echo $this->_var['lang']['order_status']; ?></th>
              <th bgcolor="#ffffff"><?php echo $this->_var['lang']['handle']; ?></th>
            </tr>
            <?php $_from = $this->_var['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
            <tr>
              <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['back_id']; ?></td>
              <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['order_sn']; ?></td>
              <td align="center" bgcolor="#ffffff" >
			  <?php $_from = $this->_var['item']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_info');if (count($_from)):
    foreach ($_from AS $this->_var['goods_info']):
?>
				  <a href="goods.php?id=<?php echo $this->_var['goods_info']['goods_id']; ?>"><?php echo $this->_var['goods_info']['goods_name']; ?></a><br />
			  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			  </td>
              <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['order_time']; ?></td>
              <td align="right" bgcolor="#ffffff"><?php echo $this->_var['item']['refund_money_1']; ?></td>
              <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['status_back']; ?></td>
            <td align="center" bgcolor="#ffffff"><?php if ($this->_var['item']['status_back'] == 0 && $this->_var['item']['status_back_1'] < 6 && $this->_var['item']['status_back_1'] != 3): ?><a href="user.php?act=del_back_order&id=<?php echo $this->_var['item']['back_id']; ?>" onclick="return confirm('你确认要取消吗？')">取消</a> | <?php endif; ?> <a href="user.php?act=back_order_detail&id=<?php echo $this->_var['item']['back_id']; ?>">查看</a></td>
            </tr>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </table>
          <div class="blank5"></div>
          <?php echo $this->fetch('library/pages.lbi'); ?>
          <div class="blank5"></div>
          <?php endif; ?> 
          
          <?php if ($this->_var['action'] == back_order): ?>
          <div class="tabmenu">
            <ul class="tab pngFix">
              <li class="active">退款\退货\维修 订单提交</li>
            </ul>
          </div>
          <script>
	function check_back_form()
	{
		if (document.getElementById("back_type_2").checked == true)
		{
			if (document.getElementById("huan_box").innerHTML == "")
			{
				alert("请添加换货商品！");
				document.getElementById("add_huan_btton").focus();
				show_huan_goods();
				return false;	
			}
		}
		
		if (document.getElementById("back_reason").value == '')
		{
			alert("请输入问题描述！");	
			document.getElementById("back_reason").focus();
			return false;
		}
		
		if (document.getElementById("back_type_2").checked == true || document.getElementById("back_type_3").checked == true)
		{
			if (document.getElementById("back_address").value == '')
			{
				alert("请输入收货地址！");	
				document.getElementById("back_address").focus();
				return false;
			}
			if (document.getElementById("back_zipcode").value == '')
			{
				alert("请输入邮政编码！");	
				document.getElementById("back_zipcode").focus();
				return false;
			}
			if (document.getElementById("back_consignee").value == '')
			{
				alert("请输入联系人姓名！");	
				document.getElementById("back_consignee").focus();
				return false;
			}
			if (document.getElementById("back_mobile").value == '')
			{
				alert("请输入手机号码！");	
				document.getElementById("back_mobile").focus();
				return false;
			}
		}
	}
	</script>
          <form action="user.php?act=back_order_act" name="theForm" id="theForm" method="post" onsubmit="return check_back_form();">
            <table width="100%" border="0" cellpadding="5" cellspacing="1"  bgcolor="#eeeeee">
              <?php if ($this->_var['order_info']): ?>
				<tr>
					<td bgcolor="#FFFFFF" colspan="5">订单编号：<?php echo $this->_var['order_info']['order_sn']; ?><?php if ($_GET['order_all'] == 1): ?> &nbsp;
                        订单已付金额（应退金额）：<?php if ($this->_var['order_info']['money_paid'] != 0): ?><?php echo $this->_var['order_info']['money_paid']; ?><?php else: ?><?php echo $this->_var['order_info']['surplus']; ?><?php endif; ?><?php endif; ?></td>
				</tr>
				<tr>
					<td align=center bgcolor="#FFFFFF">商品名称</td>
					<td align=center bgcolor="#FFFFFF">商品属性</td>
					<td align=center bgcolor="#FFFFFF">商品价格</td>
					<td align=center bgcolor="#FFFFFF">购买数量</td>
					<td align=center bgcolor="#FFFFFF">小计</td>
				</tr>
				<?php $_from = $this->_var['order_info']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_info');if (count($_from)):
    foreach ($_from AS $this->_var['goods_info']):
?>
				<tr>
					<td align=center bgcolor="#FFFFFF"><?php echo $this->_var['goods_info']['goods_name']; ?> </td>
					<td bgcolor="#FFFFFF"><?php echo $this->_var['goods_info']['goods_attr']; ?></td>
					<td align=center bgcolor="#FFFFFF"><?php echo $this->_var['goods_info']['goods_price_format']; ?></td>
					<td align=center bgcolor="#FFFFFF"><?php echo $this->_var['goods_info']['goods_number']; ?></td>
					<td align=center bgcolor="#FFFFFF"><?php echo $this->_var['goods_info']['total_price_format']; ?></td>
				</tr>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			  <?php else: ?>
				<tr>
					<td align=center bgcolor="#FFFFFF">订单编号</td>
					<td align=center bgcolor="#FFFFFF">商品名称</td>
					<td align=center bgcolor="#FFFFFF">商品属性</td>
					<td align=center bgcolor="#FFFFFF">商品价格</td>
					<td align=center bgcolor="#FFFFFF">购买数量</td>
					<td align=center bgcolor="#FFFFFF">小计</td>
				</tr>
				<tr>
					<td align=center bgcolor="#FFFFFF"><?php echo $this->_var['back_goods']['order_sn']; ?></td>
					<td align=center bgcolor="#FFFFFF"><?php echo $this->_var['back_goods']['goods_name']; ?> </td>
					<td bgcolor="#FFFFFF"><?php echo $this->_var['back_goods']['goods_attr']; ?></td>
					<td align=center bgcolor="#FFFFFF"><?php echo $this->_var['back_goods']['goods_price_format']; ?></td>
					<td align=center bgcolor="#FFFFFF"><?php echo $this->_var['back_goods']['goods_number']; ?></td>
					<td align=center bgcolor="#FFFFFF"><?php echo $this->_var['back_goods']['total_price_format']; ?></td>
				</tr>
			  <?php endif; ?>
            </table>
            <div class="blank"></div>
            <div class="blank"></div>
            <table width="100%" border="0" cellpadding="5" cellspacing="1" >
              <tr>
                <td width="15%" align="right" valign=top>服务类型：</td>
        <td>
        	<?php if ($this->_var['back_goods']['shipping_time_end'] == 0): ?>
		<?php if ($_GET['x'] != 1): ?><input type="radio" name="back_type" id="back_type_1" value="1" <?php if ($_GET['x'] != 1): ?>checked="checked" <?php endif; ?>onclick="tui_box_show(3)" />退货　<?php endif; ?>
            <!--<input type="radio" name="back_type" id="back_type_2" value="2" onclick="tui_box_show(2)" />换货　-->
            <input type="radio" name="back_type" id="back_type_4" value="4" <?php if ($_GET['x'] == 1): ?>checked="checked" <?php endif; ?>onclick="tui_box_show(3)" />退款（无需退货）　
            <?php else: ?>
            <input type="radio" name="back_type" id="back_type_3" value="3" checked="checked" />申请返修
            <?php endif; ?>
            
            <input type="hidden" name="tui_goods_price" value ="<?php echo $this->_var['back_goods']['goods_price']; ?>">
            <input type="hidden" name="product_id_tui" value ="<?php echo $this->_var['back_goods']['product_id']; ?>" >
            <input type="hidden" name="goods_attr_tui" value ="<?php echo $this->_var['back_goods']['goods_attr']; ?>" >
        </td>
              </tr>
              <tr id="thh_2" style="display:none">
                <td width="15%" align="right" valign=top></td>
                <td><div>
                    <input type="button" name="add_huan_btton" id="add_huan_btton" value="添加换货商品" onclick="javascript:show_huan_goods();">
                    <font color=#ff3300>（*）</font> </div>
                  <table id="huan_goods" style="padding:10px;background:#eee;display:none;">
                    <tr>
                      <td align=right>商品名称：</td>
                      <td><?php echo $this->_var['back_goods']['goods_name']; ?> </td>
                    </tr>
                    <?php $_from = $this->_var['specification']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('spec_key', 'spec');if (count($_from)):
    foreach ($_from AS $this->_var['spec_key'] => $this->_var['spec']):
?> 
                    <?php if ($this->_var['spec']['attr_type'] == 1): ?>
                    <tr>
                      <td valign=top style="padding-top:5px;" align=right><?php echo $this->_var['spec']['name']; ?>：</td>
                      <td ><div class="catt"> 
                          <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?> 
                          <a <?php if ($this->_var['key'] == 0): ?>class="cattsel"<?php endif; ?> onclick="changeAtt(this,<?php echo $this->_var['back_goods']['goods_id']; ?>)" href="javascript:;" name="<?php echo $this->_var['value']['id']; ?>" title="[<?php if ($this->_var['value']['price'] > 0): ?><?php echo $this->_var['lang']['plus']; ?><?php elseif ($this->_var['value']['price'] < 0): ?><?php echo $this->_var['lang']['minus']; ?><?php endif; ?> <?php echo $this->_var['value']['format_price']; ?>]"><?php echo $this->_var['value']['label']; ?>
                          <input style="display:none" id="spec_value_<?php echo $this->_var['value']['id']; ?>" type="radio" name="spec_<?php echo $this->_var['spec_key']; ?>" value="<?php echo $this->_var['value']['id']; ?>" <?php if ($this->_var['key'] == 0): ?>checked<?php endif; ?> />
                          </a> 
                          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                        </div>
                        <input type="hidden" name="spec_list" value="<?php echo $this->_var['key']; ?>" /></td>
                    </tr>
                    <?php endif; ?> 
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <tr>
                      <td colspan=2><input type="button" value="确定" onclick="add_huan_goods(<?php echo $this->_var['back_goods']['goods_id']; ?>);"></td>
                    </tr>
                  </table>
                  <table id="huan_box" >
                  </table></td>
              </tr>
              <tr>
				<?php if ($_GET['x'] == 1): ?>
                <td width="15%" align="right" valign=top>退款提示：</td>
                <td>申请退款，将取消整笔订单，并退回您该笔订单款项，如有需要请重新下单。</td>
				<?php else: ?>
                <td width="15%" align="right" valign=top>提交数量：</td>
                <td><script>
			function check_tui_goods_number()
			{
				var now_number = Number(document.getElementById("tui_goods_number").value);
				var goods_number = <?php echo $this->_var['back_goods']['goods_number']; ?>;
				if (now_number < 1)
				{
					alert("提交数量不能小于1");
					document.getElementById("tui_goods_number").value = 1;
					document.getElementById("tui_goods_number").focus();
				}
				else if (now_number > goods_number)
				{
					alert("提交数量不能超过购买数量"+goods_number);
					document.getElementById("tui_goods_number").value = goods_number;
					document.getElementById("tui_goods_number").focus();
				}
			}
			</script>
                  <input type="text" name="tui_goods_number" id="tui_goods_number" onblur="check_tui_goods_number()" value="1" size=5 class="inputBg"></td>
				  <?php endif; ?>
              </tr>
              <tr>
                <td width="15%" align="right" valign=top>问题描述：</td>
                <td><textarea name="back_reason" id="back_reason" rows=5 cols=50></textarea>
                  <font color=#ff3300>（*）</font>
                  <div style="color:#999">请您如实填写申请原因及商品情况，字数在500字内。</div></td>
              </tr>
              <tr>
                <td width="15%" align="right" valign=top>图片信息：</td>
                <td><link rel="stylesheet" href="includes/kindeditor/themes/default/default.css" />
                  <script src="includes/kindeditor/kindeditor.js"></script> 
                  <script src="includes/kindeditor/lang/zh_CN.js"></script> 
                  <script>
                KindEditor.ready(function(K) {
                    var editor = K.editor({
                        allowFileManager : true
                    });
                    K('#back_order_img').click(function() {
                        editor.loadPlugin('image', function() {
                            editor.plugin.imageDialog({
                                showRemote : false,
                                //imageUrl : K('#url3').val(),
                                clickFn : function(url, title, width, height, border, align) {
									K('#back_order_img_list').append('<div><img height="60" src="' + url + '"><input type="hidden" name="imgs[]" value="' + url + '" /></div>');
                                    editor.hideDialog();
                                }
                            });
                        });
                    });
                });
            </script>
                  <style>
			#back_order_img_list div {float:left; margin:0 10px 10px 0;}
			</style>
                  <div id="back_order_img_list" class="clearfix"> </div>
                  <div><img id="back_order_img" src="themes/68ecshopcom_360buy/images/back_order_img.gif" /></div>
                  <div style="margin-top:10px;">为了帮助我们更好的解决问题，请您上传图片</div>
                  <div style="color:#999">每张图片大小不超过2M，支持gif,jpg,png,jpeg格式文件</div></td>
              </tr>
    <?php if ($this->_var['back_goods']['shipping_time_end'] == 0): ?>
    <tr id="thh_1">
    <?php else: ?>
    <tr id="thh_1" style="display:none">
    <?php endif; ?>
                <td width="15%" align="right" valign=top>退款方式：</td>
                <td><input type="radio" name="back_pay" value="1" />
                  退款至账户余额<br />
                  <input type="radio" name="back_pay" value="2" checked="checked" />
                  原支付方式返回
                  <div style="color:#999; padding-left:20px;">如为现金支付，将会退款至您的账户余额或银行卡；</div>
                  <div style="color:#999; padding-left:20px;">请您在 <a href="#" style="color:#005ea7">退款说明</a> 中查看退款时效</div></td>
              </tr>
    <?php if ($_GET['x'] == 1 || $_GET['x'] == 2): ?>
	<tbody id="thh_address" style="display:none">
    <?php else: ?>
	<tbody id="thh_address">
    <?php endif; ?>
                <tr>
                  <td width="15%" align="right" >收货地址：</td>
                  <td> <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js,transport.js,region.js,shopping_flow.js')); ?>
                    <select name="country" id="selCountries_1" onchange="region.changed(this, 1, 'selProvinces_1')">
                      <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['0']; ?></option>
                      <?php $_from = $this->_var['country_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'country');if (count($_from)):
    foreach ($_from AS $this->_var['country']):
?>
                      <option value="<?php echo $this->_var['country']['region_id']; ?>" <?php if ($this->_var['order']['country'] == $this->_var['country']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['country']['region_name']; ?></option>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </select>
                    <select name="province" id="selProvinces_1" onchange="region.changed(this, 2, 'selCities_1')">
                      <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['1']; ?></option>
                      <?php $_from = $this->_var['shop_province']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
                      <option value="<?php echo $this->_var['province']['region_id']; ?>" <?php if ($this->_var['order']['province'] == $this->_var['province']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['province']['region_name']; ?></option>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </select>
                    <select name="city" id="selCities_1" onchange="region.changed(this, 3, 'selDistricts_1')">
                      <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['2']; ?></option>
                      <?php $_from = $this->_var['shop_city']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'city');if (count($_from)):
    foreach ($_from AS $this->_var['city']):
?>
                      <option value="<?php echo $this->_var['city']['region_id']; ?>" <?php if ($this->_var['order']['city'] == $this->_var['city']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['city']['region_name']; ?></option>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </select>
                    <select name="district" id="selDistricts_1" <?php if (! $this->_var['shop_district']): ?>style="display:none"<?php endif; ?>>
                      <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['3']; ?></option>
                      <?php $_from = $this->_var['shop_district']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'district');if (count($_from)):
    foreach ($_from AS $this->_var['district']):
?>
                      <option value="<?php echo $this->_var['district']['region_id']; ?>" <?php if ($this->_var['order']['district'] == $this->_var['district']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['district']['region_name']; ?></option>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </select>
                    <div style=" display: inline-block">
                    <input type="text" name="back_address" id="back_address" size=50 value="<?php echo $this->_var['order']['address']; ?>" class="inputBg">
                    <font color=#ff3300>（*）</font></div></td>
                </tr>
                <tr>
                  <td width="15%" align="right" >邮政编码：</td>
                  <td><input type="text" name="back_zipcode"  id="back_zipcode" size=20 value="<?php echo $this->_var['order']['zipcode']; ?>" class="inputBg">
                    <font color=#ff3300>（*）</font></td>
                </tr>
                <tr>
                  <td width="15%" align="right" >联系人姓名：</td>
                  <td><input type="text" name="back_consignee"  id="back_consignee" size=20 value="<?php echo $this->_var['order']['consignee']; ?>" class="inputBg">
                    <font color=#ff3300>（*）</font></td>
                </tr>
                <tr>
                  <td width="15%" align="right" >手机号码：</td>
                  <td><input type="text" name="back_mobile"  id="back_mobile" size=20 value="<?php echo $this->_var['order']['mobile']; ?>" class="inputBg">
                    <font color=#ff3300>（*）</font></td>
                </tr>
              </tbody>
              <tr>
                <td width="15%" align="right" >我要留言：</td>
                <td><textarea name="back_postscript" rows=5 cols=50></textarea></td>
              </tr>
              <tr>
                <td colspan=2 align=center><input type="hidden" name="act" value="back_order_act">
                  <?php if ($this->_var['order_info']): ?>
				  <input type="hidden" name="order_all" value="1">
                  <input type="hidden" name="order_id" value="<?php echo $this->_var['order_info']['order_id']; ?>">
				  <?php else: ?>
				  <input type="hidden" name="order_id" value="<?php echo $this->_var['back_goods']['order_id']; ?>">
                  <input type="hidden" name="order_sn" value="<?php echo $this->_var['back_goods']['order_sn']; ?>">
                  <input type="hidden" name="goods_id" value="<?php echo $this->_var['back_goods']['goods_id']; ?>">
                  <input type="hidden" name="goods_name" value="<?php echo $this->_var['back_goods']['goods_name']; ?>">
                  <input type="hidden" name="goods_sn" value="<?php echo $this->_var['back_goods']['goods_sn']; ?>">
				  <?php endif; ?>
                  <input name="submit" type="submit" value="确认" class="main-btn main-btn-large"/>
                  <input type="button" value="取消" class="main-btn main-btn-large" onclick="history.go(-1)"/>
				</td>
              </tr>
            </table>
            <script>

	function show_huan_goods()
	{
	   if (document.getElementById('huan_goods').style.display=="block")
	   {
		document.getElementById('huan_goods').style.display="none";
	   }
	   else if(document.getElementById('huan_goods').style.display=="none")
	   {
		document.getElementById('huan_goods').style.display="block";
	   }
	}

	function changeAtt(t,goods_id) {
	t.lastChild.checked='checked';
	for (var i = 0; i<t.parentNode.childNodes.length;i++) {
		if (t.parentNode.childNodes[i].className == 'cattsel') {
		t.parentNode.childNodes[i].className = '';
		}
	}

	t.className = "cattsel";	
	}

	function  add_huan_goods(goods_id)
	{
	   var goods        = new Object();
	   var formBuy      = document.forms['theForm'];
	   spec_arr = getSelectedAttributes(formBuy);
	   goods.spec     = spec_arr;
	   goods.goods_id = goods_id;
	   Ajax.call('user.php?act=add_huan_goods', 'goods=' + goods.toJSONString(), add_huan_goodsResponse, 'POST', 'JSON');
	}
       function rand_str(prefix)
	{
	var dd = new Date();
	 var tt = dd.getTime();
	tt = prefix + tt;

	var rand = Math.random();
	rand = Math.floor(rand * 100);

	return (tt + rand);
	}

	function add_huan_goodsResponse(result)
	{
		var table_list = document.getElementById('huan_box');
		var new_tr_id = rand_str('t');
		var index = table_list.rows.length; 
		var new_row = table_list.insertRow(index);//新增行
		new_row.setAttribute("id", new_tr_id);
		var new_col = new_row.insertCell(0);
		new_col.innerHTML =  result.goods_name + result.content + '<input type="hidden" name="product_id_huan[]" id="pro_"'+index+' value="' + result.product_id + '"><input type="hidden" name="goods_attr_huan[]" value="' + result.content + '"><input type="button" class="button" value="删除 " onclick="javascript:del_huan_goods(\'' + new_tr_id + '\');"/>';
	
	}


	function del_huan_goods(tr_number)
	{
	if (tr_number.length > 0)
	{
		if (confirm("确定删除吗？") == false)
		{
			return false;
		}
		var table_list = document.getElementById('huan_box');
		for (var i = 0; i < table_list.rows.length; i++)
		{
		if (table_list.rows[i].id == tr_number)
		{
		 table_list.deleteRow(i);
		}
		}
	}
	return true;
	}

	function tui_box_show(type)
	{
		if (type == 1)
		{
			document.getElementById("thh_1").style.display = '';
			document.getElementById("thh_2").style.display = 'none';
			document.getElementById("thh_4").style.display = '';
			document.getElementById("thh_address").style.display = '';
		}
		
		if (type == 2)
		{
			document.getElementById("thh_1").style.display = 'none';
			document.getElementById("thh_2").style.display = '';
			document.getElementById("thh_4").style.display = '';
			document.getElementById("thh_address").style.display = '';
		}
		
		if (type == 3)
		{
			document.getElementById("thh_1").style.display = '';
			document.getElementById("thh_2").style.display = 'none';
			document.getElementById("thh_4").style.display = '';
			document.getElementById("thh_address").style.display = 'none';
		}
		
	}

	function check_back(frm)
	{
	var back_number = <?php echo $this->_var['back_goods']['goods_number']; ?>;
	//alert(back_number);
	var msg = new Array();
	var err = false; 
	if (frm.elements['back_consignee'].value == "" )
	{
	     err = true;
	     msg.push('换回商品收件人不能为空！');
        }
	if (frm.elements['back_address'].value == "" )
	{
	     err = true;
	     msg.push('收货人地址不能为空！');
        }
	
	var back_type_list = frm.elements["back_type"];
	var tui_goods_number=0;
	var huan_goods_number=0;
	if (back_type_list[0].checked == true)
	{
		tui_goods_number = frm.elements['tui_goods_number'].value;		
	}
	if (back_type_list[1].checked == true)
	{
		var table_list = document.getElementById('huan_box');
		huan_goods_number = table_list.rows.length;
	}
	var all_goods_number = Number(huan_goods_number) + Number(tui_goods_number);
	var old_goods_number =frm.elements['old_goods_number'].value;
	//alert(all_goods_number);
	if (all_goods_number > old_goods_number)
	{
	     err = true;
	     msg.push('退货/维修总数不能大于原订单购买数量！');
	}

	if (err)
	{
	    message = msg.join("\n");
	    alert(message);
	}
	return ! err;
	}
	</script>
          </form>
          
          <?php endif; ?> 
          
          <?php if ($this->_var['action'] == back_order_act): ?>
          <div class="tabmenu">
            <ul class="tab pngFix">
              <li class="active"> 
    <?php if ($this->_var['back_act_w'] == 'tuihuo'): ?>
    退货&nbsp;申请已提交
    <?php elseif ($this->_var['back_act_w'] == 'tuikuan'): ?>
	退款&nbsp;申请已提交
    <?php elseif ($this->_var['back_act_w'] == 'weixiu'): ?>
    维修&nbsp;申请已提交
    <?php endif; ?>
    </li>
            </ul>
          </div>
          <table cellpadding=5 cellspacing=1 width=100% bgcolor="#eeeeee">
            <tr>
              <td bgcolor="#FFFFFF" style="font-size:15px;font-weight:bold;line-height:180%;padding:20px;color:#555"> 
    	<?php if ($this->_var['back_act_w'] == 'tuihuo'): ?>
	      商品寄回地址：<?php echo $this->_var['back_address']; ?><br>
                邮政编码：<?php echo $this->_var['back_zipcode']; ?><br>
                收件人：<?php echo $this->_var['back_consignee']; ?> 
		</td>
            </tr>
            <tr>
              <td bgcolor="#FFFFFF" style="padding:10px 20px 20px 30px"> 1、请尽快将退换货商品寄出<br>
	2、退货商品寄出后，请您在“用户中心 》退款/退货及维修 》详情”中填写快递信息<br>
	3、您随时可以在“退款/退货及维修”中查看退货进度<br>
                4、如果您有其他需要，请随时联系我们的客服。 </td>
    <?php elseif ($this->_var['back_act_w'] == 'tuikuan'): ?>
    退款申请已提交，请耐心等待卖家处理。
    <?php elseif ($this->_var['back_act_w'] == 'weixiu'): ?>
    维修申请已提交，请耐心等待卖家处理。<br>
	商品寄回地址：<?php echo $this->_var['back_address']; ?><br>
	邮政编码：<?php echo $this->_var['back_zipcode']; ?><br>
	收件人：<?php echo $this->_var['back_consignee']; ?>
    <?php endif; ?>
	</td>
            </tr>
            <tr>
              <td bgcolor="#FFFFFF" align=center><input type="button" value="确定" onclick='location.href="user.php?act=back_list";' style="cursor:pointer;border:none; background:#ED5854;color:#fff;padding:5px 15px"></td>
            </tr>
          </table>
          <?php endif; ?> 
           
          <?php if ($this->_var['action'] == order_detail): ?>
          
          <input type="hidden" id="chat_order_id" name="chat_order_id" value="<?php echo $this->_var['order']['order_id']; ?> "/>
          <div class="tabmenu">
              <ul class="tab pngFix">
                <li class="first active"><?php echo $this->_var['lang']['order_status']; ?></li>
              </ul>
          </div>
          <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee" class="order_detail">
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['detail_order_sn']; ?>：</td>
              <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['order_sn']; ?> 
                <?php if ($this->_var['order']['extension_code'] == "group_buy"): ?> 
                <a href="./group_buy.php?act=view&id=<?php echo $this->_var['order']['extension_id']; ?>" class="main-color"><strong><?php echo $this->_var['lang']['order_is_group_buy']; ?></strong></a> 
                 <?php elseif ($this->_var['order']['extension_code'] == "pre_sale"): ?> 
                <a href="./pre_sale.php?act=view&id=<?php echo $this->_var['order']['extension_id']; ?>" class="main-color"><strong><?php echo $this->_var['lang']['order_is_pre_sale']; ?></strong></a> 
                <?php elseif ($this->_var['order']['extension_code'] == "exchange_goods"): ?> 
                <a href="./exchange.php?act=view&id=<?php echo $this->_var['order']['extension_id']; ?>" class="main-color"><strong><?php echo $this->_var['lang']['order_is_exchange']; ?></strong></a> 
                <?php endif; ?> 
                <a href="user.php?act=message_list&order_id=<?php echo $this->_var['order']['order_id']; ?>" class="main-color">[<?php echo $this->_var['lang']['business_message']; ?>]</a></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['detail_order_status']; ?>：</td>
              <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['order_status']; ?><?php echo $this->_var['order']['confirm_time']; ?></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['detail_pay_status']; ?>：</td>
              <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['pay_status']; ?><?php if ($this->_var['order']['order_amount'] > 0): ?><?php echo $this->_var['order']['pay_online']; ?><?php endif; ?><?php echo $this->_var['order']['pay_time']; ?></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['detail_shipping_status']; ?>：</td>
              <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['shipping_status']; ?><?php echo $this->_var['order']['shipping_time']; ?></td>
            </tr>
            <?php if ($this->_var['order']['invoice_no']): ?>
            <tr>
              <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['consignment']; ?>：</td>
              <td align="left" bgcolor="#ffffff" id="invoice_no"><?php echo $this->_var['order']['invoice_no']; ?></td>
            </tr>
            <?php endif; ?> 
            
          </table>
          <br/>
          <?php if ($this->_var['order']['invoice_no'] && $this->_var['order']['shipping_name'] != '门店自提'): ?>
          	<?php if ($this->_var['order']['tc_express']): ?>
          <div class="tabmenu">
              <ul class="tab pngFix">
				  <li class="first active">物流跟踪 [ 本单为同城快递，信息由本网站提供 ] </li>
				</ul>
			  </div>
              <div class="blank"></div>
	  		  <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
				<tr>
				  <td bgcolor="#ffffff"><?php echo $this->_var['result_content']; ?></td>
				</tr>
			  </table>
	  		<?php else: ?>
			  <div class="tabmenu">
				<ul class="tab pngFix">
                <li class="first active">物流跟踪</li>
              </ul>
          </div>
       	  <div class="blank"></div>
          <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
            <tr>
              <td bgcolor="#ffffff" class="wuliu_rec_nav">
              	<ul id='ul_i' class="rec-nav">
				<?php $_from = $this->_var['order']['invoices']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'invoice_info');$this->_foreach['name_i'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name_i']['total'] > 0):
    foreach ($_from AS $this->_var['invoice_info']):
        $this->_foreach['name_i']['iteration']++;
?>
    				<li id="div_i_<?php echo $this->_foreach['name_i']['iteration']; ?>"><a href='javascript:;' onclick="get_invoice_info('<?php echo $this->_var['invoice_info']['shipping_name']; ?>','<?php echo $this->_var['invoice_info']['invoice_no']; ?>','<?php echo $this->_foreach['name_i']['iteration']; ?>')">物流<?php echo $this->_foreach['name_i']['iteration']; ?></a></li>
  				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</ul>
              	<div id="retData"></div>
              </td>
            </tr>
          </table>
			<?php endif; ?>
          <?php endif; ?>
          <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee" >
             
            <?php if ($this->_var['order']['to_buyer']): ?>
            <tr>
              <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['detail_to_buyer']; ?>：</td>
              <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['to_buyer']; ?></td>
            </tr>
            <?php endif; ?> 
            
            <?php if ($this->_var['virtual_card']): ?>
            <tr>
              <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['virtual_card_info']; ?>：</td>
              <td colspan="3" align="left" bgcolor="#ffffff"><?php $_from = $this->_var['virtual_card']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'vgoods');if (count($_from)):
    foreach ($_from AS $this->_var['vgoods']):
?> 
                <?php $_from = $this->_var['vgoods']['info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'card');if (count($_from)):
    foreach ($_from AS $this->_var['card']):
?> 
                <?php if ($this->_var['card']['card_sn']): ?><?php echo $this->_var['lang']['card_sn']; ?>:<span style="color:red;"><?php echo $this->_var['card']['card_sn']; ?></span><?php endif; ?> 
                <?php if ($this->_var['card']['card_password']): ?><?php echo $this->_var['lang']['card_password']; ?>:<span style="color:red;"><?php echo $this->_var['card']['card_password']; ?></span><?php endif; ?> 
                <?php if ($this->_var['card']['end_date']): ?><?php echo $this->_var['lang']['end_date']; ?>:<?php echo $this->_var['card']['end_date']; ?><?php endif; ?><br />
                
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></td>
            </tr>
            <?php endif; ?>
          </table>
          <div class="blank"></div>
           <div class="tabmenu">
              <ul class="tab pngFix">
                <li class="first active"><?php echo $this->_var['lang']['goods_list']; ?></li>
              </ul>
          </div>
          <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
            <tr>
              <th width="32%" align="center" bgcolor="#ffffff"><?php echo $this->_var['lang']['goods_name']; ?></th>
              <th width="13%" align="center" bgcolor="#ffffff"><?php echo $this->_var['lang']['goods_attr']; ?></th>
              <!--<th><?php echo $this->_var['lang']['market_price']; ?></th>-->
              <th width="15%" align="center" bgcolor="#ffffff"><?php echo $this->_var['lang']['goods_price']; ?><?php if ($this->_var['order']['extension_code'] == "group_buy"): ?><?php echo $this->_var['lang']['gb_deposit']; ?><?php endif; ?></th>
              <th width="9%" align="center" bgcolor="#ffffff"><?php echo $this->_var['lang']['number']; ?></th>
              <th width="17%" align="center" bgcolor="#ffffff"><?php echo $this->_var['lang']['subtotal']; ?></th>
              <!-- 
              <th width="21%" align="center" bgcolor="#ffffff">申请退换货</th>
               -->
            </tr>
            <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
            <tr>
              <td bgcolor="#ffffff"><?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] != 'package_buy'): ?> 
              
                <a href="<?php if ($this->_var['goods']['extension_code'] == 'virtual_good'): ?>virtual_group_goods.php<?php else: ?>goods.php<?php endif; ?>?id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank"><?php echo $this->_var['goods']['goods_name']; ?></a> 
                <?php if ($this->_var['goods']['parent_id'] > 0): ?> 
                <span style="color:#DD0000">（<?php echo $this->_var['lang']['accessories']; ?>）</span> 
                <?php elseif ($this->_var['goods']['is_gift']): ?> 
                <span style="color:#DD0000">（<?php echo $this->_var['lang']['largess']; ?>）</span> 
                <?php endif; ?> 
                <?php elseif ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] == 'package_buy'): ?> 
                <a href="javascript:void(0)" onclick="setSuitShow(<?php echo $this->_var['goods']['goods_id']; ?>)"><?php echo $this->_var['goods']['goods_name']; ?><span style="color:#DD0000;">（礼包）</span></a>
                <div id="suit_<?php echo $this->_var['goods']['goods_id']; ?>" style="display:none"> 
                  <?php $_from = $this->_var['goods']['package_goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'package_goods_list');if (count($_from)):
    foreach ($_from AS $this->_var['package_goods_list']):
?>
                  <div class="clearfix" style="padding:5px 0;">
                    <div style="width:50px; height:50px; float:left;"><img src="<?php echo $this->_var['package_goods_list']['goods_thumb']; ?>" width="50" height="50"></div>
                    <div style="float:left; width:262px; margin:5px 5px 0 5px;"><a href="goods.php?id=<?php echo $this->_var['package_goods_list']['goods_id']; ?>" target="_blank" ><?php echo $this->_var['package_goods_list']['goods_name']; ?></a></div>
                  </div>
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                </div>
                
                <?php endif; ?></td>
              <td align="center" bgcolor="#ffffff"><?php echo nl2br($this->_var['goods']['goods_attr']); ?></td>
              <!--<td align="right"><?php echo $this->_var['goods']['market_price']; ?></td>-->
              <td align="center" bgcolor="#ffffff"><?php echo $this->_var['goods']['goods_price']; ?></td>
              <td align="center" bgcolor="#ffffff"><?php echo $this->_var['goods']['goods_number']; ?></td>
              <td align="center" bgcolor="#ffffff"><?php echo $this->_var['goods']['subtotal']; ?></td>
             <!-- 
              <td align="center" bgcolor="#ffffff">
                <?php if ($this->_var['goods']['extension_code'] == 'virtual_good'): ?>不支持此功能<?php else: ?>
                <?php if ($this->_var['not_back'] == 0): ?>
                <?php if ($this->_var['order']['shipping_status_id'] == '1' || $this->_var['order']['shipping_status_id'] == '2' || $this->_var['order']['shipping_status_id'] == '4'): ?> <font color=#ff3300> <?php if ($this->_var['goods']['back_can']): ?>
                [<a href="user.php?act=back_order&order_id=<?php echo $this->_var['order']['order_id']; ?>&goods_id=<?php echo $this->_var['goods']['goods_id']; ?>&product_id=<?php echo $this->_var['goods']['product_id']; ?>" style="color:#ff3300;">申请返修/退换货</a>]
                <?php else: ?>	      
                [已申请]
                <?php endif; ?> </font> <?php endif; ?>
                <?php else: ?> <font style="color:#ff3300;">[暂不可申请退换货,请在规定时间内申请]</font> <?php endif; ?><?php endif; ?>
                </td>
            </tr>
             -->
			</tr>
            <?php if ($this->_var['goods']['virtual_goods_card']): ?>
            <tr>
            	<td colspan="8" bgcolor="#ffffff">
                     <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#eeeeee">
                        <tr>
                            <th align="center" bgcolor="#ffffff">验证码</th>
                            <th align="center" bgcolor="#ffffff">过期时间</th>
                            <th align="center" bgcolor="#ffffff">验证时间</th>
                            <th align="center" bgcolor="#ffffff">状态</th>
                        </tr>
                     	<?php $_from = $this->_var['goods']['virtual_goods_card']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'virtual_goods_card');if (count($_from)):
    foreach ($_from AS $this->_var['virtual_goods_card']):
?>
                        <tr>
                            <td align="center" bgcolor="#ffffff"><?php echo $this->_var['virtual_goods_card']['card_sn']; ?></td>
                            <td align="center" bgcolor="#ffffff"><?php echo $this->_var['virtual_goods_card']['end_date']; ?></td>
                            <td align="center" bgcolor="#ffffff"><?php if ($this->_var['virtual_goods_card']['buy_date'] == ''): ?>未使用<?php else: ?><?php echo $this->_var['virtual_goods_card']['buy_date']; ?><?php endif; ?></td>
                            <td align="center" bgcolor="#ffffff">
                            <?php if ($this->_var['virtual_goods_card']['buy_date_time'] == '' && time() < $this->_var['virtual_goods_card']['end_date_time']): ?> <div class="countdown" end_date ="<?php echo $this->_var['virtual_goods_card']['end_date']; ?>"></div><?php endif; ?>
                            <?php if ($this->_var['virtual_goods_card']['buy_date_time'] == '' && time() > $this->_var['virtual_goods_card']['end_date_time']): ?>已经过期<?php endif; ?>
                            <?php if ($this->_var['virtual_goods_card']['buy_date_time'] != ''): ?>已使用<?php endif; ?>
                        	</td>
                        </tr>
                      	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </table>
                </td>
            </tr>
            <?php endif; ?>
            <script>
                    $(function(){
                    updateEndTime();
                    });
                    function updateEndTime(){    
                        var date = new Date();
                        var time = date.getTime();
                            $(".countdown").each(function(i){
                    
                            var endDate = this.getAttribute("end_date"); //结束时间字符串
                            //转换为时间日期类型
                            var endDate1 = eval('new Date(' + endDate.replace(/\d+(?=-[^-]+$)/, function (a) {return parseInt(a, 10) - 1;}).match(/\d+/g) + ')');
                    
                            var endTime = endDate1.getTime(); //结束时间毫秒数
                    
                            var lag = (endTime - time) / 1000; //当前时间和结束时间之间的秒数
                             if(lag > 0)
                             {
                              var second = Math.floor(lag % 60);     
                              var minite = Math.floor((lag / 60) % 60);
                              var hour = Math.floor((lag / 3600) % 24);
                              var day = Math.floor((lag / 3600) / 24);
                              $(this).html("剩余时间:"+day+"天"+hour+"小时"+minite+"分"+second+"秒");
                             }
                             else
                              $(this).css('display','none');
                            });   
                             setTimeout("updateEndTime()",1000);
                        }
                        
                    </script>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <tr>
              <td colspan="8" bgcolor="#ffffff" align="right"> <?php echo $this->_var['lang']['shopping_money']; ?><?php if ($this->_var['order']['extension_code'] == "group_buy"): ?><?php echo $this->_var['lang']['gb_deposit']; ?><?php endif; ?>: <?php echo $this->_var['order']['formated_goods_amount']; ?> </td>
            </tr>
          </table>
          <div class="blank"></div>
          <div class="tabmenu">
              <ul class="tab pngFix">
                <li class="first active"><?php echo $this->_var['lang']['fee_total']; ?></li>
              </ul>
          </div>
          <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
            <tr>
              <td align="right" bgcolor="#ffffff"> <?php echo $this->_var['lang']['goods_all_price']; ?><?php if ($this->_var['order']['extension_code'] == "group_buy"): ?><?php echo $this->_var['lang']['gb_deposit']; ?><?php endif; ?>: <?php echo $this->_var['order']['formated_goods_amount']; ?> 
                <?php if ($this->_var['order']['discount'] > 0): ?> 
                - <?php echo $this->_var['lang']['discount']; ?>: <?php echo $this->_var['order']['formated_discount']; ?> 
                <?php endif; ?> 
                <?php if ($this->_var['order']['tax'] > 0): ?> 
                + <?php echo $this->_var['lang']['tax']; ?>: <?php echo $this->_var['order']['formated_tax']; ?> 
                <?php endif; ?> 
                <?php if ($this->_var['order']['shipping_fee'] > 0): ?> 
                + <?php echo $this->_var['lang']['shipping_fee']; ?>: <?php echo $this->_var['order']['formated_shipping_fee']; ?> 
                <?php endif; ?> 
                <?php if ($this->_var['order']['insure_fee'] > 0): ?> 
                + <?php echo $this->_var['lang']['insure_fee']; ?>: <?php echo $this->_var['order']['formated_insure_fee']; ?> 
                <?php endif; ?> 
                <?php if ($this->_var['order']['pay_fee'] > 0): ?> 
                + <?php echo $this->_var['lang']['pay_fee']; ?>: <?php echo $this->_var['order']['formated_pay_fee']; ?> 
                <?php endif; ?> 
                <?php if ($this->_var['order']['pack_fee'] > 0): ?> 
                + <?php echo $this->_var['lang']['pack_fee']; ?>: <?php echo $this->_var['order']['formated_pack_fee']; ?> 
                <?php endif; ?> 
                <?php if ($this->_var['order']['card_fee'] > 0): ?> 
                + <?php echo $this->_var['lang']['card_fee']; ?>: <?php echo $this->_var['order']['formated_card_fee']; ?> 
                <?php endif; ?></td>
            </tr>
            <?php if ($this->_var['order']['money_paid'] > 0 || $this->_var['order']['surplus'] > 0 || $this->_var['order']['integral_money'] > 0 || $this->_var['order']['bonus'] > 0): ?>
            <tr>
              <td align="right" bgcolor="#ffffff"><?php if ($this->_var['order']['money_paid'] > 0): ?> 
                - <?php echo $this->_var['lang']['order_money_paid']; ?>: <?php echo $this->_var['order']['formated_money_paid']; ?> 
                <?php endif; ?> 
                <?php if ($this->_var['order']['surplus'] > 0): ?> 
                - <?php echo $this->_var['lang']['use_surplus']; ?>: <?php echo $this->_var['order']['formated_surplus']; ?> 
                <?php endif; ?> 
                <?php if ($this->_var['order']['integral_money'] > 0): ?> 
                - <?php echo $this->_var['lang']['use_integral']; ?>: <?php echo $this->_var['order']['formated_integral_money']; ?> 
                <?php endif; ?> 
                <?php if ($this->_var['order']['bonus'] > 0): ?> 
                - <?php echo $this->_var['lang']['use_bonus']; ?>: <?php echo $this->_var['order']['formated_bonus']; ?> 
                <?php endif; ?></td>
            </tr>
            <?php endif; ?>
            <tr>
              <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['order_amount']; ?>: <?php echo $this->_var['order']['formated_order_amount']; ?> 
                <?php if ($this->_var['order']['extension_code'] == "group_buy"): ?>
                <br />
                <?php echo $this->_var['lang']['notice_gb_order_amount']; ?>
                <?php elseif ($this->_var['order']['extension_code'] == "pre_sale"): ?>
                <br />
                <?php echo $this->_var['lang']['notice_ps_order_amount']; ?>
                <?php endif; ?>
                </td>
            </tr>
            <?php if ($this->_var['allow_edit_surplus']): ?>
            <tr>
              <td align="right" bgcolor="#ffffff"><form action="user.php" method="post" name="formFee" id="formFee">
                  <?php echo $this->_var['lang']['use_more_surplus']; ?>:
                  <input name="surplus" type="text" size="8" value="0" style="border:1px solid #ccc;padding:3px 5px"/>
                  <?php echo $this->_var['max_surplus']; ?> 
                  
                  <input onclick="return check_surplus_open(this.form);" type="submit" name="Submit" class="main-btn main-btn-large" value="<?php echo $this->_var['lang']['button_submit']; ?>"/>
                  
                  <input type="hidden" name="act" value="act_edit_surplus" />
                  <input type="hidden" name="order_id" value="<?php echo $_GET['order_id']; ?>" />
                  <input type="hidden" id="order_amount" value="<?php echo $this->_var['order']['order_amount']; ?> " />
                </form></td>
            </tr>
            <?php endif; ?>
          </table>
          <div class="blank"></div>
<?php if ($this->_var['order']['exist_real_goods'] == false): ?>
        <div class="tabmenu">
              <ul class="tab pngFix">
                <li class="first active">绑定手机</li>
              </ul>
          </div>
    <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
        <tr>
                <td width="15%" align="right" bgcolor="#ffffff">绑定手机号 : </td><td width="85%" align="left" bgcolor="#ffffff"><?php echo $this->_var['mobile_phone']; ?>&nbsp&nbsp&nbsp&nbsp&nbsp<!--<input type="button" value="重新发送验证码">--></td>
        </tr>
    </table>
     <?php endif; ?>

          <div class="tabmenu">
              <ul class="tab pngFix">
                <li class="first active"><?php echo $this->_var['lang']['consignee_info']; ?></li>
              </ul>
          </div>
          <?php if ($this->_var['order']['allow_update_address'] > 0): ?>
          <form action="user.php" method="post" name="formAddress" id="formAddress">
            <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
              <tr>
                <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['consignee_name']; ?>： </td>
                <td width="35%" align="left" bgcolor="#ffffff"><input name="consignee" type="text"  class="inputBg" value="<?php echo htmlspecialchars($this->_var['order']['consignee']); ?>" size="25"></td>
                <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['email_address']; ?>： </td>
                <td width="35%" align="left" bgcolor="#ffffff"><input name="email" type="text"  class="inputBg" value="<?php echo htmlspecialchars($this->_var['order']['email']); ?>" size="25" /></td>
              </tr>
              <?php if ($this->_var['order']['exist_real_goods']): ?> 
              
              <tr>
                <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['detailed_address']; ?>： </td>
                <td align="left" bgcolor="#ffffff"><input name="address" type="text" class="inputBg" value="<?php echo htmlspecialchars($this->_var['order']['address']); ?> " size="25" /></td>
                <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['postalcode']; ?>：</td>
                <td align="left" bgcolor="#ffffff"><input name="zipcode" type="text"  class="inputBg" value="<?php echo htmlspecialchars($this->_var['order']['zipcode']); ?>" size="25" /></td>
              </tr>
              <?php endif; ?>
              <tr>
                <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['phone']; ?>：</td>
                <td align="left" bgcolor="#ffffff"><input name="tel" type="text" class="inputBg" value="<?php echo htmlspecialchars($this->_var['order']['tel']); ?>" size="25" /></td>
                <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['backup_phone']; ?>：</td>
                <td align="left" bgcolor="#ffffff"><input name="mobile" type="text"  class="inputBg" value="<?php echo htmlspecialchars($this->_var['order']['mobile']); ?>" size="25" /></td>
              </tr>
              <?php if ($this->_var['order']['exist_real_goods']): ?> 
              
              <tr>
                <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['sign_building']; ?>：</td>
                <td align="left" bgcolor="#ffffff"><input name="sign_building" class="inputBg" type="text" value="<?php echo htmlspecialchars($this->_var['order']['sign_building']); ?>" size="25" /></td>
                <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['deliver_goods_time']; ?>：</td>
                <td align="left" bgcolor="#ffffff"><input name="best_time" type="text" class="inputBg" value="<?php echo htmlspecialchars($this->_var['order']['best_time']); ?>" size="25" /></td>
              </tr>
              <?php endif; ?>
              <tr>
                <td colspan="4" align="center" bgcolor="#ffffff"><input type="hidden" name="act" value="save_order_address" />
                  <input type="hidden" name="order_id" value="<?php echo $this->_var['order']['order_id']; ?>" />
                  <input type="submit" class="main-btn main-btn-large" value="<?php echo $this->_var['lang']['update_address']; ?>"  /></td>
              </tr>
            </table>
          </form>
          <?php else: ?>
          <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['consignee_name']; ?>：</td>
              <td width="35%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['consignee']; ?></td>
              <td width="15%" align="right" bgcolor="#ffffff" ><?php echo $this->_var['lang']['email_address']; ?>：</td>
              <td width="35%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['email']; ?></td>
            </tr>
            <?php if ($this->_var['order']['exist_real_goods']): ?>
            <tr>
              <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['detailed_address']; ?>：</td>
              <td colspan="3" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['province_name']; ?> <?php echo $this->_var['order']['city_name']; ?> <?php echo $this->_var['order']['district_name']; ?> <?php echo $this->_var['order']['address']; ?> 
                <?php if ($this->_var['order']['zipcode']): ?> 
                [<?php echo $this->_var['lang']['postalcode']; ?>: <?php echo $this->_var['order']['zipcode']; ?>] 
                <?php endif; ?></td>
            </tr>
            <?php endif; ?>
            <tr>
              <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['phone']; ?>：</td>
              <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['tel']; ?> </td>
              <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['backup_phone']; ?>：</td>
              <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['mobile']; ?></td>
            </tr>
            <?php if ($this->_var['order']['exist_real_goods']): ?>
            <tr>
              <td align="right" bgcolor="#ffffff" ><?php echo $this->_var['lang']['postalcode']; ?>：</td>
              <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['zipcode']; ?> </td>
              <td align="right" bgcolor="#ffffff" ><?php echo $this->_var['lang']['deliver_goods_time']; ?>：</td>
              <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['best_time']; ?></td>
            </tr>
            <?php endif; ?>
          </table>
          <?php endif; ?>
          <div class="blank"></div>
          <div class="tabmenu">
              <ul class="tab pngFix">
                <li class="first active"><?php echo $this->_var['lang']['payment']; ?></li>
              </ul>
          </div>
          <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
            <tr>
              <td bgcolor="#ffffff"> <?php echo $this->_var['lang']['select_payment']; ?>: <?php echo $this->_var['order']['pay_name']; ?>。<?php echo $this->_var['lang']['order_amount']; ?>: <strong><?php echo $this->_var['order']['formated_order_amount']; ?></strong><br />
                <?php echo $this->_var['order']['pay_desc']; ?> </td>
            </tr>
            <?php if ($this->_var['payment_list']): ?>
            <tr>
              <td bgcolor="#ffffff" align="right">
                
                <form name="payment" method="post" action="user.php">
                  <?php echo $this->_var['lang']['change_payment']; ?>:
                  <select name="pay_code" onchange="choose_payment(this.value)">
                    <?php $_from = $this->_var['payment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');if (count($_from)):
    foreach ($_from AS $this->_var['payment']):
?>
                    <option value="<?php echo $this->_var['payment']['pay_code']; ?>"> <?php echo $this->_var['payment']['pay_name']; ?>(<?php echo $this->_var['lang']['pay_fee']; ?>:<?php echo $this->_var['payment']['format_pay_fee']; ?>) </option>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                  </select>
                  <div class="payment_subbox" id="payment_subbox" style="display:none">

                    <?php echo $this->fetch('library/alipay_bank.lbi'); ?> </div>
                  <input type="hidden" name="act" value="act_edit_payment" />
                  <input type="hidden" name="order_id" value="<?php echo $this->_var['order']['order_id']; ?>" />
                  <input type="submit" name="Submit" class="main-btn main-btn-large" value="<?php echo $this->_var['lang']['button_submit']; ?>" />
                </form>
                <script>
				
				function choose_payment(pay_id)
				{
					if(pay_id == 'alipay_bank')
					{	
						document.getElementById('payment_subbox').style.display = 'block';
					}
					else
					{
						document.getElementById('payment_subbox').style.display = 'none';
					}
					
				}
				</script></td>
            </tr>
            <?php endif; ?>
          </table>
          <div class="blank"></div>
           <div class="tabmenu">
              <ul class="tab pngFix">
                <li class="first active"><?php echo $this->_var['lang']['other_info']; ?></li>
              </ul>
          </div>
          <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#eeeeee">
            <?php if ($this->_var['order']['shipping_id'] > 0): ?>
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['shipping']; ?>：</td>
              <td colspan="3" width="85%" align="left" bgcolor="#ffffff" id="shipping_name"><?php echo $this->_var['order']['shipping_name']; ?></td>
            </tr>
            <?php endif; ?>
            
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['payment']; ?>：</td>
              <td colspan="3" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['pay_name']; ?></td>
            </tr>
            <?php if ($this->_var['order']['insure_fee'] > 0): ?> 
            <?php endif; ?> 
            <?php if ($this->_var['order']['pack_name']): ?>
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['use_pack']; ?>：</td>
              <td colspan="3" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['pack_name']; ?></td>
            </tr>
            <?php endif; ?> 
            <?php if ($this->_var['order']['card_name']): ?>
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['use_card']; ?>：</td>
              <td colspan="3" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['card_name']; ?></td>
            </tr>
            <?php endif; ?> 
            <?php if ($this->_var['order']['card_message']): ?>
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['bless_note']; ?>：</td>
              <td colspan="3" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['card_message']; ?></td>
            </tr>
            <?php endif; ?> 
            <?php if ($this->_var['order']['surplus'] > 0): ?> 
            <?php endif; ?> 
            <?php if ($this->_var['order']['integral'] > 0): ?>
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['use_integral']; ?>：</td>
              <td colspan="3" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['integral']; ?></td>
            </tr>
            <?php endif; ?> 
            <?php if ($this->_var['order']['bonus'] > 0): ?> 
            <?php endif; ?> 
             
            <?php if ($this->_var['order']['inv_type'] == 'vat_invoice'): ?>
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['inv_type']; ?>：</td>
              <td colspan="3" width="36%" align="left" bgcolor="#ffffff"><?php echo $this->_var['lang'][$this->_var['order']['inv_type']]; ?></td>
            </tr>
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['inv_content']; ?>：</td>
              <td width="36%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['inv_content']; ?></td>
              <td width="19%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['label_company_name1']; ?></td>
              <td width="25%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['vat_inv_company_name']; ?></td>
            </tr>
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['label_taxpayer_id']; ?></td>
              <td width="36%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['vat_inv_taxpayer_id']; ?></td>
              <td width="19%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['label_registration_address']; ?></td>
              <td width="25%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['vat_inv_registration_address']; ?></td>
            </tr>
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['label_registration_phone']; ?></td>
              <td width="36%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['vat_inv_registration_phone']; ?></td>
              <td width="19%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['label_deposit_bank']; ?></td>
              <td width="25%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['vat_inv_deposit_bank']; ?></td>
            </tr>
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['label_bank_account']; ?></td>
              <td width="36%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['vat_inv_bank_account']; ?></td>
              <td width="19%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['label_inv_consignee_name']; ?></td>
              <td width="25%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['inv_consignee_name']; ?></td>
            </tr>
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['label_inv_consignee_phone']; ?></td>
              <td width="36%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['inv_consignee_phone']; ?></td>
              <td width="19%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['label_inv_consignee_address']; ?></td>
              <td width="25%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['inv_complete_address']; ?></td>
            </tr>
            <?php endif; ?> 
            
            <?php if ($this->_var['order']['inv_type'] == 'normal_invoice'): ?>
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['inv_type']; ?>：</td>
              <td width="36%" align="left" bgcolor="#ffffff"><?php echo $this->_var['lang'][$this->_var['order']['inv_type']]; ?></td>
              <td width="19%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['inv_payee']; ?>：</td>
              <td width="25%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['inv_payee']; ?></td>
            </tr>
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['inv_content']; ?>：</td>
              <td colspan="3" width="36%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['inv_content']; ?></td>
            </tr>
            <?php endif; ?> 
             
            
            <?php if ($this->_var['order']['postscript']): ?>
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['order_postscript']; ?>：</td>
              <td colspan="3" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['postscript']; ?></td>
            </tr>
            <?php endif; ?>
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['booking_process']; ?>：</td>
              <td colspan="3" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['how_oos_name']; ?></td>
            </tr>
          </table>
          <?php endif; ?> 
          
          
          <?php if ($this->_var['action'] == "tg_login"): ?>
          <div class="tabmenu">
            <ul class="tab pngFix">
              <li class="first active">提货券</li>
            </ul>
          </div>
          <div class="mar_top">
            <form action="" method="post" name="valueForm" id="valueForm" onSubmit="return valueLogin()">
              <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#ffffff" style="border:1px solid #eee;border-top:1px solid #eee;padding-top:35px;">
                <tr >
                  <td align="right" height="25px" width="30%">请输入您的提货券号码：</td>
                  <td width="80%"><input type="text" name="tcard"  class="inputBg" size=30>
                    <font color=#ff3300>*</font></td>
                </tr>
                <tr >
                  <td align="right" height="25px" width="30%">请输入您的提货券密码：</td>
                  <td width="80%"><input type="password" name="pwd"  class="inputBg" size=20>
                    <font color=#ff3300>*</font></td>
                </tr>
                <tr>
                  <td></td>
                  <td height=30><input type="hidden" name="act" value="tg_login_act">
                    <input type="submit" name="submit" class="main-btn main-btn-large" value="确认" ></td>
                </tr>
                <tr>
                  <td colspan=2 height=30></td>
                </tr>
              </table>
            </form>
          </div>
          <script type="text/javascript">
          function valueLogin(){
				var frm = document.forms['valueForm'];
				var vcard=frm.elements['vcard'].value;
				var pwd = frm.elements['pwd'].value;
				var msg = '';
		
				if (vcard.length == 0){
					msg +=  '卡号不能为空\n';
				}
				if (pwd.length == 0){
					msg +=  '密码不能为空\n';
				}
		
				if (msg.length > 0){
					alert(msg);
					return false;
				}else{
					return true;
				}
			}
        	</script> 
          <?php endif; ?> 
          <?php if ($this->_var['action'] == 'tg_order'): ?>
          <div class="tabmenu">
            <ul class="tab pngFix">
              <li class="first active"><a><?php echo $this->_var['lang']['takegoods_order_list']; ?></a></li>
            </ul>
          </div>
          <div class="mar_top">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#eeeeee">
              <tr align="center">
                <th bgcolor="#ffffff">提货券卡号</th>
                <th bgcolor="#ffffff">提货商品</th>
                <th bgcolor="#ffffff">提货时间</th>
                <th bgcolor="#ffffff">提货地址</th>
                <th bgcolor="#ffffff">提货状态</th>
              </tr>
              <?php $_from = $this->_var['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
              <tr>
                <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['tg_sn']; ?></td>
                <td align="center" bgcolor="#ffffff"><a href="<?php echo $this->_var['item']['goods_url']; ?>" class="f6"><?php echo $this->_var['item']['goods_name']; ?></a></td>
                <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['add_time']; ?></td>
                <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['address']; ?></td>
                <td align="center" bgcolor="#ffffff"> 
                	<?php if ($this->_var['item']['order_status'] == '1'): ?> 
                    <a href="user.php?act=tg_order_confirm&id=<?php echo $this->_var['item']['rec_id']; ?>"> 
                    <?php endif; ?> 
                    <font color=<?php if ($this->_var['item']['order_status'] == '2'): ?>#ff3300<?php else: ?>#F52648<?php endif; ?>><?php echo $this->_var['item']['order_status_name']; ?></font> 
                    <?php if ($this->_var['item']['order_status'] == '1'): ?> 
                    </a> 
                    <?php endif; ?> 
                </td>
              </tr>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </table>
            <div class="blank5"></div>
            <?php echo $this->fetch('library/pages.lbi'); ?> </div>
          <?php endif; ?> 
          
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
<script language="javascript">
get_invoice_info('<?php echo $this->_var['order']['invoices']['0']['shipping_name']; ?>','<?php echo $this->_var['order']['invoices']['0']['invoice_no']; ?>',1);

function get_invoice_info(expressid,expressno,div_id)
{
	$("#ul_i").children("li").removeClass();
	document.getElementById("div_i_"+div_id).className = 'selected';
	Ajax.call(
		'plugins/kuaidi100/kuaidi100_post.php?com='+ expressid+'&nu=' + expressno, 
		'showtest=showtest', 
		function(data){
			document.getElementById("retData").innerHTML='快递公司：'+expressid+' &nbsp; 运单号：'+expressno+'<br>';
			document.getElementById("retData").innerHTML+=data;
		}, 
		'GET', 
		'TEXT', 
		false
	);
}

function get_invoice_info2(expressid,expressno,div_id,order_id)
{
	$("#ul_i_"+order_id).children("li").removeClass();
	document.getElementById("div_i_"+order_id+"_"+div_id).className = 'selected';
	Ajax.call(
		'plugins/kuaidi100/kuaidi100_post.php?com='+ expressid+'&nu=' + expressno, 
		'showtest=showtest', 
		function(data){
			document.getElementById("retData_"+order_id).innerHTML='快递公司：'+expressid+' &nbsp; 运单号：'+expressno+'<br>';
			document.getElementById("retData_"+order_id).innerHTML+=data;
		}, 
		'GET', 
		'TEXT', 
		false
	);
}
</script>
<script type="text/javascript">
<?php $_from = $this->_var['lang']['clips_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</script>
</html>
