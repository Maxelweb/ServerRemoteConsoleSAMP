<?php
/**
 * @author Edward McKnight (EM-Creations.co.uk)
 */

/* *****************************************************************
// SampRcon.class.php
// Version 1.1
// This class connects to a specific SA-MP server via sockets.
// Copyright 2014 Edward McKnight (EM-Creations.co.uk)
// Creative Commons Attribution-NoDerivs 3.0 Unported License
// http://creativecommons.org/licenses/by-nd/3.0/
// Credits to Westie for the original PHP SA-MP API and inspiration for this API.
* *****************************************************************/

class SampRcon {
    private $sock = null;
    private $server = null;
    private $port = null;
    private $password = null;

    /**
     * Creates a new SampRcon object. 
     * @param $server  hostname of the server
     * @param $port  port of the server
     * @param $password  rcon password for the server
     */
    public function __construct($server, $port, $password) {
		// <editor-fold defaultstate="collapsed" desc="Constructor">
        $this->server = $server;
        $this->port = $port;
        $this->password = $password;
		// </editor-fold>
    }

    /**
     * Returns an array of rcon commands. 
     * @return Array
     * (
     *   Array[0] => "echo"
     *   ...
     * )
     *   ...
     * @see getServerVariables()
     */
    public function getCommandList() {
		// <editor-fold defaultstate="collapsed" desc="Get Command List">
        $commands = $this->rconSend('cmdlist');

        foreach($commands as &$command) {
            $command = trim($command);
        }
        return $commands;
		// </editor-fold>
    }

    /**
     * Returns an array of server variables. 
     * @return Array[]
     *  (
     *   ['variableName'] = variableValue
     *   ...
     *  )
     * @see getCommandList
     */
    public function getServerVariables() {
		// <editor-fold defaultstate="collapsed" desc="Get Server Variables">
        $aVariables = $this->rconSend('varlist');
        unset($aVariables[0]);
        $aReturn = array();

        foreach($aVariables as $sString) {
            preg_match('/(.*)=[\s]+(.*)/', $sString, $aMatches);

            if($aMatches[2][0] == '"') {
                preg_match('/\"(.*)\"[\s]+\(/', $aMatches[2], $aTemp);
                $aReturn[trim($aMatches[1])] = $aTemp[1];
            } else {
                preg_match('/(.*?)\s+\(/', $aMatches[2], $aTemp);
                $aReturn[trim($aMatches[1])] = $aTemp[1];
            }
        }
        return $aReturn;
		// </editor-fold>
    }

    /**
     * Sets the server's current weather, if no weather ID is given 1 is used. 
     * @param $weatherID weather ID
     */
    public function setWeather($weatherID=1) {
        $this->rconSend("weather ".$weatherID, false);
    }

    /**
     * Sets the server's current gravity, of mp gravity is given 0.008 is used. 
     * @param $gravity gravity double / float
     */
    public function setGravity($gravity=0.008) {
        $this->rconSend("gravity ".$gravity, false);
    }


    /**
     * Ban a player from the server.
     * @param $playerID player's ID
     * @return Output from ban
     */
    public function ban($playerID) {
        return $this->rconSend("ban ".$playerID);
    }

    /**
     * Kick a player from the server.
     * @param $playerID player's ID
     * @return Output from kick
     */
    public function kick($playerID) {
        return $this->rconSend("kick ".$playerID);
    }

    /**
     * Ban an IP address from the server.
     * @param $address IP address
     * @return Output from ban
     */
    public function banAddress($address) {
        return $this->rconSend("banip ".$address);
    }

    /**
     * Unban an IP address from the server.
     * @param $address IP address
     * @return Output from unban
     */
    public function unbanAddress($address) {
        return $this->rconSend("unbanip ".$address);
    }

    /**
     * Reload the server's log file.
     */
    public function reloadLog() {
            return $this->rconSend("reloadlog");
    }

    /**
     * Reload the server's bans file.
     */
    public function reloadBans() {
        return $this->rconSend("reloadbans");
    }

    /**
     * Send an admin message to players on the server.
     * @param $message message to send to players
     */
    public function say($message) {
        $this->rconSend("say ".$message, false);
    }


    /**
     * Change the server's current gamemode.
     * @param $gameMode game mode to change to
     */
    public function changeGameMode($gameMode) {
        $this->rconSend("changemode ".$gameMode, false);
    }

    /**
     * Set the server's current displayed game mode text.
     * @param $gameModeText game mode text to change to
     */
    public function setGameModeText($gameModeText) {
        $this->rconSend("gamemodetext ".$gameModeText, false);
    }
    
    /**
     * Run the server's next gamemode (gmx).
     */
    public function nextGameMode() {
        $this->rconSend("gmx", false);
    }
    
    /**
     * Run the server's next gamemode (gmx).
     */
    public function gmx() {
        $this->nextGamemode();
    }

    /**
     * Execute config file.
     * @param $config config file to execute
     * @return Output from exec
     */
    public function execConfig($config) {
        return $this->rconSend("exec ".$config);
    }

    /**
     * Load a filterscript.
     * @param $fs filterscript to load
     * @return Output from filterscript load
     */
    public function loadFilterscript($fs) {
        return $this->rconSend("loadfs ".$fs);
    }

    /**
     * Unload a filterscript.
     * @param $fs filterscript to unload
     * @return Output from filterscript unload
     */
    public function unloadFilterscript($fs) {
        return $this->rconSend("unloadfs ".$fs);
    }

    /**
     * Reload a filterscript.
     * @param $fs filterscript to reload
     * @return Output from filterscript reload
     */
    public function reloadFilterscript($fs) {
        return $this->rconSend("reloadfs ".$fs);
    }

    /**
     * Shutdown the server.
     */
    public function exitGame() {
        $this->rconSend("exit", false);
    }
    
    /**
     * Sets the server's host name.
     * @param $hostName the host name to set the server to
     */
    public function setHostName($hostName) {
        $this->rconSend("hostname ".$hostName, false);
    }
    
    /**
     * Sets the server's map name.
     * @param $mapName the map name to set the server to
     */
    public function setMapname($mapName) {
        $this->rconSend("mapname ".$mapName, false);
    }
    
    /**
     * Sets the server's time.
     * Note: This will not change the weather relative to the time.
     * @param $time the time to set the server to
     */
    public function setTime($time) {
        $this->rconSend("worldtime ".$time, false);
    }
    
    /**
     * Sets the server's web url.
     * @param $url the url to set the server to
     */
    public function setURL($url) {
        $this->rconSend("weburl ".$url, false);
    }
    
    /**
     * Sets the server's password.
     * @param $password the password to set the server to
     */
    public function setPassword($password) {
        $this->rconSend("password ".$password, false);
    }
    
    /**
     * Remove the server's password.
     */
    public function removePassword() {
        $this->rconSend("password 0", false);
    }
    
    /**
     * Sets the server's rcon password.
     * @param $password the password the rcon password should be set to
     */
    public function setRconPassword($password) {
        $this->rconSend("rcon_password ".$password, false);
    }
    
    /**
     * Disables remote rcon to the server.
     */
    public function disableRcon() {
        $this->rconSend("rcon 0", false);
    }
    
    /**
     * Enables remote queries to the server.
     */
    public function enableQuery() {
        $this->rconSend("query 1", false);
    }
    
    /**
     * Disables remote queries to the server.
     */
    public function disableQuery() {
        $this->rconSend("query 0", false);
    }
    
    /**
     * Enables the server's announce.
     */
    public function enableAnnounce() {
        $this->rconSend("announce 1", false);
    }
    
    /**
     * Disables the server's announce.
     */
    public function disableAnnounce() {
        $this->rconSend("announce 0", false);
    }
    
    /**
     * Sets the server's max number of NPCs.
     * @param $maxNPCs the maximum numbers of NPCs
     */
    public function setMaxNPCs($maxNPCs) {
        $this->rconSend("maxnpc ".$maxNPCs, false);
    }
    
    /**
     * Execute an rcon command.
     * @param $command command to execute
     * @param $delay delay time, if you don't expect any data back set this to false
     * @return Output from command
     */
    public function call($command, $delay=1.0) {
        return $this->rconSend($command, $delay);
    }

	/**
	 * Send an rcon command
	 * 
	 * @param String $command
	 * @param double $delay
	 * @return String
	 */
    private function rconSend($command, $delay=1.0) {
		// <editor-fold defaultstate="collapsed" desc="Rcon Send">
        fwrite($this->sock, $this->assemblePacket($command));

        if ($delay === false) {
            return;
        }

        $result = array();
        $iMicrotime = microtime(true) + $delay;

        while (microtime(true) < $iMicrotime) {
            $temp = substr(fread($this->sock, 128), 13);

            if (strlen($temp)) {
                $result[] = $temp;
            } else {
                break;
            }
        }
        return $result;
		// </editor-fold>
    }

	/**
	 * Assembles a packet, ready for sending
	 * 
	 * @param String $command
	 * @return String
	 */
    private function assemblePacket($command) {
		// <editor-fold defaultstate="collapsed" desc="Assemble Packet">
        $sPacket = "SAMP";
        $sPacket .= chr(strtok($this->server, "."));
        $sPacket .= chr(strtok("."));
        $sPacket .= chr(strtok("."));
        $sPacket .= chr(strtok("."));
        $sPacket .= chr($this->port & 0xFF);
        $sPacket .= chr($this->port >> 8 & 0xFF);
        $sPacket .= "x";

        $sPacket .= chr(strlen($this->password) & 0xFF);
        $sPacket .= chr(strlen($this->password) >> 8 & 0xFF);
        $sPacket .= $this->password;
        $sPacket .= chr(strlen($command) & 0xFF);
        $sPacket .= chr(strlen($command) >> 8 & 0xFF);
        $sPacket .= $command;

        return $sPacket;
		// </editor-fold>
    }
    
    /**
     * Attempts to connect to the server and returns whether it was successful.
     * @return boolean
     */
    public function connect() {
		// <editor-fold defaultstate="collapsed" desc="Connect">
        $connected = false;
        
        $packet = "SAMP";
        $packet .= chr(strtok($this->server, "."));
        $packet .= chr(strtok("."));
        $packet .= chr(strtok("."));
        $packet .= chr(strtok("."));
        $packet .= chr($this->port & 0xFF);
        $packet .= chr($this->port >> 8 & 0xFF);
        $packet .= "p0101";
        
        $this->sock = fsockopen("udp://".$this->server, $this->port, $errorNum, $errorString, 2);
        socket_set_timeout($this->sock, 2);
        
        fwrite($this->sock, $packet);

        if(fread($this->sock, 10)) {
            if(fread($this->sock, 5) == 'p0101') {
                $connected = true;
            }
        }
        return $connected;
		// </editor-fold>
    }

    /**
     * Closes the connection
     */
    public function close() {
        @fclose($this->sock);
    }
}