<?php 
include 'dibi.min.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1;">
  <title>Welcome to my project</title>
<body>
Hello!
Tady asi časem něco dodám.
<?php
error_reporting(E_ALL);
/*
dibi::connect(array(
    'driver'   => 'mysql',
    'host'     => getenv('OPENSHIFT_MYSQL_DB_HOST'),
    'username' => getenv('OPENSHIFT_MYSQL_DB_USERNAME'),
    'password' => getenv('OPENSHIFT_MYSQL_DB_PASSWORD'),
    'database' => getenv('OPENSHIFT_GEAR_NAME'),
    'charset'  => 'utf8',
));
*/
dibi::connect(array(
    'driver'   => 'mysql',
    'host'     => 'localhost',
    'username' => 'admini7llZ7c',
    'password' => '4QAjFVA_J_uf',
    'database' => 'gameofflags',
    'charset'  => 'utf8',
));

$result = dibi::query('SELECT * FROM student WHERE age < 500');


foreach ($result as $n => $row) {
    print_r($row);
}

unset($result);


?>

</body>
</html>

