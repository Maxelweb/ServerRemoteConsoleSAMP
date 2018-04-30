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
 */


	$a = (isset($_GET['a'])) ? $_GET['a'] : "";
	$id = (isset($_GET['id'])) ? (int)$_GET['id'] : 0;
	$session = (isset($_SESSION['src_logged'])) ? 1 : 0;
	$version = "1.1";
	$GithubRepo = "https://github.com/Maxelweb/ServerRemoteConsoleSAMP";
	$lastupdate = "2018-05-01";
	$errorPermissions = "An error has occured while trying to create an auto-generated config file. Please, make sure to have all necessary permissions in <code>./includes/Config/</code> folder";
	@define(BULL_FOLDER, "./store/");
	@define(BULL_EXTENSION, ".txt");



?>
