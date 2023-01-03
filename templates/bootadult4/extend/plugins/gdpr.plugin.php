<?php
function template_plugin_gdpr()
{
	$cookie_name	= 'gdpr_consent';
	if (VCookie::exists($cookie_name)) {
		return;
	}
	
	$ip = VServer::ip();
	if ($ip == '127.0.0.1' or !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
		return;
	}
	
	$continent	= VGeoIP::continent($ip);
	if ($continent != 'EU') {
		return;
	}

	$output		= array();
	$output[]	= '<div id="gdpr-container" class="fixed-bottom bg-section border-top p-2">';
	$output[]	= '<div class="container-fluid">';
	$output[]	= '<div class="d-flex">';
	$output[]	= '<div class="p-2 flex-grow-1 align-items-center">'.__('gdpr-msg', array('<a href="'.REL_URL.'/static/cookies/"><strong>'.__('learn-more').'</strong></a>')).'</div>';
	$output[]	= '<div class="p-2 align-items-center">';
	$output[]	= '<button id="gdpr" class="btn btn-sm btn-warning">'.__('OK').'</button>';
	$output[]	= '</div>';
	$output[]	= '</div>';
	$output[]	= '</div>';
	$output[]	= '</div>';
	
	return implode('', $output);
}
