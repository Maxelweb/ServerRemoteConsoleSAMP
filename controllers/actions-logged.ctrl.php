<?php

/*
	DO NOT CHANGE!
	---------------------
	SERVER REMOTE CONSOLE
	actions - core file
	developed by Maxel (marianosciacco.it)
*/


		if($a == "logout" && $CONFIG['EnableSRCPassword'])
		{
			unset($_SESSION['src_logged']); 
			location("?");
		}
		elseif($a == "control")
		{

			if($_POST['start'] && $CONFIG['EnableSSH'])
			{
				$ssh = new Net_SSH2(IP_SERVER);
				if (!$ssh->login(SERVER_SSH_USER, SERVER_SSH_PSW)) 
	    			exit(No('Host access refused!'));
				$ssh->exec('cd '.SERVER_SSH_PATH.'; nohup ./samp03svr &');  
				Ok("Server started!");
			}  
			elseif($_POST['stop'] && $CONFIG['EnableRCON'])
			{
				$query = new SampRcon(IP_SERVER, PORT_SERVER, RCON_SERVER); 
				if(!$query->connect()) return "Connection error. Retry."; 
				$query->call("say {FFFFFF} [SRC] The server is turning off. You're going to be drop-kicked by Chuck Norris soon.", 1); 
				$query->call("exit", 2); 
				$query->close(); 
				Ok("Server stopped!");
			}  	
			elseif($_POST['gmx'] && $CONFIG['EnableRCON'])
			{
				$query = new SampRcon(IP_SERVER, PORT_SERVER, RCON_SERVER); 
				if(!$query->connect()) return "Connection error. Retry."; 
				$query->call("say {FFFFFF} [SRC] The server is changing mode. Please, consider to relog.", 1); 
				$query->gmx(); 
				$query->close(); 
				Ok("Changing mode... done!");
			}  	
			elseif($_POST['viewlogs'] && $CONFIG['EnableSSH'])
			{
				Ok("Fetching server_logs...<br><br>");
				$ssh = new Net_SSH2(IP_SERVER);
				if (!$ssh->login(SERVER_SSH_USER, SERVER_SSH_PSW)) 
	    			exit(No('Host access refused!'));
	    		echo "<textarea rows=50 cols=110 class='form-control' readonly>";
				echo $ssh->exec('cd '.SERVER_SSH_PATH.'; cat server_log.txt'); 
				echo "</textarea>";
			}  	
			elseif($_POST['resetlogs'] && $CONFIG['EnableSSH'])
			{
				$ssh = new Net_SSH2(IP_SERVER);
				if (!$ssh->login(SERVER_SSH_USER, SERVER_SSH_PSW)) 
	    			exit(No('Host access refused!'));
				echo $ssh->exec('cd '.SERVER_SSH_PATH.'; rm server_log.txt; touch server_log.txt'); 
				Ok("Server logs cleaned!");
			}  	


		}
		elseif($a == "sendmex")
		{

			if($_POST['smex'] && $CONFIG['EnableRCON'])
			{
				$query = new SampRcon(IP_SERVER, PORT_SERVER, RCON_SERVER); 
				if(!$query->connect()) return "Connection error. Retry."; 
				$query->call("say {FFFFFF}[SRC] ".$_POST['mex'], 1); 
				$query->close(); 
				Ok("In-game message sent!");
			}  		

		}
		elseif($a == "kickPlayer" && $CONFIG['EnableRCON'])
		{
			$name = $_GET['name'];
			$query = new SampRcon(IP_SERVER, PORT_SERVER, RCON_SERVER); 
			if(!$query->connect()) return "Connection error. Retry."; 
			$query->call("say {FFFFFF} [KICK-SRC] The player $name has been kicked from the server.", 1);
			$query->call("kick $id", 5);  
			$query->close(); 
			Ok("The player <b>$name</b> has been kicked successfully.");		
		}
		elseif($a == "banPlayer" && $CONFIG['EnableRCON'])
		{
			$name = $_GET['name'];
			$query = new SampRcon(IP_SERVER, PORT_SERVER, RCON_SERVER); 
			if(!$query->connect()) return "Connection error. Retry."; 
			$query->call("say {FFFFFF} [BAN-SRC] The player $name has been banned from the server.", 1);
			$query->call("ban $id", 5); 
			$query->reloadBans(); 
			$query->close();
			Ok("The player <b>$name</b> has been banned successfully.");		
		}					
		elseif($a == "info" || (!$CONFIG['EnableSRCPassword'] && !$CONFIG['EnableSSH'] && !$CONFIG['EnableRCON']))
		{

			$query = new SampQuery(IP_SERVER, PORT_SERVER);
	        
	        
	        if ($query->connect()) 
	        { 
	        	echo "<h2>Server information</h2>";

	            Ok("Connection established<br><br>");
	            
	            echo "<div class='row'>";
	            echo "<div class='col-md-6'><ul class='list-group'>";
	            foreach($query->getInfo() as $key => $value)
	            {
	            	if("password" == trim($key)) $value = $value ? "yes" : "no";
	            	echo "<li class='list-group-item'> <b>".ucfirst($key).":</b> $value </li>"; 
	            }
	            echo "</ul></div>";	
	            echo "<div class='col-md-6'><ul class='list-group'>";  
	            foreach($query->getRules() as $key => $value)
	            	echo "<li class='list-group-item'> <b>".ucfirst($key).":</b> $value </li>";
	            echo "</ul></div>";
	            echo "</div>";

	            echo "<br><br><h2>Online players <small>(last update: ".date("Y/m/d - H:i:s").")</small></h2><br>
	            <table class='table table-border table-striped table-hover'>
	             <tr>
	                 <th>PlayerID</th>
	                 <th>Nickname</th>
	                 <th>Score</th>
	                 <th>Ping</th>";

	            if($CONFIG['EnableRCON']) echo "<th>Options</th>"; 

	            echo "
	             </tr>
	            ";
	            $players = $query->getDetailedPlayers();
	            $fieldsnum = $CONFIG['EnableRCON'] ? 5 : 4;

	            if(!count($players))
	            {
	            	echo "<td colspan=$fieldsnum>The server is actually empty.</td>";
	            }
	            else
		            foreach($players as $arr)
		            {
		            	$id = 0; 
		            	$name = ""; 
		            	echo "<tr> ";
		            	foreach($arr as $key => $value)
		            	{
		            		if($key == "playerid") $id = $value; 
		            		if($key == "nickname") $name = $value; 
		            		echo "<td>$value</td>"; 
		            	}

		            	if($CONFIG['EnableRCON']) echo "<td><a href='?a=kickPlayer&id=$id&name=$name' class='badge badge-warning'>Kick</a> <a href='?a=banPlayer&id=$id&name=$name' class='badge badge-danger'>Ban</a></td>";
		            	echo "</tr>";
		            }
	            echo "</table><br><br>";

	        } 
	        else 
	            No("The server is not responding! It may be offline.<br>");
	        

	        $query->close(); 
	    

	        echo "<hr>";
	    }

?>