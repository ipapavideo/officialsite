<?php
defined('_VALID') or die('Restricted Access!');
function template_plugin_pagination($options=array(), $url, $index=2, $id=NULL)
{
	$page		 = $options['page'];
	$total_pages = $options['total_pages'];
	$prev_page	 = $options['prev_page'];
	$next_page	 = $options['next_page'];
	$output      = array();

	if ($page != 1 && $total_pages > 0) {
          $output[]   = '<li><a href="'.pag_strip($prev_page, $url).'"'.pag_id($prev_page, $id, 'prev_page').' class="prevnext" title="Go to previous page!"><i class="fa fa-arrow-left"></i></a></li>';
	}
	
    if ($total_pages > (($index*2)+3) && $page >= ($index+3)) {
        $output[]   = '<li><a href="'.pag_strip(1, $url).'"' .pag_id(1, $id). ' title="Go to page 1!">1</a></li>';
        $output[]   = '<li><a href="'.pag_strip(2, $url).'"' .pag_id(2, $id). ' title="Go to page 2!">2</a></li>';
    }
    
    if ($page > $index+3) {
        $output[]   = '<li><span style="color: #373737;">&nbsp;...&nbsp;</span></li>';
	}
		
    for ($i=1; $i<=$total_pages; $i++) {
        if ($page == $i ) {
            $output[] = '<li class="active disabled"><a href="#">' .$page. '</a></li>';
        } elseif ( ($i >= ($page-$index) && $i < $page) OR ($i <= ($page+$index) && $i > $page) ) {
            $output[] = '<li><a href="'.pag_strip($i, $url).'"'.pag_id($i, $id).' title="Go to page '.$i.'!">'.$i.'</a></li>';
        }
    }

    if ($page < ($total_pages-6)) {
        $output[]   = '<li><span style="color: #373737;">&nbsp;...&nbsp;</span></li>';
	}
		
    if ($total_pages > (($index*2)+3) && $page <= $total_pages-($index+3)) {
        $output[]   = '<li><a href="'.pag_strip(($total_pages-1), $url).'"'.pag_id(($total_pages-1), $id).' title="Go to page '.($total_pages-1).'!">'.($total_pages-1).'</a></li>';
        $output[]   = '<li><a href="'.pag_strip(($total_pages), $url).'"'.pag_id(($total_pages), $id).' title="Go to last page!">'.($total_pages).'</a></li>';
    }
		
    if ($page != $total_pages) {
        $output[]   = '<li><a href="'.pag_strip($next_page, $url).'"'.pag_id($next_page, $id, 'next_page').' class="prevnext" title="Go to next page!"><i class="fa fa-arrow-right"></i></a></li>';
	}
		
    return implode('', $output);
}

function pag_id($page, $id=NULL, $add=NULL)
{
    if ($id) {
        $add = (isset($add)) ? '_'.$add : NULL;
        return ' id="'.$id.'_'.$page.$add.'"';
    }
}
	
function pag_strip($page, $url)
{
	if ($page === 1) {
		if (strpos($url, '#PAGE#') !== false) {
			return str_replace(array('/#PAGE#', '/recent/'), array('', '/'), $url);
		} else {
			return preg_replace('/(\?|&)page=(\w+)/i', '', str_replace('&amp;', '&', $url));
		}
	}

	if (strpos($url, '#PAGE#') !== false) {
      	return str_replace('#PAGE#', $page, $url);
	}

	if (isset($_GET['page']) or stripos($url, 'page=') !== false) {
		return str_replace('#PAGE#', 'page='.$page, preg_replace('/page=(\w+)/i', '#PAGE#', str_replace('&amp;', '&', $url)));
	} else {
		return $url.((strpos($url, '?')) ? '&' : '?').'page='.$page;
	}
}
