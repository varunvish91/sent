#!/bin/bash

echo "testing is integer for 52"
/usr/bin/php StatsclassTests.php int 52

echo "testing is integer for 12351123"
/usr/bin/php StatsclassTests.php int 12351123

echo "testing is integer for \$123"
/usr/bin/php StatsclassTests.php int \$123


echo "testing is integer for 0.23141"
/usr/bin/php StatsclassTests.php int 0.23141


echo "testing is integer for 33:33:33"
/usr/bin/php StatsclassTests.php int 33:33:33


echo "testing is valid time for 315141413231331231"
/usr/bin/php StatsclassTests.php time 315141413231331231


echo "testing is valid time for -123411231"
/usr/bin/php StatsclassTests.php time -123411231

echo "testing is valud time for 0.5143213231"
/usr/bin/php StatsclassTests.php time 0.541432132131

echo "testing is valid time \$12341"
/usr/bin/php StatsclassTests.php time \$12341



echo "testing is valud string for \$123"
/usr/bin/php StatsclassTests.php string \$123

