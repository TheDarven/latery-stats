	<?php $page = "joueurs";
	include('modele/header.php'); ?>
			<div class="d-flex justify-content-center flex-wrap categorie-texte">
				<div class="col-lg-6 col-md-6 col-sm-11">
					<h2>Les joueurs</h2>
					<p style="text-align: center;">Retrouvez ici les statistiques des joueurs. Pour cela il vous suffit de cliquer sur sa tête.</p>
				</div>		
			</div>
			<div class="d-flex justify-content-center flex-wrap" style="margin-top: 20px;">
				<div class="col-lg-3 col-md-4 col-sm-6 col-10">
					<input id="playerName" placeholder="Pseudo" oninput="changeMemberList()" type="text" style="width: 100%; margin-bottom: 5px; padding: 5px; border: 1px solid #ddd;">
				</div>
			</div>
			<div class="d-flex justify-content-center flex-wrap players-select" style="margin-top: 10px;">
				<div class="col-lg-6 col-md-6 col-sm-11 col-sx-11">
					<div class="container">
						<div class="d-flex justify-content-center flex-wrap" id="playerList" style="max-width: 100%;">
							<?php $sql = $db->query('SELECT * FROM site_joueur');
							while($joueur = $sql->fetch(PDO::FETCH_OBJ)) { ?>
								<a href="<?= WebSite_Url ?>/profile/<?php echo urlencode($joueur->pseudo); ?>">
									<div style="padding: 5px 10px; position: relative;" data-pseudo="<?php echo $joueur->pseudo; ?>">
										<span class="popup"><?php echo $joueur->pseudo; ?></span>
										<img src="<?= WebSite_Url ?>/assets/images/lazy-head.png" data-original="https://crafatar.com/avatars/<?php echo $joueur->uuid; ?>" style="height: 64px;" class="lazy">
									</div> 
								</a>
							<?php }
							$sql->closeCursor(); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="d-flex justify-content-center flex-wrap categorie-texte">
				<div class="col-lg-6 col-md-6 col-sm-11">
					<h2>Classements</h2>
				</div>		
			</div>
			<div class="table-responsive">
				<table id="myTable" class="table table-striped col-lg-6 col-sm-8 col-8" cellspacing="0">
					<thead class="thead-dark">
						<tr class="d-none d-lg-table-row">
							<th data-sort="0">Position</th>
							<th data-sort="0">Tête</th>
							<th onclick="sortTable(2)" data-sort="0" class="sort after" style="min-width: 132px;">Pseudo</th>
							<th onclick="sortTable(3)" data-sort="0" class="sort" style="min-width: 75px;">Kills</th>
							<th onclick="sortTable(4)" data-sort="0" class="sort" style="min-width: 90px;">Morts</th>
							<th onclick="sortTable(5)" data-sort="0" class="sort" style="min-width: 110px;">Victoires</th>
						</tr>
						<tr class="d-lg-none">
							<th>Position</th>
							<th>Tête</th>
							<th>Pseudo</th>
							<th>Kills</th>
							<th>Morts</th>
							<th>Victoires</th>
						</tr>
					</thead>
					<tbody>
						<?php $sql = $db->query('SELECT * FROM site_joueur ORDER BY pseudo');
						$count = 0;
						while($joueur = $sql->fetch(PDO::FETCH_OBJ)){ 
							$count = $count+1; ?>
							<tr <?php if($count > 15) { ?> style="display: none;" <?php } ?> >
								<td class="align-middle"><?php echo $count; ?></td>
								<td><img src="<?= WebSite_Url ?>/assets/images/lazy-head.png" data-original="https://crafatar.com/avatars/<?php echo $joueur->uuid; ?>" class="lazy"></td>
								<td class="align-middle"><?php echo $joueur->pseudo; ?></td>
								<?php $sql1 = $db->prepare('SELECT SUM(kills) as total_kills FROM (SELECT kills,id_partie FROM site_taupe WHERE uuid = ? UNION SELECT kills,id_partie FROM site_role WHERE uuid = ?) A');
								$sql1->execute(array($joueur->uuid,$joueur->uuid));
								$total_kills = $sql1->fetch(PDO::FETCH_OBJ)->total_kills;
								if($total_kills == null){
									$total_kills = 0;
								}
								$sql1->closeCursor(); 

								$sql1 = $db->prepare('SELECT SUM(mort) as total_mort FROM (SELECT mort,id_partie FROM site_taupe WHERE uuid = ? UNION SELECT mort,id_partie FROM site_role WHERE uuid = ?) A');
									$sql1->execute(array($joueur->uuid,$joueur->uuid));											
									$total_morts = $sql1->fetch(PDO::FETCH_OBJ)->total_mort;
									if($total_morts == null){
										$total_morts = 0;
									}
									$sql1->closeCursor(); ?>
								<td class="align-middle"><?php echo $total_kills; ?></td>
								<td class="align-middle"><?php echo $total_morts; ?></td>
								<td class="align-middle"><?php echo taupe_win($joueur->uuid)+lg_win($joueur->uuid); ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<div class="col-lg-6 col-sm-8 col-8" style="margin: auto;">
					<nav>
						<ul class="pagination justify-content-center" id="myPagination">
							<li class="page-item"><span class="page-link">Prev</span></li>
							<li class="page-item active" onClick="changePage(1)"><span class="page-link">1</span></li>
							<li class="page-item"><span class="page-link">Next</span></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	<?php include('modele/footer.php'); ?>
	<script src="<?= WebSite_Url ?>/assets/js/joueurs-recherche.js"></script>
	<script src="<?= WebSite_Url ?>/assets/js/joueurs-tableau.js"></script>
</html>