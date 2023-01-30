<?php defined('_VALID') or die('Restricted Access!'); $allow_delete = VCfg::get('forum.allow_delete');  $start = 0; if ($this->pagination['page'] > 1): $start = ($this->pagination['page']-1)*$this->pagination['items_per_page']; endif; ?>
<?php foreach ($this->posts as $index => $post): $username = e($post['username']); ?>
<div id="topic-<?php echo $post['post_id']; ?>" class="media topic border rounded p-1 mb-1">
  <div class="media-left text-center pr-1">
	<a href="<?php echo REL_URL,LANG,'/users/',$username; ?>/" class="d-block">
	  <img src="<?php echo USER_URL,'/',avatar(false, $post['user_id'], $post['avatar'], $post['gender'], true); ?>" alt="<?php echo __('user-avatar', $post['username']); ?>" width="70" class="rounded">
	</a>
	<small class="text-muted"><?php echo $post['posts'],' '; if ($post['posts'] == '1'): echo __('post'); else: echo __('posts'); endif; ?></small>
  </div>
  <div class="media-body ml-3 p-1">
    <div class="d-flex justify-content-between align-items-center">
      <h5><a href="<?php echo REL_URL,LANG,'/users/',$username; ?>/"><?php echo $username; ?></a> <small class="text-muted"><?php echo __('posted'),' ',VDate::format($post['add_time'], 'd M Y - h:iA'); ?></small></h5>
      <div class="topic-right">
    	<a href="<?php echo REL_URL,LANG,'/forum/topic/',$this->topic_id; ?>/#p<?php echo $post['post_id']; ?>">#<?php echo $start+$index+2; ?></a>
      </div>
    </div>
    <p><?php echo nl2br($post['content']); ?></p>
    <div class="d-flex justify-content-between border-top py-1">
      <?php if ($post['signature']): ?>
      <div class="signature"><?php echo nl2br($post['signature']); ?></div>
      <?php endif; ?>
      <div class="topic-actions">
    	<a href="<?php echo REL_URL,LANG,'/forum/reply/',$this->topic_id,'/?post=',$post['post_id']; ?>" class="btn btn-xs btn-primary"><?php echo __('quote'); ?></a>
        <button class="btn btn-xs btn-forum-report" id="report-topic-<?php echo $post['post_id']; ?>" data-id="<?php echo $post['post_id']; ?>" data-type="topic"><i class="fa fa-flag"></i></button>
        <?php if (($allow_delete and $post['user_id'] == $this->user_id) or $this->moderator): ?>
        <button class="btn btn-xs btn-forum-delete" data-id="<?php echo $post['post_id']; ?>" data-type="topic"><i class="fa fa-trash"></i></button>
        <?php endif; if ($this->user_id == $post['user_id']): ?>
        <a href="<?php echo REL_URL,LANG,'/forum/edit/',$post['post_id']; ?>/" class="btn btn-xs"><i class="fa fa-edit"></i></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>
