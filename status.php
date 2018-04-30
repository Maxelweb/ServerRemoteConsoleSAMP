<?php

/*
 *
 *  SERVER REMOTE CONSOLE
 *  Model - Status / Guest page
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
	require("includes/Class/QueryServer.class.php");
	require("includes/Class/Bulletins.class.php");
	require('includes/configuration.php');
	require('includes/environment.php');
	require('includes/functions.php');


/*
 *	Main Body	
 *
 */


	require("views/header.view.php");
	
	if(!$config->EnableGuestPage)
	{
		location("login.php");
	}
	else
	{

		try {
 
			$query = new QueryServer(IP_SERVER, PORT_SERVER);
	   
	    	$Info = $query->GetInfo();
	    	$Rules = $query->GetRules();

	    	if(empty($Rules)) location("?id=".$id);

	    	$sStatus = 1; 
	    	$ServerStatus = "ONLINE";
	    	list($sPassword, $sPlayers, $sMaxPlayers, $sHostname, $sGamemode) = ConvertArray($Info);
	    	list($sLagComp, $sMap, $sVersion, $sWeather, $sUrl, $sWorldTime) = ConvertArray($Rules);
	    	$sDesc = "The server is up and running. ";
	    	$sDesc .= ($sPassword) ? " <b>However, you need a password to join it.</b>" : "You can join the server without any restriction.";
	    	$sColor = ($sPassword) ? "warning text-dark" : "success";
	    	$sIcon = ($sPassword) ? "lock" : "check";

	    	$sTotPlayers = "$sPlayers / $sMaxPlayers";

	    	if($sPlayers>50)
	    	{
	    		$PlayerBlock = "<div class='card-body'><p class='card-text'>The server has more than 50 players online <i class='far fa-smile'></i>. <br>For technical limitation the players' list won't be shown.</p></div>";
	    	}
	    	else
	    	{

		        $players = $query->GetPlayers();

		        if(!count($players))
		        {
		        	$PlayerBlock = "<div class='card-body'><p class='card-text'>The server is actually empty <i class='far fa-frown'></i></p></div>";
		        } 
		        else
		        {

		           	$PlayerBlock = "<ul class='list-group list-group-flush PlayersList'>";
			        foreach($players as $key => $pDetails)
			       	{
			            	
			            $pInfo = ConvertArray($pDetails);
			            list($pUsername, $pScore) = $pInfo;

			            $PlayerBlock .= "<li class='list-group-item d-flex justify-content-between align-items-center'> ";
			            $PlayerBlock .= "$pUsername <span class='badge badge-info badge-pill'>$pScore</span>";
			            $PlayerBlock .= "</li>";
			        }
			        $PlayerBlock .= "</ul>";
			    }
			}


	    $query->Close(); 

		} catch(QueryServerException $e) {

		   $sStatus = 0; 
		   $ServerStatus = "OFFLINE";
	       $sIcon = "times";
	       $sColor = "danger";
	       $sDesc = "The server is not responding, it may be offline or it has several players connected thus leading to connection issues. <br><br> <a href='?' class='btn btn-dark btn-block'>Retry to connect</a>";	
	       // <br> <b>Error:</b> ".$e->toString()."	    
		}


	    // This is the number of bulletins showed, base 7 * x, 
	    // where x is the value selected in the <Select> form.
		// Keep it under 30 to avoid long loading issues

	    $Bulletins = new Status();
	    $id = ($id>4 || $id<0) ? 4 : $id; 
	    $Days = ($id+1)*7;

		require("views/guestpage.view.php");
			
	}


	require("views/footer.view.php");

?>
