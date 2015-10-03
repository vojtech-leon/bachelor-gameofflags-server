<?php

define('hostname', 'OPENSHIFT_MYSQL_DB_HOST');
define('user', 'OPENSHIFT_MYSQL_DB_USERNAME');
define('password', 'OPENSHIFT_MYSQL_DB_PASSWORD');
define('databaseName', 'gameofflags');

$connect = mysqli_connect(hostname, user, password, databaseName);          

?>

