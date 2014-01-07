<?php

include('help/delicious.php');

$titles = mysql_query("select id, date, title from post");

$status = mysql_query("select id from post order by id desc limit 1");

$nav['lastpost'];
$nav['postcount'];
$nav['posts'] = array();

while ($thestatus = mysql_fetch_array($status, MYSQL_ASSOC)){
	$nav['lastpost'] = $thestatus['id'];
}

while ($thistitle = mysql_fetch_assoc($titles)){
	$nav['postcount']++;
    $nav['posts'][] = array('id' => $thistitle['id'], 'date' => $thistitle['date'], 'title' => $thistitle['title']);
}

// echo jsonReadable( 
	echo json_encode($nav);
	// );

?>