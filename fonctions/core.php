<?php Class Core{

	public function Secu($var){
		$var = htmlspecialchars(trim($var));
		return $var;
	}

	public function equipe_taupe_gagnante($id){
		global $db;
		$sql = $db->prepare('SELECT * FROM site_equipe WHERE id_partie = ?');
		$sql->execute(array($id));
		while($equipe = $sql->fetch(PDO::FETCH_OBJ)) { 
			if($equipe->mort == 0){
				return $equipe->nom;
			}
		}
		$sql->closeCursor();

		$sql = $db->prepare('SELECT * FROM site_taupe WHERE id_partie = ?');
		$sql->execute(array($id));
		while($joueur = $sql->fetch(PDO::FETCH_OBJ)) {
			if($joueur->mort == 0){
				if($joueur->supertaupe != 0){
					return 'Supertaupe '.$joueur->supertaupe;
				}else{
					return 'Taupe '.$joueur->taupe;
				}
			}
		}
		return "ERROR_GAME";
	}

	public function equipe_lg_gagnante($id){
		global $db;
		$loupblanc = true;
		$loup = true;
		$couple = true;
		$assassin = true;

		$sql = $db->prepare('SELECT * FROM site_role WHERE id_partie = ?');
		$sql->execute(array($id));
		while($role = $sql->fetch(PDO::FETCH_OBJ)) {
			if($role->nom != "Loup garou blanc" && $role->mort == 0){
				$loupblanc = false;
			}
			if($role->nom != "Loup garou" && $role->nom != "Infect père des loups" && $role->infecte == 0 && $role->mort == 0){
				$loup = false;
			}
			if($role->couple == 0 && $role->mort == 0){
				$couple = false;
			}
			if($role->nom != "Assassin" && $role->nom != "Petit assassin" && $role->mort == 0){
				$assassin = false;
			}
		}
		if($loupblanc){
			return 'Loup garou blanc';
		}else if($loup){
			return 'Loups-garous';
		}else if($couple){
			return 'Couple';
		}else if($assassin){
			return 'Assassins';
		}
		return "Village";
	}

	public function getIp(){

		if(isset($_SERVER['HTTP_CLIENT_IP'])){
			return $_SERVER['HTTP_CLIENT_IP'];
		}elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
		}

	}

	public function getDateComplete($timestamp){
		setlocale(LC_ALL, 'fra');
		setlocale(LC_TIME, 'fra', 'fr_FR');
		ini_set('date.timezone', 'Europe/Berlin');
		return strftime("%A %d %B %Y", $timestamp);
	}

	public function getDate($timestamp){
		setlocale(LC_ALL, 'fra');
		setlocale(LC_TIME, 'fra', 'fr_FR');
		ini_set('date.timezone', 'Europe/Berlin');
		return strftime("%d/%m/%Y", $timestamp);
	}

	public function getTimestamp(){
		ini_set('date.timezone', 'Europe/Berlin');
		$date = date_create();
		return date_timestamp_get($date);
	}

	public function Redirect($var){

		if(headers_sent()){
			echo "<script language='JavaScript'>document.location.href='".$var."'</script>";
			exit();
		}else{
			header("Location:".$var);
			exit();
		}

	}

	public function getPseudo($uuid){
		return file_get_contents('http://api.serveurs-minecraft.com/api_uuid?UUID_Vers_Pseudo&ID='.str_replace("-", "", $uuid));
	}

	public function getUUID($pseudo){
		
	}
}

$core = new Core(); ?>