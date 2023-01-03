<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_profile.js'; ?>
<div class="row" id="profile" data-id="<?php echo $this->user_id; ?>" data-username="<?php echo $this->username; ?>">
  <div class="col-12">
	<div class="d-flex <?php if (isset($this->user['ext_wall']) and $this->user['ext_wall']): ?>model-backimage" style="background-image: url('<?php echo USER_URL,'/',$this->user_id,'_wall.',$this->user['ext_wall']; ?>');"<?php else: ?>model-background"<?php endif; ?>>
	  <div class="profile-image">
		<img src="<?php echo USER_URL,'/',avatar(false, $this->user_id, $this->user['avatar'], $this->user['gender'], true); ?>" alt="<?php echo __('user-avatar', e($this->username)); ?>" class="model-image rounded mt-3 mb-1 mx-2">
		<?php if ($this->is_self): ?>
        <a href="<?php echo REL_URL,LANG; ?>/user/avatar/" title="<?php echo __('edit-image-help'); ?>" class="btn btn-xs btn-primary profile-image-edit"><i class="fa fa-camera"></i> <?php echo __('edit-image');?></a>
        <?php endif; ?>			  	  
	  </div>
	  <div class="align-self-end">
		<h1 class="model-btn model-name mb-0"><?php echo e($this->username); ?></h1>
		<div class="d-flex mt-1 mb-1">
		  <?php if (!$this->is_self): $login = (!$this->user_id) ? 'login ' : ''; ?>
		  <div id="subscribe" class="ml-1">
        	<?php if ($this->is_subscribed): ?>
        	<button id="subscribe-del" class="btn btn-xs btn-primary rounded-pill btn-subscribe" data-action="del" data-toggle="tooltip" data-placement="right" title="<?php echo __('profile-unsubscribe-help'); ?>"><i class="fa fa-minus"></i> <?php echo __('unsubscribe'); ?></button>
        	<?php else: ?>
        	<button id="subscribe-add" class="<?php echo $login; ?>btn btn-xs btn-primary rounded-pill btn-subscribe" data-action="add" data-toggle="tooltip" data-placement="right" title="<?php echo __('profile-subscribe-help'); ?>"><i class="fa fa-user-plus"></i> <?php echo __('subscribe'); ?></button>
        	<?php endif; ?>			
		  </div>
		  <?php if ($this->user['allow_friends'] != '0' or $this->is_friend): ?>
		  <div id="friend" class="ml-1">
        	<?php if ($this->is_friend): ?>
        	<button id="friend-del" class="btn btn-xs btn-primary rounded-pill btn-friend" data-action="del" data-toggle="tooltip" data-placement="top" title="<?php echo __('profile-unfriend-help'); ?>"><i class="fa fa-user-times"></i> <?php echo __('unfriend'); ?></button>
        	<?php else: ?>
        	<button id="friend-add" class="<?php echo $login; ?>btn btn-xs btn-primary rounded-pill btn-friend" data-action="add" data-toggle="tooltip" data-placement="top" title="<?php echo __('profile-friend-help'); ?>"><i class="fa fa-user-plus"></i> <?php echo __('add-friend'); ?></button>
        	<?php endif; ?>
      	  </div>
      	  <?php endif; if ($this->is_friend): ?>
      	  <div class="ml-1">
      		<a href="<?php echo REL_URL,LANG,'/message/chat/',$this->username; ?>/" rel="nofollow" class="btn btn-xs btn-primary rounded-pill"><i class="fa fa-envelope"></i> <?php echo __('message'); ?></a>
      	  </div>
      	  <?php endif; else: ?>
      	  <a href="<?php echo REL_URL,LANG; ?>/user/profile/" class="btn btn-xs btn-primary rounded-pill"><i class="fa fa-edit"></i> <?php echo __('edit-profile'); ?></a>
      	  <?php endif; ?>
        </div>
	  </div>
	</div>
  </div>
</div>
<div class="row mt-1 mt-lg-3">
  <div class="col-12 col-md-12 col-lg-3 col-xl-2 mb-3 sidebar">
    <div class="d-flex flex-row flex-lg-column flex-wrap text-muted text-center text-lg-left justify-content-center mt-2 mt-lg-0">
      <span class="p-1 p-md-2"><i class="fa fa-heart"></i> <small><?php echo __('popularity'); ?>:</small> <strong><?php echo $this->user['popularity']; ?></strong></span>
      <span class="p-1 p-md-2"><i class="fa fa-eye"></i> <small><?php echo __('profile-views'); ?>:</small> <strong><?php echo number_format($this->user['profile_views']); ?></strong></span>
      <span class="p-1 p-md-2"><i class="fa fa-video-camera"></i> <small><?php echo __('videos'); ?>:</small> <strong><?php echo number_format($this->user['videos']); ?></strong></span>
      <?php if (VModule::enabled('photo')): ?>
      <span class="p-1 p-md-2"><i class="fa fa-camera"></i> <small><?php echo __('albums'); ?>:</small> <strong><?php echo number_format($this->user['albums']); ?></strong></span>
      <?php endif; ?>
      <span class="p-1 p-md-2"><i class="fa fa-user-plus"></i> <small><?php echo __('subscribers'); ?>:</small> <strong><span id="subscribers-count"><?php echo $this->user['subscribers']; ?></span></strong></span>
      <span class="p-1 p-md-2"><i class="fa fa-user-plus"></i> <small><?php echo __('friends'); ?>:</small> <strong><span id="friends-count"><?php echo $this->user['friends']; ?></span></strong></span>
    </div>
    <?php echo w('user_users_popular'); ?>
  </div>
  <div class="col-12 col-md-12 col-lg-9 col-xl-10">
	<div class="row">
	  <div class="col-12 col-md-6 col-lg-8">
		<div class="row profile-info">
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('gender'); ?>:</strong> <span class="text-muted"><?php echo $this->genders[$this->user['gender']]; ?></span>
		  </div>
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('relation'); ?>:</strong> <span class="text-muted"><?php echo $this->relationships[$this->user['relation']]; ?></span>
		  </div>
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('interested-in'); ?>:</strong> <span class="text-muted"><?php echo $this->interestedins[$this->user['interested']]; ?></span>
		  </div>
		  <?php if ($this->user['birth_time']): ?>
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('birth-date'); ?>:</strong> <span class="text-muted"><?php echo VDate::format($this->user['birth_time'], 'd M Y'); ?></span>
		  </div>
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('age'); ?>:</strong> <span class="text-muted"><?php echo VDate::diff($this->user['birth_time'], time()); ?></span>
		  </div>
		  <?php endif; if ($this->user['country_id']): ?>
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('country'); ?>:</strong> <span class="text-muted"><?php echo VCountry::getName($this->user['country_id']); ?></span>
		  </div>
		  <?php endif; if ($this->user['city']): ?>
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('city'); ?>:</strong> <span class="text-muted"><?php echo e($this->user['city']); ?></span>
		  </div>
		  <?php endif; if ($this->user['website']): ?>
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('website'); ?>:</strong> <span class="text-muted"><?php echo e($this->user['website']); ?></span>
		  </div>
		  <?php endif; if ($this->user['occupation']): ?>
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('occupation'); ?>:</strong> <span class="text-muted"><?php echo e($this->user['occupation']); ?></span>
		  </div>
		  <?php endif; if ($this->user['school']): ?>
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('school'); ?>:</strong> <span class="text-muted"><?php echo e($this->user['school']); ?></span>
		  </div>
		  <?php endif; if ($this->user['company']): ?>
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('company'); ?>:</strong> <span class="text-muted"><?php echo e($this->user['company']); ?></span>
		  </div>
		  <?php endif; if ($this->user['hobbies']): ?>
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('hobbies'); ?>:</strong> <span class="text-muted"><?php echo e($this->user['hobbies']); ?></span>
		  </div>
		  <?php endif; if ($this->user['movies']): ?>
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('movies'); ?>:</strong> <span class="text-muted"><?php echo e($this->user['movies']); ?></span>
		  </div>
		  <?php endif; if ($this->user['music']): ?>
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('music'); ?>:</strong> <span class="text-muted"><?php echo e($this->user['music']); ?></span>
		  </div>
		  <?php endif; if ($this->user['books']): ?>
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('books'); ?>:</strong> <span class="text-muted"><?php echo e($this->user['books']); ?></span>
		  </div>
		  <?php endif; if ($this->user['turn_on']): ?>
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('turn-ons'); ?>:</strong> <span class="text-muted"><?php echo e($this->user['turn_on']); ?></span>
		  </div>
		  <?php endif; if ($this->user['turn_off']): ?>
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('turn-offs'); ?>:</strong> <span class="text-muted"><?php echo e($this->user['turn_off']); ?></span>
		  </div>
		  <?php endif; ?>
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('joined'); ?>:</strong> <span class="text-muted"><?php echo VDate::nice($this->user['join_time']); ?></span>
		  </div>
		  <div class="col-12 col-md-6 col-lg-6">
			<strong><?php echo __('last-login'); ?>:</strong> <span class="text-muted"><?php if ($this->user['login_time']): echo VDate::nice($this->user['login_time']); else: echo __('never'); endif; ?></span>
		  </div>
		</div>
	  </div>
	  <?php if ($this->user['about']): ?>
	  <div class="col-12 col-md-6 col-lg-4 mt-3 mt-md-0">
		<p class="text-muted"><?php echo nl2br($this->user['about']); ?></p>
	  </div>
	  <?php endif; ?>
	</div>
	<div class="w-100 mt-3 text-center text-lg-left">
	  <a href="<?php echo REL_URL.LANG.'/users/'.$this->username; ?>/" class="mb-1 btn<?php if (isset($this->amodel)): echo ' btn-primary'; else: echo ' btn-secondary'; endif; ?>" rel="nofollow"><?php echo __('stream'); ?></a>
	  <a href="<?php echo REL_URL.LANG,'/users/',$this->username; ?>/videos/" rel="nofollow" class="mb-1 btn<?php if ($this->extramenu == 'profile_videos'): echo ' btn-primary'; else: echo ' btn-secondary'; endif; ?>"><?php echo __('videos'),' (',$this->user['videos']; ?>)</a>
	  <?php if (VModule::enabled('photo')): ?><a href="<?php echo REL_URL.LANG,'/users/',$this->username; ?>/photos/" rel="nofollow" class="mb-1 btn<?php if ($this->extramenu == 'profile_photos'): echo ' btn-primary'; else: echo ' btn-secondary'; endif; ?>"><?php echo __('albums'),' (',$this->user['albums']; ?>)</a><?php endif; ?>
	  <?php if (VModule::enabled('playlist')): ?><a href="<?php echo REL_URL.LANG,'/users/',$this->username; ?>/playlists/" rel="nofollow" class="mb-1 btn<?php if ($this->extramenu == 'profile_playlists'): echo ' btn-primary'; else: echo ' btn-secondary'; endif; ?>"><?php echo __('playlists'),' (',$this->user['playlists']; ?>)</a><?php endif; ?>
	  <a href="<?php echo REL_URL.LANG,'/users/',$this->username; ?>/connections/" class="mb-1 btn<?php if ($this->extramenu == 'profile_connections'): echo ' btn-primary'; else: echo ' btn-secondary'; endif; ?>"><?php echo __('connections'); ?></a>
    </div>
    <?php if ($this->template == 'stream'): ?>
    <div id="profile-wall" class="my-2 py-3 px-1 w-100 bg-white border rounded">
  	  <div id="profile-actions" class="w-100 text-center">
    	<button id="wall-post" class="btn btn-sm btn-primary rounded-pill"><i class="fa fa-pencil-square-o"></i> <?php if ($this->is_self): echo __('post-on-your-wall'); else: echo __('post-on-user-wall', $this->username); endif; ?></button>
  	  </div>
      <div id="profile-wall-action" class="w-100"></div>  	  
      <div id="modal-container"></div>
    </div>
    <?php endif; echo $this->fetch('profile_'.$this->template); ?>
  </div>
</div>
