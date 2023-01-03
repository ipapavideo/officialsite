<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_forum_post.js';?>
<div class="row">
  <div class="col-12">
	<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
    	<li class="breadcrumb-item"><a href="<?php echo REL_URL,LANG; ?>/forum/"><?php echo __('forum'); ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo REL_URL,LANG,'/forum/',$this->topic['forum_slug']; ?>" title="<?php echo e($this->topic['forum_title']); ?>"><?php echo e($this->topic['forum_title']); ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo REL_URL,LANG,'/forum/topic/',$this->topic_id,'/',$this->topic['slug']; ?>/" title="<?php echo e($this->topic['title']); ?>"><?php echo e($this->topic['title']); ?></a></li>
        <li class="breadcrumb-item active"><?php echo __('post-reply'); ?></li>
      </ol>
    </nav>
  </div>
  <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-4 order-1 order-md-2 mb-3">
    <div class="border rounded-lg p-2">
      <h4><?php echo e(__('forum-post-rules')); ?></h4>
      <ul class="nav flex-column">
        <li class="nav-item"><i class="fa fa-check-square"></i> <?php echo __('post-rule-1'); ?></li>
        <li class="nav-item"><i class="fa fa-check-square"></i> <?php echo __('post-rule-2'); ?></li>
        <li class="nav-item"><i class="fa fa-check-square"></i> <?php echo __('post-rule-3'); ?></li>
        <li class="nav-item"><i class="fa fa-check-square"></i> <?php echo __('post-rule-4'); ?></li>
        <li class="nav-item"><i class="fa fa-check-square"></i> <?php echo __('post-rule-5'); ?></li>
      </ul>
    </div>
  </div>
  <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-8 order-2 order-md-1">
    <form id="topic-form" role="form" method="post" action="<?php echo REL_URL,LANG,'/forum/reply/',$this->topic_id; ?>/<?php if ($this->quote_id): echo '?quote='.$this->quote_id; endif; ?>">
  	  <input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
      <div id="content-group" class="form-group">
        <textarea name="content" id="post-content" class="form-control" rows="5" style="width: 100%; height: 300px;"><?php echo $this->reply['content']; ?></textarea>
      </div>
      <div class="d-flex justify-content-between">
      	<?php $captcha = VCfg::get('forum.captcha'); if ($captcha): if ($captcha === 2 and VCfg::get('recaptcha')): ?>
        <div class="g-recaptcha" data-sitekey="<?php echo VCfg::get('recaptcha_site_key'); ?>" id="recaptcha" data-theme="dark"></div>
        <?php else: ?>
        <div class="d-flex justify-content-center justify-content-md-start">
          <img src="<?php echo REL_URL; ?>/captcha/?rand=<?php rand(1, 100); ?>" id="captcha" class="captcha-freload" alt="" data-toggle="tooltip" data-placement="top" title="<?php echo __('click-to-reload-image'); ?>">
      	  <input name="captcha-verify" type="text" class="form-control form-control-sm ml-1" style="width: 40px;">
        </div>
        <?php endif; endif; if ($this->moderator): ?>
        <div class="custom-control custom-checkbox">
      	  <input name="sticky" type="checkbox" id="sticky" class="custom-control-input" <?php if ($this->topic['sticky']): echo ' checked="checked"'; endif; ?>>
      	  <label class="custom-control-label text-muted" for="sticky"><?php echo __('stick-topic'); ?></label>
        </div>
        <?php endif; ?>
        <div class="submit-post">
      	  <button type="submit" name="submit_reply" id="submit-reply" class="btn btn-primary"><?php echo __('post'); ?></button>
        </div>    	
      </div>
    </form>
  </div>
</div>
