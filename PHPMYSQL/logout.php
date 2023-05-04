<?php 

error_reporting(E_ALL &~E_NOTICE);

session_start();
unset($_SESSION);
session_destroy();
?>
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Logout libreria</title>
	<link rel="stylesheet" href="cssesterno.css" type="text/css" />
</head>

<body style="background-color:white;">

	<div style="border-radius:10px;background-image:url('./immagini/libreria.jpg');height:30%;width:100%;justify-content:left;padding-left:10px;background-size:100%;margin-bottom:20px;">
		<p style="text-align:left;font-size:40px;font-family:georgia,serif;color:white;">
		<img src="./immagini/logo.png" width="10%" align="left"/>
		&nbsp;Libreria</p>
	</div>
	
	<div style="border-radius:10px;background-image:url('./immagini/libreria.jpg');width:100%;justify-content:center;padding-left:10px;background-size:100%;">
	<h1 style="width:100%">Grazie della visita!</h1>
	<a href='login.php' style="width:25%;">
	<button class="button" style="width:100%;border-right:2px solid red;">Torna al login</button></a>
	</div>


</body>
</html>