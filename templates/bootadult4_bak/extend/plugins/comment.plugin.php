<?php
function template_plugin_comment($content_id, $poster_id, $type = 'video', $csrf_token, $rows = 1)
{
	$output		= array();
	$output[]	= '<div class="col-12 comment-post-container border-bottom pb-3 mt-3">';
	$output[]	= '<input name="csrf_token_comment" type="hidden" value="'.$csrf_token.'">';
	$output[]	= '<div id="response-comment" class="alert alert-danger d-none" role="alert"></div>';
	$output[]	= '<div class="row">';
    $output[]	= '<div class="col col-auto">';
    $output[]	= '<div style="width: 50px;"><img src="'.USER_URL.'/'.avatar(true).'" alt="'.__('user-avatar').'" class="rounded" width="50"></div>';
    $output[]	= '</div>';
    $output[]	= '<div class="col pl-2">';
    
    if (VCfg::get('honeypot')) {
  		$output[]	= '<input name="comment_field" id="comment-field" type="text" class="form-control form-control-sm d-none" placeholder="Leave this input empty!">';
  	}
  	
    $output[]	= '<div class="row">';
    
    if (!$poster_id) {
  		$output[]	= '<div class="col-12 col-md-4 mb-1">';
        $output[]	= '<input name="nickname" id="comment-nickname-'.$content_id.'" type="text" class="form-control form-control-sm" placeholder="'.__('nickname').'">';
        $output[]	= '</div>';
    }
    
    $output[]	= '<div class="col-12">';
    $output[]	= '<textarea name="comment" id="comment-textarea-'.$content_id.'" class="form-control form-control-sm elastic" rows="'.$rows.'" placeholder="'.__('comment').'"></textarea>';
    $output[]	= '</div>';
    $output[]	= '</div>';
    $output[]	= '<div class="row mt-1">';
    $output[]	= '<div class="col-12 col-md-6">';
    
    $captcha 	= VCfg::get('comment_captcha'); 
    if ($captcha) {
  		if ($captcha === 2 and VCfg::get('recaptcha')) {    
      		$output[]	= '<div class="g-recaptcha" data-sitekey="'.VCfg::get('recaptcha_site_key').'" id="recaptcha" data-theme="dark"></div>';
      	} else {
        	$output[]	= '<div class="d-flex justify-content-center justify-content-md-start">';
            $output[]	= '<img src="'.REL_URL.'/captcha/?rand='.time().'" id="captcha" class="captcha-reload rounded" alt="" data-toggle="tooltip" data-placement="top" title="'.__('click-to-reload-image').'">';
            $output[]	= '<input name="captcha-verify" type="text" id="comment-captcha-'.$content_id.'" class="form-control form-control-sm ml-1" style="width: 40px;">';
        	$output[]	= '</div>';
    	}
    }
    
    $output[]	= '</div>';
    $output[]	= '<div class="col-12 col-md-6 mt-2 mt-md-0">';
    $output[]	= '<div class="d-flex justify-content-center justify-content-between">';
    $output[]	= '<small><span id="remaining">500</span> '.__('characters-left').'</small>';
    $output[]	= '<button id="post-comment-'.$content_id.'" class="btn btn-sm btn-primary" data-id="'.$content_id.'" data-type="'.$type.'">'.__('post-comment').'</button>';
    $output[]	= '</div></div></div></div></div></div>';

	return implode("\n", $output);
}