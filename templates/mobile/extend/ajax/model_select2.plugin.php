<?php
defined('_VALID') or die('Restricted Access!');
function ajax_plugin_model_select2()
{
    $filter		= VF::factory('filter');
    $db			= VF::factory('database');
    $keyword	= $filter->get('k');    
    
    if (utf8_strlen($keyword) === 0) {
  		return json_encode(array('id' => '0', 'text' => 'Please enter at least one character to start searching...'));
    }
    
    $db->prepare('
  		SELECT model_id, name
  		FROM #__model
  		WHERE name LIKE ?
  		AND status = 1',
  		's',
  		$keyword.'%'
  	);
  	
  	if ($db->num_rows()) {
  		$models	= $db->fetch_rows();
  		$data	= array();
  		foreach ($models as $model) {
  			$data[]	= array('id' => $model['model_id'], 'text' => e($model['name']));
  		}
  	} else {
  		$data	= array('id' => '0', 'text' => 'No models found...');
  	}

    return json_encode($data);
}
?>
