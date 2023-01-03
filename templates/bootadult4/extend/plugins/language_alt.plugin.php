<?php
function template_plugin_language_alt($language = null)
{
	if (!VCfg::get('multi_language')) {
		return;
	}

    $languages  = VLanguage::getLanguages();
    $language   = ($language) ? $language : VLanguage::getLanguage();
    $default	= VCfg::get('language');
    
    $base_url	= (defined('_MOBILE')) ? MOBILE_URL : BASE_URL;
	$output		= array();
    if (VCfg::get('language_method') == 'subdomain') {
  		// posibile urls:
  		// www.domain.com
  		// domain.com
  		// m.domain.com
  		// de.domain.com
  		// de.www.domain.com
  		// de.m.domain.com
    
  		$parsed	= parse_url(CUR_URL);
  		if (strpos($parsed['host'], 'www.') !== false) {
  			$host	= str_replace('www.', '', $parsed['host']);
  			$www	= 'www.';
  		} else {
  			$host	= $parsed['host'];
  			$www	= '';
  		}

  		$scheme	= $parsed['scheme'].'://';
  		$port	= (isset($parsed['port'])) ? ':'.$parsed['port'] : '';
  		$path	= (isset($parsed['path'])) ? $parsed['path'] : '/';
  		$query	= (isset($parsed['query'])) ? '?'.$parsed['query'] : '';
  		$frag	= (isset($parsed['fragment'])) ? $parsed['fragment'] : '';
  		
  		$pre	= substr($host, 0, strpos($host, '.'));
  		if (VLanguage::valid($pre)) {
  			$host	= substr($host, strpos($host, '.')+1);
  		}
  		
  		$output[]	= '<link rel="alternate" href="'.$scheme.$www.$host.$port.$path.$query.$frag.'" hreflang="x-default">';
  		
  		foreach ($languages as $code => $values) {
  			if ($values['status'] == '0') {
  				continue;
  			}
  			
  			$url	= ($code == $default) ? $scheme.$www.$host.$port.$path.$query.$frag : $scheme.$code.'.'.$host.$port.$path.$query.$frag;
      		$output[]	= '<link rel="alternate" href="'.$url.'" hreflang="'.$code.'">';
  		}  		
    } else {
		$add		= str_replace($base_url, '', CUR_URL);
		if ($language != $default) {
			$add	= str_replace('/'.$language, '', $add);
		}
		$add		= str_replace(' ', '+', $add);
		$add		= ($add) ? $add : '/';
	
		$output[]	= '<link rel="alternate" href="'.$base_url.$add.'" hreflang="x-default">';
	
  		foreach ($languages as $code => $values) {
  			if ($values['status'] == '0') {
  				continue;
  			}
    
  			$url		= ($code == $default) ? $base_url.$add : $base_url.'/'.$code.$add;        
      	  $output[]	= '<link rel="alternate" href="'.$url.'" hreflang="'.$code.'">';
		}
	}
	
    return implode("\n", $output)."\n";
}
