<?php
# Nastaven� a p�ipojen� k datab�zi
# Jm�no hosta datab�ze v�choz� 
$server = 'localhost';      # pokud pracujete na "vlastn�m" prostoru nemus�te m�nit
# pokud zpracov�v�te datab�zi z jin�ho serveru, uvedete URL
$dbname = 'gameofflags';    # jm�no datab�ze
$dbuser = 'admini7llZ7c';      # u�ivatel datab�ze
$dbpass = '4QAjFVA_J_uf';      # heslo do datab�ze

# test a p�ipojen� k datab�zi 
MySQL_Connect($server, $dbuser, $dbpass) or die('Nepoda�ilo se p�ipojit k MySQL datab�zi'); #p�ipojen� k datab�zov�mu serveru
MySQL_Select_DB($dbname) or die('Nepoda�ila se otev��t datab�ze.'); #v�b�r datab�ze
$conn= MySQL_Connect($server, $dbuser, $dbpass); #p�ipojen� k datab�zi - vytvo�en� ��sla p�ipojen�

mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_connection=utf8");
mysql_query("SET character_set_client=utf8");
?>
<table>
<?php
$vysledek=mysql_query("select * from student where age < 500");
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