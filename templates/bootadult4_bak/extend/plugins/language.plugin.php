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

//        $output[]   = '<link rel="alternate" href="'.$scheme.$www.$host.$port.$path.$query.$frag.'" hreflang="x-default">';

        foreach ($languages as $code => $values) {
            if ($values['status'] == '0') {
                continue;
            }
            
            $active		= null;
            if ($code == $language) {
          		$current	= $values['flag'];
          		$active		= ' active';
            }

            $url    	= ($code == $default) ? $scheme.$www.$host.$port.$path.$query.$frag : $scheme.$code.'.'.$host.$port.$path.$query.$frag;
      		$dropdown[]	= '<a href="'.$url.'" rel="nofollow" class="dropdown-item'.$active.'"><img src="'.MEDIA_REL.'/flags/'.$values['flag'].'.png" alt="'.$code.'" /> '.e($values['translation']).'</a>';
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
          		$active		= ' active';
          		$url		= REL_URL.$add;
      		}
      		
      		$dropdown[]	= '<a href="'.$url.'" rel="nofollow" class="dropdown-item'.$active.'"><img src="'.MEDIA_REL.'/flags/'.$values['flag'].'.png" alt="'.$code.'" /> '.e($values['translation']).'</a>';
      	}
	}

	$output[]	= '<div class="btn-group">';
    $output[]	= '<button class="btn btn-light rounded-pill dropdown-toggle btn-mobile" id="language" data-toggle="dropdown" type="button" aria-haspopup="true" aria-expanded="false">';
    $output[]	= '<img src="'.MEDIA_REL.'/flags/'.$current.'.png" alt="'.$language.'">';
    $output[]	= '</button>';
    $output[]	= '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="language">';
    $output[]	= implode("\n", $dropdown);
	$output[]	= '</div>';	
	$output[]	= '</div>';

    return implode("\n", $output);
}
