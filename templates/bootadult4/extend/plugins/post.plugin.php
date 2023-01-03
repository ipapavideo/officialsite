<?php
function template_plugin_post($wall_id, $poster_id, $wall_rating = true, $wall_comments = true, $allow_comment = true, $wall = null)
{
	if (!$wall) {
		if (!$wall = VModel::load('wall', 'profile')->get($wall_id)) {
			return;
		}
	}
	
	$output		= array();
	$output[]	= '<div id="wall-'.$wall_id.'" class="p-2">';
	$output[]	= '<div class="w-100 wall-content">'.$wall['content'].'</div>';
	$output[]	= '<div class="d-flex mt-2 w-100 align-items-center border-top">';
	
	if ($wall_rating) {		
		$class 		= ($wall['percent'] >= 50 or $wall['percent'] == '0') ? 'text-success' : 'text-danger';
    	$disabled 	= (!upref($wall['wall_rating'], $wall['user_id'], $poster_id)) ? ' disabled="disabled"' : '';

		$output[]	= '<div id="wall-rating-'.$wall_id.'" class="wall-rating">';
    	$output[]	= '<span class="wall-percent '.$class.'">'.round($wall['percent']).'%</span>';
    	$output[]	= '<button class="btn btn-clean btn-rating rate-wall" data-id="'.$wall['wall_id'].'" data-rating="1" data-toggle="tooltip" data-placement="top" title="'.__('i-like-this').'"'.$disabled.'><i class="fa fa-thumbs-up"></i></button>';
    	$output[]	= '<button class="btn btn-clean btn-rating rate-wall" data-id="'.$wall['wall_id'].'" data-rating="0" data-toggle="tooltip" data-placement="top" title="'.__('i-dislike-this').'"'.$disabled.'><i class="fa fa-thumbs-down"></i></button>';
		$output[]	= '</div>';
	}
	
	if ($wall_comments and $comment = upref($wall['wall_comments'], $wall['user_id'], $poster_id)) {
		$output[]	= '<div class="wall-comment ml-3"><button class="btn btn-sm comment-wall" data-id="'.$wall_id.'"><i class="fa fa-comment"></i> '.__('comment').'</button></div>';
	}
	
	$output[]	= '<div class="wall-report"><button class="btn btn-sm btn-post report-wall" data-id="'.$wall_id.'"><i class="fa fa-flag"></i></button></div>';
	
	$output[]	= '</div>';
	
	if ($wall_comments) {
		$output[]	= '<div id="wall-comments-'.$wall_id.'" class="wall-comments">';
		
		if ($comment) {
			if (($allow_comment == '1' and $poster_id) or $allow_comment == '2') {
				$output[]	= '<div id="post-comment-'.$wall_id.'" style="display:none;"><div class="comment-post-container"></div></div>';
			} else {
				$allow_comment	= false;
			}
		} else {
			$allow_comment	= false;
		}
		
		if ($wall['total_comments'] > 0) {
			$comments	= p('wall_comments', $wall_id);
			$output[]	= p('comments', $comments, $wall['total_comments'], $wall_id, 'wall', 0, $allow_comment);
		} else {
			$output[]	= '<div id="comments-container-'.$wall_id.'" class="comments-container" style="display: none;"></div>';
		}
		
		$output[]	= '</div>';
	}
	
	$output[]	= '</div>';
	
	return implode("\n", $output);
}
