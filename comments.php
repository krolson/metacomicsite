<?php

	function OpenConnection()
    	{        	
		  $serverName = getenv('APPSETTING_dbServer');
        	$connectionOptions = array("Database"=>getenv('APPSETTING_dbName'), "UID"=>getenv('APPSETTING_dbUid'), "pwd"=>getenv('APPSETTING_dbPwd'));
        	$conn = sqlsrv_connect($serverName, $connectionOptions);
        	if($conn == false)
		    echo(FormatErrors(sqlsrv_errors()));

        	return $conn;
    	}

	function getComicComments($dirDateID) {	
		//TODO: validate you have a dirDateID in expected format

		// // SQLSRV extension
		try
        {
            $conn = OpenConnection();
			if($conn == false) {
				echo("ErrorGettingCxn!");
			}
			$commenttsql = "SELECT [Name],[Text],[CreatedDate] FROM Comments WHERE PostId = ?";
			$commentparams = array($dirDateID);  			
      $getComments = sqlsrv_query($conn, $commenttsql, $commentparams);
      if ($getComments == FALSE) {							
           return FormatErrors(sqlsrv_errors());
			}
			
			print_r("<h3>Comments</h3>");
			print_r("<hr>");

      while($row = sqlsrv_fetch_array($getComments, SQLSRV_FETCH_ASSOC))
      {					
			  	formatCommentAsHtml($row['Name'], $row['CreatedDate'], $row['Text']);
      }
      sqlsrv_free_stmt($getComments);
      sqlsrv_close($conn);
      }
      catch(Exception $e)
      {
          echo("Error!");
      }
	}

	function formatCommentAsHtml($cAuthor, $cDate, $cText) {
		if(!is_string($cDate)) {
			$cDate = $cDate->format(\DateTime::ISO8601);
		}
		echo("type: ".gettype($cDate)); // TEMP

		echo('<div class="comment">');		
		echo("<leftBlock>");
		echo("<author>");
		echo($cAuthor);
		echo("</author>");
		echo("<br/>");
		echo("<commentDate>");
		echo($cDate);
		echo("</commentDate>");			
		echo('<form method="POST">');
		echo('        <input type=hidden name=postAuthor value="'.$cAuthor.'" >');
		echo('		  <input type=hidden name=postTime value="'.$cDate.'" >');
		echo('        <input type=submit value=Delete name=delete >');
		echo('	</form>');
		echo("</leftBlock>");
		echo("<rightBlock>");
		echo($cText);
		echo("</rightBlock>");
		echo("<br/>");
		echo("</div>");
	}

	function addComment($dirDateID, $Comment, $User) {							
		try
        {
            $conn = OpenConnection();
			if($conn == false) {
				echo("ErrorGettingCxn!");
			}
			/*Prepend the review so it can be opened as a stream.*/  
			$comments = "data://text/plain,".$Comment;  
			$stream = fopen( $comments, "r" );  			
			$addtsql = "INSERT INTO Comments (PostID, Name, Text, CreatedDate) VALUES (?, ?, ?, GETDATE())";
			$addParams = array($dirDateID, $User, &$stream);  
			/* Prepare and execute the statement. */  
			$insertComment = sqlsrv_prepare($conn, $addtsql, $addParams); 						

			if( $insertComment === false )  
				die( FormatErrors( sqlsrv_errors() ) );  
			/* By default, all stream data is sent at the time of query execution. */  
			if( sqlsrv_execute($insertComment) === false )  
				die( FormatErrors( sqlsrv_errors() ) );   

			sqlsrv_free_stmt( $insertComment );  
			sqlsrv_close($conn);
			echo "<h4 align='center'>(Comment submitted)</h4>";
        }
        catch(Exception $e)
        {
            echo("Error!");
        }	  
	}

	function deleteComment($dirDateID, $CommentDate, $User) {							
		try
        {
            $conn = OpenConnection();
			if($conn == false) {
				echo("ErrorGettingCxn!");
			}
			$deletetsql = "DELETE TOP (1) FROM Comments WHERE PostID = ? AND Name = ? AND CreatedDate = ?";		
			$deleteparams = array($dirDateID, $User, $CommentDate);  
			/* Prepare and execute the statement. */  
			$deleteRowStmt = sqlsrv_prepare($conn, $deletetsql, $deleteparams);  
			if( $deleteRowStmt === false )  
				die( FormatErrors( sqlsrv_errors() ) );  
			
			if( sqlsrv_execute($deleteRowStmt) === false )  
				die( FormatErrors( sqlsrv_errors() ) );   

			sqlsrv_free_stmt($deleteRowStmt);  
			sqlsrv_close($conn);
			echo "<h4 align='center'>(Comment deleted)</h4>";              			                        
        }
        catch(Exception $e)
        {
            echo("Error!");
        }	  
	}

	function FormatErrors( $errors )  
	{  
		/* Display errors. */  
		echo "Error information: <br/>";  
	
		foreach ( $errors as $error )  
		{  
			echo "SQLSTATE: ".$error['SQLSTATE']."<br/>";  
			echo "Code: ".$error['code']."<br/>";  
			echo "Message: ".$error['message']."<br/>";  
		}  
	}	

	$headers = array_change_key_case(getallheaders(), CASE_UPPER);	
	$loggedInUserName = $headers["X-MS-CLIENT-PRINCIPAL-NAME"];
        echo("Hi $loggedInUserName!");
	// $loggedInUserName = "person@microsoft.com"; // only when local testing
	$userAlias = strtok($loggedInUserName, '@');
	if(empty($userAlias))
	{
		if(empty($loggedInUserName))
		{		
			$userAlias = "anonymous";
		} else {
			$userAlias = $loggedInUserName;
		}
	}

	if(isset($_POST["submit"]))
	{	
		addComment($currentComicDir, $_POST["commentbox"], $userAlias);
	}

	if(isset($_POST["delete"]))
	{	 	
		deleteComment($currentComicDir, $_POST["postTime"], $_POST["postAuthor"]);
	}
?>
