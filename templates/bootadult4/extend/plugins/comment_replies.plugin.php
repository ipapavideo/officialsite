<?php
function template_plugin_comment_replies($parent_id, $content_id, $type = 'video', $allow_comment, $submenu = '')
{
	$types	= VData::get('comment_types', 'core');
	if (!isset($types[$type])) {
		throw new VException('Invalid type!');
	}
	
	$module		= ($type == 'wall') ? 'profile' : $type;
	$cmodel		= VModel::load('comment', $module);
	$where		= 'c.'.$type.'_id= ? AND c.parent_id = ? AND c.status = 1';
	if (!$comments = $cmodel->comments($where, 'ii', array($content_id, $parent_id), 100, 'c.comment_id', 'ASC')) {
		return;
	}
	
	return p('comments', $comments, count($comments), $content_id, $type, $parent_id, $allow_comment, $submenu);
}
