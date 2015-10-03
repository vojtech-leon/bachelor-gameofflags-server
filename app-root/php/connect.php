<?php

define('hostname', getenv('OPENSHIFT_MYSQL_DB_HOST' || 'localhost'));
define('user', getenv('OPENSHIFT_MYSQL_DB_USERNAME' || 'admini7llZ7c'));
define('password', getenv('OPENSHIFT_MYSQL_DB_PASSWORD' || '4QAjFVA_J_uf'));
define('databaseName', getenv('OPENSHIFT_GEAR_NAME' || 'gameofflags'));

$connect = mysqli_connect(hostname, user, password, databaseName);          

?>

