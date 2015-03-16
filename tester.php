<?php
  require('API.php');
  $data = createTestFive();
  $_GET['content'] = $data;
  $result = runIt();


  function createTestFour() {
    $item = array();
    $item["fields"] = array();
    $item["limit"] = 30;
    $item["callback"] = "receiver";
    $item["fields"]["id"][] = 1;
    $item["fields"]["id"][] = 2;

    $item["fields"]["velocity"] = array();
    $item["fields"]["AppDetails"][] = "velocity_score";
    $item["fields"]["AppDetails"][] = "dau";
    $item["fields"]["AppDetails"][] = "rank";
    $item["fields"]["AppDetails"][] = "title";
    $item["fields"]["EarnedMedia"]['country'] = "Japan";
    $item["fields"]["SocialBrand"] = array();

    return json_encode($item);
  }

  function createTestFive() {
    $item = array();
    $item["limit"] = 1;
    $item["callback"] = "hellowrold";
    $item["fields"] = array();
    return json_encode($item);
  }
?>
