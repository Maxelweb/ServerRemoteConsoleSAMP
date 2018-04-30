<?php
/*********************************************
*
* SA-MP Query Server Version 0.3
*
* This class provides you with an easy to use interface to query
* your SA-MP 0.2 servers. Usage is simple, but has changed a bit
* since the last version, so be sure to check out the examples
* that come along with this script. It is updated with some of
* the new SA-MP 0.2 query-techniques that can be used.
*
* Author: Peter Beverloo
*     peter@dmx-network.com
*     Ex SA-MP Developer
*
* Updated: Wouter van Eekelen
*     wouter.van.eekelen@serverffs.com
*     SA-MP Betatester
*********************************************/

class QueryServer
{
  // Private variables used for the query-ing.
  private $szServerIP;
  private $iPort;
  private $rSocketID;

  private $bStatus;

  // The __construct function gets called automatically
  // by PHP once the class gets initialized.
  function __construct( $szServerIP, $iPort )
  {
      $this->szServerIP = $this->VerifyAddress( $szServerIP );
      $this->iPort = $iPort;

      if (empty( $this->szServerIP ) || !is_numeric( $iPort )) {
          throw new QueryServerException( 'Either the ip-address or the port isn\'t filled in correctly.' );
      }

      $this->rSocketID = @fsockopen( 'udp://' . $this->szServerIP, $iPort, $iErrorNo, $szErrorStr, 5 );
      if (!$this->rSocketID) {
          throw new QueryServerException( 'Cannot connect to the server: ' . $szErrorStr );
      }

      socket_set_timeout( $this->rSocketID, 0, 500000 );
      $this->bStatus = true;
  }

  // The VerifyAddress function verifies the given hostname/
  // IP address and returns the actual IP Address.
  function VerifyAddress( $szServerIP )
  {
      if (ip2long( $szServerIP ) !== false && 
        long2ip( ip2long( $szServerIP ) ) == $szServerIP ) {
          return $szServerIP;
      }

      $szAddress = gethostbyname( $szServerIP );
      if ($szAddress == $szServerIP) {
          return "";
      }

      return $szAddress;
  }

  // The SendPacket function sends a packet to the server which
  // requests information, based on the type of packet send.
  function SendPacket( $cPacket )
  {
      $szPacket = 'SAMP';
      $aIpChunks = explode( '.', $this->szServerIP );

      foreach( $aIpChunks as $szChunk ) {
          $szPacket .= chr( $szChunk );
      }

      $szPacket .= chr( $this->iPort & 0xFF );
      $szPacket .= chr( $this->iPort >> 8 & 0xFF );
      $szPacket .= $cPacket;

      return fwrite( $this->rSocketID, $szPacket, strlen( $szPacket ) );
  }

  // The GetPacket() function returns a specific number of bytes
  // read from the socket. This uses a special way of getting stuff.
  function GetPacket( $iBytes )
  {
      $iResponse = fread( $this->rSocketID, $iBytes );
      if ($iResponse === false) {
          throw new QueryServerException( 'Connection to ' . $this->szServerIP . ' failed or has dropped.' );
      }

      $iLength = ord( $iResponse );
      if ($iLength > 0)
          return fread( $this->rSocketID, $iLength );

      return "";
  }

  // After we're done, the connection needs to be closed using
  // the Close() function. Otherwise stuff might go wrong.
  function Close( )
  {
      if ($this->rSocketID !== false) {
          fclose( $this->rSocketID );
      }
  }

  // A little function that's needed to properly convert the
  // four bytes we're recieving to integers to an actual PHP
  // integer. ord() can't handle value's higher then 255.
  function toInteger( $szData )
  {
      $iInteger = 0;

      $iInteger += ( ord( @$szData[ 0 ] ) );
      $iInteger += ( ord( @$szData[ 1 ] ) << 8 );
      $iInteger += ( ord( @$szData[ 2 ] ) << 16 );
      $iInteger += ( ord( @$szData[ 3 ] ) << 24 );

      if( $iInteger >= 4294967294 )
          $iInteger -= 4294967296;

      return $iInteger;
  }

  // The GetInfo() function returns basic information about the
  // server, like the hostname, number of players online etc.
  function GetInfo( )
  {
      if ($this->SendPacket('i') === false) {
          throw new QueryServerException( 'Connection to ' . $this->szServerIP . ' failed or has dropped.' );
      }

      $szFirstData = fread( $this->rSocketID, 4 );
      if (empty( $szFirstData ) || $szFirstData != 'SAMP') {
          throw new QueryServerException( 'The server is not a SA-MP Server.' ); //at ' . $this->szServerIP . '
      }

      // Pop the first seven characters returned.
      fread( $this->rSocketID, 7 );

      return array (
          'Password'  =>  ord( fread( $this->rSocketID, 1 ) ),
          'Players'  =>  $this->toInteger( fread( $this->rSocketID, 2 ) ),
          'MaxPlayers' =>  $this->toInteger( fread( $this->rSocketID, 2 ) ),
          'Hostname'  =>  $this->GetPacket( 4 ),
          'Gamemode'  =>  $this->GetPacket( 4 ),
          'Map'    =>  $this->GetPacket( 4 )
      );
  }

  // The GetRules() function returns the rules which are set
  // on the server, e.g. the gravity, version etcetera.
  function GetRules( )
  {
      if ($this->SendPacket('r') === false) {
          throw new QueryServerException( 'Connection to ' . $this->szServerIP . ' failed or has dropped.' );
      }

      // Pop the first 11 bytes from the response;
      fread( $this->rSocketID, 11 );

      $iRuleCount = ord( fread( $this->rSocketID, 2 ) );
      $aReturnArray = array( );

      for( $i = 0; $i < $iRuleCount; $i ++ ) {
          $szRuleName = $this->GetPacket( 1 );
          $aReturnArray[ $szRuleName ] = $this->GetPacket( 1 );
      }

      return $aReturnArray;
  }

  // The GetPlayers() function is pretty much simelar to the
  // detailed function, but faster and contains less information.
  function GetPlayers( )
  {
      if ($this->SendPacket('c') === false) {
          throw new QueryServerException( 'Connection to ' . $this->szServerIP . ' failed or has dropped.' );
      }

      // Again, pop the first eleven bytes send;
      fread( $this->rSocketID, 11 );

      $iPlayerCount = ord( fread( $this->rSocketID, 2 ) );
      $aReturnArray = array( );

      for( $i = 0; $i < $iPlayerCount; $i ++ )
      {
          $aReturnArray[ ] = array (
              'Nickname' => $this->GetPacket( 1 ),
              'Score'  => $this->toInteger( fread( $this->rSocketID, 4 ) )
          );
      }

      return $aReturnArray;
  }

  // The GetDetailedPlayers() function returns the player list,
  // but in a detailed form inclusing the score and the ping.
  function GetDetailedPlayers( )
  {
      if ($this->SendPacket('d') === false) {
          throw new QueryServerException( 'Connection to ' . $this->szServerIP . ' failed or has dropped.' );
      }

      // Skip the first 11 bytes of the response;
      fread( $this->rSocketID, 11 );

      $iPlayerCount = ord( fread( $this->rSocketID, 2 ) );
      $aReturnArray = array( );

      for( $i = 0; $i < $iPlayerCount; $i ++ ) {
          $aReturnArray[ ] = array(
              'PlayerID'  => $this->toInteger( fread( $this->rSocketID, 1 ) ),
              'Nickname'  => $this->GetPacket( 1 ),
              'Score'   => $this->toInteger( fread( $this->rSocketID, 4 ) ),
              'Ping'    => $this->toInteger( fread( $this->rSocketID, 4 ) )
          );
      }

      return $aReturnArray;
  }

function RCON($rcon, $command)
  {
      echo 'Password '.$rcon.' with '.$command;
      if ($this->SendPacket('x '.$rcon.' '.$command) === false) {
          throw new QueryServerException( 'Connection to ' . $this->szServerIP . ' failed or has dropped.' );
      }

      // Pop the first 11 bytes from the response;
      $aReturnArray = fread( $this->rSocketID, 11 );

      echo fread( $this->rSocketID, 11 );

      return $aReturnArray;
  }

}

/*********************************************
*
* The QueryServerException is used to throw errors when querying
* a specific server. That way we force the user to use proper
* error-handling, and preferably even a try-/catch statement.
*
**********************************************/

class QueryServerException extends Exception
{
  // The actual error message is stored in this variable.
  private $szMessage;

  // Again, the __construct function gets called as soon
  // as the exception is being thrown, in here we copy the message.
  function __construct( $szMessage )
  {
      $this->szMessage = $szMessage;
  }

  // In order to read the exception being thrown, we have
  // a .NET-like toString() function, which returns the message.
  function toString( )
  {
      return $this->szMessage;
  }
}
?>