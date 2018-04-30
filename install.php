<?php

/*
 *
 *  SERVER REMOTE CONSOLE
 *  Model - Installation wizard
 *  
 *  Developed by Maxel (marianosciacco.it)
 *  Github - src.debug.ovh
 *
 */



/*
 *	Main configurations and functions files
 *	
 */

	error_reporting(E_ERROR);
	set_include_path(get_include_path() . PATH_SEPARATOR . 'resources'); 
	include('Net/SSH2.php');	
	require('includes/environment.php');
	require('includes/functions.php');

/*
 *	Main Body	
 *
 */

	require("views/header.view.php");
	
	$IsInstalled = fopen("installed.lock", "r");

	if($IsInstalled)
	{
		echo "<br>";
		Ok("The Server Remote Console has been successfully installed. Please, <a href='login.php'>click here</a> to continue.");
	}
	else
	{	

		if(file_exists("./includes/Config/modes.config.php") && file_exists("./includes/Config/parameters.config.php"))
		{
			include("./includes/Config/modes.config.php");
			include("./includes/Config/parameters.config.php");
			
			//$srcp = SRC_PASSWORD;
			$ips = IP_SERVER;
			$port = PORT_SERVER;
			//$rcon = RCON_SERVER;
			$user = SERVER_SSH_USER;
			//$pass = SERVER_SSH_PSW;
			$path = SERVER_SSH_PATH;
			/*$ercon = $config->EnableRCON;
			$essh = $config->EnableSSH;
			$srcon = $config->ShowRCON;*/
		}
		else
		{
			list($ips, $port, $user, $path, $ercon, $essh, $srcon) = array("","7777","","",0,0,0);
		}

		if(!empty($a))
			require("controllers/installation.ctrl.php");

		require("views/installation.view.php");
	}

	require("views/footer.view.php");

?>
