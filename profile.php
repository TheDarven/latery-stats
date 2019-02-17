<?php $page = "joueurs";
include('modele/header.php');

if(!isset($_GET['pseudo'])){
	$core->Redirect(WebSite_Url); 
}


$pseudo = $core->Secu($_GET['pseudo']);
$uuid = "ERROR_UUID";

$sql = $db->prepare('SELECT * FROM site_joueur WHERE pseudo = ?');
$sql->execute(array($pseudo));
if($sql->rowCount() == 0){
	$core->Redirect(WebSite_Url);
}else{
	$uuid = $sql->fetch(PDO::FETCH_OBJ)->uuid;
	$cache = 'cache/profile'.$uuid.'.txt';
	$expire = time() - 86400;
	if(!(file_exists($cache) && filemtime($cache) > $expire)){
		$new_pseudo = $core->getPseudo(str_replace("-", "", $uuid));
		if(!strpos($new_pseudo != $pseudo && $new_pseudo,"UUID incorrect !")){
			ob_start(); // ouverture du tampon
			$new_pseudo = str_replace("?","",utf8_decode($new_pseudo));
			$sql1 = $db->prepare('UPDATE site_joueur SET pseudo = ? WHERE uuid = ?');
			$sql1->execute(array($new_pseudo,$uuid));
			$sql1->closeCursor();
		        
		    $page = ob_get_contents(); // copie du contenu du tampon dans une chaîne
		    ob_end_clean(); // effacement du contenu du tampon et arrêt de son fonctionnement
		        
		    file_put_contents($cache, $page) ; // on écrit la chaîne précédemment récupérée ($page) dans un fichier ($cache)
		    $core->Redirect(WebSite_Url."/profile/".urlencode($new_pseudo));
		}
	}
}
$sql->closeCursor();
			$sql = $db->prepare('SELECT * FROM site_joueur WHERE uuid = ?');
			$sql->execute(array($uuid));
			while($joueur = $sql->fetch(PDO::FETCH_OBJ)) { ?>
				<div class="d-flex justify-content-center flex-wrap categorie-partie" style="margin-top: -10px;">
					<div class="col-lg-9 col-md-9 col-sm-12 col-12">
						<div class="container" style="padding: 0px;">
							<div class="row">
								<div class="col-lg-9 col-md-9 col-sm-12 col-12">
									<h4 class="separation-profil">Taupegun</h4>
									<div class="row statistiques-profil">
										<?php $sql1 = $db->prepare('SELECT SUM(kills) as total_kills FROM site_taupe WHERE uuid = ?');
										$sql1->execute(array($uuid));
										$taupe_kills = $sql1->fetch(PDO::FETCH_OBJ)->total_kills;
										if($taupe_kills == null){
											$taupe_kills = 0;
										}
										$sql1->closeCursor(); 

										$sql1 = $db->prepare('SELECT SUM(mort) as total_mort FROM site_taupe WHERE uuid = ?');
										$sql1->execute(array($uuid));												
										$taupe_morts = $sql1->fetch(PDO::FETCH_OBJ)->total_mort;
										if($taupe_morts == null){
											$taupe_morts = 0;
										}
										$sql1->closeCursor(); 

										$sql1 = $db->prepare('SELECT COUNT(id_partie) as total_partie FROM site_taupe WHERE uuid = ?');
										$sql1->execute(array($uuid));
										$taupe_partie = $sql1->fetch(PDO::FETCH_OBJ)->total_partie;
										if($taupe_partie == null){
											$taupe_partie = 0;
										}
										$sql1->closeCursor(); 

										$sql1 = $db->prepare('SELECT COUNT(id_partie) as total_taupe FROM site_taupe WHERE uuid = ? AND taupe > ?');
										$sql1->execute(array($uuid,0));
										$taupe_taupe = $sql1->fetch(PDO::FETCH_OBJ)->total_taupe;
										if($taupe_taupe == null){
											$taupe_taupe = 0;
										}
										$sql1->closeCursor();

										$sql1 = $db->prepare('SELECT COUNT(id_partie) as total_supertaupe FROM site_taupe WHERE uuid = ? AND supertaupe > ?');
										$sql1->execute(array($uuid,0));
										$taupe_supertaupe = $sql1->fetch(PDO::FETCH_OBJ)->total_supertaupe;
										if($taupe_supertaupe == null){
											$taupe_supertaupe = 0;
										}
										$sql1->closeCursor(); ?>

										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
											<h5>Dernière partie</h5>
											<?php $sql1 = $db->prepare('SELECT * FROM site_partie WHERE type = ? ORDER BY id DESC LIMIT 1');
											$sql1->execute(array("taupegun")); ?>
											<p><?php echo date('d/m/y',$sql1->fetch(PDO::FETCH_OBJ)->debut); ?></p>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
											<h5>Nombre de partie</h5>
											<p><?php echo $taupe_partie; ?></p>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
											<h5>Nombre de victoire</h5>
											<p><?php echo taupe_win($uuid); ?></p>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
											<h5>Ratio V/D</h5>
											<p>
												<?php if($taupe_partie-taupe_win($uuid) > 0){
													echo round((taupe_win($uuid))/($taupe_partie-taupe_win($uuid)),2);
												}else{
													echo taupe_win($uuid);
												}
												$sql1->closeCursor(); ?>
											</p>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
											<h5>Nombre de meutre</h5>
											<p>
												<?php echo $taupe_kills;
												if($taupe_kills > 1){
													echo " kills";
												}else{
													echo " kill";
												} ?>
											</p>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
											<h5>Nombre de mort</h5>
											<p>
												<?php echo $taupe_morts;
												if($taupe_morts > 1){
													echo " morts";
												}else{
													echo " mort";
												} ?>
											</p>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
											<h5>Nombre de meurtre par partie</h5>
											<p>
												<?php if($taupe_partie > 0){
													echo round(($taupe_kills/$taupe_partie),2);
												}else{
													echo $taupe_kills;
												} ?>
											</p>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
											<h5>Ratio K/D</h5>
											<p>
												<?php if($taupe_morts > 0){
													echo round($taupe_kills/$taupe_morts,2);
												}else{
													echo $taupe_kills;
												} ?>
											</p>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
											<h5>Nombre de fois Taupe</h5>
											<p><?php echo $taupe_taupe; ?></p>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
											<h5>Nombre de fois Supertaupe</h5>
											<p><?php echo $taupe_supertaupe; ?></p>
										</div>
									</div>
									<h4 class="separation-profil">Lguhc</h4>
									<div class="row statistiques-profil">
										<?php $sql1 = $db->prepare('SELECT SUM(kills) as total_kills FROM site_role WHERE uuid = ?');
										$sql1->execute(array($uuid));
										$role_kills = $sql1->fetch(PDO::FETCH_OBJ)->total_kills;
										if($role_kills == null){
											$role_kills = 0;
										}
										$sql1->closeCursor(); 

										$sql1 = $db->prepare('SELECT SUM(mort) as total_mort FROM site_role WHERE uuid = ?');
										$sql1->execute(array($uuid));												
										$role_morts = $sql1->fetch(PDO::FETCH_OBJ)->total_mort;
										if($role_morts == null){
											$role_morts = 0;
										}
										$sql1->closeCursor(); 

										$sql1 = $db->prepare('SELECT COUNT(id_partie) as total_partie FROM site_role WHERE uuid = ?');
										$sql1->execute(array($uuid));
										$role_partie = $sql1->fetch(PDO::FETCH_OBJ)->total_partie;
										if($role_partie == null){
											$role_partie = 0;
										}
										$sql1->closeCursor(); ?>

										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
											<h5>Dernière partie</h5>
											<?php $sql1 = $db->prepare('SELECT * FROM site_partie WHERE type = ? ORDER BY id DESC LIMIT 1');
											$sql1->execute(array("taupegun")); ?>
											<p><?php echo date('d/m/y',$sql1->fetch(PDO::FETCH_OBJ)->debut); ?></p>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
											<h5>Nombre de partie</h5>
											<p><?php echo $role_partie; ?></p>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
											<h5>Nombre de victoire</h5>
											<p><?php echo taupe_win($uuid); ?></p>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
											<h5>Ratio V/D</h5>
											<p>
												<?php if($role_partie-taupe_win($uuid) > 0){
													echo round((taupe_win($uuid))/($role_partie-taupe_win($uuid)),2);
												}else{
													echo taupe_win($uuid);
												}
												$sql1->closeCursor(); ?>
											</p>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
											<h5>Nombre de meutre</h5>
											<p>
												<?php echo $role_kills;
												if($role_kills > 1){
													echo " kills";
												}else{
													echo " kill";
												} ?>
											</p>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
											<h5>Nombre de mort</h5>
											<p>
												<?php echo $role_morts;
												if($role_morts > 1){
													echo " morts";
												}else{
													echo " mort";
												} ?>
											</p>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
											<h5>Nombre de meurtre par partie</h5>
											<p>
												<?php if($role_partie > 0){
													echo round(($role_kills/$role_partie),2);
												}else{
													echo $role_kills;
												} ?>
											</p>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
											<h5>Ratio K/D</h5>
											<p>
												<?php if($role_morts > 0){
													echo round($role_kills/$role_morts,2);
												}else{
													echo $role_kills;
												} ?>
											</p>
										</div>
									</div>
									<div class="container">
										<div class="d-flex justify-content-center flex-wrap profile-lguhc" style="max-width: 100%;">
											<?php $sql1 = $db->query('SELECT * FROM site_role_class ORDER BY position');
											while($role = $sql1->fetch(PDO::FETCH_OBJ)) { ?>
												<?php $sql2 = $db->prepare('SELECT * FROM site_role WHERE nom = ? AND uuid = ?');
												$sql2->execute(array($role->nom_plugin,$uuid)); ?>
												<div class="carte-partie" style="position: relative;">
													<span class="popup"><?php echo $role->nom_plugin; ?></span>
													<?php if($sql2->rowCount() == 0){ ?>
														<div class="carte role-<?php echo $role->nom_class; ?>" style="filter: grayscale(1);">
														</div>
													<?php }else{ ?>
														<div class="carte role-<?php echo $role->nom_class; ?>">
															<div class="nombre"><?php echo $sql2->rowCount(); ?></div>
														</div>
													<?php }
													$sql2->closeCursor(); ?>
												</div>
											<?php } 
											$sql1->closeCursor(); ?>
										</div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-12 col-12">
									<?php $sql1 = $db->prepare('SELECT SUM(kills) as total_kills FROM (SELECT kills,id_partie FROM site_taupe WHERE uuid = ? UNION SELECT kills,id_partie FROM site_role WHERE uuid = ?) A');
									$sql1->execute(array($uuid,$uuid));
									$total_kills = $sql1->fetch(PDO::FETCH_OBJ)->total_kills;
									if($total_kills == null){
										$total_kills = 0;
									}
									$sql1->closeCursor(); 

									$sql1 = $db->prepare('SELECT SUM(mort) as total_mort FROM (SELECT mort,id_partie FROM site_taupe WHERE uuid = ? UNION SELECT mort,id_partie FROM site_role WHERE uuid = ?) A');
									$sql1->execute(array($uuid,$uuid));												
									$total_morts = $sql1->fetch(PDO::FETCH_OBJ)->total_mort;
									if($total_morts == null){
										$total_morts = 0;
									}
									$sql1->closeCursor(); ?>

									<h4 class="separation-profil">Informations</h4>
									<div class="row statistiques-profil">
										<div style="text-align: center;" class="col-lg-12 col-md-12 col-sm-12 col-12">
											<img src="<?= WebSite_Url ?>/assets/images/lazy-head.png" data-original="https://crafatar.com/avatars/<?php echo $joueur->uuid; ?>" style="height: 64px; border-radius: 3px;" class="lazy">
											<h5 style="color: rgb(33, 37, 41); font-family: inherit; font-size: 1.25rem; font-weight: inherit; margin-bottom: 10px;"><?php echo $pseudo; ?></h5>
										</div>
										<div class="col-lg-6 col-md-12 col-sm-6 col-6">
											<h5>Temps de jeu</h5>
											<p>
												<?php $timeplay = $joueur->time_play/60;
												if($timeplay < 60){
													echo(round($timeplay)."min");
												}else{
													echo(round($timeplay/60)."h");
												} ?>
											</p>
										</div>
										<div class="col-lg-6 col-md-12 col-sm-6 col-6">
											<h5>Dernière connexion</h5>
											<p><?php echo date('d/m/y',$joueur->last); ?></p>
										</div>
										<div class="col-lg-6 col-md-12 col-sm-6 col-6">
											<h5>Nombre de meurtre</h5>
											<p>
												<?php echo $total_kills;
												if($total_kills > 1){
													echo " kills";
												}else{
													echo " kill";
												} ?>
											</p>
										</div>
										<div class="col-lg-6 col-md-12 col-sm-6 col-6">
											<h5>Nombre de mort</h5>
											<p>
												<?php echo $total_morts;
												if($total_morts > 1){
													echo " morts";
												}else{
													echo " mort";
												} ?>
											</p>
										</div>
										<div class="col-lg-6 col-md-12 col-sm-6 col-6">
											<h5>Ratio K/D</h5>
											<p>
												<?php if($total_morts > 0){
													echo round($total_kills/$total_morts,2);
												}else{
													echo $total_kills;
												} ?>
											</p>
										</div>
										<div class="col-lg-6 col-md-12 col-sm-6 col-6">
											<h5>Ratio V/D</h5>
											<p>
												<?php $sql1 = $db->prepare('SELECT COUNT(id_partie) as total_partie FROM (SELECT id_partie FROM site_taupe WHERE uuid = ? UNION SELECT id_partie FROM site_role WHERE uuid = ?) A');
												$sql1->execute(array($uuid,$uuid));
												$total_partie = $sql1->fetch(PDO::FETCH_OBJ)->total_partie;
												if($total_partie-taupe_win($uuid)-lg_win($uuid) > 0){
													echo round((taupe_win($uuid)+lg_win($uuid))/($total_partie-taupe_win($uuid)-lg_win($uuid)),2);
												}else{
													echo taupe_win($uuid)+lg_win($uuid);
												}
												$sql1->closeCursor(); ?>
											</p>
										</div>
										<div class="col-lg-6 col-md-12 col-sm-6 col-6">
											<h5>Nombre de victoire</h5>
											<p>
												<?php echo taupe_win($uuid)+lg_win($uuid); ?>
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php }
			$sql->closeCursor(); ?>
		</div>
	</body>
	<?php include('modele/footer.php'); ?>
</html>