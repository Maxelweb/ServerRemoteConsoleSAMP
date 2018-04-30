
<?php
/*
 *
 *  SERVER REMOTE CONSOLE
 *  View - Settings page
 *  
 *  Developed by Maxel (marianosciacco.it)
 *  Github - src.debug.ovh
 *
 */
?>

<h3><i class="fa fa-wrench"></i> General settings</h3>

<div class="jumbotron p-4">
	<form action='?settings&a=edit-general' method='post'>
		<div class="table-responsive">
			<table class="table main_table">
				<tbody>
					<tr class="table-light">
						<td class="w-25">Modes:</td> 
						<td class="w-75">
							<input type='checkbox' name='ercon' <?=($config->EnableRCON) ? "checked" : ""; ?> value="1" disabled> 
							Enable control with RCON password<br>
							<input type='checkbox' name='essh' <?=($config->EnableSSH) ? "checked" : ""; ?> value="1" disabled> 
							Enable control with SSH access (Ubuntu / Debian required) <br>
							<input type='checkbox' name='srcon' <?=($config->ShowRCON) ? "checked" : ""; ?> value="1" disabled> 
							Show RCON password on server information (protected area) <br>
							<input type='checkbox' name='gpage' <?=($config->EnableGuestPage) ? "checked" : ""; ?> value="1"> 
							Enable Guest Page for server information and status <br><br>
							<!--<input type='checkbox' name='esrcp' value="1"> 
							Enable Password Protected Area 
							<br> <p class="text-danger"><b>Warning:</b> To disable this feature, SSH &amp; RCON access have to be disabled.</b></p>-->
							<br>
							<input type="submit" value="Apply changes" class="btn btn-warning">
						</td>
					</tr>
					<tr>
						<td colspan="2"><b>To change SSH access, RCON password and/or SRC password, restart the installation process.</b> Delete <code>installed.lock</code> file from root folder. <i>Note:</i> this will not remove or damage the bulletins submitted.</td>
					</tr>
					<tr class="table-light">
						<td class="text-danger">Emergency Block:</td>
						<td><a href="?settings&a=emergency-block" class="btn btn-dark btn-lg" OnClick="return confirm('THE SITE WILL BE BLOCKED. DO YOU WANT TO CONTINUE?');"><i class="fa fa-lock"></i> Activate Block Mode</a>
							<br><p class="text-muted small my-2"><span class="badge badge-danger">Warning</span> In case of password theft, activate the emergency mode to immediatly block the entire site. <br>Remove <code>emergency.lock</code> to reactivate it.</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
</div> 


<?php if($config->EnableGuestPage) { ?>

<h3><i class="fa fa-newspaper"></i> Guest Page configuration</h3>

<div class="jumbotron p-4">
	<form action='?settings&a=edit-gpage' method='post'>
		<div class="table-responsive">
			<table class="table main_table">
				<tbody>
					<tr class="table-light">
						<td class="w-25">Server Name / Guest page title:</td> 
						<td class="w-75">
							<input type='text' class='form-control' required placeholder='Insert the name of the server or a custom title' name='gname' value="<?=$gpage->ServerName;?>">
						</td>
					</tr>
					<tr class="table-light">
						<td>Options:</td> 
						<td><input type='checkbox' name='gusers' <?=($gpage->ShowPlayersList) ? "checked" : ""; ?> value="1"> 
							Show players' list to guests<br>
							<input type='checkbox' name='gstatus' <?=($gpage->EnableStatus) ? "checked" : ""; ?> value="1"> 
							Show server status with bulletins to guests<br>
						<br>
							<input type="submit" value="Apply changes" class="btn btn-primary">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
</div> 

<?php } ?>