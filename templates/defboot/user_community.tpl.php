<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_wall.js'; ?>
	  <div class="profile">
		<div class="profile-left">
		  <div class="panel panel-default profile-stream">
        	<div class="panel-heading">
          	  <span class="panel-title"><?php echo $this->title; ?></span>
        	</div>
      		<div class="panel-body profile-panel">
      		  <?php if ($this->stream): $this->limit = true; echo $this->fetch('_stream_list'); else: ?>
      		  <div class="none"><?php echo __('no-activity'); ?></div>
      		  <?php endif; ?>
      		</div>
      	  </div>
    	</div>	  
		<div class="profile-right" style="margin-top: 0;">
      	  <div class="panel panel-default">
        	<div class="panel-body">
        	  <?php echo p('adv', 'community-right'); ?>
        	</div>        	
      	  </div>
      	  <?php $this->uclass = 'users-small'; ?>        		
      	  <div class="panel panel-default">
        	<div class="panel-heading">
          	  <span class="panel-title pull-left"><?php echo __('most-popular-users'); ?></span>
          	  <a href="<?php echo REL_URL,LANG; ?>/user/search/?order=popular" rel="nofollow" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
          	  <div class="clearfix"></div>
        	</div>
        	<div class="panel-body">
        	  <?php $this->users = $this->users_popular; echo $this->fetch('_user_list'); ?>
        	</div>        	
      	  </div>        		
      	  <div class="panel panel-default">
        	<div class="panel-heading">
          	  <span class="panel-title pull-left"><?php echo __('most-subscribed-users'); ?></span>
          	  <a href="<?php echo REL_URL,LANG; ?>/user/search/?order=subscribed" rel="nofollow" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
          	  <div class="clearfix"></div>
        	</div>
        	<div class="panel-body">
        	  <?php $this->users = $this->users_subscribed; echo $this->fetch('_user_list'); ?>
        	</div>        	
      	  </div>        		
		</div>
		<div class="clearfix"></div>
	  </div>
	  