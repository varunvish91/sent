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
  
  echo "TestOne\n";
  $data = createTestOne();
  $_GET['content'] = $data;
  runIt();

  echo "TestZero\n";
  $data = createTestZero();
  $_GET['content'] = $data;
  runIt();
  
  
  function runIt() { 
    if (isset($_GET['content'])) {
      $jsonContent = json_decode($_GET['content']);
      // get the Fields, this is required
      if (isset($jsonContent->fields)) {

      } else {
        echo "Required Fields entry\n";
      }

      print_r($jsonContent);
      $mysqli = new mysqli("localhost", "root", "Password1704", "API") or die ("error connecting to DB");
  
  
    }
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
















?>
