<?php
function template_widget_categories_featured()
{
	$cmodel		= VModel::load('category', 'video');
	$categories	= $cmodel->categories(orientation(), 'featured', VCfg::get('template.bootadult4.categories_popular_nr'));

    $output     = array();
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-lg-12">';
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-md-8 text-center text-md-left">';
    $output[]   = '<h2>'.__('featured-categories').'</h2>';
    $output[]   = '</div>';
    $output[]   = '<div class="col-md-4 d-flex justify-content-center justify-content-lg-end align-items-center">';
    $output[]   = '<a href="'.REL_URL.LANG.'/categories/?order=featured" class="btn btn-light btn-sm"><i class="fa fa-plus"></i> '.__('view-all').'</a>';
    $output[]   = '</div>';
    $output[]   = '</div>';

    if ($categories) {
        $output[]   = p('categories', $categories);
    } else {
        $output[]   = '<div class="none">'.__('no-featured-categories').'</div>';
    }

    $output[]   = '</div>';
    $output[]   = '</div>';

    return implode('', $output);
}
