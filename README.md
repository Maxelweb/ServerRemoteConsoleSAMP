# Server Remote Console (SA-MP)

This web application wrote in PHP is a simple remote console to manage players and server activities.
You can easily start & stop your server, once configured, and you can view server logs as well as server advanced informations and player's list. Moreover, it is possible to kick or ban players directely from the console and send global messages.

## Features

- Easy configuration
- No mysql database needed
- Multiple types of configuration based on needs
- Password protected area
- Simple Server Start (via SSH)
- Simple Server Stop (via RCON)
- Possibility to send global message to ingame players (via RCON)
- Direct access to server_logs.txt and quick reset (via SSH)
- Advanced information panel about the server
- Advanced player's list (with score, username, id and ping) and kick/ban options (via RCON)
- Bootstrap 4.0 coding and font-awesome icons


## Requirements

1. Web server with PHP 7.0+ (it should work fine in PHP 5 and in earlier versions)
2. **[Recommended]** SA-MP server on Ubuntu or Debian
3. **[Recommended]** RCON password of the server
4. **[Recommended]** SSH access to samp-server directory with granted privileges 


## Installation

The installation process is pretty easy: you need to edit the file ```includes/configuration.php``` with the requested field. In order to make everything usable, you must have satisfy all the recommended requirements described above. Anyway, there are various modes to use this console.

Modes | Description | Requirements
---   | ---         | ---
**Open** | This mode is used to display only the server information and player's list. Guests are able to see everything. | (1)
**Limited** | In this mode, you need a password to access the area and you can only view server information and player's list, once logged-in. | (1)
**Only RCON** | Like the limited mode, but with the possibility to kick and ban players, stop server and send global messages. | (1) (3)
**Only SSH** | Like the limited mode, with the possibility to start the server, view and reset server_logs. | (1) (2) (4)
**Complete** | All features available. | (1) (2) (3) (4)


## Configuration File

The configuration file is very simple to change. Just read this chapter to understand the function of each parameter.


There are four main flags where ```enabled = 1``` and ```disabled = 1```. 

- **ShowRCON** is a flag used to show the RCON password of the sa-mp server in the information area.
	   	
- **EnableRCON** activates the following features:
	- Kick / Ban players
	- Message
	- Stop server
 		- *[Requirement] YOU NEED THE RCON SERVER PASSWORD*		
	 

- **EnableSSH** activates the following features:
 	- View / Reset server logs
	- Start server
		- *[Requirement] YOU NEED SSH ACCESS WITH SA-MP FOLDER PERMISSIONS*		

- **EnableSRCPassword** is used to enable / disable password protected area for this console.

> **[IMPORTANT]** It is strongly recommended to disable **EnableSRCPassword** __only__ if BOTH **EnableSSH** and **EnableRCON** are __disabled__, since the entire console would be visible to guests.

---

Then, there also seven more fields used to define core parameters:

- **SRC_PASSWORD** (Server Remote Console Password) is the password used for the protected area.
- **IP_SERVER** is the IP of the target server.
- **PORT_SERVER** is the port of the target server (default sa-mp port: 7777).
- **RCON_PASSWORD** is the RCON password used in the target server.
- **SERVER_SSH_USER** and **SERVER_SSH_PSW** are the user credentials to access via SSH the sa-mp server folder.
- **SERVER_SSH_PATH** is the path of the sa-mp installation in the server. 

> To localize the server Path, login with your SSH user credentials and move with ```cd``` through folders till you find the samp03 (or similar) folder. Do not forget to add a slash ( / ) at the end. 

> User credentials must have permissions to start the server and open (```cat```) / remove (```rm```) files. 

> **Do not use ROOT credentials**.


## Credits

The server remote console for SA-MP has been developed and coded by **Maxel** (marianosciacco.it)
It is actually released in **beta version 1.0**.
This project has started in __19/04/2018__ and it is __still supported__. 

Special thanks to __StatusRed__ aka __Edward McKnight__ for his plugin **SA-MP Query and RCON API for PHP** which is used in this project. 
Bootstrap 4 and Font-Awesome.com has been also used to make the GUI of this website.
