<?php
# Nastavení a pøipojení k databázi
# Jméno hosta databáze výchozí 
$server = 'localhost';      # pokud pracujete na "vlastním" prostoru nemusíte mìnit
# pokud zpracováváte databázi z jiného serveru, uvedete URL
$dbname = 'gameofflags';    # jméno databáze
$dbuser = 'admini7llZ7c';      # uživatel databáze
$dbpass = '4QAjFVA_J_uf';      # heslo do databáze

# test a pøipojení k databázi 
MySQL_Connect($server, $dbuser, $dbpass) or die('Nepodaøilo se pøipojit k MySQL databázi'); #pøipojení k databázovému serveru
MySQL_Select_DB($dbname) or die('Nepodaøila se otevøít databáze.'); #výbìr databáze
$conn= MySQL_Connect($server, $dbuser, $dbpass); #pøipojení k databázi - vytvoøení èísla pøipojení

mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_connection=utf8");
mysql_query("SET character_set_client=utf8");

echo $conn;
?>