<?php
function template_plugin_requests()
{
	$user_id	= (int) VSession::get('user_id');
	if ($prefs = VModel::load('user', 'user')->preferences($user_id)) {
  		if ($prefs['allow_friends'] == '2') {
      		return VModel::load('friend', 'profile')->total($user_id, 0, false);
        }
    }

	return 0;
}
