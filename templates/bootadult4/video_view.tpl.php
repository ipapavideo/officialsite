<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_video_view.js'; ?>
<div id="video" class="row mt-2" data-id="<?php echo $this->video['video_id']; ?>">
  <?php if (isset($this->playlist) && $this->playlist): ?>
  <link href="<?php echo REL_URL; ?>/misc/lightslider/css/lightslider.min.css" rel="stylesheet">
  <div class="col-12 mb-1 border rounded bg-white">
	<div class="d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center mb-2">
	  <div>
		<a href="<?php echo REL_URL,LANG,'/playlist/',$this->playlist_id,'/',$this->playlist['slug']; ?>/" class="h3 ml-0 pl-0"><?php echo e($this->playlist['name']); ?></a>
		<small class="text-muted"><?php echo $this->playlist['total_videos'],' ',__('videos'); ?></small>
	  </div>
	  <div>
        <?php if ($this->playlist_videos['0']['video_id'] !== $this->video['video_id']): $this->prev = true; ?><button id="playlist-prev" class="btn btn-sm btn-submit" data-toggle="tooltip" data-placement="top" title="<?php echo __('playlist-prev'); ?>"><i class="fa fa-step-backward"></i></button><?php endif; ?>
        <?php $index = count($this->playlist_videos)-1; if ($this->playlist_videos[$index]['video_id'] != $this->video['video_id']): $this->next = true; ?><button id="playlist-next" class="btn btn-sm btn-submit" data-toggle="tooltip" data-placement="top" title="<?php echo __('playlist-next'); ?>"><i class="fa fa-step-forward"></i></button><?php endif; ?>
        <button id="playlist-shuffle" class="btn btn-sm btn-submit" data-toggle="tooltip" data-placement="top" title="<?php echo __('playlist-shuffle'); ?>"><i class="fa fa-random"></i></button>
        <a href="<?php echo REL_URL,'/playlist/',$this->playlist['playlist_id'],'/',$this->playlist['slug'],'/" class="btn btn-sm btn-submit" data-toggle="tooltip" data-placement="top" title="',__('playlist-view'); ?>"><i class="fa fa-list"></i></a>	  
	  </div>
	</div>
    <ul id="lightSlider" class="cS-hidden">
  	  <?php foreach ($this->playlist_videos as $index => $video): if ($video['video_id'] == $this->video['video_id']): $this->item = $index+1; endif;
      if (!isset($this->item)): $this->url_prev = video_view_url($video['video_id'], $video['slug'], 'playlist='.$this->playlist_id); endif;
      if (isset($this->item) && $index == $this->item): $this->url_next = video_view_url($video['video_id'], $video['slug'], 'playlist='.$this->playlist_id); endif; ?>
      <li class="playlist-video<?php if ($video['video_id'] == $this->video['video_id']): $item = $index+1; echo ' playlist-active'; endif; ?>">
        <a href="<?php echo video_view_url($video['video_id'], $video['slug'], 'playlist='.$this->playlist_id); ?>">
          <img src="<?php echo THUMB_URL,'/',path($video['video_id']),'/',$video['thumb'],'.jpg" alt="',e($video['title']); ?>" width="150" height="84" />
          <p class="slider-title"><?php echo e($video['title']); ?></p>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>	
  </div>
  <?php endif; ?>
  <div class="col-12 col-md p-0 border">
    <?php if ($this->video['status'] == '8'): echo $this->fetch('video_view_deleted'); else: if ($this->friends): ?>
    <?php if ($this->video['embed_code'] == ''): echo $this->fetch('video_view_'.VCfg::get('video.player')); else: echo $this->fetch('video_view_embedded'); endif; ?>
    <?php else: echo $this->fetch('video_view_private'); ?>
    <?php endif; endif; $adv = p('adv_player', $this->video['adv_id'], $this->video['adv_mobile_id']); if ($adv): ?>
    <div class="row no-gutters pt-1 border-bottom"><div class="col-12"><?php echo $adv; ?></div></div>
    <?php endif; ?>
    <div class="row no-gutters pt-2 pb-1 pb-md-0 bg-white">
  	  <div class="col-12 col-md-8 text-center text-md-left pl-1">
  		<h1 class="content-title"><?php echo e($this->video['title']); ?></h1>
  	  </div>
  	  <div id="subscribe" class="col-12 col-md-4 d-flex justify-content-center justify-content-md-end align-items-start pr-1">
  		<?php if ($this->user_id and p('subscribed', $this->video['user_id'], $this->user_id)): ?>
  		<button type="button" class="btn btn-sm rounded-pill btn-primary btn-subscribe" data-action="del" data-user="<?php echo $this->video['user_id']; ?>"><i class="fa fa-user"></i> <?php echo __('unsubscribe'); ?> (<?php echo $this->video['subscribers']; ?>)</button>
  		<?php else: ?>
  		<button type="button" class="btn btn-sm rounded-pill btn-primary btn-subscribe" data-action="add" data-user="<?php echo $this->video['user_id']; ?>"><i class="fa fa-user"></i> <?php echo __('subscribe'); ?> (<?php echo $this->video['subscribers']; ?>)</button>
  		<?php endif; ?>
  	  </div>
    </div>
    <div class="d-flex justify-content-center justify-content-md-start flex-wrap pt-0 pb-1 pl-2 pr-2 bg-white border-bottom">
  	  <div class="content-from mr-2">
  		<?php echo __('from'); ?>: <a href="<?php echo REL_URL,'/users/',e($this->video['username']); ?>/"><strong><?php echo e($this->video['username']); ?></strong></a>
  	  </div>
  	  <div class="content-details text-muted">
  		<span class="px-2"><i class="fa fa-calendar"></i> <?php echo VDate::nice($this->video['add_time']); ?></span>
  		<span class="px-2"> <i class="fa fa-eye"></i> <?php echo number_format($this->video['total_views']); ?></span>
  		<span class="px-2"> <i class="fa fa-clock-o"></i> <?php echo VDate::duration($this->video['duration']); ?></span>
  	  </div>
    </div>
    <div class="row no-gutters py-2 border-bottom">
  	  <div id="response" class="col-12 col-md-12 p-2 text-center d-none">
  		<div class="alert alert-dismissible fade show" role="alert"></div>
  	  </div>
  	  <div class="col-12 col-md-4 text-center text-md-left">
  		<?php $percent = ($this->video['likes'] > 0 && $this->video['rated_by']) ? round($this->video['likes']*100/$this->video['rated_by']) : 100; ?>
  		<div class="d-flex justify-content-center justify-content-md-start">
  		  <button type="button" class="btn btn-action btn-thumbs-up btn-rate-video" data-rating="1" data-toggle="tooltip" data-placement="top" title="<?php echo __('i-like-this'); ?>"><i id="thumbs-up" class="fa fa-thumbs-up"></i></button>
  		  <div id="rating" class="votes p-1 pt-2"><?php echo $percent; ?>% (<?php echo $this->video['rated_by'],' ',__('votes'); ?>)
  			<div class="progress progress-danger">
  			  <div class="progress-bar bg-success" style="width: <?php echo $percent; ?>%;"></div>
  			  <div class="progress-bar bg-danger" style="width: <?php echo 100-$percent; ?>%"></div>
  			</div>
  		  </div>
  		  <button type="button" class="btn btn-action btn-thumbs-down btn-rate-video mr-1" data-rating="0" data-toggle="tooltip" data-placement="top" title="<?php echo __('i-dislike-this'); ?>"><i id="thumbs-down" class="fa fa-thumbs-down"></i></button>
  		  <button type="button" class="btn btn-action btn-favorite-video" data-toggle="tooltip" data-placement="top" title="<?php echo __('add-to-favorites'); ?>"><i id="favorite-video" class="fa fa-heart"></i><?php if ($this->video['total_favorites'] > 0): echo ' '.$this->video['total_favorites']; endif; ?></button>
  		</div>  		
  	  </div>
  	  <div class="col-12 col-md-8 d-flex justify-content-center justify-content-md-end mt-2 mt-md-0">
  		<button type="button" class="btn btn-action btn-section mr-1" data-id="about" data-toggle="tooltip" data-placement="top" title="<?php echo __('about-this-video'); ?>"><i class="fa fa-info-circle text-section"></i></button>
  		<?php if ($this->video['thumbs'] > 1): ?>
  		<button type="button" class="btn btn-action btn-section mr-1" data-id="thumbs"><i class="fa fa-image"></i></button>
  		<?php endif; ?>
  		<button type="button" class="btn btn-action btn-section mr-1" data-id="share" data-toggle="tooltip" data-placement="top" title="<?php echo __('share-this-video'); ?>"><i class="fa fa-share-alt"></i></button>
  		<button type="button" class="btn btn-action mr-1" id="flag" data-toggle="tooltip" data-placement="top" title="<?php echo __('flag-this-video'); ?>"><i class="fa fa-flag"></i></button>
  		<?php if (VModule::enabled('playlist')): ?>
  		<button type="button" class="btn btn-action mr-1<?php if (!$this->user_id): echo ' login '; else: $playlist = true; echo ' video-playlist'; endif; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo __('add-to-playlist'); ?>"><i class="fa fa-plus"></i></button>
  		<?php endif; if (VCfg::get('video.download') && $this->video['embed_code'] == '' and $this->video['allow_download']): $download = true; ?>
  		<button type="button" class="btn btn-action btn-section mr-1" data-id="download" data-toggle="tooltip" data-placement="top" title="<?php echo __('download-this-video'); ?>"><i class="fa fa-download"></i></button>
  		<?php endif; ?>
  	  </div>
    </div>
    <div class="row no-gutters bg-section content-section" id="content-about">
  	  <div class="col-12 pt-2 tb-1 px-2">
  		<?php if (VCfg::get('video.view_channel') and $this->video['channel_id']): ?>
  		<div class="my-1"><?php echo __('channel'); ?>:
  		  <a href="<?php echo REL_URL.LANG.'/channel/'.$this->video['channel_slug']; ?>/"><strong><?php echo e($this->video['channel_name']); ?></strong></a>
  		  <small class="text-muted"><i class="fa fa-video-camera"></i> <?php echo number_format($this->video['total_videos']); ?></small>
  		</div>
  		<?php endif; if (VCfg::get('video.view_categories')): ?>
  		<div class="my-1"><?php echo __('categories'); ?>: <?php $slugs = explode(',', $this->video['slugs']); $names = explode(',', $this->video['names']); foreach ($slugs as $index => $slug): ?>
        <a href="<?php echo video_category_url($slug); ?>" class="badge badge-secondary"><?php echo e($names[$index]); ?></a>
        <?php endforeach ;?></div>
        <?php endif; if (VCfg::get('video.view_tags') and $this->video['tags']): ?>
		<div class="my-1"><?php echo __('tags'); ?>: <?php $tags = explode(',', $this->video['tags']); foreach ($tags as $index => $tag): ?>
        <a href="<?php echo video_url().'/tag/'.str_replace(' ', '-', $tag); ?>/" class="badge badge-secondary"><?php echo e($tag); ?></a>
        <?php endforeach ;?></div>
        <?php endif; if (isset($this->models) && $this->models): $ids = array(); ?>
		<div class="my-1"><?php echo __('models'); ?>: <?php foreach ($this->models as $index => $model): $ids[] = $model['model_id']; ?>
        <a href="<?php echo model_url($model['slug'], false); ?>" class="badge badge-secondary"><?php echo e($model['name']); ?></a>
		<?php endforeach; ?></div>
		<?php endif; if ($this->video['description'] && VCfg::get('video.view_desc')): ?>
		<p class="content-description">
		  <?php echo nl2br(e($this->video['description'])); ?>
		</p>
		<?php endif; ?>
  	  </div>
    </div>
    <?php if ($this->video['thumbs']): ?>
    <div class="row no-gutters bg-section d-none content-section" id="content-thumbs">
  	  <div class="grid mx-auto videos">
  		<?php for ($i=1; $i<=$this->video['thumbs']; $i++): ?>
  		<div class="cell"><div class="video-thumb"><img src="<?php echo THUMB_URL,'/',path($this->video_id),'/',$i; ?>.jpg" alt="Thumb <?php echo $i; ?>"></div></div>
  		<?php endfor; ?>
  	  </div>
    </div>
    <?php endif; ?>
    <div class="row no-gutters bg-section d-none content-section" id="content-share">
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
  	  <div class="col-12 col-md-6 pt-2 px-2 text-center text-md-left">
  		<?php echo __('link-to-this-video'); ?>:<br>
  		<input type="text" class="form-control autoselect" value="<?php echo video_view_url($this->video_id, $this->video['slug'], null, $this->video['premium'], true); ?>" readonly> 	  
  	  </div>
  	  <div class="col-12 pb-2 p-2 text-center text-md-left">
  		<?php echo __('embed'); ?>:<br>
  		<textarea class="form-control autoselect" readonly><iframe src="<?php echo BASE_URL,'/embed/',$this->video_id; ?>/" frameborder="0" border="0" scrolling="no" width="100%" height="100%" allowfullscreen></iframe></textarea>
  	  </div>
    </div>
    <?php if (isset($download)): ?>
    <div class="row no-gutters bg-section d-none content-section" id="content-download">
  	  <div class="col-12 p-2">
		<?php if ($this->download === true): if ($this->friends): ?>
		<nav class="nav nav-pills nav-fill">
		  <?php foreach ($this->files as $file): $url = ($file['url']) ? $file['url'] : video_url().'/download/'.$this->video['video_id'].'/'.$file['file_id'].'/'.$file['resolution'].'/'; ?>
		  <a class="nav-item nav-link" href="<?php echo $url; ?>" rel="nofollow" target="_blank"><i class="fa fa-arrow-down"></i> <?php echo $file['resolution']; ?></a>
		  <?php endforeach; ?>
		</nav>
  		<?php else: echo __('video-view-private', array('<a href="'.REL_URL.'/users/'.e($this->video['username']).'/" class="btn-link"><strong>'.e($this->video['username']).'</strong></a>')); ?>
  		<?php endif; elseif ($this->download == 'login'): ?>
  		<div class="alert alert-primary text-center" role="alert"><?php echo __('video-download-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><strong>'.__('login').'</strong></a>', '<a href="'.REL_URL.LANG.'/user/signup/"><strong>'.__('signup').'</strong></a>')); ?></div>
  		<?php endif; ?>
  	  </div>
    </div>
    <div class="row no-gutters bg-section d-none content-section p-2" id="content-flag"></div>
    <?php endif; if (isset($playlist)): ?>
    <div class="row no-gutters bg-section d-none content-section p-2" id="content-playlist"></div>
    <?php endif; if (isset($this->comments)): ?>
    <div class="row no-gutters p-2 border-top" style="position: relative;">
  	  <h4><?php echo __('comments'); ?> <small class="text-muted">(<?php echo $this->comments_total; ?>)</small></h4>
  	  <?php $allow_comment = VCfg::get('video.allow_comment'); $this->poster_id = $this->user_id; $this->content_id = $this->video_id; $this->ctype = 'video'; if ($this->video['allow_comment'] && $allow_comment): ?>
      <?php if ($allow_comment == '2' or ($allow_comment == '1' and $this->user_id)): echo $this->fetch('_comment_post'); $this->allow_comment = true; else: ?>
      <div class="p-3 w-100 text-center">
        <div class="alert alert-warning"><?php echo __('comment-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><span>'.__('login').'</span></a>', '<a href="'.REL_URL.LANG.'/user/signup/"><span>'.__('signup').'</span></a>')); ?></div>
      </div>
      <?php $this->allow_comment = false; endif; else: $this->allow_comment = false; endif; ?>
      <?php echo p('comments', $this->comments, $this->comments_total, $this->video_id, 'video', 0, $this->allow_comment); ?>
    </div>
    <?php endif; ?>
    <div id="flag-container"></div>
  </div>
  <div class="col-12 col-md-auto p-0 m-0 pl-md-2">
	<div class="video-right mt-2 mt-md-0">
	  <?php echo p('adv_right', 'video-view-right-1'),p('adv_right', 'video-view-right-2'),p('adv_right', 'video-view-right-3'); ?>
	</div>
  </div>
</div>
<div class="row mt-2">
  <div class="col-12 p-0">
	<div class="tabs" id="videoTabs">
	  <div class="w-100 text-center text-lg-left">
    	<?php if (isset($this->related)): ?>
		<button data-type="tab" data-target="related-videos" class="btn btn-lg btn-primary btn-tab mb-1"><?php echo __('related-videos'); ?></button>
    	<?php endif; if (VCfg::get('video.channel_videos') && $this->video['channel_name']): $channel_videos = true; ?>
		<button data-type="tabajax" data-target="channel-videos" data-url="video_channel_videos&id=<?php echo $this->video_id; ?>" class="btn btn-lg btn-secondary btn-tab mb-1"><?php echo __('channel-videos', array($this->video['channel_name'])); ?></button>
    	<?php endif; if (VCfg::get('video.user_videos')): $user_videos = true; ?>
		<button data-type="tabajax" data-target="user-videos" data-url="video_user_videos&id=<?php echo $this->video_id; ?>" class="btn btn-lg btn-secondary btn-tab mb-1"><?php echo __('user-videos', array($this->video['username'])); ?></button>
		<?php endif; ?>
	  </div>
	  <div class="tabs-content mt-2" id="videoTabsContent">
		<?php if (isset($this->related)): ?>
		<div class="tab-section d-block" id="related-videos">
		  <?php if ($this->related): ?>
      	  <?php echo p('adv', 'video-related-native', false, 'adv-native'),p('videos', $this->related, '-related'); if ($this->related_total > VCfg::get('video.view_per_page')): ?>
      	  <div class="text-center"><button class="btn btn-lg btn-primary rounded-pill w-50 my-2" id="related-more" data-page="2"><i class="fa fa-spinner"></i> <strong><?php echo __('more-related-videos'); ?></strong></button></div>
      	  <?php endif; else: ?>
      	  <div class="none"><?php echo __('no-related-videos'); ?></div>
      	  <?php endif; ?>
		</div>
		<?php endif; if (isset($channel_videos)): ?>
		<div class="tab-section" id="channel-videos"></div>
		<?php endif; if (isset($user_videos)): ?>
		<div class="tab-section" id="user-videos"></div>
		<?php endif; ?>
	  </div>
	</div>
  </div>
</div>
