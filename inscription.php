<?php
session_start();
	include 'bdd.php';

	if (isset($_POST['submit'])) {

		$nom = strtoupper(htmlspecialchars($_POST['nom']));
		$prenom = ucfirst(htmlspecialchars($_POST['prenom']));
		$age = htmlspecialchars($_POST['age']);
		$mail = htmlspecialchars($_POST['mail']);
		$mdp = htmlspecialchars($_POST['mdp']);
		$mdp2 = htmlspecialchars($_POST['mdp2']);

		if (strlen($nom) < 30 OR strlen($prenom) < 30) {
			if (strcmp($mdp, $mdp2) == 0) {
					$reqnom = $bdd->prepare("SELECT * FROM utilisateur WHERE nom = :nom AND prenom = :prenom");
	                $reqnom->execute(array('nom'=>$nom,'prenom'=>$prenom));
	                $nomexiste = $reqnom->rowCount();
				if ($nomexiste == 0) {
					$reqmail = $bdd->prepare("SELECT * FROM utilisateur WHERE mail = :mail");
	                $reqmail->execute(array('mail' => $mail));
	                $mailexiste = $reqmail->rowCount();
					if ($mailexiste == 0) {
						$crypted = password_hash($mdp, PASSWORD_DEFAULT);
						$query = $bdd->prepare('INSERT INTO utilisateur(nom, prenom, age, mail, mdp) VALUES(:nom, :prenom, :age, :mail, :mdp)');
						$marqueurs = array('nom'=>$nom,'prenom'=>$prenom,'age'=>$age,'mail'=>$mail,'mdp'=>$crypted);
						$query->execute($marqueurs);
						$query->closeCursor();
						header('Location: connexion.php');
						exit();
					}
					else {
						$erreur = "Cette adresse mail est déjà utilisée.";
					}
				}
				else {
					$erreur = "Cette combinaison nom/prénom est déjà utilisée.";
				}	
			}
			else {
				$erreur = "Les deux mots de passe ne sont pas identiques.";
			}
		}
		else {
			$erreur = "Le nom et le prénom doivent être inférieurs à 30 caractères.";
		}
	}


?>
<!DOCTYPE html>
<html>
	<head>
		<script src="https://kit.fontawesome.com/cbe705ba66.js"></script>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Inscription</title>
	</head>
	<body>
		<?php include 'menu.php'; ?>
		<section>
			<div class="bloc">
				<form method="POST">
					<?php if (isset($erreur)) { echo '<div class="erreur"><i class="fas fa-times"></i> '.$erreur.'</div>'; } ?>
					<p>
						Inscription: 
						<br><br>
						<input type="text" name="nom" placeholder="Nom"  value="<?php if(isset($_POST['nom'])) { echo $_POST['nom']; }?>" autofocus required>
						<br><br>
						<input type="text" name="prenom" placeholder="Prénom" value="<?php if(isset($_POST['prenom'])) { echo $_POST['prenom']; }?>" required>
						<br><br>
						<input type="text" name="age" placeholder="Âge" value="<?php if(isset($_POST['age'])) { echo $_POST['age']; }?>" required>
						<br><br>
						<input type="email" name="mail" placeholder="Adresse mail" value="<?php if(isset($_POST['mail'])) { echo $_POST['mail']; }?>" required>
						<br><br>
						<input type="password" name="mdp" placeholder="Mot de passe" required>
						<br><br>
						<input type="password" name="mdp2" placeholder="Confirmation mot de passe" required>
						<br><br>
						<input type="submit" value="Envoyer" name="submit">
					</p>
					<p id="already">Déjà inscrit? Cliquer <a href="connexion.php">ici</a>.</p>
				</form>
			</div>
		</section>
	</body>
</html>
