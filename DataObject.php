<?php

  class DataObject {
    public $id;
    /*public $imgUrl;
    public $description;
    public $rank;
    public $velocityScore;
    public $sentimentScore;
    public $dau;
    public $downloads;
    public $iosRev;
    public $googleRev;
    public $amazonRev;
    public $windowsRev;
    public $steamRev;
    public $inAppRev;
    public $inAppPercent;
    public $revenueSubscription;  
    public $percentSubscription;
    public $revenueInterstitial;
    public $percentInterstitial;
    public $revenuePlayable;  
    public $percentPlayable;  
    public $revenueVideoInterstitial;  
    public $percentVideoInterstitial;
    public $revenueCustomFrame;
    public $percentCustomFrame;
    public $revenueOfferWall;
    public $percentOfferWall;
    public $previousDailyRevenue;
    public $totalRevenueChannels;
    public $totalRevenueToDate;*/

    public function __construct() {}


  }
  class DataObjectsList {
    private $_list;
    private $_index;
    public function __construct() {
      $this->_list = array();
      $this->_index = "returnResult";
      $this->_list[$this->_index] = array();
    }

    public function insertDocument($id, $row) {
      foreach ($row as $key => $value) {
        $this->_list[$this->_index][$id][$key] = $value;
      }
    }

    public function insertCollection($id, $row, $title, $index) {
      if (!isset($this->_list[$this->_index][$id][$title])) {
        $this->_list[$this->_index][$id][$title] = array();
      }
      foreach ($row as $key => $value) {
        $this->_list[$this->_index][$id][$title][$index][$key] = $value;
      } 
    }

    public function getResultAsString() {
      return json_encode($this->_list, JSON_NUMERIC_CHECK);
    }
    
    public function printList() {
      print_r($this->_list);
    }


  }





?>
