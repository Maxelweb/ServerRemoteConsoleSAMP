


<?php

$button = !$status ? 
			(($CONFIG['EnableSSH']) ? 
				"<button type='submit' name='start' value=1 class='btn btn-sm btn-success'><i class='fa fa-play'></i> Start Server</button>" : "")
	      : (($CONFIG['EnableRCON']) ? 
	    		"<button type='submit' name='stop' value=1 class='btn btn-sm btn-danger'><i class='fa fa-stop'></i> Stop Server</button>" : "");  

?>

<div class="jumbotron p-4">

	<form method='POST' action='?a=control'>
		<nav class="navbar navbar-light bg-light">
		  	<span class="navbar-brand mb-0 h1">Options</span>
			<a href='?a=info' class='btn btn-sm btn-primary'><i class='fa fa-list-ul'></i> Info and players</a>
			<?php if($CONFIG['EnableRCON']) {?>
				<button type="submit" name="gmx" class='btn btn-sm btn-info' value="1"><i class='fa fa-redo-alt'></i> Restart / Next Gamemode</button>
			<?php } ?>	
			<?=$button;?>	
			<?php if($CONFIG['EnableSSH']) {?>
				<button type="submit" name="viewlogs" class='btn btn-sm btn-default' value="1"><i class='fa fa-server'></i> View server logs</button> 
				<button type="submit" name="resetlogs" class='btn btn-sm btn-warning' value="1"><i class='fa fa-redo-alt'></i> Reset server logs</button>
			<?php } ?>
		</nav>
	</form> 

	<table class="table main_table">
		<tbody>
			<tr class="table-light">
				<td class="w-50">Server IP:</td> 
				<td class="w-50"><code><?=IP_SERVER.":".PORT_SERVER;?></code></td>
			</tr>
			<?php if($CONFIG['ShowRCON']) { ?>
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

	<?php if($CONFIG['EnableSSH']) {?>
	<form method='POST' action='?a=sendmex' class='form-inline mt-3'>
		<input type='text' class='form-control' placeholder='Write a message to send to everyone in the server' name='mex' style='width: 82%; margin-right: 15px;'>
		<button type='submit' class='btn btn-info btn-sm' name='smex' value="1">Send message <i class='fa fa-pen-square'></i> </button>
	</form>  

	<?php } ?>	

</div> 