<?php
function ajax_plugin_profile_post()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger', 'subscribers' => 0, 'score' => 0);
	
	if (!isset($_POST['user_id']) or !isset($_POST['content'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
	}
	
    VLanguage::load('frontend.profile');
    
    $poster_id	= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$poster_id) {
  		$data['msg'] = 'Invalid request (login)!';
  		return json_encode($data);
    }
    
    $filter		= VF::factory('filter');
    $poster		= e(VSession::get('username'));
    $user_id	= $filter->get('user_id', 'INT');    
    $wmodel		= VModel::load('wall', 'profile');    
    $wall 		= $wmodel->wall($user_id);
    $username	= e($wall['username']);
    
    if (!upref($wall['wall'], $user_id, $poster_id)) {
  		$data['msg'] = 'Invalid request (perm)!';
  		return json_encode($data);  		
    }
    
    $content	= utf8_trim($_POST['content']);
    if ($content == '' or $content == '<p><br></p>') {
  		$data['msg'] = __('profile-post-empty');
  		return json_encode($data);		
    }
    
    
    if (VCfg::get('video.embed_allow')) {
  		if (strpos($content, 'embed-video') !== false) {
  			preg_match_all('#<div class="embed-video"><iframe src="'.BASE_URL.'/embed/([0-9]+)/" width="100%" height="100%" frameborder="0" border="0" scrolling="no"></iframe></div><div class="embed-video-title">(.*?)</div>#', $content, $matches);
  			if (isset($matches['1']) and $matches['1']) {
  				$videos	= array();
  				$titles	= array();
  				foreach ($matches['1'] as $index => $match) {
  					$search		= '<iframe src="'.BASE_URL.'/embed/'.$match.'/" width="100%" height="100%" frameborder="0" border="0" scrolling="no"></iframe>';
  					$replace	= $match;
  					$content	= str_replace($search, $replace, $content);
  					$title		= e($matches['2'][$index]);
  					$search		= '<div class="embed-video-title">'.$title.'</div>';
  					$replace	= '<div class="embed-video-title">'.$index.'</div>';
  					$content	= str_replace($search, $replace, $content);

  					$videos[]	= $match;
  					$titles[]	= $title;
  				}
  			}
  		}
    }
    
    if (!function_exists('htmLawed')) {
  		VF::load('vendor.htmlawed.htmlawed');
    }
    
    $elements   = 'strong, em, u, i, b, p, code, div, ul, li, ol, span';
    $config     = array('safe' => 1, 'elements' => $elements, 'keep_bad' => 0, 'schemes'=>'*:http, https', 'abs_urls' => -1, 'css_expression' => 1);
    $spec       = 'div=-*, class';
    $content    = htmLawed(utf8_trim($content), $config, $spec);
    
    if (isset($videos)) {
  		preg_match_all('#<div class="embed-video">([0-9]+)</div><div class="embed-video-title">([0-9]+)</div>#', $content, $matches);
  		if (isset($matches['1']) and $matches['1']) {
  			foreach ($matches['1'] as $index => $match) {
  				$search		= '<div class="embed-video">'.$match.'</div><div class="embed-video-title">'.$matches['2'][$index].'</div>';
  				$replace	= '<div class="embed-video"><iframe src="'.BASE_URL.'/embed/'.$match.'/" width="100%" height="100%" frameborder="0" border="0" scrolling="no"></iframe></div><div class="embed-video-title">'.$titles[$index].'</div>';
  				$content	= str_replace($search, $replace, $content);
  			}
  		}
    }

    if (VCfg::get('profile.spam_filter')) {
        $smodel 		= VModel::load('spam', 'core');
        $umodel         = VModel::load('user', 'user');
        $spam_posts  	= $smodel->getStats($poster_id, 'walls');
        $valid_posts 	= $umodel->valid($poster_id, 'wall');
        $same_body      = $wmodel->sameBody($poster_id, $content);

        $score      = VF::factory('spam')->getScore($content, $same_body, $spam_posts, $valid_posts);
        if ($score < 0) {
            VLog::warning('Post from user_id: '.$poster_id.' on '.$user_id.' wall with score '.$score.' has a spam score lower than 0!');
            $data['score']	= $score;
            $data['msg']    = __('dont-spam');
            return json_encode($data);
        }    
    }
    
    if (!$wall_id = $wmodel->add($user_id, $poster_id, $content)) {
  		$data['msg']	= 'Invalid request (add)!';
  		return json_encode($data);
    }
    
    
    if (VCfg::get('user.activity')) {
  		$amodel	= VModel::load('activity', 'core');
  		$amodel->add($poster_id, 'post', array(
  			'id'	=> $wall_id,
  			'data'	=> ($user_id === $poster_id) ? array() : array('username' => $username)
  		), 1, $user_id);
    }
    
    if (VCfg::get('user.points')) {
        VModel::load('points', 'user')->add($user_id, 'wall');
    }
        
    $link		= BASE_URL.'/users/'.$poster.'/';
    $img		= USER_URL.'/'.avatar(true);
    $alt		= __('username-avatar', $poster);
    $url		= '<a href="'.BASE_URL.'/users/'.$username.'/" class="btn-color"><strong>'.$username.'</strong></a>';
    $activity	= ($user_id === $poster_id) ? __('activity-profile-post-self') : __('activity-profile-post', $url);
    
    $code	= array();
    $code[]	= '<div class="stream">';
	$code[]	= '<div class="stream-header">';
	$code[]	= '<div class="stream-avatar">';
    $code[]	= '<a href="'.$link.'" rel="nofollow">';
    $code[]	= '<img src="'.$img.'" alt="'.$alt.'" width="50" class="img-rounded">';
    $code[]	= '</a>';
    $code[]	= '</div>';
    $code[]	= '<div class="stream-info">';
    $code[]	= '<a href="'.$link.'" rel="nofollow">'.$poster.'</a>'.$activity;
    $code[]	= '<span class="stream-time"><i class="fa fa-clock-o"></i> '.__('just-now').'</span>';
    $code[]	= '</div>';
    $code[]	= '<div class="clearfix"></div>';
	$code[]	= '</div>';
	$code[]	= '<div class="stream-content stream-content-post">';
	$code[]	= $content;
	$code[]	= '</div>';
	$code[]	= '</div>';
	
	$data['status']	= 1;
	$data['code']	= implode("\n", $code);

    
	return json_encode($data);
}
