<!DOCTYPE html>
<html>
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

<script type="text/javascript" src="//www.gstatic.com/authtoolkit/js/gitkit.js"></script>
<link type=text/css rel=stylesheet href="//www.gstatic.com/authtoolkit/css/gitkit.css" />

<script type=text/javascript>
  window.google.identitytoolkit.signInButton(
    '#navbar',
    {
      widgetUrl: "/gitkit/gitkit.php",
      signOutUrl: "/gitkit/index.php"
    }
  );
</script>
</head>
<body>
<div id="navbar"></div>

<!-- 2: Print the user information if a signed in user is present -->
<p>
  <?php if ($gitkitUser) { ?>
    Welcome back!<br><br>
    Email: <?= $gitkitUser->getEmail() ?><br>
    Id: <?= $gitkitUser->getUserId() ?><br>
    Name: <?= $gitkitUser->getDisplayName() ?><br>
    Identity provider: <?= $gitkitUser->getProviderId() ?><br>
	Salt: <?= $gitkitUser->getSalt() ?><br>
	Verify: <?= $gitkitUser->isEmailVerified() ?><br>
	validace: <?= $gitkitClient->validateToken(""); ?><br>
  <?php } else { ?>
    You are not logged in yet.
  <?php } ?>
</p>
<!-- End modification 2 -->

</body>
</html>