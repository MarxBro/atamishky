<?php
$header_bit=<<<EOF
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="../atamishky.css">
<title>Autentificación ATAM - UNA</title>
</head>
EOF;

#<link href='http://fonts.googleapis.com/css?family=Ruda:400,700,900' rel='stylesheet' type='text/css'>
#<link href='http://fonts.googleapis.com/css?family=Bitter:400,700,400italic' rel='stylesheet' type='text/css'>

// Generar un token unico por encuesta a rellenar
session_start();
session_set_cookie_params(1800,'tmp','mediateca.atamvirtual.com.ar');

// ID de la cookie...
$length = 25;
$randomString = substr(str_shuffle(md5(time())),0,$length);

// Exportar los valores globales, usados en index, submit (validacion), gracias y error.
$_SESSION['secreto'] = $randomString;
global $_SESSION;
global $header_bit;

?>
