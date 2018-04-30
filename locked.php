<?php

/*
 *
 *  SERVER REMOTE CONSOLE
 *  Model - Locked area
 *  
 *  Developed by Maxel (marianosciacco.it)
 *  Github - src.debug.ovh
 *
 */

	error_reporting(E_ERROR);

/*
 *	Main configurations and functions files
 *	
 */

	require('includes/environment.php');


/*
 *	Main Body	
 *
 */


	require("views/header.view.php");
	

	if(file_exists("emergency.lock"))
	{
		require("views/emergency.view.php");
	}
	else 
	{
		header("location:index.php");
	}


	require("views/footer.view.php");

?>
