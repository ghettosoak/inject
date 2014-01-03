<?php

include('help/delicious_unjson.php');

$date = mysql_query('select date from post where id = 7');

$date = mysql_fetch_array($date, MYSQL_BOTH);

$date = $date['date'];

echo $date;

?>