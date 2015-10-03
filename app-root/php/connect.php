<?php

define('hostname', getenv('OPENSHIFT_MYSQL_DB_HOST'));
define('user', getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
define('password', getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
define('databaseName', getenv('OPENSHIFT_GEAR_NAME'));

$connect = mysqli_connect(hostname, user, password, databaseName);          

?>

