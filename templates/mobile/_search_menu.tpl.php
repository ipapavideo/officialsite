<?php defined('_VALID') or die('Restricted Access!'); ?>
	  <div class="content-search-left">
		<div class="panel panel-default panel-search">
		  <div class="panel-heading">
			<h3 class="panel-title pull-left"><?php echo __('content-type'); ?></h3>			
			<button type="button" class="btn btn-ns btn-menu btn-panel pull-right" data-target="content-types"><i class="fa fa-arrow-up"></i></button>
			<div class="clearfix"></div>
		  </div>
		  <div id="content-types" class="panel-body panel-body-search">
			<ul class="nav nav-stacked nav-list">
			  <li<?php if ($this->menu == 'video'): echo ' class="active disabled"'; endif; ?>><a href="<?php echo REL_URL,LANG,'/search/video/?s=',e($this->query); ?>"><i class="fa fa-video-camera"></i> <?php echo __('videos'); ?></a></li>
			  <?php if (VModule::enabled('photo')): ?><li<?php if ($this->menu == 'photo'): echo ' class="active disabled"'; endif; ?>><a href="<?php echo REL_URL,LANG,'/search/photo/?s=',e($this->query); ?>"><i class="fa fa-camera"></i> <?php echo __('photos'); ?></a></li><?php endif; ?>
			  <?php if (VModule::enabled('game')): ?><li<?php if ($this->menu == 'game'): echo ' class="active disabled"'; endif; ?>><a href="<?php echo REL_URL,LANG,'/search/game/?s=',e($this->query); ?>"><i class="fa fa-gamepad"></i> <?php echo __('games'); ?></a></li><?php endif; ?>
			  <?php if (VModule::enabled('blog')): ?><li<?php if ($this->menu == 'blog'): echo ' class="active disabled"'; endif; ?>><a href="<?php echo REL_URL,LANG,'/search/blog/?s=',e($this->query); ?>"><i class="fa fa-file-text-o"></i> <?php echo __('blogs'); ?></a></li><?php endif; ?>
			  <?php if (VModule::enabled('forum')): ?><li<?php if ($this->menu == 'forum'): echo ' class="active disabled"'; endif; ?>><a href="<?php echo REL_URL,LANG,'/search/forum/?s=',e($this->query); ?>"><i class="fa fa-comments"></i> <?php echo __('forum'); ?></a></li><?php endif; ?>
			  <?php if (VModule::enabled('model')): ?><li<?php if ($this->menu == 'model'): echo ' class="active disabled"'; endif; ?>><a href="<?php echo REL_URL,LANG,'/search/model/?s=',e($this->query); ?>"><i class="fa fa-female"></i> <?php echo __('models'); ?></a></li><?php endif; ?>
			  <?php if (VModule::enabled('story')): ?><li<?php if ($this->menu == 'story'): echo ' class="active disabled"'; endif; ?>><a href="<?php echo REL_URL,LANG,'/search/story/?s=',e($this->query); ?>"><i class="fa fa-camera"></i> <?php echo __('stories'); ?></a></li><?php endif; ?>
			</ul>
		  </div>
		</div>
		<?php if (isset($this->popular) and $this->popular): ?>
		<div class="panel panel-default panel-search">
		  <div class="panel-heading">
			<h3 class="panel-title pull-left"><?php echo __('related-searches'); ?></h3>			
			<button type="button" class="btn btn-ns btn-menu btn-panel pull-right" data-target="related-searches"><i class="fa fa-arrow-up"></i></button>
			<div class="clearfix"></div>
		  </div>
		  <div id="related-searches" class="panel-body panel-body-search">
			<ul class="nav nav-stacked nav-list">
			  <?php foreach ($this->popular as $row): ?>
			  <li><a href="<?php echo REL_URL,'/search/',$this->menu,'/?s=',e(str_replace(' ', '+', $row['keyword'])),'">',e($row['keyword']); ?></a></li>
			  <?php endforeach; ?>
			</ul>
		  </div>
		</div>
		<?php endif; ?>
