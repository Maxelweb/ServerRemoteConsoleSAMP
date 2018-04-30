<?php

/*
 *
 *  SERVER REMOTE CONSOLE
 *  Model - Login Area
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
		if($a == "login") 
			require("controllers/login.ctrl.php");

		require("views/login.view.php");

	}
	else 
	{
		location("index.php");
	}


	require("views/footer.view.php");

?>
