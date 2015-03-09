<?php
  include('API.php');
  $data = createTestFour();
  $_GET['content'] = $data;
  $result = runIt();
  print_r(json_decode($result));
  echo "\n";
  


  function createTestFour() {
    $item = array();
    $item["fields"] = array();
    $item["limit"] = 30;
    $item["callback"] = "receiver";
    $item["fields"]["id"][] = 1;
    $item["fields"]["id"][] = 2;

    $item["fields"]["AppDetails"][] = "velocity_score";
    $item["fields"]["AppDetails"][] = "dau";
    $item["fields"]["AppDetails"][] = "rank";
    $item["fields"]["AppDetails"][] = "title";
    $item["fields"]["EarnedMedia"]['country'] = "Japan";
    return json_encode($item);
  }
?>
