<?php
function template_plugin_adv_preroll()
{
	if (!VCfg::get('ads')) {
		return;
	}
		
	$gmodel = VModel::load('group', 'adv');
    $group  = $gmodel->get('video-preroll');
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
	
	$amodel->update($adv['adv_id']);
	
	return $adv;
}
