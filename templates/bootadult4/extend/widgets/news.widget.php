<?php
function template_widget_news()
{
	$nmodel		= VModel::load('news', 'news');
	$articles	= $nmodel->articles(0, 0, 1);
	
	if (!$articles) {
		return;
	}
	
	$article	= $articles['0'];
	
    $output[]   = '<div class="row mb-2">';
    $output[]   = '<div class="col-lg-12">';
    
    $output[]	= '<div class="card">';    
    $output[]	= '<div class="card-body">';
    $output[]	= '<h5 class="w-100 border-bottom"><a href="'.REL_URL.LANG.'/news/'.e($article['slug']).'/">'.e($article['title']).'</a></h5>';
    $output[]	= '<small class="card-subtitle mb-2 text-muted">'.__('by').' <a href="'.REL_URL.LANG.'/users/'.e($article['username']).'/" class="btn btn-xs btn-primary">'.e($article['username']).'</a> '.VDate::nice($article['add_time']).'</small>';
    $output[]	= '<p class="card-text">'.$article['content'].'</p>';
    $output[]	= '</div>';
    $output[]	= '</div>';
    
    $output[]	= '</div>';
    $output[]	= '</div>';
  	
  	return implode('', $output);
}