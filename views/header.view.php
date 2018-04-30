<?php
/*
 *
 *  SERVER REMOTE CONSOLE
 *  View - Header (General)
 *  
 *  Developed by Maxel (marianosciacco.it)
 *  Github - src.debug.ovh
 *
 */
?>


<!DOCTYPE html>
<html lang="en">
<head> 
  	<title>Server Remote Console <?=$version?> | SA-MP </title>
    <link rel="shortcut icon" type="image/png" href="./styles/images/favicon.png">
    <meta charset="UTF-8">
    <meta name="description" content="Server Remote Console and Status tracker for SA-MP servers.">
    <meta name="keywords" content="Console,StatusTracker,SA-MP,Server,Bulletins,San,Andreas,Multiplayer,SRC">
    <meta name="author" content="Maxel (Mariano Sciacco)">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- [CSS] Bootstrap 4.0, Personal Style fixes based on Bootstrap 4.0, Fontawesome for icons -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="styles/server_console.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

    <!-- [Javascript] Bootstrap 4.0, Jquery 3.2.1, Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>

<div class="container main_container p-2">                             
    <div class="page">
    	<div class="row mt-1 mb-3">
    		<div class="col-md-3">
    			<a href="?">
    				<img src="./styles/images/samp_logo.png" class="logo">
    			</a>

    		</div>
    		<div class="col-md-9 header">
    			<h1>
                    Server Remote Console 
                    <img src="./styles/images/favicon.png">&nbsp;
                    <small><span class="badge badge-info"><?=$version;?></span></small>
                </h1>   

                <?php if(isset($_SESSION['src_logged'])) { ?>
                <p>
                <?php if(@$config->EnableGuestPage) { ?>
                    <a href='status.php'>
                        <i class="fa fa-user"></i> Guest Page
                    </a> &nbsp;
                <?php  } ?>
                    <a href='?settings'>
                        <i class="fa fa-cog"></i> Settings
                    </a> &nbsp;
                    <a href='?a=logout'>
                        <i class="fa fa-sign-out-alt"></i> Logout
                    </a>
                </p>
                <?php }else{  ?> 
                <p>
                    <a href='login.php'>
                        <i class="fa fa-sign-in-alt"></i> Go to the Protected Area
                    </a>
                </p>
                <?php } ?>             
            </div>
    	</div>      

