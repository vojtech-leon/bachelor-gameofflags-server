<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- 1: Load the Google Identity Toolkit helpers -->
<?php
  require_once __DIR__ . '/../../vendor/autoload.php';

  $gitkitClient = Gitkit_Client::createFromFile(dirname(__FILE__) . '/../../gitkit/gitkit-server-config.json');
?>
<!-- End modification 1 -->

    <style type="text/css">
        #vypis, #vypis td, #vypis th {border-style: solid; border-collapse: collapse;}
        #token  {max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}
    </style>
</head>
<body>
<div id="navbar"></div>

<!-- 2: Print the user information if a signed in user is present -->
<p>
<?php

function validate($token)
{
	$gitkitClient = Gitkit_Client::createFromFile(dirname(__FILE__) . '/../../gitkit/gitkit-server-config.json');
    return $gitkitClient->validateToken($token);
}
echo "<form method=post action=validate.php><table>".
    "<tr><td>Token:</td><td><input type=text name='token' value=''></td></tr>".
    "<tr><td colspan=2><input type=submit name='validateToken' value='Validuj'></td></tr>".
    "</table></form>";

if (isset($_POST['validateToken']))
{
    try {
		 $token = $_POST["token"];
		$ano = validate($token);
		if ($ano) {
			echo "Token je správný.<br>";
            echo $gitkitClient->validateToken($token)->getUserId();
		} else {
			echo "Nezadal jsi token.<br>";
		}
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}


}
else
{
    echo "<p>Neklikl jsi na tlačítko.<br>";
}

?>
    <?php
    try {
        $token = $gitkitClient->getTokenString();
        if ($token) {
            echo "<br><br>";
            echo "Token: " . $token . "<br>";
        } else {
            echo "<br>Nejsi přihlášen.<br>";
        }
    }catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
    ?>
<br><br>
<?php
echo "<form method=post action=validate.php><table>".
    "<tr><td>Smazat UserID:</td><td><input type=text name='id' value=''></td></tr>".
    "<tr><td colspan=2><input type=submit name='deleteUser' value='Smaz'></td></tr>".
    "</table></form>";

if (isset($_POST['deleteUser']))
{
    try {
		 $id = $_POST["id"];
		 $gitkitClient->deleteUser($id);
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}


}
?>
<br><br>
   <div style="font-weight: bold"> Seznam lidí:</div>
<br />
    <?php
    // ---- download account ----
    $iterator = $gitkitClient->getAllUsers();
    ?>
    <table id="vypis">
        <thead>
            <th>UserId</th>
            <th>E-mail</th>
            <th>Jméno</th>
            <th>Provider</th>
            <th>Password-hash</th>
            <th>Salt</th>
            <th>PhotoUrl</th>
        </thead>
        <tbody>

<?php
    while ($iterator->valid()) {
        $user = $iterator->current();
        echo "<tr>";
        echo "<td>".$user->getUserId()."</td>";
        echo "<td>".$user->getEmail()."</td>";
        echo "<td>".$user->getDisplayName()."</td>";
        echo "<td>".$user->getProviderId()."</td>";
        echo "<td>".$user->getPasswordHash()."</td>";
        echo "<td>".$user->getSalt()."</td>";
        echo "<td id='token'>".$user->getPhotoUrl()."</td>";
        echo "</tr>";
    // $user is a Gitkit_Account object
     $iterator->next();
    }
?>
        </tbody>
    </table>
</p>
<!-- End modification 2 -->

</body>
</html>