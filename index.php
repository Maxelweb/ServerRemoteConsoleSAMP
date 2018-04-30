<?php

/*
 *
 *  SERVER REMOTE CONSOLE
 *  Model - Index of protected area
 *  
 *  Developed by Maxel (marianosciacco.it)
 *  Github - src.debug.ovh
 *
 */


/*
 *	Libs and important stuff
 *	
 */
	error_reporting(E_ERROR);
	set_include_path(get_include_path() . PATH_SEPARATOR . 'resources'); 
	include('Net/SSH2.php');
	require("includes/Class/SampQuery.class.php");
	require("includes/Class/SampRcon.class.php");
	require("includes/Class/Bulletins.class.php");

/*
 *	Main configurations and functions files
 *	
 */
	
	session_start();

	require('includes/configuration.php');
	require('includes/environment.php');
	require('includes/functions.php');


/*
 *	Main Body	
 *
 */

	require("views/header.view.php");
	

	if(!isset($_SESSION['src_logged']))
	{
		if($config->EnableGuestPage) 
			location("status.php");
		else 
			location("login.php");
	}
	else
	{

		if(isset($_GET['updates']))
		{
			require("controllers/updates.ctrl.php");
		}


		if(isset($_GET['settings']))
		{
			if($a != "")
				require("controllers/settings.ctrl.php");
			require("views/settings.view.php");
		}
		elseif(isset($_GET['bulletins']))
		{
			
			$f = !isset($_GET['file']) ? "" : $_GET['file'];
			$ord = isset($_GET['ord']) && $_GET['ord']<4 ? $_GET['ord'] : 0;

			if($a != "")
				require("controllers/bulletins.ctrl.php");
			require("views/bulletins.view.php");
		}
		else
		{
			$server = new SampQuery(IP_SERVER, PORT_SERVER);
		    $status = ($server->connect()) ? 1 : 0;
		    $statusMessage = $status ? Ok("Online", 1, 1) : No("Offline", 1, 1);
		    
		    require("views/tools.view.php");

		    if(!empty($a))
	    	{
	    		require("controllers/server-actions.ctrl.php");
	    	}
		}
	}


	require("views/footer.view.php");

?>
