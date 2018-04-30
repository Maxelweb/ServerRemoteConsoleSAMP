<?php

/*
 *	DO NOT CHANGE!
 *  ---------------------------------------
 *
 *  SERVER REMOTE CONSOLE
 *  Include - Functions Processing
 *  
 *  Developed by Maxel (marianosciacco.it)
 *  Github - src.debug.ovh
 *
 * 	---------------------------------
 *	This is not the configuration file.
 *  To restart the installation REMOVE installed.lock FROM root folder.
 *  To change MANUALLY some parameters, you have to edit parameters.config.php and modes.config.php in < Config/ > folder
 *  ---------------------------------
*/

	if(file_exists("emergency.lock"))
	{
		header("location: locked.php");
	}
	elseif(file_exists("installed.lock"))
	{
		require_once("Config/parameters.config.php");
		require_once("Config/modes.config.php");
		require_once("Config/guestpage.config.php");
	}
	else
	{
		header("location: install.php");
	}
?>

