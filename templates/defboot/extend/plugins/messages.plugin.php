<?php
function template_plugin_messages($user_id)
{
	return VModel::load('message', 'message')->total('received', $user_id);	
}
