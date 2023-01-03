<?php
function template_widget_news()
{
	$nmodel		= VModel::load('news', 'news');
	$articles	= $nmodel->articles(0, 0, 1);
	
	if (!$articles) {
		return;
	}
	
	$article	= $articles['0'];
	
	$output		= array();
	$output[]	= '<div class="panel panel-default">';
    $output[]	= '<div class="panel-heading">';
    $output[]	= '<a href="'.REL_URL.LANG.'/news/'.e($article['slug']).'/" class="panel-title btn-color"><strong>'.e($article['title']).'</strong></a><br>';
    $output[]	= '<small>'.__('by').' <a href="'.REL_URL.LANG.'/users/'.e($article['username']).'/" class="btn-color">'.e($article['username']).'</a> '.VDate::nice($article['add_time']).'</small>';
    $output[]	= '</div>';
    $output[]	= '<div class="panel-body panel-article">'.$article['content'].'</div>';
  	$output[]	= '</div>';
  	
  	return implode('', $output);
}