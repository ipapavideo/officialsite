<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_user_account.js'; ?>
<?php echo $this->fetch('_user_header'); ?>
                    <form id="preferences-form" class="form-horizontal" method="post" action="<?php echo REL_URL; ?>/user/preferences/">
                      <input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
<div class="row">
  <div class="col-12 col-lg-6">
                      <div class="form-group row">
                        <label for="profile" class="col-sm-3 col-form-label"><?php echo __('show-profile'); ?></label>
                        <div class="col-sm-9">
                          <?php $afn = array(1 => __('all'), 2 => __('friends'), 0 => __('no')); ?>
                          <?php echo VForm4::radiosInline('profile', $afn, $this->prefs['profile']); ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="wall" class="col-sm-3 col-form-label"><?php echo __('wall-posts'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('wall', array(3 => __('only-you'), 2 => __('friends'), 1 => __('all'), 0 => __('no')), $this->prefs['wall']); ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="wall_rating" class="col-sm-3 col-form-label"><?php echo __('wall-rating'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('wall_rating', $afn, $this->prefs['wall_rating']); ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="wall_comments" class="col-sm-3 col-form-label"><?php echo __('wall-comments'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('wall_comments', array_merge($afn, array(3 => __('only-you'), 4 => __('approve'))), $this->prefs['wall_comments']); ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="show_videos" class="col-sm-3 col-form-label"><?php echo __('show-videos'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('show_videos', $afn, $this->prefs['show_videos']); ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="show_video_favorites" class="col-sm-3 col-form-label"><?php echo __('show-video-favorites'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('show_video_favorites', $afn, $this->prefs['show_video_favorites']); ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="show_video_history" class="col-sm-3 col-form-label"><?php echo __('show-video-history'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('show_video_history', $afn, $this->prefs['show_video_history']); ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="show_video_playlists" class="col-sm-3 col-form-label"><?php echo __('show-playlists'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('show_playlists', $afn, $this->prefs['show_playlists']); ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="show_video_favorites" class="col-sm-3 col-form-label"><?php echo __('show-playlist-favorites'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('show_playlist_favorites', $afn, $this->prefs['show_playlist_favorites']); ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="show_friends" class="col-sm-3 col-form-label"><?php echo __('show-friends'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('show_friends', $afn, $this->prefs['show_friends']); ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="show_subscriptions" class="col-sm-3 col-form-label"><?php echo __('show-subscriptions'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('show_subscriptions', $afn, $this->prefs['show_subscriptions']); ?>
                        </div>
                      </div>                      
  </div>
  <div class="col-12 col-lg-6">
                      <div class="form-group row">
                        <label for="show_subscribers" class="col-sm-3 col-form-label"><?php echo __('show-subscribers'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('show_subscribers', $afn, $this->prefs['show_subscribers']); ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="show_activity" class="col-sm-3 col-form-label"><?php echo __('show-activity'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('show_activity', $afn, $this->prefs['show_activity']); ?>
                        </div>
                      </div>
                      <div class="form-group row"<?php if (!VModule::enabled('blog')): echo ' style="display: none;"'; endif; ?>>
                        <label for="show_blogs" class="col-sm-3 col-form-label"><?php echo __('show-blogs'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('show_blogs', $afn, $this->prefs['show_blogs']); ?>
                        </div>
                      </div>
                      <div class="form-group row"<?php if (!VModule::enabled('photo')): echo ' style="display: none;"'; endif; ?>>
                        <label for="show_albums" class="col-sm-3 col-form-label"><?php echo __('show-albums'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('show_albums', $afn, $this->prefs['show_albums']); ?>
                        </div>
                      </div>
                      <div class="form-group row"<?php if (!VModule::enabled('photo')): echo ' style="display: none;"'; endif; ?>>
                        <label for="show_photo_favorites" class="col-sm-3 col-form-label"><?php echo __('show-photo-favorites'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('show_photo_favorites', $afn, $this->prefs['show_photo_favorites']); ?>
                        </div>
                      </div>
                      <div class="form-group row"<?php if (!VModule::enabled('photo')): echo ' style="display: none;"'; endif; ?>>
                        <label for="show_photo_history" class="col-sm-3 col-form-label"><?php echo __('show-photo-history'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('show_photo_history', $afn, $this->prefs['show_photo_history']); ?>
                        </div>
                      </div>
                      <div class="form-group row"<?php if (!VModule::enabled('game')): echo ' style="display: none;"'; endif; ?>>
                        <label for="show_games" class="col-sm-3 col-form-label"><?php echo __('show-games'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('show_games', $afn, $this->prefs['show_games']); ?>
                        </div>
                      </div>
                      <div class="form-group row"<?php if (!VModule::enabled('game')): echo ' style="display: none;"'; endif; ?>>
                        <label for="show_game_favorites" class="col-sm-3 col-form-label"><?php echo __('show-game-favorites'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('show_game_favorites', $afn, $this->prefs['show_game_favorites']); ?>
                        </div>
                      </div>
                      <div class="form-group row"<?php if (!VModule::enabled('game')): echo ' style="display: none;"'; endif; ?>>
                        <label for="show_game_history" class="col-sm-3 col-form-label"><?php echo __('show-game-history'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('show_game_history', $afn, $this->prefs['show_game_history']); ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="allow_friends" class="col-sm-3 col-form-label"><?php echo __('allow-friends'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('allow_friends', array(1 => __('yes-auto-approve'), 2 => __('approve'), 0 => __('no')), $this->prefs['allow_friends']); ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="allow_message" class="col-sm-3 col-form-label"><?php echo __('allow-message'); ?></label>
                        <div class="col-sm-9">
                          <?php echo VForm4::radiosInline('allow_message', $afn, $this->prefs['allow_message']); ?>
                        </div>
                      </div>
  </div>
  <div class="col-12 text-center">
	<button name="submit_preferences" id="submit-preferences" class="btn btn-lg btn-primary"><?php echo __('save'); ?></button>
  </div>
</div>
</form>
<?php echo $this->fetch('_user_footer'); ?>
