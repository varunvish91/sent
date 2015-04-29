<?php
  include 'Stats.class.php';
  $returnResult = array();
  if (isset($_GET['gamestats'])) {
    /* get the values from gamestats fields include
      1. Device ID (Android/iOS/Windows/Samsung/etc.)
      2. Player ID
      3. Time player enters app (maybe due in military time so we can understand international time zones later)
      4. Total time player is within app
      5. Time player leaves app
      6. soft currency
      7. soft currency purchased
      8. soft currency spent
      9. soft currency earned
      10. hard currency
      11. hard currency purchased
      12. hard currency spent
      13. hard currency earned
      14. level in the game (progress) player starts at
      15. level in the game (progress) player ends at
      16. levels (progress) completed
      17. Retention (did player return to app at any future date)
      18. Did player invite any other player ID into app
      19. How many players were invited into app
      20. Who are players that were invited into app
      21. real currency type
      22. country code of player ID
      23. IP address (if applicable)
      24. FB user ID
      25. Twitter user ID
      26. ioS/GooglePlay/Windows/Steam/Valve/Samsung/etc. ID
      27. Player alias ID
      28. Game username
      29. browser
      30. URL source (if applicable)
      31. Did player install/download app
      32. Developer Name
      33. Game Name
      
      error code of 1 means that the transaction was cancelled
      reason will not be empty if the error code is 1

      error code of 2 means you are forgetting a field but
      the transaction was still processed
    */
    
    // scrub the inputs
    $data = json_decode($_GET['gamestats']);
    if (Stats::isValidInteger($data['deviceID'])) {
      Stats::$deviceID = $data['deviceID'];
    } else {
      $returnResult['error']['code'] = 1;
      $returnResult['error']['reason'] = "No Device ID";
      echo json_encode($returnResult);
      exit();
    }

    if (Stats::isValidInteger($data['playerID'])) {
      Stats::$playerID = $data['playerID'];
    } else {
      $returnResult['error']['code'] = 1;
      $returnResult['error']['reason'] = "No Player ID";
      echo json_encode($returnResult);
      exit();
    }

    if (Stats::isValidTime($data['timeEnteredApp'])) {
      Stats::$timeEnteredApp = $data['timeEnteredApp'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No time player entered App";
    }

    if (Stats::isValidTime($data['timeInApp'])) {
      Stats::$timeInApp = $data['timeInApp'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No time player was in app";
    }


    if (Stats::isValidTime($data['timeLeftApp'])) {
      Stats::$timeLeftApp = $data['timeLeftApp'];         
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No time player left app";
    }

    if (Stats::isValidString($data['softCurrency'])) {
      Stats::$softCurrency = $data['softCurrency'];
    } else  {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No soft Currency";
    }

    if (Stats::isValidString($data['softCurrencyPurchased'])) {
      Stats::$softCurrencyPurchased = $data['softCurrencyPurchased'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No soft currency Purchased included";
    }

    if (Stats::isValidString($data['softCurrencySpent'])) {
      Stats::$softCurrencySpent = $data['softcurrencySpent'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No soft currency spent included";
    }

    if (Stats::isValidString($data['softCurrencyEarned'])) {  
      Stats::$softCurrencyEarned = $data['softCurrencyEarned'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No soft currency earned included";
    }

    if (Stats::isValidString($data['hardCurrency'])) {
      Stats::$hardCurrency = $data['hardCurrency']; 
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No hard currency included";
    }

    if (Stats::isValidString($data['hardCurrencyPurchased'])) {
      Stats::$hardCurrencyPurchased = $data['hardCurrencyPurchased'];

    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No hard currency purchased included";
    }

    if (Stats::isValidString($data['hardCurrencySpent'])) {
      Stats::$hardCurrencySpent = $data['hardCurrencySpent'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No hard currency spent included";
    }

    if (Stats::isValudString($data['hardCurrencyEarned'])) {
      Stats::$hardCurrencyEarned = $data['hardCurrencyEarned'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No hard currency earned included";
    }

    if (Stats::isValudInteger($data['levelInGameStart'])) {
      Stats::$levelInGameStart = $data['levelInGameStart'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No level start included";
    }

    if (Stats::isValidInteger($data['levelInGameEnd'])) {
      Stats::$levelInGameEnd = $data['levelInGameEnd'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No end level included";
    }

    if (Stats::isValidInteger($data['levelsCompleted'])) {
      Stats::$levelsCompleted = $data['levelsCompleted'];

    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No levels completed included";
    }
  
    if (Stats::isValidBoolean($data['didPlayerReturnToApp'])) {
      Stats::$didPlayerReturnToApp = $data['didPlayerReturnToApp'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No didPlayerReturnToApp included";
    }

    if (Stats::isValidBoolean($data['didPlayerInviteFriendsToApp'])) {
      Stats::$didPlayerInvluteFriendsToApp = $data['didPlayerInvitefriendsToApp'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No didPlayerInviteFriendsToApp included";
    }

    if (Stats::isValidInteger($data['numPlayersInvited'])) {
      $numPlayersList = $data['numPlayersInvited'];
      $playerIDs = $data['numPlayersinvited']['playerId'];
      $include = true;
      for ($i = 0; $i < $numPlayersList; $i++) {
        if (!Stats::isValidInteger($numPlayersList[$i])) {
          $returnResult['error']['code'] = 2;
          $returnResult['error']['reason'] = "invalid fbid's of players invited";
          $include = false;
        }
      }
      if ($inlude) {
        Stats::$numPlayersInvited = $data['numPlayersInvited'];
        Stats::$playerIDInvitedToApp = $playerIDs;
      }

    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "invalid integer for numPlayersInvited";;
    }

    if (Stats::isValidString($data['realCurrencyType'])) {
      Stats::$realCurrencyType = $data['realCurrencyType'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No real currency type included";
    }

    if (Stats::isValidString($data['countryCode'])) {
      Stats::$countryCode = $data['countryCode'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No country code included";
    }

    if (Stats::isValidString($data['ipAddr'])) {
      Stats::$ipAddr = $data['ipAddr'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No IP addr included";
    }

    if (Stats::isValidInteger($data['fbuid'])) {
      Stats::$fbUid = $data['fbuid'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No facebook uid included";
    }

    if (Stats::isValidInteger($data['twitterId'])) {
      Stats::$twitterID = $data['twitterId'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No Twitter ID included";
    }

    if (Stats::isValidString($data['OperatingSystem'])) {
      Stats::$Osid = $data['OperatingSystem'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No operating system included";
    }

    if(Stats::isValidInteger($data['playerAliasId'])) {
      Stats::$playerAliasID = $data['playerAliasId'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No player Alias id included";
    }

    if (Stats::isValidString($data['inGameUserName'])) {
      Stats::$gameUsername = $data['inGameUserName'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "No ingame username";
    }

    if (Stats::isValidString($data['browser'])) {
      Stats::$browser = $data['browser'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "no web browser included";
    }

    if (Stats::isValidString($data['urlSource'])) {
      Stats::$urlSource = $data['urlSource'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "no URL source included";
    } 

    if (Stats::isValidString($data['installOrDownloadApp']) && ($data['installOrDownloadApp'] == "install" || $data['installOrDownloadApp'] == "download")) {
      Stats::$didPlayerInstallOrDownloadApp = $data['installOrDownloadApp'];
    } else {
      $returnResult['error']['code'] = 2;
      $returnResult['error']['reason'] = "not valid entry for wheter player installed or downloaded App";
    }

    if (Stats::isValidString($data['developername'])) {
      Stats::$developerName = $data['developername'];
    } else {
      $returnResult['error']['code'] = 1;
      $returnResult['error']['reason'] = "Required field developername";
    }

    if (Stats::isValidString($data['gameName'])) {
      Stats::$gameName = $data['gameName'];
    } else {
      $returnResult['error']['code'] = 1;
      $returnResult['error']['reason'] = "Required field gamename";
    }
  } else {
    $returnResult['error']['code'] = 1;
    $returnResult['error']['reason'] = "Required field gamestats";
    echo json_encode($returnResult);
  }

  
  if (Stats::commit()) {
    $returnResult['success'] = "Transaction complete";        
  } 
  





?>
