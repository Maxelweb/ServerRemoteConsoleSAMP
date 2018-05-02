<?php

/*
 *
 *  SERVER REMOTE CONSOLE
 *  Controller - Settings 
 *  
 *  Developed by Maxel (marianosciacco.it)
 *  Github - src.debug.ovh
 *
 */

if($a == "emergency-block")
{
	$emergencyFile = fopen("emergency.lock", "w+") or die($errorPermissions);
	fclose($emergencyFile);

	if($emergencyFile)
	{
		location("index.php");
	}
}
elseif($a == "edit-general")
{

	//$srcon = (int)$_POST['srcon'];
	//$ercon = (int)$_POST['ercon'];
	//$essh = (int)$_POST['essh'];
	$gpage = (int)$_POST['gpage'];

	$srcon = $config->ShowRCON;
	$ercon = $config->EnableRCON;
	$essh = $config->EnableSSH;

		
	$modesFile = fopen("./includes/Config/modes.config.php", "w+") or die($errorPermissions);

	$newModes = '
<?php

// THIS IS AN AUTO-GENERATED FILE. DON\'T EDIT! 
//  -- SERVER REMOTE CONSOLE MODES --

$config =  (object) array 
	(
		"ShowRCON" 			=> '.$srcon.' ,
		"EnableGuestPage"	=> '.$gpage.' ,
		"EnableRCON" 		=> '.$ercon.' , 
		"EnableSSH" 		=> '.$essh.' 
	);
?>';

	fwrite($modesFile, $newModes);
	fclose($modesFile);

	if($modesFile)
	{
		Ok("Changes to General settings have been applied successfully. <a href='?settings'>Reload page.</a>");
	}
}
elseif($a == "edit-gpage" && $config->EnableGuestPage)
{	
	$gname = str_replace('"', '\"',$_POST['gname']);
	$gusers = (int)$_POST['gusers'];
	$gstatus = (int)$_POST['gstatus'];

	if(!Regex($gname) || strlen($gname) > 32)
		No("Only letters, numbers, spaces and underscores are allowed. Requested length: 1-24 characters.");
	else
	{

		$modesFile = fopen("./includes/Config/guestpage.config.php", "w+") or die($errorPermissions);

		$newModes = '
<?php

// THIS IS AN AUTO-GENERATED FILE. DON\'T EDIT! 
//  -- SERVER REMOTE CONSOLE GUEST PAGE --

$gpage =  (object) array 
	(
		"ServerName" 		=> "'.$gname.'" ,
		"ShowPlayersList"	=> '.$gusers.' ,
		"EnableStatus" 		=> '.$gstatus.' 
	);
?>';

		fwrite($modesFile, $newModes);
		fclose($modesFile);

		if($modesFile)
		{
			Ok("Changes to Guest Page have been applied successfully. <a href='?settings'>Reload page.</a>");
		}
		else
			No("Unexpected error.");
	}
}


?>