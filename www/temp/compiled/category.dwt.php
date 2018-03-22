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
<link rel="stylesheet" type="text/css" href="themes/68ecshopcom_360buy/css/<?php echo $this->_var['cat_style']; ?>" />
<script>var jdpts = new Object(); jdpts._st = new Date().getTime();</script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-lazyload.js"></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,global.js,compare.js,utils.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js,user.js')); ?>
</head>
<body><?php 
$k = array (
  'name' => 'add_url_uid',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
  <?php echo $this->fetch('library/page_header.lbi'); ?>
  <div class="blank"></div>
  <div class="w1210">
  	<?php echo $this->fetch('library/best_nei.lbi'); ?>
	<?php echo $this->fetch('library/ur_here.lbi'); ?>
     
     
    <script type="text/javascript">
	var begin_hidden=0;
	function init_position_left(){
		var kuan1=document.getElementById('attr-list-ul').clientWidth;
		var kuan2=document.getElementById('attr-group-more').clientWidth;
		var kuan =(kuan1-kuan2)/2;
		document.getElementById('attr-group-more').style.marginLeft=kuan+"px";
	}
	function getElementsByName(tagName, eName){  
		var tags = document.getElementsByTagName(tagName);  
		var returns = new Array();  
      	if (tags != null && tags.length > 0) {  
			for (var i = 0; i < tags.length; i++) {  
				if (tags[i].getAttribute("name") == eName) {  
					returns[returns.length] = tags[i];  
				}  
			}  
		}  
		return returns;  
	}
	function Show_More_Attrgroup(){
		var attr_list_dl = getElementsByName('dl','attr-group-dl');
		var attr_group_more_text = document.getElementById('attr-group-more-text');
		if(begin_hidden==2){
			for(var i=0;i<attr_list_dl.length;i++){
				attr_list_dl[i].style.display= i >= begin_hidden ? 'none' : 'block';
			}
			attr_group_more_text.innerHTML="更多选项（" + attr_group_more_txt + "）";
			init_position_left();
			begin_hidden=0;
		}else{
			for(var i=0;i<attr_list_dl.length;i++){
				attr_list_dl[i].style.display='block';				
			}
			attr_group_more_text.innerHTML="收起";
			init_position_left();
			begin_hidden=2;
		}
	}
	// 是否显示“更多”__初始化
	function init_more(boxid, moreid, height){
	     var obj_brand=document.getElementById(boxid);
	     var more_brand = document.getElementById(moreid);
	     if (obj_brand.clientHeight > height){
			obj_brand.style.height= height+ "px";
			obj_brand.style.overflow="hidden";
			more_brand.innerHTML='<a href="javascript:void(0);"  onclick="slideDiv(this, \''+boxid+'\', \''+height+'\');" class="more-68ecshop-1" >更多</a>';
	     }
	 }
	 function slideDiv(thisobj, divID,Height){  
	     var obj=document.getElementById(divID).style;  
	     if(obj.height==""){  
         	obj.height= Height+ "px";  
         	obj.overflow="hidden";
	     	thisobj.innerHTML="更多";
	     	thisobj.className="more-68ecshop-1";
	        // 如果是品牌，额外处理
			if(divID=='brand-abox'){
			   //obj.width="456px";
			   getBrand_By_Zimu(document.getElementById('brand-zimu-all'),'');
			   document.getElementById('brand-sobox').style.display = "none";
			   document.getElementById('brand-zimu').style.display = "none";
			   document.getElementById('brand-abox-father').className="";
			}
         }else{  
         	obj.height="";  
         	obj.overflow="";  
	     	thisobj.innerHTML="收起";
	     	thisobj.className="more-68ecshop-2";
	        // 如果是品牌，额外处理
			if(divID=='brand-abox'){
			   //obj.width="456px";
				   document.getElementById('brand-sobox').style.display = "block";
			   document.getElementById('brand-zimu').style.display = "block";
			   //getBrand_By_Zimu(document.getElementById('brand-zimu-all'),'');
			   document.getElementById('brand-abox-father').className="brand-more-ecshop68";
			 }
	     }  
	}
	function getBrand_By_Name(val){
	    val =val.toLocaleLowerCase();
	    var brand_list = document.getElementById('brand-abox').getElementsByTagName('li');    
	    for(var i=0;i<brand_list.length;i++){
			//document.getElementById('brand-abox').style.width="auto";
			var name_attr_value= brand_list[i].getAttribute("name").toLocaleLowerCase();
			if(brand_list[i].title.indexOf(val)==0 || name_attr_value.indexOf(val)==0 || val==''){
				brand_list[i].style.display='block';
			}else{
				brand_list[i].style.display='none';
			}
	    }
	}
	//点击字母切换品牌
	function getBrand_By_Zimu(obj, zimu)
	{
		document.getElementById('brand-sobox-input').value="可搜索拼音、汉字查找品牌";
		obj.focus();
		var brand_zimu=document.getElementById('brand-zimu');
		var zimu_span_list = brand_zimu.getElementsByTagName('span');
		for(var i=0;i<zimu_span_list.length;i++){
			zimu_span_list[i].className='';
		}
		var thisspan=obj.parentNode;
		thisspan.className='span';
		var brand_list = document.getElementById('brand-abox').getElementsByTagName('li');			
		for(var i=0;i<brand_list.length;i++){	
			//document.getElementById('brand-abox').style.width="auto";
			if(brand_list[i].getAttribute('rel') == zimu || zimu==''){
				brand_list[i].style.display='block';
			}else{
				brand_list[i].style.display='none';
			}
		}
	}
	var duoxuan_a_valid=new Array();
	// 点击多选， 显示多选区
	function showDuoXuan(dx_divid, a_valid_id){	     
	     var dx_dl_68ecshop = document.getElementById('attr-list-ul').getElementsByTagName('dl');
	     for(var i=0;i<dx_dl_68ecshop.length;i++){
			dx_dl_68ecshop[i].className='';
			dx_dl_68ecshop[0].className='selected-attr-dl';
	     }
	     var dxDiv=document.getElementById(dx_divid);
	     dxDiv.className ="duoxuan";
	     duoxuan_a_valid[a_valid_id]=1;
	     
	}
	function hiddenDuoXuan(dx_divid, a_valid_id){
		var dxDiv=document.getElementById(dx_divid);
		dxDiv.className ="";
		duoxuan_a_valid[a_valid_id]=0;
		if(a_valid_id=='brand'){
			var ul_obj_68ecshop = document.getElementById('brand-abox');
			var li_list_68ecshop = ul_obj_68ecshop.getElementsByTagName('li');
			if(li_list_68ecshop){
				for(var j=0;j<li_list_68ecshop.length;j++){
					li_list_68ecshop[j].className="";
				}
			}
		}else{
			var ul_obj_68ecshop = document.getElementById('attr-abox-'+a_valid_id);
		}
		var input_list = ul_obj_68ecshop.getElementsByTagName('input');
		var span_list = ul_obj_68ecshop.getElementsByTagName('span');
		for(var j=0;j<input_list.length;j++){
			input_list[j].checked=false;
		}
		if(span_list.length){
			for(var j=0;j<span_list.length;j++){
				span_list[j].className="color-ecshop68";
			}
		}
	}
	function duoxuan_Onclick(a_valid_id, idid, thisobj)
	{			
		if (duoxuan_a_valid[a_valid_id]){
			if (thisobj){	
				var fatherObj = thisobj.parentNode;
				if (a_valid_id =="brand"){
					fatherObj.className = fatherObj.className == "brand-seled" ? "" : "brand-seled";
					}else{
					fatherObj.className =   fatherObj.className == "color-ecshop68" ? "color-ecshop68-seled" : "color-ecshop68";
				}
			}
			document.getElementById('chk-'+a_valid_id+'-'+idid).checked= !document.getElementById('chk-'+a_valid_id+'-'+idid).checked;
			return false;
		}
	}
	
	function duoxuan_Submit(dxid, indexid, attr_count, category, brand_id, price_min, price_max,  filter_attr,filter)
	{		
		var theForm =document.forms['theForm'];
		var chklist=theForm.elements['checkbox_'+ dxid+'[]'];
		var newpara="";
		var mm=0;
		for(var k=0;k<chklist.length;k++){
			if(chklist[k].checked){
				//alert(chklist[k].value);
				newpara += mm>0 ? "_" : "";
				newpara += chklist[k].value;
				mm++;
			}
		}
		if (mm==0){
			return false;
		}
		if(dxid=='brand'){
			brand_id = newpara;
		}else{
			var attr_array = new Array();
			filter_attr = filter_attr.replace(/\./g,",");
			attr_array=filter_attr.split(',');
			for(var h=0;h<attr_count;h++){
				if(indexid == h){
					attr_array[indexid] = newpara;
				}else{
					if(attr_array[h]){
					}else{
					 attr_array[h] = 0;
					}
				}
			}
			filter_attr = attr_array.toString();
		}
		filter_attr = filter_attr.replace(/,/g,".");
		var url="other.php";
		//var url="category.php";
		url += "?id="+ category;
		url += brand_id ? "&brand="+brand_id : "";
		url += price_min ? "&price_min="+price_min : "&price_min=0";
		url += price_max ? "&price_max="+price_max : "&price_max=0";
		url += filter_attr ? "&filter_attr="+filter_attr : "&filter_attr=0";
		url += filter ? "&filter="+filter : "&filter=0";
		//location.href=url;
		return_url(url,dxid);
	}

	function return_url(url,dxid){
	  $.ajax({    
		    url:url,   
		    type:'get',
		    cache:false,
		    dataType:'text',
		    success:function(data){
		        var obj = document.getElementById('button-'+dxid);
		        obj.href = data;
			obj.click();
			//location.href=data;
		     }
		});
	}
	
	</script> 
    <?php if ($this->_var['brands']['1'] || $this->_var['price_grade']['1'] || $this->_var['filter_attr_list']): ?>
    <form action="" method="post" name="theForm" >
      <div class="box-attr-ecshop68" id="attr-list-ul"> 
        <?php if ($this->_var['condition']): ?>
        <dl class="selected-attr-dl">
          <dt>已选条件：</dt>
          <dd class="moredd"><a href="category.php?id=<?php echo $this->_var['category']; ?>">全部撤销</a></dd>
          <dd>
            <ul class="selected-attr">
              <?php $_from = $this->_var['condition']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cond');if (count($_from)):
    foreach ($_from AS $this->_var['cond']):
?>
              <li><a href="<?php echo $this->_var['cond']['cond_url']; ?>"><?php echo $this->_var['cond']['cond_type']; ?>：<b class="main-color"><?php echo $this->_var['cond']['cond_name']; ?></b><i></i></a></li>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
          </dd>
        </dl>
        <?php endif; ?> 
        
        <?php if ($this->_var['brands']['1']): ?>
        <dl style="border-top:none;" id="attr-group-dl-brand">
          <dt><?php echo $this->_var['lang']['brand']; ?>：</dt>
          <dd class="moredd">
            <label id="brand-more"></label>
            <label><a href="javascript:void(0)" onclick="showDuoXuan('attr-group-dl-brand','brand');" class="duo-68ecshop"><font class="duo-b">+</font>多选</a> </label>
          </dd>
          <dd>
            <div id="brand-sobox" style="display:none;">
              <input type="text" id="brand-sobox-input" value="可搜索拼音、汉字查找品牌" onfocus="if(this.value=='可搜索拼音、汉字查找品牌') {this.value=''}" 
	     onblur="if (this.value=='') {this.value='可搜索拼音、汉字查找品牌'}" onkeyup="getBrand_By_Name(this.value);">
            </div>
            <div id="brand-zimu" class="clearfix" style="display:none;"><span class="span"><a href="javascript:void(0);" onmouseover="getBrand_By_Zimu(this,'')" id="brand-zimu-all">所有品牌</a><b></b></span> <?php $_from = $this->_var['brand_zimu_68ecshop']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'bzimu');if (count($_from)):
    foreach ($_from AS $this->_var['bzimu']):
?><span><a href="javascript:void(0);" onmouseover="getBrand_By_Zimu(this,'<?php echo $this->_var['bzimu']; ?>')"><?php echo $this->_var['bzimu']; ?></a><b></b></span><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></div>
            <div id="brand-abox-father">
              <ul id="brand-abox" class="brand-abox-imgul">
                <?php $_from = $this->_var['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'brand');$this->_foreach['brands_68ecshop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['brands_68ecshop']['total'] > 0):
    foreach ($_from AS $this->_var['brand']):
        $this->_foreach['brands_68ecshop']['iteration']++;
?> 
                <?php if (($this->_foreach['brands_68ecshop']['iteration'] - 1) > 0): ?>
                <li title="<?php echo $this->_var['brand']['brand_name']; ?>" name="<?php echo $this->_var['brand']['pinyin']; ?>" rel="<?php echo $this->_var['brand']['shouzimu']; ?>" <?php if ($this->_foreach['brands_68ecshop']['iteration'] > 8): ?>class="bottom"<?php endif; ?>>
                  <input type="checkbox" style="display:none;" name="checkbox_brand[]" id="chk-brand-<?php echo $this->_foreach['brands_68ecshop']['iteration']; ?>" value="<?php echo $this->_var['brand']['brand_id_68ecshop']; ?>">
                  <a href="<?php echo $this->_var['brand']['url']; ?>" onclick="return duoxuan_Onclick('brand','<?php echo $this->_foreach['brands_68ecshop']['iteration']; ?>', this);"> <?php if ($this->_var['brand']['brand_logo']): ?><img src="data/brandlogo/<?php echo $this->_var['brand']['brand_logo']; ?>" width="100" height="40"/><?php else: ?><?php echo $this->_var['brand']['brand_name']; ?><?php endif; ?><i></i></a></li>
                <?php endif; ?> 
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              </ul>
            </div>
            <div class="duoxuan-btnbox"> <a id="button-brand"></a> <a class="select-button disabled" onclick="duoxuan_Submit('brand',0,'<?php echo $this->_var['filter_attr_count_num']; ?>','<?php echo $this->_var['category']; ?>','<?php echo $this->_var['brand_id']; ?>', '<?php echo $this->_var['price_min']; ?>', '<?php echo $this->_var['price_max']; ?>', '<?php echo $this->_var['filter_attr']; ?>','<?php echo $this->_var['filter']; ?>');">确定</a> <a href="javascript:void(0);" onclick="hiddenDuoXuan('attr-group-dl-brand', 'brand');" class="select-button" style="margin-left:10px;white-space:nowrap;">取消</a> </div>
          </dd>
        </dl>
        <script type="text/javascript">
	      duoxuan_a_valid['brand'] = 0;
	      init_more('brand-abox', 'brand-more', '83');	
		  $('#brand-abox li').click(function(){
			var seled_num = $(this).parent().find('.brand-seled').length;
			if(seled_num > 0){
				$(this).parents('dd').find('.select-button').eq(0).attr('class','select-button select-button-sumbit');	
			}else if(seled_num == 0){
				$(this).parents('dd').find('.select-button').eq(0).attr('class','select-button disabled');	
			}
		  })
	      </script> 
        <?php endif; ?> 
        
        <?php if ($this->_var['price_grade']['1']): ?>
        <dl>
          <dt><?php echo $this->_var['lang']['price']; ?>：</dt>
          <dd class="moredd">&nbsp;</dd>
          <dd>
            <ul>
              <?php $_from = $this->_var['price_grade']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'grade');$this->_foreach['price_grade_68ecshop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['price_grade_68ecshop']['total'] > 0):
    foreach ($_from AS $this->_var['grade']):
        $this->_foreach['price_grade_68ecshop']['iteration']++;
?> 
              <?php if (($this->_foreach['price_grade_68ecshop']['iteration'] - 1) > 0): ?>
              <li><a href="<?php echo $this->_var['grade']['url']; ?>"><?php echo $this->_var['grade']['price_range']; ?></a></li>
              <?php endif; ?> 
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              <li> 
                
                
                <input type="text" name="price_min" id="price_min" value="<?php echo $this->_var['price_min']; ?>" class="price-68ecshop" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" autocomplete="off">
                <i></i>
                <input type="text" name="price_max" id="price_max" value="<?php echo $this->_var['price_max']; ?>" class="price-68ecshop" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" autocomplete="off">
                
                 
                <a class="select-button" href="javascript:void()" onclick="setPrice('<?php echo $this->_var['url_no_price']; ?>');" >确定</a> </li>
            </ul>
          </dd>
        </dl>
        <?php endif; ?> 
        
        <?php $_from = $this->_var['filter_attr_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('kattr', 'filter_attr_0_10444800_1490260561');$this->_foreach['filter_attr_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['filter_attr_list']['total'] > 0):
    foreach ($_from AS $this->_var['kattr'] => $this->_var['filter_attr_0_10444800_1490260561']):
        $this->_foreach['filter_attr_list']['iteration']++;
?>
        <dl name="attr-group-dl" id="attr-group-dl-<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>">
          <dt><?php echo htmlspecialchars($this->_var['filter_attr_0_10444800_1490260561']['filter_attr_name']); ?>：</dt>
          <dd class="moredd">
            <label id="attr-more-<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>"></label>
            <label><a href="javascript:void(0)" onclick="showDuoXuan('attr-group-dl-<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>', '<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>');" class="duo-68ecshop"><font class="duo-b">+</font>多选</a></label>
          </dd>
          <dd>
            <ul id="attr-abox-<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>">
              <?php $_from = $this->_var['filter_attr_0_10444800_1490260561']['attr_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'attr');$this->_foreach['attr_list_68ecshop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['attr_list_68ecshop']['total'] > 0):
    foreach ($_from AS $this->_var['attr']):
        $this->_foreach['attr_list_68ecshop']['iteration']++;
?> 
              <?php if (($this->_foreach['attr_list_68ecshop']['iteration'] - 1) > 0): ?>
              <li class="<?php if ($this->_var['filter_attr_0_10444800_1490260561']['filter_attr_name'] == '颜色'): ?>color-ecshop68-li<?php else: ?>other-ecshop68-li<?php endif; ?>"> <?php if ($this->_var['filter_attr_0_10444800_1490260561']['filter_attr_name'] == '颜色'): ?> <span class="color-ecshop68" style="position:relative;">
                <div class="sanjiao-red" onclick="return duoxuan_Onclick('<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>','<?php echo $this->_foreach['attr_list_68ecshop']['iteration']; ?>', this);">&nbsp;</div>
                <input type="checkbox" style="display:none;" name="checkbox_<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>[]" id="chk-<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>-<?php echo $this->_foreach['attr_list_68ecshop']['iteration']; ?>" value="<?php echo $this->_var['attr']['goods_id']; ?>">
                <a href="<?php echo $this->_var['attr']['url']; ?>" title="<?php echo $this->_var['attr']['attr_value']; ?>"  onclick="return duoxuan_Onclick('<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>','<?php echo $this->_foreach['attr_list_68ecshop']['iteration']; ?>', this);"  style="display:block;cursor:pointer;width:15px;height:15px;border:1px solid #fff;background:#<?php echo $this->_var['attr']['color_code']; ?>;">&nbsp;</a> </span> <?php else: ?>
                <input type="checkbox"  name="checkbox_<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>[]" id="chk-<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>-<?php echo $this->_foreach['attr_list_68ecshop']['iteration']; ?>" class="chkbox-68ecshop" value="<?php echo $this->_var['attr']['goods_id']; ?>" >
                <a href="<?php echo $this->_var['attr']['url']; ?>" onclick="return duoxuan_Onclick('<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>','<?php echo $this->_foreach['attr_list_68ecshop']['iteration']; ?>');"><?php echo $this->_var['attr']['attr_value']; ?></a> <?php endif; ?> </li>
              <?php endif; ?> 
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
            <div class="duoxuan-btnbox" > <a id="button-<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>"></a> <a id="select-button-<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>" class="select-button disabled" onclick="duoxuan_Submit(<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>, '<?php echo $this->_var['kattr']; ?>', '<?php echo $this->_var['filter_attr_count_num']; ?>', '<?php echo $this->_var['category']; ?>','<?php echo $this->_var['brand_id']; ?>', '<?php echo $this->_var['price_min']; ?>', '<?php echo $this->_var['price_max']; ?>', '<?php echo $this->_var['filter_attr_value']; ?>','<?php echo $this->_var['filter']; ?>');" >确定</a> <a href="javascript:void(0);" onclick="hiddenDuoXuan('attr-group-dl-<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>', '<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>');" class="select-button" style="margin-left:10px;white-space:nowrap;">取消</a> </div>
          </dd>
        </dl>
        <script type="text/javascript">
	     duoxuan_a_valid[<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>] = 0;
	     init_more('attr-abox-<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>', 'attr-more-<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>', '24');	
	     <?php if ($this->_foreach['filter_attr_list']['iteration'] > 2): ?>
	     document.getElementById('attr-group-dl-<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>').style.display="none";
	     <?php endif; ?>
	     </script> 
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      </div>
      <?php if ($this->_var['attr_group_more_count'] > 2): ?> 
      <script type="text/javascript">var attr_group_more_txt = "<?php echo $this->_var['attr_group_more_txt']; ?>";</script>
      <span class="attr-group-more" id="attr-group-more"> <a href="javascript:void(0);" onclick="Show_More_Attrgroup();" id="attr-group-more-text">更多选项（<?php echo $this->_var['attr_group_more_txt']; ?>）</a> </span>
      <script type="text/javascript" >init_position_left(); </script> 
      <?php endif; ?> 
      <script type="text/javascript" >init_position_left(); </script>
    </form>
    <script type="text/javascript">
      $(function(){
		 $('.color-ecshop68-li span').click(function(){
			var seled_num = $(this).parents('ul').find('.color-ecshop68-seled').length;
			if(seled_num > 0){
				$(this).parents('dd').find('.select-button').eq(0).attr('class','select-button select-button-sumbit');	
			}else if(seled_num == 0){
				$(this).parents('dd').find('.select-button').eq(0).attr('class','select-button disabled');	
			}
		 })
		 $('.other-ecshop68-li input[type="checkbox"]').bind('click',function(){
			 var seled_input_num = $(this).parents('ul').find('input[type="checkbox"]:checked').length;
			 if(seled_input_num>0){
				 $(this).parents('dd').find('.select-button').eq(0).attr('class','select-button select-button-sumbit');	
			 }else if(seled_input_num == 0){
				 $(this).parents('dd').find('.select-button').eq(0).attr('class','select-button disabled');
			 }
		 })  
	  })
      </script> 
    <?php endif; ?>
     
     
    
    <div class="blank15"></div>
    <div class="content-wrap category-wrap clearfix">
        <div class="aside">
        	<span class="slide-aside"></span>
            <div class="aside-inner">
                <?php if ($this->_var['new_goods']): ?>
                <div class="aside-con">
                    <h2 class="aside-tit">新品推荐</h2>
                    <ul class="aside-list">
                        <?php $_from = $this->_var['new_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?> 
                        <?php if ($this->_foreach['goods']['iteration'] < 6): ?>
                        <li>
                            <div class="p-img">
                                <a target="_blank" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>" href="<?php echo $this->_var['goods']['url']; ?>"><img alt="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>" data-original="<?php echo $this->_var['goods']['thumb']; ?>" src="themes/68ecshopcom_360buy/images/loading.gif" /></a> 
                            </div>
                            <div class="p-name">
                                <a target="_blank" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>" href="<?php echo $this->_var['goods']['url']; ?>"><?php echo $this->_var['goods']['name']; ?></a>
                            </div>
                            <div class="p-price">
                                <span class="sale-price main-color"><?php if ($this->_var['goods']['promote_price'] != ""): ?><?php echo $this->_var['goods']['promote_price']; ?><?php else: ?><?php echo $this->_var['goods']['shop_price']; ?><?php endif; ?></span>
                                <span class="market-price"><del><?php echo $this->_var['goods']['market_price']; ?></del></span>
                            </div>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
                <?php endif; ?> 
                <?php echo $this->fetch('library/top10.lbi'); ?> 
            </div>
        </div>
    	<div class="main">
        	<?php echo $this->fetch('library/goods_list.lbi'); ?>
            <?php echo $this->fetch('library/pages.lbi'); ?>
        </div>
    </div>
    <?php echo $this->fetch('library/history.lbi'); ?>
  </div>
  <?php echo $this->fetch('library/right_sidebar.lbi'); ?>
  <?php echo $this->fetch('library/arrive_notice.lbi'); ?>
  <div class="site-footer">
        <div class="footer-related">
            <?php echo $this->fetch('library/help.lbi'); ?>
            <?php echo $this->fetch('library/page_footer.lbi'); ?>
      </div>
  </div>
<script>//收集skuId
var skuIds = [];
$('ul.list-h li[sku]').each(function(i){
    skuIds.push($(this).attr('sku'));
})

function setPrice(url){
  var max = 'max='+document.getElementById('price_max').value;
  var min = 'min='+document.getElementById('price_min').value;
  var remin = /min=([0-9])*/ig;  //•g（全文查找）；•i（忽略大小写）；•m（多行查找）  
  var remax = /max=([0-9])*/ig;  //•g（全文查找）；•i（忽略大小写）；•m（多行查找）  
  var nurl = url.replace(remin,min).replace(remax,max);
  location.href = nurl;
}
</script> 
 
<script type="text/javascript">
$("img").lazyload({
    effect       : "fadeIn",
	 skip_invisible : true,
	 failure_limit : 20
});
</script> 
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/compare.js"></script> 
</body>
</html>
