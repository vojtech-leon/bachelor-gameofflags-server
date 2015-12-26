<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<!-- Copy and paste here the client configuration from Developer Console into the config variable -->
<script type="text/javascript" src="//www.gstatic.com/authtoolkit/js/gitkit.js"></script>
<link type="text/css" rel="stylesheet" href="//www.gstatic.com/authtoolkit/css/gitkit.css" />
<script type="text/javascript">
  var config =
    // Copy and paste client configuration here
	{
  "widgetUrl": "http://gameofflags-vojtele1.rhcloud.com/gitkit/gitkit.php",
  "signInSuccessUrl": "http://gameofflags-vojtele1.rhcloud.com/gitkit",
  "signOutUrl": "http://gameofflags-vojtele1.rhcloud.com/gitkit",
  "oobActionUrl": "/",
  "apiKey": "AIzaSyARf53ZPZ8-YOzpAwxrqmTuWz0cTKozoOQ",
  "siteName": "this site",
  "signInOptions": ["password","google","facebook"]
}
  ;
  // The HTTP POST body should be escaped by the server to prevent XSS
  window.google.identitytoolkit.start(
      '#gitkitWidgetDiv', // accepts any CSS selector
      config,
      JSON.parse('<?php echo json_encode(file_get_contents("php://input")); ?>')
  );
</script>
<!-- End modification -->

</head>
<body>

<!-- Include the sign in page widget with the matching 'gitkitWidgetDiv' id -->
<div id="gitkitWidgetDiv"></div>
<!-- End identity toolkit widget -->

</body>
</html>