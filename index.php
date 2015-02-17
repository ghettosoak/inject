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
    <meta name="description" content="Thoughts and musings of a designer pretending to be a developer; and an American pretending to be a Swiss." />

    <link rel="shortcut icon" href="img/favicon.ico" />
    <link rel="apple-touch-icon" href="img/apple-touch-icon.png" />
        
    <link rel="stylesheet" type="text/css" href="css/master.css?v2" />
    <script>
    	<?php 
    		echo 'var available = ['.implode(', ', $nav).'];'
    	?>
    	
    	console.log(available);

    	var svg_attr_dark = {'fill':'#00002a', 'stroke':'none'};
    </script>
</head>

<body>
	<div id="master" class="whiteblack wait">
		<div id="left">
			<div class="edit"></div>
			<div id="syringe">
				<div class="dark"></div>
				<div class="light"></div>
			</div>
			<div id="name">
				<h1>IN.JECT</h1>
			</div>
			<div id="title"></div>
		</div>
		<div id="switch">
			<div class="target"></div>
			<div class="left colour"></div>
			<div class="right colour"></div>
		</div>
		<div id="right">
			<div class="edit">
				<input tabindex="1" type="password" id="trial" />
				<div class="control">
					<div id="save"><div></div><div></div></div>
					<div id="new"><div></div><div></div></div>
					<div id="delete"><div></div><div></div><p>really?</p></div>
					<div id="return"><div></div><div></div></div>
					<textarea id="titleedit"></textarea>
				</div>
			</div>

			<div class="content">
				<textarea id="postedit"></textarea>
			</div>

			<div id="articleNav">
				<div class="articleNavInside">
					<span id="prev"></span>
					<span id="next"></span>
					<span id="back"></span>
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript" src="js/master-m.js?v2"></script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-31902149-2', 'ject.ch');
  ga('send', 'pageview', {
   'page': location.pathname + location.search  + location.hash
  });
  
</script>
</body>
</html>