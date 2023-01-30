<?php
defined('_VALID') or die('Restricted Access!');
function template_plugin_date($current = '', $prefix = 'Date_', $months = true, $days = true, $years = true,
	                          $extra = '', $extra_months = '', $extra_days = '', $extra_years = '')
{

	$output			= array();
	
	if (is_int($current)) {
		$current_year	= date('Y', $current);
		$current_month	= date('m', $current);
		$current_day	= date('d', $current);
	} else {
		$current		= explode('-', $current);
		$current_year	= (isset($current['0'])) ? $current['0'] : NULL;
		$current_month	= (isset($current['1'])) ? $current['1'] : NULL;
		$current_day	= (isset($current['2'])) ? $current['2'] : NULL;
	}
		
	if ($months) {
		$output[]	= '<label class="inline">';
		$output[]	= '<select name="' .$prefix. 'month" ' .$extra . $extra_months. '>';
		$output[]	= '<option value="">'.__('month').'</option>';
		$count		= 1;
		$months_arr	= array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august',
		                    'september', 'october', 'november', 'december');
		foreach ($months_arr as $key) {
			$selected	= ($current_month == $count) ? ' selected="selected"' : NULL;
			$output[]	= '<option value="' .$count. '"' .$selected. '>' .__($key). '</option>';
			++$count;
		}
		$output[]	= '</select>';
		$output[]	= '</label>';
	}
	
	if ($days) {
		$output[]	= '<label class="inline">';
		$output[]	= '<select name="' .$prefix. 'day" ' .$extra . $extra_days. '>';
		$output[]	= '<option value="">'.__('day').'</option>';
		for ($count=1; $count<=31; $count++) {
			$selected	= ($count == $current_day) ? ' selected="selected"' : NULL;
			$output[]	= '<option value="' .$count. '"' .$selected. '>' .$count. '</option>';
		}
		$output[]	= '</select>';
		$output[]	= '</label>';
	}
		
	if ($years) {
		$output[]	= '<label class="inline">';
		$output[]	= '<select name="' .$prefix. 'year" ' .$extra . $extra_years. '>';
		$output[]	= '<option value="">'.__('year').'</option>';
		for ($count=date('Y'); $count >= 1920; $count--) {
			$selected	= ($count == $current_year) ? ' selected="selected"' : NULL;
			$output[]	= '<option value="' .$count. '"' .$selected. '>' .$count. '</option>';
		}
		$output[]	= '</select>';
		$output[]	= '</label>';
	}
		
	return implode("\n", $output);
}