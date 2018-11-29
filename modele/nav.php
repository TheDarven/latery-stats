<?php function taupe_win($uuid){
	global $db,$core;
	$victoire = 0;
	$sql = $db->prepare('SELECT * FROM site_taupe WHERE uuid = ?');
	$sql->execute(array($uuid));
	while($taupe = $sql->fetch(PDO::FETCH_OBJ)) { 
		$sql1 = $db->prepare('SELECT * FROM site_equipe WHERE id = ?');
		$sql1->execute(array($taupe->id_team));

		if($sql1->fetch(PDO::FETCH_OBJ)->nom == $core->equipe_taupe_gagnante($taupe->id_partie) && $taupe->taupe == 0){
			$victoire += 1;
		}else if($taupe->taupe != 0 && $core->equipe_taupe_gagnante($taupe->id_partie) == "Taupe ".$taupe->taupe){
			$victoire += 1;
		}else if($taupe->supertaupe != 0 && $core->equipe_taupe_gagnante($taupe->id_partie) == "Supertaupe ".$taupe->supertaupe){
			$victoire += 1;
		}
		// Equipe gagnante de la partie == son équipe && par taupe
		// Equipe gagnante de la partie taupe && il est taupe && même nombre
		// Equipe gagnante de la partie supertaupe && il est supertaupe && même nombre
	}
	return $victoire;
} 

function lg_win($uuid){
	global $db;
	$sql = $db->prepare('SELECT COUNT(id_partie) as victoire FROM site_role WHERE uuid = ? AND mort = ?');
	$sql->execute(array($uuid,0));
	return $sql->fetch(PDO::FETCH_OBJ)->victoire;
} ?>

<div class="categorie-navigation">
	<div>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  	<a href="<?= WebSite_Url ?>/index">
		  		<img src="<?= WebSite_Url ?>/assets/images/latery.png">
		  	</a>
		  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
		    	<span class="navbar-toggler-icon"></span>
		 	</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
				    <a class="nav-item nav-link <?php if($page == "index"){ echo "active"; } ?>" href="<?= WebSite_Url ?>/index">Index</a>
				    <a class="nav-item nav-link <?php if($page == "joueurs"){ echo "active"; } ?>" href="<?= WebSite_Url ?>/joueurs">Joueurs</a>
				    <a class="nav-item nav-link <?php if($page == "taupegun"){ echo "active"; } ?>" href="<?= WebSite_Url ?>/taupegun">Taupegun</a>
				    <a class="nav-item nav-link <?php if($page == "lguhc"){ echo "active"; } ?>" href="<?= WebSite_Url ?>/loupgarou">Lguhc</a>
				    <a class="nav-item nav-link d-xl-none d-lg-none d-sm-block d-xm-block" href="https://discord.gg/HZyS5T7" target="_blank" style="color: #5B6EAD;">Discord</a>
				</div>
			</div>
			<a class="d-xl-block d-lg-block d-sm-none d-none" href="https://discord.gg/HZyS5T7" target="_blank">
				<img src="<?= WebSite_Url ?>/assets/images/discord.svg">
			</a>
		</nav>
	</div>
</div>
<div class="d-lg-block d-md-block d-sm-block d-none banniere">
	<div class="container">
		<h1>Events Latery</h1>
		<h4>Des statistiques sur vos parties</h4>
	</div>
</div>
<div class="d-lg-none d-md-none d-sm-none d-block" style="height: 50px;"></div>