<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_playlist_view.js'; ?>
<div id="playlist" class="row mt-2" data-id="<?php echo $this->playlist['playlist_id']; ?>">
  <div class="col-12 col-md p-0 border">
    <div class="row no-gutters pt-2 bg-white">
  	  <div class="col-12 col-md-8 text-center text-md-left pl-1">
  		<h1 class="content-title"><?php echo e($this->playlist['name']); ?></h1>
  	  </div>
  	  <div class="col-12 col-md-4 d-flex justify-content-center justify-content-md-end align-items-start pr-1">
		<?php if ($this->user_id == $this->playlist['user_id']): ?>
        <a href="<?php echo REL_URL.LANG.'/playlist/edit/',$this->playlist_id; ?>/" class="btn btn-sm btn-primary rounded-pill"><i class="fa fa-edit"></i> <?php echo __('edit'); ?></a>
        <?php endif; ?>
  		<a href="<?php echo video_view_url($this->playlist['thumb_id'], $this->playlist['video_slug'], 'playlist='.$this->playlist_id); ?>" class="btn btn-sm btn-primary rounded-pill ml-1"><i class="fa fa-play"></i> <?php echo __('play-all'); ?></a>
  	  </div>
    </div>
    <div class="d-flex justify-content-center justify-content-md-start flex-wrap pt-0 pb-1 pl-2 pr-2 border-bottom bg-white">
  	  <div class="content-from mr-2">
  		<?php echo __('from'); ?>: <a href="<?php echo REL_URL,'/users/',e($this->playlist['username']); ?>/"><strong><?php echo e($this->playlist['username']); ?></strong></a>
  	  </div>
  	  <div class="content-details text-muted">
  		<span class="px-2"><i class="fa fa-calendar"></i> <?php echo VDate::nice($this->playlist['add_time']); ?></span>
  		<span class="px-2"><i class="fa fa-video-camera"></i> <?php echo $this->playlist['total_videos']; ?></span>
  		<span class="px-2"> <i class="fa fa-eye"></i> <?php echo number_format($this->playlist['total_views']); ?></span>
  	  </div>
    </div>
    <div class="row no-gutters py-2 border-bottom">
  	  <div id="response" class="col-12 col-md-12 p-2 text-center d-none">
  		<div class="alert alert-dismissible fade show" role="alert"></div>
  	  </div>
  	  <div class="col-12 col-md-4 text-center text-md-left">
  		<?php $percent = ($this->playlist['likes'] > 0 && $this->playlist['rated_by']) ? round($this->playlist['likes']*100/$this->playlist['rated_by']) : 100; ?>
  		<div class="d-flex justify-content-center justify-content-md-start">
  		  <button type="button" class="btn btn-thumbs-up btn-rate-playlist" data-rating="1" data-toggle="tooltip" data-placement="top" title="<?php echo __('i-like-this'); ?>"><i id="thumbs-up" class="fa fa-thumbs-up"></i></button>
  		  <div id="rating" class="votes p-1 pt-2"><?php echo $percent; ?>% (<?php echo $this->playlist['rated_by'],' ',__('votes'); ?>)
  			<div class="progress progress-danger">
  			  <div class="progress-bar bg-success" style="width: <?php echo $percent; ?>%;"></div>
  			  <div class="progress-bar bg-danger" style="width: <?php echo 100-$percent; ?>%"></div>
  			</div>
  		  </div>
  		  <button type="button" class="btn btn-thumbs-down btn-rate-playlist" data-rating="0" data-toggle="tooltip" data-placement="top" title="<?php echo __('i-dislike-this'); ?>"><i id="thumbs-down" class="fa fa-thumbs-down"></i></button>
  		  <button type="button" class="<?php if (!$this->user_id): echo 'login '; endif; ?>btn btn-favorite-playlist" data-toggle="tooltip" data-placement="top" title="<?php echo __('add-to-favorites'); ?>"><i id="favorite-playlist" class="fa fa-heart"></i><?php if ($this->playlist['total_favorites'] > 0): echo ' '.$this->playlist['total_favorites']; endif; ?></button>
  		</div>  		
  	  </div>
  	  <div class="col-12 col-md-8 d-flex justify-content-center justify-content-md-end">
  		<button type="button" class="btn btn-section" data-id="about" data-toggle="tooltip" data-placement="top" title="<?php echo __('about-this-playlist'); ?>"><i class="fa fa-info-circle text-section"></i></button>
  		<button type="button" class="btn btn-section" data-id="share" data-toggle="tooltip" data-placement="top" title="<?php echo __('share-this-playlist'); ?>"><i class="fa fa-share-alt"></i></button>
  	  </div>
    </div>
    <div class="row no-gutters bg-section content-section" id="content-about">
  	  <div class="col-12 pt-2 tb-1 px-2">
        <?php if (VCfg::get('playlist.view_tags')): ?>
		<div class="my-1"><?php echo __('tags'); ?>: <?php $tags = explode(',', $this->playlist['tags']); foreach ($tags as $index => $tag): ?>
        <a href="<?php echo video_url().'/tag/'.str_replace(' ', '-', $tag); ?>/" class="badge badge-secondary"><?php echo e($tag); ?></a>
        <?php endforeach ;?></div>
		<?php endif; if ($this->playlist['description'] && VCfg::get('playlist.view_desc')): ?>
		<p class="content-description">
		  <?php echo nl2br(e($this->playlist['description'])); ?>
		</p>
		<?php endif; ?>
  	  </div>
    </div>
    <div class="row no-gutters bg-section d-none content-section" id="content-share">
  	  <div class="col-12 col-lg-6 pt-2 px-2 text-center text-md-left">
  		<?php echo __('share'); ?>:<br>
        <!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
      	  <a class="addthis_button_email"></a>
          <a class="addthis_button_favorites"></a>
          <a class="addthis_button_facebook"></a>
          <a class="addthis_button_twitter"></a>
          <a class="addthis_button_reddit"></a>
          <a class="addthis_button_compact"></a>
          <a class="addthis_counter addthis_bubble_style"></a>
        </div>
        <script>var addthis_config = {"data_track_addressbar":false};</script>
        <script src="https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4f9d8c433d6f0bfa"></script>
        <!-- AddThis Button END -->  	  
  	  </div>
  	  <div class="col-12 col-lg-6 p-2 text-center text-md-left">
  		<?php echo __('link-to-this-playlist'); ?>:<br>
  		<input type="text" class="form-control autoselect" value="<?php echo BASE_URL,'/playlist/',$this->playlist['playlist_id'],'/',$this->playlist['slug']; ?>/" readonly>
  	  </div>
    </div>
	<?php if (isset($this->comments)): ?>
    <div class="row no-gutters p-2 border-top" style="position: relative;">
      <div class="comments-title"><span class="badge badge-primary rounded-pill px-4 py-2"><?php echo __('comments'); ?> (<?php echo $this->comments_total; ?>)</span></div>
      <?php $allow_comment = VCfg::get('playlist.allow_comment'); $this->poster_id = $this->user_id; $this->content_id = $this->playlist_id; $this->ctype = 'playlist'; if ($this->playlist['allow_comment'] && $allow_comment): ?>
      <?php if ($allow_comment == '2' or ($allow_comment == '1' and $this->user_id)): echo $this->fetch('_comment_post'); $this->allow_comment = true; else: ?>
      <div class="p-3 w-100 text-center">
        <div class="alert alert-warning"><?php echo __('comment-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><span>'.__('login').'</span></a>', '<a href="'.REL_URL.LANG.'/user/signup/"><span>'.__('signup').'</span></a>')); ?></div>
      </div>
      <?php $this->allow_comment = false; endif; else: $this->allow_comment = false; endif; ?>
      <?php echo p('comments', $this->comments, $this->comments_total, $this->playlist_id, 'playlist', 0, $this->allow_comment); ?>
    </div>
    <?php endif; ?>    
  </div>
  <div class="col-12 col-md-auto p-0 m-0 pl-md-2">
	<div class="video-right mt-2 mt-md-0">
	  <?php echo p('adv_right', 'playlist-view'); ?>
	</div>
  </div>
</div>
<div class="row mt-2">
  <div class="col-12 p-0">
	<div class="tabs" id="playlistTabs">
	  <button data-type="tab" data-target="videos" class="btn btn-lg btn-primary btn-tab"><?php echo __('videos'); ?></button>
	  <div class="tabs-content mt-2" id="playlistTabsContent">
		<div class="tab-section d-block" id="videos">
		  <?php if ($this->videos): ?>
      	  <?php echo p('adv', 'playlist-native', false, 'adv-native'),p('videos', $this->videos, '-related'); ?>
      	  <?php else: ?>
      	  <div class="none"><?php echo __('no-videos'); ?></div>
      	  <?php endif; ?>
		</div>
	  </div>
	</div>
  </div>
</div>
