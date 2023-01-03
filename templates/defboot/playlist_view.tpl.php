<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_playlist_view.js'; ?>
	  <div id="playlist" data-id="<?php echo $this->playlist['playlist_id']; ?>" data-user-id="<?php echo $this->user_id; ?>">
		<div class="container-left">
		<div class="left">
		  <div class="content-group content-group-light">
			<h1 class="pull-left"><?php echo e($this->playlist['name']); ?></h1>
			<div class="pull-right">
			  <?php if ($this->user_id == $this->playlist['user_id']): ?>
			  <a href="<?php echo REL_URL.LANG.'/playlist/edit/',$this->playlist_id; ?>/" class="btn btn-xs btn-submit"><i class="fa fa-edit"></i> <?php echo __('edit'); ?></a>
			  <?php endif; ?>
			  <a href="<?php echo video_view_url($this->playlist['thumb_id'], $this->playlist['video_slug'], 'playlist='.$this->playlist_id); ?>" class="btn btn-xs btn-submit"><i class="fa fa-play"></i> <?php echo __('play-all'); ?></a>
			</div>
			<div class="clearfix"></div>
			<div class="content-group-left">
			  <ul class="buttons">
				<?php $login = ($this->user_id) ? '' : 'login '; $rate_login = (VCfg::get('playlist.rating_type') == 'user') ? $login : ''; ?>
			    <li><a href="#rate-up" class="<?php echo $rate_login; ?>btn btn-rating rate-playlist" data-rating="1" data-toggle="tooltip" data-placement="top" title="<?php echo __('i-like-this'); ?>"><i id="thumbs-up" class="fa fa-thumbs-up fa-lg"></i> <?php echo __('like'); ?></a></li>
				<li><a href="#rate-down" class="<?php echo $rate_login; ?>btn btn-rating rate-playlist" data-rating="0" data-toggle="tooltip" data-placement="top" title="<?php echo __('i-dislike-this'); ?>"><i id="thumbs-down" class="fa fa-thumbs-down fa-lg"></i></a></li>
				<li><a href="#favorite" class="<?php echo $login; ?>favorite-playlist" data-toggle="tooltip" data-placement="top" title="<?php echo __('add-to-favorites'); ?>"><i class="fa fa-heart fa-lg"></i></a></li>
			  </ul>
			</div>
			<div class="content-group-right">
			  <ul class="buttons content-tabs">
			    <li class="active"><a href="#about" class="playlist-tab" data-tab="about" data-toggle="tooltip" data-placement="top" title="<?php echo __('about-this-video'); ?>"><i class="fa fa-info"></i> <?php echo __('about'); ?></a></li>
				<li><a href="#share" class="playlist-tab" data-tab="share" data-toggle="tooltip" data-placement="top" title="<?php echo __('share-this-video'); ?>"><i class="fa fa-share"></i> <?php echo __('share'); ?></a></li>
			  </ul>			  
			</div>
			<div class="clearfix"></div>
		  </div>
		  <div id="response" class="alert alert-response content-group" style="display: none;"></div>
		  <div id="report-container"></div>
		  <div id="content-tab-about" class="content-group content-tab">
			<div class="content-group-left">
			  <div class="content-views">
				<span><?php echo number_format($this->playlist['total_views']); ?></span> <?php echo __('views'); ?>
			  </div>
			  <div class="content-rating">
				<?php $percent = ($this->playlist['likes'] > 0 && $this->playlist['rated_by']) ? round($this->playlist['likes']*100/$this->playlist['rated_by']) : 100; ?>
				<div class="progress">
				  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent; ?>%;">
  					<span class="sr-only"><?php echo $percent; ?>% Complete</span>
				  </div>
				</div>
				<?php echo $percent; ?>%
				<span class="pull-right">
				  <i class="fa fa-thumbs-up"></i> <?php echo $this->playlist['likes']; ?>
				  <i class="fa fa-thumbs-down"></i> <?php echo ($this->playlist['rated_by'] - $this->playlist['likes']); ?>
				</span>
				<div class="clearfix"></div>
			  </div>
			</div>
			<div class="content-group-right">
			  <?php if (VCfg::get('playlist.view_from')): ?>
			  <div class="content-info">
				<?php echo __('from'); ?>: <a href="<?php echo REL_URL,'/users/',e($this->playlist['username']); ?>/"><strong><?php echo e($this->playlist['username']); ?></strong></a>
			  </div>
			  <?php endif; if (VCfg::get('playlist.view_tags')): ?>
              <div class="content-info">
                <?php echo __('tags'); ?>: <?php $tags = explode(',', $this->playlist['tags']); foreach ($tags as $index => $tag): ?>
                <a href="<?php echo REL_URL,LANG,'/search/video/?s=',e(str_replace(' ', '+', $tag)); ?>"><?php echo e($tag); ?></a><?php if (isset($tags[$index+1])): echo ', '; endif; ?>
                <?php endforeach ;?>
				<button id="suggest-tag" type="button" class="btn btn-ns btn-menu"><i class="fa fa-plus"></i> <?php echo __('suggest'); ?></button>
              </div>
			  <?php endif; if (VCfg::get('playlist.view_added')): ?>
			  <div class="content-info">
				<?php echo __('added'); ?>: <span><?php echo VDate::nice($this->playlist['add_time']); ?></span>
			  </div>
			  <?php endif; if ($this->playlist['description'] && VCfg::get('playlist.view_desc')): ?>
			  <div class="content-info">
				<span><?php echo nl2br(e($this->playlist['description'])); ?></span>
			  </div>
			  <?php endif; ?>
			</div>
			<div class="clearfix"></div>
		  </div>
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
                <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4f9d8c433d6f0bfa"></script>
                <!-- AddThis Button END -->				
			  </div>
			  <div class="col-sm-6 col-md-6">
				<div class="content-title">Link to this playlist:</div>
				<input type="text" class="form-control autoselect" value="<?php echo BASE_URL,'/playlist/',$this->playlist['playlist_id'],'/',$this->playlist['slug']; ?>/" readonly>
			  </div>
			</div>
		  </div>
		</div>
		</div>
		<div class="right">
		  <?php echo p('adv_right', 'playlist-view'); ?>
		</div>
		<div class="clearfix"></div>
		<div class="tablist">
		  <ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#related" aria-controls="related" role="tab" data-toggle="tab"><strong><?php echo __('videos'); ?></strong></a></li>
			<?php if (isset($this->comments)): ?><li role="presentation"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab"><strong><?php echo __('comments'),'</strong>'; if ($this->comments_total): echo ' (',$this->comments_total,')'; endif; ?></a></li><?php endif; ?>
		  </ul>
		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="related">
			  <?php if ($this->videos): $this->vclass = 'related'; $this->id = '-playlist'; echo $this->fetch('_video_list'); ?>
			  <?php else: ?>
			  <div class="none"><?php echo __('no-videos'); ?></div>
			  <?php endif; ?>
			</div>
			<div role="tabpanel" class="tab-pane" id="comments">
			  <?php $allow_comment = VCfg::get('playlist.allow_comment'); $this->poster_id = $this->user_id; $this->content_id = $this->playlist_id; $this->ctype = 'playlist'; if ($this->playlist['allow_comment'] or ($allow_comment == '1' && $this->user_id) or $allow_comment == '2'): ?>
			  <?php echo $this->fetch('_comment_post'); $this->allow_comment = true; else: $this->allow_comment = false; endif; ?>
			  <?php $this->comments_per_page = VCfg::get('playlist.comments_per_page'); $this->reply = VCfg::get('playlist.comment_replies'); echo $this->fetch('_comment_list'); ?>
			</div>
		  </div>
		</div>
	  </div>
	  