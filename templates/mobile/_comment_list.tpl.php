<?php defined('_VALID') or die('Restricted Access!'); $loggedin = VAuth::loggedin(); $login = ($this->vote == '1' && !$loggedin) ? 'login ' : ''; ?>
<div id="comments-container-<?php echo $this->content_id; ?>" class="comments-container">
  <ul class="media-list">
	<?php if ($this->comments): foreach ($this->comments as $comment): ?>
	<li id="comment-<?php echo $comment['comment_id']; ?>" data-id="<?php echo $comment['comment_id']; ?>" class="media">
	  <div class="media-left">
		<?php $username = ($comment['user_id']) ? e($comment['username']) : e($comment['nickname']); $url = REL_URL.LANG.'/users/'.$username.'/'; ?>
		<a href="<?php echo $url ?>" rel="nofollow">
		  <img src="<?php echo USER_URL,'/',avatar(false, $comment['user_id'], $comment['avatar'], $comment['gender']); ?>" alt="<?php echo __('username-avatar', array($username)); ?>" width="64" class="media-object">
		</a>
	  </div>
	  <div class="media-body">
		<div class="media-heading">
		  <?php if ($comment['user_id']): ?>
		  <h4 class="pull-left"><a href="<?php echo $url; ?>" rel="nofollow"><?php echo $username; ?></a></h4>
		  <?php else: ?>
		  <h4 class="pull-left"><?php echo $username; ?></h4>
		  <?php endif; ?>
		  <small><i class="fa fa-clock-o"></i> <?php echo VDate::nice($comment['add_time']); ?></small>
		  <?php $status = (isset($comment['status'])) ? $comment['status'] : null; ?>
		  <div class="media-buttons pull-right"<?php if (!isset($status)): echo ' style="display: none;"'; endif; ?>>
			<?php if ($status == '0'): ?>
			<button class="comment-approve btn btn-ns btn-success" data-id="<?php echo $comment['comment_id']; ?>" data-content-id="<?php echo $this->content_id; ?>" data-type="<?php echo $this->ctype; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo __('approve-comment'); ?>"><?php echo __('approve'); ?></button>
			<?php endif; if (($comment['user_id'] == $this->user_id) or VAuth::group('Moderator', true)): ?>
			<button class="comment-delete btn btn-ns btn-danger" data-id="<?php echo $comment['comment_id']; ?>" data-content-id="<?php echo $this->content_id; ?>" data-type="<?php echo $this->ctype; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo __('delete-comment'); ?>"><?php echo __('delete'); ?></button>
			<?php endif; ?>
			<span id="comment-spam-<?php echo $comment['comment_id']; ?>" class="comment-spam-response">
			  <button id="comment-spam-button-<?php echo $comment['comment_id']; ?>" class="comment-spam btn btn-ns btn-warning" data-id="<?php echo $comment['comment_id']; ?>" data-content-id="<?php echo $this->content_id; ?>" data-type="<?php echo $this->ctype; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo __('report-spam'); ?>"><?php echo __('spam'); ?></button>
			</span>
		  </div>
		  <div class="clearfix"></div>
		</div>
		<p><?php echo nl2br(e($comment['comment'])); ?></p>
		<div id="comment-footer-<?php echo $comment['comment_id']; ?>" class="media-footer">
		  <?php if ($this->vote): ?>
		  <span class="text-success"><?php echo $comment['likes']; ?></span>
		  <button class="<?php echo $login; ?>comment-rate comment-rate-up btn btn-rate" data-vote="up" data-type="<?php echo $this->ctype; ?>" data-id="<?php echo $comment['comment_id']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo __('vote-up'); ?>"><i class="fa fa-thumbs-up"></i></button>
		  <button class="<?php echo $login; ?>comment-rate comment-rate-down btn btn-rate" data-vote="down" data-type="<?php echo $this->ctype; ?>" data-id="<?php echo $comment['comment_id']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo __('vote-down'); ?>"><i class="fa fa-thumbs-down"></i></button>
		  <?php endif; if ($this->reply && $this->allow_comment): ?>
		  <button class="comment-reply btn btn-xs btn-reply" data-id="<?php echo $comment['comment_id']; ?>" data-type="<?php echo $this->ctype; ?>" data-content-id="<?php echo $this->content_id; ?>"><i class="fa fa-reply"></i> <?php echo __('reply'); ?></button>
		  <?php endif; ?>
		  <small class="comment-vote-response"></small>
		</div>
		<?php if (isset($comment['replies'])): ?>
		<div id="comment-replies-container-<?php echo $comment['comment_id']; ?>" class="comment-replies-container media"<?php if ($comment['replies'] == '0'): echo ' style="display: none;"'; endif; ?>>
		  <?php if ($comment['replies'] > 0): echo p('comment_replies', $comment['comment_id'], $this->content_id, $this->ctype); endif; ?>
		</div>
		<?php endif; if (isset($this->submenu) and $this->submenu == 'user-comments'): ?>
		<div class="media-actions">
		  <button class="btn btn-ns btn-success btn-action" data-id="<?php echo $comment['comment_id']; ?>" data-action="approve"><?php echo __('approve'); ?></button>
		  <button class="btn btn-ns btn-danger btn-action" data-id="<?php echo $comment['comment_id']; ?>" data-action="delete"><?php echo __('delete'); ?></button>
		</div>
		<?php endif; ?>
	  </div>
	</li>
	<?php endforeach; endif; ?>
  </ul>
  <?php if ($this->comments_total > $this->comments_per_page): ?>
  <div class="text-center"><button id="more-comments-<?php echo $this->content_id; ?>" class="btn btn-submit" data-id="<?php echo $this->content_id; ?>" data-page="2" data-type="<?php echo $this->ctype; ?>"><?php echo __('load-more'); ?></button></div>
  <?php endif; if (!$this->comments): ?>
  <div id="no-comments" class="none"><?php echo __('no-comments'); ?></div>
  <?php endif; ?>
</div>
