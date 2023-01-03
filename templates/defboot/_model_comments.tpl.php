<?php defined('_VALID') or die('Restricted Access!'); ?>
<div role="tabpanel" class="tab-pane active" id="comments">
  <div class="model-content-menu">
    <div class="model-order-title pull-left"><?php echo e($this->title); ?></div>
    <?php echo $this->fetch('_model_comments_menu'); ?>
	<div class="clearfix"></div>
  </div>
  <div class="model-comments">
	<?php $allow_comment = VCfg::get('model.allow_comment'); $this->poster_id = $this->user_id; $this->content_id = $this->model_id; $this->ctype = 'model'; if ($allow_comment == '2' or ($allow_comment == '1' and $this->user_id)): ?>
	<?php echo $this->fetch('_comment_post'); $this->allow_comment = true; else: $this->allow_comment = false; ?>
	<div class="alert alert-warning content-group text-center"><?php echo __('comment-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><span>'.__('login').'</span></a>', '<a href="'.REL_URL.LANG.'/user/signup/"><span>'.__('signup').'</span></a>')); ?></div>
	<?php endif; $this->comments_per_page = VCfg::get('model.comments_per_page'); $this->reply = VCfg::get('model.comment_replies'); $this->vote = VCfg::get('model.comment_vote'); echo $this->fetch('_comment_list'); ?>
  </div>
</div>
