<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_photo_view.js'; ?>
<div class="row" id="photo" data-id="<?php echo $this->photo['photo_id']; ?>" data-album="<?php echo $this->photo['album_id']; ?>" data-user="<?php echo $this->user_id; ?>">
  <div class="col-12 col-md p-0 border-bottom border">
	<?php if ($this->photo['status'] == '8'): ?>
	<div class="none"><?php echo __('this-photo-was-deleted'); ?></div>
	<?php else: ?>
	<div id="image">
      <?php if ($this->friends): ?>
      <a href="<?php echo REL_URL,LANG,'/photo/',$this->photo_next; ?>/"><img src="<?php echo $this->photo['photo_url'],'/',$this->photo_id,'.',$this->photo['ext']; ?>" alt="<?php echo $this->photo['caption']; ?>" class="img-reponsive" style="max-width: 100%;"></a>
      <?php if (isset($this->photo_prev) and $this->photo_prev): ?>
      <a href="<?php echo REL_URL,LANG,'/photo/',$this->photo_prev; ?>/" class="photo-prev"><i class="fa fa-chevron-circle-left fa-2x"></i></a>
      <?php endif; if (isset($this->photo_next) and $this->photo_next): ?>
      <a href="<?php echo REL_URL,LANG,'/photo/',$this->photo_next; ?>/" class="photo-next"><i class="fa fa-chevron-circle-right fa-2x"></i></a>
      <?php endif; else: ?>
      <div class="private"><i class="fa fa-lock fa-5x"></i><br><?php echo __('photo-view-private', '<a href="'.REL_URL.LANG.'/users/'.e($this->photo['username']).'/" class="btn-link"><strong>'.e($this->photo['username']).'</strong></a>'); ?></div>
      <?php endif; ?>	
	</div>
	<?php endif; ?>  
	<div class="row no-gutters pt-2 border-bottom bg-white">
      <div class="col-12 col-md-8 text-center text-md-left pl-2">
    	<h1 class="photo-title">
    	  <?php echo __('album').': <a href="'.album_url($this->photo['album_id'], $this->photo['slug']).'">'.e($this->photo['title']); ?></a>
    	  <?php if ($this->photo['caption']): echo e($this->photo['caption']); endif; ?>
    	</h1>    	
      </div>
      <div id="subscribe" class="col-12 col-md-4 d-flex justify-content-center justify-content-md-end align-items-start mb-2 mb-md-0 pr-2">
    	<?php if ($this->user_id and p('subscribed', $this->photo['user_id'], $this->user_id)): ?>
        <button type="button" class="btn btn-sm btn-primary rounded-pill btn-subscribe" data-action="del" data-user="<?php echo $this->photo['user_id']; ?>"><i class="fa fa-user"></i> <?php echo __('unsubscribe'); ?> (<?php echo $this->photo['subscribers']; ?>)</button>
    	<?php else: ?>
        <button type="button" class="<?php if (!$this->user_id): echo 'login '; endif; ?>btn btn-sm btn-primary rounded-pill btn-subscribe" data-action="add" data-user="<?php echo $this->photo['user_id']; ?>"><i class="fa fa-user"></i> <?php echo __('subscribe'); ?> (<?php echo $this->photo['subscribers']; ?>)</button>
        <?php endif; ?>
      </div>
      <div class="d-flex justify-content-center justify-content-md-start flex-wrap pt-0 px-2 pb-1 w-100">
    	<?php if (isset($this->photo['username']) and $this->photo['username']): ?>
        <div class="content-from mr-2">
          <?php echo __('from'); ?>: <a href="<?php echo REL_URL,'/users/',e($this->photo['username']); ?>/" rel="nofollow"><strong><?php echo e($this->photo['username']); ?></strong></a>
        </div>
        <?php endif; ?>
        <div class="content-details text-muted" style="font-size: 14px;">
          <span class="px-2"><i class="fa fa-calendar"></i> <?php echo VDate::nice($this->photo['add_time']); ?></span>
          <span class="px-2"><i class="fa fa-eye"></i> <?php echo number_format($this->photo['total_views']); ?></span>
        </div>
      </div>
    </div>
    <div class="row no-gutters border-bottom">
  	  <div id="response" class="col-12 col-md-12 p-2 text-center d-none"><div class="alert alert-dismissible fade show" role="alert"></div></div>
      <div class="col-12 col-md-4 text-center text-md-left pl-0">
        <?php $percent = ($this->photo['likes'] > 0 && $this->photo['rated_by']) ? round($this->photo['likes']*100/$this->photo['rated_by']) : 100; ?>
        <div class="d-flex justify-content-center justify-content-md-start">
          <button type="button" class="btn btn-action btn-thumbs-up btn-rate-photo" data-rating="1" data-toggle="tooltip" data-placement="top" title="<?php echo __('i-like-this'); ?>"><i id="thumbs-up" class="fa fa-thumbs-up"></i></button>
          <div id="rating" class="votes p-1 pt-2"><?php echo $percent; ?>% (<?php echo $this->photo['rated_by'],' ',__('votes'); ?>)
            <div class="progress progress-danger">
              <div class="progress-bar bg-success" style="width: <?php echo $percent; ?>%;"></div>
              <div class="progress-bar bg-danger" style="width: <?php echo 100-$percent; ?>%"></div>
            </div>
          </div>
          <button type="button" class="btn btn-action btn-thumbs-down btn-rate-photo" data-rating="0" data-toggle="tooltip" data-placement="top" title="<?php echo __('i-dislike-this'); ?>"><i id="thumbs-down" class="fa fa-thumbs-down"></i></button>
          <button type="button" class="btn btn-action btn-favorite-photo" data-toggle="tooltip" data-placement="top" title="<?php echo __('add-to-favorites'); ?>"><i id="favorite-photo" class="fa fa-heart"></i></button>
        </div>
      </div>
      <div class="col-12 col-md-8 d-flex justify-content-center justify-content-md-end pr-0 mb-2 mb-md-0">
        <button type="button" class="btn btn-action btn-section" data-id="share" data-toggle="tooltip" data-placement="top" title="<?php echo __('share-this-photo'); ?>"><i class="fa fa-share-alt"></i></button>
        <button type="button" class="btn btn-action" id="flag" data-toggle="tooltip" data-placement="top" title="<?php echo __('flag-this-photo'); ?>"><i class="fa fa-flag"></i></button>
      </div>
    </div>
    <div class="row no-gutters d-none content-section border-bottom" id="content-share">
      <div class="col-12 col-md-6 pt-2 px-2 text-center text-md-left">
        <?php echo __('share'); ?>:<br>
        <!-- AddToAny BEGIN -->
        <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
          <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
          <a class="a2a_button_facebook"></a>
          <a class="a2a_button_twitter"></a>
          <a class="a2a_button_email"></a>
          <a class="a2a_button_reddit"></a>
        </div>
        <script async src="https://static.addtoany.com/menu/page.js"></script>
        <!-- AddToAny END -->
      </div>
      <div class="col-12 col-md-6 pt-2 pb-4 px-2 text-center text-md-left">
        <?php echo __('link-to-this-photo'); ?>:<br>
        <input type="text" class="form-control autoselect" value="<?php echo BASE_URL,LANG,'/photo/',$this->photo_id,'/'; ?>" readonly>
      </div>
    </div>
	<?php if (isset($this->comments)): ?>
    <div class="row no-gutters p-2" style="position: relative;">
  	  <h4><?php echo __('comments'); ?> <small class="text-muted">(<?php echo $this->comments_total; ?>)</small></h4>
      <?php $allow_comment = VCfg::get('photo.allow_comment'); $this->poster_id = $this->user_id; $this->content_id = $this->photo_id; $this->ctype = 'photo'; if ($this->photo['allow_comment'] and $allow_comment == '1'): ?>
      <?php if ($allow_comment == '2' or ($allow_comment == '1' and $this->user_id)): ?>
      <?php echo $this->fetch('_comment_post'); $this->allow_comment = true; else: $this->allow_comment = false; ?>
      <div class="p-3 w-100 text-center">
    	<div class="alert alert-warning"><?php echo __('comment-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><span>'.__('login').'</span></a>', '<a href="'.REL_URL.LANG.'/user/signup/"><span>'.__('signup').'</span></a>')); ?></div>
      </div>
  	  <?php endif; else: $this->allow_comment = false; endif; echo p('comments', $this->comments, $this->comments_total, $this->photo_id, 'photo', 0, $this->allow_comment); ?>
    </div>
    <?php endif; ?>
    <div id="flag-container"></div>        
  </div>
  <div class="col-12 col-md-auto p-0 m-0 pl-md-2">
    <div class="album-right mt-2 mt-md-0">
  	  <?php echo p('adv_right', 'album-view-right'); ?>
    </div>
  </div>  
</div>
