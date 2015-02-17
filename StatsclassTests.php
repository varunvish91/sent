<?php
  include 'Stats.class.php';
  
  // 1 - type of test, int, time, string
  // 2 - input

  switch ($argv[1]) {
    case 'int':
      exerciseValidInt($argv[2]);
      break;
    case 'time':
      exerciseValidTime($argv[2]);
      break;
    case 'string':
      exerciseValidString($argv[2]);
      break;
  }

  function exerciseValidInt($val) {
    if (Stats::isValidInteger($val)) {
      echo "is a valid integer" . PHP_EOL;
    } else {
      echo "is not a valid integer". PHP_EOL;
    }
  }

  function exerciseValidTime($val) {
    echo Stats::isValidTime($val);

  }

  function exerciseValidString ($val) {
    echo Stats::isValidString($val);
  }
?>
