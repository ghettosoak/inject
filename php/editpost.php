<?php

include('help/delicious.php');
include('help/markdown.php');

$post = $_REQUEST['post'];

$fetch = mysql_query("select title from post where id =".$post);

$return = array();

while ($thispost = mysql_fetch_assoc($fetch)){
    $return['title'] = $thispost['title'];
}

// $return['body'] = file_get_contents('../store/md/'.$post.'.md');

echo jsonReadable(json_encode($return));

?>