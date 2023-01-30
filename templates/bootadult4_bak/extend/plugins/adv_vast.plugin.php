<?php
function template_plugin_adv_vast($multiple = false)
{
	if (!VCfg::get('ads')) {
		return;
	}
		
	$gmodel = VModel::load('group', 'adv');
    $group  = $gmodel->get('video-vast');
    if (!$group) {
        return;
    }

    $amodel = VModel::load('adv', 'adv');
    $advs   = $amodel->advs($group['group_id'], $group['rotate'], $multiple);
    if (!$advs) {
        return;
    }
    
    if ($multiple) {
  		$ids	= array();
  		foreach ($advs as $index => $adv) {
  			if (time() > $adv['expire']) {
  				unset($advs[$index]);
  			} else {
  				$ids[]	= $adv['adv_id'];
  			}
  		}
  		
  		if (!$advs) {
  			return;
  		}    
    } else {			
  		if ($group['rotate']) {
      		$index  = array_rand($advs);
      		$adv    = $advs[$index];
  		} else {
      		$adv    = current($advs);
  		}

		if (time() > $adv['expire']) {
			return;
		}
		
		$ids	= array($adv['adv_id']);
	}
	
	$amodel->updates($ids);
	
	return ($multiple) ? $advs : $adv;
}
