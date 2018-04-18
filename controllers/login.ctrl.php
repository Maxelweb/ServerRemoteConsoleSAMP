<?php

/*
	DO NOT CHANGE!
	---------------------
	SERVER REMOTE CONSOLE
	Login controller file
	developed by Maxel (marianosciacco.it)
*/

	$psw = $_POST['psw'];
	if($psw == SRC_PASSWORD) 
	{
		$_SESSION['src_logged'] = 1; 
		location("index.php");
	}
	else
		echo No("ERROR! Wrong password, try again.");

?>