<?php

dibi::connect(array(
    'driver'   => 'mysql',
    'host'     => getenv('OPENSHIFT_MYSQL_DB_HOST'),
    'username' => getenv('OPENSHIFT_MYSQL_DB_USERNAME'),
    'password' => getenv('OPENSHIFT_MYSQL_DB_PASSWORD'),
    'database' => getenv('OPENSHIFT_GEAR_NAME'),
    'charset'  => 'utf8',
));



$vysledek = dibi::query('SELECT * FROM student WHERE age < 500');

/*
foreach ($result as $n => $row) {
    print_r($row);
}

unset($result);
*/

?>

<?php 
echo "Ahoj";

?>

<table>
<?php
//$vysledek=mysql_query("select * from student where age < 500");
  while ($zaznam=MySQL_Fetch_Array($vysledek)):
    ?>
    <TR>
      <TD><?echo $zaznam["firstname"]?></TD>
      <TD><?echo $zaznam["lastname"]?></TD>    
	  <TD><?echo $zaznam["age"]?></TD>    
    </TR>
    <?    
  endwhile;
?>