<!DOCTYPE html>
<html lang="en">
<head>
  	<title>Server Remote Console <?=$version?> | SA-MP </title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="styles/server_console.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
</head>
<body>

<div class="container main_container p-2">                             
    <div class="page">
    	<div class="row">
    		<div class="col-md-3">
    			<a href="?">
    				<img src="styles/images/samp_logo.png" class="logo">
    			</a>
    		</div>
    		<div class="col-md-9">
    			<h1 class="my-4">Server Remote Console <small><span class="badge badge-info"><?=$version;?></span></small></h1>
    		</div>
    	</div>
		<?php if($CONFIG['EnableSRCPassword']) { ?>
		<p class="text-right text-info">
			<a href='?a=logout'>
				<i class="fa fa-sign-out-alt"></i> Logout
			</a>
		</p>
		<?php } ?>

