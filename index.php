<?php

/*
	SERVER REMOTE CONSOLE
	MADE BY Maxel (marianosciacco.it)

	Useful Libs:

		SA_MP API 		http://forum.sa-mp.com/showthread.php?t=355574

*/



/*
 *	Libs and important stuff
 *	
 */
	error_reporting(E_ERROR);
	set_include_path(get_include_path() . PATH_SEPARATOR . 'resources'); 
	include('Net/SSH2.php');
	require("resources/Class/SampQuery.class.php");
	require("resources/Class/SampRcon.class.php");

/*
 *	Main configurations and functions files
 *	
 */
	
	session_start();

	require('includes/configuration.php');
	require('includes/functions.php');


/*
 *	Main Body	
 *
 */


	require("views/header.view.php");
	

	if(!isset($_SESSION['src_logged']) && $CONFIG['EnableSRCPassword'])
	{
		if($a == "login") 
			require("controllers/login.ctrl.php");

		require("views/login.view.php");

	}
	elseif((isset($_SESSION['src_logged']) && $CONFIG['EnableSRCPassword']) || !$CONFIG['EnableSRCPassword']) 
	{

		$server = new SampQuery(IP_SERVER, PORT_SERVER);
	    $status = ($server->connect()) ? 1 : 0;
	    $statusMessage = $status ? Ok("Online", 1) : No("Offline", 1);
	    

	    require("views/tools.view.php");

	    if($a != "" || (!$CONFIG['EnableSRCPassword'] && !$CONFIG['EnableSSH'] && !$CONFIG['EnableRCON']))
	    {
	    	require("controllers/actions-logged.ctrl.php");
	    }
	}


	require("views/footer.view.php");

?>
