<?php 
echo "Ahoj";

?>
<?php 
include 'dibi.min.php';
?>
<?php
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

