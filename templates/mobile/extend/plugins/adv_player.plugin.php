<?php
function template_plugin_adv_player($adv_id = 0, $adv_mobile_id = 0)
{
	if (!VCfg::get('ads')) {
		return;
	}
	
    $mobile       = VCfg::get('adv.mobile');
    if ($mobile) {
  		if (VCfg::get('mobile.redirect')) {
            $mobile   = (MOBILE) ? true : false;
        } else {
            $mobile   = (VF::factory('device')->isMobile()) ? true : false;
        }
    }
		
	$amodel = VModel::load('adv', 'adv');
	$adv_id	= ($mobile) ? $adv_mobile_id : $adv_id;
	
	if ($adv_id) {
		$adv = $amodel->get($adv_id);
        if ($adv and is_array($adv) and isset($adv['0'])) {
            $adv = $adv['0'];
        }
	}
	
	if (!isset($adv) or !$adv) {
		$gmodel	= VModel::load('group', 'adv');
		$group = $gmodel->get('video-player-default');
  		if (!$group) {
      		return;
  		}
		
  		$advs = $amodel->advs($group['group_id'], $group['rotate']);
		if (!$advs) {  		
      		return;
  		}

  		if ($group['rotate']) {
      		$index  = array_rand($advs);
      		$adv    = $advs[$index];
  		} else {
      		$adv    = current($advs);
  		}
	}
	
	if (time() > $adv['expire']) {
		return;
	}
	
	VHelper::load('module.adv.display');
	return VHelper_adv_display::render($adv, 'adv');
}
