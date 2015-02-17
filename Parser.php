<?php

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
   */

  } else {
    $returnResult['error']['code'] = 1;
    $returnResult['error']['reason'] = "Required field gamestats";
    echo json_encode($returnResult);
  }





?>
