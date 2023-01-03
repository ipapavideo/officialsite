<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_forum.js'; ?>
	  <div id="content">
		<ol class="breadcrumb">
		  <li><a href="<?php echo REL_URL,LANG; ?>/forum/"><?php echo __('forum'); ?></a></li>
		  <li><a href="<?php echo REL_URL,LANG,'/forum/search/?s=',str_replace(' ', '+', $this->query); ?>"><?php echo __('forum-search', $this->query); ?></a></li>
		</ol>
		<div class="forum-header">
		  <div class="forum-pagination">
			<?php if ($this->pagination['total_pages'] > 1): ?>
			<nav><ul class="pagination pagination-xs"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
			<?php else: echo '<span class="content-info">',__('single-page'),'</span>'; endif; ?>			
		  </div>
		  <div class="clearfix"></div>
		</div>
		<div class="panel panel-default panel-forum">
		  <div class="panel-heading">
			<h3 class="panel-title"><?php echo __('forum-search', $this->query); ?></h3>
			<div class="clearfix"></div>
		  </div>
		  <div id="forum-<?php echo $this->forum['forum_id']; ?>" class="panel-body">
			<?php if ($this->topics): echo $this->fetch('_forum_topic_list'); else: ?>
			<div class="none"><?php echo __('no-topics'); ?></div>
			<?php endif; ?>
		  </div>
		</div>
		<div class="forum-footer">
		  <div class="forum-pagination">
			<?php if ($this->pagination['total_pages'] > 1): ?>
			<nav><ul class="pagination pagination-xs"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
			<?php else: echo '<span class="content-info">',__('single-page'),'</span>'; endif; ?>			
		  </div>
		  <div class="clearfix"></div>
		</div>
	  </div>
