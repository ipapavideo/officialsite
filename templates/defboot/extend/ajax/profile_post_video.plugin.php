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
    
	
    $act_1  = ($type == 'videos') ? ' class="active"' : '';
    $act_2  = ($type == 'favorites') ? ' class="active"' : '';
    $act_3  = ($type == 'history') ? ' class="active"' : '';
    $size	= (VF::factory('device')->isMobile()) ? 'sm' : 'lg';
	
	$code	= array();
    $code[] = '<div id="modal-insert" class="modal fade">';
    $code[] = '<div class="modal-dialog modal-'.$size.'">';
    $code[] = '<div class="modal-content">';
    $code[] = '<div class="modal-header">';
    $code[] = '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">'.__('close').'</span></button>';
    $code[] = '<ul class="nav nav-tabs nav-tabs-video">';
    $code[] = '<li role="presentation"'.$act_1.'><a href="#my-videos" data-type="videos">'.__('my-videos').'</a></li>';
    $code[] = '<li role="presentation"'.$act_2.'><a href="#my-favorites" data-type="favorites">'.__('my-favorite-videos').'</a></li>';
    $code[] = '<li role="presentation"'.$act_3.'><a href="#my-history" data-type="history">'.__('my-view-history').'</a></li>';
    $code[] = '</ul>';
    $code[] = '</div>';
    $code[] = '<div class="modal-body">';

    $total_videos	= $vmodel->total($user_id);
    if ($total_videos > 0) {        
  		$pagination		= VPagination::get($page, $total_videos, 12);
  		if ($type == 'videos') {
  			$videos			= $vmodel->videos($user_id, 'public', $pagination['limit']);
  		} else {
  			$videos			= $vmodel->videos($user_id, $pagination['limit']);
  		}

  		$vpreview   	= VCfg::get('video.thumb_video') ? ' video-preview' : '';
  		$tpreview   	= (!$vpreview && VCfg::get('video.thumb_preview')) ? ' thumb-preview' : '';

  		$code[]     	= '<ul class="videos videos-modal">';
  		
  		foreach ($videos as $video) {
      		$percent    = ($video['percent']) ? round($video['percent']) : 100;
      		$class      = ($percent >= 50) ? 'up' : 'down';
      		$tdata      = ' data-id="'.$video['video_id'].'" data-thumb="'.$video['thumb'].'" data-thumbs="'.$video['thumbs'].'"';
      		$hd         = ($video['hd']) ? '<strong>'.__('hd').'</strong> ' : '';
      		$views      = ($video['total_views'] == '1') ? __('view') : __('views');

      		$code[]     = '<li id="video-'.$video['video_id'].'" class="video">';
      		$code[]     = '<a href="'.video_view_url($video['video_id'], $video['slug']).'" title="'.e($video['title']).'" data-id="'.$video['video_id'].'" class="image">';
      		$code[]     = '<div class="video-thumb'.$vpreview.$tpreview.'">';
      		$code[]     = '<img src="'.THUMB_URL.'/'.path($video['video_id']).'/'.$video['thumb'].'.jpg" alt="'.e($video['title']).'" id="preview-'.$video['video_id'].'-user"'.$tdata.'>';
      		$code[]     = '<span class="duration">'.$hd.VDate::duration($video['duration']).'</span>';
      		$code[]     = '</div></a>';
      		$code[]     = '<span class="title"><a href="'.video_view_url($video['video_id'], $video['slug']).'" title="'.e($video['title']).'" data-id="'.$video['video_id'].'">'.e($video['title']).'</a></span>';
      		$code[]     = '<span class="views">'.$video['total_views'].' '.$views.'</span>';
      		$code[]     = '<span class="rating '.$class.'><i class="fa fa-thumbs-'.$class.'"></i> '.$percent.'%</span>';
      		$code[]     = '</li>';
  		}
  		
  		$code[]     = '</ul>';
  		$code[]     = '<div class="clearfix"></div>';  		
  	} else {
  		$code[] = '<div class="none">'.__('no-videos').'</div>';
  	}
	
    $code[] = '</div>';
    $code[] = '<div class="modal-footer">';
    $code[] = '<div class="row">';
    $code[] = '<div class="col-xs-8 col-sm-8 col-md-8">';

    if ($total_videos > 0) {
        $code[] = '<nav class="text-left"><ul class="pagination pagination-xs pagination-video" style="padding: 0; margin: 0;">';
        $code[] = pagination_video($pagination, 2, $type);
        $code[] = '</ul></nav>';
    }

    $code[] = '</div>';
    $code[] = '<div class="col-xs-4 col-sm-4 col-md-4">';
    $code[] = '<button type="button" class="btn btn-submit" data-dismiss="modal">'.__('done').'</button>';
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
          $output[]   = '<li><a href="#page-prev" data-type="'.$type.'" data-page="'.($page-1).'" class="prevnext"><i class="fa fa-arrow-left"></i></a></li>';
    }

    if ($total_pages > (($index*2)+3) && $page >= ($index+3)) {
        $output[]   = '<li><a href="#page-1" data-type="'.$type.'" data-page="1">1</a></li>';
        $output[]   = '<li><a href="#page-2" data-type="'.$type.'" data-page="2">2</a></li>';
    }

    if ($page > $index+3) {
        $output[]   = '<li><span style="color: #373737;">&nbsp;...&nbsp;</span></li>';
    }

    for ($i=1; $i<=$total_pages; $i++) {
        if ($page == $i ) {
            $output[] = '<li class="active disabled"><a href="#page-'.$page.'" data-type="'.$type.'" data-page="'.$page.'">' .$page. '</a></li>';
        } elseif ( ($i >= ($page-$index) && $i < $page) OR ($i <= ($page+$index) && $i > $page) ) {
            $output[] = '<li><a href="#page-'.$i.'" data-type="'.$type.'" data-page="'.$i.'">'.$i.'</a></li>';
        }
    }
        
    if ($page < ($total_pages-6)) {
        $output[]   = '<li><span style="color: #373737;">&nbsp;...&nbsp;</span></li>';
    }

    if ($total_pages > (($index*2)+3) && $page <= $total_pages-($index+3)) {
        $output[]   = '<li><a href="#page-'.($total_pages-2).'" data-type="'.$type.'" data-page="'.($total_pages-2).'">'.($total_pages-2).'</a></li>';
        $output[]   = '<li><a href="#page-'.($total_pages-1).'" data-type="'.$type.'" data-page="'.($total_pages-1).'">'.($total_pages-1).'</a></li>';
    }

    if ($page != $total_pages) {
        $output[]   = '<li><a href="#page-next" data-type="'.$type.'" data-page="'.($page+1).'" class="prevnext"><i class="fa fa-arrow-right"></i></a></li>';
    }

    return implode('', $output);
}
