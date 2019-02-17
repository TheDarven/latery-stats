<?php $page = "taupegun";
include('modele/header.php');

if(isset($_GET['id_partie'])){
	$id = $core->Secu($_GET['id_partie']);
	$sql = $db->prepare('SELECT * FROM site_partie WHERE type = ? AND id = ? AND visible = ?');
	$sql->execute(array("taupegun",$id,1));
	if($sql->rowCount() == 0 || $sql->rowCount() > 1){
		$core->Redirect(WebSite_Url);
	}
	$sql->closeCursor();
}
			if(isset($_GET['id_partie'])){ 
				$sql = $db->prepare('SELECT * FROM site_partie WHERE type = ? AND id = ? AND visible = ?');
				$sql->execute(array("taupegun",$id,1));
				while($partie = $sql->fetch(PDO::FETCH_OBJ)) { ?>
					<div class="d-flex justify-content-center flex-wrap categorie-partie" style="margin-top: -10px;">
						<div class="col-lg-9 col-md-9 col-sm-12">
							<div class="container" style="padding: 0px;">
								<div class="row">
									<div class="col-lg-9 col-md-9 col-sm-12">
										<h4 style="border-bottom: 1px solid #eee; padding-bottom: 9px; margin: 40px 0 20px; font-size: 18px;">Equipes</h4>
										<div class="container">
											<div class="row justify-content-center flex-wrap">
											<?php $sql1 = $db->prepare('SELECT * FROM site_equipe WHERE id_partie = ? ORDER BY mort');
											$sql1->execute(array($partie->id));
											while($equipe = $sql1->fetch(PDO::FETCH_OBJ)) { ?>
													<div class="col-lg-6 col-md-12 col-sm-12 partie-equipe">
														<div class="partie-top color-<?php echo str_replace("§","",$equipe->couleur); ?>">
															<h3><?php echo $equipe->nom; 
																if($equipe->nom == $core->equipe_taupe_gagnante($partie->id)){ ?>
																	<img src="#" data-original="<?= WebSite_Url ?>/assets/images/diamond.png" class="lazy">
																<?php } ?>
															</h3>
														</div>
														<div class="partie-main">
															<div class="container">
																<?php $sql2 = $db->prepare('SELECT * FROM site_taupe WHERE id_team = ? ORDER BY taupe DESC, kills DESC');
																$sql2->execute(array($equipe->id));
																while($taupe = $sql2->fetch(PDO::FETCH_OBJ)) { 
																	$sql3 = $db->prepare('SELECT * FROM site_joueur WHERE uuid = ?');
																	$sql3->execute(array($taupe->uuid));
																	while($joueur = $sql3->fetch(PDO::FETCH_OBJ)) { ?>
																		<div class="row">
																			<a href="<?= WebSite_Url ?>/profile/<?php echo urlencode($joueur->pseudo); ?>">
																				<div class="ligne-joueur" data-pseudo="<?php echo $joueur->pseudo; ?>">
																					<img src="<?= WebSite_Url ?>/assets/images/lazy-head.png" data-original="https://crafatar.com/avatars/<?php echo $joueur->uuid; ?>" style=" 
																						<?php if($taupe->mort == 1){ ?>
																							filter: grayscale(1); 
																						<?php } ?>
																					" class="lazy">
																					<?php if($taupe->taupe != 0) { ?>
																						<span class="joueur-taupe">
																							<?php if($taupe->supertaupe != 0) { ?>
																								<span style="color: #6E0000; margin-right: 5px;">Supertaupe <?php echo $taupe->supertaupe; ?></span>
																							<?php } ?>
																							<span style="color: #AA0000;">Taupe <?php echo $taupe->taupe; ?></span>
																						</span>
																					<?php } ?>
																					<span class="indicateur"><?php echo $joueur->pseudo; ?></span>
																					<span class="badge badge-dark valeur"
																						<?php if($taupe->mort == 0){ ?>
																							style="background-color: #1BA12A;" 
																						<?php } ?>
																					><?php echo $taupe->kills; ?> kills</span>
																				</div> 
																			</a>
																		</div>
																	<?php }
																	$sql3->closeCursor();
																}
																$sql2->closeCursor(); ?>
															</div>
														</div>
													</div>
												<?php } 
												$sql1->closeCursor(); ?>
											</div>
										</div>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-12">
										<h4 style="border-bottom: 1px solid #eee; padding-bottom: 9px; margin: 40px 0 10px; font-size: 18px;">Informations</h4>
										<div class="row">
											<div style="font-size: 16px; padding: 0px; text-align: center;" class="col-lg-6 col-md-12 col-sm-6">
												<h5 style="font-size: 12px; color: #a9a9a9; margin-bottom: 0px; font-weight: bold; ">Date de la partie</h5>
												<p><?php echo date('d/m/y',$partie->debut); ?></p>
											</div>
											<div style="font-size: 16px; padding: 0px; text-align: center;" class="col-lg-6 col-md-12 col-sm-6">
												<h5 style="font-size: 12px; color: #a9a9a9; margin-bottom: 0px; font-weight: bold;">Durée de la partie</h5>
												<p><?php echo round($partie->duree/60); ?>min</p>
											</div>
											<div style="font-size: 16px; padding: 0px; text-align: center;" class="col-lg-6 col-md-12 col-sm-6">
												<h5 style="font-size: 12px; color: #a9a9a9; margin-bottom: 0px; font-weight: bold; ">Equipe gagnante</h5>
												<p><?php echo $core->equipe_taupe_gagnante($partie->id); ?></p>
											</div>
										</div>
										<h4 style="border-bottom: 1px solid #eee; padding-bottom: 9px; margin: 40px 0 10px; font-size: 18px;">Configuration</h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php }
				$sql->closeCursor();
			}else{ ?>
				<div class="d-flex justify-content-center flex-wrap categorie-texte">
					<div class="col-lg-6 col-md-6 col-sm-11">
						<h2>TaupeGun</h2>
						<p>Excogitatum est super his, ut homines quidam ignoti, vilitate ipsa parum cavendi ad colligendos rumores per Antiochiae latera cuncta destinarentur relaturi quae audirent. hi peragranter et dissimulanter honoratorum circulis adsistendo pervadendoque divites domus egentium habitu quicquid noscere poterant vel audire latenter intromissi.</p>
					</div>
				</div>
				<div class="d-flex justify-content-center flex-wrap categorie-partie">
					<div class="col-lg-6 col-md-6 col-sm-11">
						<div class="container">
							<div class="row">
								<?php $sql = $db->prepare('SELECT * FROM site_partie WHERE type = ? ORDER BY id DESC');
								$sql->execute(array("taupegun"));
								while($partie = $sql->fetch(PDO::FETCH_OBJ)) { ?>
									<div class="col-lg-6 col-md-12 col-sm-12 partie-list">
										<a href="<?= WebSite_Url ?>/taupegun/<?php echo $partie->id; ?>" style="width: 100%;">
											<div class="partie-top">
												<h3>Partie du <?php echo date('d/m/y',$partie->debut); ?></h3>
												<h4>Lancée à <?php echo date('H',$partie->debut).'H'.date('i',$partie->debut); ?></h4>
											</div>
											<div class="partie-main">
												<div>
													<span class="indicateur">Durée de la partie</span><span class="badge badge-dark valeur"><?php echo round($partie->duree/60); ?>min</span>
												</div>
												<?php $sql1 = $db->prepare('SELECT * FROM site_taupe WHERE id_partie = ?');
												$sql1->execute(array($partie->id)); ?>
												<div>
													<span class="indicateur">Nombre de participant</span><span class="badge badge-dark valeur"><?php echo $sql1->rowCount(); ?></span>
												</div>
												<?php $sql1->closeCursor();
												$sql1 = $db->prepare('SELECT * FROM site_equipe WHERE id_partie = ?');
												$sql1->execute(array($partie->id)); ?>
												<div>
													<span class="indicateur">Nombre d'équipe</span><span class="badge badge-dark valeur"><?php echo $sql1->rowCount(); ?></span>
												</div>
												<div>
													<span class="indicateur">Equipe gagnante</span><span class="badge badge-dark valeur"><?php echo $core->equipe_taupe_gagnante($partie->id); ?></span>
												</div>
												<?php $sql1->closeCursor(); ?>
											</div>
										</a>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</body>
	<?php include('modele/footer.php'); ?>
</html>