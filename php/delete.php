<?php

include('help/delicious.php');

$post = $_REQUEST['post'];

$fetch = mysql_query("delete from post where id = ".$post);

unlink('../store/md/'.$post.'.md');
unlink('../store/html/'.$post.'.php');

?>