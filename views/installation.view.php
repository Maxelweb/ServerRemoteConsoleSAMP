<?php
/*
 *
 *  SERVER REMOTE CONSOLE
 *  View - Installation page
 *  
 *  Developed by Maxel (marianosciacco.it)
 *  Github - src.debug.ovh
 *
 */
?>


<h1 class="py-4"><i class="fa fa-magic"></i> Installation</h1>

<p>The installation process is very simple. Please, fill the form with the required fields.</p>
<p>For more information check the <a href="<?=$GithubRepo;?>/wiki">wiki at Github</a>.</p>

<form action='?a=do-magic-things' method='post' class="form-control">

	<h3 class="pt-4 pb-2"><i class="fa fa-thumbtack"></i> Main configuration <span class="badge badge-danger small">REQUIRED</span></h3>
	<input type='password' class='form-control' required placeholder='Choose a password' name='srcp'>
	<p class="text-muted small mt-2 mb-4">Choose a Password to access the SRC. <b><code>Letters, numbers, dashes and underscores only; [4-32] characters length.</code></b></p>
	<input type='text' value="<?=$ips;?>" class='form-control' required placeholder='Server IP Address (without port)' name='ips'>
	<p class="text-muted small mt-2 mb-4">Insert the SA-MP server IP address. <b>Example:</b> <code>92.133.132.181</code></p>
	<input type='number' value="<?=$port;?>" required class='form-control' placeholder='Server Port' name='port'>
	<p class="text-muted small mt-2 mb-4">Insert the SA-MP server Port <b>Example:</b> <code>7777</code> (default SA-MP port)</p>

	<h3 class="pt-4 pb-2"><i class="fa fa-lock"></i> RCON configuration <span class="badge badge-warning small">RECOMMENDED</span></h3>
	<input type='checkbox' name='ercon' class="custom-checkbox" id="enableRcon" value="1"> Enable control with RCON password<br>
	<input type='checkbox' name='srcon' class="custom-checkbox" id="showRcon" disabled value="1"> Show RCON password in protected area<br>
	<p class="text-muted small"><b>If disabled</b>, the RCON password <u>won't be shown</u> while fetching server.cfg from SSH and in the Index Toolbar.</p>
	<input type='password' class='form-control' placeholder='RCON password' name='rcon' id="setRcon" disabled>
	<p class="text-muted small mt-2 mb-4"><b>Required</b>, if <u>Control with RCON password</u> is checked. Otherwise leave it blank.</p>

	<h3 class="pt-4 pb-2"><i class="fa fa-server"></i> SSH configuration <span class="badge badge-warning small">RECOMMENDED</span></h3>
	<input type='checkbox' name='essh' class="custom-checkbox" id="enableSSH" value="1"> Enable control with SSH access (Ubuntu / Debian required)
	<p class="text-muted small my-2"><b>Required</b>, if <u>Control with SSH access</u> is checked. Otherwise leave it blank.</p>
	<p class="text-danger"><span class="badge badge-danger">Warning</span> Please, do not use <b><code>root</code></b>. Create a <b><code>samp</code></b> user instaed, without sudoers privileges.</p>
	<input type='text' class='form-control' value="<?=$user;?>" placeholder='SSH User' name='user' id="sshUser" disabled /><br>
	<input type='password' class='form-control' placeholder='SSH Password' name='pass' id="sshPass" disabled /><br>
	<input type='text' class='form-control' value="<?=$path;?>" placeholder='SSH Path/to/sa-mp/server' name='path' id="sshPath" disabled />
	<p class="text-muted small my-2"><b>Warning</b>, the folder MUST end with <code>/</code>. For example: <code>samp03/</code></p>
	<br>
	<button class='btn btn-primary' type='submit'>Submit the form <span class="fa fa-sign-in-alt"></span></button>
</form>



<script>
$('#enableRcon').change(function() {
    $('#setRcon').attr('disabled',!this.checked);
    $('#showRcon').attr('disabled',!this.checked);
});
$('#enableSSH').change(function() {
    $('#sshUser').attr('disabled',!this.checked);
    $('#sshPass').attr('disabled',!this.checked);
    $('#sshPath').attr('disabled',!this.checked);
});
</script>