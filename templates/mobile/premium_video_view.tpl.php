<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_video_view.js'; ?>
	  <div id="video" data-id="<?php echo $this->video['video_id']; ?>" data-user-id="<?php echo $this->user_id; ?>">
		<?php if (isset($this->playlist) && $this->playlist): ?>
		<link href="<?php echo REL_URL; ?>/misc/lightslider/css/lightslider.min.css" rel="stylesheet">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h2 class="panel-title pull-left">
			  <a href="<?php echo REL_URL,LANG,'/playlist/',$this->playlist_id,'/',$this->playlist['slug']; ?>/"><?php echo e($this->playlist['name']); ?></a>
			  <small><?php echo $this->playlist['total_videos'],' ',__('videos'); ?></small>
			</h2>
			<div class="pull-right">
          	  <?php if ($this->playlist_videos['0']['video_id'] !== $this->video['video_id']): $this->prev = true; ?><button id="playlist-prev" class="btn btn-xs btn-submit" data-toggle="tooltip" data-placement="top" title="<?php echo __('playlist-prev'); ?>"><i class="fa fa-step-backward"></i></button><?php endif; ?>
              <?php $index = count($this->playlist_videos)-1; if ($this->playlist_videos[$index]['video_id'] != $this->video['video_id']): $this->next = true; ?><button id="playlist-next" class="btn btn-xs btn-submit" data-toggle="tooltip" data-placement="top" title="<?php echo __('playlist-next'); ?>"><i class="fa fa-step-forward"></i></button><?php endif; ?>
              <button id="playlist-shuffle" class="btn btn-xs btn-submit" data-toggle="tooltip" data-placement="top" title="<?php echo __('playlist-shuffle'); ?>"><i class="fa fa-random"></i></button>
              <a href="<?php echo REL_URL,'/playlist/',$this->playlist['playlist_id'],'/',$this->playlist['slug'],'/" class="btn btn-xs btn-submit" data-toggle="tooltip" data-placement="top" title="',__('playlist-view'); ?>"><i class="fa fa-list"></i></a>			
			</div>
			<div class="clearfix"></div>
		  </div>
		  <div class="panel-body">
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
		</div>
		<?php endif; ?>
		<h1><?php echo e($this->video['title']); ?></h1>
		<div class="container-premium">
		  <?php if ($this->video['status'] == '8'): echo $this->fetch('video_view_deleted'); else: if ($this->friends): ?>
		  <?php if ($this->video['embed_code'] == ''): echo $this->fetch('premium_video_view_player'); else: echo $this->fetch('premium_video_view_embedded'); endif; ?>
		  <?php else: echo $this->fetch('video_view_private'); ?>
		  <?php endif; endif; if ($this->video['channel_id'] != '0' and VCfg::get('premium.view_channel')): ?>
		  <div class="content-group">
			<div class="content-group-left channel-logo">
			  <a href="<?php echo REL_URL.LANG.'/channel/',e($this->video['channel_slug']); ?>/">
			    <img src="<?php echo CHANNEL_URL,'/',$this->video['channel_id'],'.logo.',$this->video['logo'],'" alt="'.__('channel-logo', e($this->video['channel_name'])); ?>">
			  </a>
			</div>
			<div class="content-group-right">
			  <a href="<?php echo REL_URL.LANG.'/channel/',e($this->video['channel_slug']); ?>/" class="channel-name btn-link"><?php echo e($this->video['channel_name']); ?></a>
			  <p class="channel-desc"><?php echo e($this->video['channel_desc']); ?></p>
			  <a href="<?php echo REL_URL,LANG,'/channel/redirect/?id=',$this->video['channel_id']; ?>" target="_blank" rel="nofollow" class="btn btn-submit"><?php echo __('channel-join-now', e($this->video['channel_name'])); ?></a>
			</div>
		  </div>
		  <?php endif; ?>
		  <div class="content-group content-group-light">
			<div class="content-group-left">
			  <ul class="buttons">
			    <li><a href="#rate-up" class="btn btn-rating btn-mobile rate-video rate-up" data-rating="1" data-toggle="tooltip" data-placement="top" title="<?php echo __('i-like-this'); ?>"><i id="thumbs-up" class="fa fa-thumbs-up fa-lg"></i> <?php echo __('like'); ?></a></li>
				<li><a href="#rate-down" class="btn btn-rating btn-mobile rate-video rate-down" data-rating="0" data-toggle="tooltip" data-placement="top" title="<?php echo __('i-dislike-this'); ?>"><i id="thumbs-down" class="fa fa-thumbs-down fa-lg"></i></a></li>
				<li><a href="#favorite" class="btn-mobile favorite-video" data-toggle="tooltip" data-placement="top" title="<?php echo __('add-to-favorites'); ?>"><i class="fa fa-heart fa-lg"></i></a></li>
			  </ul>
			</div>
			<div class="content-group-right">
			  <ul class="buttons content-tabs">
			    <li class="active"><a href="#about" class="video-tab" data-tab="about" data-toggle="tooltip" data-placement="top" title="<?php echo __('about-this-video'); ?>"><i class="fa fa-info"></i> <?php echo __('about'); ?></a></li>
				<?php if (VCfg::get('premium.download') && $this->video['embed_code'] == '' and $this->video['allow_download'] and !$this->trailer): ?><li><a href="#download" class="video-tab" data-tab="download" data-toggle="tooltip" data-placement="top" title="<?php echo __('download-this-video'); ?>"><i class="fa fa-download"></i> <?php echo __('download'); ?></a></li><?php endif; ?>
				<li><a href="#share" class="video-tab" data-tab="share" data-toggle="tooltip" data-placement="top" title="<?php echo __('share-this-video'); ?>"><i class="fa fa-share"></i> <?php echo __('share'); ?></a></li>
				<?php if (VModule::enabled('playlist')): ?><li><a href="#playlist" class="<?php if (!$this->user_id): echo 'login '; endif; ?>video-playlist" data-toggle="tooltip" data-placement="top" title="<?php echo __('add-to-playlist'); ?>"><i class="fa fa-plus"></i> <?php echo __('playlist'); ?></a></li><?php endif; ?>
				<li><a href="#flag" id="flag" class="flag" data-toggle="tooltip" data-placement="top" title="<?php echo __('flag-this-video'); ?>"><i class="fa fa-flag"></i></a></li>
			  </ul>			  
			</div>
			<div class="clearfix"></div>
		  </div>
		  <div id="response" class="alert alert-response content-group" style="display: none;"></div>
		  <div id="report-container"></div>
		  <div id="content-tab-about" class="content-group content-tab">
			<div class="content-group-left">
			  <div class="content-views">
				<span><?php echo number_format($this->video['total_views']); ?></span> <?php echo __('views'); ?>
			  </div>
			  <div class="content-rating">
				<?php $percent = ($this->video['likes'] > 0 && $this->video['rated_by']) ? round($this->video['likes']*100/$this->video['rated_by']) : 100; ?>
				<div class="progress">
				  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent; ?>%;">
  					<span class="sr-only"><?php echo $percent; ?>% Complete</span>
				  </div>
				</div>
				<?php echo $percent; ?>%
				<span class="pull-right">
				  <i class="fa fa-thumbs-up"></i> <?php echo $this->video['likes']; ?> &nbsp;
				  <i class="fa fa-thumbs-down"></i> <?php echo ($this->video['rated_by'] - $this->video['likes']); ?>
				</span>
				<div class="clearfix"></div>
			  </div>
			</div>
			<div class="content-group-right">
			  <?php if (VCfg::get('premium.view_from')): ?>
			  <div class="content-info">
				<?php echo __('from'); ?>: <a href="<?php echo REL_URL,'/users/',e($this->video['username']); ?>/"><strong><?php echo e($this->video['username']); ?></strong></a>
			  </div>
			  <?php endif; if (VCfg::get('premium.view_categories')): ?>
			  <div class="content-info">
				<?php echo __('categories'); ?>: <?php $slugs = explode(',', $this->video['slugs']); $names = explode(',', $this->video['names']); foreach ($slugs as $index => $slug): ?>
				<a href="<?php echo video_category_url($slug); ?>"><?php echo e($names[$index]); ?></a><?php if (isset($slugs[$index+1])): echo ', '; endif; ?>
				<?php endforeach ;?>
			  </div>
			  <?php endif; if (VCfg::get('premium.view_tags')): ?>
              <div class="content-info">
                <?php echo __('tags'); ?>: <?php $tags = explode(',', $this->video['tags']); foreach ($tags as $index => $tag): ?>
                <a href="<?php echo REL_URL,LANG,'/search/video/?s=',e(str_replace(' ', '+', $tag)); ?>"><?php echo e($tag); ?></a><?php if (isset($tags[$index+1])): echo ', '; endif; ?>
                <?php endforeach ;?>
              </div>
			  <?php endif; if (isset($this->models) && $this->models): $ids = array(); ?>
              <div class="content-info">
                <?php echo __('models'); ?>: <?php foreach ($this->models as $index => $model): $ids[] = $model['model_id']; ?>
                <a href="<?php echo model_url($model['slug'], false); ?>"><?php echo e($model['name']); ?></a><?php if (isset($this->models[$index+1])): echo ', '; endif; ?>
                <?php endforeach ; p('model_video_views', $ids); ?>
              </div>
			  <?php endif; ?>
			  <div class="content-info">
				<?php echo __('added'); ?>: <span><?php echo VDate::nice($this->video['add_time']); ?></span>
			  </div>
			  <?php if ($this->video['description'] && VCfg::get('premium.view_desc')): ?>
			  <div class="content-info">
				<span><?php echo e($this->video['description']); ?></span>
			  </div>
			  <?php endif; ?>
			</div>
			<div class="clearfix"></div>
		  </div>
		  <?php if (VCfg::get('premium.download') and $this->video['embed_code'] == '' and $this->video['allow_download'] and !$this->trailer): ?>
		  <div id="content-tab-download" class="content-group text-center content-tab" style="display: none;">
			<?php if ($this->friends): foreach ($this->files as $file): $url = ($file['url']) ? $file['url'] : REL_URL.'/premium/download/'.$this->video['video_id'].'/'.$file['file_id'].'/'.$file['resolution'].'/'; ?>
			<a href="<?php echo $url; ?>" target="_blank" rel="nofollow" class="btn btn-menu btn-link"><i class="fa fa-arrow-down"></i> <?php echo $file['resolution']; ?></a>
			<?php endforeach; else: echo __('video-view-private', array('<a href="'.REL_URL.'/users/'.e($this->video['username']).'/" class="btn-link"><strong>'.e($this->video['username']).'</strong></a>')); ?>
			<?php endif; ?>
		  </div>
		  <?php endif; ?>
		  <div id="content-tab-share" class="content-group content-tab" style="display: none;">
			<div class="row">
			  <div class="col-sm-6 col-md-6">
				<div class="content-title">Share:</div>
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
                <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
                <script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4f9d8c433d6f0bfa"></script>
                <!-- AddThis Button END -->				
			  </div>
			  <div class="col-sm-6 col-md-6">
				<div class="content-title"><?php echo __('link-to-this-video'); ?>:</div>
				<input type="text" class="form-control autoselect" value="<?php echo video_view_url($this->video_id, $this->video['slug'], null, $this->video['premium'], true); ?>" readonly>
			  </div>
			  <?php if (VCfg::get('video.embed_allow') && $this->video['allow_embed']): ?>
			  <div class="col-sm-12">
				<div class="content-title"><?php echo __('embed'); ?>:</div>
				<input type="text" class="form-control autoselect" value='<iframe src="<?php echo BASE_URL,'/embed/',$this->video_id; ?>/" frameborder="0" border="0" scrolling="no" width="100%" height="100%"></iframe>' readonly>
			  </div>
			  <?php endif; ?>
			</div>
		  </div>
		  <?php if (VModule::enabled('playlist') and $this->user_id): ?>
		  <div id="content-tab-playlist" class="content-group content-tab" style="display: none;"></div>
		  <?php endif; if (isset($this->comments)): ?>
		  <div class="content-group content-group-light">
			<div id="comments-header" class="content-group-header">
			  <div class="pull-left"><?php echo __('comments'),' (',$this->comments_total,')'; ?></div>
			  <div class="pull-right"><small><?php echo __('show-comments'); ?></small></div>
			  <div class="clearfix"></div>
			</div>
		  </div>
		  <div id="comments-body" class="content-group" style="display: none;">
			<?php $allow_comment = VCfg::get('premium.allow_comment'); $this->poster_id = $this->user_id; $this->content_id = $this->video_id; $this->ctype = 'video'; if ($this->video['allow_comment'] && $allow_comment): ?>
			<?php if ($allow_comment == '2' or ($allow_comment == '1' and $this->user_id)): echo $this->fetch('_comment_post'); $this->allow_comment = true; else: ?>
			<div class="alert alert-warning content-group text-center"><?php echo __('comment-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><span>'.__('login').'</span></a>', '<a href="'.REL_URL.LANG.'/user/signup/"><span>'.__('signup').'</span></a>')); ?></div>
			<?php $this->allow_comment = false; endif; else: $this->allow_comment = false; endif; ?>
			<?php $this->comments_per_page = VCfg::get('premium.comments_per_page'); $this->reply = VCfg::get('premium.comment_replies'); $this->vote = VCfg::get('premium.comment_vote'); echo $this->fetch('_comment_list'); ?>
		  </div>
		  <?php endif; ?>
		</div>
		<div class="tablist">
		  <ul class="nav nav-tabs" role="tablist">
			<?php if (isset($this->related)): ?><li role="presentation" class="active"><a href="#related" aria-controls="related" role="tab" data-toggle="tab"><?php echo __('related-videos'); ?></a></li><?php endif; ?>
			<?php if (VCfg::get('premium.channel_videos') && $this->video['channel_name']): ?><li role="presentation"><a href="#channel-videos" data-url="video_channel_videos&id=<?php echo $this->video_id; ?>" data-target="#channel-videos" aria-controls="channel-videos" role="tab" data-toggle="tabajax"><?php echo __('channel-videos', array($this->video['channel_name'])); ?></a></li><?php endif; ?>
			<?php if (VCfg::get('premium.user_videos')): ?><li role="presentation"><a href="#user-videos" data-url="video_user_videos&id=<?php echo $this->video_id; ?>" data-target="#user-videos" aria-controls="user-videos" role="tab" data-toggle="tabajax"><?php echo __('user-videos', array($this->video['username'])); ?></a></li><?php endif; ?>
			<li role="presentation"><a href="#thumbs" aria-controls="thumbs" role="tab" data-toggle="tab"><?php echo __('thumbs'); ?></a></li>
		  </ul>
		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="related">
			  <?php if ($this->related): $this->vclass = 'related'; $this->videos = $this->related; $this->id = '-related'; echo $this->fetch('_video_list'); ?>
			  <?php if ($this->related_total > VCfg::get('premium.view_per_page')): ?>
			  <div class="text-center"><a href="#related-more" class="btn btn-more" id="related-more" data-page="2"><i class="fa fa-spinner"></i> <?php echo __('more-related-videos'); ?></a></div>
			  <?php endif; else: ?>
			  <div class="none"><?php echo __('no-related-videos'); ?></div>
			  <?php endif; ?>
			</div>
			<?php if (VCfg::get('premium.channel_videos') && $this->video['channel_name']): ?><div role="tabpanel" class="tab-pane" id="channel-videos"></div><?php endif; ?>
			<?php if (VCfg::get('premium.user_videos')): ?><div role="tabpanel" class="tab-pane" id="user-videos"></div><?php endif; ?>
			<div role="tabpanel" class="tab-pane" id="thumbs">
			  <ul class="thumbs">
				<?php for ($i=1; $i<=$this->video['thumbs']; $i++): ?>
				<li><div class="video-thumb"><img src="<?php echo THUMB_URL,'/',path($this->video_id),'/',$i; ?>.jpg" alt="Thumb <?php echo $i; ?>"></div></li>
				<?php endfor; ?>
			  </ul>
			  <div class="clearfix"></div>
			</div>
		  </div>
		</div>
	  </div>
	  