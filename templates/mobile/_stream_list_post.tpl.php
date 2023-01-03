<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if ($wall = p('wall', $this->wall_id)): ?>
<div id="wall-<?php echo $wall['wall_id']; ?>">
  <div class="wall-content">
  <?php echo $wall['content']; ?>
  </div>
  <div class="wall-footer">
	<?php if ($this->wall_rating == '1'): ?>
	<div id="wall-rating-<?php echo $wall['wall_id']; ?>" class="wall-rating pull-left">
	  <?php $class = ($wall['percent'] >= 50 or $wall['percent'] == '0') ? 'text-success' : 'text-danger'; ?>
	  <?php $disabled = (!upref($wall['wall_rating'], $wall['user_id'], $this->poster_id)) ? ' disabled="disabled"' : ''; ?>
	  <span class="wall-percent <?php echo $class; ?>"><?php echo round($wall['percent']); ?>%</span>
	  <button class="btn btn-rating rate-wall" data-id="<?php echo $wall['wall_id']; ?>" data-rating="1" data-toggle="tooltip" data-placement="top" title="<?php echo __('i-like-this'); ?>"<?php echo $disabled; ?>><i class="fa fa-thumbs-up"></i></button>
	  <button class="btn btn-rating rate-wall" data-id="<?php echo $wall['wall_id']; ?>" data-rating="0" data-toggle="tooltip" data-placement="top" title="<?php echo __('i-dislike-this'); ?>"<?php echo $disabled; ?>><i class="fa fa-thumbs-down"></i></button>
	</div>
	<?php endif; if (VCfg::get('profile.comments') and $comment = upref($wall['wall_comments'], $wall['user_id'], $this->poster_id)): ?>
	<div class="wall-comment pull-left">
	  <button class="btn btn-xs btn-link btn-post comment-wall" data-id="<?php echo $wall['wall_id']; ?>"><i class="fa fa-comment"></i> <?php echo __('comment'); ?></button>
	</div>
	<?php endif; ?>
	<div class="wall-report pull-right">
	  <button class="btn btn-xs btn-link btn-post report-wall" data-id="<?php echo $wall['wall_id']; ?>"><i class="fa fa-flag"></i></button>
	</div>
	<div class="clearfix"></div>
  </div>
  <?php if (VCfg::get('profile.comments')): $this->content_id = $wall['wall_id']; ?>
  <div id="wall-comments-<?php echo $this->content_id; ?>" class="wall-comments">
	<?php $this->ctype = 'wall'; if ($comment): $allow_comment = VCfg::get('profile.allow_comment'); if (($allow_comment == '1' && $this->poster_id) or $allow_comment == '2'): ?>
	<?php echo '<div id="post-comment-'.$this->content_id.'" style="display:none;"><div class="comment-post-container"></div></div>'; $this->allow_comment = true; else: echo $this->allow_comment = false; endif; ?>
	<?php else: $this->allow_comment = false; endif; ?>
	<?php if ($wall['total_comments'] > 0): $this->comments = p('wall_comments', $wall['wall_id']); $this->comments_total = $wall['total_comments']; ?>
	<?php $this->comments_per_page = VCfg::get('profile.comments_per_page'); $this->reply = VCfg::get('profile.comment_replies'); $this->vote = VCfg::get('profile.comment_vote'); echo $this->fetch('_comment_list'); ?>
	<?php else: ?>
	<div id="comments-container-<?php echo $this->content_id; ?>" class="comments-container" style="display: none;"><ul class="media-list"></ul></div>
	<?php endif; ?>
  </div>
  <?php endif; ?>
</div>
<?php endif; ?>
