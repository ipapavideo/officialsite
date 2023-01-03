<?php defined('_VALID') or die('Restricted Access!'); ?>
	  <?php $this->uclass = 'users-small'; ?>
	  <div class="members">
		<div class="members-right">
      	  <div class="panel panel-default">
        	<div class="panel-body">
        	  <?php echo p('adv', 'community-right'); ?>
        	</div>        	
      	  </div>
      	  <?php $this->uclass = 'users-small'; ?>        		
      	  <div class="panel panel-default">
        	<div class="panel-heading">
          	  <span class="panel-title pull-left"><?php echo __('online-members'); ?></span>
          	  <a href="<?php echo REL_URL,LANG; ?>/user/search/?online=yes" class="btn btn-xs btn-submit pull-right"><?php echo __('see-more'); ?></a>
          	  <div class="clearfix"></div>
        	</div>
        	<div class="panel-body">
        	  <?php $this->id = 'online'; $this->users = $this->online; echo $this->fetch('_user_list'); ?>
        	</div>        	
      	  </div>        		
      	  <div class="panel panel-default">
        	<div class="panel-heading">
          	  <span class="panel-title pull-left"><?php echo __('recent-members'); ?></span>
          	  <a href="<?php echo REL_URL,LANG; ?>/user/search/" class="btn btn-xs btn-submit pull-right"><?php echo __('see-more'); ?></a>
          	  <div class="clearfix"></div>
        	</div>
        	<div class="panel-body">
        	  <?php $this->id = 'recent'; $this->users = $this->recent; echo $this->fetch('_user_list'); ?>
        	</div>        	
      	  </div>        		
		</div>
		<?php $this->uclass = 'users-small users-small-margin'; ?>
		<div class="members-left">
		  <div class="panel panel-default">
        	<div class="panel-heading">
          	  <span class="panel-title pull-left"><?php echo __('most-popular-members'); ?></span>
          	  <a href="<?php echo REL_URL,LANG; ?>/user/search/?order=popular" class="btn btn-xs btn-submit pull-right"><?php echo __('see-more'); ?></a>
          	  <div class="clearfix"></div>
        	</div>
      		<div class="panel-body">
      		  <?php $this->id = 'popular'; $this->users = $this->popular; echo $this->fetch('_user_list'); ?>
      		</div>
      	  </div>
		  <div class="panel panel-default">
        	<div class="panel-heading">
          	  <span class="panel-title pull-left"><?php echo __('most-subscribed-members'); ?></span>
          	  <a href="<?php echo REL_URL,LANG; ?>/user/search/?order=subscribed" class="btn btn-xs btn-submit pull-right"><?php echo __('see-more'); ?></a>
          	  <div class="clearfix"></div>
        	</div>
      		<div class="panel-body">
      		  <?php $this->id = 'subscribed'; $this->users = $this->subscribed; echo $this->fetch('_user_list'); ?>
      		</div>
      	  </div>
		  <div class="panel panel-default">
        	<div class="panel-heading">
          	  <span class="panel-title pull-left"><?php echo __('most-popular-male-members'); ?></span>
          	  <a href="<?php echo REL_URL,LANG; ?>/user/search/?order=popular&gender=female" class="btn btn-xs btn-submit pull-right"><?php echo __('see-more'); ?></a>
          	  <div class="clearfix"></div>
        	</div>
      		<div class="panel-body">
      		  <?php $this->id = 'popular'; $this->users = $this->popular_male; echo $this->fetch('_user_list'); ?>
      		</div>
      	  </div>
		  <div class="panel panel-default">
        	<div class="panel-heading">
          	  <span class="panel-title pull-left"><?php echo __('most-popular-female-members'); ?></span>
          	  <a href="<?php echo REL_URL,LANG; ?>/user/search/?order=popular&gender=female" class="btn btn-xs btn-submit pull-right"><?php echo __('see-more'); ?></a>
          	  <div class="clearfix"></div>
        	</div>
      		<div class="panel-body">
      		  <?php $this->id = 'popular'; $this->users = $this->popular_female; echo $this->fetch('_user_list'); ?>
      		</div>
      	  </div>
    	</div>	  
		<div class="clearfix"></div>
	  </div>
	  