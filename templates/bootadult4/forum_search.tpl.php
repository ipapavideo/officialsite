<?php defined('_VALID') or die('Restricted Access!'); ?>
<div id="report-container"></div>
<div id="delete-container"></div>
<div class="row">
  <div class="col-12">
	<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo REL_URL,LANG; ?>/forum/"><?php echo __('forum'); ?></a></li>
        <li class="breadcrumb-item active"><?php echo __('forum-search', $this->query); ?></li>
      </ol>
	</nav>
	<h1 class="forum-title"><?php echo __('forum-search', $this->query); ?></h1>
	<?php if ($this->pagination['total_pages'] > 1): ?>
	<div class="d-flex justify-content-center justify-content-md-between align-items-center forum-header">
      <div class="forum-pagination">
        <nav aria-label="pagination"><ul class="pagination pagination-sm mb-1"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
      </div>
    </div>
    <?php endif; ?>
    <div class="w-100 mt-1 p-1 border rounded">
      <?php if ($this->topics): echo $this->fetch('_forum_topic_list'); else: ?>
      <div class="none"><?php echo __('no-topics'); ?></div>
      <?php endif; ?>
    </div>
	<?php if ($this->pagination['total_pages'] > 1): ?>
	<div class="d-flex justify-content-center justify-content-md-between align-items-center forum-footer mt-1">
      <div class="forum-pagination">
        <nav aria-label="pagination"><ul class="pagination pagination-sm mb-1"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
      </div>
    </div>
    <?php endif; ?>
	<nav class="mt-2" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo REL_URL,LANG; ?>/forum/"><?php echo __('forum'); ?></a></li>
        <li class="breadcrumb-item active"><?php echo __('forum-search', $this->query); ?></li>
      </ol>
	</nav>
  </div>
</div>