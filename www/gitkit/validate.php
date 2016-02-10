<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- 1: Load the Google Identity Toolkit helpers -->
<?php
  set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ .'/vendor/google/apiclient/src');
  require_once __DIR__ . '/vendor/autoload.php';

  $gitkitClient = Gitkit_Client::createFromFile(dirname(__FILE__) . '/gitkit-server-config.json');
  $gitkitUser = $gitkitClient->getUserInRequest();
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
    $gitkitClient = Gitkit_Client::createFromFile(dirname(__FILE__) . '/gitkit-server-config.json');
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


eyJhbGciOiJSUzI1NiIsImtpZCI6ImJMOTJtZyJ9.eyJpc3MiOiJodHRwczovL2lkZW50aXR5dG9vbGtpdC5nb29nbGUuY29tLyIsImF1ZCI6IjYxMTM0NzM3Njg1OC1nMnFncHQxNGZmMjBubDFlb24wbm9scXRoaHNmcTJhbC5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsImlhdCI6MTQ1MTA5NDMyMSwiZXhwIjoxNDUyMzAzOTIxLCJ1c2VyX2lkIjoiMDIwMDYwMzI2ODQyMjQwNjkyMDUiLCJlbWFpbCI6InZ2QHZ2LnZ2IiwidmVyaWZpZWQiOmZhbHNlLCJkaXNwbGF5X25hbWUiOiJ2dnZ2dnYifQ.OKERvBcDxT7-4g5bNrNRUWrIzFNVtSVOgSjhjPacqA0nsabqlgrGi3TN6ci-4oltc_FTy7t1QBZVglNDploULhM93IKr5hdPIgsoZu92IrFjKDECPwBcX27CwfVJMI6DngU0Ytvt9_ybvu730q0ladiieF69qnnYG_1NVLqv_lLqK7GFteuSUICl_EXljLPneFMjfzS2hW9COZMnItHaCbIuVfzb28MQcUMoFz9oxEj65nz_DL6ZnF3wF5pZRG5BCpx73RzENIpud1ISMzGMpIoQZQxkQXHpTgo1eeX7Lv42cAooba4SJqHoMPOVFP3wKU2ghQZevwnTuB-LHTQW2Q
<br><br>
eyJhbGciOiJSUzI1NiIsImtpZCI6ImJMOTJtZyJ9.eyJpc3MiOiJodHRwczovL2lkZW50aXR5dG9vbGtpdC5nb29nbGUuY29tLyIsImF1ZCI6IjYxMTM0NzM3Njg1OC1nMnFncHQxNGZmMjBubDFlb24wbm9scXRoaHNmcTJhbC5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsImlhdCI6MTQ1MTA5Njc0NSwiZXhwIjoxNDUyMzA2MzQ1LCJ1c2VyX2lkIjoiMDIwMDYwMzI2ODQyMjQwNjkyMDUiLCJlbWFpbCI6InZ2QHZ2LnZ2IiwidmVyaWZpZWQiOmZhbHNlLCJkaXNwbGF5X25hbWUiOiJ2dnZ2dnYifQ.OFHWkEX8eElzCupNj1mFJYnVS7ZssTuHM86Ycfs-OtmXa-678pt7Gpmi6YS3bwunrD73P-O_f3jtVOdzuXgJDnbUQuYRaZ3ixYh3Qu_am4yTuP7ufT7Mr6SM9d3co-4KRBQaO1WMurazgYXrq_kfP28BHT0p50GxGhXu0pveMeAHFlC8XjIyu0SLH-1V1OVqZCUkGjCaUwaCLezhSKspMA_xCzjgHAAgRuVYz0GJ5xLQIQFs5TJANmTTRYXQvpmjtPfoWiAi0tYEMrf_GJEQownCdejJoMDcmxgdamf7RYD_x4_Td89IrmUKiHgTpRnz08OBE-Xh4H-uzIwE_umoQQ
<br>aaaaaa - 26.12.<br>
eyJhbGciOiJSUzI1NiIsImtpZCI6ImJMOTJtZyJ9.eyJpc3MiOiJodHRwczovL2lkZW50aXR5dG9vbGtpdC5nb29nbGUuY29tLyIsImF1ZCI6IjYxMTM0NzM3Njg1OC1nMnFncHQxNGZmMjBubDFlb24wbm9scXRoaHNmcTJhbC5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsImlhdCI6MTQ1MTA5Njg4MywiZXhwIjoxNDUyMzA2NDgzLCJ1c2VyX2lkIjoiMTEyMDg1OTcwODc4NDU2MzU2ODAiLCJlbWFpbCI6ImFhQGFhLmFhIiwidmVyaWZpZWQiOmZhbHNlLCJkaXNwbGF5X25hbWUiOiJhYWFhYWEifQ.Hyjas-1IwDcYCG54nDYqJ0Sc7pAkmzhMLeE9V1pelFQtmkhazgNHKN0pyzv3wa7k6KkIJxA1ffDj4g9oPH9A3K1z2mh83ZqTYWaQ4tp7ov1Dm_68c_CgUzerOsuEFn5h7KEHQcfmWgghjemMXC3mUDgIKpPg_b1HIt-XJ7YHC_1rhvTHIfjAaQiEAMWhZy3p_FlQlpETrugdwKnZWjKiYXPiH2Rg7gTbujXSYYP7hDHMT_P4FZE4ecol_aWaVz-VqDQo7rJlr3B8jWYzaUUr6y-43oEhW6LUPW9nuC7_jg7v8m-jdP2yIE6QA_v8kOas4qW7ZLBWuY2uKImXzwF47Q
<br>aaaaaa - 26.12. - odpoledne<br>
eyJhbGciOiJSUzI1NiIsImtpZCI6ImJMOTJtZyJ9.eyJpc3MiOiJodHRwczovL2lkZW50aXR5dG9vbGtpdC5nb29nbGUuY29tLyIsImF1ZCI6IjYxMTM0NzM3Njg1OC1nMnFncHQxNGZmMjBubDFlb24wbm9scXRoaHNmcTJhbC5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsImlhdCI6MTQ1MTE0OTc5OSwiZXhwIjoxNDUyMzU5Mzk5LCJ1c2VyX2lkIjoiMTEyMDg1OTcwODc4NDU2MzU2ODAiLCJlbWFpbCI6ImFhQGFhLmFhIiwidmVyaWZpZWQiOmZhbHNlLCJkaXNwbGF5X25hbWUiOiJhYWFhYWEifQ.O3oZrnULZCbrdLneE7Fi7OKlrmyXQr4NdhFOKv3ld1Op3sKrohyLj-hWQV530EPPPtA7i8zOEsTYSvK2DC19DJynyPeHr_kEL07VJHz6DST-t97udhdrfvFxs4lbAc_C5vJroPI5m_zhsP5Z4oniZ3-TMyLdO9GRXJqlKTsWVV24ka4gJQXO4CLdHjlPWPso4H2Il9ORxpPQQiEty7vvyebfIKcnyH2lFiZpPR1UKo2F2DPHerGWWSkLNvQakWBiZyg3lOPnG9Ayo1pQUlwvXfDrexQPpToWZwbyN-58zO0J7IwC_I6kqpZ64BYgfw53EftySebYkTuc046JKh1i1Q