<?php
function template_widget_albums_recent()
{
	$amodel		= VModel::load('album', 'photo');
	$total		= $amodel->total(array('orientation' => orientation()));
	$pagination	= VPagination::get(1, $total, VCfg::get('photo.browse_per_page'));
	$albums		= $amodel->albums(array(
		'orientation'	=> orientation(),
		'order'			=> 'recent'
	), VCfg::get('template.defboot.albums_recent_nr'));

	$url        = (VCfg::get('photo.browse_url')) ? REL_URL.LANG.ORIENTATION.'/photos/recent/' : REL_URL.LANG.ORIENTATION.'/photo/recent/';	
  	
	$output		= array();
	$output[]	= '<div class="panel panel-default">';
    $output[]	= '<div class="panel-heading">';
    $output[]	= '<h3 class="panel-title pull-left"><strong>'.__('recent-photo-albums').'</strong></h3>';
    $output[]   = '<a href="'.$url.'" class="btn btn-menu btn-xs pull-right">'.__('view-more').'</a>';
    $output[]   = '<div class="clearfix"></div>';    
    $output[]	= '</div>';
    $output[]	= '<div class="panel-body">';
    
    if ($albums) {
  		if (!function_exists('display_albums')) {
  			require BASE_DIR.'/templates/defboot/extend/functions/photo.php';
  		}
  		
  		$output[]	= display_albums($albums, 'recent');
  	} else {
  		$output[]	= '<div class="none">'.__('no-albums').'</div>';
  	}
  	
  	$output[]	= '</div></div>';
  	
  	if ($total > 0) {
  		$output[]	= '<nav class="text-center"><ul class="pagination">'.p('pagination', $pagination, $url.'#PAGE#/').'</ul></nav>';
  	}
  	
  	return implode('', $output);
}