<?php
function template_plugin_adv_footer()
{
	if (!VCfg::get('ads')) {
		return;
	}
	
	$gmodel	= VModel::load('group', 'adv');
	if (!$group = $gmodel->get('footer')) {
		return;
	}
	
	$amodel = VModel::load('adv', 'adv');
	$advs = $amodel->advs($group['group_id'], $group['rotate']);
	if (!$advs) {
		VHelper::load('module.adv.display');
		
		$groups	= array('footer-1', 'footer-2', 'footer-3', 'footer-4');
		$output	= array();
		foreach ($groups as $slug) {
			$group	= $gmodel->get($slug);
			if ($group) {
				$advs = $amodel->advs($group['group_id'], $group['rotate']);
				if ($advs) {
  					if ($group['rotate']) {
      					$index  = array_rand($advs);
      					$adv    = $advs[$index];
  					} else {
      					$adv    = current($advs);
  					}

					if (time() <= $adv['expire']) {
						$output[]	= VHelper_adv_display::render($adv, 'adv-footer');
					}
				}
			}
		}
		
		if ($output) {
			return '<div class="d-flex flex-column flex-md-row justify-content-center align-items-center">'.implode('', $output).'</div>';
		}
	}
	
	if (!$advs or !is_array($advs)) {
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
	return '<div class="d-flex justify-content-center">'.VHelper_adv_display::render($adv, 'adv').'</div>';
}
