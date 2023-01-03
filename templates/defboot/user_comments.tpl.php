<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_user_comments.js'; ?>
<div id="response" class="alert alert-dismissible" style="display: none;"></div>
<?php echo $this->fetch('_user_header'); ?>
<input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
<?php if ($this->allow_comment == '4'): if ($this->comments): ?>
<div class="user-comments">
<div class="help-block"><?php echo __('my-comments-help'); ?></div>
<?php $this->ctype = 'wall'; echo $this->fetch('_comment_list'); ?>
</div>
<nav class="text-center"><ul class="pagination"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
<?php else: ?>
<div class="none"><?php echo __('no-comments-approve'); ?></div>
<?php endif; else: ?>
<div class="none"><?php echo __('no-comments-approve-preferences'); ?></div>
<?php endif; ?>
<?php echo $this->fetch('_user_footer'); ?>
