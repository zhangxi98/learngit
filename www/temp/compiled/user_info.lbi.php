<div class="sideNav">
  <h1><a href="#"><span><?php echo $_SESSION['user_name']; ?></span></a></h1>
  <div class="userInfo">
    <div class="myInfo clearfix"> 
      <div class="photo">
        <div class="mask"></div>
        <img id="headImagePath" src="<?php if ($_SESSION['headimg']): ?><?php echo $_SESSION['headimg']; ?><?php else: ?>themes/68ecshopcom_360buy/images/people.gif<?php endif; ?>" height="80" width="80">
      </div>
      <div class="info-op">
      	<ul>
        	<li class="info-op1"><i></i><a href="user.php?act=profile" >修改资料</a></li>
        	<li class="info-op2"><i></i><a href="user.php?act=logout" >安全退出</a></li>
            <li class="info-op3"><i></i><a href="javascript:void(0);" title="会员等级"><?php echo $this->_var['rank_name']; ?></a></li>
        </ul>
      </div>
    </div>
    <p class="cost"><?php echo $this->_var['next_rank_name']; ?></p>
  </div>
</div>
