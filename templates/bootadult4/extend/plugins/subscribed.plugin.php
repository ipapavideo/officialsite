<?php
function template_plugin_subscribed($user_id, $subscriber_id)
{
	return VModel::load('subscribe', 'profile')->exists($user_id, $subscriber_id);
}
