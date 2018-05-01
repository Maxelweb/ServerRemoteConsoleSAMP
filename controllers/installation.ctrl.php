<?php

/*
 *
 *  SERVER REMOTE CONSOLE
 *  Controller - Installation wizard
 *  
 *  Developed by Maxel (marianosciacco.it)
 *  Github - src.debug.ovh
 *
 */

	$srcp = $_POST['srcp'];
	$ips = $_POST['ips'];
	$port = (int)$_POST['port'];
	$rcon = $_POST['rcon'];
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	$path = $_POST['path'];


	$ercon = (int)$_POST['ercon'];
	$essh = (int)$_POST['essh'];
	$srcon = (int)$_POST['srcon'];


	if(!Regex($srcp, 8) || strlen($srcp) > 32 || strlen($srcp) < 5)
		No("Only letters, numbers, dash and underscores are permitted as SRC Password. Requested length: 4-32 characters.");
	elseif(!filter_var($ips, FILTER_VALIDATE_IP)) 
		No("The IP inserted is not in a valid format. Retry.");
	elseif(strlen($port) != 4)
		No("Invalid Port. Please insert 4 numbers. Default sa-mp port: <code>7777</code>");
	elseif($srcon && !$ercon)
		No("RCON password must be enabled to activate <code>Show RCON password in protected area</code>");
	elseif(!Regex($path, 9) && $essh)
		No("The path inserted is invalid. Do not use spaces and don't forget the ending slash <code>/</code>. Retry.");
	else
	{

		echo "Starting configuration, please wait...<br>";

		if($ercon)
		{
			$query = new SampRcon($ips, $port, $rcon); 
				if(!$query->connect()) 
					die(No("Connection error. Retry.",1));
				
				if(count($query->getCommandList()) <= 1) // if invalid, returns one element with error message
					exit(No("RCON password - The RCON is invalid, please insert a valid RCON to continue."));
				else
					Ok("RCON password - Accepted.<br>");
		}

		if($essh)
		{
			$ssh = new Net_SSH2($ips);
				if (!$ssh->login($user, $pass)) 
	    			exit(No('SSH access - Login incorrect. Please, retry.'));
	    		else
	    		{
	    			if(trim($ssh->exec('find '.$path.'samp03svr')) != $path."samp03svr")
	    				exit(No("SSH access - Login correct, but <u>invalid server path</u>. The path should contains the <code>samp03svr</code> execution file as well as the basic SA-MP files and folders."));
	    			else
	    				Ok('SSH access - Done. <br>');
	    		}
		}



		$rcon = str_replace('"', '\"', $rcon);
		$pass = str_replace('"', '\"', $pass);


		$configFile = fopen("./includes/Config/parameters.config.php", "w+") or die($errorPermissions);

		$newConfig = "";

		fwrite($configFile, $newConfig);

		$newConfig = '
<?php

// THIS IS AN AUTO-GENERATED FILE. BEFORE EDITING, VIEW THE DOCUMENTATION! 
//  -- SERVER REMOTE CONSOLE CONFIG_PARAMETERS --

@define(SRC_PASSWORD, "'.$srcp.'"); 
@define(IP_SERVER, "'.$ips.'"); 
@define(PORT_SERVER, "'.$port.'"); 
@define(RCON_SERVER, "'.$rcon.'");
@define(SERVER_SSH_USER, "'.$user.'"); 
@define(SERVER_SSH_PSW, "'.$pass.'");
@define(SERVER_SSH_PATH, "'.$path.'"); 

?> ';

		fwrite($configFile, $newConfig);
		fclose($configFile);


		$modesFile = fopen("./includes/Config/modes.config.php", "w+") or die($errorPermissions);

		$newModes = '
<?php

// THIS IS AN AUTO-GENERATED FILE. DON\'T EDIT! 
//  -- SERVER REMOTE CONSOLE MODES --

$config =  (object) array 
	(
		"ShowRCON" 			=> '.$srcon.' ,
		"EnableGuestPage"	=> 1 ,
		"EnableRCON" 		=> '.$ercon.' , 
		"EnableSSH" 		=> '.$essh.' 
	);
?>';

		fwrite($modesFile, $newModes);
		fclose($modesFile);


	if(file_exists("includes/Config/guestpage.config.php"))
	{
		$gpageFile = 1;
	}
	else
	{
		$gpageFile = fopen("./includes/Config/guestpage.config.php", "w+") or die($errorPermissions);

		$newGpage = '
<?php

// THIS IS AN AUTO-GENERATED FILE. DON\'T EDIT! 
//  -- SERVER REMOTE CONSOLE GUEST PAGE --

$gpage =  (object) array 
	(
		"ServerName" 		=> "Server Tracker" ,
		"ShowPlayersList"	=> 1 ,
		"EnableStatus" 		=> 1 
	);
?>';

		fwrite($gpageFile, $newGpage);
		fclose($gpageFile);

	}

		if($newConfig && $modesFile && $gpageFile)
		{
			$lock = fopen("installed.lock", "x");
			if($lock) Ok("Configuration completed! Wait..");
			else die($errorPermissions);
			sleep(1);
			location("install.php");
		}
		else
		{
			No("Unexpected error.");
		}
	}


?>