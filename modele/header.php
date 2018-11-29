<?php @require('fonctions/infos.php');
@require('fonctions/core.php'); ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Resumé events</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		<link rel="stylesheet" href="<?= WebSite_Url ?>/assets/bootstrap.min.css">
		<link rel="stylesheet" href="<?= WebSite_Url ?>/assets/style.css">
		<link rel="stylesheet" href="<?= WebSite_Url ?>/assets/roles-image.css">
		<link rel="stylesheet" href="<?= WebSite_Url ?>/assets/team-color.css">
	</head>
	<body>
		<div class="container-fluid" style="padding: 0px;">
			<?php include_once("modele/nav.php"); ?>