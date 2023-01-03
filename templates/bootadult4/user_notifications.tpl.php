<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_user_account.js'; ?>
<?php echo $this->fetch('_user_header'); ?>
                  <form id="notifications-form" class="form-horizontal" method="post" action="<?php echo REL_URL; ?>/user/notifications/">
                      <input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
<div class="row">
  <div class="col-12 col-lg-6">
                      <div class="form-group row<?php if (!VCfg::get('user.notify_comment')): echo ' hidden'; endif; ?>">
                        <label for="profile_comment" class="col-sm-3 col-form-label"><?php echo __('profile-comment'); ?></label>
                        <div class="col-sm-9">
                          <?php $yesno = array(1 => __('yes'), 0 => __('no')); ?>
                          <?php echo VForm4::radiosInline('profile_comment', $yesno, $this->notifs['profile_comment']); ?>
                        </div>
                      </div>
                      <div class="form-group row<?php if (!VCfg::get('user.notify_rating')): echo ' hidden'; endif; ?>">
                        <label for="profile_rating" class="col-sm-3 col-form-label"><?php echo __('profile-rating'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('profile_rating', $yesno, $this->notifs['profile_rating']); ?>
                        </div>
                      </div>
                      <div class="form-group row<?php if (!VCfg::get('user.notify_subscribe')): echo ' hidden'; endif; ?>">
                        <label for="profile_subscribe" class="col-sm-3 col-form-label"><?php echo __('profile-subscribe'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('profile_subscribe', $yesno, $this->notifs['profile_subscribe']); ?>
                        </div>
                      </div>
                      <div class="form-group row<?php if (!VCfg::get('user.notify_friend')): echo ' hidden'; endif; ?>">
                        <label for="friend_request" class="col-sm-3 col-form-label"><?php echo __('friend-request'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('friend_request', $yesno, $this->notifs['friend_request']); ?>
                        </div>
                      </div>
                      <div class="form-group row<?php if (!VCfg::get('user.notify_friend')): echo ' hidden'; endif; ?>">
                        <label for="friend_approve" class="col-sm-3 col-form-label"><?php echo __('friend-approve'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('friend_approve', $yesno, $this->notifs['friend_approve']); ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="new_message" class="col-sm-3 col-form-label"><?php echo __('new-message'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('new_message', $yesno, $this->notifs['new_message']); ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="video_approve" class="col-sm-3 col-form-label"><?php echo __('video-approve'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('video_approve', $yesno, $this->notifs['video_approve']); ?>
                        </div>
                      </div>
                      <div class="form-group row<?php if (!VCfg::get('user.notify_comment')): echo ' hidden'; endif; ?>">
                        <label for="video_comment" class="col-sm-3 col-form-label"><?php echo __('video-comment'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('video_comment', $yesno, $this->notifs['video_comment']); ?>
                        </div>
                      </div>
                      <div class="form-group row<?php if (!VCfg::get('user.notify_rating')): echo ' hidden'; endif; ?>">
                        <label for="video_rating" class="col-sm-3 col-form-label"><?php echo __('video-rating'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('video_rating', $yesno, $this->notifs['video_rating']); ?>
                        </div>
                      </div>                        
  </div>
  <div class="col-12 col-lg-6">
                     <div class="form-group row"<?php if (!VModule::enabled('photo')): echo ' style="display: none;"'; endif; ?>>
                        <label for="photo_approve" class="col-sm-3 col-form-label"><?php echo __('photo-approve'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('photo_approve', $yesno, $this->notifs['photo_approve']); ?>
                        </div>
                      </div>
                      <div class="form-group row"<?php if (!VModule::enabled('photo') or !VCfg::get('user.notify_comment')): echo ' style="display: none;"'; endif; ?>>
                        <label for="photo_comment" class="col-sm-3 col-form-label"><?php echo __('photo-comment'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('photo_comment', $yesno, $this->notifs['photo_comment']); ?>
                        </div>
                      </div>
                      <div class="form-group row"<?php if (!VModule::enabled('photo') or !VCfg::get('user.notify_rating')): echo ' style="display: none;"'; endif; ?>>
                        <label for="photo_rating" class="col-sm-3 col-form-label"><?php echo __('photo-rating'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('photo_rating', $yesno, $this->notifs['photo_rating']); ?>
                        </div>
                      </div>
                      <div class="form-group row"<?php if (!VModule::enabled('game')): echo ' style="display: none;"'; endif; ?>>
                        <label for="game_approve" class="col-sm-3 col-form-label"><?php echo __('game-approve'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('game_approve', $yesno, $this->notifs['game_approve']); ?>
                        </div>
                      </div>
                      <div class="form-group row"<?php if (!VModule::enabled('game') or !VCfg::get('user.notify_comment')): echo ' style="display: none;"'; endif; ?>>
                        <label for="game_comment" class="col-sm-3 col-form-label"><?php echo __('game-comment'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('game_comment', $yesno, $this->notifs['game_comment']); ?>
                        </div>
                      </div>
                      <div class="form-group row"<?php if (!VModule::enabled('game') or !VCfg::get('user.notify_rating')): echo ' style="display: none;"'; endif; ?>>
                        <label for="game_rating" class="col-sm-3 col-form-label"><?php echo __('game-rating'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('game_rating', $yesno, $this->notifs['game_rating']); ?>
                        </div>
                      </div>
                      <div class="form-group row"<?php if (!VModule::enabled('blog')): echo ' style="display: none;"'; endif; ?>>
                        <label for="blog_approve" class="col-sm-3 col-form-label"><?php echo __('blog-approve'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('blog_approve', $yesno, $this->notifs['blog_approve']); ?>
                        </div>
                      </div>
                      <div class="form-group row"<?php if (!VModule::enabled('blog') or !VCfg::get('user.notify_comment')): echo ' style="display: none;"'; endif; ?>>
                        <label for="blog_comment" class="col-sm-3 col-form-label"><?php echo __('blog-comment'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('blog_comment', $yesno, $this->notifs['blog_comment']); ?>
                        </div>
                      </div>
                      <div class="form-group row"<?php if (!VModule::enabled('blog') or !VCfg::get('user.notify_rating')): echo ' style="display: none;"'; endif; ?>>
                        <label for="blog_rating" class="col-sm-3 col-form-label"><?php echo __('blog-rating'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('blog_rating', $yesno, $this->notifs['blog_rating']); ?>
                        </div>
                      </div>
                      <div class="form-group row"<?php if (!VModule::enabled('channel')): echo ' style="display: none;"'; endif; ?>>
                        <label for="channel_approve" class="col-sm-3 col-form-label"><?php echo __('channel-approve'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('channel_approve', $yesno, $this->notifs['channel_approve']); ?>
                        </div>
                      </div>
                      <div class="form-group row"<?php if (!VModule::enabled('channel') or !VCfg::get('user.notify_subscribe')): echo ' style="display: none;"'; endif; ?>>
                        <label for="channel_subscribe" class="col-sm-3 col-form-label"><?php echo __('channel-subscribe'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('channel_subscribe', $yesno, $this->notifs['channel_subscribe']); ?>
                        </div>
                      </div>  
  </div>
  <div class="col-12 text-center">
	<button name="submit_notifications" id="submit-notifications" class="btn btn-lg btn-primary"><?php echo __('save'); ?></button>
  </div>
</div>
</form>
<?php echo $this->fetch('_user_footer'); ?>
