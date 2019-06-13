<?php
session_start();
	include 'bdd.php';
	if (!isset($_SESSION['admin']) AND !$_SESSION['admin']) {
		header('Location: index.php');
		exit();
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
		<title>Amis</title>
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
						if ($nb_add == 0) {
							echo '<p>Vous n\'avez aucun ami à ajouter...</p>';
						}
						else {
							foreach ($rep_add as $value_add) {
								?>
								<p><?php echo $value_add['nom'].' '.$value_add['prenom'];?><a href='amis.php?add=<?php echo $value_add['id'];?>'>Ajouter</a></p>

								<?php
						}
					}
				echo '</div>';


				$req_del = $bdd->prepare('SELECT * FROM utilisateur WHERE id != 1 AND amis = 1 ORDER BY id DESC');
				$req_del->execute();
				$rep_del = $req_del->fetchAll();

				$nb_del = $req_del->rowCount();
				echo '<div class="add_del">
						<h1>Supprimer des amis ('.$nb_del.') : </h1>';
						if ($nb_del == 0) {
							echo '<p>Vous n\'avez aucun ami à supprimer...</p>';
						}
						else {
							foreach ($rep_del as $value_del) {
								?>
								<p><?php echo $value_del['nom'].' '.$value_del['prenom'];?><a href='amis.php?del=<?php echo $value_del['id'];?>'>Supprimer</a></p>
								<?php
							}
						}
				echo '</div>';


				$contact = $bdd->prepare('SELECT mail, prenom, nom FROM utilisateur WHERE amis = 1 AND id != 1 ORDER BY id DESC');
				$contact->execute();
				$rep_contact = $contact->fetchAll();
				echo '<div class="form_contact">';
				echo '<h1>Envoyer un mail à un ami :</h1>';
								$nb_contact = $contact->rowCount();
								if ($nb_contact == 0) {
									echo "<p>Veuillez ajouter un ami pour envoyer un mail...</p>";
								}
								else {
									echo '	<form action="contact.php" method="POST">';
									if (isset($_GET['mail']) AND strcmp($_GET['mail'], 'done') == 0) {
										echo "<p class='valide'><i class='fas fa-check'></i> Votre mail a bien été envoyé.<p>";
									}
									echo		'<p><label>Selectionner un ami :</label><br><br>
													<select name="user_contact">';
									foreach ($rep_contact as $value_contact) {
										echo 			'<option value="'.$value_contact['mail'].'">'.$value_contact['nom'].' '.$value_contact['prenom'].'</option>';
									}
									echo			'</select>
												</p>
												<br><label>Écrire votre message :</label><br><br>
												<input type="text" name="objet_contact" placeholder="Objet" autocomplete="off">
												<br><br>
												<textarea name="message_contact" placeholder="Votre message..." autocomplete="off"></textarea>
												<input type="submit" name="submit_contact">
											</form>';
								}
				echo		'</div>';
				
			}	
			?>
		</section>
	</body>
</html>
