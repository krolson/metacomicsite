<?php include "comicslib.php"; ?>
<html>
<head>
<title>krolson comics</title>
<style>
	* { margin:0; padding:0; -webkit-text-size-adjust:100%; font-family:Arial, Verdana, serif; }
	BODY { text-align:center; margin-bottom:30px; }
	IMG { max-width:800px; }
	.pageHeader { margin-left:auto; margin-right:auto; text-align:center; margin-bottom:30px; }
	.pageHeader H1 { font-size:6em; margin-top:10px; }
	.pageHeader H2 { font-size:2em; margin-bottom:20px; margin-top:10px; }
	.links { display:block; margin-top:30px; }
	.links A { width:75px; height:50px; background-color:black; color:white; display:inline-block;
		border-color:gray; text-decoration:none; margin:25px; font-size:2em; 
		font-weight:bold; padding-top:0.5em; }
	.links A:hover { color:gray; }
</style>
</head>
<body>
	<div class="pageHeader">
		<h1>Kristina's 15th work anniversary!</h1>
		<h2>Here are some comics Kristina made in her early years working here</h2>	
	</div>
	
	<div class="links">
		<a href="?comic=first">&lt;&nbsp;&lt;</a>
		<a href="?comic=<?= $previousComicDate ?>">&lt;</a>
		<a href="?comic=<?= $nextComicDate ?>">&gt;</a>
		<a href="?comic=last">&gt;&nbsp;&gt;</a>
	</div>

	<img src="<?= $currentComicImage ?>" title="<?= $altText ?>"/>
	
	<div class="links">
		<a href="?comic=first">&lt;&nbsp;&lt;</a>
		<a href="?comic=<?= $previousComicDate ?>">&lt;</a>
		<a href="?comic=<?= $nextComicDate ?>">&gt;</a>
		<a href="?comic=last">&gt;&nbsp;&gt;</a>
	</div>
	
</body>

<!-- Powered by mincomixsite (https://github.com/codercowboy/mincomixsite) -->

</html>
