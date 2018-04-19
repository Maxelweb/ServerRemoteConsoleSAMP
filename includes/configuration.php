<?php

	/*
	 * This is the configuration file. 
	 * Make sure to read everything before make any changes.
	 * 
	 * SERVER REMOTE CONSOLE 
	 * ------------------------------------------------
	 *  	
	 *	EnableRCON activates the following features:
	 		- Kick / Ban players
	 		- Message
	 		- Stop server
	 *
	 *  Requirement: YOU NEED THE RCON SERVER PASSWORD TO ENABLE THIS FEATURE	
	 *	
	 *  ---------------------------------
	 *
	 *	EnableSSH activates the following features:
	 		- view / reset server logs
			- Start server
	 *
	 *  Requirement: YOU NEED SSH ACCESS WITH SA-MP FOLDER PERMISSIONS TO ENABLE THIS FEATURE		
	 *
	 *  ---------------------------------
	 *
	 *  EnableSRCPassword is used to enable / disable password protected area to this console.
	   		[IMPORTANT] 
	   			It is strongly recommended to change it only if BOTH EnableSSH and EnableRCON are disabled, because the entire console would be visible to guests.
	 *
	 *
	 *  ---------------------------------
	*/


	$CONFIG = 	array  // Change this section with [0 / 1]
				(
						"ShowRCON" 			=> 1 , // (Show / hide) RCON password from infomation bar at the top
						"EnableRCON" 		=> 1 , 
						"EnableSSH" 		=> 1 , 	 
						"EnableSRCPassword" => 1 	// READ ABOVE BEFORE CHANGING THIS!
				);


	

	define(SRC_PASSWORD, "getsomecoffee"); // Insert ServerConsole password
	define(IP_SERVER, "127.0.0.1"); // Insert server IP
	define(PORT_SERVER, "7777"); // Insert server port (DEFAULT: 7777)
	define(RCON_SERVER, "changeme"); // Insert RCON password

	define(SERVER_SSH_USER, "user"); // Insert your SSH user to login your VPS / Dedicated server
	define(SERVER_SSH_PSW, "sshpassword"); // Insert your SSH password to login your VPS / Dedicated server
	define(SERVER_SSH_PATH, "path/to/samp03/"); // Insert path to samp-server file with final "/"







	// ====== DO NOT CHANGE AFTER THIS LINE =====

	$a = (isset($_GET['a'])) ? $_GET['a'] : "";
	$id = (isset($_GET['id'])) ? (int)$_GET['id'] : 0;
	$session = (isset($_SESSION['src_logged'])) ? 1 : 0;
	$version = "1.0-beta";
	// $TITLE = "SA-MP Server"; // Change this with your sa-mp server name

?>

