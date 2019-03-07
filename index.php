<?php $page = "index";
include('modele/header.php'); ?>
			<div class="d-flex justify-content-center flex-wrap categorie-texte">
				<div class="col-lg-6 col-md-6 col-sm-11 col-xs-11">
					<h2>Qui sommes-nous ?</h2>
					<p>Le nom <b>"Latery"</b> vient de notre premier serveur Minecraft (2015) entre amis, depuis ce jour le serveur s'est développé pour donner place aujourd'hui à un serveur riche en événements que ce soit sur Minecraft (Taupe Gun, LG UHC) ou sur d'autres jeux vidéos. Notre communauté est réunie sur un serveur Discord spacieux et organisé pour les événements. Les deux administrateurs, Tino et Darven, s'occupent de gérer le serveur, <b>Tino</b> s'occupe de la gestion, du commerce et du personnel tandis que <b>Darven</b> s'occupe des événements et du développement web et plugins.</p>
				</div>
			</div>
			<div class="d-flex justify-content-center flex-wrap categorie-texte">
				<div class="col-lg-6 col-md-6 col-sm-11 col-xs-11">
					<h2>Dernières parties</h2>
				</div>
			</div>
			<div class="d-flex justify-content-center flex-wrap categorie-partie">
				<div class="col-lg-6 col-md-6 col-sm-11 col-xs-11">
					<div class="container">
						<div class="row">
							<?php $sql = $db->prepare('SELECT * FROM site_partie WHERE type = ? ORDER BY id DESC LIMIT 2');
							$sql->execute(array("taupegun"));
							while($partie = $sql->fetch(PDO::FETCH_OBJ)) { 
								if($partie->type == "taupegun"){ ?>
									<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 partie-list">
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
								<?php } 
							} 
							$sql->closeCursor(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
	<?php include('modele/footer.php'); ?>
</html>
