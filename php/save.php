<?php

include('help/delicious_unjson.php');
include('help/markdown.php');

$isnew = $_REQUEST['isnew'];
$post = $_REQUEST['post'];
$title = $_REQUEST['title'];
$body = $_REQUEST['body'];

// if (!$isnew) echo 'yeah!';

if ($isnew == 'true'){
	$today = getdate();
	$day;
	$month;
	$year;

	if ($today['mday'] < 10) $day = '0'.$today['mday'];
	else $day = $today['mday'];

	if ($today['mon'] < 10) $month = '0'.$today['mon'];
	else $month = $today['mon'];

	$year = substr($today['year'], -2);

	$thedate = $day.'.'.$month.'.'.$year;

	mysql_query('insert into post set date = "'.$thedate.'", title = "'.$title.'"');
	echo $thedate;
}else mysql_query('update post set title = "'.$title.'" where id ='.$post);

$a = file_get_contents('../inc/show_a.html');
$b = file_get_contents('../inc/show_b.html');

// $return['body'] = file_get_contents('../store/md/'.$post.'.md');

file_put_contents('../store/md/'.$post.'.md', $body);
file_put_contents('../store/html/'.$post.'.php', '<h1>'.$title.'</h1>'.Markdown($body));
file_put_contents('../store/look/'.$post.'.html', $a.'<h1>'.$title.'</h1>'.Markdown($body).$b);


?>