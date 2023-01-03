<?php defined('_VALID') or die('Restricted Access!'); ?>
<div id="report-container"></div>
<div id="delete-container"></div>
<div class="row">
  <div class="col-12">
	<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo REL_URL,LANG; ?>/forum/"><?php echo __('forum'); ?></a></li>
        <li class="breadcrumb-item active"><?php echo e($this->forum['title']); ?></li>
      </ol>
	</nav>
	<h1 class="forum-title"><?php echo e($this->forum['title']); ?></h1>
	<div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-between align-items-center forum-header">
      <div class="forum-pagination">
        <?php if ($this->pagination['total_pages'] > 1): ?>
        <nav aria-label="pagination"><ul class="pagination pagination-sm mb-1"><?php echo p('pagination', $this->pagination, REL_URL.LANG.'/forum/'.$this->forum['slug'].'/#PAGE#/'); ?></ul></nav>
        <?php else: echo '<span class="content-info">',__('single-page'),'</span>'; endif; ?>
      </div>
      <div class="forum-action">
    	<?php if ($this->user_id): ?>
      	  <?php if ($this->perms === true): ?>
          <a href="<?php echo REL_URL,LANG; ?>/forum/post/<?php echo $this->forum['forum_id']; ?>/" class="btn btn-sm btn-primary"><strong><?php echo __('post-new-topic'); ?></strong></a>
          <?php endif; ?>
        <?php else: ?>
        <a href="#login" class="login btn btn-sm btn-outline-danger"><?php echo __('forum-login-post'); ?></a>
        <?php endif; ?>
      </div>
    </div>
    <div class="w-100 mt-1 p-1 border rounded">
      <?php if ($this->topics): echo p('topics', $this->topics, $this->user_id); else: ?>
      <div class="none"><?php echo __('no-topics'); ?></div>
      <?php endif; ?>
    </div>
    <div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-between align-items-center forum-footer mt-1">
      <div class="forum-pagination">
        <?php if ($this->pagination['total_pages'] > 1): ?>
        <nav aria-label="pagination"><ul class="pagination pagination-sm"><?php echo p('pagination', REL_URL.LANG.'/forum/'.$this->forum['slug'].'/#PAGE#/'); ?></ul></nav>
        <?php else: echo '<span class="content-info">',__('single-page'),'</span>'; endif; ?>
      </div>
      <div class="forum-action align-self-center align-self-md-start">
    	<?php if ($this->user_id): ?>
      	  <?php if ($this->perms === true): ?>
          <a href="<?php echo REL_URL,LANG; ?>/forum/post/<?php echo $this->forum['forum_id']; ?>/" class="btn btn-sm btn-primary"><strong><?php echo __('post-new-topic'); ?></strong></a>
          <?php endif; ?>
        <?php else: ?>
        <a href="#login" class="login btn btn-sm btn-outline-danger"><?php echo __('forum-login-post'); ?></a>
        <?php endif; ?>
      </div>
    </div>
	<nav class="mt-2" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo REL_URL,LANG; ?>/forum/"><?php echo __('forum'); ?></a></li>
        <li class="breadcrumb-item active"><?php echo e($this->forum['title']); ?></li>
      </ol>
	</nav>
  </div>
</div>