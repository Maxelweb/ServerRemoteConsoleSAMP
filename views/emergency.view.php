<?php
/*
 *
 *  SERVER REMOTE CONSOLE
 *  View - Emergency Block Mode
 *  
 *  Developed by Maxel (marianosciacco.it)
 *  Github - src.debug.ovh
 *
 */
?>


<h2 class="text-danger"><i class="fa fa-lock"></i> The site has been blocked</h2>
<br><br>
<p class="text-danger"><b>The site has been blocked for security issues.</b> It will be back as soon as possible.</p>
<p>If you're the web master, delete <code>emergency.lock</code> from website root folder to reactivate the site.</p>
<p>If you're a user or a guest, while the webmaster fixes the issues, let's play <b>Rock, Paper, Scissors</b>: </p>

<div class="jumbotron py-2 px-3">
	<div class="row my-3" id="game">
		<div class="col-md-4"><button class="btn btn-lg btn-block btn-success" OnClick="Choose('rock');"> <i class="fa fa-hand-rock"></i> Rock</button></div>
		<div class="col-md-4"><button class="btn btn-lg btn-block btn-light" OnClick="Choose('paper');"> <i class="fa fa-hand-paper"></i> Paper</button></div>
		<div class="col-md-4"><button class="btn btn-lg btn-block btn-danger" OnClick="Choose('scissors');"> <i class="fa fa-hand-scissors"></i> Scissors</button></div>
	</div>
	<div id="result"></div>
</div>

	<script>
		
		var scoreP = 0;
		var scorePC = 0;

		function Choose(Player)
		{       

			$("#game").hide();
			$("#result").show();

			var toprint = "";

			var Moves = ['rock','paper','scissors'];
			var wins = ["02","10","21"];
			var PlayerMove = Moves.indexOf(Player);

	        if(PlayerMove >= 0)
	       		toprint += ("<p class='h3'><b>Player</b>" + " <i class='fa fa-hand-"+ Player +"'></i> " + Player + "</p>");
	       	else
	       		toprint += ("<p class='h3'>Don't cheat!</p>");  	

	        var ComputerMove = Math.floor(Math.random() * 3);
	        Computer = Moves[ComputerMove];
	        
	        toprint += ("<p class='h3'><b>Computer</b>" + " <i class='fa fa-hand-"+ Computer +"'></i> " + Computer + "</p>");

	   		toprint += ("<hr><p class='h3'> ");

	        if(Computer == Player)
	        	toprint += "<span class='badge badge-light'>It's Tie!</span>";  
	        else if(Computer != Player)
	        {
	        	var cond = (wins.indexOf(PlayerMove.toString() + ComputerMove.toString()) >=0);
	        	toprint += (cond) ? "<span class='badge badge-success'>You won!</span>" : "<span class='badge badge-danger'>You lose!</span>";
	        	if(cond) scoreP++; 
	        	else scorePC++;
	        }

	        toprint += (scoreP > scorePC) ? " You're winning!" : (scoreP == scorePC) ? " Same points." : " PC is winning! ";

	        toprint += ( " (" + scoreP + " : " + scorePC + ")" + "</p><br> <button class='btn btn-block btn-lg btn-secondary' onClick='Retry()'>Retry</button>");

	       	document.getElementById('result').innerHTML = toprint;
	    }

 
	    function Retry(){
		    $("#game").show();
		    $("#result").hide();
		}

    </script>