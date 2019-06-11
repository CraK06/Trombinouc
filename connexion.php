<?php
	session_start();
	include 'bdd.php';

	if (isset($_POST['envoi'])) {

		$mail = htmlspecialchars($_POST['mail']);
		$mdp = htmlspecialchars($_POST['mdp']);

		$query = $bdd->prepare('SELECT * FROM utilisateur WHERE mail=:mail');
		$marqueurs = array('mail'=>$mail);
		$query->execute($marqueurs);
		$rep = $query->fetch();

		if ($rep == TRUE) {
			if (password_verify($_POST['mdp'], $rep['mdp'])) {
				if ($rep['id'] == 1) {
					$_SESSION['admin'] = TRUE;
					$_SESSION['user'] = TRUE;
					$_SESSION['id'] = $rep['id'];
					$_SESSION['nom'] = $rep['nom'];
					$_SESSION['prenom'] = $rep['prenom'];
					header('Location: timeline.php');
				}
				elseif ($rep['id'] > 1) {
					$_SESSION['user'] = TRUE;
					$_SESSION['id'] = $rep['id'];
					$_SESSION['nom'] = $rep['nom'];
					$_SESSION['prenom'] = $rep['prenom'];
					header('Location: timeline.php');	
				}
			}
			else {
				$erreur = "L'adresse mail ou le mot de passe est incorrect.";
			}
		}
		else {
			$erreur = "L'adresse mail ou le mot de passe est incorrect.";
		}
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<script src="https://kit.fontawesome.com/cbe705ba66.js"></script>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title></title>
	</head>
	<body>
		<?php include 'menu.php'; ?>
		<section>
			<div class="bloc">
				<form method="POST">
					
					<?php
						if (isset($erreur)) { echo '<div class="erreur"><i class="fas fa-times"></i> '.$erreur.'</div>'; }  
						elseif (isset($_GET['err']) AND $_GET['err'] == 'timeline') { echo '<div class="erreur"><i class="fas fa-times"></i> Veuillez vous connecter pour accéder aux actualités!</div>'; }
						elseif (isset($_GET['err']) AND $_GET['err'] == 'amis') { echo '<div class="erreur"><i class="fas fa-times"></i> Veuillez vous connecter pour accéder à vos amis!</div>'; }  
					?>
					<p>
						Se connecter: 
						<br><br>
						<input type="email" name="mail" placeholder="Adresse mail" value="<?php if(isset($_POST['mail'])) { echo $_POST['mail']; }?>">
						<br><br>
						<input type="password" name="mdp" placeholder="Mot de passe">
						<br><br>
						<input type="submit" value="Connexion" name="envoi">
					</p>
					<p id="already">Pas encore inscrit? Cliquer <a href="inscription.php">ici</a>.</p>
				</form>
			</div>
		</section>
	</body>
</html>