<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_channel_view.js'; ?>
<div class="row" id="channel" data-id="<?php echo $this->channel['channel_id']; ?>">
  <div class="col-12">
	<div class="d-flex <?php if ($this->channel['cover']): ?>channel-backimage" style="background-image: url('<?php echo CHANNEL_URL,'/',$this->channel_id,'.cover.',$this->channel['cover']; ?>');"<?php else: ?>channel-background"<?php endif; ?>>
	  <img src="<?php echo CHANNEL_URL,'/',$this->channel_id,'.logo.',$this->channel['logo']; ?>" alt="<?php echo __('channel-image', e($this->channel['name'])); ?>" class="channel-image rounded mt-3 mb-2 mx-2">
	  <div class="mt-auto my-2">
		<h1 class="btn-channel channel-name"><?php echo e($this->channel['name']); ?></h1>
		<?php if (VCfg::get('channel.subscribe')): $login = (!$this->user_id) ? 'login ' : ''; ?>
		<div id="subscribe" class="mt-2">
          <?php if ($this->subscribed): ?>
          <button id="subscribe-del" class="btn btn-xs btn-primary rounded-pill btn-subscribe" data-action="del" data-toggle="tooltip" data-placement="top" title="<?php echo __('channel-unsubscribe-help'); ?>"><i class="fa fa-minus"></i> <?php echo __('unsubscribe'),' (',$this->channel['total_subscribers']; ?>)</button>
          <?php else: ?>
          <button id="subscribe-add" class="<?php echo $login; ?>btn btn-xs btn-primary rounded-pill btn-subscribe" data-action="add" data-toggle="tooltip" data-placement="top" title="<?php echo __('channel-subscribe-help'); ?>"><i class="fa fa-plus"></i> <?php echo __('subscribe'),' (',$this->channel['total_subscribers']; ?>)</button>
          <?php endif; ?>			
		</div>
		<?php endif; ?>
	  </div>
	</div>
  </div>
</div>
<div class="row mt-3">
  <div class="col-12 col-md-12 col-lg-3 col-xl-2 mb-3 sidebar">
	<a href="<?php echo REL_URL.LANG.'/channel/redirect/?id='.$this->channel['channel_id']; ?>" target="_blank" class="btn btn-lg btn-primary btn-block"><?php echo __('join-website-now', e($this->channel['name'])); ?> <i class="fa fa-external-link"></i></a>
	<hr class="d-none d-lg-block width="90%">
	<?php $arrow = 'up'; $color = ' text-success'; if ($this->channel['rank_prev'] > $this->channel['rank']): $arrow = 'down'; $color = ' text-danger'; endif; ?>
	<div class="d-flex flex-row flex-lg-column flex-wrap text-muted text-center text-lg-left mt-2 mt-lg-0">
	  <span class="p-1 p-md-2"><i class="fa fa-line-chart"></i> <small><?php echo __('rank'); ?>:</small> <strong><?php echo $this->channel['rank']; ?></strong> <small><i class="fa fa-arrow-<?php echo $arrow,$color; ?>"></i></small></span>
	  <span class="p-1 p-md-2"><i class="fa fa-eye"></i> <small><?php echo __('views'); ?>:</small> <strong><?php echo $this->channel['total_views']; ?></strong></span>
	  <span class="p-1 p-md-2"><i class="fa fa-video-camera"></i> <small><?php echo __('videos'); ?>:</small> <strong><?php echo $this->channel['total_videos']; ?></strong></span>
	  <span class="p-1 p-md-2"><i class="fa fa-play"></i> <small><?php echo __('video-views'); ?>:</small> <strong><?php echo $this->channel['video_views']; ?></strong></span>
	  <?php if (VModule::enabled('photo')): ?>
	  <span class="p-1 p-md-2"><i class="fa fa-camera"></i> <small><?php echo __('albums'); ?>:</small> <strong><?php echo $this->channel['total_albums']; ?></strong></span>
	  <span class="p-1 p-md-2"><i class="fa fa-image"></i> <small><?php echo __('album-views'); ?>:</small> <strong><?php echo $this->channel['album_views']; ?></strong></span>
	  <?php endif; ?>
	  <span class="p-1 p-md-2"><i class="fa fa-user-plus"></i> <small><?php echo __('subscribers'); ?>:</small> <strong><span id="subscribers-count"><?php echo $this->channel['total_subscribers']; ?></span></strong></span>
	</div>
	<?php echo w('channel_channels_viewed'); ?>	
  </div>
  <div class="col-12 col-md-12 col-lg-9 col-xl-10">
	<?php if (CUR_URL == BASE_URL.LANG.'/channel/'.$this->channel['slug'].'/' and $this->channel['description']): ?>
	<hr width="90%">
	<p class="text-muted small">
	  <?php echo nl2br($this->channel['description']); ?>
	  <span class="w-100 d-block text-center mt-2"><a href="<?php echo REL_URL.LANG.'/channel/redirect/?id='.$this->channel['channel_id']; ?>" class="btn btn-sm btn-primary rounded-pill" target="_blank"><i class="fa fa-external-link"></i> <?php echo __('join-website-now', e($this->channel['name'])); ?></a></span>
	</p>
	<?php endif; ?>
	<div class="w-100 text-center text-md-left">
	  <a href="<?php echo REL_URL,LANG,'/channel/',e($this->channel['slug']); ?>/" class="mb-1 btn btn-lg<?php if ($this->type == 'videos'): echo ' btn-primary'; else: echo ' btn-secondary'; endif; ?>"><?php echo __('videos'),' (',$this->channel['total_videos']; ?>)</a>
	  <?php if (VModule::enabled('photo')): ?><a href="<?php echo REL_URL,LANG,'/channel/',e($this->channel['slug']); ?>/photos/" class="mb-1 btn btn-lg<?php if ($this->type == 'photos'): echo ' btn-primary'; else: echo ' btn-secondary'; endif; ?>"><?php echo __('photos'),' (',$this->channel['total_albums']; ?>)</a><?php endif; ?>
    </div>
    <?php echo $this->fetch('_channel_'.$this->type); ?>
    <?php if ($this->pagination['page'] === 1 and $models = p('channel_models', $this->channel_id)): ?>
    <hr width="90%">
    <div class="h3"><?php echo __('models-appearing-in', $this->channel['name']); ?></div>
    <?php echo p('models', $models); endif; if ($this->pagination['page'] === 1 and $keywords = p('channel_searches', $this->channel['name'])): ?>
    <hr width="90%">
    <div class="h3"><?php echo __('searches-related-to', $this->channel['name']); ?></div>
    <?php foreach ($keywords as $row): $keyword = e($row['keyword']); ?>
    <a href="<?php echo REL_URL.LANG.'/search/video/?s=',substr(' ', '+', $keyword); ?>" class="badge badge-secondary"><?php echo $keyword; ?></a>
    <?php endforeach; endif; ?>
  </div>
</div>
