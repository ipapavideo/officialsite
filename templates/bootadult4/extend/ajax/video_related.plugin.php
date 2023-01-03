<?php
function ajax_plugin_video_related()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger', 'page' => 0, 'end' => 0);
	
	if (!isset($_POST['video_id']) or !isset($_POST['page'])) {
		$data['msg']	= 'Invalid request!';
		return json_encode($data);
	}
	
	
    VLanguage::load('frontend.video');

    $filter		= VF::factory('filter');
    $video_id	= $filter->get('video_id', 'INT');
    $page		= $filter->get('page', 'INT');

	$vmodel		= VModel::load('video', 'video');
	if (!$video = $vmodel->related($video_id)) {
		$data['msg']	= 'Invalid video!';
		return json_encode($data);
	}
	
	$perpage	= VCfg::get('video.view_per_page');
	$rmodel		= VModel::load('related', 'video');
	$related	= $rmodel->related($video_id, $video['orientation'], $video['title'], $video['tags'], $video['categories'], $page, $perpage);
	$total		= $related['total'];
	$videos		= $related['videos'];
	
	$tpl		= VF::factory('template');
    $code       = array();
    $code[]     = p('adv', 'video-related-native', false, 'adv-native');
    $code[]     = p('videos', $videos, '-related', false, false, true);
	
	$data['status']	= 1;
	$data['code']	= implode('', $code);
	$data['page']	= $page+1;

	if ($total <= $perpage*$page) {
		$data['end']	= 1;
	}
	
	return json_encode($data);
}
