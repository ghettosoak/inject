<?php

include('help/delicious_unjson.php');
include('help/markdown.php');

$dates = mysql_query('select date from post order by id asc');
$dateArray = array();
$titles = mysql_query('select title from post order by id asc');
$titleArray = array();

while ($dateQuery = mysql_fetch_array($dates, MYSQL_BOTH)){
	array_push($dateArray, $dateQuery['date']);
}

while ($titleQuery = mysql_fetch_array($titles, MYSQL_BOTH)){
	array_push($titleArray, $titleQuery['title']);
}

$a = file_get_contents('../inc/show_a.html');
$b = file_get_contents('../inc/show_b.html');
$c = file_get_contents('../inc/show_c.html');

for ($i = 1; $i <= 27; $i++){
	$thePost = file_get_contents('../store/md/' . $i . '.md');

	file_put_contents('../store/html/' . $i . '.php', '<h5>' . $dateArray[$i-1] . '</h5><h1>' . $titleArray[$i-1] . '</h1>' . Markdown($thePost));
	file_put_contents('../store/look/' . $i . '.html', $a . '<title>in / ject // ' . $titleArray[$i-1] . '</title>' . $b . '<h5>'. $dateArray[$i-1] .'</h5><h1>'.$titleArray[$i-1].'</h1>'.Markdown($thePost).$c);
}

echo 'yeah!!';

?>