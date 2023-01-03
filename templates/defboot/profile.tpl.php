<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_profile.js'; ?>
	  <div class="content" id="profile" data-id="<?php echo $this->user_id; ?>" data-username="<?php echo $this->username; ?>">
		<div class="profile-image">
		  <img src="<?php echo USER_URL,'/',avatar(false, $this->user_id, $this->user['avatar'], $this->user['gender'], true); ?>" alt="<?php echo __('user-avatar', e($this->username)); ?>" class="img-rounded img-responsive">
		  <?php if ($this->is_self): ?>
		  <a href="<?php echo REL_URL,LANG; ?>/user/avatar/" title="<?php echo __('edit-image-help'); ?>" class="profile-image-edit btn btn-xs btn-menu"><i class="fa fa-camera"></i> <?php echo __('edit-image'); ?></a>
		  <?php endif; ?>
		</div>
		<div class="profile-info">
		  <div class="profile-header">
			<h1 class="profile-username"><?php echo $this->username; ?></h1>
			<?php if (!$this->is_self): $login = (!$this->is_loggedin) ? 'login ' : ''; ?>
			<div class="profile-actions">
			  <div id="subscribe" class="profile-action">
				<?php if ($this->is_subscribed): ?>
				<button id="subscribe-del" class="btn btn-xs btn-submit btn-subscribe" data-action="del" data-toggle="tooltip" data-placement="top" title="<?php echo __('profile-unsubscribe-help'); ?>"><i class="fa fa-rss"></i> <?php echo __('unsubscribe'); ?></button>
				<?php else: ?>
				<button id="subscribe-add" class="<?php echo $login; ?>btn btn-xs btn-submit btn-subscribe" data-action="add" data-toggle="tooltip" data-placement="top" title="<?php echo __('profile-subscribe-help'); ?>"><i class="fa fa-rss"></i> <?php echo __('subscribe'); ?></button>
				<?php endif; ?>
			  </div>
			  <?php if ($this->user['allow_friends'] != '0' or $this->is_friend): ?>
			  <div id="friend" class="profile-action">
				<?php if ($this->is_friend): ?>
				<button id="friend-del" class="btn btn-xs btn-submit btn-friend" data-action="del" data-toggle="tooltip" data-placement="top" title="<?php echo __('profile-unfriend-help'); ?>"><i class="fa fa-user-times"></i> <?php echo __('unfriend'); ?></button>
				<?php else: ?>
				<button id="friend-add" class="<?php echo $login; ?>btn btn-xs btn-submit btn-friend" data-action="add" data-toggle="tooltip" data-placement="top" title="<?php echo __('profile-friend-help'); ?>"><i class="fa fa-user-plus"></i> <?php echo __('add-friend'); ?></button>
				<?php endif; ?>
			  </div>
			  <?php endif; if ($this->is_friend): ?>
			  <a href="<?php echo REL_URL,LANG,'/message/chat/',$this->username; ?>/" rel="nofollow"><i class="fa fa-envelope"></i> <?php echo __('message'); ?></a>
			  <?php endif; ?>
			  <div class="clearfix"></div>
			</div>
			<div id="response" class="alert alert-response" style="display: none;"></div>
			<?php endif; ?>
			<?php if ($this->is_self): ?>
			<a href="<?php echo REL_URL,LANG; ?>/user/profile/" class="btn btn-xs btn-menu btn-profile-edit"><i class="fa fa-edit"></i> <?php echo __('edit-profile'); ?></a>
			<?php endif; ?>
			<div class="clearfix"></div>
		  </div>
		  <div class="profile-stats">
			<div class="profile-box"><?php echo __('subscribers'); ?>: <span><?php if ($this->user['subscribers']): ?><a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/subscribers/" class="btn-color"><?php echo number_format($this->user['subscribers']); ?></a><?php else: echo number_format($this->user['subscribers']); endif; ?></span></div>
			<div class="profile-box"><?php echo __('friends'); ?>: <span><?php if ($this->user['friends']): ?><a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/friends/" class="btn-color"><?php echo number_format($this->user['friends']); ?></a><?php else: echo number_format($this->user['friends']); endif; ?></span></div>
			<div class="profile-box"><?php echo __('videos-viewed'); ?>: <span><?php echo number_format($this->user['videos_viewed']); ?></span></div>
			<div class="profile-box"><?php echo __('profile-views'); ?>: <span><?php echo number_format($this->user['profile_views']); ?></span></div>
		  </div>
		  <?php if ($this->user['about']): ?>
		  <div class="profile-about">
			<div class="profile-info-title"><?php echo __('about'); ?></div>
			<?php echo e($this->user['about']); ?>
		  </div>
		  <?php endif; ?>
		  <div class="profile-details">
            <div class="profile-about-row">
              <span><?php echo __('gender'); ?>:</span> <?php echo $this->genders[$this->user['gender']]; ?>
            </div>		  
            <div class="profile-about-row">
              <span><?php echo __('relation'); ?>:</span> <?php echo $this->relationships[$this->user['relation']]; ?>
            </div>		  
            <div class="profile-about-row">
              <span><?php echo __('interested-in'); ?>:</span> <?php echo $this->interestedins[$this->user['interested']]; ?>
            </div>		  
            <?php if ($this->user['birth_time']): ?>
            <div class="profile-about-row">
              <span><?php echo __('age'); ?>:</span> <?php echo VDate::diff($this->user['birth_time'], time()); ?>
            </div>
            <?php endif; if ($this->user['country_id']): ?>
            <div class="profile-about-row">
              <span><?php echo __('country'); ?>:</span> <?php echo VCountry::getName($this->user['country_id']); ?>
            </div>
            <?php endif; if ($this->user['city']): ?>
            <div class="profile-about-row">
              <span><?php echo __('city'); ?>:</span> <?php echo e($this->user['city']); ?>
            </div>
			<?php endif; ?>
            <div class="profile-about-row">
              <span><?php echo __('joined'); ?>:</span> <?php echo VDate::nice($this->user['join_time']); ?>
            </div>
            <div class="profile-about-row">
              <span><?php echo __('last-login'); ?>:</span> <?php if ($this->user['login_time']): echo VDate::nice($this->user['login_time']); else: echo __('never'); endif; ?>
            </div>
		  </div>
		</div>  
		<div class="clearfix"></div>
	  </div>
	  <div class="profile">
		<div class="profile-left">
    	  <div class="tablist">
      		<ul class="nav nav-tabs" role="tablist">
      		  <li<?php if (isset($this->amodel)): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL.LANG.'/users/'.$this->username; ?>/" rel="nofollow"><?php echo __('stream'); ?></a></li>
      		  <li<?php if ($this->extramenu == 'profile_videos'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL.LANG,'/users/',$this->username; ?>/videos/" rel="nofollow"><i class="fa fa-video-camera"></i> <span class="hidden-xs hidden-sm"><?php echo __('videos'); ?></span></a></li>
      		  <?php if (VModule::enabled('photo')): ?><li<?php if ($this->extramenu == 'profile_photos'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL.LANG,'/users/',$this->username; ?>/photos/" rel="nofollow"><i class="fa fa-camera"></i> <span class="hidden-xs hidden-sm"><?php echo __('photos'); ?></span></a></li><?php endif; ?>
      		  <?php if (VModule::enabled('game')): ?><li<?php if ($this->extramenu == 'profile_games'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL.LANG,'/users/',$this->username; ?>/games/" rel="nofollow"><i class="fa fa-game"></i> <span class="hidden-xs hidden-sm"><?php echo __('games'); ?></span></a></li><?php endif; ?>
      		  <?php if (VModule::enabled('blog')): ?><li<?php if ($this->extramenu == 'profile_blogs'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL.LANG,'/users/',$this->username; ?>/blogs/" rel="nofollow"><i class="fa fa-blog"></i> <span class="hidden-xs hidden-sm"><?php echo __('blogs'); ?></span></a></li><?php endif; ?>
      		  <?php if (VModule::enabled('playlist')): ?><li<?php if ($this->extramenu == 'profile_playlists'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL.LANG,'/users/',$this->username; ?>/playlists/" rel="nofollow"><i class="fa fa-list"></i> <span class="hidden-xs hidden-sm"><?php echo __('playlists'); ?></span></a></li><?php endif; ?>
      		  <li<?php if ($this->extramenu == 'profile_connections'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL.LANG,'/users/',$this->username; ?>/connections/" rel="nofollow"><i class="fa fa-users"></i> <span class="hidden-xs hidden-sm"><?php echo __('connections'); ?></span></a></li>      		  
      		</ul>
      		<div class="tab-content profile-content">
      		  <input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
      		  <?php if ($this->template == 'stream'): ?>
      		  <div id="profile-wall">
      			<div id="profile-wall-actions">
      			  <button id="wall-post" class="btn btn-lg btn-color"><i class="fa fa-pencil-square-o"></i> <?php if ($this->is_self): echo __('post-on-your-wall'); else: echo __('post-on-user-wall', $this->username); endif; ?></button>
      			</div>
      			<div id="modal-container"></div>
      			<div id="profile-wall-action" class="profile-wall-action"></div>
      		  </div>
      		  <?php endif; echo $this->fetch('profile_'.$this->template); ?>
      		</div>
      	  </div>
    	</div>	  
		<div class="profile-right">
		  <?php if ($adv = p('adv', 'profile-right')): ?>
		  <div class="adv-container"><?php echo $adv; ?></div>
		  <?php endif; ?>
      	  <div class="panel panel-default">
        	<div class="panel-heading">
          	  <span class="panel-title"><?php echo __('profile'); ?></span>
        	</div>
        	<div class="panel-body profile-panel-right">
        	  <?php if ($this->user['website']): ?>
          	  <div class="profile-row">
            	<span><?php echo __('website'); ?>:</span> <?php echo e($this->user['website']); ?>
          	  </div>		  
        	  <?php endif; if ($this->user['occupation']): ?>
          	  <div class="profile-row">
            	<span><?php echo __('occupation'); ?>:</span> <?php echo e($this->user['occupation']); ?>
          	  </div>		  
        	  <?php endif; if ($this->user['school']): ?>
          	  <div class="profile-row">
            	<span><?php echo __('school'); ?>:</span> <?php echo e($this->user['school']); ?>
          	  </div>		  
        	  <?php endif; if ($this->user['company']): ?>
          	  <div class="profile-row">
            	<span><?php echo __('company'); ?>:</span> <?php echo e($this->user['company']); ?>
          	  </div>		  
        	  <?php endif; if ($this->user['hobbies']): ?>
          	  <div class="profile-row">
            	<span><?php echo __('hobbies'); ?>:</span> <?php echo e($this->user['hobbies']); ?>
          	  </div>		  
        	  <?php endif; if ($this->user['movies']): ?>
          	  <div class="profile-row">
            	<span><?php echo __('movies'); ?>:</span> <?php echo e($this->user['movies']); ?>
          	  </div>		  
        	  <?php endif; if ($this->user['music']): ?>
          	  <div class="profile-row">
            	<span><?php echo __('music'); ?>:</span> <?php echo e($this->user['music']); ?>
          	  </div>		  
        	  <?php endif; if ($this->user['books']): ?>
          	  <div class="profile-row">
            	<span><?php echo __('books'); ?>:</span> <?php echo e($this->user['books']); ?>
          	  </div>		  
        	  <?php endif; if ($this->user['turn_on']): ?>
          	  <div class="profile-row">
            	<span><?php echo __('turn-ons'); ?>:</span> <?php echo e($this->user['turn_on']); ?>
          	  </div>		  
        	  <?php endif; if ($this->user['turn_off']): ?>
          	  <div class="profile-row">
            	<span><?php echo __('turn-offs'); ?>:</span> <?php echo e($this->user['turn_off']); ?>
          	  </div>		  
          	  <?php endif; ?>
        	</div>        	
      	  </div>
      	  <?php if (isset($this->channels) and $this->channels): ?>
      	  <div class="panel panel-default">
        	<div class="panel-heading">
          	  <span class="panel-title"><?php echo __('channel-subscriptions'); ?></span>
        	</div>
        	<div class="panel-body">
        	  <?php $this->cclass = 'channels-small'; echo $this->fetch('_channel_list'); ?>
        	</div>
      	  </div>
      	  <?php endif; if (isset($this->models) and $this->models): ?>
      	  <div class="panel panel-default">
        	<div class="panel-heading">
          	  <span class="panel-title"><?php echo __('model-subscriptions'); ?></span>
        	</div>
        	<div class="panel-body">
        	  <?php $this->mclass = 'models-small'; echo $this->fetch('_model_list'); ?>
        	</div>
      	  </div>
      	  <?php endif; if ($this->extramenu == 'profile_stream' and isset($this->subscriptions) and $this->subscriptions): ?>
          <div class="panel panel-default">
            <div class="panel-heading">
              <span class="panel-title"><?php echo __('subscriptions'); ?></span>
            </div>
            <div class="panel-body">
              <?php $this->uclass = 'users-small'; $this->users = $this->subscriptions; echo $this->fetch('_user_list'); ?>
            </div>
          </div>
		  <?php endif; ?>
		</div>
		<div class="clearfix"></div>
	  </div>
	  