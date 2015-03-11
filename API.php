
<?php
require('DataObject.php');
runIt();
  function runIt() {
   $returnResult;
    if (!isset($_GET['content'])) {
      $jsonContent->{"limit"} = 30;
    } else
      $jsonContent = json_decode($_GET['content']) or die ("error decoding json");
    if (!isset($jsonContent->fields) || count($jsonContent->fields) == 0) {
      $returnResult = getAllAppIdsByRank($jsonContent);
      $jsonContent->fields->AppDetails = array();
      $jsonContent->fields->SocialBrand = array();
      $jsonContent->fields->EarnedMedia = array();
      $jsonContent->fields->Velocity = array();
    }
    $returnResult = query($jsonContent);
    $stringRep = $returnResult->getResultAsString();
    if (isset($jsonContent->callback)) {
      header('Content-Type: text/javascript; charset=utf8');
      echo $jsonContent->callback.'('.$stringRep.');';
    } else {
      header('Content-Type: application/json; charset=utf8');
      echo $stringRep;
    }
   }
  function getAllAppIdsByRank($jsonContent) {
    $mysqli = new mysqli("localhost", "root", "Password1704", "API") or die ("error connecting to DB");
    $sql = "SELECT `id` FROM `AppDetails`ORDER BY `rank` ASC LIMIT 0,".$jsonContent->limit;
    $result = $mysqli->query($sql) or die ("error");
    $list = array();
    while ($row = $result->fetch_assoc()) {
      $list[] = $row['id'];
    }
    $jsonContent->fields->id =  $list;
    return $jsonContent;
  }
  

  function query($json) {
    $list = array();
    $dataList = new DataObjectsList();
    $ids = $json->fields->id;
    $mysqli = new mysqli("localhost", "root", "Password1704", "API") or die ("error connecting to DB");
    if (isset($json->fields->AppDetails)) { 
      $queryParams = $json->fields->AppDetails;
      $table = "AppDetails";
      foreach($ids as $id) {
        $sql = "SELECT ";
        if (count($queryParams) == 0) {
          $sql .= "*";
        } else {
          $sql .= "`id`,";
          for ($i = 0; $i < count($queryParams); $i++) {
            $param = $queryParams[$i];
            if ($i == 0) {
              $sql .= "`$param`";
            } else {
              $sql .= ",`$param`";
            }
          }
        }

        $sql .= " FROM `$table` WHERE `id` = '$id' LIMIT 0,". $json->limit;
        $result = $mysqli->query($sql) or die ("error\n");
        while ($row = $result->fetch_assoc()) {
          $dataList->insertDocument($id, $row);
        }
      }
    }
    
    if (isset($json->fields->Velocity)) {
      $table = "velocity";
      $queryParams = $json->fields->Velocity;
      foreach ($ids as $id) {
        $sql = "SELECT `month`, `day`, `score`  FROM `$table` WHERE `id` = '$id' LIMIT 0,".$json->limit;
        $result = $mysqli->query($sql) or die ("error");
        $index = 0;
        while ($row = $result->fetch_assoc()) {
          $dataList->insertCollection($id, $row, "Velocity", $index);
          $index++;
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
          $index = 0;
          while ($row = $result->fetch_assoc()) {
            $dataList->insertCollection($id, $row, "EarnedMedia", $index);
            $index++;
          }
        }
      } else {
        $country = $json->fields->EarnedMedia->country; 
        $sql = "SELECT `country`,`value` FROM `$table` WHERE `id` = '$id' AND `country` = '$country' LIMIT 0,".$json->limit;
        $result = $mysqli->query($sql) or die ("error");
        $index = 0;
        while($row = $result->fetch_assoc()) {
          $dataList->insertCollection($id, $row, "EarnedMedia", $index);
          $index++;
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
          $index = 0;
          while ($row = $result->fetch_assoc()) {
            $dataList->insertCollection($id, $row, "SocialBrand", $index);
            $index++;
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
          $index = 0;
          while ($row = $result->fetch_assoc()) {
            $dataList->insertCollection($id, $row, "SocialBrand", $index);
            $index++;
          }
        }
      }
    }
    return $dataList;
  }


?>
