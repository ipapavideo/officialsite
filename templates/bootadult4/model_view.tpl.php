<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_model_view.js'; ?>
<div class="row" id="model" data-id="<?php echo $this->model['model_id']; ?>">
  <div class="col-12">
	<div class="d-flex <?php if ($this->model['ext_wall']): ?>model-backimage" style="background-image: url('<?php echo MODEL_URL,'/',$this->model_id,'_wall.',$this->model['ext_wall']; ?>');"<?php else: ?>model-background"<?php endif; ?>>
	  <img src="<?php echo MODEL_URL,'/',$this->model_id,'.',$this->model['ext']; ?>" alt="<?php echo __('model-image', e($this->model['name'])); ?>" class="model-image rounded mt-3 mb-2 mx-2">
	  <div class="mt-auto my-2">
		<h1 class="model-btn model-name"><?php echo e($this->model['name']); ?></h1>
		<?php if (VCfg::get('model.subscribe')): $login = (!$this->user_id) ? 'login ' : ''; ?>
		<div id="subscribe" class="mt-2">
          <?php if ($this->subscribed): ?>
          <button id="subscribe-del" class="btn btn-xs btn-primary rounded-pill btn-subscribe" data-action="del" data-toggle="tooltip" data-placement="top" title="<?php echo __('model-unsubscribe-help'); ?>"><i class="fa fa-minus"></i> <?php echo __('unsubscribe'),' (',$this->model['total_subscribers']; ?>)</button>
          <?php else: ?>
          <button id="subscribe-add" class="<?php echo $login; ?>btn btn-xs btn-primary rounded-pill btn-subscribe" data-action="add" data-toggle="tooltip" data-placement="top" title="<?php echo __('model-subscribe-help'); ?>"><i class="fa fa-plus"></i> <?php echo __('subscribe'),' (',$this->model['total_subscribers']; ?>)</button>
          <?php endif; ?>			
		</div>
		<?php endif; ?>
	  </div>
	</div>
  </div>
</div>
<div class="row mt-1 mt-lg-3">
  <div class="col-12 col-md-12 col-lg-3 col-xl-2 mb-2 sidebar">
	<?php $arrow = 'up'; $color = ' text-success'; if ($this->model['rank_prev'] > $this->model['rank']): $arrow = 'down'; $color = ' text-danger'; endif; ?>
    <div class="d-flex flex-row flex-lg-column flex-wrap text-muted text-center text-lg-left justify-content-center mt-2 mt-lg-0">
      <span class="p-1 p-md-2"><i class="fa fa-line-chart"></i> <small><?php echo __('rank'); ?>:</small> <strong><?php echo $this->model['rank']; ?></strong><small><i class="fa fa-arrow-<?php echo $arrow,$color; ?>"></i></small></span>
      <span class="p-1 p-md-2"><i class="fa fa-eye"></i> <small><?php echo __('views'); ?>:</small> <strong><?php echo number_format($this->model['total_views']); ?></strong></span>
      <span class="p-1 p-md-2"><i class="fa fa-video-camera"></i> <small><?php echo __('videos'); ?>:</small> <strong><?php echo number_format($this->model['total_videos']); ?></strong></span>
      <span class="p-1 p-md-2"><i class="fa fa-play"></i> <small><?php echo __('video-views'); ?>:</small> <strong><?php echo number_format($this->model['video_views']); ?></strong></span>
      <?php if (VModule::enabled('photo')): ?>
      <span class="p-1 p-md-2"><i class="fa fa-camera"></i> <small><?php echo __('albums'); ?>:</small> <strong><?php echo number_format($this->model['total_albums']); ?></strong></span>
      <?php endif; ?>
      <span class="p-1 p-md-2"><i class="fa fa-user-plus"></i> <small><?php echo __('subscribers'); ?>:</small> <strong><span id="subscribers-count"><?php echo $this->model['total_subscribers']; ?></span></strong></span>
    </div>
    <?php echo w('model_models_viewed'); ?>
  </div>
  <div class="col-12 col-md-12 col-lg-9 col-xl-10">
	<?php if (CUR_URL == model_url($this->model['slug'])): ?>
	<div class="row my-1">
	  <div class="col-12">
		<span class="h6 font-weight-bold"><?php echo __('about'); ?></span>
		<div class="grid-info">
		  <?php if ($this->model['performs']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('performs'); ?>:</span>
			<span class="model-value"><?php echo $this->model['performs']; ?></span>
		  </div>
		  <?php endif; if ($this->model['aliases']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('aliases'); ?>:</span>
			<span class="model-value"><?php echo e($this->model['aliases']); ?></span>
		  </div>	
		  <?php endif; if ($this->model['birth_date'] and $this->model['birth_date'] != '1970-01-01'): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('birth-date'); ?>:</span>
			<span class="model-value"><?php echo VDate::format($this->model['birth_date'], 'M d, Y'); ?></span>
		  </div>	
		  <?php endif; if ($this->model['birth_location']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('birth-location'); ?>:</span>
			<span class="model-value"><?php echo e($this->model['birth_location']); ?></span>
		  </div>	
		  <?php endif; if ($this->model['birth_name']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('birth-name'); ?>:</span>
			<span class="model-value"></span> <?php echo e($this->model['birth_name']); ?></span>
		  </div>	
		  <?php endif; if ($this->model['countryName']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('country'); ?>:</span>
			<span class="model-value"><?php echo e($this->model['countryName']); ?>:</span>
		  </div>	
		  <?php endif; if ($this->model['url']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('website'); ?>:</span>
			<span class="model-value"><a href="<?php echo $this->model['url']; ?>" target="_blank" rel="nofollow"><?php echo e($this->model['url']); ?></a></span>
		  </div>	
		  <?php endif; if ($this->model['bust_size']): ?>
		  <div class="cell-info">		  
			<span class="model-expl"><?php echo __('bust-size'); ?>:</span>
			<span class="model-value"><?php echo $this->bust_sizes[$this->model['bust_size']]; ?></span>
		  </div>	
		  <?php endif; if ($this->model['measurements']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('measurements'); ?>:</span>
			<span class="model-value"><?php echo e($this->model['measurements']); ?></span>
		  </div>	
		  <?php endif; if ($this->model['height']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('height'); ?>:</span>
			<span class="model-value"><?php echo e($this->model['height']); ?></span>
		  </div>	
		  <?php endif; if ($this->model['weight']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('weight'); ?>:</span>
			<span class="model-value"><?php echo e($this->model['weight']); ?></span>
		  </div>	
		  <?php endif; if ($this->model['eye_color']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('eye-color'); ?>:</span>
			<span class="model-value"><?php echo __($this->eye_colors[$this->model['eye_color']]); ?></span>
		  </div>	
		  <?php endif; if ($this->model['hair_color']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('hair-color'); ?>:</span>
			<span class="model-value"><?php echo __($this->hair_colors[$this->model['hair_color']]); ?></span>
		  </div>	
		  <?php endif; if ($this->model['ethnicity']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('ethnicity'); ?>:</span>
			<span class="model-value"><?php echo __($this->ethnicities[$this->model['ethnicity']]); ?></span>
		  </div>	
		  <?php endif;if ($this->model['nationality']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('nationality'); ?>:</span>
			<span class="model-value"><?php echo e($this->model['nationality']); ?></span>
		  </div>	
		  <?php endif; if ($this->model['has_tattoos']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('tattoos'); ?>:</span>
			<span class="model-value"><?php echo e($this->model['tattoos']); ?></span>
		  </div>	
		  <?php endif; if ($this->model['has_piercings']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('piercings'); ?>:</span>
			<span class="model-value"><?php echo e($this->model['piercings']); ?></span>
		  </div>	
		  <?php endif; if ($this->model['custom1']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('model-custom-1'); ?>:</span>
			<span class="model-value"><?php echo e($this->model['custom1']); ?></span>
		  </div>	
		  <?php endif; if ($this->model['custom2']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('model-custom-2'); ?>:</span>
			<span class="model-value"><?php echo e($this->model['custom2']); ?></span>
		  </div>	
		  <?php endif; if ($this->model['custom3']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('model-custom-3'); ?>:</span>
			<span class="model-value"><?php echo e($this->model['custom3']); ?></span>
		  </div>	
		  <?php endif; if ($this->model['custom4']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('model-custom-4'); ?>:</span>
			<span class="model-value"><?php echo e($this->model['custom4']); ?></span>
		  </div>	
		  <?php endif; if ($this->model['custom5']): ?>
		  <div class="cell-info">
			<span class="model-expl"><?php echo __('model-custom-5'); ?>:</span>
			<span class="model-value"><?php echo e($this->model['custom5']); ?></span>
		  </div>	
		  <?php endif; ?>
		</div>
	  </div>
	  <?php if ($this->model['description']): ?>
	  <div class="col-12 mt-2">
		<span class="h6 font-weight-bold"><?php echo __('bio'); ?></span>
		<p class="model-bio text-muted"><?php echo nl2br($this->model['description']); ?></p>
	  </div>
	  <?php endif; ?>
	</div>
	<?php endif; ?>
	<div class="w-100 text-center text-lg-left">
	  <a href="<?php echo model_url($this->model['slug']); ?>" class="mb-1 btn btn-lg<?php if ($this->type == 'videos'): echo ' btn-primary'; else: echo ' btn-secondary'; endif; ?>"><?php echo __('videos'),' (',$this->model['total_videos']; ?>)</a>
	  <?php if (VModule::enabled('photo')): ?><a href="<?php echo model_url($this->model['slug']); ?>photos/" class="mb-1 btn btn-lg<?php if ($this->type == 'photos'): echo ' btn-primary'; else: echo ' btn-secondary'; endif; ?>"><?php echo __('photos'),' (',$this->model['total_albums']; ?>)</a><?php endif; ?>
	  <a href="<?php echo model_url($this->model['slug']); ?>comments/" class="mb-1 btn btn-lg<?php if ($this->type == 'comments'): echo ' btn-primary'; else: echo ' btn-secondary'; endif; ?>"><?php echo __('comments'),' ('.$this->model['total_comments']; ?>)</a>
    </div>
    <?php echo $this->fetch('_model_'.$this->type); ?>
  </div>
</div>