<?php

/*define('hostname', getenv('OPENSHIFT_MYSQL_DB_HOST' || 'localhost'));
define('user', getenv('OPENSHIFT_MYSQL_DB_USERNAME' || 'admini7llZ7c'));
define('password', getenv('OPENSHIFT_MYSQL_DB_PASSWORD' || '4QAjFVA_J_uf'));
define('databaseName', getenv('OPENSHIFT_GEAR_NAME' || 'gameofflags'));
*/
$hostname = getenv('OPENSHIFT_MYSQL_DB_HOST');
$user = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
$password = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');
$databaseName = getenv('OPENSHIFT_GEAR_NAME');

// $connect = mysqli_connect(hostname, user, password, databaseName);    
$connect = mysqli_connect($hostname, $user, $password, $databaseName);  

if (!$connect) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo "Success: A proper connection to MySQL was made! The " . $databaseName . " database is great." . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($connect) . PHP_EOL;

mysqli_close($connect);      

?>

