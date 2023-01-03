<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_photo_album.js'; ?>
	  <div id="album" data-id="<?php echo $this->album['album_id']; ?>" data-user-id="<?php echo $this->user_id; ?>">
		<div id="gallery"></div>
		<div class="container-left">
		<div class="left">
		  <div class="content-group content-group-light">
			<h1><?php echo e($this->album['title']); if ($this->friends): ?> <a href="#photos" id="slideshow" class="btn-link"><i class="fa fa-lg fa-play-circle"></i> <?php echo __('slideshow'); ?></a><?php endif; ?></h1>
		  </div>
		  <div id="response" class="alert alert-response content-group" style="display: none;"></div>
		  <div id="report-container"></div>
		  <div id="content-tab-about" class="content-group content-tab">
			<div class="content-group-left">
			  <div class="content-views">
				<span><?php echo number_format($this->album['total_views']); ?></span> <?php echo __('views'); ?>
			  </div>
			  <div class="content-rating">
				<?php $percent = ($this->album['likes'] > 0 && $this->album['rated_by']) ? round($this->album['likes']*100/$this->album['rated_by']) : 100; ?>
				<div class="progress">
				  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent; ?>%;">
  					<span class="sr-only"><?php echo $percent; ?>% Complete</span>
				  </div>
				</div>
				<?php echo $percent; ?>%
				<span class="pull-right">
				  <i class="fa fa-thumbs-up"></i> <?php echo $this->album['likes']; ?>
				  <i class="fa fa-thumbs-down"></i> <?php echo ($this->album['rated_by'] - $this->album['likes']); ?>
				</span>
				<div class="clearfix"></div>
			  </div>
			</div>
			<div class="content-group-right">
			  <div class="content-info">
				<?php echo __('photos'); ?>: <a href="#photos"><strong><?php echo $this->album['total_photos']; ?></strong></a>
			  </div>
			  <?php if (VCfg::get('photo.view_from')): ?>
			  <div class="content-info">
				<?php echo __('from'); ?>: <a href="<?php echo REL_URL,'/users/',e($this->album['username']); ?>/"><strong><?php echo e($this->album['username']); ?></strong></a>
			  </div>
			  <?php endif; if (VCfg::get('photo.view_channel') and $this->album['channel_id']): ?>
			  <div class="content-info">
				<?php echo __('channel'); ?>: <a href="<?php echo REL_URL,'/channel/',$this->album['channel_slug']; ?>/"><strong><?php echo e($this->album['channel_name']); ?></strong></a>
			  </div>
			  <?php endif; if (VCfg::get('photo.view_categories')): ?>
			  <div class="content-info">
				<?php echo __('categories'); ?>: <?php $slugs = explode(',', $this->album['slugs']); $names = explode(',', $this->album['names']); foreach ($slugs as $index => $slug): ?>
				<a href="<?php echo photo_category_url($slug); ?>"><?php echo e($names[$index]); ?></a><?php if (isset($slugs[$index+1])): echo ', '; endif; ?>
				<?php endforeach ;?>
			  </div>
			  <?php endif; if (VCfg::get('photo.view_tags')): ?>
              <div class="content-info">
                <?php echo __('tags'); ?>: <?php $tags = explode(',', $this->album['tags']); foreach ($tags as $index => $tag): ?>
                <a href="<?php echo REL_URL,LANG,'/search/photo/?s=',e(str_replace(' ', '+', $tag)); ?>"><?php echo e($tag); ?></a><?php if (isset($tags[$index+1])): echo ', '; endif; ?>
                <?php endforeach ;?>
              </div>
			  <?php endif; if (isset($this->models) && $this->models): $ids = array(); ?>
              <div class="content-info">
                <?php echo __('models'); ?>: <?php foreach ($this->models as $index => $model): $ids[] = $model['model_id']; ?>
                <a href="<?php echo model_url($model['slug']); ?>"><?php echo e($model['name']); ?></a><?php if (isset($this->models[$index+1])): echo ', '; endif; ?>
                <?php endforeach ; p('model_album_views', $ids); ?>
              </div>
			  <?php endif; ?>
			  <div class="content-info">
				<?php echo __('added'); ?>: <span><?php echo VDate::nice($this->album['add_time']); ?></span>
			  </div>
			  <?php if ($this->album['description'] && VCfg::get('photo.view_desc')): ?>
			  <div class="content-info">
				<span><?php echo e($this->album['description']); ?></span>
			  </div>
			  <?php endif; ?>
			</div>
			<div class="clearfix"></div>
		  </div>
		</div>
		</div>
		<div class="right">
		  <?php echo p('adv_right', 'album-view-right'); ?>
		</div>
		<div class="clearfix"></div>
		<div class="tablist">
		  <ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#photos"><strong>Photos</strong></a></li>
		  </ul>
		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="photos">
			  <?php if ($this->friends): ?>
			  <?php if ($this->photos): echo $this->fetch('_photo_list'); if ($this->pagination['total_pages'] >= 2): echo '<nav class="text-center"><ul class="pagination">',p('pagination', $this->pagination, CUR_URL, 10),'</ul></nav>'; endif; else: ?>
			  <div class="none"><?php echo __('no-photos'); ?></div>
			  <?php endif; else: ?>
			  <div class="private"><i class="fa fa-lock fa-5x"></i><br><?php echo __('album-view-private', '<a href="'.REL_URL.LANG.'/users/'.e($this->album['username']).'/" class="btn-link"><strong>'.e($this->album['username']).'</strong></a>'); ?></div>
			  <?php endif; ?>
			</div>
		  </div>
		</div>
	  </div>
	  