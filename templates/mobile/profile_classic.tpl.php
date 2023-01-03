<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_profile.js'; $icons = array(1 => 'mars', 2 => 'venus', 3 => 'transgender'); ?>
	  <div class="content" id="profile-classic" data-id="<?php echo $this->user_id; ?>" data-username="<?php echo $this->username; ?>">
		<div class="profile-c-left">
		  <div class="profile-c">
			<div class="profile-c-image">
			  <img src="<?php echo USER_URL,'/',avatar(false, $this->user_id, $this->user['avatar'], $this->user['gender'], true); ?>" alt="<?php echo __('user-avatar', e($this->username)); ?>" class="img-thumbnail img-responsive">
			  <?php if ($this->is_self): ?>
			  <a href="<?php echo REL_URL,LANG; ?>/user/avatar/" title="<?php echo __('edit-image-help'); ?>" class="profile-image-edit btn btn-xs btn-menu"><i class="fa fa-camera"></i> <?php echo __('edit-image'); ?></a>
			  <?php endif; ?>
            <?php if (!$this->is_self): $login = (!$this->is_loggedin) ? 'login ' : ''; ?>
            <div class="profile-c-actions">
              <div id="subscribe" class="profile-c-action">
                <?php if ($this->is_subscribed): ?>
                <button id="subscribe-del" class="btn btn-ns btn-submit btn-subscribe" data-action="del" data-toggle="tooltip" data-placement="top" title="<?php echo __('profile-unsubscribe-help'); ?>"><i class="fa fa-rss"></i> <?php echo __('unsubscribe'); ?></button>
                <?php else: ?>
                <button id="subscribe-add" class="<?php echo $login; ?>btn btn-ns btn-submit btn-subscribe" data-action="add" data-toggle="tooltip" data-placement="top" title="<?php echo __('profile-subscribe-help'); ?>"><i class="fa fa-rss"></i> <?php echo __('subscribe'); ?></button>
                <?php endif; ?>
              </div>
              <?php if ($this->user['allow_friends'] != '0' or $this->is_friend): ?>
              <div id="friend" class="profile-c-action profile-c-friend">
                <?php if ($this->is_friend): ?>
                <button id="friend-del" class="btn btn-ns btn-submit btn-friend" data-action="del" data-toggle="tooltip" data-placement="top" title="<?php echo __('profile-unfriend-help'); ?>"><i class="fa fa-user-times"></i> <?php echo __('unfriend'); ?></button>
                <?php else: ?>
                <button id="friend-add" class="<?php echo $login; ?>btn btn-ns btn-submit btn-friend" data-action="add" data-toggle="tooltip" data-placement="top" title="<?php echo __('profile-friend-help'); ?>"><i class="fa fa-user-plus"></i> <?php echo __('add-friend'); ?></button>
                <?php endif; ?>
              </div>
              <?php endif; ?>
              <div class="clearfix"></div>
            </div>            
            <div id="response" class="alert alert-response" style="display: none;"></div>
            <?php endif; ?>
			</div>
			<div class="profile-c-info">
			  <h1 class="profile-c-username">
				<?php echo e($this->username); ?>
				<?php if ($this->is_self): ?>
				<a href="<?php echo REL_URL,LANG; ?>/user/profile/"><i class="fa fa-edit fa-xs"></i></a>
				<?php endif; if ($this->is_friend): ?>
            	<a href="<?php echo REL_URL,LANG,'/message/chat/',$this->username; ?>/" rel="nofollow" class="btn-xs"><i class="fa fa-envelope"></i></a>
            	<?php endif; ?>
			  </h1>			  
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('joined'); ?>:</div>
				<div class="profile-c-value"><?php echo VDate::nice($this->user['join_time']); ?></div>
			  </div>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('last-login'); ?>:</div>
				<div class="profile-c-value"><?php if ($this->user['login_time']): echo VDate::nice($this->user['login_time']); else: echo __('never'); endif; ?></div>
			  </div>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('popularity'); ?>:</div>
				<div class="profile-c-value"><?php echo number_format($this->user['popularity']); ?></div>
			  </div>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('profile-views'); ?>:</div>
				<div class="profile-c-value"><?php echo number_format($this->user['profile_views']); ?></div>
			  </div>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('videos-viewed'); ?>:</div>
				<div class="profile-c-value"><?php echo number_format($this->user['videos_viewed']); ?></div>
			  </div>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('subscribers'); ?>:</div>
				<div class="profile-c-value"><?php if ($this->user['subscribers']): ?><a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/subscribers/" class="btn-color"><?php echo number_format($this->user['subscribers']); ?></a><?php else: echo number_format($this->user['subscribers']); endif; ?></div>
			  </div>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('friends'); ?>:</div>
				<div class="profile-c-value"><?php if ($this->user['friends']): ?><a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/friends/" class="btn-color"><?php echo number_format($this->user['friends']); ?></a><?php else: echo number_format($this->user['friends']); endif; ?></div>
			  </div>
			</div>
			<div class="clearfix"></div>
			<div class="profile-c-about">
			  <?php $items = array(); if ($this->user['name']): $items[] = e($this->user['name']); endif;
			  if ($this->user['birth_time']): $items[] = VDate::diff($this->user['birth_time'], time()); endif;
			  if ($this->user['gender'] > 0): $items[] = '<i class="fa fa-'.$icons[$this->user['gender']].'"></i> '.$this->genders[$this->user['gender']]; endif;
			  if ($this->user['relation'] > 0): $items[] = $this->relationships[$this->user['relation']]; endif; if ($items): ?>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('i-am'); ?>:</div>
				<div class="profile-c-value"><?php echo implode('<span style="font-weight: normal;">,</span> ', $items); ?></div>
			  </div>
			  <?php endif; $items = array(); if ($this->user['city']): $items[] = e($this->user['city']); endif;
			  if ($this->user['country_id']): $items[] = VCountry::getName($this->user['country_id']); endif; if ($items): ?>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('From'); ?>:</div>
				<div class="profile-c-value"><?php echo implode('<span style="font-weight: normal;">,</span> ', $items); ?></div>
			  </div>
			  <?php endif; if ($this->user['interested']): ?>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('interested-in'); ?>:</div>
				<div class="profile-c-value"><?php echo $this->interestedins[$this->user['interested']]; ?></div>
			  </div>
			  <?php endif; if ($this->user['website']): ?>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('website'); ?>:</div>
				<div class="profile-c-value">
				  <a href="<?php echo $this->user['website']; ?>" target="blank" rel="nofollow"><?php echo e($this->user['website']); ?> <i class="fa fa-external-link"></i></a>
				</div>
			  </div>
			  <?php endif; if ($this->user['about']): ?>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('about'); ?>:</div>
				<div class="profile-c-value"><?php echo e($this->user['about']); ?></div>
			  </div>
			  <?php endif; if ($this->user['occupation']): ?>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('occupation'); ?>:</div>
				<div class="profile-c-value"><?php echo e($this->user['occupation']); ?></div>
			  </div>
			  <?php endif; if ($this->user['school']): ?>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('school'); ?>:</div>
				<div class="profile-c-value"><?php echo e($this->user['school']); ?></div>
			  </div>
			  <?php endif; if ($this->user['company']): ?>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('company'); ?>:</div>
				<div class="profile-c-value"><?php echo e($this->user['company']); ?></div>
			  </div>
			  <?php endif; if ($this->user['hobbies']): ?>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('hobbies'); ?>:</div>
				<div class="profile-c-value"><?php echo e($this->user['hobbies']); ?></div>
			  </div>
			  <?php endif; if ($this->user['movies']): ?>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('movies'); ?>:</div>
				<div class="profile-c-value"><?php echo e($this->user['movies']); ?></div>
			  </div>
			  <?php endif; if ($this->user['music']): ?>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('music'); ?>:</div>
				<div class="profile-c-value"><?php echo e($this->user['music']); ?></div>
			  </div>
			  <?php endif; if ($this->user['turn_on']): ?>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('turn-ons'); ?>:</div>
				<div class="profile-c-value"><?php echo e($this->user['turn_on']); ?></div>
			  </div>
			  <?php endif; if ($this->user['turn_off']): ?>
			  <div class="profile-c-row">
				<div class="profile-c-label"><?php echo __('turn-offs'); ?>:</div>
				<div class="profile-c-value"><?php echo e($this->user['turn_off']); ?></div>
			  </div>
			  <?php endif; ?>
			</div>
		  </div>
		  <div class="panel panel-default margin-top-10">
        	<div class="panel-heading">
        	  <div class="panel-title"><?php echo __('wall'); ?></div>
        	</div>
        	<div class="panel-body profile-c-panel">
        	  <?php $this->poster_id = ($this->is_loggedin) ? $this->is_loggedin : 0; $allow_comment = VCfg::get('profile.allow_comment'); $this->content_id = $this->user_id; $this->ctype = 'wall'; if (isset($this->comments)): ?>
        	  <?php if ($allow_comment == '2' or ($allow_comment == '1' and $this->poster_id)): echo $this->fetch('_comment_post'); $this->allow_comment = true; else: $this->allow_comment = false; endif; ?>
        	  <?php $this->comments_per_page = VCfg::get('profile.comments_per_page'); $this->reply = VCfg::get('profile.comment_replies'); $this->vote = VCfg::get('profile.comment_vote'); if ($this->comments): ?>
			  <?php echo $this->fetch('_comment_list'); else: ?>
        	  <div id="comments-container-<?php echo $this->content_id; ?>" class="comments-container" style="display: none;"><ul class="media-list"></ul></div>
        	  <?php endif; endif; ?>
        	</div>
      	  </div>
		</div>
		<div class="profile-c-right">
		  <?php $this->vclass = 'videoss'; $this->id = 'public'; if ($this->total_public_videos): ?>
		  <div class="panel panel-default">
        	<div class="panel-heading">
          	  <div class="panel-title panel-title-left"><?php echo __('profile-public-videos-title', $this->username); ?> <span>(<?php echo $this->total_public_videos; ?>)</span></div>
          	  <?php if ($this->total_public_videos > 6): ?>
          	  <a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/videos/public/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
          	  <?php endif; ?>
          	  <div class="clearfix"></div>
        	</div>
        	<div class="panel-body">
        	  <?php $this->videos = $this->public_videos; echo $this->fetch('_video_list'); ?>
			</div>
		  </div>
		  <?php endif; $this->id = 'private'; if ($this->total_private_videos): ?>
		  <div class="panel panel-default">
        	<div class="panel-heading">
          	  <div class="panel-title panel-title-left"><?php echo __('profile-private-videos-title', $this->username); ?> <span>(<?php echo $this->total_private_videos; ?>)</span></div>
          	  <?php if ($this->total_private_videos > 6): ?>
          	  <a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/videos/private/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
          	  <?php endif; ?>
          	  <div class="clearfix"></div>
        	</div>
        	<div class="panel-body">
        	  <?php $this->videos = $this->private_videos; echo $this->fetch('_video_list'); ?>
			</div>
		  </div>
		  <?php endif; $this->id = 'favorite'; if ($this->favorite_videos): ?>
		  <div class="panel panel-default">
        	<div class="panel-heading">
          	  <div class="panel-title panel-title-left"><?php echo __('profile-favorite-videos-title', $this->username); ?> <span>(<?php echo $this->total_favorite_videos; ?>)</span></div>
          	  <?php if ($this->total_favorite_videos > 6): ?>
          	  <a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/videos/favorites/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
          	  <?php endif; ?>
          	  <div class="clearfix"></div>
        	</div>
        	<div class="panel-body">
        	  <?php $this->videos = $this->favorite_videos; echo $this->fetch('_video_list'); ?>
			</div>
		  </div>
		  <?php endif; $this->id = 'publica'; if (isset($this->total_public_albums) and $this->total_public_albums): ?>
		  <div class="panel panel-default">
        	<div class="panel-heading">
  			  <div class="panel-title panel-title-left"><?php echo __('profile-public-albums-title', $this->username); ?> <span>(<?php echo $this->total_public_albums; ?>)</span></div>
  			  <?php if ($this->total_public_albums > 5): ?>
  			  <a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/albums/public/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
  			  <?php endif; ?>
  			  <div class="clearfix"></div>
			</div>
        	<div class="panel-body">
			  <?php $this->albums = $this->public_albums; echo $this->fetch('_photo_album_list'); ?>
			</div>
		  </div>
		  <?php endif; $this->id = 'privatea'; if (isset($this->total_private_albums) and $this->total_private_albums): ?>
		  <div class="panel panel-default">
        	<div class="panel-heading">
  			  <div class="panel-title panel-title-left"><?php echo __('profile-private-albums-title', $this->username); ?> <span>(<?php echo $this->total_private_albums; ?>)</span></div>
  			  <?php if ($this->total_private_albums > 5): ?>
  			  <a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/albums/private/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
  			  <?php endif; ?>
  			  <div class="clearfix"></div>
			</div>
        	<div class="panel-body">
			  <?php $this->albums = $this->private_albums; echo $this->fetch('_photo_album_list'); ?>
			</div>
		  </div>
		  <?php endif; $this->id = 'favoritep'; if (isset($this->total_favorite_photos) and $this->total_favorite_photos): ?>
		  <div class="panel panel-default">
        	<div class="panel-heading">
  			  <div class="panel-title panel-title-left"><?php echo __('profile-favorite-photos-title', $this->username); ?> <span>(<?php echo $this->total_favorite_photos; ?>)</span></div>
  			  <?php if ($this->total_favorite_photos > 5): ?>
  			  <a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/photos/favorites/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
  			  <?php endif; ?>
  			  <div class="clearfix"></div>
			</div>
        	<div class="panel-body">
			  <?php $this->photos = $this->favorite_photos; echo $this->fetch('_photo_list'); ?>
			</div>
		  </div>
		  <?php endif; if (isset($this->total_friends) and $this->total_friends): ?>
		  <div class="panel panel-default">
        	<div class="panel-heading">
  			  <div class="panel-title panel-title-left"><?php echo __('profile-friends-title', $this->username); ?> <span>(<?php echo $this->total_friends; ?>)</span></div>
  			  <?php if ($this->total_friends > 6): ?>
  			  <a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/friends/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
  			  <?php endif; ?>
  			  <div class="clearfix"></div>
			</div>
        	<div class="panel-body">
			  <?php $this->users = $this->friends; echo $this->fetch('_user_list'); ?>
			</div>
		  </div>
		  <?php endif; ?>		  
		</div>
		<div class="clearfix"></div>
	  </div>
	  