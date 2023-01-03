<?php
function template_widget_albums_viewed()
{
	$amodel		= VModel::load('album', 'photo');
	$timeline	= VCfg::get('template.defboot.albums_viewed_timeline');
	$total		= $amodel->total(array('orientation' => orientation(), 'timeline' => $timeline));
	$pagination	= VPagination::get(1, $total, VCfg::get('photo.browse_per_page'));
	$albums		= $amodel->albums(array(
		'orientation'	=> orientation(),
		'timeline'		=> $timeline,
		'order'			=> 'viewed'
	), VCfg::get('template.defboot.albums_viewed_nr'));

	$timeline	= ($timeline != 'all') ? $timeline.'/' : '';
	$url        = (VCfg::get('photo.browse_url')) ? REL_URL.LANG.ORIENTATION.'/photos/viewed/'.$timeline : REL_URL.LANG.ORIENTATION.'/photo/viewed/'.$timeline;	
  	
	$output		= array();
	$output[]	= '<div class="panel panel-default">';
    $output[]	= '<div class="panel-heading">';
    $output[]	= '<h3 class="panel-title pull-left"><strong>'.__('trending-photo-albums').'</strong></h3>';
    $output[]   = '<a href="'.$url.'" class="btn btn-menu btn-xs pull-right">'.__('view-more').'</a>';
    $output[]   = '<div class="clearfix"></div>';    
    $output[]	= '</div>';
    $output[]	= '<div class="panel-body">';
    
    if ($albums) {
  		if (!function_exists('display_albums')) {
  			require BASE_DIR.'/templates/defboot/extend/functions/photo.php';
  		}
  		
  		$output[]	= display_albums($albums, 'viewed');
  	} else {
  		$output[]	= '<div class="none">'.__('no-albums').'</div>';
  	}
  	
  	$output[]	= '</div></div>';
  	
  	if ($total > 0) {
  		$output[]	= '<nav class="text-center"><ul class="pagination">'.p('pagination', $pagination, $url.'#PAGE#/').'</ul></nav>';
  	}
  	
  	return implode('', $output);
}