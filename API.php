<?php
  header("Content-type:text/plain");
  ini_set('display_errors',1);
  ini_set('display_startup_errors',1);
  error_reporting(-1);
  
  /* 
     Test suite
     -  Empty paramaters No limit
     -  Empty paramaters with limit
     -  just id
     -  id with a few query paramaters
     -  id with a few other query paramaters
     -  ids with a few query paramaters
     -  just some query paramaters no specific ID with limit


  */
  
/*  echo "TestOne\n";
  $data = createTestOne();
  $_GET['content'] = $data;
  runIt();
*/
  echo "TestThree\n";
  $data = createTestThree();
  $_GET['content'] = $data;
  runIt();

/*  echo "TestZero\n";
  $data = createTestZero();
  $_GET['content'] = $data;
  runIt();
  */
  
  
  function runIt() { 
   $returnResult;
    if (isset($_GET['content'])) {
      $jsonContent = json_decode($_GET['content']);
      // get the Fields, this is required
      if (isset($jsonContent->fields)) {
        if (count($jsonContent->fields) == 0) {
          echo "Full DB scan not available yet";
          //$returnResult = getAllFields($jsonContent->limit, $mysqli); 
        
        } else {
          $returnResult = query($jsonContent); 
          echo json_encode($returnResult);
        
        }
      } else {
        echo "Required Fields entry\n";
      }
    }
  }
  

  function query($json) {
    $list = array();
    $ids = $json->fields->id;
    $mysqli = new mysqli("localhost", "root", "Password1704", "API") or die ("error connecting to DB");
    if (isset($json->fields->AppDetails)) { 
      $queryParams = $json->fields->AppDetails;
      $table = "AppDetails";
      foreach($ids as $id) {
        $sql = "SELECT `id`,";
        if (count($queryParams) == 0) {
          $sql .= "*";
        } else {
          for ($i = 0; $i < count($queryParams); $i++) {
            $param = $queryParams[$i];
            if ($i == 0) {
              $sql .= "`$param`";
            } else {
              $sql .= ",`$param`";
            }
          }

          $sql .= " FROM `$table` WHERE `id` = '$id' LIMIT 0,". $json->limit;
          $result = $mysqli->query($sql) or die ("error");
          while ($row = $result->fetch_assoc()) {
            $list[$id]['appDetails'] = $row;
          }
        }
      }
    }

    if (isset($json->fields->velocity)) {
      $table = "velocity";
      $queryParams = $json->fields->velocity;
      foreach ($ids as $id) {
        $sql = "SELECT `month`, `day`, `score`  FROM `$table` WHERE `id` = '$id' LIMIT 0,".$json->limit;
      
        $result = $mysqli->query($sql) or die ("error");
        while ($row = $result->fetch_assoc()) {
          $list[$id]['appVelocity'][] = $row;
        }
      }
    }

    return $list;
  }



  function createTestZero() {
    $item = array();
    return json_encode($item);
  }
  function createTestOne() {
    $item = array();
    $item["fields"] = array();
    return json_encode($item);
  }
  
  function createTestTwo() {
    $item = array();
    $item["fields"] = array();
    $item["limit"] = 2;
    return json_encode($item);
  
  }
  
  function createTestThree() {
    $item = array();
    $item["fields"] = array();
    $item["limit"] = 30;
    // get id of 1 and 2
    $item["fields"]["id"][] = 1;
    $item["fields"]["id"][] = 2;
    
    // get velocity score of 1 and 2
    $item["fields"]["AppDetails"][] = "velocity_score";
    $item["fields"]["AppDetails"][] = "dau";
    $item["fields"]["AppDetails"][] = "rank";
    $item["fields"]["AppDetails"][] = "title";
    $item["fields"]["velocity"] = array();
    return json_encode($item);
  }
  













?>
