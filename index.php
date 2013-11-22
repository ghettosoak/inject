<?php

include('php/help/delicious_unjson.php');

$available = mysql_query('select id from post');
$nav = array();
while ($theavailablity = mysql_fetch_array($available, MYSQL_ASSOC)){
	$nav[] = $theavailablity['id'];
}

?>
<!doctype html>
<!--[if lt IE 7]>  <html class="ie ie8 ie7 ie6" lang="en"> <![endif]-->
<!--[if IE 7]>     <html class="ie ie8 ie7" lang="en"> <![endif]-->
<!--[if IE 8]>     <html class="ie ie8" lang="en"> <![endif]-->
<!--[if IE]>       <html class="ie" lang="en"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>in / ject</title>
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="css/master.css" />
    <script>
    	<?php 
    		echo 'var available = ['.implode(', ', $nav).'];'
    	?>
    	console.log(available);

    	var svg_attr_dark = {'fill':'#00002a', 'stroke':'none'}
    </script>
</head>

<body>
	<div id="master" class="whiteblack wait">
		<div id="left">
			<div class="edit"></div>
			<div id="syringe"></div>
			<div id="name">
				<h1>IN.JECT</h1>
			</div>
			<div id="title"></div>
		</div>
		<div id="right">
			<div class="edit">
				<input tabindex="1" type="password" id="trial" />
				<div class="control">
					<div id="save"></div>
					<div id="new"></div>
					<div id="delete"><p>really?</p></div>
					<div id="return"></div>
					<textarea id="titleedit"></textarea>
				</div>
			</div>

			<div class="content">
				<textarea id="postedit"></textarea>
			</div>
			<!-- <div class="content_editor">
				
			</div> -->
		</div>
	</div>

<script type="text/javascript" src="js/master-m.js"></script>
</body>
</html>