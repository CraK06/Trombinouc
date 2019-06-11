<?php
session_start();
	include 'bdd.php';
	if (!$_SESSION['admin']) {
		header('Location: timeline.php');
	}
	elseif (!$_SESSION['user']) {
		header('Location: connexion.php?err=amis');
	}

	if (isset($_GET['add']) AND !empty($_GET['add'])) {
		$req = $bdd->prepare('UPDATE utilisateur SET amis = 1 WHERE id = :id');
		$marqueurs = array('id'=>$_GET['add']);
		$req->execute($marqueurs);
	}
	if (isset($_GET['del']) AND !empty($_GET['del'])) {
		$req = $bdd->prepare('UPDATE utilisateur SET amis = 0 WHERE id = :id');
		$marqueurs = array('id'=>$_GET['del']);
		$req->execute($marqueurs);
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
			<?php if (isset($_SESSION['admin'])) {
				$req_add = $bdd->prepare('SELECT * FROM utilisateur WHERE id != 1 AND amis = 0 ORDER BY id DESC');
				$req_add->execute();
				$rep_add = $req_add->fetchAll();

				$nb_add = $req_add->rowCount();
				echo '<div class="amis">
						<h1>Amis :</h1>
					</div>';
				echo '<div class="add_del">
						<h1>Ajouter des amis ('.$nb_add.') :</h1>';
					foreach ($rep_add as $value_add) {
						?>
						<p><?php echo $value_add['nom'].' '.$value_add['prenom'];?> - <a href='amis.php?add=<?php echo $value_add['id'];?>'>Ajouter</a></p>

						<?php
					}
				echo '</div>';


				$req_del = $bdd->prepare('SELECT * FROM utilisateur WHERE id != 1 AND amis = 1 ORDER BY id DESC');
				$req_del->execute();
				$rep_del = $req_del->fetchAll();

				$nb_del = $req_del->rowCount();
				echo '<div class="add_del">
						<h1>Supprimer des amis ('.$nb_del.') : </h1>';
					foreach ($rep_del as $value_del) {
						?>
						<p><?php echo $value_del['nom'].' '.$value_del['prenom'];?> - <a href='amis.php?del=<?php echo $value_del['id'];?>'>Supprimer</a></p>
						<?php
					}
				echo '</div>';

				;
			}	
			?>
		</section>
	</body>
</html>
