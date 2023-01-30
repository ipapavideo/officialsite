<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_user_comments.js'; ?>
<?php echo $this->fetch('_user_header'); ?>
<input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
<div id="response" class="w-100 d-none"><div class="alert alert-dismissible fade show" role="alert"></div></div>
<?php if ($this->allow_comment == '4'): if ($this->comments): ?>
<div class="user-comments">
<div class="text-muted mb-3"><?php echo __('my-comments-help'); ?></div>
<?php echo p('comments', $this->comments, $this->pagination['total_items'], 0, 'wall', 0, 0, $this->submenu); ?>
</div>
<nav class="mt-3"><ul class="pagination pagination-lg justify-content-center"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
<?php else: ?>
<div class="none"><?php echo __('no-comments-approve'); ?></div>
<?php endif; else: ?>
<div class="none"><?php echo __('no-comments-approve-preferences'); ?></div>
<?php endif; echo $this->fetch('_user_footer'); ?>
