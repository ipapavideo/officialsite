<?php
function ajax_plugin_playlist_create()
{
	$data 	= array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	
	VLanguage::load('frontend.playlist');
	
	if (isset($_POST['type']) and isset($_POST['video_id'])) {
		$filter			= VF::factory('filter');
		$video_id		= $filter->get('video_id', 'INT');
		$name			= $filter->get('name');
		$description	= $filter->get('description');
		$tags			= $filter->get('tags');
		$type			= $filter->get('type', 'INT');
		$user_id		= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
		
		$errors			= array();
		if (!$user_id) {
			$data['msg']	= __('playlist-login-confirm');
			return json_encode($data);
		}
		
		$pmodel			= VModel::load('playlist', 'playlist');
		
		if (!$video_id or !$video = $pmodel->video($video_id)) {
			$errors[]	= __('playlist-video-invalid');
		}
		
		if ($name == '') {
			$errors[]	= __('playlist-name-empty');
		} elseif (!VValid::length($name, VCfg::get('playlist.name_min_length'), VCfg::get('playlist.name_max_length'))) {
			$errors[]	= __('playlist-name-length', array(VCfg::get('playlist.name_min_length'), VCfg::get('playlist.name_max_length')));
		} 
		
		if ($description != '') {
			if (!VValid::length($name, VCfg::get('playlist.desc_min_length'), VCfg::get('playlist.desc_max_length'))) {
				$errors[]	= __('playlist-description-length', array(VCfg::get('playlist.desc_min_length'), VCfg::get('playlist.desc_max_length')));
			}
		}
		
		if ($tags != '') {
      		if (!VValid::length($tags, 1, VCfg::get('playlist.tags_max_length'))) {
                $errors[]	= __('playlist-tags-length', array(VCfg::get('playlist.tags_max_length')));
            } else {
                $exploded   = explode(',', $tags);
                $processed  = array();
                $invalid    = array();

                $max_length = VCfg::get('playlist.tag_max_length');
                $max_words  = VCfg::get('playlist.tag_max_words');

                foreach ($exploded as $tag) {
                    $tag    = utf8_trim($tag);
                    if (VValid::tag($tag)) {
                        if (utf8_strlen($tag) > $max_length) {
                            $errors[]	= __('playlist-tag-length', array($max_length));
                        } else {
                            if (utf8_is_ascii($tag)) {
                                if (str_word_count($tag) > $max_words) {
                                    $errors[]	= __('playlist-tag-words', array($max_words));
                                } else {
                                    $processed[$tag] = 1;
                                }
                            } else {
                                $processed[$tag] = 1;
                            }
                        }
                
                        $processed[$tag]    = 1;
                    } else {
                        $invalid[]  = $tag;
                    }
                }
         
                if ($invalid) {
                    $errors[]	= __('playlist-tags-invalid', array(implode(',', $invalid)));
                } 
            }		
		}
		
		if ($type !== 0 and $type !== 1) {
			$errors[]	= __('playlist-type-invalid');
		}
		
		if ($errors) {
			$data['msg']	= implode('<br>', $errors);
			return json_encode($data);
		}
		
		if (!$errors) {
			if ($playlist_id = $pmodel->add(array(
				'user_id'		=> $user_id,
				'thumb_id'		=> $video_id,
				'name'			=> $name,
				'description'	=> $description,
				'type'			=> $type,
				'duration'		=> $video['duration']))) {
				if (isset($processed)) {
					$tmodel	= VModel::load('tag', 'tools', true);
					foreach ($processed as $tag => $id) {
						$tmodel->addTag($tag, $playlist_id, 'playlist');
					}
				}
				
				$pmodel->addVideo($playlist_id, $video_id);
				
  				if (VCfg::get('user.points')) {
  					$pmodel	= VModel::load('points', 'user');
      				$pmodel->add($user_id, 'playlist-create');
      				$pmodel->add($user_id, 'playlist-video-add');
  				}				
				
				$data['msg']	= __('playlist-created');
				$data['status']	= 1;
			} else {
				$errors[]	= 'Failed to create database entry!';
			}
		}
	} else {
		if (!isset($_GET['id'])) {
			return;
		}
		
		$filter		= VF::factory('filter');
		$video_id	= $filter->get('id', 'INT', 'GET');
	
        $output     = array();
        $output[]   = '<div id="playlist-create-modal" class="modal fade">';
        $output[]   = '<div class="modal-dialog">';
        $output[]   = '<div class="modal-content">';
        $output[]   = '<div class="modal-header">';
        $output[]   = '<h4 class="modal-title">'.__('create-new-playlist').'</h4>';
        $output[]   = '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">'.__('close').'</span></button>';
        $output[]   = '</div>';
        $output[]   = '<div class="modal-body">';
        $output[]   = '<div id="response-playlist" class="alert alert-danger" style="display: none;"></div>';
        $output[]	= '<form>';
        $output[]	= '<div class="form-group">';
  		$output[]	= '<label for="name">'.__('name').'*</label>';
  		$output[]	= '<input name="name" type="name" class="form-control" id="name" placeholder="'.__('name').'">';
		$output[]	= '</div>';
        $output[]	= '<div class="form-group">';
  		$output[]	= '<label for="description">'.__('description').'</label>';
  		$output[]	= '<textarea name="description" class="form-control" id="description" rows="3"></textarea>';
		$output[]	= '</div>';
        $output[]	= '<div class="form-group">';
  		$output[]	= '<label for="tags">'.__('tags').'</label>';
  		$output[]	= '<textarea name="tags" class="form-control" id="tags" rows="2"></textarea>';
		$output[]	= '</div>';
		$output[]	= '<div class="custom-control custom-radio custom-control-inline">';
		$output[]	= '<input type="radio" id="type-0" name="type" class="custom-control-input" value="0" checked="checked">';
		$output[]	= '<label class="custom-control-label" for="type-0">'.__('public').'</label>';
		$output[]	= '</div>';
		$output[]	= '<div class="custom-control custom-radio custom-control-inline">';
		$output[]	= '<input type="radio" id="type-1" name="type" class="custom-control-input" value="10">';
		$output[]	= '<label class="custom-control-label" for="type-1">'.__('private').'</label>';
		$output[]	= '</div>';
        $output[]	= '</form>';
        $output[]   = '</div>';
        $output[]   = '<div class="modal-footer">';
        $output[]   = '<button id="playlist-create" data-id="'.$video_id.'" type="button" class="btn btn-primary">'.__('create-playlist').'</button>';
        $output[]   = '</div>';
        $output[]   = '</div></div></div>';

        return implode('', $output);
    }   

	return json_encode($data);			
}
