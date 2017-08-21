<?php
$db = require(__DIR__ . '/db.php');
// test database! Important not to run tests on production or development databases
// TODO $db['dsn'] = 'mysql:host=localhost;dbname=gg_test_yii2_tests';

return $db;