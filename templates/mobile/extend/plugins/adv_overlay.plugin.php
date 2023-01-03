<?php
function template_plugin_adv_overlay($slug = 'video-player-overlay')
{
	if (!VCfg::get('ads')) {
		return;
	}
	
    $gmodel = VModel::load('group', 'adv');
    $group  = $gmodel->get($slug);
    if (!$group) {
        return;
    }

    $amodel = VModel::load('adv', 'adv');
    $advs   = $amodel->advs($group['group_id'], $group['rotate']);
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
	
	VHelper::load('module.adv.display');
	return '<div id="player-advertising">'.VHelper_adv_display::render($adv).'<a href="#close" id="player-close">'.__('close-and-play').'</a></div>';
}
