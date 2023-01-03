<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_channel_view.js'; ?>
	  <div class="content" id="channel" data-id="<?php echo $this->channel_id; ?>" data-user-id="<?php echo $this->user_id; ?>">
		<div class="channel-image">
		  <img src="<?php echo CHANNEL_URL,'/',$this->channel_id,'.',$this->channel['thumb']; ?>" alt="<?php echo __('channel-image', e($this->channel['name'])); ?>" class="img-rounded">
		  <?php if (VCfg::get('channel.allow_rating')): $login = (!$this->user_id and VCfg::get('channel.rating_type') == 'user') ? 'login ' : ''; ?>
		  <div class="channel-rating">
			<div class="channel-thumbs">
			  <a href="#up" class="<?php echo $login; ?>rate-channel btn btn-rating rate-up" data-rating="1" data-toggle="tooltip" data-placement="top" title="<?php echo __('i-like-this'); ?>"><i id="thumbs-up" class="fa fa-thumbs-up fa-lg"></i></a>
			  <a href="#down" class="<?php echo $login; ?>rate-channel btn btn-rating rate-down" data-rating="0" data-toggle="tooltip" data-placement="top" title="<?php echo __('i-dislike-this'); ?>"><i id="thumbs-down" class="fa fa-thumbs-down fa-lg"></i></a>
			</div>
			<div class="channel-rating-result">
              <?php $percent = ($this->channel['likes'] > 0 && $this->channel['rated_by']) ? round($this->channel['likes']*100/$this->channel['rated_by']) : 100; ?>
              <?php echo $percent; ?>%
              <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent; ?>%;">
                  <span class="sr-only"><?php echo $percent; ?>% Complete</span>
                </div>
              </div>
			</div>
			<div class="clearfix"></div>
		  </div>
		  <div id="response" class="alert alert-response" style="display: none;"></div>
		  <?php endif; ?>
		</div>
		<div class="channel-info">
		  <div class="channel-header">
			<h1 class="pull-left"><?php echo e($this->channel['name']); ?></h1>
			<?php if (VCfg::get('channel.subscribe')): $login = (!$this->user_id) ? 'login ' : ''; ?>
			<div class="channel-actions">
			  <div id="subscribe">
				<?php if ($this->subscribed): ?>
				<button id="subscribe-del" class="btn btn-ns btn-submit btn-subscribe" data-action="del" data-toggle="tooltip" data-placement="top" title="<?php echo __('channel-unsubscribe-help'); ?>"><i class="fa fa-rss"></i> <?php echo __('unsubscribe'); ?></button>
				<?php else: ?>
				<button id="subscribe-add" class="<?php echo $login; ?>btn btn-ns btn-submit btn-subscribe" data-action="add" data-toggle="tooltip" data-placement="top" title="<?php echo __('channel-subscribe-help'); ?>"><i class="fa fa-rss"></i> <?php echo __('subscribe'); ?></button>
				<?php endif; ?>
			  </div>
			</div>
			<?php endif; ?>
			<div class="clearfix"></div>
		  </div>
		  <div class="channel-stats">
			<div class="channel-box">
			  <?php $arrow = 'up'; $color = 'text-success'; if ($this->channel['rank_prev'] > $this->channel['rank']): $arrow = 'down'; $color = 'text-danger'; endif; ?>
			  <?php echo __('rank'); ?>:<span><?php echo $this->channel['rank']; ?></span> <i class="<?php echo $color; ?> fa fa-arrow-<?php echo $arrow; ?>"></i>
			</div>
			<div class="channel-box"><?php echo __('Views'); ?>:<span><?php echo $this->channel['total_views']; ?></span></div>
			<div class="channel-box"><?php echo __('video-views'); ?>:<span><?php echo $this->channel['video_views']; ?></span></div>
			<div class="channel-box"><?php echo __('videos'); ?>:<span><?php echo $this->channel['total_videos']; ?></span></div>
			<div class="channel-box"><?php echo __('subscribers'); ?>:<span id="subscribers-count"><?php echo $this->channel['total_subscribers']; ?></span></div>
		  </div>
		  <?php if ($this->channel['description'] and VCfg::get('channel.show_desc')): ?>
		  <div class="channel-description">
			<?php echo nl2br($this->channel['description']); ?>
		  </div>
		  <?php endif; ?>
		  <div class="channel-about">
			<?php if (VCfg::get('channel.show_added')): ?>
            <div class="channel-about-row">
              <span><?php echo __('created'); ?>:</span> <?php echo VDate::nice($this->channel['add_time']); ?>
            </div>			
			<?php endif; if (VCfg::get('channel.show_tags') and $this->channel['tags']): ?>
            <div class="channel-about-row">
              <span><?php echo __('tags'); ?>:</span> <?php $tags = explode(',', $this->channel['tags']); foreach ($tags as $index => $tag): $tag = e(utf8_trim($tag)); ?>
              <a href="<?php echo REL_URL,LANG,'/search/video/?s=',$tag; ?>" class="btn-color"><?php echo $tag; ?></a><?php if (isset($tags[$index+1])): echo ', '; endif; ?>
              <?php endforeach; ?>
            </div>			
			<?php endif; ?>
			<div class="channel-about-row channel-join">
			  <a href="<?php echo REL_URL,LANG,'/channel/redirect/?id=',$this->channel['channel_id']; ?>" target="_blank" rel="nofollow" class="btn btn-submit"><?php echo __('join-website-now', e($this->channel['name'])); ?></a>
			</div>				
			<div class="clearfix"></div>
		  </div>
		</div>
	  </div>
	  <div class="clearfix"></div>
      <div class="tablist">
        <ul class="nav nav-tabs" role="tablist">
      	  <?php if ($this->type == 'videos'): ?><li class="active"><a href="#videos"><?php else: ?><li><a href="<?php echo REL_URL,LANG,'/channel/',$this->channel['slug']; ?>/"><?php endif; echo __('videos'); ?></a></li>
      	  <?php if (VModule::enabled('photo')): if ($this->type == 'photos'): ?><li class="active"><a href="#photos"><?php else: ?><li><a href="<?php echo REL_URL,LANG,'/channel/',$this->channel['slug']; ?>/photos/"><?php endif; echo __('photos'); ?></a></li><?php endif; ?>
        </ul>
        <div class="tab-content">
      	  <?php echo $this->fetch('_channel_'.$this->type); ?>
        </div>
      </div>      
