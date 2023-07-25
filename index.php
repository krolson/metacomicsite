<?php include "comicslib.php"; include "comments.php" ?>
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
		font-weight:bold; padding-top:0.5em; border-radius:4px; }
	.links A:hover { color:gray; }	
	.comments { margin:auto; max-width:800px }	
	.comment { display:block; overflow:hidden; max-width:800px; text-align:left; padding-bottom:15px; break-after:always}
	.comment leftBlock {display:inline-block; width:78%; padding-bottom:500em;margin-bottom:-500em; }
	.comment rightBlock {float:right; width:20%; padding-bottom:500em;margin-bottom:-500em;}
	.comment author {font-weight:bold}
	.comment commentDate {font-size:x-small;}
	.comment deletebutton { background-color:black; color:white; text-align:center; width:75px; padding-top:1em; padding-bottom:1em;}
	input[type=submit] { background-color: #lightgray; color:303030;
		border-color:gray; border-width:1px; padding: 8px 16px; text-decoration: none;
		margin: 4px 2px; border-radius:4px; cursor: pointer; }
	input:hover {background-color:505050; color:lightgray}
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
	
	<details>
		<summary>hover text</summary>
		<p><?= $altText ?></p>  
	</details>
	
	<div class="links">
		<a href="?comic=first">&lt;&nbsp;&lt;</a>
		<a href="?comic=<?= $previousComicDate ?>">&lt;</a>
		<a href="?comic=<?= $nextComicDate ?>">&gt;</a>
		<a href="?comic=last">&gt;&nbsp;&gt;</a>
	</div>

	<div class="comments">	
		<h3>Comments</h3>
		<hr style="margin:5px">	
		<?php
			getComicComments($currentComicDir, $userAlias);
		?>
		<br/>
		<div class="comment">
		<form action="" method="post">
			<leftBlock>
				<textarea id="commentbox" name="commentbox" rows="8" style="width:95%; max-width:95%; top:0" maxlength="2000" placeholder="New comment..." border-radius="4px"></textarea>	
			</leftBlock>
			<rightBlock>
				<author><?= $userAlias ?></author>
				<br/>
				<input type="submit" name="submit" value="Post" />				
			</rightBlock>			
		</form>			
		</div>
	</div>
	
	<br/>
</body>

<!-- Powered by mincomixsite (https://github.com/codercowboy/mincomixsite) -->

</html>
