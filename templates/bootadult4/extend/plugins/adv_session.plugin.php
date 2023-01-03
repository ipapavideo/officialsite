<?php
function template_plugin_adv_session($slug)
{
	if (!VCfg::get('ads')) {
		return;
	}
	
    if (VSession::exists($slug)) {
  		$interval   = (int) VCfg::get('adv.'.$slug);
  		if ($interval === 0) {
  			return;
  		}
  		
  		$executed		= (int) VSession::get($slug);
  		if (time() < ($executed+$interval)) {
  			return;
  		}
    }

	$gmodel	= VModel::load('group', 'adv');
	$group	= $gmodel->get($slug);
	if (!$group) {
		return;
	}
	
	$amodel = VModel::load('adv', 'adv');
	$advs 	= $amodel->advs($group['group_id'], $group['rotate']);
	if (!$advs) {
		return;
	}

    if ($group['rotate']) {
        $index  = array_rand($advs);
        $adv    = $advs[$index];
    } else {
        $adv    = current($advs);
    }
	
	if (time() > $adv['expire']) {
		return;
	}
	
	VSession::set($slug, time());

	VHelper::load('module.adv.display');
	return VHelper_adv_display::render($adv, null);
}
