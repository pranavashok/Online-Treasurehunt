<?php 
	session_start();
	require_once("database.php");
	if (!$_SESSION["valid_user"])
	{
		Header("Location: loginform.php");
	}
	else if($_SESSION["role"] == 10)
	{
		$content = "<div class='box'>
		<img src=\"theme/clueless/border_tl.png\" style=\"position:absolute; top:0; left:0;\" />
		<img src=\"theme/clueless/border_tr.png\" style=\"position:absolute; top:0; right:0;\" />
		<img src=\"theme/clueless/border_bl.png\" style=\"position:absolute; bottom:0; left:0;\" />
		<img src=\"theme/clueless/border_br.png\" style=\"position:absolute; bottom:0; right:0;\" />";
		$content .= "<h2>Levels</h2>";
		$pagetype = "admin";
		$sql = "SELECT * FROM levels ORDER BY name";
		$ref = mysql_query($sql);
		while($row = mysql_fetch_assoc($ref))
		{
			$content = $content . "<br>" . $row["name"] . "&nbsp; : &nbsp; <a href = \"editlevels.php?l=" . $row["name"] ."\">" . $row["title"] . "</a>";
		}
		$sql = "SELECT * FROM accesslogs ORDER BY time DESC LIMIT 0,100";
		$ref = mysql_query($sql);
		$content .= "<br><br><h2>Access Logs</h2>";
		while($row = mysql_fetch_assoc($ref))
		{
			$content .= "<br>" . $row['user'] . ":&nbsp;" . $row['val'] . "&nbsp; From" . $row['ip'];
		}
		$sql = "SELECT * FROM users WHERE role != 10 ORDER BY level DESC, passtime ASC";
		$ref = mysql_query($sql);
		$sidebaradmin = "<div class=\"box\" >
		<img src=\"theme/clueless/border_tl.png\" style=\"position:absolute; top:0; left:0;\" />
		<img src=\"theme/clueless/border_tr.png\" style=\"position:absolute; top:0; right:0;\" />
		<img src=\"theme/clueless/border_bl.png\" style=\"position:absolute; bottom:0; left:0;\" />
		<img src=\"theme/clueless/border_br.png\" style=\"position:absolute; bottom:0; right:0;\" />";
		$sidebaradmin .= "<h2>leaderboard</h2>";
		while($row = mysql_fetch_assoc($ref))
		{
			
			 $sidebaradmin .= "<br><a href = \"edituser.php?id=" . $row["id"] . "\">" . $row["name"] . "</a>&nbsp;" . $row["level"] . "&nbsp;" . $row["fname"];
		}
		$sql = "SELECT * FROM logs ORDER BY time DESC LIMIT 0, 100";
		$ref = mysql_query($sql);
		$sidebaradmin .= "<br><br><h2>logs</h2>";
		while($row = mysql_fetch_assoc($ref))
		{
			
			 $sidebaradmin .= "<br>" . $row["user"] . "&nbsp; : &nbsp;" . $row["val"];
		}
		$content .= "</div><br /><br />";
		$sidebaradmin .= "</div>";
	}
	else if($_SESSION["role"] >= 6)
	{
		$content = "<div class='box'>
		<img src=\"theme/clueless/border_tl.png\" style=\"position:absolute; top:0; left:0;\" />
		<img src=\"theme/clueless/border_tr.png\" style=\"position:absolute; top:0; right:0;\" />
		<img src=\"theme/clueless/border_bl.png\" style=\"position:absolute; bottom:0; left:0;\" />
			<img src=\"theme/clueless/border_br.png\" style=\"position:absolute; bottom:0; right:0;\" />";
		$pagetype = "admin";
		$content .= "<h2>Levels</h2>";
		$sql = "SELECT * FROM levels ORDER BY name";
		$ref = mysql_query($sql);
		while($row = mysql_fetch_assoc($ref))
		{
			$content .= "<br>" . $row["name"] . "&nbsp; : &nbsp; <a href = \"editlevels.php?l=" . $row["name"] ."\">" . $row["title"] . "</a>";
		}
		$sql = "SELECT * FROM users WHERE role != 10 ORDER BY level DESC, passtime ASC";
		$ref = mysql_query($sql);
		$sidebaradmin = "<div class=\"box\" >
		<img src=\"theme/clueless/border_tl.png\" style=\"position:absolute; top:0; left:0;\" />
		<img src=\"theme/clueless/border_tr.png\" style=\"position:absolute; top:0; right:0;\" />
		<img src=\"theme/clueless/border_bl.png\" style=\"position:absolute; bottom:0; left:0;\" />
		<img src=\"theme/clueless/border_br.png\" style=\"position:absolute; bottom:0; right:0;\" />";
		$sidebaradmin .= "<h2>leaderboard</h2>";
		while($row = mysql_fetch_assoc($ref))
		{
			
			 $sidebaradmin .= "<br><a href = \"edituser.php?id=" . $row["id"] . "\">" . $row["name"] . "</a>&nbsp;" . $row["level"];
		}
		$sql = "SELECT * FROM logs ORDER BY time DESC LIMIT 0,100";
		$ref = mysql_query($sql);
		$sidebaradmin .= "<br><br><h2>logs</h2>";
		while($row = mysql_fetch_assoc($ref))
		{
			
			 $sidebaradmin .= "<br>" . $row["user"] . "&nbsp; : &nbsp;" . $row["val"];
		}
		$content .= "</div><br /><br />";
		$sidebaradmin .= "</div>";
	}
	else if($_SESSION["role"] >=0)
	{
		$content = "<div class='box'>
		<img src=\"theme/clueless/border_tl.png\" style=\"position:absolute; top:0; left:0;\" />
		<img src=\"theme/clueless/border_tr.png\" style=\"position:absolute; top:0; right:0;\" />
		<img src=\"theme/clueless/border_bl.png\" style=\"position:absolute; bottom:0; left:0;\" />
		<img src=\"theme/clueless/border_br.png\" style=\"position:absolute; bottom:0; right:0;\" />";
		$sql = "SELECT * FROM levels ORDER BY name";
	
		$id = $_SESSION["level"];

		$sql = "SELECT * FROM levels WHERE name = '" . mysql_real_escape_string($id) . "'" ;
		$ref = mysql_query($sql);
		$row = mysql_fetch_assoc($ref);
		$content .= $row['contents'] ;
		
		if(!($row['contents']))	
			$content .= "Waiting for the remaining levels to be uploaded";
		else
			$content .= "<br><div id = \"answerbox\"><form action = \"answer.php\" name = \"answer\" autocomplete=\"off\">Answer: <input type = \"text\" name = \"answer\"><input type = \"submit\" value = \"Check\"></form></div>";
		$cookie = $row['cookie'];
		$javascript = $row['javascript'];
		$title = $row['title'];
		$pagetype = "player";
		$content .= "</div><br /><br />";
	}	
	else
	{
		$content = "<div class='box'>
		<img src=\"theme/clueless/border_tl.png\" style=\"position:absolute; top:0; left:0;\" />
		<img src=\"theme/clueless/border_tr.png\" style=\"position:absolute; top:0; right:0;\" />
		<img src=\"theme/clueless/border_bl.png\" style=\"position:absolute; bottom:0; left:0;\" />
		<img src=\"theme/clueless/border_br.png\" style=\"position:absolute; bottom:0; right:0;\" />";
		$content .= "You have been banned from playing. Please contact admin for details";
		$content = $content . "</div><br /><br />";
	}
	require_once("theme/clueless/theme.php");
?>
	

