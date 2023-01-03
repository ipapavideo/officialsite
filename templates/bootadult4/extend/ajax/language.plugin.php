<?php
function ajax_plugin_language()
{
    $languages  = VLanguage::getLanguages();
    $language   = VLanguage::getLanguage();
    $default    = VCfg::get('language');

    $filter     = VF::factory('filter');
    $cur_url   	= $filter->get('url');
    
    if ($cur_url == '') {
  		return;
    }
    
    $parsed 	= parse_url($cur_url);
    if (strpos($parsed['host'], 'www.') !== false) {
        $host   = str_replace('www.', '', $parsed['host']);
        $www    = 'www.';
    } else {
        $host   = $parsed['host'];
        $www    = '';
    }

    $scheme = $parsed['scheme'].'://';
    $port   = (isset($parsed['port'])) ? ':'.$parsed['port'] : '';
    $path   = (isset($parsed['path'])) ? $parsed['path'] : '/';
    $query  = (isset($parsed['query'])) ? $parsed['query'] : '';
    $frag   = (isset($parsed['fragment'])) ? $parsed['fragment'] : '';

    $pre    = substr($host, 0, strpos($host, '.'));
    if (VLanguage::valid($pre)) {
        $host   = substr($host, strpos($host, '.')+1);
    }

	if (BASE_URL != $scheme.$www.$host.$port) {
		return;
	}

    $list   	= array();
    
    if (VCfg::get('language_method') == 'subdomain') {
        foreach ($languages as $code => $values) {
            if ($values['status'] == '0') {
                continue;
            }

            $active     = null;
            if ($code == $language) {
                $current    = $values['flag'];
                $active     = ' active';
            }
            
            $url        = ($code == $default) ? $scheme.$www.$host.$port.$path.$query.$frag : $scheme.$code.'.'.$host.$port.$path.$query.$frag;
            $list[] = '<a href="'.$url.'" rel="nofollow" class="list-group-item list-group-item-action'.$active.'"><img src="'.MEDIA_REL.'/flags/'.$values['flag'].'.png" alt="'.$code.'" /> '.e($values['translation']).'</a>';
        }
    } else {
  		$add        = str_replace(BASE_URL, '', $cur_url);
        if ($language != $default) {
            $add    = str_replace('/'.$language, '', $add);
        }
        $add        = str_replace(' ', '+', $add);
        $add        = ($add) ? $add : '/';

        foreach ($languages as $code => $values) {
            if ($values['status'] == '0') {
                continue;
            }
            
            $active = null;
            $url    = ($code == $default) ? REL_URL.$add : REL_URL.'/'.$code.$add;
            if ($code == $language) {
                $current    = $values['flag'];
                $active     = ' active';
                $url        = REL_URL.$add;
            }
            
            $list[] = '<a href="'.$url.'" rel="nofollow" class="list-group-item list-group-item-action'.$active.'"><img src="'.MEDIA_REL.'/flags/'.$values['flag'].'.png" alt="'.$code.'" /> '.e($values['translation']).'</a>';
        }
    }

    $output     = array();
    $output[]   = '<div id="language-modal" class="modal fade" tabindex="-1" role="dialog">';
    $output[]   = '<div class="modal-dialog modal-sm" role="document">';
    $output[]   = '<div class="modal-content">';
    $output[]   = '<div class="modal-header">';
    $output[]   = '<h4 class="modal-title">'.__('languages').'</h4>';
    $output[]   = '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>';
    $output[]   = '</div>';
    $output[]   = '<div class="modal-body">';
    
  	$output[]	= '<ul class="list-group list-group-sm list-group-flush">';
  	$output[]	= implode('', $list);
  	$output[]	= '</ul>';
    
    $output[]   = '</div></div></div>';

    return implode('', $output);
}
