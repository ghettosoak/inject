<?php

include('help/delicious_unjson.php');

$thedate = 'today';
$title = 'nope';

mysql_query('insert into post set date = "'.$thedate.'", title = "'.$title.'"');

echo 'yeah!';
?>