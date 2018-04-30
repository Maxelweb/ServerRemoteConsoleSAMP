<?php 

/*
 *
 *  SERVER REMOTE CONSOLE
 *  Include - Functions Processing
 *  
 *  Developed by Maxel (marianosciacco.it)
 *  Github - src.debug.ovh
 *
 */


/*
 *	 General functions
 */


function location($url)
{
	echo "<script>location.replace('$url');</script>";
}

function CleanFileExt($file)
{
	$ex = explode(".", $file);
	return $ex[0];
}

function ConvertArray($arr)
{
	$pInfo = array(); 
	foreach($arr as $key => $info) 
		array_push($pInfo, $info);
	return $pInfo;
}

function Regex($value, $type=0)
{
	if($type==1) 		$reg = "/^[a-zA-Z0-9\s]+$/";  // only letters, numbers and spaces
	elseif($type==2) 	$reg = "/^[a-zA-Z0-9]+$/";   // only letters and numbers
	elseif($type==3) 	$reg = "/^[0-9]+$/";		 // only numbers
	elseif($type==4) 	$reg = "/^[a-zA-Z]+$/";	     // only letters
	elseif($type==5) 	$reg = "/^[a-zA-Z_]+$/";	 // only letters and underscore
	elseif($type==6) 	$reg = "/^[a-zA-Z\s]+$/";	 // only letters and spaces
	elseif($type==7)	$reg = "/^[a-z][a-z0-9\.,\-_]{5,31}$/i"; // Skype
	elseif($type==8) 	$reg = "/^[a-zA-Z0-9_-]+$/";	 // only letters, numbers dashes and underscore
	elseif($type==9) 	$reg = "/^[^\s]+\/$/";	 // No spaces allowed
	else				$reg = "/^[a-zA-Z0-9\s_-]+$/"; // only letters, numbers, spaces dashes and underscores
	return preg_match($reg, $value);
}


/*
 *	 Messages / Alerts functions
 */


function Ok($mex, $asreturn=0, $notime=0)
{
	$time = $notime ? "" : "<small>(".date('H:i:s').")</small>"; 
	$x = "<span class='text-success'><i class='fa fa-check'></i> $time <b>$mex</b></span>";
	if(!$asreturn) echo $x; else return $x;
}

function No($mex, $asreturn=0, $notime=1)
{
	$time = $notime ? "" : "<small>(".date('H:i:s').")</small>"; 
	$x = "<span class='text-danger'><i class='fa fa-times'></i> $time <b>$mex</b></span>";
	if(!$asreturn) echo $x; else return $x;
}

function Alert($mex, $asreturn=0, $notime=1)
{
	$time = $notime ? "" : "<small>(".date('H:i:s').")</small>"; 
	$x = "<span class='text-warning'><i class='fa fa-exclamation-triangle'></i> $time <b>$mex</b></span>";
	if(!$asreturn) echo $x; else return $x;
}


/*
 *	 Priorities functions
 */


function Priority($priority)
{
    switch ($priority) 
    {
        case 1:
            return "<span class='badge badge-primary'><i class='fa fa-thumbtack'></i> Announcement</span>";
            break;
        case 2: 
            return "<span class='badge badge-info'><i class='fa fa-edit'></i> Changelog</span>";
            break;
        case 3: 
            return "<span class='badge badge-danger'><i class='fa fa-exclamation-triangle'></i> General Maintenance</span>";
            break;
        default:
            return "<span class='badge badge-secondary'><i class='fa fa-info-circle'></i> Status update</span>";
            break;
    }
}

function ShowPriority($equals)
{
	if($equals > 3) $equals == 0;

	for($i=0; $i<4; $i++)
		{
			echo '<div class="form-check form-check-inline">';
			if($i == $equals) 
				echo "<input class='form-check-input' name='priority' checked type='radio' value='".$i."'>";
			else 
				echo "<input class='form-check-input' name='priority' type='radio' value='".$i."'>";
			echo '<label class="form-check-label"> '.Priority($i).' </label>';
			echo "</div>";
		}
}


?>
