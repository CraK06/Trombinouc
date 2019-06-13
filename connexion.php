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
			if (password_verify($mdp, $rep['mdp'])) {
				if ($rep['id'] == 1) {
					$_SESSION['admin'] = TRUE;
					$_SESSION['user'] = TRUE;
					$_SESSION['id'] = $rep['id'];
					$_SESSION['nom'] = $rep['nom'];
					$_SESSION['mail'] = $rep['mail'];
					header('Location: timeline.php');
					exit();
				}
				elseif ($rep['id'] > 1) {
					$_SESSION['user'] = TRUE;
					$_SESSION['id'] = $rep['id'];
					$_SESSION['nom'] = $rep['nom'];
					$_SESSION['prenom'] = $rep['prenom'];
					$_SESSION['mail'] = $rep['mail'];
					header('Location: timeline.php');
					exit();
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
		<title>Connexion</title>
	</head>
	<body>
		<?php include 'menu.php'; ?>
		<section>
			<div class="bloc">
				<form method="POST">
					
					<?php
						if (isset($erreur)) { echo '<div class="erreur"><i class="fas fa-times"></i> '.$erreur.'</div>'; }  
						elseif (isset($_GET['err']) AND $_GET['err'] == 'timeline') { 
							echo '<div class="erreur"><i class="fas fa-times"></i> Veuillez vous connecter pour accéder aux actualités!</div>'; 
						}
						elseif (isset($_GET['msg']) AND $_GET['msg'] == 'deco') { 
							echo '<div class="info"><i class="fas fa-info"></i> Vous avez été déconnecté.</div>'; 
						} 
					?>
					<p>
						Se connecter: 
						<br><br>
						<input type="email" name="mail" placeholder="Adresse mail" value="<?php if(isset($_POST['mail'])) { echo $_POST['mail']; }?>" autofocus>
						<br><br>
						<input type="password" name="mdp" placeholder="Mot de passe">
						<br><br>
						<input type="submit" value="Connexion" name="envoi">
					</p>
					<p id="not_already">Pas encore inscrit? Cliquer <a href="inscription.php">ici</a>.</p>
				</form>
			</div>
		</section>
	</body>
</html>