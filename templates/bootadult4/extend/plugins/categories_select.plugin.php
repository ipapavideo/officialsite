<?php
// this needs to have a type argument to be able to load categories
function template_plugin_categories_select($categories, $selected = array(), $type = 'video')
{
	$types		= array('video' => 1, 'photo' => 1, 'game' => 1, 'article' => 1);
	if (!isset($types[$type])) {
		throw new VException('Invalid categories type!');
	}
	
	if (!$categories) {
		$categories	= VModel::load('category', $type, true)->tree();
	}

	$output		= array();
	if (!is_array($selected)) {
		$selected	= explode(',', $selected);
	}
	
	$selected	= ($selected) ? array_flip($selected) : array();	
	$added		= array();
	foreach ($categories as $category) {
		$cat_id	= (int) $category['cat_id'];
		if (!isset($added[$cat_id])) {
			if (is_array($selected)) {		
				$select	= (isset($selected[$cat_id])) ? ' selected="selected"' : '';
			} else {
				$select	= ($selected == $cat_id) ? ' selected="selected"' : '';
			}
			
			$output[]		= '<option value="'.$cat_id.'"'.$select.'>'.e($category['name']).'</option>';
			$added[$cat_id]	= 1;
		}
		
		if (isset($category['subcat_id']) && $category['subcat_id']) {
			$subcat_id	= (int) $category['subcat_id'];
			if (!isset($added[$subcat_id])) {
				if (is_array($selected)) {
					$select	= (isset($selected[$subcat_id])) ? ' selected="selected"' : '';
				} else {
					$select	= ($selected == $subcat_id) ? ' selected="selected"' : '';
				}
				
				$output[]			= '<option value="'.$subcat_id.'"'.$select.'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.e($category['subcat_name']).'</option>';
				$added[$subcat_id]	= 1;
			}
		}
	}
	
	return implode("\n", $output);
}
