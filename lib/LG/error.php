<!DOCTYPE html>
<?php
include("verif.inc");
session_unset();
session_destroy();
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Ups!</title>
</head>
<body>
	<div>
		<p>Ocurrió un error en el envío del formulario.</p>
		<p>Intente nuevamente.</p>
	</div>
</body>
</html>
