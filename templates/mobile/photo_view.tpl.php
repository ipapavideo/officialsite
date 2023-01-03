<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_photo_view.js'; ?>
	  <div id="photo" data-id="<?php echo $this->photo['photo_id']; ?>" data-album="<?php echo $this->photo['album_id']; ?>" data-user="<?php echo $this->user_id; ?>">
		<div class="right">
		  <?php echo p('adv_right', 'photo-view-right-1'),p('adv_right', 'photo-view-right-2'),p('adv_right', 'photo-view-right-3'); ?>
		</div>
		<div class="left">
		  <?php if ($this->photo['status'] == '8'): ?>
		  <div class="photo-"><?php echo __('this-photo-was-deleted'); ?></div>
		  <?php else: ?>
		  <div id="image">
			<?php if ($this->friends): ?>
			<a href="<?php echo REL_URL,LANG,'/photo/',$this->photo_next; ?>/"><img src="<?php echo $this->photo['photo_url'],'/',$this->photo_id,'.',$this->photo['ext']; ?>" alt="<?php echo $this->photo['caption']; ?>" class="img-reponsive" style="max-width: 100%;"></a>
			<?php if (isset($this->photo_prev) and $this->photo_prev): ?>
			<a href="<?php echo REL_URL,LANG,'/photo/',$this->photo_prev; ?>/" class="photo-prev"><i class="fa fa-chevron-circle-left fa-2x"></i></a>
			<?php endif; if (isset($this->photo_next) and $this->photo_next): ?>
			<a href="<?php echo REL_URL,LANG,'/photo/',$this->photo_next; ?>/" class="photo-next"><i class="fa fa-chevron-circle-right fa-2x"></i></a>
			<?php endif; else: ?>
			<div class="private"><i class="fa fa-lock fa-5x"></i><br><?php echo __('photo-view-private', '<a href="'.REL_URL.LANG.'/users/'.e($this->photo['username']).'/" class="btn-link"><strong>'.e($this->photo['username']).'</strong></a>'); ?></div>
			<?php endif; ?>
		  </div>
		  <?php endif; ?>
		  <div class="content-group content-group-light">
			<div class="content-group-left">
			  <ul class="buttons">
			    <li><a href="#rate-up" class="btn btn-rating rate-photo rate-up" data-rating="1" data-toggle="tooltip" data-placement="top" title="<?php echo __('i-like-this'); ?>"><i id="thumbs-up" class="fa fa-thumbs-up fa-lg"></i> <?php echo __('like'); ?></a></li>
				<li><a href="#rate-down" class="btn btn-rating rate-photo rate-down" data-rating="0" data-toggle="tooltip" data-placement="top" title="<?php echo __('i-dislike-this'); ?>"><i id="thumbs-down" class="fa fa-thumbs-down fa-lg"></i></a></li>
				<li><a href="#favorite" class="favorite-photo" data-toggle="tooltip" data-placement="top" title="<?php echo __('add-to-favorites'); ?>"><i class="fa fa-heart fa-lg"></i></a></li>
			  </ul>
			</div>
			<div class="content-group-right">
			  <ul class="buttons content-tabs">
			    <li class="active"><a href="#about" class="video-tab" data-tab="about" data-toggle="tooltip" data-placement="top" title="<?php echo __('about-this-video'); ?>"><i class="fa fa-info"></i> <?php echo __('about'); ?></a></li>
				<li><a href="#share" class="video-tab" data-tab="share" data-toggle="tooltip" data-placement="top" title="<?php echo __('share-this-video'); ?>"><i class="fa fa-share"></i> <?php echo __('share'); ?></a></li>
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
				<span><?php echo number_format($this->photo['total_views']); ?></span> <?php echo __('views'); ?>
			  </div>
			  <div class="content-rating">
				<?php $percent = ($this->photo['likes'] > 0 && $this->photo['rated_by']) ? round($this->photo['likes']*100/$this->photo['rated_by']) : 100; ?>
				<div class="progress">
				  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent; ?>%;">
  					<span class="sr-only"><?php echo $percent; ?>% Complete</span>
				  </div>
				</div>
				<?php echo $percent; ?>%
				<span class="pull-right">
				  <i class="fa fa-thumbs-up"></i> <?php echo $this->photo['likes']; ?> &nbsp;
				  <i class="fa fa-thumbs-down"></i> <?php echo ($this->photo['rated_by'] - $this->photo['likes']); ?>
				</span>
				<div class="clearfix"></div>
			  </div>
			</div>
			<div class="content-group-right">
			  <?php if (VCfg::get('video.view_from')): ?>
			  <div class="content-info">
				<?php echo __('from'); ?>: <a href="<?php echo REL_URL,'/users/',e($this->photo['username']); ?>/"><strong><?php echo e($this->photo['username']); ?></strong></a>
			  </div>
			  <?php endif; ?>
			  <div class="content-info">
				<?php echo __('album'); ?>: <a href="<?php echo album_url($this->photo['album_id'], $this->photo['slug'], $this->photo['premium']); ?>"><strong><?php echo e($this->photo['title']); ?></strong></a>
			  </div>
			  <div class="content-info">
				<?php echo __('added'); ?>: <span><?php echo VDate::nice($this->photo['add_time']); ?></span>
			  </div>
			  <?php if ($this->photo['description'] && VCfg::get('photo.view_desc')): ?>
			  <div class="content-info">
				<span><?php echo e($this->photo['description']); ?></span>
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
				<div class="content-title">Link to this photo:</div>
				<input type="text" class="form-control autoselect" value="<?php echo BASE_URL,LANG,'/photo/',$this->photo_id,'/'; ?>" readonly>
			  </div>
			</div>
		  </div>
		  <?php if (isset($this->comments)): ?>
		  <div class="content-group content-group-light">
			<div id="comments-header" class="content-group-header">
			  <div class="pull-left"><?php echo __('comments'),' (',$this->comments_total,')'; ?></div>
			  <div class="pull-right"><small><?php echo __('show-comments'); ?></small></div>
			  <div class="clearfix"></div>
			</div>
		  </div>
		  <div id="comments-body" class="content-group">
			<?php $allow_comment = VCfg::get('photo.allow_comment'); $this->poster_id = $this->user_id; $this->content_id = $this->photo_id; $this->ctype = 'photo'; if ($this->photo['allow_comment'] and $allow_comment == '1'): ?>
			<?php if ($allow_comment == '2' or ($allow_comment == '1' and $this->user_id)): ?>			
			<?php echo $this->fetch('_comment_post'); $this->allow_comment = true; else: $this->allow_comment = false; ?>
			<div class="alert alert-warning content-group text-center"><?php echo __('comment-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><span>'.__('login').'</span></a>', '<a href="'.REL_URL.LANG.'/user/signup/"><span>'.__('signup').'</span></a>')); ?></div>
			<?php endif; else: $this->allow_comment = false; endif; ?>
			<?php $this->comments_per_page = VCfg::get('photo.comments_per_page'); $this->reply = VCfg::get('photo.comment_replies'); $this->vote = VCfg::get('photo.comment_vote'); echo $this->fetch('_comment_list'); ?>
		  </div>
		  <?php endif; ?>
		</div>
		<div class="clearfix"></div>
	  </div>
	  