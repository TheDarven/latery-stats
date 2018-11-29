<?php $page = "lguhc";
include('modele/header.php'); 

if(isset($_GET['id_partie'])){
	$id = $core->Secu($_GET['id_partie']);
	$sql = $db->prepare('SELECT * FROM site_partie WHERE type = ? AND id = ? AND visible = ?');
	$sql->execute(array("lguhc",$id,1));
	if($sql->rowCount() == 0 || $sql->rowCount() > 1){
		$core->Redirect(WebSite_Url);
	}
	$sql->closeCursor();
}
			if(isset($_GET['id_partie'])){ 
				$sql = $db->prepare('SELECT * FROM site_partie WHERE type = ? AND id = ? AND visible = ?');
				$sql->execute(array("lguhc",$id,1));
				while($partie = $sql->fetch(PDO::FETCH_OBJ)) { ?>
					<div class="d-flex justify-content-center flex-wrap categorie-partie" style="margin-top: -10px;">
						<div class="col-lg-9 col-md-9 col-sm-12">
							<div class="container" style="padding: 0px;">
								<div class="row">
									<div class="col-lg-9 col-md-9 col-sm-12">
										<h4 style="border-bottom: 1px solid #eee; padding-bottom: 9px; margin: 40px 0 20px; font-size: 18px;">Couple</h4>
										<div class="container">
											<div class="row justify-content-center flex-wrap">
												
											</div>
										</div>
										<h4 style="border-bottom: 1px solid #eee; padding-bottom: 9px; margin: 40px 0 20px; font-size: 18px;">Assassins</h4>
										<div class="container">
											<div class="row justify-content-center flex-wrap">
												
											</div>
										</div>
										<h4 style="border-bottom: 1px solid #eee; padding-bottom: 9px; margin: 40px 0 20px; font-size: 18px;">Village</h4>
										<div class="container">
											<div class="row justify-content-center flex-wrap">
												
											</div>
										</div>
										<h4 style="border-bottom: 1px solid #eee; padding-bottom: 9px; margin: 40px 0 20px; font-size: 18px;">Loups</h4>
										<div class="container">
											<div class="row justify-content-center flex-wrap">
												
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
												<h5 style="font-size: 12px; color: #a9a9a9; margin-bottom: 0px; font-weight: bold; ">Durée de la partie</h5>
												<p><?php echo round($partie->duree/60); ?>min</p>
											</div>
											<div style="font-size: 16px; padding: 0px; text-align: center;" class="col-lg-6 col-md-12 col-sm-6">
												<h5 style="font-size: 12px; color: #a9a9a9; margin-bottom: 0px; font-weight: bold; ">Equipe gagnante</h5>
												<p><?php echo $core->equipe_lg_gagnante($partie->id); ?></p>
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
						<h2>Loup garou UHC</h2>
						<p>Excogitatum est super his, ut homines quidam ignoti, vilitate ipsa parum cavendi ad colligendos rumores per Antiochiae latera cuncta destinarentur relaturi quae audirent. hi peragranter et dissimulanter honoratorum circulis adsistendo pervadendoque divites domus egentium habitu quicquid noscere poterant vel audire latenter intromissi.</p>
					</div>
				</div>
				<div class="d-flex justify-content-center flex-wrap categorie-partie">
					<div class="col-lg-6 col-md-6 col-sm-11">
						<div class="container">
							<div class="row">
								<?php $sql = $db->prepare('SELECT * FROM site_partie WHERE type = ? ORDER BY id DESC');
								$sql->execute(array("lguhc"));
								while($partie = $sql->fetch(PDO::FETCH_OBJ)) { ?>
									<div class="col-lg-6 col-md-12 col-sm-12 partie-list">
										<a href="<?= WebSite_Url ?>/loupgarou/<?php echo $partie->id; ?>" style="width: 100%;">
											<div class="partie-top">
												<h3>Partie du <?php echo date('d/m/y',$partie->debut); ?></h3>
												<h4>Lancée à <?php echo date('H',$partie->debut).'H'.date('i',$partie->debut); ?></h4>
											</div>
											<div class="partie-main">
												<div>
													<span class="indicateur">Durée de la partie</span><span class="badge badge-dark valeur"><?php echo round($partie->duree/60); ?>min</span>
												</div>
												<?php $sql1 = $db->prepare('SELECT * FROM site_role WHERE id_partie = ?');
												$sql1->execute(array($partie->id)); ?>
												<div>
													<span class="indicateur">Nombre de participant</span><span class="badge badge-dark valeur"><?php echo $sql1->rowCount(); ?></span>
												</div>
												<?php $sql1->closeCursor();
												$sql1 = $db->prepare('SELECT * FROM site_role WHERE id_partie = ?');
												$sql1->execute(array($partie->id)); ?>
												<div>
													<span class="indicateur">Nombre d'équipe</span><span class="badge badge-dark valeur"><?php echo $sql1->rowCount(); ?></span>
												</div>
												<div>
													<span class="indicateur">Equipe gagnante</span><span class="badge badge-dark valeur"><?php echo $core->equipe_lg_gagnante($partie->id); ?></span>
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