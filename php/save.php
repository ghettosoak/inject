<?php

include('help/delicious_unjson.php');
include('help/markdown.php');

$isnew = $_REQUEST['isnew'];
$post = $_REQUEST['post'];
$title = $_REQUEST['title'];
$body = $_REQUEST['body'];

if ($isnew === 'true'){
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

	mysql_query('insert into post set id = "' . $post . '",  date = "'.$thedate.'", title = "'.$title.'"');
}else{
	mysql_query('update post set title = "'.$title.'" where id ='.$post);

	$thedate = mysql_query('select date from post where id = ' . $post);
	$thedate = mysql_fetch_array($thedate, MYSQL_BOTH);
	$thedate = $thedate['date'];
}

$a = file_get_contents('../inc/show_a.html');
$b = file_get_contents('../inc/show_b.html');
$c = file_get_contents('../inc/show_c.html');

file_put_contents('../store/md/'.$post.'.md', $body);
file_put_contents('../store/html/'.$post.'.php', '<div><h5>'. $thedate .'</h5><h1>'.$title.'</h1></div>'.Markdown($body));
file_put_contents('../store/look/'.$post.'.html', $a . '<title>in / ject // ' . $title . '</title>' . $b . '<div><h5>'. $thedate .'</h5><h1>'.$title.'</h1></div>'.Markdown($body).$c);

echo $thedate;

?>