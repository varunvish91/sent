<?php
  $mysqli = new mysqli("localhost", "root", "Password1704", "API") or die ("error");
  $result = $mysqli->query("SELECT * FROM `TABLE 7`") or die ("issue");
  while ($row = $result->fetch_row()) {
    $id = $row[0];
    unset($row[0]);
    unset($row[1]);
    unset($row[2]);
    unset($row[3]);
    unset($row[4]);
    
    $subGenreOne = $row[5];
    $subGenreRank = $row[6];
    $sub2 = $row[7];
    $sub2Rank = $row[8];
    $query = "INSERT INTO `SubGenre`(`id`, `subgenre`, `rank`) VALUES ('$id','$subGenreOne','$subGenreRank')"; 
    $queryTwo = "INSERT INTO `SubGenre`(`id`,`subgenre`,`rank`) VALUES ('$id','$sub2','$sub2Rank')";

//    $mysqli->query($query) or die ("A\n");
//    $mysqli->query($queryTwo) or die ("B\n");
    unset ($row[5]);
    unset($row[6]);
    unset($row[7]);
    unset($row[8]);

  
    for ($i = 9; $i < 14; $i++) {
      $country = $row[$i];
      $value = $row[$i + 5];
      $sql = "INSERT INTO `EarnedMedia`(`id`, `country`, `value`) VALUES ('$id','$country','$value')";
//      $mysqli->query($sql) or die ("error with query");
      unset($row[$i]);
      unset($row[$i + 5]);
    
    }
    
    unset($row[19]);
    unset($row[20]);
    unset($row[21]);
    unset ($row[22]);
    for ($i = 23; $i < 48; $i++) {
      $month = "february";
      $day = $i - 22;
      $score = $row[$i];
      $sql = "INSERT INTO `velocity`(`id`, `month`, `day`, `score`) VALUES ('$id', '$month','$day', '$score')";
//      $mysqli->query($sql) or die ("hello world");
      unset($row[$i]);
    }

    for ($i = 48; $i <=69; $i++) {
      unset($row[$i]);
    }

    
    for ($i = 70; $i <= 74; $i++) {
     $brand = addslashes($row[$i]);
     $over_index = $row[$i + 5];
     $sharedFollowers = $row[$i + 10];
     $twitterFollowers = $row[$i + 15];
     $sql = "INSERT INTO `SocialBrand`(`id`, `brand`, `over_index`, `shared_followers`, `twitter_followers`) VALUES ('$id', '$brand','$over_index','$sharedFollowers','$twitterFollowers')";
  //   $mysqli->query($sql) or die ($mysqli->error);
     unset($row[$i], $row[$i + 5], $row[$i + 10], $row[$i + 15]);
    } 
    
    for ($i = 90; $i < 100; $i++) {
      $sentiment_word = $row[$i];
      $proporation = $row[$i + 10];
      $topic = $row[$i + 20];
      $volume = $row[$i + 30];
      $sql = "INSERT INTO `WordData`(`id`, `sentiment_word`, `proporation_word`, `topic_word`, `volume_word`) VALUES ('$id','$sentiment_word','$proporation','$topic', '$volume')";
      $mysqli->query($sql) or die ($mysqli->error);
    }
  }

?>
