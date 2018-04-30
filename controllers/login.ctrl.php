<?php

/*
 *
 *  SERVER REMOTE CONSOLE
 *  Controller - Login
 *  
 *  Developed by Maxel (marianosciacco.it)
 *  Github - src.debug.ovh
 *
 */


	if($_SESSION['src_login_wait'] > time())
		No("Your access has been blocked. You must wait 5 minutes to continue.");
	else
	{
	
		$psw = $_POST['psw'];
		if($psw == SRC_PASSWORD) 
		{
			$_SESSION['src_logged'] = 1; 
			unset($_SESSION['src_login_tried']);
			unset($_SESSION['src_login_wait']);
			location("index.php?updates");
		}
		else
		{
			if(!isset($_SESSION['src_login_tried']))
				$_SESSION['src_login_tried'] = 1;
			
			if($_SESSION['src_login_tried'] == 5)
			{
				$_SESSION['src_login_tried'] = 1;
				$_SESSION['src_login_wait'] = time()+300;
				No("Your access has been blocked. You must wait 5 minutes to continue.");
			}
			else
			{ 
				echo No("ERROR! Wrong password, try again. ".($_SESSION['src_login_tried'])."/5 attempts.");
				$_SESSION['src_login_tried'] += 1;
			}
		}
	}

	echo "<br><br>";

?>