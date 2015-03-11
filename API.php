
<?php

runIt();
  function runIt() {
   $returnResult;
    if (isset($_GET['content'])) {
      $jsonContent = json_decode($_GET['content']) or die ("error decoding json");
      // get the Fields, this is required
      if (isset($jsonContent->fields)) {
        if (count($jsonContent->fields) == 0) {
          echo "Full DB scan not available yet";
          //$returnResult = getAllFields($jsonContent->limit, $mysqli); 
        
        } else {
          $returnResult = query($jsonContent); 
          if (isset($jsonContent->callback)) {
            header('Content-Type: text/javascript; charset=utf8');
            echo $jsonContent->callback.'('.json_encode($returnResult).');';
            
          } else {
            header('Content-Type: application/json; charset=utf8');
            echo json_encode($returnResult);
          }
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

    if (isset($json->fields->EarnedMedia)) {
      $table = "EarnedMedia";
      $queryParams = $json->fields->EarnedMedia;
      // pull everything for that id where country = something
      if (count($json->fields->EarnedMedia) == 0) {
        // pull everything forthe users
        foreach($ids as $id) {
          $sql = "SELECT `country`, `value` FROM `$table` WHERE `id` = '$id' LIMIT 0,".$json->limit;
          $result = $mysqli->query($sql) or die ("error");
          while ($row = $result->fetch_assoc()) {
            $list[$id]['earnedMedia'][] = $row;
          }
        }
      } else {
        $country = $json->fields->EarnedMedia->country; 
        $sql = "SELECT `country`,`value` FROM `$table` WHERE `id` = '$id' AND `country` = '$country' LIMIT 0,".$json->limit;
        $result = $mysqli->query($sql) or die ("error");
        while($row = $result->fetch_assoc()) {
          $list[$id]['earnedMedia'][] = $row;
        }
      }
    }

    if (isset($json->fields->SocialBrand)) {
      $table = "SocialBrand";
      $queryParams = $json->fields->EarnedMedia;
      if (count($json->fields->SocialBrand) == 0) {
        // db read
        foreach($ids as $id) {
          $sql = "SELECT * FROM `SocialBrand` WHERE `id` = '$id' LIMIT 0,". $json->limit;
          $result = $mysqli->query($sql) or die ("error\n");
          while ($row = $result->fetch_assoc()) {
            $list[$id]['socialBrand'][] = $row;
          }
        } 
      
      } else {
        foreach($ids as $id) { 
          $sql = "SELECT ";
          $where = " WHERE ";
          foreach ($json->fields->SocialBrand as $key => $value) {
            $sql .= "`$key`, ";
            $where .= "`$key` = '$value',";
          }
          $sql = substr($sql, 0, -2);
          $sql .= " FROM `$table`";

          $where = substr($where, 0, -1);
          $sql .= $where . " AND `id` = '$id' LIMIT 0,". $json->limit; 
        
          $result = $mysqli->query($sql) or die ("error\n");
          while ($row = $result->fetch_assoc()) {
            $list[$id]['socialBrand'][] = $row;
          }
      
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
    $item['callback'] = "receiver";
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
