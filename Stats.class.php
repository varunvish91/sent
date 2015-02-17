<?php
  /*
     container class which will hold all of the information that the client is sending for tracking
     data must be properly formatted. Also will insert data into the database

   */


  class Stats {
    public static $devieID;
    public static $playerID;
    public static $timeEnteredApp;
    public static $timeInApp;
    public static $timeLeftApp;
    public static $softCurrency;
    public static $softCurrencyPurchased;
    public static $softCurrencySpent;
    public static $softCurrencyEarned;
    public static $hardCurrency;
    public static $hardCurrencyPurchased;
    public static $hardCurrencySpent;
    public static $hardCurrencyEarned;
    public static $levelInGameStart;
    public static $levelInGameEnd;
    public static $levelsCompleted;
    public static $didPlayerReturnToApp;
    public static $didPlayerInviteFriendsToApp;
    public static $numPlayersInvited;
    public static $playerIDinvitedToApp;
    public static $realCurrencyType;
    public static $countryCode;
    public static $ipAddr;
    public static $fbUid;
    public static $twitterID;
    public static $Osid;
    public static $playerAliasID;
    public static $gameUsername;
    public static $browser;
    public static $urlSource;
    public static $didPlayerInstallOrDownloadApp;
    public static $developerName;
    public static $gameName;
    
    public function __construct() {}
    
    public static function isValidInteger($value) {
      return is_int($value);
    }

    public static function isValidTime($numberOfSecs) {
      $dateTime = date(date('Y/m/d H:i:s', $numberOfSecs);
      return $dateTime;
    }

    public static function isValudString($string) {
      return is_string($string);
    }

    // need to check if the string matches true or false
    // since it is coming in as a string
    public static function isValidBoolean($string) {
      if ($string == "true" || $string == "false") {
        return true;
      } 
      return false;
    }
    
  }



?>
