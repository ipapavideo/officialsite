<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_model_view.js'; ?>
	  <div class="content" id="model" data-id="<?php echo $this->model_id; ?>" data-user-id="<?php echo $this->user_id; ?>">
		<div class="model-image">
		  <img src="<?php echo MODEL_URL,'/',$this->model_id,'.',$this->model['ext']; ?>" alt="<?php echo __('model-image', e($this->model['name'])); ?>" class="img-rounded">
		  <?php if (VCfg::get('model.allow_rating')): $login = (!$this->user_id and VCfg::get('model.rating_type') == 'user') ? 'login ' : ''; ?>
		  <div class="model-rating">
			<div class="model-thumbs">
			  <a href="#up" class="<?php echo $login; ?>rate-model btn btn-rating" data-rating="1" data-toggle="tooltip" data-placement="top" title="<?php echo __('i-like-this'); ?>"><i id="thumbs-up" class="fa fa-thumbs-up fa-lg"></i></a>
			  <a href="#down" class="<?php echo $login; ?>rate-model btn btn-rating" data-rating="0" data-toggle="tooltip" data-placement="top" title="<?php echo __('i-dislike-this'); ?>"><i id="thumbs-down" class="fa fa-thumbs-down fa-lg"></i></a>
			</div>
			<div class="model-rating-result">
              <?php $percent = ($this->model['likes'] > 0 && $this->model['rated_by']) ? round($this->model['likes']*100/$this->model['rated_by']) : 100; ?>
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
		<div class="model-info">
		  <div class="model-header">
			<h1 class="pull-left"><?php echo e($this->model['name']); ?></h1>
			<?php if (VCfg::get('model.subscribe')): $login = (!$this->user_id) ? 'login ' : ''; ?>
			<div class="model-actions">
			  <div id="subscribe">
				<?php if ($this->subscribed): ?>
				<button id="subscribe-del" class="btn btn-ns btn-submit btn-subscribe" data-action="del" data-toggle="tooltip" data-placement="top" title="<?php echo __('model-unsubscribe-help'); ?>"><i class="fa fa-rss"></i> <?php echo __('unsubscribe'); ?></button>
				<?php else: ?>
				<button id="subscribe-add" class="<?php echo $login; ?>btn btn-ns btn-submit btn-subscribe" data-action="add" data-toggle="tooltip" data-placement="top" title="<?php echo __('model-subscribe-help'); ?>"><i class="fa fa-rss"></i> <?php echo __('subscribe'); ?></button>
				<?php endif; ?>
			  </div>
			</div>
			<?php endif; ?>
			<div class="clearfix"></div>
			<div id="response-subscribe" class="alert alert-response" style="display: none;"></div>			
		  </div>
		  <div class="model-stats">
			<div class="model-box">
			  <?php $arrow = 'up'; $color = 'text-success'; if ($this->model['rank_prev'] > $this->model['rank']): $arrow = 'down'; $color = 'text-danger'; endif; ?>
			  <?php echo __('rank'); ?>:<span><?php echo $this->model['rank']; ?></span> <i class="<?php echo $color; ?> fa fa-arrow-<?php echo $arrow; ?>"></i>
			</div>
			<div class="model-box"><?php echo __('Views'); ?>:<span><?php echo $this->model['total_views']; ?></span></div>
			<div class="model-box"><?php echo __('video-views'); ?>:<span><?php echo $this->model['video_views']; ?></span></div>
			<div class="model-box"><?php echo __('videos'); ?>:<span><?php echo $this->model['total_videos']; ?></span></div>
			<div class="model-box"><?php echo __('subscribers'); ?>:<span id="subscribers-count"><?php echo $this->model['total_subscribers']; ?></span></div>
		  </div>
		  <?php if ($this->model['description']): ?>
		  <div class="model-bio">
			<div class="model-info-title"><?php echo __('bio'); ?></div>
			<?php echo nl2br($this->model['description']); ?>
		  </div>
		  <?php endif; ?>
		  <div class="model-about">
			<div class="model-info-title"><?php echo __('about'); ?></div>
			<?php if ($this->model['performs']): ?>
			<div class="model-about-row">
			  <span><?php echo __('performs'); ?>:</span> <?php echo $this->model['performs']; ?>
			</div>
			<?php endif; if ($this->model['aliases']): ?>
			<div class="model-about-row">
			  <span><?php echo __('aliases'); ?>:</span> <?php echo $this->model['aliases']; ?>
			</div>
			<?php endif; if ($this->model['birth_date'] and $this->model['birth_date'] != '1970-01-01' and $this->model['birth_date'] != '0000-00-00'): ?>
			<div class="model-about-row">
			  <span><?php echo __('birth-date'); ?>:</span> <?php echo VDate::format($this->model['birth_date'], 'M d, Y'); ?>
			</div>
			<?php endif; if ($this->model['birth_location']): ?>
			<div class="model-about-row">
			  <span><?php echo __('birth-location'); ?>:</span> <?php echo e($this->model['birth_location']); ?>
			</div>
			<?php endif; if ($this->model['birth_name']): ?>
			<div class="model-about-row">
			  <span><?php echo __('birth-name'); ?>:</span> <?php echo e($this->model['birth_name']); ?>
			</div>
			<?php endif; if ($this->model['countryName']): ?>
			<div class="model-about-row">
			  <span><?php echo __('country'); ?>:</span> <?php echo e($this->model['countryName']); ?>
			</div>
			<?php endif; if ($this->model['url']): ?>
			<div class="model-about-row">
			  <span><?php echo __('website'); ?>:</span> <a href="<?php echo $this->model['url']; ?>" target="_blank" rel="nofollow"><?php echo e($this->model['url']); ?></a>
			</div>
			<?php endif; if ($this->model['bust_size']): ?>
          	<div class="model-about-row">
              <span><?php echo __('cup-size'); ?>:</span> <?php echo $this->bust_sizes[$this->model['bust_size']]; ?>
            </div>
			<?php endif; if ($this->model['measurements']): ?>
          	<div class="model-about-row">
              <span><?php echo __('measurements'); ?>:</span> <?php echo e($this->model['measurements']); ?>
            </div>
            <?php endif; if ($this->model['height']): ?>
          	<div class="model-about-row">
              <span><?php echo __('height'); ?>:</span> <?php echo e($this->model['height']); ?>
            </div>
            <?php endif; if ($this->model['weight']): ?>
          	<div class="model-about-row">
              <span><?php echo __('weight'); ?>:</span> <?php echo e($this->model['weight']); ?>
            </div>
            <?php endif; if ($this->model['eye_color']): ?>
          	<div class="model-about-row">
              <span><?php echo __('eye-color'); ?>:</span> <?php echo __($this->eye_colors[$this->model['eye_color']]); ?>
            </div>
            <?php endif; if ($this->model['hair_color']): ?>
          	<div class="model-about-row">
              <span><?php echo __('hair-color'); ?>:</span> <?php echo __($this->hair_colors[$this->model['hair_color']]); ?>
            </div>
            <?php endif; if ($this->model['ethnicity']): ?>
          	<div class="model-about-row">
              <span><?php echo __('ethnicity'); ?>:</span> <?php echo __($this->ethnicities[$this->model['ethnicity']]); ?>
            </div>
            <?php endif;if ($this->model['nationality']): ?>
          	<div class="model-about-row">
              <span><?php echo __('nationality'); ?>:</span> <?php echo e($this->model['nationality']); ?>
            </div>
			<?php endif; if ($this->model['has_tattoos']): ?>
			<div class="model-about-row">
			  <span><?php echo __('tattoos'); ?>:</span> <?php echo e($this->model['tattoos']); ?>
			</div>
			<?php endif; if ($this->model['has_piercings']): ?>
			<div class="model-about-row">
			  <span><?php echo __('piercings'); ?>:</span> <?php echo e($this->model['piercings']); ?>
			</div>
			<?php endif; if ($this->model['custom1']): ?>
			<div class="model-about-row">
			  <span><?php echo __('model-custom-1'); ?>:</span> <?php echo e($this->model['custom1']); ?>
			</div>
			<?php endif; if ($this->model['custom2']): ?>
			<div class="model-about-row">
			  <span><?php echo __('model-custom-2'); ?>:</span> <?php echo e($this->model['custom2']); ?>
			</div>
            <?php endif; if ($this->model['custom3']): ?>
          	<div class="model-about-row">
              <span><?php echo __('model-custom-3'); ?>:</span> <?php echo $this->model['custom3']; ?>
            </div>
            <?php endif; if ($this->model['custom4']): ?>
          	<div class="model-about-row">
              <span><?php echo __('model-custom-4'); ?>:</span> <?php echo $this->model['custom4']; ?>
            </div>
            <?php endif; if ($this->model['custom5']): ?>
          	<div class="model-about-row">
              <span><?php echo __('model-custom-5'); ?>:</span> <?php echo $this->model['custom5']; ?>
            </div>
            <?php endif; ?>
			<div class="clearfix"></div>
		  </div>
		</div>
	  </div>
	  <div class="clearfix"></div>
      <div class="tablist">
        <ul class="nav nav-tabs" role="tablist">
      	  <?php if ($this->type == 'videos'): ?><li class="active"><a href="#videos"><?php else: ?><li><a href="<?php echo model_url($this->model['slug']); ?>"><?php endif; echo __('videos'); ?></a></li>
      	  <?php if (VModule::enabled('photo')): if ($this->type == 'photos'): ?><li class="active"><a href="#photos"><?php else: ?><li><a href="<?php echo model_url($this->model['slug']); ?>photos/"><?php endif; echo __('photos'); ?></a></li><?php endif; ?>
      	  <?php if ($this->type == 'comments'): ?><li class="active"><a href="#comments"><?php else: ?><li><a href="<?php echo model_url($this->model['slug']); ?>comments/"><?php endif; echo __('comments'); ?></a></li>
        </ul>
        <div class="tab-content">
      	  <?php echo $this->fetch('_model_'.$this->type); ?>
        </div>
      </div>      
