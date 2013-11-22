<?php

include('help/delicious.php');
include('help/markdown.php');

$post = $_REQUEST['post'];
// $htmlpls = $_REQUEST['htmlpls'];

$fetch = mysql_query("select title from post where id =".$post);

$return = array();

while ($thispost = mysql_fetch_assoc($fetch)){
	// $thebody = htmlspecialchars(urldecode($thispost['body_html']));
	// $thetitle = htmlspecialchars(urldecode($thispost['title']));

	// if ($htmlpls == 'true') 
		// $html = Markdown($thispost['body_html']);
		// $html = ($thispost['body_html']);
	// else 
		// $html = $thebody;

    $return['title'] = $thispost['title'];
}

$return['body'] = file_get_contents('../store/md/'.$post.'.md');

echo jsonReadable(json_encode($return));


// echo file_get_contents('../store/md/'.$post.'.md');

// echo '../store/md/'.$post.'.md';

// echo $post;
// 
// echo file_get_contents('../index.php');


?>