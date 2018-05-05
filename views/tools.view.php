<?php
/*
 *
 *  SERVER REMOTE CONSOLE
 *  View - Toolsbar
 *  
 *  Developed by Maxel (marianosciacco.it)
 *  Github - src.debug.ovh
 *
 */
?>

<?php

$button = !$status ? 
			(($config->EnableSSH) ? 
				'<div class="dropdown">
				  <button type="button" class="btn btn-sm btn-success dropdown-toggle" id="ServerStart" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    <i class="fa fa-play"></i> Start Server</button>
				  </button>
				  <div class="dropdown-menu" aria-labelledby="ServerStart">
				  	<h6 class="dropdown-header">Choose an action</h6>
				    <button class="dropdown-item" type="submit" name="start" value="1">Normal start</button>
				    <button class="dropdown-item text-success" type="submit" name="forcestart" value="1">Force start</button>
				  </div>
				</div>' : "")
	      : (($config->EnableRCON) ? 
	    		"<button type='submit' name='stop' value=1 class='btn btn-sm btn-danger'><i class='fa fa-stop'></i> Stop Server</button>" : "");  

?>



<div class="jumbotron p-4">

	<form method='POST' action='?a=control'>
		<nav class="navbar navbar-dark bg-dark navbar-expand-lg">		
		  	<span class="navbar-brand mb-0 h1"><i class="fa fa-server"></i> Options</span>
		  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#Options" aria-controls="Options" aria-expanded="false" aria-label="Toggle navigation">
			    <span class="navbar-toggler-icon"></span>
			  </button>

			<div class="collapse navbar-collapse" id="Options">
			    <ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a href='?a=info' class="nav-link"><i class='fa fa-users'></i> Info and players</a>
					</li>
					<?php if($config->EnableSSH) {?>
					<li class="nav-item dropdown">
						<a class="dropdown-toggle nav-link" href="#" role="button" id="ddLogs"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						   <i class='fa fa-list-ul'></i> Logs & Banlist
						</a>
						<div class="dropdown-menu" aria-labelledby="ddLogs">
							<a href="?a=control&viewlogs" class="dropdown-item"><i class='fa fa-eye'></i> View server logs</a> 
							<a href="?a=control&viewcfg" class="dropdown-item"><i class='fa fa-wrench'></i> View server configuration</a> 
							<a href="?a=control&viewbans" class="dropdown-item"><i class='fa fa-ban'></i> View banlist</a> 
							<a href="?a=control&resetlogs" class="dropdown-item"><i class='fa fa-redo-alt'></i> Reset server logs</a>
						</div>
					</li>
					<?php } ?>
					<?php if($config->EnableRCON || $config->EnableSSH) {?>
					<li class="nav-item dropdown">
						<a class="dropdown-toggle nav-link" href="#" role="button" id="ddActions"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						   <i class='fa fa-location-arrow'></i> Server Actions
						</a>
						<div class="dropdown-menu" aria-labelledby="ddActions">
							<?php if($config->EnableRCON) {?>
							<a href="?a=control&gmx" class="dropdown-item text-danger"><i class='fa fa-redo-alt'></i> Restart / Next Gamemode</a>
							<?php } if($config->EnableSSH) {?>
							<a href="?a=control&hardstop" onclick="return confirm('You\'re gonna kill all current sa-mp server running in your server. Proceed?')" class="dropdown-item text-danger"><i class='fa fa-stop'></i> Hard Server Stop (Kill Process)</a>
							<?php } ?>
						</div>
					</li>
					<?php } ?>	
					<?php if($config->EnableGuestPage) {?>
					<li class="nav-item">
						<a href='?bulletins' class="nav-link"><i class='far fa-newspaper'></i> Bulletins Management</a>
					</li>
					<?php } ?>	
				</ul>
				<span class="navbar-text">
					<?=$button;?>	
				</span>
			</div>	
		</nav>
	</form> 

	<div class='table-responsive'>
		<table class="table main_table">
			<tbody>
				<tr class="table-light">
					<td class="w-50">Server IP:</td> 
					<td class="w-50"><code><?=IP_SERVER.":".PORT_SERVER;?></code></td>
				</tr>
				<?php if($config->ShowRCON) { ?>
				<tr class="table-light">
					<td>Server RCON password:</td> 
					<td><code><?=RCON_SERVER;?></code></td>
				</tr>
				<?php } ?>
				<tr class="table-light">
					<td>Status:</td> 
					<td><?=$statusMessage;?></td>
				</tr>
			</tbody>
		</table>
	</div>

	<?php if($config->EnableRCON) {?>
	<form method='POST' action='?a=rcon' class='form-inline mt-3'>
		<div class="input-group my-3">
			<div class="input-group-prepend">
			  <span class="input-group-text"><code>/rcon </code></span>
			</div>
			<select class="custom-select" name="cmd">
				<option value="1">Say [message]</option>
				<option value="2">Kick [playerid]</option>
				<option value="3">Ban [playerid]</option>
				<option value="4">BanIP [ip]</option>
				<option value="5">UnBanIP [ip]</option>
				<option value="6">(Set) GamemodeText [text]</option>
				<option value="7">(Set) Hostname [text]</option>
				<option value="8">(Set) Password [text]</option>
				<option value="9">(Remove) Password</option>
				<option value="10">(Set) Weburl [url]</option>
				<option value="11">(Set) Language [text]</option>	
				<option value="12">(Set) Mapname [text]</option>	
			</select>
		</div>
		<input type='text' class='form-control' placeholder='Enter the second part of the rcon command, like the message or the playerid' name='mex' style='width: 82%; margin-right: 15px;'>
		<button type='submit' class='btn btn-info btn-xs' name='smex' value="1">Send command <i class='fa fa-pen-square'></i> </button>
	</form>  

	<?php } ?>	

</div> 