<?php

/*
 *
 *  SERVER REMOTE CONSOLE
 *  Controller - Server actions
 *  
 *  Developed by Maxel (marianosciacco.it)
 *  Github - src.debug.ovh
 *
 */

		if($a == "logout")
		{
			unset($_SESSION['src_logged']); 
			location("?");
		}
		elseif($a == "control")
		{

			if((isset($_POST['start']) || isset($_POST['forcestart'])) && $config->EnableSSH)
			{
				$ssh = new Net_SSH2(IP_SERVER);
				if (!$ssh->login(SERVER_SSH_USER, SERVER_SSH_PSW)) 
	    			exit(No('Host access refused!'));
	    		$response = $ssh->exec('pgrep samp03svr');
	    		if($response && $_POST['start']) No("The server is already running! You can use <u>Force start</u>, if you're running multiple server. Please, if you notice any small issue consider to <u>Hard Stop the SA-MP server</u>, by killing all SA-MP processes.");
	    		elseif((!$response && $_POST['start']) || $_POST['forcestart'])
	    		{
					$ssh->exec('cd '.SERVER_SSH_PATH.'; nohup ./samp03svr &');  
					Ok("Server started! <a href='?' class='btn btn-sm btn-success'>Reload the page</a>");
				}
			}  
			elseif(isset($_POST['stop']) && $config->EnableRCON)
			{
				$query = new SampRcon(IP_SERVER, PORT_SERVER, RCON_SERVER); 
				if(!$query->connect()) die(No("Connection error. Retry.",1)); 
				$query->call("say {c726e0} [SRC] {FFFFFF}The server is turning off. You're going to be drop-kicked by Chuck Norris soon.", 1); 
				$query->call("exit", 2); 
				$query->close(); 
				Ok("Server stopped! <a href='?' class='btn btn-sm btn-success'>Reload the page</a>");
			}  	
			elseif(isset($_GET['gmx']) && $config->EnableRCON)
			{
				$query = new SampRcon(IP_SERVER, PORT_SERVER, RCON_SERVER); 
				if(!$query->connect()) return "Connection error. Retry."; 
				$query->call("say {c726e0}[SRC] {FFFFFF}The server is changing mode. Please, consider to relog.", 1); 
				$query->gmx(); 
				$query->close(); 
				Ok("Changing mode... done! <a href='?' class='btn btn-sm btn-success'>Reload the page</a>");
			}  
			elseif(isset($_GET['viewcfg']) && $config->EnableSSH)
			{
				echo "<h3>Server Configuration</h3>";
				Ok("Fetching server.cfg ...<br><br>");
				$ssh = new Net_SSH2(IP_SERVER);
				if (!$ssh->login(SERVER_SSH_USER, SERVER_SSH_PSW)) 
	    			exit(No('Host access refused!'));
	    		echo "<textarea rows=18 cols=30 class='form-control' readonly>";
				$File = $ssh->exec('cd '.SERVER_SSH_PATH.'; cat server.cfg'); 
				if($config->ShowRCON) echo $File;
				else
				{
					$Line = preg_split('/\r\n|\r|\n/', $File);
					foreach($Line as $L) 
						if(!(strpos($L, "rcon_password") !== false)) echo $L."\n";
						else echo "*** RCON has been hidden as of SRC configuration ***\n";
					
				}
				echo "</textarea>";
			}  	
			elseif(isset($_GET['viewbans']) && $config->EnableSSH)
			{
				echo "<h3>Server Banlist</h3>";
				Ok("Fetching samp.ban ...<br><br>");
				$ssh = new Net_SSH2(IP_SERVER);
				if (!$ssh->login(SERVER_SSH_USER, SERVER_SSH_PSW)) 
	    			exit(No('Host access refused!'));
	    		echo "<textarea rows=20 cols=30 class='form-control' readonly>";
				echo $ssh->exec('cd '.SERVER_SSH_PATH.'; cat samp.ban'); 
				echo "</textarea>";
			}  	
			elseif(isset($_GET['viewlogs']) && $config->EnableSSH)
			{
				echo "<h3>Server Logs</h3>";
				Ok("Fetching server_logs.txt ...<br><br>");
				$ssh = new Net_SSH2(IP_SERVER);
				if (!$ssh->login(SERVER_SSH_USER, SERVER_SSH_PSW)) 
	    			exit(No('Host access refused!'));
	    		echo "<textarea id='logs' rows=20 class='form-control' readonly>";
				echo $ssh->exec('cd '.SERVER_SSH_PATH.'; cat server_log.txt'); 
				echo "</textarea> 
				<script>var textarea = document.getElementById('logs');
						textarea.scrollTop = textarea.scrollHeight;</script>";
			}  	
			elseif(isset($_GET['resetlogs']) && $config->EnableSSH)
			{
				$ssh = new Net_SSH2(IP_SERVER);
				if (!$ssh->login(SERVER_SSH_USER, SERVER_SSH_PSW)) 
	    			exit(No('Host access refused!'));
				echo $ssh->exec('cd '.SERVER_SSH_PATH.'; rm server_log.txt; touch server_log.txt'); 
				Ok("Server logs cleaned!");
			}  	
			elseif(isset($_GET['hardstop']) && $config->EnableSSH)
			{
				$ssh = new Net_SSH2(IP_SERVER);
				if (!$ssh->login(SERVER_SSH_USER, SERVER_SSH_PSW)) 
	    			exit(No('Host access refused!'));
				$ssh->exec('pkill -f samp03svr'); 
				Ok("Server Process Killed! <a href='?' class='btn btn-sm btn-success'>Reload the page</a>");
			}  	
		}
		elseif($a == "rcon" && $config->EnableRCON)
		{

			$query = new SampRcon(IP_SERVER, PORT_SERVER, RCON_SERVER); 
				if(!$query->connect()) die(No("Connection error. Retry.",1)); 

				$text = $_POST['mex'];

				switch ((int)$_POST['cmd']) 
				{
					case 1:
						$query->call("say {c726e0}[SRC] {FFFFFF}".$text, 1);
						$cmd = "say";
						break;
					case 2:
						if($text == 0 || filter_var($text, FILTER_VALIDATE_INT)) 
							$query->kick($text);
						else 
							die(No("This is not a valid ID, retry.", 1));
						$cmd = "kick";
						break;
					case 3:
						if($text == 0 || filter_var($text, FILTER_VALIDATE_INT)) 
						{ 
							$query->ban($text);
							$query->reloadBans();
						}
						else 
							die(No("This is not a valid ID, retry.", 1));
						$cmd = "ban";
						break;
					case 4:
						if(filter_var($text, FILTER_VALIDATE_IP)) 
						{ 
							$query->banAddress($text);
							$query->reloadBans();
						}
						else 
							die(No("This is not a valid IP, retry.", 1));
						$cmd = "banip";
						break;
					case 5:
						if(filter_var($text, FILTER_VALIDATE_IP)) 
						{ 
							$query->unbanAddress($text);
							$query->reloadBans();
						}
						else 
							die(No("This is not a valid IP, retry.", 1));
						$cmd = "unbanip";
						break;
					case 6:
						$query->setGameModeText($text);
						$cmd = "gamemodetext";
						break;
					case 7:
						$query->setHostName($text);
						$cmd = "hostname";
						break;
					case 8:
						$query->setPassword($text);
						$cmd = "password";
						break;
					case 9:
						$query->removePassword();
						$cmd = "password 0";
						break;
					case 10:
						$query->setURL($text);
						$cmd = "weburl";
						break;
					case 11:
						$query->call("language ".$text, 1);
						$cmd = "language";
						break;
					case 12:
						$query->setMapName($text);
						$cmd = "mapname";
						break;
					default:
						die(No("Command not found."));
						break;
				}

			Ok("RCON command sent: <code>/rcon ".$cmd." ".$text."</code>");
			$query->close(); 		

		}
		elseif($a == "kickPlayer" && $config->EnableRCON)
		{
			$name = $_GET['name'];
			$query = new SampRcon(IP_SERVER, PORT_SERVER, RCON_SERVER); 
			if(!$query->connect()) return "Connection error. Retry."; 
			$query->call("say {c726e0}[KICK-SRC] {FFFFFF} The player $name has been kicked from the server.", 1);
			$query->call("kick $id", 5);  
			$query->close(); 
			Ok("The player <b>$name</b> has been kicked successfully.");		
		}
		elseif($a == "banPlayer" && $config->EnableRCON)
		{
			$name = $_GET['name'];
			$query = new SampRcon(IP_SERVER, PORT_SERVER, RCON_SERVER); 
			if(!$query->connect()) return "Connection error. Retry."; 
			$query->call("say {c726e0}[BAN-SRC] {FFFFFF} The player $name has been banned from the server.", 1);
			$query->call("ban $id", 5); 
			$query->reloadBans(); 
			$query->close();
			Ok("The player <b>$name</b> has been banned successfully.");		
		}					
		elseif($a == "info")
		{

			$query = new SampQuery(IP_SERVER, PORT_SERVER);
	        
	        
	        if ($query->connect()) 
	        { 
	        	echo "<h3>Server information</h3>";

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

	            echo "<br><br><h3>Online players</h3><br>
	            <div class='table-responsive'><table class='table table-border table-striped table-hover table-sm'>
	             <tr class='table-info'>
	                 <th>PlayerID</th>
	                 <th>Nickname</th>
	                 <th>Score</th>
	                 <th>Ping</th>";

	            if($config->EnableRCON) echo "<th>Options</th>"; 

	            echo "
	             </tr>
	            ";
	            $players = $query->getDetailedPlayers();
	            $fieldsnum = $config->EnableRCON ? 5 : 4;

	            if(!count($players))
	            {
	            	echo "<td colspan=$fieldsnum>The server is actually empty or has more than 50 players connected.</td>";
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

		            	if($config->EnableRCON) echo "<td><a href='?a=kickPlayer&id=$id&name=$name' class='badge badge-warning'>Kick</a> <a href='?a=banPlayer&id=$id&name=$name' class='badge badge-danger'>Ban</a></td>";
		            	echo "</tr>";
		            }
	            echo "</table></div><br><br>";

	        } 
	        else 
	            No("The server is not responding! It may be offline.<br>");
	        

	        $query->close(); 
	    

	        echo "<hr>";
	    }

?>