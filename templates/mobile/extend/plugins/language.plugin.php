<?php
function template_plugin_language($language = null)
{
    $languages  = VLanguage::getLanguages();
    $language   = ($language) ? $language : VLanguage::getLanguage();
    $default	= VCfg::get('language');
    
    $dropdown   = array();
    if (VCfg::get('language_method') == 'subdomain') {
        // posibile urls:
        // www.domain.com
        // domain.com
        // m.domain.com
        // de.domain.com
        // de.www.domain.com
        // de.m.domain.com

        $parsed = parse_url(CUR_URL);
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
        $query  = (isset($parsed['query'])) ? '?'.$parsed['query'] : '';
        $frag   = (isset($parsed['fragment'])) ? $parsed['fragment'] : '';

        $pre    = substr($host, 0, strpos($host, '.'));
        if (VLanguage::valid($pre)) {
            $host   = substr($host, strpos($host, '.')+1);
        }

        $output[]   = '<link rel="alternate" href="'.$scheme.$www.$host.$port.$path.$query.$frag.'" hreflang="x-default">';

        foreach ($languages as $code => $values) {
            if ($values['status'] == '0') {
                continue;
            }
            
            $active		= null;
            if ($code == $language) {
          		$current	= $values['flag'];
          		$active		= ' class="active"';
            }

            $url    	= ($code == $default) ? $scheme.$www.$host.$port.$path.$query.$frag : $scheme.$code.'.'.$host.$port.$path.$query.$frag;
            $dropdown[]	= '<li'.$active.'><a href="'.$url.'" rel="nofollow"><img src="'.MEDIA_REL.'/flags/'.$values['flag'].'.png" alt="'.$code.'" /> '.e($values['translation']).'</a></li>';
        }
    } else {
		$add		= str_replace(BASE_URL, '', CUR_URL);
		if ($language != $default) {
			$add	= str_replace('/'.$language, '', $add);
		}
		$add		= str_replace(' ', '+', $add);
		$add		= ($add) ? $add : '/';
	
  		foreach ($languages as $code => $values) {
  			if ($values['status'] == '0') {
  				continue;
  			}
    
  			$active	= null;
  			$url	= ($code == $default) ? REL_URL.$add : REL_URL.'/'.$code.$add;
      		if ($code == $language) {
          		$current	= $values['flag'];
          		$active		= ' class="active"';
          		$url		= REL_URL.$add;
      		}
        
      		$dropdown[]	= '<li'.$active.'><a href="'.$url.'" rel="nofollow"><img src="'.MEDIA_REL.'/flags/'.$values['flag'].'.png" alt="'.$code.'" /> '.e($values['translation']).'</a></li>';
      	}
	}
	
	$output[]	= '<div class="dropdown">';
	$output[]	= '<button id="language-dropdown" class="btn btn-menu btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">';
	$output[]	= '<img src="'.MEDIA_REL.'/flags/'.$current.'.png" alt="'.$language.'"> <span class="caret"></span>';
	$output[]	= '<span class="sr-only">Toggle Dropdown</span>';
	$output[]	= '</button>';
	$output[]	= '<ul id="language" class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="language-dropdown">';
	$output[]	= implode('', $dropdown);
	$output[]	= '</ul>';
	$output[]	= '</div>';

    return implode('', $output);
}
