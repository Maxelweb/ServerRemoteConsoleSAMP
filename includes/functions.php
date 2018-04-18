<?php 

/*
	DO NOT CHANGE!
	---------------------
	SERVER REMOTE CONSOLE
	Functions file
	developed by Maxel (marianosciacco.it)
*/


function location($url)
{
	echo "<script>location.replace('$url');</script>";
}


function Ok($mex, $echo=0)
{
	$x = "<font color=green><i class='fa fa-check'></i> <b>$mex</b></font>";
	if(!$echo) echo $x;
	else return $x;
}

function No($mex, $echo=0)
{
	$x = "<font color=darkred><i class='fa fa-exclamation-triangle'></i> <b>$mex</b></font>";
	if(!$echo) echo $x;
	else return $x;
}



?>
