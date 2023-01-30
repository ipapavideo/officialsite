<?php
function ajax_plugin_profile_post_video()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger');
        
    if (!isset($_GET['user_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $filter		= VF::factory('filter');
    $user_id	= $filter->get('user_id', 'INT', 'GET');
    $poster_id	= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    $wmodel		= VModel::load('wall', 'profile');
    
    if (!$wall = $wmodel->wall($user_id)) {
  		$data['msg'] = 'Invalid request!';
  		return json_encode($data);
    }
    
    if (!$poster_id) {
  		$data['msg']	= 'Invalid request (login)!';
  		return json_encode($data);
    }
    
    $allow	= true;
    $pref	= $wall['wall'];
    if ($pref == '0') {
  		$allow	= false;
    } elseif ($pref == '2') {
  		if ($user_id != $poster_id) {
  			$fmodel	= VModel::load('friend', 'profile');
  			if ($fmodel->exists($user_id, $poster_id) != '1') {
  				$allow	= false;
  			}
  		}
    } elseif ($pref == '3') {
  		if ($user_id != $poster_id) {
  			$allow	= false;
  		}
    }
    
    if (!$allow) {
  		$data['msg']	= 'Invalid request (perm)!';
  		return json_encode($data);
    }
    
    $page	= (isset($_GET['page'])) ? $filter->get('page', 'INT', 'GET') : 1;
    $type	= (isset($_GET['type'])) ? $filter->get('type', 'STRING', 'GET') : 'videos';
    if ($type == 'videos') {
  		$vmodel	= VModel::load('video', 'profile');
    } elseif ($type == 'favorites') {
  		$vmodel	= VModel::load('favorite', 'profile');
    } elseif ($type == 'history') {
  		$vmodel	= VModel::load('history', 'profile');
    } else {
  		$data['msg']	= 'Invalid request (type)!';
  		return json_encode($data);
    }
    
	
	$tpl	= VF::factory('template');
    $act_1  = ($type == 'videos') ? ' active' : '';
    $act_2  = ($type == 'favorites') ? ' active' : '';
    $act_3  = ($type == 'history') ? ' active' : '';
    $size	= (VF::factory('device')->isMobile()) ? 'sm' : 'lg';
	
	$code	= array();
    $code[] = '<div id="modal-insert" class="modal fade">';
    $code[] = '<div class="modal-dialog modal-'.$size.'">';
    $code[] = '<div class="modal-content">';
    $code[] = '<div class="modal-header">';
    $code[] = '<ul class="nav nav-pills nav-tabs-video">';
    $code[] = '<li class="nav-item" role="presentation"><a href="#my-videos" class="nav-link'.$act_1.'" data-type="videos">'.__('my-videos').'</a></li>';
    $code[] = '<li class="nav-item" role="presentation"><a href="#my-favorites" class="nav-link'.$act_2.'" data-type="favorites">'.__('my-favorite-videos').'</a></li>';
    $code[] = '<li class="nav-item" role="presentation"><a href="#my-history" class="nav-link'.$act_3.'" data-type="history">'.__('my-view-history').'</a></li>';
    $code[] = '</ul>';
    $code[] = '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">'.__('close').'</span></button>';
    $code[] = '</div>';
    $code[] = '<div class="modal-body">';

    $total_videos	= $vmodel->total($poster_id);
    if ($total_videos > 0) {        
  		$pagination		= VPagination::get($page, $total_videos, 12);
  		if ($type == 'videos') {
  			$videos			= $vmodel->videos($poster_id, 'public', $pagination['limit']);
  		} else {
  			$videos			= $vmodel->videos($poster_id, $pagination['limit']);
  		}

  		$code[]			= p('videos', $videos);
  	} else {
  		$code[] = '<div class="none">'.__('no-videos').'</div>';
  	}
	
    $code[] = '</div>';
    $code[] = '<div class="modal-footer">';
    $code[] = '<div class="w-100 row m-1">';
    $code[] = '<div class="col-12 col-sm-8 col-md-8">';

    if ($total_videos > 0) {
        $code[] = '<nav><ul class="pagination pagination-sm pagination-video" style="padding: 0; margin: 0;">';
        $code[] = pagination_video($pagination, 2, $type);
        $code[] = '</ul></nav>';
    }

    $code[] = '</div>';
    $code[] = '<div class="col-12 col-sm-4 col-md-4 text-right">';
    $code[] = '<button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">'.__('done').'</button>';
    $code[] = '</div>';
    $code[] = '</div>';
    $code[] = '</div>';
    $code[] = '</div>';
    $code[] = '</div>';
    $code[] = '</div>';	
	
    $data['status']	= 1;
    $data['code']	= implode("\n", $code);
    
    return json_encode($data);
}

function pagination_video($options=array(), $index = 2, $type = 'videos')
{
    $page        = $options['page'];
    $total_pages = $options['total_pages'];
    $prev_page   = $options['prev_page'];
    $next_page   = $options['next_page'];
    $output      = array();

    if ($page != 1 && $total_pages > 0) {
          $output[]   = '<li class="page-item"><a href="#page-prev" data-type="'.$type.'" data-page="'.($page-1).'" class="page-link prevnext"><i class="fa fa-arrow-left"></i></a></li>';
    }

    if ($total_pages > (($index*2)+3) && $page >= ($index+3)) {
        $output[]   = '<li class="page-item"><a href="#page-1" data-type="'.$type.'" data-page="1" class="page-link">1</a></li>';
        $output[]   = '<li class="page-item"><a href="#page-2" data-type="'.$type.'" data-page="2" class="page-link">2</a></li>';
    }

    if ($page > $index+3) {
        $output[]   = '<li class="page-item"><span style="color: #373737;">&nbsp;...&nbsp;</span></li>';
    }

    for ($i=1; $i<=$total_pages; $i++) {
        if ($page == $i ) {
            $output[] = '<li class="page-item active"><a href="#page-'.$page.'" data-type="'.$type.'" data-page="'.$page.'" class="page-link">' .$page. '</a></li>';
        } elseif ( ($i >= ($page-$index) && $i < $page) OR ($i <= ($page+$index) && $i > $page) ) {
            $output[] = '<li class="page-item"><a href="#page-'.$i.'" data-type="'.$type.'" data-page="'.$i.'" class="page-link">'.$i.'</a></li>';
        }
    }
        
    if ($page < ($total_pages-6)) {
        $output[]   = '<li class="page-item"><span style="color: #373737;">&nbsp;...&nbsp;</span></li>';
    }

    if ($total_pages > (($index*2)+3) && $page <= $total_pages-($index+3)) {
        $output[]   = '<li class="page-item"><a href="#page-'.($total_pages-2).'" data-type="'.$type.'" data-page="'.($total_pages-2).'" class="page-link">'.($total_pages-2).'</a></li>';
        $output[]   = '<li class="page-item"><a href="#page-'.($total_pages-1).'" data-type="'.$type.'" data-page="'.($total_pages-1).'" class="page-link">'.($total_pages-1).'</a></li>';
    }

    if ($page != $total_pages) {
        $output[]   = '<li class="page-item"><a href="#page-next" data-type="'.$type.'" data-page="'.($page+1).'" class="prevnext page-link"><i class="fa fa-arrow-right"></i></a></li>';
    }

    return implode('', $output);
}
