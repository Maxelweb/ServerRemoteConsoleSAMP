<h1>Server Remote Console</h1>
<br>
<?php if($CONFIG['EnableSRCPassword']) { ?>
<p class="text-right text-info">
	<a href='?a=logout'>
		<i class="fa fa-sign-out-alt"></i> Logout
	</a>
</p>
<?php } ?>
<ul class="my-4">
	<li><b>Server IP:</b> <code><?=IP_SERVER.":".PORT_SERVER;?></code></li>
	<?php if($CONFIG['ShowRCON']) { ?><li><b>Server RCON password:</b> <code><?=RCON_SERVER;?></code></li><?php } ?>
	<li><b>Status:</b> <?=$statusMessage;?> </li>
</ul>

<center>

	<?php if($CONFIG['EnableSSH']) {?>
	<form method='POST' action='?a=sendmex' class='form-inline'>
		<input type='text' class='form-control' placeholder='Write a message to send to everyone in the server' name='mex' style='width: 82%; margin-right: 15px;'>
		<button type='submit' class='btn btn-info btn-sm' name='smex' value="1">Send message <i class='fa fa-pen-square'></i> </button>
	</form>  

	<br>
	<?php } ?>

	<form method='POST' action='?a=control'>
		<a href='?a=info' class='btn btn-primary'><i class='fa fa-list-ul'></i> Informations and players list</a>
		<?=$button;?>		
		<?php if($CONFIG['EnableSSH']) {?>
		<button type="submit" name="viewlogs" class='btn btn-default' value="1"><i class='fa fa-server'></i> View server logs</button> 
		<button type="submit" name="resetlogs" class='btn btn-warning' value="1"><i class='fa fa-redo-alt'></i> Reset server logs</button>
		<?php } ?>
	</form> 

	<br>
	<hr>
	<br>

</center> 