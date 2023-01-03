<?php defined('_VALID') or die('Restricted Access!'); $dislikes = 0; if ($this->album['rated_by'] > 0): $dislikes = ($this->album['rated_by']-$this->album['likes']); endif; ?>
<div class="row" id="album" data-id="<?php echo $this->album['album_id']; ?>" data-user-id="<?php echo $this->user_id; ?>">
  <div class="col-12 col-md border">
    <div class="row pt-2 bg-white">
      <div class="col-12 col-md-8 text-center text-md-left pl-2">
        <h1 class="content-title"><?php echo e($this->album['title']); ?></h1>
      </div>
      <div id="subscribe" class="col-12 col-md-4 d-flex justify-content-center justify-content-md-end align-items-start mb-2 mb-md-0 pr-2">
    	<?php if ($this->user_id and p('subscribed', $this->album['user_id'], $this->user_id)): ?>
        <button type="button" class="btn btn-sm btn-primary rounded-pill btn-subscribe" data-action="del" data-user="<?php echo $this->album['user_id']; ?>"><i class="fa fa-minus"></i> <?php echo __('unsubscribe'); ?> (<?php echo $this->album['subscribers']; ?>)</button>
        <?php else: ?>
        <button type="button" class="<?php if (!$this->user_id): echo 'login '; endif; ?>btn btn-sm btn-primary rounded-pill btn-subscribe" data-action="add" data-user="<?php echo $this->album['user_id']; ?>"><i class="fa fa-plus"></i> <?php echo __('subscribe'); ?> (<?php echo $this->album['subscribers']; ?>)</button>
        <?php endif; if ($this->friends): ?>
        <button id="slideshow" class="btn btn-sm btn-primary ml-2 rounded-pill"><i class="fa fa-lg fa-play-circle"></i> <?php echo __('slideshow'); ?></button>
        <?php endif; ?>
      </div>
  	  <div class="d-flex justify-content-center justify-content-md-start flex-wrap pt-0 px-2 w-100 border-bottom">
    	<div class="content-from mr-2">
      	  <?php echo __('from'); ?>: <a href="<?php echo REL_URL,'/users/',e($this->album['username']); ?>/" rel="nofollow"><strong><?php echo e($this->album['username']); ?></strong></a>
    	</div>
    	<div class="content-details text-muted pb-2 pb-md-0">
      	  <span class="px-2"><i class="fa fa-calendar"></i> <?php echo VDate::nice($this->album['add_time']); ?></span>
      	  <span class="px-2"><i class="fa fa-camera"></i> <?php echo $this->album['total_photos'] ?></span>
      	  <span class="px-2"><i class="fa fa-eye"></i> <?php echo number_format($this->album['total_views']); ?></span>
      	  <span class="px-2"><i class="fa fa-thumbs-up<?php if ($this->album['likes'] > $dislikes): echo ' text-success'; endif; ?>"></i> <?php echo $this->album['likes']; ?></span>
      	  <span class="px-2"><i class="fa fa-thumbs-down<?php if ($this->album['likes'] < $dislikes): echo ' text-danger'; endif; ?>"></i> <?php echo $dislikes; ?></span>
    	</div>
  	  </div>
      <div class="col-12 pt-2 tb-1 px-2 border-bottom">
		<div id="response" class="col-12 col-md-12 p-2 text-center d-none"><div class="alert alert-dismissible fade show" role="alert"></div></div>
		<?php if ($this->album['channel_id'] and VCfg::get('photo.view_channel')): ?>
		<div class="my-1"><?php echo __('channel'); ?>:
          <a href="<?php echo REL_URL.LANG.'/channel/'.$this->album['channel_slug']; ?>/"><strong><?php echo e($this->album['channel_name']); ?></strong></a>
          <small class="text-muted"><i class="fa fa-camera"></i> <?php echo number_format($this->video['total_albums']); ?></small>
		</div>
        <?php endif; if (VCfg::get('photo.view_categories')): ?>
        <div class="my-1"><?php echo __('categories'); ?>: <?php $slugs = explode(',', $this->album['slugs']); $names = explode(',', $this->album['names']); foreach ($slugs as $index => $slug): ?>
        <a href="<?php echo video_category_url($slug); ?>" class="badge badge-secondary"><?php echo e($names[$index]); ?></a>
        <?php endforeach ;?></div>
        <?php endif; if (VCfg::get('photo.view_tags') and $this->album['tags']): ?>
        <div class="my-1"><?php echo __('tags'); ?>: <?php $tags = explode(',', $this->album['tags']); foreach ($tags as $index => $tag): ?>
        <a href="<?php echo video_url().'/tag/'.str_replace(' ', '-', $tag); ?>/" class="badge badge-secondary"><?php echo e($tag); ?></a>
        <?php endforeach ;?></div>
        <?php endif; if (isset($this->models) && $this->models): $ids = array(); ?>
        <div class="my-1"><?php echo __('models'); ?>: <?php foreach ($this->models as $index => $model): $ids[] = $model['model_id']; ?>
        <a href="<?php echo model_url($model['slug'], false); ?>" class="badge badge-secondary"><?php echo e($model['name']); ?></a>
        <?php endforeach; ?></div>
        <?php endif; if ($this->album['description'] && VCfg::get('photo.view_desc')): ?>
        <p class="content-description">
          <?php echo nl2br(e($this->album['description'])); ?>
        </p>
        <?php endif; ?>
      </div>
  	</div>
  	<div class="mt-2">
  	  <?php if ($this->friends): if ($this->photos): echo p('photos', $this->photos, $this->album, '-album'); if ($this->pagination['total_pages'] >= 2): ?>
  	  <nav class="mt-3"><ul class="pagination pagination-lg justify-content-center"><?php echo p('pagination', $this->pagination, CUR_URL, 10); ?></ul></nav>
  	  <?php endif; else: ?>
  	  <div class="none"><?php echo __('no-photos'); ?></div>
  	  <?php endif; else: ?>
	  <div class="private"><i class="fa fa-lock fa-5x"></i><br><?php echo __('album-view-private', '<a href="'.REL_URL.LANG.'/users/'.e($this->album['username']).'/" class="btn-link"><strong>'.e($this->album['username']).'</strong></a>'); ?></div>
  	  <?php endif; ?>
  	</div>
  </div>
  <div class="col-12 col-md-auto p-0 m-0 pl-md-2">
    <div class="album-right mt-2 mt-md-0">
  	  <?php echo p('adv_right', 'album-view-right'); ?>
    </div>
  </div>  
</div>
